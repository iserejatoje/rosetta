<?php

global $CONFIG;

require_once (ENGINE_PATH.'include/place/placenews.php');
require_once (ENGINE_PATH.'configure/lib/place/error.php');


class PlaceNewsMgr
{
	private $cache 		= array();
	public $_db			= null;
	public $_tables		= array(
		'place_news'	=> 'place_news',
	);

	public function __construct()
	{
		LibFactory::GetStatic('data');

		$this->_db = DBFactory::GetInstance('webbazar');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);
	}

	static function &getInstance() 
	{
        static $instance;

        if (!isset($instance)) 
		{
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }
	
	/**
	 * добавить новость
	 *
	 * @param info    информация о новости
	 * @param placeid    ID места
	 */
	public function Add(array $info)
	{
		unset($info['NewsID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "INSERT INTO ".$this->_tables['place_news']." SET " . implode(", ", $fields);

		if ($this->_db->query($sql) !== false)
			return $this->_db->insert_id;

		return false;
	}
	
	/**
	 * обновить информацию о новости
	 *
	 * @param info    информация о новости
	 */
	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['NewsID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "UPDATE ".$this->_tables['place_news']." SET " . implode(", ", $fields);
		$sql .= " WHERE NewsID = ".$info['NewsID'];

		return $this->_db->query($sql) !== false;
	}
	
	/**
	 * удалить новость
	 *
	 * @param id    идентификатор
	 */
	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;
		
		$sql = "DELETE FROM ".$this->_tables['place_news']." WHERE NewsID = ".$id;
		return $this->_db->query($sql);
	}
	
	/**
	 * получить новость
	 *
	 * @param id    идентификатор новости
	 */
	public function GetNewsByID($id)
	{	
		if (!Data::Is_Number($id))
			return false;
				
		$sql = "SELECT * FROM ".$this->_tables['place_news'];
		$sql.= " WHERE `NewsID`=".$id;
		
		$res = $this->_db->query($sql);
				
		if ( $row = $res->fetch_assoc() )
				return new PlaceNews($row);		
			
		return false;		
	}

	/**
	 * получить список новостей по фильтру
	 *
	 * @param placeid    идентификатор места
	 */
	public function GetNewsFilter($filter)
	{
		if ( isset($filter['field']) ) 
		{
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) 
				if ( !in_array($v, array('Name', 'Created', 'Updated')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			
			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir']))
		{
			$filter['field'] = array('Name');
			$filter['dir'] = array('ASC');
		}
		
		// Проверенные...
		if ( isset($filter['flags']['IsVerified']) && in_array((int) $filter['flags']['IsVerified'], array(0, 1)) )
			$filter['flags']['IsVerified'] = (int) $filter['flags']['IsVerified'];
		else
			$filter['flags']['IsVerified'] = -1;
			
		// Видимые...
		if ( isset($filter['flags']['IsVisible']) && in_array((int) $filter['flags']['IsVisible'], array(0, 1)) )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = -1;
		
		//По конкретному placeid
		if ( !Data::Is_Number($filter['flags']['PlaceID']) )
			$filter['flags']['PlaceID'] = 0;
		
		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = "SELECT SQL_CALC_FOUND_ROWS * ";
		else
			$sql = "SELECT * ";
			
		$sql.= " FROM ".$this->_tables['place_news']." ";
				
		$where = array();
		
		if ( $filter['flags']['IsVerified'] != -1 )
			$where[] = " IsVerified = ".$filter['flags']['IsVerified'];
			
		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = " IsVisible = ".$filter['flags']['IsVisible'];
		
		if ( $filter['flags']['PlaceID'] > 0 )
			$where[] = " PlaceID = ".$filter['flags']['PlaceID'];

		if ( sizeof($where) )
			$sql .= " WHERE ".implode(" AND ", $where);
		
		$sql.= " ORDER BY ";

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) 
		{
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
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}
		
	/**
	 * удалить все новости для места
	 *
	 * @param placeid    идентификатор места
	 */
	public function RemoveAllForPlace($placeid)
	{
		if (!Data::Is_Number($placeid))
			return false;

		$sql = "DELETE FROM ".$this->_tables['place_news']." WHERE `PlaceID` = ".$placeid;
		return  $this->_db->query($sql) !== false;
	}

	public function Dispose()
	{
		
	}
}
