<?php

require_once ($CONFIG['engine_path'].'include/catalog/productphoto.php');

class ProductPhotoMgr
{
	public $dbname		= 'ecologystyle';
	public $_tables		= array(
		'photos'		=> 'ctl_photos',
	);

	public function __construct($caching = true)
	{
		LibFactory::GetStatic('data');
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$this->_db = DBFactory::GetInstance($this->dbname);
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

	public function GetPhoto($photoid)
	{
		if ( !Data::Is_Number($photoid) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$photoid;

		if ( false === ($res = $this->_db->query($sql)))
			return null;

		return new ProductPhoto($res->fetch_assoc());
	}

	public function GetPhotos($filter)
	{
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Name', 'Created', 'LastUpdated', 'ord')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Ord');
			$filter['dir'] = array('ASC');
		}

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = 1;

		if ( isset($filter['flags']['ProductID']) && $filter['flags']['ProductID'] != -1 )
			$filter['flags']['ProductID'] = (int) $filter['flags']['ProductID'];
		elseif (!isset($filter['flags']['ProductID']))
			$filter['flags']['ProductID'] = 0;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['photos'].'.* ';
		else
			$sql = 'SELECT '.$this->_tables['photos'].'.* ';

		$sql.= ' FROM '.$this->_tables['photos'].' ';

		$where = array();

		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['photos'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['photos'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['photos'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['ProductID'] != 0 )
			$where[] = ' '.$this->_tables['photos'].'.ProductID = '.$filter['flags']['ProductID'];

		if ( is_array($filter['flags']['filtered']) && sizeof($filter['flags']['filtered']) > 0 )
			$where[] = ' '.$this->_tables['photos'].'.ProductID IN ('.implode(",", $filter['flags']['filtered']).')';

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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

        if($filter['dbg'] == 1)
            echo $sql;

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
			$id = $row['ProductID'];
			if ($filter['flags']['objects'] === true)
			{
				$row = new ProductPhoto($row);
			}
			if ($filter['flags']['with'] === true)
				$result[$id][] = $row;
			else
				$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

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
		unset($info['photoid']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['photos'].' SET ' . implode(', ', $fields);
		// echo $sql; exit;
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

		$photo = $this->GetPhoto($id);
		$photo->PhotoSmall = null;
		$photo->PhotoBig = null;
		$photo->Photo = null;

		$sql = 'DELETE FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
		return $this->_db->query($sql) !== false;
	}


	/**
	 * обновить информацию о месте
	 *
	 * @param info    информация о месте
	 */
	public function Update(array $info)
	{

		$str = "";
		foreach($info as $k => $v)
		{
			$str .= "\n$k = $v";
		}
		if ( !sizeof($info) || !Data::Is_Number($info['photoid']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".$v."'";

		$sql = 'UPDATE '.$this->_tables['photos'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE PhotoID = '.$info['photoid'];

		return $this->_db->query($sql) !== false;
	}
}