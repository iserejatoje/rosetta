<?php

require_once ($CONFIG['engine_path'].'include/page/page.php');

class PageMgr
{
	public $_tables		= array(
		'pages'		=> 'pages',
	);

	public function __construct($caching = true)
	{
		LibFactory::GetStatic('data');


		$this->_db = DBFactory::GetInstance('takemix');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_Product_CANT_CONNECT_TODB', ERR_L_Product_CANT_CONNECT_TODB);
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

	public function GetPage($pageid)
	{
		if ( !Data::Is_Number($pageid) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['pages'].' WHERE PageID = '.$pageid;
		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows)
			return null;

		return new Page($res->fetch_assoc());
	}

	public function GetPageBySectionID($sectionid)
	{
		if ( !Data::Is_Number($sectionid) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['pages'].' WHERE SectionID = '.$sectionid;
		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows)
			return null;

		return new Page($res->fetch_assoc());
	}

	public function GetPages($filter)
	{
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Name', 'Created', 'LastUpdated')) )
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
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['pages'].'.* ';
		else
			$sql = 'SELECT '.$this->_tables['pages'].'.* ';

		$sql.= ' FROM '.$this->_tables['pages'].' ';

		$where = array();

		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['pages'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['pages'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['pages'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['pages'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['pages'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		$sql.= ' ORDER BY ';

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
				$row = new Page($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	/**
	 * добавить страницу
	 *
	 * приватный метод - за внешний вызов удар в лоб
	 * @param info    информация о странице
	 */
	public function Add(array $info)
	{
		unset($info['PageID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['pages'].' SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	 * удалить фотку
	 *
	 * @param id    идентификатор
	 */
	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$photo = $this->GetPage($id);

		$sql = 'DELETE FROM '.$this->_tables['pages'].' WHERE PageID = '.$id;
		return $this->_db->query($sql) !== false;
	}


	/**
	 * обновить информацию о месте
	 *
	 * @param info    информация о месте
	 */
	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['PageID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE '.$this->_tables['pages'].' SET LastUpdated = NOW(), ' . implode(', ', $fields);
		$sql .= ' WHERE PageID = '.$info['PageID'];

		return $this->_db->query($sql) !== false;
	}
}