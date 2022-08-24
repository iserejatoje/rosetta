<?

require_once $CONFIG['engine_path'].'include/advertise/advmgr.php';

static $error_code = 0;
define('ERR_L_LOSTFOUND_MASK', 0x00610000);

define('ERR_L_LOSTFOUND_SECTION', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_SECTION] = 'Раздел не указан или не сответствует установленному формату!';
define('ERR_L_LOSTFOUND_PHONE', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_PHONE] = 'Телефон не указан или не сответствует установленному формату!';
define('ERR_L_LOSTFOUND_NUMBER', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_NUMBER] = 'Поле "Номер" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_ONNAME', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_ONNAME] = 'Поле "На имя" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_BRAND', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_BRAND] = 'Поле "Бренд" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_MODEL', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_MODEL] = 'Поле "Модель" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_OTHER', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_OTHER] = 'Поле "Другое" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_ITEM', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_ITEM] = 'Поле "Название" обязательно для заполнения!';
define('ERR_L_LOSTFOUND_COLOR', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_COLOR] = 'Цвет не указан или не сответствует установленному формату!';
define('ERR_L_LOSTFOUND_EMAIL', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_EMAIL] = 'Е-майл не сответствует установленному формату!';
define('ERR_L_LOSTFOUND_CONTACTS', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_CONTACTS] = 'Укажите контактные данные!';
define('ERR_L_LOSTFOUND_DATE', ERR_L_LOSTFOUND_MASK | $error_code++);
	UserError::$Errors[ERR_L_LOSTFOUND_DATE] = 'Укажите дату!';

class AdvSheme_lostfound extends AdvShemeBase
{
  public $RubricID = 0;

	protected $_cache = null;
	protected $_stats = array();
	protected $_last = array();

  public function __construct($path, $prefix = '')
  {
    // база данных
	$this->sheme['db'] = 'adv_lostfound';
    // скалярные поля
	$this->sheme['scalar_fields']['AdvID']			= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['RubricID']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Section']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Area']			= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['Item']			= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['Detail']			= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['Views']			= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Date']			= array( 'type' => 'date' );
	$this->sheme['scalar_fields']['DateCreate']		= array( 'type' => 'date' );
	$this->sheme['scalar_fields']['DateUpdate']		= array( 'type' => 'date' );
	$this->sheme['scalar_fields']['DateValid']		= array( 'type' => 'date' );
	$this->sheme['scalar_fields']['UserID']			= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Contacts']		= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['Phone']			= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['Email']			= array( 'type' => 'char' );
	$this->sheme['scalar_fields']['ReceiveIM']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['IsNew']			= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Moderate']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Remoderate']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['opt_InState']	= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['Visible']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['opt_Photo']		= array( 'type' => 'int' );
	$this->sheme['scalar_fields']['opt_Title']		= array( 'type' => 'char' );

	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge','PhotoSmall') );

	// ключевое поле
	$this->sheme['key'] = 'AdvID';

	parent::__construct($path, $prefix);

	// кэш
	LibFactory::GetStatic('cache');
    $this->_cache = new Cache();
    $this->_cache->Init('memcache', 'lostfound');
  }

	public function GetStatistic($Section, $UserID = 0, $inState = 1, $visible = 1)
	{
		$inState = intval($inState);
		$Section = intval($Section);

		if ( !isset( $this->_stats[$UserID][$this->RubricID][$inState][$Section] ) )
		{
			$cacheid = 'stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $Section;

			$this->_stats[$UserID][$this->RubricID][$inState][$Section] = $this->_cache->Get($cacheid);

			if ( $this->_stats[$UserID][$this->RubricID][$inState][$Section] === false || $_GET['nocache'] > 12 )
			{
				$sql = "SELECT COUNT(*) FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
				if ( $inState == 1 )
					$sql.= " WHERE `opt_InState` = 0 AND ";
				else
					$sql.= " WHERE ";
				$sql.= "`RubricID` = ". $this->RubricID;
				if ( $visible == 1 )
					$sql.= " AND `Visible` = 1";
				if ( $UserID > 0 )
					$sql.= " AND `UserID` = ". $UserID;
				if ($Section == 0 || $Section == 1)
				{
					$sql.= " AND `Section` = ".$Section;
				}
				$res = $this->db->query($sql);

				if ( $res === false )
					return false;

				list($this->_stats[$UserID][$this->RubricID][$inState][$Section]) = $res->fetch_row();

				$this->_cache->Set($cacheid, $this->_stats[$UserID][$this->RubricID][$inState][$Section], 60);
			}
		}
		return $this->_stats[$UserID][$this->RubricID][$inState][$Section];
	}
	public function GetLast($Section, $UserID = 0, $inState = 1, $visible = 1)
	{
		$cacheid = 'last|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $Section;
		$this->_last[$UserID][$this->RubricID][$inState][$Section] = $this->_cache->Get($cacheid);

		if ( $this->_last[$UserID][$this->RubricID][$inState][$Section] === false || $_GET['nocache'] > 12 )
		{
			$sql = "SELECT * FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
			$sql.= " WHERE 1";
			if ( $inState == 1 )
				$sql.= " AND `opt_InState` = 0";
			$sql.= " AND `RubricID` = '".$this->RubricID."'";
			if ( $visible == 1 )
				$sql.= " AND `Visible` = 1";
			if ( $UserID > 0 )
				$sql.= " AND `UserID` = ". $UserID;

			if ($Section == 0 || $Section == 1)
				$sql.= " AND `Section` = ".$Section;

			$sql.= " AND `IsNew` IN (0,1)";
			$sql.= " ORDER BY `DateUpdate` DESC LIMIT 0,5";
			$res = $this->db->query($sql);

			if ( $res === false )
				return false;

			while (($row = $res->fetch_assoc()) != false)
				$rows[$row['AdvID']] = $row;

			$this->_last[$UserID][$this->RubricID][$inState][$Section] = $rows;
			$this->_cache->Set($cacheid, $this->_last[$UserID][$this->RubricID][$inState][$Section], 300);
		}
		return $this->_last[$UserID][$this->RubricID][$inState][$Section];
	}

	public function UpdateState()
	{
		LibFactory::GetStatic('datetime_my');
		$now = DateTime_my::NowOffset();

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != '0'";
		$where.= " AND `DateCreate` < '". $now ."'";
		$where.= " AND `DateValid` > '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = '0'";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != '1'";
		$where.= " AND `DateCreate` < '". $now ."'";
		$where.= " AND `DateValid` < '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = '1'";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != '2'";
		$where.= " AND `DateCreate` > '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = '2'";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		return true;
	}

	public function UserActionProlongAndUpdate( $AdvIds, $Period = 1, $limit = null )
	{
		global $OBJECTS;

		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;

		switch ($Period)
		{
			case 2:
				$add = "2 WEEK";
				break;
			case 3:
				$add = "1 MONTH";
				break;
			case 4:
				$add = "2 MONTH";
				break;
			default:
				$add = "1 WEEK";
		}

    LibFactory::GetStatic('datetime_my');

		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateUpdate` = NOW()";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `DateUpdate` < '". Datetime_my::DateOffset()."'";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);

		$this->db->query($sql);
		//error_log($sql);

		$updated = intval($this->db->affected_rows);

		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateValid` = NOW() + INTERVAL ". $add .", ";
		$sql.= " `opt_InState` = 0";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);

		$this->db->query($sql);

		$prolonged = intval($this->db->affected_rows);
		foreach ($AdvIds as $id)
			$OBJECTS['log']->Log(660, $id, array());

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return array($prolonged,$updated);
	}

	public function UserActionDelete( $AdvIds = array() )
	{
		global $OBJECTS;
		
		foreach ( $AdvIds as $id )
		{
			$this->RemoveAdv($id, $OBJECTS['user']->ID);
			$OBJECTS['log']->Log(658, $id, array());
		}
		AdvCache::getInstance()->Remove($this, $AdvIds);
	}

	public function UserActionReset( $AdvIds = array() )
	{
		foreach ( $AdvIds as $id )
		{
			AdvStat::getInstance()->Reset($this, $id);
		}
	}
	
	public function AdminActionDelete ( $AdvIds = array() )
	{
		global $OBJECTS;
		foreach ( $AdvIds as $id )
		{
			$this->RemoveAdv($id);
			$OBJECTS['log']->Log(659, $id, array());
		}
		AdvCache::getInstance()->Remove($this, $AdvIds);
	}

	public function ClearCache($UserID = 0)
	{
    $this->_cache->Remove('last|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $Section);
    $this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $Section);
	}
}

class AdvIterator_lostfound extends AdvIteratorBase
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'Visible', 'IsNew', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Area', 'Section', 'Subrubric', 'DateValid', 'Color', 'Breed', 'Number', 'OnName', 'Brand',
		'Size', 'Model', 'Item', 'Detail', 'Contacts', 'Phone', 'Email', 'Moderate', 'opt_Photo'
	);

	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_lostfound extends AdvBase
{
	public function IsValid()
	{
		global $OBJECTS;

		$is_valid = true;

		if ( empty($this->data['Phone']) || !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$this->data['Phone'].',') )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_PHONE);
			$is_valid = false;
		}
		if ( !empty($this->data['Email']) && !preg_match('/[0-9a-z_]+@[0-9a-z_^.]+.[a-z]{2,3}/i',$this->data['Email'].',') )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_EMAIL);
			$is_valid = false;
		}

		if ( empty($this->data['Contacts']))
		{
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_CONTACTS);
			$is_valid = false;
		}
		if ( !isset($this->data['Date']) || empty($this->data['Date']) || $this->data['Date'] == 0 )
		{
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_DATE);
			$is_valid = false;
		}
		if ($this->data['Section'] !== 0 && $this->data['Section'] !== 1){
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_SECTION);
			$is_valid = false;
		}
		return ( parent::IsValid() && $is_valid );
	}

	public function Store()
	{
		$this->data['RubricID'] = $this->sheme->RubricID;
		parent::Store();
	}

	public function Remove()
	{
		if ( array_key_exists('Photo', $this->sheme->sheme['vector_fields'] ) )
		{
			$this->VectorLoad('Photo');

			if ( is_array($this->data['Photo']) )
			{
				LibFactory::GetStatic('filestore');
				foreach ( $this->data['Photo'] as $photo )
				{
					if( ($img_obj = FileStore::ObjectFromString($photo['PhotoLarge'])) !== false )
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['large']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e )
						{
							continue;
						}
					}
					else
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['large']['path'] . FileStore::GetPath_NEW($photo['PhotoLarge']));
						}
						catch ( MyException $e ) {}
					}

					if( ($img_obj = FileStore::ObjectFromString($photo['PhotoSmall'])) !== false )
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['small']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e )
						{
							continue;
						}
					}
					else
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['small']['path'] . FileStore::GetPath_NEW($photo['PhotoSmall']));
						}
						catch ( MyException $e ) {}
					}
				}
			}
		}
	}
}
?>
