<?php

	$sql = 'SELECT DISTINCT DATE_FORMAT(a.Date,\'%m.%Y\') as dt FROM '.$this->_config['tables']['article'].' as  a';
	$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ';
	$sql.= ' ON (r.NewsID = a.NewsID AND r.SectionID = '.$this->_env['sectionid'].')';
	$sql.= ' WHERE a.isVisible = 1 ';
	$sql.= ' ORDER BY a.Date DESC';
	$sql.= ' LIMIT 100';	
	$res = $this->_db->query($sql);

	$list['l_y'] = array();
	$list['l_m'] = array();
	$lasrYear = 0;
	$index = 0;
	while ($row = $res->fetch_assoc())
	{
		if(preg_match("@^(\d{2})\.(\d{4})$@",$row['dt'],$dt)) {
			if( $lasrYear != $dt[2] ) {
				$index++;
				$list['l_y'][$index] = array(
					'link' => $dt[2].'/',
					'name' => $dt[2]
				);
				$lasrYear = $dt[2];
				
			}
			
			if ( !isset($list['l_m'][$index]) )
				$list['l_m'][$index] = array();
			
			$list['l_m'][$index][] = array(
				'link' => $dt[2]."/".$dt[1]."/",
				'date' => mktime(0,0,0,intval($dt[1]),1,$dt[2])
			);
		}
	}

	return $list;

?>