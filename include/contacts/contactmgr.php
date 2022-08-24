<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/shares/share.php');

class ShareMgr
{
	public $shares = array();

	public $_db			= null;
	public $_tables		= array(
		'shares'		=> 'shares',
	);

	private $_cache		= null;

	public function __construct()
	{
		LibFactory::GetStatic('places');
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

	static function &getInstance ()
	{
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }


	/**
	 * Получить место по идентификатору
	 *
	 * @param int $id - id'шник фирмы
	 * @param int $section - id'шник раздела
	 * @param bool $as_array - возвращать как массив
	 * @return Place (если as_array=false), и array, если as_array=true. В случае ошибки вернет null
	 */

	private function _shareObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$share = new Share($info);
		if (isset($info['shareid']))
			$this->shares[ $info['shareid'] ] = $share;

		return $share;
	}


	public function Add(array $info)
	{
		unset($info['ShareID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['shares'].' SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		try
		{
			if ($this->shares[$id])
			{
				$this->shares[$id]->Thumb = null;
				$this->shares[$id]->SmallThumb = null;
			}
		}
		catch(MyException $e) {}

		$sql = 'DELETE FROM '.$this->_tables['shares'].' WHERE ShareID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('share_'.$id);

			unset($this->shares[$id]);
			return true;
		}

		return false;
	}

	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['ShareID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE '.$this->_tables['shares'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE ShareID = '.$info['ShareID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('share_'.$info['ShareID']);

			return true;
		}

		return false;
	}

	public function GetShare($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( $section !== null && !Data::Is_Number($section) )
			return null;

		if ( isset($this->shares[$id]) )
			return $this->shares[$id];

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

		$news = $this->_shareObject($info);
		return $news;
	}

	public function GetShares($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Title', 'Created', 'Ord')) )
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


		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
		else
			$sql = 'SELECT * ';

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

		if (isset($filter['flags']['SectionID']))
			$where[] = ' '.$this->_tables['shares'].'.SectionID = '.$filter['flags']['SectionID'];

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['places'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['places'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
				$group[] = ' '.$this->_tables['places'].'.`'.$v.'`';
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
				if ( isset($this->shares[$row['ShareID']]) )
					$row = $this->shares[$row['ShareID']];
				else
					$row = $this->_shareObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	/**
	 * Get array of shares objects with specified sectionID
	 * @param int $sectionID - sectionID of shares
	 * @return array of shares objects or null
	 **/
	public function GetVisibleSharesBySectionID($sectionID)
	{
		$sectionID = intval($sectionID);
		if ($sectionID <= 0)
			return null;

		if ( $sectionID !== null && !Data::Is_Number($sectionID) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['shares'].' WHERE SectionID = '.$sectionID.' AND IsVisible = 1';

		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows )
			return null;

		$info = $res->fetch_assoc();

		$result = array();
		while ($row = $res->fetch_assoc())
		{

			if ( isset($this->shares[$row['ShareID']]) )
				$row = $this->shares[$row['ShareID']];
			else
				$row = $this->_shareObject($row);

			$result[] = $row;
		}

		return $result;
	}

	public function Dispose()
	{
		if(!empty($this->shares)) {
			foreach($this->shares as $k => $v) {
				$this->shares[$k] = null;
			}
		}

		$this->shares = null;
		$this->shares = array();
	}

}