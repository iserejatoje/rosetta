<?php

function source_db_words($params)
{
	global $CONFIG,  $OBJECTS;

	$result = array(
		'Word' => '',
		'WordID' => 0,
	);

	$params['siteid'] = intval($params['siteid']);
	if ($params['siteid'] <= 0)
		return $result;

	if (($config = ModuleFactory::GetConfigById('section', 72)) === null)
		return $result;

	
	LibFactory::GetStatic('cache');
	$cache = new Cache();
	$cache->Init('memcache', 'source_db_words');

	$cacheid = 'words_list';
	$words = $cache->get($cacheid);
	if ($words === false)
	{
	    $db = DBFactory::GetInstance('dpsearch');

	    $words = array();
	    $sql = "SELECT w.WordID, w.Word, w.Priority, r.SiteID FROM ".$config['tables']['words']." w";
	    $sql.= " INNER JOIN ".$config['tables']['words_ref']." r ON (w.WordID=r.WordID)";

	    $res = $db->query($sql);
	    while ($row = $res->fetch_assoc())
	    {
		$words[$row['SiteID']][] = array(
		    'WordID'	=> $row['WordID'],
		    'Word'	=> $row['Word'],
		    'Priority'	=> $row['Priority'],
		);
	    }

	    $cache->set($cacheid, $words, 0);
	}

	if (!isset($words[$params['siteid']]))
	    return $result;

	$pl = array();
	foreach ($words[$params['siteid']] as $v)
	{
	    $v['Priority'] = intval($v['Priority']);
	   
	    if (!empty($pl))
		    $pl[$v['Priority']] = array_sum(array_keys($pl)) + $v['Priority'];
	    else
		    $pl[$v['Priority']] = $v['Priority'];
	 
	}

	$rand = mt_rand(0, end($pl));
	$Priority = key($pl);
	foreach($pl as $k => $s)
		if ($rand <= $s)
		{
			$Priority = $k;
			break ;
		}

	$words_by_priority = array();
	foreach ($words[$params['siteid']] as $k => $v)	  
	    if ($v['Priority'] == $Priority)	    
		$words_by_priority[] = array(
			'Word' => $v['Word'],
			'WordID' => $v['WordID'],
		    );

	shuffle($words_by_priority);
	$result = current($words_by_priority);
	
	LibFactory::GetStatic('statincrement');

	StatIncrement::Log(
		$config['db'], $config['tables']['words'],
		'Views', 'WordID', $result['WordID']
	);
	
	return $result;
	


	/*$db = DBFactory::GetInstance('dpsearch');

	$sql = 'SELECT Priority FROM '.$config['tables']['words_ref'];
	$sql.= ' WHERE SiteID = '.$params['siteid'];
	$sql.= ' GROUP by Priority';

	$pl = array();
	$res = $db->query($sql);
	if (!$res || !$res->num_rows) {
		return array(
			'Word' => '',
			'WordID' => 0,
		);
	}

	while(false != ($row = $res->fetch_row())) {
		if (!empty($pl))
			$pl[$row[0]] = array_sum(array_keys($pl))+(int) $row[0];
		else
			$pl[$row[0]] = (int) $row[0];
	}

	$rand = mt_rand(0, end($pl));
	$Priority = key($pl);
	foreach($pl as $k => $s) {
		if ($rand <= $s) {
			$Priority = $k;
			break ;
		}
	}

	$sql = 'SELECT w.WordID, w.Word FROM '.$config['tables']['words_ref'].' r ';
	$sql.= ' INNER JOIN '.$config['tables']['words'].' w ON(w.WordID = r.WordID) ';
	$sql.= ' WHERE r.SiteID = '.$params['siteid'];
	$sql.= ' AND r.Priority = '.$Priority.' ORDER by RAND() LIMIT 1';

	$res = $db->query($sql);
	$result = $res->fetch_assoc();

	LibFactory::GetStatic('statincrement');

	StatIncrement::Log(
		$config['db'], $config['tables']['words'],
		'Views', 'WordID', $result['WordID']
	);

	return $result;*/
}

?>