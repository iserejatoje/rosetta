<?php

/**
 * @author Евгений Овчинников
 * @version 1.0
 */
class SphinxConfig
{
	static public function GetIndexList($params = array()) {
		global $CONFIG;

		$indexList = array();
		list($params['db'], $params['table']) = explode('.', $params['source']);
		$db = DBFactory::GetInstance($params['db']);
		
		$sql = 'SELECT `Index`, `SectionID` FROM '.$params['table'].' WHERE ';
		$sql.= ' RegionID != 0';

		if ( isset($params['RegionID']) && is_numeric($params['RegionID']) )
			$sql.= ' AND RegionID ='.(int) $params['RegionID'];
		
		if ( isset($params['SiteID']) && is_numeric($params['SiteID']) )
			$sql.= ' AND SiteID ='.(int) $params['SiteID'];
		
		if ( isset($params['SectionID']) && is_numeric($params['SectionID']) )
			$sql.= ' AND SectionID ='.(int) $params['SectionID'];

		if ( isset($params['Type']) && is_numeric($params['Type']) && $params['Type'] > 0 )
			$sql.= ' AND Type ='.(int) $params['Type'];

		$res = $db->query($sql);
	
		if ( !$res || !$res->num_rows )
			return $indexList;
	
		$page['form']['arr_c'] = array();
		while (false != ($row = $res->fetch_row())) {
			$n = STreeMgr::GetNodeByID($row[1]);
			if ($n === null || (is_array($params['denyModules']) && in_array($n->Module, $params['denyModules'])))
				continue ;

			$indexList[$row[0]] = '';
		}
		return array_keys($indexList);
	}

}
?>