<?

class Tag {

	private $_mgr = null;
	private $_info = array();

	/**
	 * Конструктор
	 *
	 * @param array info - массив, по которому создается объект
	 * @param object mgr - объект TagsMgr
	 */
	function __construct(array $info, $mgr) {

		$info = array_change_key_case($info, CASE_LOWER);
		
		$this->_mgr = $mgr;
		$this->_info = $info;
	}

	/**
	 * Создать для текущего тега связь
	 *
	 * @param int uniqueid - идентификатор материала к которому привязывается тег
	 * @param int sectionid - раздел, куда привязывается тег
	 * @param int active - активность тега
	 * @param int ts - timestamp создания тега (если не передать, то будет текущее время)
	 * @return bool
	 */
	public function createRef($uniqueid, $sectionid, $active = 0, $ts = null) {
		if ($this->_info['tagid'] <= 0)
			return false;

		if (!is_numeric($uniqueid) || $uniqueid <= 0)
			return false;

		if (!is_numeric($sectionid) || $sectionid <= 0)
			return false;

		if ($ts === null)
			$ts = time();

		$section = STreeMgr::GetNodeByID($sectionid);

		$sql = 'INSERT IGNORE INTO '.$this->_mgr->_tables['ref'].' SET ';
		$sql.= ' `TagID` = '.intval($this->_info['tagid']);
		$sql.= ' ,`UniqueID` = '.intval($uniqueid);
		$sql.= ' ,`RegionID` = '.intval($section->Regions);
		$sql.= ' ,`SiteID` = '.intval($section->ParentID);
		$sql.= ' ,`SectionID` = '.intval($section->ID);
		$sql.= ' ,`Module` = \''.addslashes($section->Module).'\'';
		$sql.= ' ,`Date` = \''.date('Y-m-d H:i:s', $ts).'\'';
		$sql.= ' ,`isActive` = \''.($active ? 1 : 0).'\'';

		if (false != ($res = $this->_mgr->_db->query($sql))) {
			$this->_mgr->log(880, $this->_mgr->_db->insert_id, array(
				'UniqueID' => intval($uniqueid),
				'Module' => addslashes($section->Module),
			));
			return true;
		}

		return false;
	}

	/**
	 * Удалить тег
	 *
	 * @return bool
	 */
	 public function Remove() {
		if ($this->_info['tagid'] <= 0)
			return false;

		return $this->_mgr->removeTagByID($this->_info['tagid']);
	}

	/**
	 * Обновить тег. 
	 * Обновляется по полям объекта
	 *
	 * @return bool
	 */
	public function Update() {
		if (trim($this->_info['name']) === '')
			return false;

		$info = array(
			'TagID'	=> (!isset($this->_info['tagid']) ? null : $this->_info['tagid']),
			'Name'	=> $this->_info['name'],
		);
		
		$result = $this->_mgr->updateTag($info);
		if (!is_integer($result))
			return $result;

		$this->_info['tagid'] = $result;
		return true;
	}
	
	function __get($name) {
		$name = strtolower($name);

		if (isset($this->_info[$name]))
			return $this->_info[$name];

		return null;
	}

	function __set($name, $value) {
		$name = strtolower($name);
		switch($name) {
			case 'name':
				$this->_info[$name] = $value;
			break;
		}
	}
}