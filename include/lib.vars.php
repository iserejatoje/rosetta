<?php

LibFactory::GetStatic('textutil');
class Variables
{
	private static $db = null;

	public static function Replace($content, $regid = null, $vars = null) {
	
		if ( empty($content) )
			return (array) $content;
	
		$content = (array) $content;

		if ( $vars === null ) {
			$vars = array();
			foreach ( $content as &$text) {
			
				if ( empty($text) )
					continue ;
			
				$text = (string) $text;
				$vars = array_merge($vars, self::Search($text, false));
			}
		}
		if ( !is_array($vars) || !sizeof($vars) )
			return $content;
			
		$sql = 'SELECT * FROM vars_group';
		$sql .= ' WHERE RegionID IN(0,'.(int) $regid.') AND ';
		$sql .= ' Name IN (\''.implode('\', \'',$vars).'\') ';
		
		$res = self::query($sql);
		if ( !$res || !$res->num_rows )
			return $content;
		
		$varValues = array();
		while (false != ($row = $res->fetch_assoc())) {
			if ( !isset($varValues['/{'.$row['Name'].'(\|([^}{]+))?}/i']) )
				$varValues['/{'.$row['Name'].'(\|([^}{]+))?}/i'] = $row['Value'];
			elseif ( $row['RegionID'] )
				$varValues['/{'.$row['Name'].'(\|([^}{]+))?}/i'] = $row['Value'];
		}

		
		$varValues['/ /'] = ' ';
		foreach ( $content as &$text) {
		
			if ( empty($text) )
				continue ;
				
			$text = str_replace(
				array('%7B','%7D'),
				array('{', '}'),
				$text
			);
			$text = preg_replace(array_keys($varValues), $varValues, $text);
		}
		
		return $content;
	}
	
	public static function Modify($content) {
		
		$vars = array();
		$replace = array();		
		$matchs = array();
		if ( !preg_match_all('/{([^}{]+?)(\|([^}{]+))?}/', (string) $content, $matchs, PREG_SET_ORDER) )
			return array($content, $vars);
		
		foreach ( $matchs as $match ) {
			list(, $var, , $desc) = $match;
			
			$old_var = $var;
			$var = self::Convert($var);

			$replace['/{'.preg_replace('/[]\\\\^$.|?*+(){}[]/', '\\\\$0',$old_var).'(\|([^}{]+))?}/i'] = '{'.$var.'}';
			$vars[strtolower($var)] = trim($desc);
		}
		
		return array(preg_replace(array_keys($replace), $replace, $content), $vars);
	}
	
	public static function Convert($name) {
		$name = TextUtil::Translit($name);
		$name = preg_replace("/[^a-z0-9_]/i", "_", $name);
		$name = strtolower(trim($name,' _'));
		
		return $name;
	}
	
	public static function Search($content, $with_desc = true) {
			
		$matchs = array();
		if ( !preg_match_all('/{([^}{]+?)(\|([^}{]+))?}/', (string) $content, $matchs, PREG_SET_ORDER) )
			return array();

		foreach ( $matchs as $match ) {
			list(, $var, , $desc) = $match;

			$var = self::Convert($var);
			if ( $with_desc === true )
				$vars[$var] = trim($desc);
			else
				$vars[] = $var;
		}
		if ( $with_desc === false )
			$vars = array_unique($vars);
		return $vars;
	}

	public static function Get($var) {
	
		if ( empty($var) )
			return null;

		$sql = 'SELECT * FROM vars WHERE ';	
		$sql .= ' Name = \''.addslashes($var).'\'';

		$res = self::query($sql);
		if ( $res && $res->num_rows )
			return $res->fetch_assoc();

		return null;
	}
	
	public static function Save($vars, $parse = false) {
	
		if ( $parse === true && is_string($vars) )
			$vars = self::Search($vars);

		if ( !is_array($vars) || !sizeof($vars) )
			return false;

		$vars = (array) $vars;			
		foreach($vars as $var => $desc) {
			$sql = 'REPLACE INTO vars SET ';	
			$sql .= ' Name = \''.addslashes($var).'\'';
			if ( trim($desc) != '')
				$sql .= ' ,Descr = \''.addslashes($desc).'\'';

			self::query($sql);
		}
		return $vars;
	}
	
	public static function SaveValue($var, $val, $regid = 0) {
	
		if ( empty($var) || trim($val) === '' || $regid < 0 )
			return false;

		$sql = 'REPLACE INTO vars_group SET ';	
		$sql .= ' RegionID = '.(int) $regid;
		$sql .= ' ,Name = \''.addslashes($var).'\'';
		$sql .= ' ,Value = \''.addslashes($val).'\'';

		self::query($sql);

		return $vars;
	}
	
	public static function Delete($vars) {

		if ( !is_array($vars) )
			return false;
			
		if ( !sizeof($vars) )
			return true;
			
		foreach($vars as &$var) {
			$var = addslashes($var);
		}
		
		$sql = 'DELETE FROM vars WHERE ';	
		$sql .= ' Name IN(\''.implode('\',\'', $vars).'\')';

		if ( false != self::query($sql) ) {
		
			$sql = 'DELETE FROM vars_group WHERE ';
			$sql .= 'Name NOT IN(SELECT Name FROM vars)';
			self::query($sql);
			return true;
		}
		return false;
	}
	
	public static function GetRefsCountByRegion(array $vars, $regid = null) {
		
		$result = array();
		if ( empty($vars) || (is_array($vars) && !sizeof($vars)) )
			return $result;
		
		$vars = (array) $vars;
		foreach($vars as &$v)
			$v = addslashes($v);
		
		$sql = 'SELECT RegionID, COUNT(*) FROM vars_group WHERE';
		if ( $regid !== null && is_numeric($regid) && $regid >= 0 )
			$sql .= ' RegionID = '.(int) $regid.' AND ';
		$sql .= ' Name IN(\''.implode('\',\'',$vars).'\')';
		$sql .= ' GROUP by RegionID';

		$res = self::query($sql);
		
		if ( !$res || !$res->num_rows )
			return $result;
			
		while (false != ($row = $res->fetch_row())) {
			$result[$row[0]] = $row[1];
		}
		
		return $result;
	}
	
	public static function GetValuesByRegion($var, $regid = null) {
		
		$result = array();
		if ( empty($var) )
			return $result;
		
		$sql = 'SELECT RegionID, Value FROM vars_group WHERE';
		if ( $regid !== null && is_numeric($regid) && $regid >= 0 )
			$sql .= ' RegionID = '.(int) $regid.' AND ';
		$sql .= ' Name = \''.$var.'\'';
		$res = self::query($sql);
		
		if ( !$res || !$res->num_rows )
			return $result;
			
		while (false != ($row = $res->fetch_row())) {
			$result[$row[0]] = $row[1];
		}
		
		return $result;
	}
	
	public static function GetRefsCount(array $vars, $def = false, $regids = array()) {
		
		$count = 0;
		if ( !sizeof($vars) )
			return $count;
		
		foreach($vars as &$v)
			$v = addslashes($v);
		
		$sql = 'SELECT COUNT(*) FROM vars_group WHERE';
		if ( $def === true )
			$sql .= ' RegionID = 0 AND ';
		
		if ( is_array($regids) && sizeof($regids) ) {
			$regids[] = 0;
			$sql .= ' RegionID IN('.implode(',', $regids).') AND ';
		}
		
		$sql .= ' Name IN(\''.implode('\',\'',$vars).'\')';

		$res = self::query($sql);
		
		if ( $res && $res->num_rows )
			list($count) = $res->fetch_row();
		
		return $count;
	}
	
	public static function GetCount($filter = array(), $byRegion = false) {
		
		if( !empty($filter['name']) )
			$filter['name'] = trim($filter['name']);
		
		if( !empty($filter['descr']) )
			$filter['descr'] = trim($filter['descr']);
		
		$count = 0;	
		if ( $byRegion === true ) {
			$sql = 'SELECT COUNT(*) FROM vars v';
			$sql .= ' INNER JOIN vars_group g ON(g.Name = v.Name) ';
		} else
			$sql = 'SELECT COUNT(*) FROM vars v';
			
		$where = array();
		if( !empty($filter['name']) )
			$where[] = ' v.Name like \'%'.addslashes($filter['name']).'%\'';
		if( !empty($filter['descr']) )
			$where[] = 'v.Desc like \'%'.addslashes($filter['descr']).'%\'';
		if( isset($filter['regid']) && DATA::Is_Number($filter['regid']) )
			$where[] = 'g.RegionID = '.(int)$filter['regid'];
		
		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);
		
		$res = self::query($sql);
		
		if ( $res && $res->num_rows )
			list($count) = $res->fetch_row();
		
		return $count;
	}
	
	public static function GetList($filter = array(), $byRegion = false) {
		
		// Поле для сортировки
		$filter['field'] = strtolower($filter['field']);
		if ( $byRegion === false && !in_array($filter['field'], array('name','descr')) || $byRegion === true && $filter['field'] != 'regionid')
			$filter['field'] = 'Name';
			
		// Порядок сортировки
		$filter['dir'] = strtoupper($filter['dir']);
		if ( $filter['dir'] != 'ASC' && $filter['dir'] != 'DESC' )
			$filter['dir'] = 'ASC';
		
		if( !Data::Is_Number($filter['offset']) )
			$filter['offset'] = 0;

		if( !Data::Is_Number($filter['limit']) )
			$filter['limit'] = 0;
			
		if( !empty($filter['name']) )
			$filter['name'] = trim($filter['name']);
		
		if( !empty($filter['descr']) )
			$filter['descr'] = trim($filter['descr']);
		if( !empty($filter['descr']) )
			$filter['descr'] = trim($filter['descr']);
		
		$list = array();
		
		if ( $byRegion === true ) {
			$sql = 'SELECT v.*, g.RegionID, g.Value FROM vars v';
			$sql .= ' INNER JOIN vars_group g ON(g.Name = v.Name) ';
		} else
			$sql = 'SELECT v.* FROM vars v';
		
		$where = array();
		if( !empty($filter['name']) )
			$where[] = ' v.Name like \'%'.addslashes($filter['name']).'%\'';
		if( !empty($filter['descr']) )
			$where[] = 'v.Desc like \'%'.addslashes($filter['descr']).'%\'';
		if( isset($filter['regid']) && DATA::Is_Number($filter['regid']) )
			$where[] = 'g.RegionID = '.(int)$filter['regid'];
		
		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);
		
		$sql .= ' ORDER by '.$filter['field'].' '.$filter['dir'];
		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}
		
		$res = self::query($sql);
		
		if ( !$res || !$res->num_rows )
			return $list;
			
		while (false != ($var = $res->fetch_assoc()))
			$list[] = $var;
		
		return $list;
	}
	
	public static function GetListByRegion($filter = array()) {
		return self::GetList($filter, true);
	}
	
	public static function GetCountByRegion($filter = array()) {
		return self::GetCount($filter, true);
	}
	
	public static function Exists($name, $ex = null) {
	
		$sql = 'SELECT * FROM vars WHERE Name = \''.self::Convert($name).'\'';
		if ( $ex !== null )
			$sql .= ' AND Name != \''.addslashes($ex).'\'';

		$res = self::query($sql);
		
		return (bool) $res->num_rows;
	}
	
	static function query($sql) {
	
		if ( self::$db === null )
			self::$db = DBFactory::GetInstance('site');
	
		return self::$db->query($sql);
	}
}

?>