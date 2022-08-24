<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/shares/share.php');

class ShareMgr
{
	private $_shares 		= array();
	private $_cache		= null;


	public $_db			= null;
	public $_tables		= array(
		'shares'            => 'shares',
	);

	public static $fieldTypes = array(
		'string'   => 'String',
		'text'     => 'Text',
		'boolean'  => 'Boolean',
		'select'   => 'Select',
		'checkbox' => 'Checkbox',
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
		$cache->Init('memcache', 'sharemgr');

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
	private function _shareObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$obj = new Share($info);
		if (isset($info['shareid']))
			$this->_shares[ $info['shareid'] ] = $obj;

		return $obj;
	}


	/**
	* @return Объект Product. В случае ошибки вернет null
	*/
	public function GetShare($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_shares[$id]) )
			return $this->_shares[$id];

		$info = false;

		$cacheid = 'share_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = 'SELECT * FROM '.$this->_tables['shares'].' WHERE ShareID = '.$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$share = $this->_shareObject($info);
		return $share;
	}

	/**
	* @return id of added share or false
	*/
	public function AddShare(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		unset($info['shareid']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['shares'].' SET Created = NOW(), ' . implode(', ', $fields);
		if(MODE === 'dev')
			error_log('Add share sql: '.$sql."\n");

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	* @return id of updated share or false
	*/
	public function UpdateShare(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( !sizeof($info) || !Data::Is_Number($info['shareid']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
		{
			$fields[] = "`$k` = '".addslashes($v)."'";
		}
		$sql = 'UPDATE '.$this->_tables['shares'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE ShareID = '.$info['shareid'];

		if($this->_db->query($sql) !== false)
		{
			$cache = $this->getCache();
			$cache->Remove('share_'.$info['shareid']);

			unset($this->_shares[$info['shareid']]);
			return $info['shareid'];
		}

		return false;
	}

	/**
	* @return bool
	*/
	public function RemoveShare($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$share = $this->GetShare($id);
		if($share == null)
			return false;

		$sql = 'DELETE FROM '.$this->_tables['shares'].' WHERE ShareID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('share_'.$id);

			unset($this->_shares[$id]);
			return true;
		}

		return false;
	}

	public function GetShares($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Title', 'Created', 'LastUpdated', 'Ord')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Title');
			$filter['dir'] = array('ASC');
		}

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = 1;

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
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['shares'].'.* ';
		else
			$sql = 'SELECT '.$this->_tables['shares'].'.* ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['shares'].' ';

		$where = array();


		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['shares'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['shares'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['shares'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['CatalogID'] != -1 )
			$where[] = ' '.$this->_tables['shares'].'.CatalogID = '.$filter['flags']['CatalogID'];


		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['shares'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['shares'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
				$group[] = ' '.$this->_tables['shares'].'.`'.$v.'`';
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
			error_log("Get shares sql: ".$sql);
			echo $sql;
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
				if ( isset($this->_shares[$row['ShareID']]) )
					$row = $this->_shares[$row['ShareID']];
				else
					$row = $this->_shareObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

}
