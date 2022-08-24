<?php

LibFactory::GetStatic('source');
LibFactory::GetStatic('location');

/**
  * возвращают дополнительную информацию
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:18
 */
class PlaceSimple
{
	/**
	 * Идентификатор места
	 */
	public $ID;
	/**
	 * Тип объекта
	 */
	public $Type;
	/**
	 * Дата создания
	 */
	public $Created;
	/**
	 * время последнего обновления
	 */
	public $LastUpdated;
	/**
	 * Имя
	 */
	public $Name;
	/**
	 * Проверена ли информация
	 */
	public $IsVerified;
	/**
	 * Видимость
	 */
	public $IsVisible;

	public $Country;
	public $Region;
	public $City;
	public $CityText;
	public $CityCode;
	public $CountryCode;

	private $_CityAsText = null;

	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$this->Type = (int) $info['typeid'];
		if ( empty($info['typeid']) || !isset(PlaceSimpleMgr::$types[$this->Type]))
			$this->Type = PlaceSimpleMgr::PT_GENERAL;

		if ( isset($info['placeid']) && Data::Is_Number($info['placeid']) )
			$this->ID = $info['placeid'];

		$this->Created		= $info['created'];
		$this->LastUpdated	= $info['lastupdated'];
		$this->Name			= $info['name'];
		$this->Country		= $info['country'];
		$this->Region		= $info['region'];
		$this->City			= $info['city'];
		$this->CityText		= $info['citytext'];
		$this->CityCode		= $info['citycode'];

		if (strlen($this->CityCode) < 22)
			$this->CityCode .= str_repeat('0', 22-strlen($this->CityCode));

		$this->CountryCode = '';
		if ( $this->CityCode ) {
			$loc_pc = Location::ParseCode($this->CityCode);
			$this->CountryCode = $loc_pc['ContinentCode'].$loc_pc['CountryCode'].'0000000000000000';
		}

		$this->IsVerified	= $info['isverified'] ? true : false;
		$this->IsVisible	= $info['isvisible']  ? true : false;
	}


	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод PlaceSimpleMgr
	 */
	public function Update()
	{
		$info = array(
			'TypeID'	=> $this->Type,
			'Name'		=> $this->Name,
			'Country'	=> $this->Country,
			'Region'	=> $this->Region,
			'City'		=> $this->City,
			'CityText'		=> $this->CityText,
			'CityCode'		=> $this->CityCode,
			'IsVerified'	=> (int) $this->IsVerified,
			'IsVisible'		=> (int) $this->IsVisible,
		);

		if ( $this->ID !== null ) {
			$info['PlaceID'] = $this->ID;
			if ( false != PlaceSimpleMgr::getInstance()->Update($info))
				return true;
		} else if ( false !== ($PlaceID = PlaceSimpleMgr::getInstance()->Add($info))) {

			$this->ID = $PlaceID;
			return $this->ID;
		}

		return false;
	}

	public function AddUser($UserID, $TypeID, array $Info) {

		if ( !Data::Is_Number($UserID) || !$UserID )
			return false;

		if ( !isset(PlaceSimpleMgr::$types[$TypeID]) )
			return false;

		if ( !in_array($TypeID, PlaceSimpleMgr::$types[$this->Type]) )
			return false;
			
		$Info = array_change_key_case($Info, CASE_LOWER);

		$sql = 'SELECT * FROM PlaceSimpleRef WHERE ';
		$sql .= ' `UserID` = '.$UserID.' AND ';
		$sql .= ' `TypeID` = '.$TypeID.' AND ';
		$sql .= ' `PlaceID` = '.$this->ID.'';
		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);

		$found = false;
		if ( $res && $res->num_rows ) {
			$found = true;

			$oInfo = array_change_key_case($res->fetch_assoc(), CASE_LOWER);
			unset($oInfo['yearstart'], $oInfo['yearend']);
			
			$Info = array_merge($oInfo, $Info);
		}

		
		unset($Info['userid'], $Info['typeid'], $Info['placeid']);
		
		if ( $found === false )
			$sql = 'INSERT INTO ';
		else
			$sql = 'UPDATE ';
		
		$sql .= 'PlaceSimpleRef SET ';
		$sql .= ' `UserID` = '.$UserID.', ';
		$sql .= ' `TypeID` = '.$TypeID.', ';
		$sql .= ' `PlaceID` = '.$this->ID.'';

		$year = $month = 0;
		if ( (int) $Info['datestart'] > 0 ) {
			$year = substr($Info['datestart'], 0, 4);
			$month = substr($Info['datestart'], 4);
		}
		
		if ( isset($Info['yearstart']) && $Info['yearstart'] >= 0 )
			$year = (int) $Info['yearstart'];

		if ( $year <= 0 )
			$month = 0;
		else if ( isset($Info['monthstart']) && $Info['monthstart'] >= 0)
			$month = (int) $Info['monthstart'];

		$Info['datestart'] = sprintf("%04d%02d", $year, $month);

		$year = $month = 0;
		if ( (int) $Info['dateend'] > 0 ) {
			$year = substr($Info['dateend'], 0, 4);
			$month = substr($Info['dateend'], 4);
		}

		if ( isset($Info['yearend']) && $Info['yearend'] >= 0 )
			$year = (int) $Info['yearend'];

		if ( $year <= 0 )
			$month = 0;
		else if ( isset($Info['monthend']) && $Info['monthend'] >= 0)
			$month = (int) $Info['monthend'];

		$Info['dateend'] = sprintf("%04d%02d", $year, $month);

		unset($Info['monthstart'], $Info['monthend'], $Info['yearstart'], $Info['yearend']);

		if ( sizeof($Info) ) {
			$fields = array();
			foreach( $Info as $k => $v)
				$fields[] = "`$k` = '".addslashes($v)."'";

			$sql .= ', '.implode(', ', $fields);
		}

		if ( $found === true ) {
			$sql .= ' WHERE `UserID` = '.$UserID.' AND ';
			$sql .= ' `TypeID` = '.$TypeID.' AND ';
			$sql .= ' `PlaceID` = '.$this->ID.'';
		}
		
		if ( PlaceSimpleMgr::getInstance()->_db->query($sql) ) {

			PlaceSimpleMgr::getInstance()->UpdateIndex($TypeID, $this->ID );
			
			if ( $TypeID == PlaceSimpleMgr::PT_HIGHER_EDUCATION && $Info['faculty'] ) {
				
				$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef WHERE ';
				$sql.= ' PlaceID = '.$this->ID;
				$sql.= ' AND Faculty = '.$Info['faculty'];

				if ( false != ($res = PlaceSimpleMgr::getInstance()->_db->query($sql)) ) {
					list($count) = $res->fetch_row();
					
					$sql = 'UPDATE PlaceSimpleFaculty SET ';
					$sql.= ' `Count` = '.$count;
					$sql.= ' WHERE FacultyID = '.$Info['faculty'];

					PlaceSimpleMgr::getInstance()->_db->query($sql);
				}
			}
			
			if ( $TypeID == PlaceSimpleMgr::PT_HIGHER_EDUCATION && $Info['faculty'] && $Info['chair'] ) {
				
				$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef WHERE ';
				$sql.= ' PlaceID = '.$this->ID;
				$sql.= ' AND Faculty = '.$Info['faculty'];
				$sql.= ' AND Chair = '.$Info['chair'];

				if ( false != ($res = PlaceSimpleMgr::getInstance()->_db->query($sql)) ) {
					list($count) = $res->fetch_row();
					
					$sql = 'UPDATE PlaceSimpleKafedra SET ';
					$sql.= ' `Count` = '.$count;
					$sql.= ' WHERE KafedraID = '.$Info['chair'].' AND FacultyID = '.$Info['faculty'];

					PlaceSimpleMgr::getInstance()->_db->query($sql);
				}
			}
			
			return true;
		}

		return false;
	}

	public function RemoveUser($UserID, $TypeID) {

		if ( !Data::Is_Number($UserID) || !$UserID )
			return false;

		if ( !isset(PlaceSimpleMgr::$types[$TypeID]) )
			return false;

		if ( !in_array($TypeID, PlaceSimpleMgr::$types[$this->Type]) )
			return false;

		$sql = 'SELECT faculty, chair FROM PlaceSimpleRef WHERE ';
		$sql .= ' `UserID` = '.$UserID.' AND ';
		$sql .= ' `TypeID` = '.$TypeID.' AND ';
		$sql .= ' `PlaceID` = '.$this->ID.'';
			
		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false ;
			
		$Info = $res->fetch_assoc();
			
		$sql = 'DELETE FROM PlaceSimpleRef WHERE ';
		$sql .= ' `UserID` = '.$UserID.' AND ';
		$sql .= ' `TypeID` = '.$TypeID.' AND ';
		$sql .= ' `PlaceID` = '.$this->ID.'';

		if ( PlaceSimpleMgr::getInstance()->_db->query($sql) ) {
			PlaceSimpleMgr::getInstance()->UpdateIndex($TypeID, $this->ID);
			
			if ( $TypeID == PlaceSimpleMgr::PT_HIGHER_EDUCATION && $Info['faculty'] ) {
				
				$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef WHERE ';
				$sql.= ' PlaceID = '.$this->ID;
				$sql.= ' AND Faculty = '.$Info['faculty'];

				if ( false != ($res = PlaceSimpleMgr::getInstance()->_db->query($sql)) ) {
					list($count) = $res->fetch_row();
					
					$sql = 'UPDATE PlaceSimpleFaculty SET ';
					$sql.= ' `Count` = '.$count;
					$sql.= ' WHERE FacultyID = '.$Info['faculty'];

					PlaceSimpleMgr::getInstance()->_db->query($sql);
				}
			}
			
			if ( $TypeID == PlaceSimpleMgr::PT_HIGHER_EDUCATION && $Info['faculty'] && $Info['chair'] ) {
				
				$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef WHERE ';
				$sql.= ' PlaceID = '.$this->ID;
				$sql.= ' AND Faculty = '.$Info['faculty'];
				$sql.= ' AND Chair = '.$Info['chair'];

				if ( false != ($res = PlaceSimpleMgr::getInstance()->_db->query($sql)) ) {
					list($count) = $res->fetch_row();
					
					$sql = 'UPDATE PlaceSimpleKafedra SET ';
					$sql.= ' `Count` = '.$count;
					$sql.= ' WHERE KafedraID = '.$Info['chair'].' AND FacultyID = '.$Info['faculty'];

					PlaceSimpleMgr::getInstance()->_db->query($sql);
				}
			}
			
			return true;
		}
		return false;
	}

	// Создание специализации для среднего образования
	public function CreateSpecialize(array $info) {
		if ( empty($info) )
			return false;

		$info = array_change_key_case($info, CASE_LOWER);
		if ( empty($info['name']) )
			return false;

		$chair = $this->GetSpecializeByName($info['name']);

		if ( $chair !== null )
			return $chair['ChairID'];

		$sql = 'INSERT INTO PlaceSimpleChair SET ';
		$sql.= ' Created = NOW()';

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!PlaceSimpleMgr::getInstance()->_db->query($sql))
			return false;

		return PlaceSimpleMgr::getInstance()->_db->insert_id;
	}

	// Получить список специализаций для среднего образования
	public function GetSpecializeList($name = '', $IsVisible = 1, $IsVerified = -1)
	{
		$list = array();

		$sql = 'SELECT * FROM PlaceSimpleChair ';
		if ( trim($name) != '')
			$sql .= " WHERE Name LIKE '%".addslashes($name)."%'";

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, ChairID ASC LIMIT 1';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}

	// Получение специализации по ID, для среднего образования
	public function GetSpecializeByName($SpecName, $IsVisible = 1, $IsVerified = -1) {
		if ( empty($SpecName) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleChair WHERE Name = \''.addslashes($SpecName).'\'';

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, ChairID ASC LIMIT 1';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ( !$res->num_rows )
			return null;

		$row = $res->fetch_assoc();
		return $row;
	}

	// Получение специализации по ID, для среднего образования
	public function GetSpecializeByID($SpecID, $IsVisible = 1, $IsVerified = -1) {
		if ( !Data::Is_Number($SpecID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleChair WHERE ChairID = '.$SpecID;

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ( !$res->num_rows )
			return null;

		$row = $res->fetch_assoc();
		return $row;
	}

	// Создание факультета для высшего образования
	public function CreateFaculty(array $info)
	{
		if ( empty($info) )
			return false;

		$info = array_change_key_case($info, CASE_LOWER);
		if ( empty($info['name']) )
			return false;

		$faculty = $this->GetFacultyByName($info['name']);

		if ( $faculty !== null )
			return $faculty['FacultyID'];

		$sql = 'INSERT INTO PlaceSimpleFaculty SET ';
		$sql.= ' PlaceID = '.$this->ID;
		$sql.= ', Created = NOW()';

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!PlaceSimpleMgr::getInstance()->_db->query($sql))
			return false;

		return PlaceSimpleMgr::getInstance()->_db->insert_id;
	}

	// Получения списка факультетов для высшего образования
	public function GetFacultyList($name = '', $IsVisible = 1, $IsVerified = -1)
	{
		$list = array();

		$sql = 'SELECT * FROM PlaceSimpleFaculty WHERE PlaceID = '.$this->ID;
		if ( trim($name) != '')
			$sql .= " AND Name LIKE '%".addslashes($name)."%'";

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, FacultyID ASC LIMIT 1';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}

	// Получение факультета по имени, для высшего образования
	public function GetFacultyByName($FacultyName, $IsVisible = 1, $IsVerified = -1) {

		if ( empty($FacultyName) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleFaculty WHERE ';

		if ( $this->ID )
			$sql.= ' PlaceID = \''.$this->ID.'\' AND ';

		$sql.= ' Name = \''.$FacultyName.'\'';
		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, FacultyID ASC LIMIT 1';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	// Получение факультета по ID, для высшего образования
	public function GetFacultyByID($FacultyID, $IsVisible = 1, $IsVerified = -1) {

		if ( !Data::Is_Number($FacultyID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleFaculty WHERE FacultyID = '.$FacultyID;
		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	// Создание кафедры, для высшего образования
	public function CreateChair($FacultyID, array $info)
	{
		if ( !Data::Is_Number($FacultyID) )
			return false;

		if ( empty($info) )
			return false;

		$info = array_change_key_case($info, CASE_LOWER);
		if ( empty($info['name']) )
			return false;

		if ( $this->GetFacultyByID($FacultyID, -1, -1) === null )
			return false;

		$chair = $this->GetChairByName($info['name'], $FacultyID);

		if ( $chair !== null )
			return $chair['KafedraID'];

		$sql = 'INSERT IGNORE INTO PlaceSimpleKafedra SET ';
		$sql.= ' FacultyID = '.$FacultyID;
		$sql.= ', Created = NOW()';

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!PlaceSimpleMgr::getInstance()->_db->query($sql))
			return false;

		return PlaceSimpleMgr::getInstance()->_db->insert_id;
	}

	// Получение списка кафедр для высшего образования
	public function GetChairList($FacultyID, $name = '', $IsVisible = 1, $IsVerified = -1)
	{
		$list = array();
		if ( !Data::Is_Number($FacultyID) )
			return null;

		if ( $this->GetFacultyByID($FacultyID, $IsVisible, $IsVerified) === null )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleKafedra WHERE FacultyID = '.$FacultyID;
		if ( trim($name) != '')
			$sql .= " AND Name LIKE '%".addslashes($name)."%'";

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, KafedraID ASC';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}

	// Получение кафедры по ID, для высшего образования
	public function GetChairByID($ChairID, $FacultyID, $IsVisible = 1, $IsVerified = -1)
	{
		if ( !Data::Is_Number($ChairID) || !Data::Is_Number($FacultyID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleKafedra WHERE KafedraID = '.$ChairID;
		$sql.= ' AND FacultyID = '.$FacultyID;
		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	// Получение кафедры по имени, для высшего образования
	public function GetChairByName($ChairName, $FacultyID, $IsVisible = 1, $IsVerified = -1)
	{
		if ( empty($ChairName) || !Data::Is_Number($FacultyID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleKafedra WHERE ';
		$sql.= ' FacultyID = '.$FacultyID;
		$sql.= ' AND Name = \''.addslashes($ChairName).'\'';

		if ( $IsVisible != -1 )
			$sql.= ' AND IsVisible = '.( $IsVisible ? 1 : 0 );
		if ( $IsVerified != -1 )
			$sql .= ' AND IsVerified = '.( $IsVerified ? 1 : 0 );
		$sql .= ' ORDER by Name ASC, KafedraID ASC LIMIT 1';

		$res = PlaceSimpleMgr::getInstance()->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	function __get($name) {
		$name = strtolower($name);

		switch ($name) {
			case 'cityastext':
				if ( $this->_CityAsText !== null )
					return $this->_CityAsText;

				if ( !empty($this->City) ) {
					$Loc = Source::GetData('db:location',
						array('type' => 'default_location', 'city' => $this->City));

					if ( is_array($Loc) && sizeof($Loc) )
						return $this->_CityAsText = $Loc['Name'];

				}

				$this->_CityAsText = $this->CityText;
				return $this->CityText;
			break;
		}
		return null;
	}

	function __destruct()
	{

	}
}
?>