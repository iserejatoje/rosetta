<?php

global $CONFIG;
require_once ($CONFIG['engine_path'].'include/place/placesimple.php');
require_once ($CONFIG['engine_path'].'configure/lib/place/error.php');

/**
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:17
 */
class PlaceSimpleMgr
{

	/**
	 * Кэш мест
	 */
	private $_places = array();

	const PT_GENERAL = 1;
	const PT_HIGHER_EDUCATION = 2;
	const PT_SECONDARY_EDUCATION = 3;
	const PT_SECONDARY_SPECIAL_EDUCATION = 5;
	const PT_OTHER = 4;
	const PT_ALL = 0;

	static public $types = array(
		PlaceSimpleMgr::PT_GENERAL => array(
			PlaceSimpleMgr::PT_GENERAL, PlaceSimpleMgr::PT_OTHER, PlaceSimpleMgr::PT_HIGHER_EDUCATION, PlaceSimpleMgr::PT_SECONDARY_EDUCATION, PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION
		),
		PlaceSimpleMgr::PT_HIGHER_EDUCATION => array(
			PlaceSimpleMgr::PT_GENERAL, PlaceSimpleMgr::PT_OTHER, PlaceSimpleMgr::PT_HIGHER_EDUCATION
		),
		PlaceSimpleMgr::PT_SECONDARY_EDUCATION => array(
			PlaceSimpleMgr::PT_GENERAL, PlaceSimpleMgr::PT_OTHER, PlaceSimpleMgr::PT_SECONDARY_EDUCATION
		),
		PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION => array(
			PlaceSimpleMgr::PT_GENERAL, PlaceSimpleMgr::PT_OTHER, PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION
		),
		PlaceSimpleMgr::PT_OTHER => array(
			PlaceSimpleMgr::PT_GENERAL, PlaceSimpleMgr::PT_HIGHER_EDUCATION, PlaceSimpleMgr::PT_SECONDARY_EDUCATION, PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION
		),
	);

	static public $types_range = array(
		PlaceSimpleMgr::PT_GENERAL => array(1,2,3,5),
		PlaceSimpleMgr::PT_OTHER => array(1,2,3,5),
		PlaceSimpleMgr::PT_HIGHER_EDUCATION => array(2),
		PlaceSimpleMgr::PT_SECONDARY_EDUCATION => array(3),
		PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION => array(5),
	);

	static public $status_arr = array(
		1 => 'Абитуриент',
		2 => 'Студент (специалист)',
		3 => 'Студент (бакалавр)',
		4 => 'Студент (магистр)',
		5 => 'Выпускник (специалист)',
		6 => 'Выпускник (бакалавр)',
		7 => 'Выпускник (магистр)',
		8 => 'Аспирант',
		9 => 'Кандидат наук',
		10 => 'Доктор наук',
	);

	static public $course_form_arr = array(
		1 => 'Дневная',
		2 => 'Вечерняя',
		3 => 'Заочная',
		4 => 'Очно-заочная'
	);

	private $config	= array(
		'db' => array('name' => 'places'),
	);

	public $_db;

	public function __construct($caching = true)
	{
		global $OBJECTS;

		LibFactory::GetStatic('location');
		LibFactory::GetStatic('data');

		$this->_db = DBFactory::GetInstance($this->config['db']['name']);

		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);
	}

	static function &getClassArr() {

		$let = array();
		$let2 = array();
		$let3 = array();

		for ($ch = ord('а'); $ch <= ord('я'); $ch++)
			if ( $ch != 250 && $ch != 252 && $ch != 233 )
				$let[] = chr($ch);

		foreach( $let as $ch ) {
			$let2[] = $ch.'2';
			$let3[] = $ch.'3';
		}

		$res = array_merge(range(1,9), $let, $let2, $let3);
		$res = array_combine (range(1, sizeof($res)), $res);
		return $res;
	}

	static function &getInstance () {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }

	/**
	 * Получить место по идентификатору
	 *
	 * @param PlaceID
	 * @param IsVisible
	 * @param IsVerified
	 */
	public function GetPlace($PlaceID, $IsVisible = null, $IsVerified = null)
	{
		if ( !Data::Is_Number($PlaceID) )
			return null;

		if ( isset($this->_places[$PlaceID]) )
			return $this->_places[$PlaceID];

		$sql = 'SELECT * FROM PlaceSimple WHERE PlaceID = '.$PlaceID;

		if ( is_bool($IsVisible) )
			$sql .= ' AND IsVisible = '.(int) $IsVisible;

		if ( is_bool($IsVerified) )
			$sql .= ' AND IsVerified = '.(int) $IsVerified;

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {
			$info = $res->fetch_assoc();
			$this->_places[$PlaceID] = new PlaceSimple($info);

			return $this->_places[$PlaceID];
		}


		return null;
	}

	/*
	public function GetSpec($name = '')
	{
		$list = array();

		$sql = 'SELECT * FROM PlaceSimpleChair ';
		if ($name != '')
			$sql .= " WHERE Name LIKE '%".$name."%'";

		$sql .= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		//echo ($sql);

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}
	public function GetSpecByID($ChairID)
	{
		if ( !Data::Is_Number($ChairID) || $ChairID < 1 )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleChair WHERE ChairID = '.$ChairID;
		$sql.= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}
	public function CreateSpec($info)
	{
		$sql = 'INSERT INTO PlaceSimpleChair SET ';
		$sql.= ' Created = NOW()';

		if (!is_array($info) || sizeof($info) < 1)
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!$this->_db->query($sql))
			return false;

		return $this->_db->insert_id;
	}
	public function GetFaculty($PlaceID, $name = '')
	{
		$list = array();
		if ( !Data::Is_Number($PlaceID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleFaculty WHERE PlaceID = '.$PlaceID;
		if ($name != '')
			$sql .= " AND Name LIKE '%".$name."%'";

		$sql .= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		//echo ($sql);

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}

	public function GetFacultyByID($FacultyID)
	{
		if ( !Data::Is_Number($FacultyID) || $FacultyID < 1 )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleFaculty WHERE FacultyID = '.$FacultyID;
		$sql.= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	public function CreateFaculty($PlaceID, $info)
	{
		if ( !Data::Is_Number($PlaceID) || $PlaceID < 1 )
			return false;

		$sql = 'INSERT INTO PlaceSimpleFaculty SET ';
		$sql.= ' PlaceID = '.$PlaceID;
		$sql.= ', Created = NOW()';

		if (!is_array($info) || sizeof($info) < 1)
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!$this->_db->query($sql))
			return false;

		return $this->_db->insert_id;
	}

	public function GetСhair($FacultyID, $name = '')
	{
		$list = array();
		if ( !Data::Is_Number($FacultyID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleKafedra WHERE FacultyID = '.$FacultyID;
		if ($name != '')
			$sql .= " AND Name LIKE '%".$name."%'";

		$sql .= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		//echo ($sql);

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		while ($row = $res->fetch_assoc())
			$list[] = $row;

		return $list;
	}

	public function GetСhairByID($KafedraID)
	{
		if ( !Data::Is_Number($KafedraID) || $KafedraID < 1 )
			return null;

		$sql = 'SELECT * FROM PlaceSimpleKafedra WHERE KafedraID = '.$KafedraID;
		$sql.= ' AND IsVisible = 1';
		//$sql .= ' AND IsVerified = 1';

		$res = $this->_db->query($sql);
		if ($res->num_rows == 0)
			return null;

		$row = $res->fetch_assoc();

		return $row;
	}

	public function CreateСhair($FacultyID, $info)
	{
		if ( !Data::Is_Number($FacultyID) || $FacultyID < 1 )
			return false;

		$sql = 'INSERT INTO PlaceSimpleKafedra SET ';
		$sql.= ' FacultyID = '.$FacultyID;
		$sql.= ', Created = NOW()';

		if (!is_array($info) || sizeof($info) < 1)
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql .= ', '.implode(', ', $fields);

		if (!$this->_db->query($sql))
			return false;

		return $this->_db->insert_id;
	}
	*/
	/**
	 * Получить место по идентификатору
	 *
	 * @param PlaceID
	 * @param IsVisible
	 * @param IsVerified
	 */
	public function GetPlaceAsIs($PlaceID, $IsVisible = null, $IsVerified = null)
	{
		if ( !Data::Is_Number($PlaceID) )
			return null;

		$sql = 'SELECT * FROM PlaceSimple WHERE PlaceID = '.$PlaceID;

		if ( is_bool($IsVisible) )
			$sql .= ' AND IsVisible = '.(int) $IsVisible;

		if ( is_bool($IsVerified) )
			$sql .= ' AND IsVerified = '.(int) $IsVerified;

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {
			$info = $res->fetch_assoc();
			$info['CountryCode'] = '';
			if ( $info['CityCode'] ) {

				if (strlen($info['CityCode']) < 22)
					$info['CityCode'] .= str_repeat('0', 22-strlen($info['CityCode']));

				$loc_pc = Location::ParseCode($info['CityCode']);
				$info['CountryCode'] = $loc_pc['ContinentCode'].$loc_pc['CountryCode'].'0000000000000000';
			}
			
			$info['YearStart'] = intval(substr($info['DateStart'], 0, 4));
			$info['MonthStart'] = intval(substr($info['DataStart'], 4));
			
			$info['YearEnd'] = intval(substr($info['DateEnd'], 0, 4));
			$info['MonthEnd'] = intval(substr($info['DataEnd'], 4));
			
			return $info;
		}

		return null;
	}

	public function GetUsersCount($PlaceID, $TypeID) {

		$count = 0;
		if ( !$PlaceID || !Data::Is_Number($PlaceID) )
			return $count;

		if ( !$TypeID || !Data::Is_Number($TypeID) )
			return $count;

		$sql = 'SELECT `Count` FROM PlaceSimpleIndex WHERE ';
		$sql .= ' PlaceID = '.$PlaceID;
		$sql .= ' AND TypeID = '.$TypeID;

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return $count;

		list($count) = $res->fetch_row();
		return $count;
	}

	/**
	 * Получить количество пользователей по фильтру
	 *
	 * @param id
	 */
	public function GetUsersCountByFilter($filter)
	{
		// Проверенные...^
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;

		// Тип...^
		if ( isset($filter['flags']['TypeID']) ) {

			$filter['flags']['TypeID'] = (array) $filter['flags']['TypeID'];
			$types = array();

			foreach($filter['flags']['TypeID'] as $id) {
				if ( isset(PlaceSimpleMgr::$types[$id]) )
					$types[] = $id;
			}

			$filter['flags']['TypeID'] = $types;
			if ( !sizeof($types) )
				$filter['flags']['TypeID'] = null;
		} else
			$filter['flags']['TypeID'] = null;

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && in_array((int) $filter['flags']['IsVisible'], array(0, -1)) )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = 1;

		if( !Data::Is_Number($filter['flags']['PlaceID']) )
			$filter['flags']['PlaceID'] = 0;

		if( !Data::Is_Number($filter['flags']['FacultyID']) )
			$filter['flags']['FacultyID'] = 0;

		if( !Data::Is_Number($filter['flags']['ChairID']) )
			$filter['flags']['ChairID'] = 0;
			
		if( !Data::Is_Number($filter['flags']['YearStart']) )
			$filter['flags']['YearStart'] = 0;
		
		if( !Data::Is_Number($filter['flags']['YearEnd']) )
			$filter['flags']['YearEnd'] = 0;
			
		if( !Data::Is_Number($filter['flags']['DateStart']) )
			$filter['flags']['DateStart'] = 0;
		
		if( !Data::Is_Number($filter['flags']['DateEnd']) )
			$filter['flags']['DateEnd'] = 0;

		if( !Data::Is_Number($filter['flags']['Region']) || !empty($filter['flags']['CityText']) )
			$filter['flags']['Region'] = 0;

		if( !Data::Is_Number($filter['flags']['City']) || !empty($filter['flags']['CityText']) )
			$filter['flags']['City'] = 0;

		if( !Data::Is_Number($filter['offset']) )
			$filter['offset'] = 0;

		if( !Data::Is_Number($filter['limit']) )
			$filter['limit'] = 0;

		$where = array();
		$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef ';
		$sql .= ' INNER JOIN PlaceSimple ON (PlaceSimple.PlaceID = PlaceSimpleRef.PlaceID) ';

		if ( $filter['flags']['TypeID'] !== null )
			$where[] = ' PlaceSimpleRef.TypeID IN('.implode(',',$filter['flags']['TypeID']).') ';
			
		if ( $filter['flags']['PlaceID'] )
			$where[] = ' PlaceSimpleRef.PlaceID = '.$filter['flags']['PlaceID'];

		if ( $filter['flags']['FacultyID'] )
			$where[] = ' PlaceSimpleRef.Faculty = '.$filter['flags']['FacultyID'];

		if ( $filter['flags']['ChairID'] )
			$where[] = ' PlaceSimpleRef.Chair = '.$filter['flags']['ChairID'];

		if ( $filter['flags']['YearStart'] )
			$where[] = ' PlaceSimpleRef.YearStart = '.$filter['flags']['YearStart'];
		else if ( $filter['flags']['YearEnd'] )
			$where[] = ' PlaceSimpleRef.YearStart >= 0';
		
		if ( $filter['flags']['YearEnd'] )
			$where[] = ' PlaceSimpleRef.YearEnd = '.$filter['flags']['YearEnd'];

		if ( $filter['flags']['DateStart'] )
			$where[] = ' PlaceSimpleRef.DateStart = '.$filter['flags']['DateStart'];
		else if ( $filter['flags']['DateEnd'] )
			$where[] = ' PlaceSimpleRef.DateStart >= \'000000\'';
		
		if ( $filter['flags']['DateEnd'] )
			$where[] = ' PlaceSimpleRef.DateEnd = '.$filter['flags']['DateEnd'];

		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = ' PlaceSimple.IsVerified = '.$filter['flags']['IsVerified'];
		else
			$where[] = ' PlaceSimple.IsVerified IN(0,1) ';
			
		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' PlaceSimple.IsVisible = '.$filter['flags']['IsVisible'];
		else
			$where[] = ' PlaceSimple.IsVisible IN(0,1) ';
			
		if ( $filter['flags']['Region'] )
			$where[] = ' PlaceSimple.Region = '.$filter['flags']['Region'];

		if ( $filter['flags']['City'] )
			$where[] = ' PlaceSimple.City = '.$filter['flags']['City'];
			
		if ( $filter['flags']['CityText'] )
			$where[] = ' PlaceSimple.CityText = \''.addslashes($filter['flags']['CityText']).'\'';

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		$count = 0;
		if ( $res = $this->_db->query($sql) )
			list($count) = $res->fetch_row();
		return $count;
	}

	/**
	 * Получить пользователей по фильтру
	 *
	 * @param id
	 */
	public function GetUsers($filter)
	{
		// Поле для сортировки
		if ( !empty($filter['field']) && !in_array($filter['field'], array('Created','LastUpdated')) )
			$filter['field'] = 'Name';

		// Порядок сортировки
		$filter['dir'] = strtoupper($filter['dir']);
		if ( $filter['dir'] != 'ASC' && $filter['dir'] != 'DESC' )
			$filter['dir'] = 'ASC';

		// Проверенные...^
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;

		// Тип...^
		if ( isset($filter['flags']['TypeID']) ) {

			$filter['flags']['TypeID'] = (array) $filter['flags']['TypeID'];
			$types = array();

			foreach($filter['flags']['TypeID'] as $id) {
				if ( isset(PlaceSimpleMgr::$types[$id]) )
					$types[] = $id;
			}

			$filter['flags']['TypeID'] = $types;
			if ( !sizeof($types) )
				$filter['flags']['TypeID'] = null;
		} else
			$filter['flags']['TypeID'] = null;

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && in_array((int) $filter['flags']['IsVisible'], array(0, -1)) )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = 1;

		if( !Data::Is_Number($filter['flags']['PlaceID']) )
			$filter['flags']['PlaceID'] = 0;

		if( !Data::Is_Number($filter['flags']['FacultyID']) )
			$filter['flags']['FacultyID'] = 0;

		if( !Data::Is_Number($filter['flags']['ChairID']) )
			$filter['flags']['ChairID'] = 0;

		if( !Data::Is_Number($filter['flags']['YearStart']) )
			$filter['flags']['YearStart'] = 0;
		
		if( !Data::Is_Number($filter['flags']['YearEnd']) )
			$filter['flags']['YearEnd'] = 0;

		if( !Data::Is_Number($filter['flags']['DateStart']) )
			$filter['flags']['DateStart'] = 0;
		
		if( !Data::Is_Number($filter['flags']['DateEnd']) )
			$filter['flags']['DateEnd'] = 0;
			
		if( !Data::Is_Number($filter['flags']['Region']) || !empty($filter['flags']['CityText']) )
			$filter['flags']['Region'] = 0;

		if( !Data::Is_Number($filter['flags']['City']) || !empty($filter['flags']['CityText']) )
			$filter['flags']['City'] = 0;

		if( !Data::Is_Number($filter['offset']) )
			$filter['offset'] = 0;

		if( !Data::Is_Number($filter['limit']) )
			$filter['limit'] = 0;

		$where = array();
		$sql = 'SELECT PlaceSimpleRef.* FROM PlaceSimpleRef ';
		$sql .= ' INNER JOIN PlaceSimple ON (PlaceSimple.PlaceID = PlaceSimpleRef.PlaceID) ';

		if ( $filter['flags']['TypeID'] !== null )
			$where[] = ' PlaceSimpleRef.TypeID IN('.implode(',',$filter['flags']['TypeID']).') ';
			
		if ( $filter['flags']['PlaceID'] )
			$where[] = ' PlaceSimpleRef.PlaceID = '.$filter['flags']['PlaceID'];

		if ( $filter['flags']['FacultyID'] )
			$where[] = ' PlaceSimpleRef.Faculty = '.$filter['flags']['FacultyID'];

		if ( $filter['flags']['ChairID'] )
			$where[] = ' PlaceSimpleRef.Chair = '.$filter['flags']['ChairID'];

		if ( $filter['flags']['YearStart'] )
			$where[] = ' PlaceSimpleRef.YearStart = '.$filter['flags']['YearStart'];
		else if ( $filter['flags']['YearEnd'] )
			$where[] = ' PlaceSimpleRef.YearStart >= 0';
		
		if ( $filter['flags']['YearEnd'] )
			$where[] = ' PlaceSimpleRef.YearEnd = '.$filter['flags']['YearEnd'];

		if ( $filter['flags']['DateStart'] )
			$where[] = ' PlaceSimpleRef.DateStart = '.$filter['flags']['DateStart'];
		else if ( $filter['flags']['DateEnd'] )
			$where[] = ' PlaceSimpleRef.DateStart >= \'000000\'';
		
		if ( $filter['flags']['DateEnd'] )
			$where[] = ' PlaceSimpleRef.DateEnd = '.$filter['flags']['DateEnd'];

		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = ' PlaceSimple.IsVerified = '.$filter['flags']['IsVerified'];
		else
			$where[] = ' PlaceSimple.IsVerified IN(0,1) ';
			
		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' PlaceSimple.IsVisible = '.$filter['flags']['IsVisible'];
		else
			$where[] = ' PlaceSimple.IsVisible IN(0,1) ';
			
		if ( $filter['flags']['Region'] )
			$where[] = ' PlaceSimple.Region = '.$filter['flags']['Region'];

		if ( $filter['flags']['City'] )
			$where[] = ' PlaceSimple.City = '.$filter['flags']['City'];
			
		if ( $filter['flags']['CityText'] )
			$where[] = ' PlaceSimple.CityText = \''.addslashes($filter['flags']['CityText']).'\'';

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if(!empty($filter['field']))
			$sql .= ' ORDER by PlaceSimple.'.$filter['field'].' '.$filter['dir'];

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}
//trace::log($sql);
		$result = array();
		$res = $this->_db->query($sql);

		while ( false != ($place = $res->fetch_assoc()) ) {
			$result[] = $place;
		}

		return $result;
	}

	/**
	 * Получить место по фильтру
	 *
	 * @param id
	 */
	public function GetPlaces($filter)
	{
		// Поле для сортировки
		if ( !in_array($filter['field'], array('Created','LastUpdated')) )
			$filter['field'] = 'Name';

		// Порядок сортировки
		$filter['dir'] = strtoupper($filter['dir']);
		if ( $filter['dir'] != 'ASC' && $filter['dir'] != 'DESC' )
			$filter['dir'] = 'ASC';

		// Проверенные...^
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;

		// Тип...^
		if ( isset($filter['flags']['TypeID']) ) {

			$filter['flags']['TypeID'] = (array) $filter['flags']['TypeID'];
			$types = array();

			foreach($filter['flags']['TypeID'] as $id) {
				if ( isset(PlaceSimpleMgr::$types[$id]) )
					$types[] = $id;
			}

			$filter['flags']['TypeID'] = $types;
			if ( !sizeof($types) )
				$filter['flags']['TypeID'] = null;
		} else
			$filter['flags']['TypeID'] = null;

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && in_array((int) $filter['flags']['IsVisible'], array(0, -1)) )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = 1;

		if( !Data::Is_Number($filter['flags']['Region']) )
			$filter['flags']['Region'] = 0;

		if( !Data::Is_Number($filter['flags']['City']) )
			$filter['flags']['City'] = 0;
			
		if( !Data::Is_Number($filter['offset']) )
			$filter['offset'] = 0;

		if( !Data::Is_Number($filter['limit']) )
			$filter['limit'] = 0;

		$where = array();

		if( Data::Is_Number($filter['flags']['UserID']) && $filter['flags']['UserID'] > 0 ) {
			$sql = 'SELECT PlaceSimple.*, PlaceSimpleRef.* FROM PlaceSimpleRef ';
			$sql .= 'INNER JOIN PlaceSimple ON (PlaceSimple.PlaceID = PlaceSimpleRef.PlaceID)';

			$where[] = ' PlaceSimpleRef.UserID = '.$filter['flags']['UserID'];
			if ( $filter['flags']['TypeID'] !== null )
				$where[] = ' PlaceSimpleRef.TypeID IN('.implode(',',$filter['flags']['TypeID']).') ';
		} else {
			$sql = 'SELECT * FROM PlaceSimple ';

			if ( $filter['flags']['TypeID'] !== null )
				$where[] = ' PlaceSimple.TypeID IN('.implode(',',$filter['flags']['TypeID']).') ';
		}

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' PlaceSimple.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = ' PlaceSimple.IsVerified = '.$filter['flags']['IsVerified'];

		if ( $filter['flags']['Region'] )
			$where[] = ' PlaceSimple.Region = '.$filter['flags']['Region'];

		if ( $filter['flags']['City'] )
			$where[] = ' PlaceSimple.City = '.$filter['flags']['City'];
			
		if ( $filter['flags']['CityCode'] )
			$where[] = ' PlaceSimple.CityCode = \''.addslashes($filter['flags']['CityCode']).'\'';

		//TODO: это должен делать sphinx
		if ( $filter['flags']['Name'] )
			$where[] = ' PlaceSimple.Name LIKE \'%'.addslashes($filter['flags']['Name']).'%\'';

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if ( $filter['limit'] ) {
			$sql .= ' ORDER by PlaceSimple.'.$filter['field'].' '.$filter['dir'];
		
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		$result = array();
		$res = $this->_db->query($sql);
		//if ( !$res || !$res->num_rows )
		//	return $result;

		while ( false != ($place = $res->fetch_assoc()) )  {

			if ($filter['flags']['objects'] === true)  {

				if ( !isset($this->_places[$place['PlaceID']]) )
					$this->_places[$place['PlaceID']] = new PlaceSimple($place);

				$place = $this->_places[$place['PlaceID']];
			} else {
				
				$place['CountryCode'] = '';
				if ( $place['CityCode'] ) {

					if (strlen($info['CityCode']) < 22)
						$info['CityCode'] .= str_repeat('0', 22-strlen($info['CityCode']));

					$loc_pc = Location::ParseCode($info['CityCode']);
					$info['CountryCode'] = $loc_pc['ContinentCode'].$loc_pc['CountryCode'].'0000000000000000';
				}
			
			}
			
			$place['YearStart'] = intval(substr($place['DateStart'], 0, 4));
			$place['MonthStart'] = intval(substr($place['DateStart'], 4));
			
			$place['YearEnd'] = intval(substr($place['DateEnd'], 0, 4));
			$place['MonthEnd'] = intval(substr($place['DateEnd'], 4));

			$result[] = $place;
		}

		return $result;
	}

	/**
	 * Получить топы по фильтру
	 *
	 * @param id
	 */
	public function GetTop($filter)
	{
		// Поле для сортировки
		if ( !in_array($filter['field'], array('Created','LastUpdated')) )
			$filter['field'] = 'Name';

		// Порядок сортировки
		$filter['dir'] = strtoupper($filter['dir']);
		if ( $filter['dir'] != 'ASC' && $filter['dir'] != 'DESC' )
			$filter['dir'] = 'ASC';

		// Проверенные...^
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;

		// Тип...^
		if ( isset($filter['flags']['TypeID']) ) {

			$filter['flags']['TypeID'] = (array) $filter['flags']['TypeID'];
			$types = array();

			foreach($filter['flags']['TypeID'] as $id) {
				if ( isset(PlaceSimpleMgr::$types[$id]) )
					$types[] = $id;
			}

			$filter['flags']['TypeID'] = $types;
			if ( !sizeof($types) )
				$filter['flags']['TypeID'] = null;
		} else
			$filter['flags']['TypeID'] = null;

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && in_array((int) $filter['flags']['IsVisible'], array(0, -1)) )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = 1;

		if( trim($filter['flags']['CityCode']) == '' )
			$filter['flags']['CityCode'] = '';
			
		if( !Data::Is_Number($filter['flags']['Region']) )
			$filter['flags']['Region'] = 0;

		if( !Data::Is_Number($filter['flags']['City']) )
			$filter['flags']['City'] = 0;

		if( !Data::Is_Number($filter['offset']) )
			$filter['offset'] = 0;

		if( !Data::Is_Number($filter['limit']) )
			$filter['limit'] = 0;

		$where = array();
		$sql = 'SELECT PlaceSimple.*, PlaceSimpleIndex.`Count` as UsersCount FROM PlaceSimpleIndex ';
		$sql .= ' INNER JOIN PlaceSimple ON (PlaceSimple.PlaceID = PlaceSimpleIndex.PlaceID)';// AND PlaceSimpleIndex.TypeID = PlaceSimple.TypeID) ';
		
		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = ' PlaceSimple.IsVerified = '.$filter['flags']['IsVerified'];
		else
			$where[] = ' PlaceSimple.IsVerified >= 0 ';
		
		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' PlaceSimple.IsVisible = '.$filter['flags']['IsVisible'];
		else
			$where[] = ' PlaceSimple.IsVisible >= 0 ';

		if ( $filter['flags']['CityCode'] )
			$where[] = ' PlaceSimple.CityCode LIKE \''.addslashes($filter['flags']['CityCode']).'%\'';
			
		if ( $filter['flags']['Region'] )
			$where[] = ' PlaceSimple.Region = '.$filter['flags']['Region'];

		if ( $filter['flags']['City'] )
			$where[] = ' PlaceSimple.City = '.$filter['flags']['City'];

		if ( $filter['flags']['TypeID'] !== null )
			$where[] = ' PlaceSimpleIndex.TypeID IN('.implode(',',$filter['flags']['TypeID']).') ';
			
		$where[] = ' PlaceSimpleIndex.Count > 0 ';
		
			
		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		$sql .= ' ORDER by PlaceSimpleIndex.`Count` DESC, PlaceSimple.'.$filter['field'].' '.$filter['dir'];

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		$result = array();
		$res = $this->_db->query($sql);

		while ( false != ($place = $res->fetch_assoc()) ) {
			$result[] = $place;
		}

		return $result;
	}

	/**
	 * добавить место
	 *
	 * приватный метод - за внешний вызов удар в лоб
	 * @param info    информация о месте
	 */
	public function Add(array $info)
	{
		unset($info['PlaceID']);
		if ( !sizeof($info) )
			return false;

		$sql = 'SELECT PlaceID FROM PlaceSimple WHERE ';
		$sql .= ' TypeID = '.(int) $info['TypeID'];
		$sql .= ' AND Name = \''.addslashes($info['Name']).'\'';
		//$sql .= ' AND City = '.(int) $info['City'];
		$sql .= ' AND CityCode = \''.addslashes($info['CityCode']).'\'';

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {
			list($PlaceID) = $res->fetch_row();
			return $PlaceID;
		}

		if ( empty($info['CityCode']) ) 
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO PlaceSimple SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	 * удалить место и все связи
	 *
	 * @param id    идентификатор
	 */
	public function Remove($PlaceID)
	{
		if ( !Data::Is_Number($PlaceID) || !$PlaceID )
			return false;

		$sql = 'DELETE FROM PlaceSimpleRef WHERE PlaceID = '.$PlaceID;
		if ( false == $this->_db->query($sql))
			return false;

		$sql = 'DELETE FROM PlaceSimpleIndex WHERE PlaceID = '.$PlaceID;
		if ( false == $this->_db->query($sql))
			return false;

		$sql = 'DELETE FROM PlaceSimple WHERE PlaceID = '.$PlaceID;
		if ( false == $this->_db->query($sql))
			return false;

		unset($this->_places[$PlaceID]);
		return true;
	}

	/**
	 * обновить информацию о месте
	 *
	 * @param info    информация о месте
	 */
	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['PlaceID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE PlaceSimple SET LastUpdated = NOW(), ' . implode(', ', $fields);
		$sql .= ' WHERE PlaceID = '.$info['PlaceID'];

		if ( false != $this->_db->query($sql) )
			return true;

		return false;
	}

	public function UpdateIndex($TypeID, $PlaceID) {

		if ( !Data::Is_Number($TypeID) || !$TypeID )
			return false;

		if ( !Data::Is_Number($PlaceID) || !$PlaceID )
			return false;

		$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef ';
		$sql .= ' INNER JOIN PlaceSimple ON(PlaceSimple.PlaceID = PlaceSimpleRef.PlaceID) ';
		$sql .= ' WHERE PlaceSimpleRef.`PlaceID` = '.$PlaceID.' AND PlaceSimpleRef.`TypeID` = '.$TypeID;
		//$sql .= ' AND PlaceSimple.IsVisible = 1 ';

		if ( false != ($res = $this->_db->query($sql)) ) {
			list($count) = $res->fetch_row();

			$sql = 'REPLACE INTO PlaceSimpleIndex SET ';
			$sql .= ' `PlaceID` = '.$PlaceID.', `TypeID` = '.$TypeID.', `Count` = '.$count;
			$this->_db->query($sql);
		}
		
		return false;
	}

	public function IsUserPlace($TypeID, $PlaceID, $UserID = null)
	{
		global $OBJECTS;

		if ( !Data::Is_Number($TypeID) || !$TypeID )
			return false;

		if ( !Data::Is_Number($PlaceID) || !$PlaceID )
			return false;

		if ($UserID === null)
			$UserID = $OBJECTS['user']->ID;

		$sql = 'SELECT COUNT(*) FROM PlaceSimpleRef ';
		$sql .= ' WHERE UserID = '.$UserID;
		$sql .= ' AND TypeID = '.$TypeID;
		$sql .= ' AND PlaceID = '.$PlaceID;

		if ( false != ($res = $this->_db->query($sql)) ) {
			list($count) = $res->fetch_row();
			if ($count > 0)
				return true;
		}
		return false;
	}
}

?>
