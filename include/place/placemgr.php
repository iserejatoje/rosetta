<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/tree/nstreemgr.php');
require_once ($CONFIG['engine_path'].'include/place/place.php');
require_once ($CONFIG['engine_path'].'configure/lib/place/error.php');

class PlaceMgr
{

	/**
	 * Кэш мест
	 */
	public $_places = array();
	
	public $_db			= null;
	public $_tables		= array(
		'tree'			=> 'place_tree',
		'ref'			=> 'place_tree_ref',
		'data'			=> 'place_data',
		'temp'			=> 'place_data_accuracy',		
	);

	private $_tree		= null;
	private $_cache		= null;

	public function __construct($caching = true)
	{
		LibFactory::GetStatic('data');
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');
		
		$this->_db = DBFactory::GetInstance('webbazar');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);
			
		if ($caching === true) {			
			$this->_cache = $this->getCache();
		}
	}

        /**
         * Получить объект memcache'а
         *
         * @return Cache
         */
	public function getCache() {
		LibFactory::GetStatic('cache');
			
		$cache = new Cache();
		$cache->Init('memcache', 'placemgr');
		
		return $cache;
	}
	
	static function &getInstance ($caching = true) {
        static $instance;

        if (!isset($instance)) {
		//error_log(var_export($caching, true));
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }

	/**
	 * Получить объект фирмы по связи
	 *
	 * @param int $uniqueid - id'шник связи
	 * @param int $section - id'шник нода
	 * @return object Place - в случае ошибки вернет null
	 */
	public function GetPlaceByUniqueID($uniqueid, $section = null)
	{
		if ( !Data::Is_Number($uniqueid) )
			return null;

		if ( $section !== null && !Data::Is_Number($section) )
			return null;

		$sql = 'SELECT PlaceID FROM '.$this->_tables['ref'].' WHERE UniqueID = '.$uniqueid;
		if ( !$section === null )
			$sql .= ' AND NodeID = '.$section;

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {
			$row = $res->fetch_row();
			return $this->GetPlace($row[0]);
		}

		return null;
	}

	/**
	 * Получить место по идентификатору
	 *
	 * @param int $id - id'шник фирмы
	 * @param int $section - id'шник раздела
	 * @param bool $as_array - возвращать как массив
	 * @return Place (если as_array=false), и array, если as_array=true. В случае ошибки вернет null
	 */
	public function GetPlace($id, $section = null, $as_array = false)
	{
	
		if ( !Data::Is_Number($id) )
			return null;
		
		if ( $section !== null && !Data::Is_Number($section) )
			return null;

		if ( isset($this->places[$id]) )
			return $this->places[$id];

		$info = false;
		
		$cacheid = 'place_'.$id;
				
		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false) {

			$info = array(
				'Place' => array(),
				'Sections' => array(),
				'CommerceType' => array(),
			);

			$sql = 'SELECT * FROM '.$this->_tables['data'].' WHERE PlaceID = '.$id;						
			if ( false === ($res = $this->_db->query($sql)))
				return null;
			
			if (!$res->num_rows )
				return null;
				
			$info['Place'] = $res->fetch_assoc();

			$sql = 'SELECT '.$this->_tables['ref'].'.NodeID, '.$this->_tables['ref'].'.CommerceType FROM '.$this->_tables['ref'].'';
			$sql.= ' STRAIGHT_JOIN '.$this->_tables['tree'].' ON('.$this->_tables['tree'].'.NodeID = '.$this->_tables['ref'].'.NodeID) ';
			$sql.= ' WHERE '.$this->_tables['ref'].'.PlaceID = '.$id.' ';

			$res = $this->_db->query($sql);
			while(false != ($row = $res->fetch_row())) {
				$info['Sections'][] = $row[0];
				$info['CommerceType'][$row[0]] = $row[1];
			}

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600);
		}

		if ( $section !== null ) {
			if (!sizeof($info['Sections']))
				return null;

			if (!in_array($section, $info['Sections']))
				return null;

			$info['Place']['CommerceType'] = $info['CommerceType'][$section];
		} else
			$info['Place']['CommerceType'] = 0;

		if ($as_array === true)
			return $info['Place'];
		
		$place = $this->_placeObject($info['Place']);
		return $place;
	}

	public function GetPlacesWithComments($filter) {

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = 1;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		$sql = 'SELECT '.$this->_tables['data'].'.*, '.$this->_tables['ref'].'.UniqueID, '.$this->_tables['ref'].'.CommerceType ';
		$sql.= ' FROM '.$this->_tables['ref'].' ';
		$sql.= ' INNER JOIN '.$this->_tables['data'].' USING(PlaceID)';

		$where = array();
		if ($filter['flags']['NodeID'] > 0)
			$where[] = ' '.$this->_tables['ref'].'.NodeID = '.(int) $filter['flags']['NodeID'];

		if ($filter['flags']['IsVisible'] != -1)
			$where[] = ' '.$this->_tables['data'].'.IsVisible = '.$filter['flags']['IsVisible'];

		$where[] = ' '.$this->_tables['data'].'.IsVerified = 1';
		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		$sql.= ' ORDER by '.$this->_tables['ref'].'.LastCommentDate DESC';
		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		$result = array();
		while (false != ($row = $res->fetch_assoc())) {
			if ($filter['flags']['objects'] === true)
			{
				if ( isset($this->places[$row['PlaceID']]) )
					$row = $this->places[$row['PlaceID']];
				else
					$row = $this->_placeObject($row);
			}
			$result[] = $row;
		}

		return $result;


	}

	/**
	 * Установить пометку о редактировании
	 *
	 * @param placeid - id'шник фирмы
     * @return bool
	 */
	public function SetIsEdited( $placeid ){
		
		$place = self::GetPlace( $placeid );
		
		if ( !isset($place) ) 
			return false;
		
		if ( $place->IsEdited !== true ){
			$place->IsEdited = true;
			$place->Update();
		}
		
		return true;
	}
	
	/**
	 * Сбросить пометку о редактировании
	 *
	 * @param placeid - id'шник фирмы
         * @return bool
	 */
	public function ResetIsEdited( $placeid ){
		
		$place = self::GetPlace( $placeid );
		
		if ( !isset($place) ) 
			return false;
		
		if ( $place->IsEdited !== false ){
			$place->IsEdited = false;
			$place->Update();
		}
		
		return true;
	}

        /**
         * Получить объект фирмы по id'шнику неточности (это фирма на которую пожаловались, или владелец фирмы отредактировал)
         *
         * @param int $id - id'шник неточности
         * @return Place - в случае ошибки null
         */
	public function GetAccuracyPlace($id)
	{
		if ( !Data::Is_Number($id) )
			return null;

		$sql = "SELECT * FROM ".$this->_tables['temp'];
		$sql.= " WHERE AccuracyID=".$id;

		$res = $this->_db->query($sql);
		if ( $res === false)
			return null;

		if (($row = $res->fetch_assoc()) !== false)
		{
			$place = $this->_placeObject($row);
			return $place;
		}

		return null;
	}

        /**
         * Получить объект фирмы, отредактированной владельцем
         *
         * @param int $placeid - id'шник фримы
         * @return Place - в случае ошибки null
         */
    public function GetAccuracySelfEditedPlace($placeid)
	{
		if ( !Data::Is_Number($placeid) )
			return null;

		$sql = "SELECT * FROM ".$this->_tables['temp'];
		$sql.= " WHERE PlaceID=".$placeid;
		$sql.= " AND IsSelfEdited = 1";

		$res = $this->_db->query($sql);
		if ( $res === false)
			return null;

		if ( $row = $res->fetch_assoc())
		{
			$place = $this->_placeObject($row);
			return $place;
		}

		return null;
	}

        /**
         * По строке из базы получить объект Place
         *
         * @param array $info
         * @return Place
         */
	private function _placeObject(array $info) {

		$info = array_change_key_case($info, CASE_LOWER);
				
		$place = new Place($info);
		if (isset($info['placeid']))
			$this->_places[ $info['placeid'] ] = $place;

		return $place;
	}
	
	public function GetPlacesFullText($filter)
	{
		if (!isset($filter['query']) || $filter['query'] == "")
			return array();
		
		$list = array();
		$sql = "SELECT SQL_CALC_FOUND_ROWS d.*, r.UniqueID, r.CommerceType FROM ".$this->_tables['data']." as d";
		$sql.= " INNER JOIN ".$this->_tables['ref']." as r USING(PlaceID)";
		$sql.= " WHERE MATCH(name,announcetext,info) AGAINST('".addslashes($filter['query'])."')";
		$sql.= " AND r.NodeID = ".(int) $filter['NodeID'];
		if (isset($filter['RegionID']) && $filter['RegionID'] > 0)
			$sql.= " AND d.RegionID=".$filter['RegionID'];
		
		if ( $filter['limit'] ) 
		{
			$sql.= " LIMIT ";
			if ( $filter['offset'] )
				$sql.= $filter['offset'].", ";

			$sql.= $filter['limit'];
		}
		
		$res = $this->_db->query($sql);
		
		$sql = "SELECT FOUND_ROWS()";
		list($count) = $this->_db->query($sql)->fetch_row();
		
		while($row = $res->fetch_assoc()) 
		{	
			$list[] = $row;
		}
		
		return array($list, $count);
	}

        /**
         * Получить разделы в которых находится фирма
         *
         * @param int $id - id'шник фримы
         * @param int $treeid - идентификатор дерева
         * @param bool $full - полные связи
         * @param bool $list - возвращать массив разбитый по коммерческому типу(true), или сквозной(false)
         * @return array - массив id'шников разделов
         */
	public function GetPlaceSectionRef($id, $treeid = null, $full = false, $list = false) {
		if ( !Data::Is_Number($id) || $id <= 0 )
			return array();

		if ( $treeid !== null && (!Data::Is_Number($treeid) || $treeid <= 0) )
			return array();

		$sections = array();

		$sql = 'SELECT '.$this->_tables['ref'].'.NodeID, '.$this->_tables['ref'].'.CommerceType FROM '.$this->_tables['ref'].'';
		$sql.= ' STRAIGHT_JOIN '.$this->_tables['tree'].' ON('.$this->_tables['tree'].'.NodeID = '.$this->_tables['ref'].'.NodeID) ';
		$sql.= ' WHERE '.$this->_tables['ref'].'.placeid = '.$id.' ';

		if ($treeid !== null)
			$sql.= ' AND '.$this->_tables['tree'].'.`TreeID` = '.$treeid;

		if ($full === false)
			$sql.= ' AND '.$this->_tables['tree'].'.`Right` - '.$this->_tables['tree'].'.`Left` = 1';
		
		$res = $this->_db->query($sql);
		while(false != ($row = $res->fetch_assoc())) {
			if ($list == true)
				$sections[$row['CommerceType']][] = $row['NodeID'];
			else
				$sections[] = $row['NodeID'];
		}

		return $sections;
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

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['data'].' SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	 * удалить место
	 *
	 * @param id    идентификатор
	 */
	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		try {
			if ($places[$id]) {
				$places[$id]->LogotypeSmall = null;
				$places[$id]->LogotypeBig = null;
				$places[$id]->LocationMap = null;
				$places[$id]->PriceFile = null;
			}
		} catch(MyException $e) {}

		$sql = 'DELETE FROM '.$this->_tables['data'].' WHERE PlaceID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('place_'.$id);
		
			$sql = 'DELETE FROM '.$this->_tables['ref'].' WHERE';
			$sql .= ' PlaceID = '.$id;
			$this->_db->query($sql);

			$sql = 'DELETE FROM '.$this->_tables['temp'].' WHERE PlaceID = '.$id;
			$this->_db->query($sql);
			
			PlaceExtraLocationMgr::getInstance()->RemoveAllForPlace($id);

			unset($places[$id]);
			return true;
		}

		return false;
	}

        /**
         * Удалить неточность по AccuracyID
         *
         * @param int $id - id'шник неточности
         * @return bool
         */
	public function RemoveAccuracy($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$sql = "SELECT PlaceID FROM ".$this->_tables['temp'];
		$sql.= " WHERE  AccuracyID = ".$id;
		
		$res = $this->_db->query($sql);
		if ( $row = $res->fetch_row() )
			self::ResetIsEdited($row[0]);
			
		$sql = 'DELETE FROM '.$this->_tables['temp'].' WHERE AccuracyID = '.$id;
		if ( false !== $this->_db->query($sql) )
			return true;

		return false;
	}
	
	/**
	 * Удалить неточности от владельца фирмы
	 *
	 * @param placeid
	 */
	public function RemoveSelfEditedAccuracy($placeid)
	{
		if ( !Data::Is_Number($placeid) )
			return false;
	
		$sql = 'DELETE FROM '.$this->_tables['temp'];
		$sql.= ' WHERE PlaceID = '.$placeid;
		$sql.= ' AND IsSelfEdited = 1';
		
		//error_log($sql);
		if ( false !== $this->_db->query($sql) )
			return true;

		return false;
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
			$fields[] = "`$k` = '".$v."'";

		$sql = 'UPDATE '.$this->_tables['data'].' SET LastUpdated = NOW(), ' . implode(', ', $fields);
		$sql .= ' WHERE PlaceID = '.$info['PlaceID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('place_'.$info['PlaceID']);
		
			return true;
		}

		return false;
	}

	/**
	 * добавить сообщение о неточности
	 *
	 * приватный метод - за внешний вызов удар в лоб
	 * @param info    информация о месте
	 */
	public function AddInaccuracy(array $info)
	{
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['temp'].' SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

        /**
         * Получить фирмы по фильтру
         *
         * @param array $filter - фильтр.
         * @return array - если $filter['calc']===true, то вернет array(result, count).
         *                 Если $filter['calc']===false или его нету, то вернет просто result
         */
	public function GetPlaces($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Name','ShortName', 'Created', 'LastUpdated', 'CommerceType', 'IsCommerce', 'Ord', 'Views')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Name');
			$filter['dir'] = array('ASC');
		}
		
		// Проверенные...^
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;

		// С координатами для ymap
		if ( isset($filter['flags']['OnMap']) && in_array((int) $filter['flags']['OnMap'], array(0, 1)) )
			$filter['flags']['OnMap'] = (int) $filter['flags']['OnMap'];
		else
			$filter['flags']['OnMap'] = -1;
			
		// Комментарии
		if ( isset($filter['flags']['IsComments']) && in_array((int) $filter['flags']['IsComments'], array(0, 1)) )
			$filter['flags']['IsComments'] = (int) $filter['flags']['IsComments'];
		else
			$filter['flags']['IsComments'] = -1;

		// Анонсируемые
		if ( isset($filter['flags']['IsAnnounce']) && in_array((int) $filter['flags']['IsAnnounce'], array(0, 1)) )
			$filter['flags']['IsAnnounce'] = (int) $filter['flags']['IsAnnounce'];
		else
			$filter['flags']['IsAnnounce'] = -1;
			
		// Коммерческие
		if ( isset($filter['flags']['CommerceType']) && in_array((int) $filter['flags']['CommerceType'], array(1, 2)) )
			$filter['flags']['CommerceType'] = (int) $filter['flags']['CommerceType'];
		else
			$filter['flags']['CommerceType'] = -1;

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = 1;

		if ( !Data::Is_Number($filter['flags']['UserID']) )
			$filter['flags']['UserID'] = 0;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['data'].'.*, '.$this->_tables['ref'].'.UniqueID, '.$this->_tables['ref'].'.CommerceType ';
		else
			$sql = 'SELECT '.$this->_tables['data'].'.*, '.$this->_tables['ref'].'.UniqueID, '.$this->_tables['ref'].'.CommerceType ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['data'].' ';
		$sql.= ' INNER JOIN '.$this->_tables['ref'].' USING(PlaceID)';
		
		$where = array();
		if ( $filter['flags']['NodeID'] > 0 )
			$where[] = ' '.$this->_tables['ref'].'.NodeID = '.(int) $filter['flags']['NodeID'];

		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['data'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['data'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = ' '.$this->_tables['data'].'.IsVerified = '.$filter['flags']['IsVerified'];
			
		if ( $filter['flags']['OnMap'] != -1 )
			$where[] = ' '.$this->_tables['data'].'.OnMap = '.$filter['flags']['OnMap'];

		if ( $filter['flags']['IsAnnounce'] != -1 )
			$where[] = ' '.$this->_tables['data'].'.IsAnnounce = '.$filter['flags']['IsAnnounce'];

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['data'].'.IsVisible = '.$filter['flags']['IsVisible'];
			
		if ( $filter['flags']['CommerceType'] != -1 )
			$where[] = ' '.$this->_tables['ref'].'.CommerceType >= '.$filter['flags']['CommerceType'];

		if ( $filter['flags']['UserID'] > 0 )
			$where[] = ' '.$this->_tables['data'].'.UserID = '.$filter['flags']['UserID'];

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['data'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['data'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
			$group = array();
			foreach($filter['group']['fields'] as $v) {
				$group[] = ' '.$this->_tables['data'].'.`'.$v.'`';
			}

			$sql .= ' GROUP by '.implode(', ', $group);
		}

		if (isset($filter['having']) && $filter['having'])
			$sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

		$sql.= ' ORDER by ';

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}
		
		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $this->_db->query($sql)->fetch_row();
		}

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ($filter['flags']['objects'] === true)
			{
				if ( isset($this->places[$row['PlaceID']]) )
					$row = $this->places[$id];
				else
					$row = $this->_placeObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	/**
	 * Получить неточности
	 *
	 *@param $treeid - идентификатор дерева, используется в хипе
	 */
	public function GetAccuracyPlaces($limit = 100, $treeid = null)
	{
		$result = array();
		
		if ( isset($treeid) ){
			$sql = "SELECT temp.* FROM ".PlaceMgr::getInstance()->_tables['temp']." temp";
			$sql.= " INNER JOIN ".PlaceMgr::getInstance()->_tables['ref']." ref ON(temp.PlaceID = ref.PlaceID)";
			$sql.= " STRAIGHT_JOIN ".PlaceMgr::getInstance()->_tables['tree']." tree ON(tree.NodeID = ref.NodeID)";
			$sql.= " WHERE tree.`TreeID` = ".intval($treeid);
			$sql.= " LIMIT ".$limit;
		} else {

			$sql = "SELECT * FROM ".PlaceMgr::getInstance()->_tables['temp'];
			$sql.= " LIMIT ".$limit;
		}

		$res = $this->_db->query($sql);
		if ( $res === false)
			return false;

		while ($row = $res->fetch_assoc())
		{
			$row = $this->_placeObject($row);
			$result[] = $row;
		}
		return $result;
	}

        /**
         * Проверить наличие фирмы с именем $Name в разделах $sections
         *
         * @param string $Name - название фирмы
         * @param int $treeid - id'шник дерева
         * @param array $sections - массив id'шников разделов
         * @param int $PlaceID - за исключением этой фирмы
         * @return bool
         */
	public function CheckDuplicatePlace($Name = "", $treeid = null, $sections = array(), $PlaceID=null)
	{
		if ($Name == "")
			return false;
			
		$Name = trim($Name);		
		$Name = preg_replace("/\s+/"," ",$Name);
		
		if ( $treeid !== null && (!Data::Is_Number($treeid) || $treeid <= 0) )
			return false;
		
		if (!is_array($sections) || count($sections) == 0)
			return false;
			
		$sql.= "SELECT count(*) cnt";
		$sql.= " FROM ".$this->_tables['data']." as d";
		$sql.= "  INNER JOIN ".$this->_tables['ref']." as r USING(PlaceID)";
		$sql.= "  INNER JOIN ".$this->_tables['tree']." as t";
		$sql.= "   ON (t.TreeID=".$treeid." AND t.NodeID=r.NodeID)";
		$sql.= " WHERE  r.NodeID IN (".implode(",", $sections).")";
		if ($PlaceID!=null)
			$sql.= " AND d.PlaceID!='".$PlaceID."'";
		$sql.= " AND d.Name='".strtolower($Name)."'";
		
		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ($row = $res->fetch_assoc())
			return intval($row['cnt']) > 0;
		
		return false;
	}

        /**
         * Получить количество видимых связей
         *
         * @param int $sid - Нод
         * @param int $visible - считать только видимые
         * @return int - количество связей (в случае ошибки false)
         */
	public function getItemsCount($sid, $visible = 1) {
		$sql = 'SELECT COUNT(*) FROM '.$this->_tables['ref'].' r';
		$sql.= ' INNER JOIN '.$this->_tables['data'].' d USING(PlaceID) ';
		$sql.= ' WHERE r.NodeId = '.$sid;

		if ($visible != -1)
			$sql.= ' AND d.IsVisible = '.(int) $visible;

		$res = $this->_db->query($sql);
		if ($res) {
			list($count) = $res->fetch_row();
			return $count;
		}

		return false;
	}

	public function restoreRefByPath(array $path, array $opath = array()) {
		
		if (!sizeof($path))
			return false;
	
		if (sizeof($path) < 2)
			return true;
	
		$this->_db->query('START TRANSACTION');
	
		if (false == $this->_restoreRefByPath($path, $opath)) {
			$this->_db->query('ROLLBACK');
			return false;
		}
		
		$this->_db->query('COMMIT');
		return true;
	}
	
	private function _restoreRefByPath(array $npath, array $opath) {
	
		$nodeId = array_pop($npath);
		if (false === $this->_removeRefByPath($opath))
			return false;
	
		foreach($opath as $v) {
			if ($nodeId == $v)
				continue ;
		
			$count = $this->getItemsCount($v);
			if ($count !== false) {

				$sql = 'UPDATE '.$this->_tables['tree'].' SET ItemsCount = '.(int) $count;
				$sql.= ' WHERE NodeID = '.$v;

				$this->_db->query($sql);
			}
		}
	
		
		$sql = 'SELECT PlaceID, CommerceType from '.$this->_tables['ref'];
		$sql.= ' WHERE  NodeID in ('.$nodeId.')';
		
		$newRefs = array();
		$res = $this->_db->query($sql);
		while(false != ($row = $res->fetch_row())) {
			
			foreach($npath as $nodeID)
				$newRefs[] = '('.$nodeID.', '.$row[0].', '.$row[1].')';
		
			if (sizeof($newRefs) < 100)
				continue ;
			
			$sql = 'INSERT IGNORE INTO '.$this->_tables['ref'].' (NodeID, PlaceID, CommerceType) VALUES ';
			$sql.= implode(', ', $newRefs);
			
			if (false == $this->_db->query($sql))
				return false;
			
			$newRefs = array();
		}
		
		if (sizeof($newRefs)) {
			$sql = 'INSERT IGNORE INTO '.$this->_tables['ref'].' (NodeID, PlaceID, CommerceType) VALUES ';
			$sql.= implode(', ', $newRefs);
		
			if (false == $this->_db->query($sql))
				return false;
		}
		
		foreach($npath as $v) {
			$count = $this->getItemsCount($v);
			if ($count !== false) {

				$sql = 'UPDATE '.$this->_tables['tree'].' SET ItemsCount = '.(int) $count;
				$sql.= ' WHERE NodeID = '.$v;

				$this->_db->query($sql);
			}
		}
		
		if (false == $this->_db->query($sql))
			return false;
			
		return true ;
	}
	
	private function _removeRefByPath(array $path) {
		if (!sizeof($path))
			return false;
		
		if (sizeof($path) < 2)
			return true;
		
		$nodeId = array_pop($path);
		
		$sql = 'SELECT PlaceID FROM '.$this->_tables['ref'];
		$sql.= ' WHERE NodeID = '.$nodeId;
		
		$idList = array();
		$res = $this->_db->query($sql);
		while(false != ($row = $res->fetch_row())) {
			$idList[] = $row[0];
			
			if (sizeof($idList) < 100)
				continue ;
			
			$sql = 'DELETE FROM '.$this->_tables['ref'];
			$sql.= ' WHERE PlaceID in('.implode(',',$idList).') and NodeID in ('.implode(', ', $path).')';
			
			if (false == $this->_db->query($sql))
				return false;
			
			$idList = array();
		}
		
		if (sizeof($idList)) {
			$sql = 'DELETE FROM '.$this->_tables['ref'];
			$sql.= ' WHERE PlaceID in('.implode(',',$idList).') and NodeID in ('.implode(', ', $path).')';
		
			if (false == $this->_db->query($sql))
				return false;
		}
		
		return true ;
	}

        /**
         * Удаляет все связи нодов и фирм, для которых нету нодов
         * @return bool
         */
	public function removeErrorRef()
	{
		$sql = 'DELETE FROM '.$this->_tables['ref'].' WHERE';
		$sql .= ' NodeID NOT IN(SELECT NodeID FROM '.$this->_tables['tree'].')';

		return $this->_db->query($sql);
	}

	public function setActiveToRef(NSTreeMgr $mgr, array $nodes, $active) {

		if (empty($nodes))
			return false;

		foreach($nodes as $nodeid) {
			if ($active == 1) {
				if (null === ($node = $mgr->getNode($nodeid)))
					continue ;

				$path = $node->getPath(true, false);
				foreach($path as $node) {
					if ($node->ID != $nodeid && !$nodeid->isVisible)
						continue 2;
				}
			}

			$sql = 'UPDATE '.$this->_tables['ref'];
			$sql.= ' SET IsActive = '.($active ? 1 : 0);
			$sql.= ' WHERE NodeID = '.(int) $nodeid;

			$this->_db->query($sql);
		}
	}

	public function Dispose()
	{
		if(!empty($this->_places)) {
			foreach($this->_places as $k => $v) {
				$this->_places[$k] = null;
			}
		}

		$this->_places = null;
		$this->_places = array();
	}

	/**
	 * Построить путь до раздела
	 *
	 * @param PNSTreeNodeIterator $path
	 * @param <type> $root
	 * @return string
	 */
	public function GetNamePath(PNSTreeNodeIterator $path, $root) {
		$base = '';

		foreach($path as $v) {
				if ($v->level <= $root->level)
						continue ;

				$base .= $v->NameID.'/';
		}

		return $base;
	}
}

?>
