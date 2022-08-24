<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/cities/city.php');
require_once ($CONFIG['engine_path'].'include/cities/address.php');

class CitiesMgr
{
	private $_cities = array();
	private $_address = array();

	private $_cache		= null;


	public $_db			= null;
	public $_tables		= array(
		'cities'   => 'cities',
		'address'   => 'city_address',
	);

	public function __construct()
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$this->_db = DBFactory::GetInstance($this->dbname);
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);

		$this->_cache = $this->getCache();
	}

	public function getCache()
	{
		LibFactory::GetStatic('cache');

		$cache = new Cache();
		$cache->Init('memcache', 'citiesmgr');

		return $cache;
	}

	static function &getInstance ($caching = true)
	{
		static $instance;

		if (!isset($instance)) {
			$cl = __CLASS__;
			$instance = new $cl($caching);
		}

		return $instance;
	}

	/**
	 * Сформировать объект по массиву данных
	 *
	 * @param array $info - массив полей со значениями
	 * @return Объект Product. В случае ошибки вернет null
	 */
	private function _citiesObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$obj = new City($info);
		if (isset($info['cityid']))
			$this->_cities[ $info['cityid'] ] = $obj;

		return $obj;
	}

	public function GetCityInfo($name) {

		$sql = "SELECT * FROM ".$this->_tables['cities'];
		$sql .= " WHERE LOWER(NameID) = '".strtolower($name)."'";

		$res = $this->_db->query($sql);
		if ( false === $res || !$res->num_rows )
		{
			$sql = "SELECT * FROM ".$this->_tables['cities'];
			$sql .= " WHERE IsDefault = 1";

			if ( false === ($res = $this->_db->query($sql)))
				return false;
		}

		if (!$res->num_rows)
			return false;

		return $this->_citiesObject($res->fetch_assoc());
	}


	/**
	* @return Объект Product. В случае ошибки вернет null
	*/
	public function GetCity($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_cities[$id]) )
			return $this->_cities[$id];

		$info = false;

		$cacheid = 'city_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = 'SELECT * FROM '.$this->_tables['cities'].' WHERE CityID = '.$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$obj = $this->_citiesObject($info);
		return $obj;
	}

	/**
	* @return id of added city or false
	*/
	public function AddCity(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		unset($info['cityid']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['cities'].' SET Created = NOW(), ' . implode(', ', $fields);
		// if(MODE === 'dev')
		// 	error_log('Add city sql: '.$sql."\n");

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	* @return id of updated city or false
	*/
	public function UpdateCity(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( !sizeof($info) || !Data::Is_Number($info['cityid']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
		{
			$fields[] = "`$k` = '".addslashes($v)."'";
		}
		$sql = 'UPDATE '.$this->_tables['cities'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE CityID = '.$info['cityid'];

		if($this->_db->query($sql) !== false)
		{
			$cache = $this->getCache();
			$cache->Remove('city_'.$info['cityid']);

			unset($this->_cities[$info['cityid']]);
			return $info['cityid'];
		}

		return false;
	}

	/**
	* @return bool
	*/
	public function RemoveCity($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$city = $this->GetCity($id);
		if($city == null)
			return false;

		$sql = 'DELETE FROM '.$this->_tables['cities'].' WHERE CityID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('city_'.$id);
			$cache->Remove('city_addr_list_'.$id);

			unset($this->_cities[$id]);
			return true;
		}

		return false;
	}

	public function GetCities($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Title', 'Created', 'LastUpdated', 'IsDefault')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('IsDefault');
			$filter['dir'] = array('ASC');
		}

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = -1;

		if ( isset($filter['flags']['IsDefault']) && $filter['flags']['IsDefault'] != -1 )
			$filter['flags']['IsDefault'] = (int) $filter['flags']['IsDefault'];
		elseif (!isset($filter['flags']['IsDefault']))
			$filter['flags']['IsDefault'] = -1;

		if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
			$filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
		elseif (!isset($filter['flags']['CatalogID']))
			$filter['flags']['CatalogID'] = -1;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['cities'].'.* ';
		else
			$sql = 'SELECT '.$this->_tables['cities'].'.* ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['cities'].' ';

		$where = array();


		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['cities'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['cities'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['cities'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['IsDefault'] != -1 )
			$where[] = ' '.$this->_tables['cities'].'.IsDefault = '.$filter['flags']['IsDefault'];

		if ( $filter['flags']['CatalogID'] != -1 )
			$where[] = ' '.$this->_tables['cities'].'.CatalogID = '.$filter['flags']['CatalogID'];


		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['cities'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['cities'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
				$group[] = ' '.$this->_tables['cities'].'.`'.$v.'`';
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

		if($filter['dbg'] == 1)
		{
			error_log("Get cities sql: ".$sql);
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
				if ( isset($this->_cities[$row['CityID']]) )
					$row = $this->_cities[$id];
				else
					$row = $this->_citiesObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	// ==================

	/**
	 * Сформировать объект по массиву данных
	 *
	 * @param array $info - массив полей со значениями
	 * @return Объект Address. В случае ошибки вернет null
	 */
	private function _addressObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$obj = new Address($info);
		if (isset($info['addressid']))
			$this->_address[ $info['addressid'] ] = $obj;

		return $obj;
	}


	/**
	* @return Объект Address. В случае ошибки вернет null
	*/
	public function GetAddress($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_address[$id]) )
			return $this->_address[$id];

		$info = false;

		$cacheid = 'address_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = 'SELECT * FROM '.$this->_tables['address'].' WHERE AddressID = '.$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$obj = $this->_addressObject($info);
		return $obj;
	}

	/**
	* @return id of added address or false
	*/
	public function AddAddress(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		unset($info['addressid']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['address'].' SET '. implode(', ', $fields);
		echo $sql; exit;
		// if(MODE === 'dev')
		// 	error_log('Add address sql: '.$sql."\n");

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	* @return id of updated address or false
	*/
	public function UpdateAddress(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( !sizeof($info) || !Data::Is_Number($info['addressid']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
		{
			$fields[] = "`$k` = '".addslashes($v)."'";
		}
		$sql = 'UPDATE '.$this->_tables['address'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE AddressID = '.$info['addressid'];

		if($this->_db->query($sql) !== false)
		{
			$cache = $this->getCache();
			$cache->Remove('address_'.$info['addressid']);
			$cache->Remove('city_addr_list_'.$info['cityid']);

			unset($this->_address[$info['addressid']]);
			return $info['addressid'];
		}

		return false;
	}

	/**
	* @return bool
	*/
	public function RemoveAddress($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$address = $this->GetAddress($id);
		if($address == null)
			return false;

		$cityid = $address->CityID;

		$sql = 'DELETE FROM '.$this->_tables['address'].' WHERE AddressID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('address_'.$id);
			$cache->Remove('city_addr_list_'.$cityid);

			unset($this->_address[$id]);
			return true;
		}

		return false;
	}

	public function GetAddressList($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Address', 'Created', 'LastUpdated', 'Ord')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Address');
			$filter['dir'] = array('ASC');
		}

		// Видимые
		if ( isset($filter['flags']['IsAvailable']) && $filter['flags']['IsAvailable'] != -1 )
			$filter['flags']['IsAvailable'] = (int) $filter['flags']['IsAvailable'];
		elseif (!isset($filter['flags']['IsAvailable']))
			$filter['flags']['IsAvailable'] = -1;

		if ( isset($filter['flags']['HasPickup']) && $filter['flags']['HasPickup'] != -1 )
			$filter['flags']['HasPickup'] = (int) $filter['flags']['HasPickup'];
		elseif (!isset($filter['flags']['HasPickup']))
			$filter['flags']['HasPickup'] = -1;

		if ( isset($filter['flags']['CityID']) && $filter['flags']['CityID'] != -1 )
			$filter['flags']['CityID'] = (int) $filter['flags']['CityID'];
		elseif (!isset($filter['flags']['CityID']))
			$filter['flags']['CityID'] = -1;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['address'].'.* ';
		else
			$sql = 'SELECT '.$this->_tables['address'].'.* ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['address'].' ';

		$where = array();


		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['address'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['address'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsAvailable'] != -1 )
			$where[] = ' '.$this->_tables['address'].'.IsAvailable = '.$filter['flags']['IsAvailable'];

		if ( $filter['flags']['CityID'] != -1 )
			$where[] = ' '.$this->_tables['address'].'.CityID = '.$filter['flags']['CityID'];

		if ( $filter['flags']['HasPickup'] != -1 )
			$where[] = ' '.$this->_tables['address'].'.HasPickup = '.$filter['flags']['HasPickup'];


		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['address'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['address'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
				$group[] = ' '.$this->_tables['address'].'.`'.$v.'`';
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

		if($filter['dbg'] == 1)
		{
			error_log("Get address sql: ".$sql);
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
				if ( isset($this->_address[$row['CityID']]) )
					$row = $this->_address[$id];
				else
					$row = $this->_addressObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	public function Dispose()
	{

	}

}