<?
class JobStats
{
	protected $_dbname = "g_job";
	protected $_db = null;
	protected $_redis = null;

	static function &getInstance()
	{
		static $instance;
		if ( !isset($instance))
		{
			$cl = __CLASS__;
			$instance = new $cl();
		}
		return $instance;
	}

	public function __construct()
	{
		$this->_redis = LibFactory::GetInstance('redis');
		try
		{
			$this->_redis->Init('advertise');
		}
		catch ( MyException $e ) {}
	}

	/** @fn GetStatistic($prefix, $type, $rubric = null)
	 *	@brief Получение статистики в разделе
	 *  @param prefix - префикс таблицы, ну и базы
	 *	@param deal - раздел
	 *  @param rubric - рубрика
	 *  @return mixed - количество объявлений, либо нул
	 */
	public function GetStatistic($prefix, $type, $rubric = null, $nocache = false)
	{
		// Проверка входных данных, от дурака
		if (!is_numeric($prefix) || $type == null)
			return false;

		$key = "job:".$prefix.":".$type;

		if (is_numeric($rubric))
			$key .= ":".$rubric;

		$val = $this->_redis->Get($key);
		$count = null;
		if ($val !== null)
			$count = unserialize($val);

		if ($count !== false && $nocache === false)
			return $count;

		$this->_db = DBFactory::getInstance($this->_dbname);

		if ($rubric === null)
		{
			$sql = "SELECT SUM(`All`) as `All`, SUM(`Count`) as `Count`, SUM(`Delta`) as `Delta`, SUM(`WeeklyCount`) as `WeeklyCount` FROM `statistic`";
			$sql.= " WHERE `Prefix` = '".$prefix."' AND `Type` = '".$type."'";
			$res = $this->_db->query($sql);
			if ( $res === false)
				return false;
		}
		else
		{
			$sql = "SELECT `All`, `Count`, `Delta`, `WeeklyCount` FROM `statistic`";
			$sql.= " WHERE `Prefix` = '".$prefix."' AND `Type` = '".$type."' AND `Rubric` = '".$rubric."'";
			$res = $this->_db->query($sql);
			if ( $res === false)
				return false;
		}
		$row = $res->fetch_assoc();
		$this->_redis->Set( $key, serialize($row) );
		return $row;
	}
	public function UpdateStatistic($prefix, $type = null)
	{
	}
}
?>