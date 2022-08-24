<?php

function source_db_place($params) {
	global $OBJECTS;
	
//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';

	LibFactory::GetMStatic('place', 'placesimplemgr');
	if ( $_POST['action'] == 'adduser' ) {
		
		if ( !$OBJECTS['user']->IsAuth() )
			exit;

		LibFactory::GetMStatic('place', 'placesimplemgr');
		$sPlace = PlaceSimpleMgr::getInstance()->GetPlace($_POST['id']);
		if ( $sPlace === null )
			exit;

		$res = $sPlace->AddUser($OBJECTS['user']->ID, $_POST['type'], array());		
		// exit($json->encode(array('status' => 'ok')));
		return array('status' => 'ok');
		
	} else if ( $_POST['action'] == 'search' ) {
	
		LibFactory::GetMStatic('place', 'placesimplemgr');

		$query = str_replace("%", "", $_POST['query']);
		$query = trim($query,"\n ");
		
		$type = (int) $_POST['type'];
		$city = $_POST['city'];
		
		if ( empty($query) )
			exit('');

		if ( !isset(PlaceSimpleMgr::$types_range[$type]) )
			exit('');

		$cl = LibFactory::GetInstance('sphinx_api');

		$cl->SetWeights ( array ( 1, 1, 1, 1, 1 ) );
		$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
		$cl->SetArrayResult ( true );
		$cl->SetLimits(0, 15);
		$cl->SetFilter('typeid', PlaceSimpleMgr::$types_range[$type], false);

		$city = $cl->EscapeString($city);
		
		if ( trim($city) == '' )
			exit('');
		
		$query = $cl->EscapeString($query);
		$query = implode('* ',explode(' ', $query)).'*';
		$result = $cl->query ('('.$query.') @City "'.$city.'"', 'place_name' );

		if ( $result === false || !is_array($result['matches']) || !sizeof($result['matches']) ) {
			if ($result === false)
				error_log("Search query failed: " . $cl->GetLastError());			
				
			exit('');
		}
		
		foreach ($result['matches'] as &$place) {
			$place = PlaceSimpleMgr::getInstance()->GetPlace($place['id']);
			echo iconv('WINDOWS-1251','UTF-8', html_entity_decode($place->Name))."\t".$place->ID."\n";
		}
		exit('');
	} else if ( $_POST['action'] == 'search_place' ) {
	
		LibFactory::GetMStatic('place', 'placesimplemgr');

		$query = trim(str_replace("%", "", $_POST['query']),"\n ");		
		$type = (int) $_POST['type'];
		$code = $_POST['code'];
		
		if ( empty($query) )
			exit('[]');

		if ( !isset(PlaceSimpleMgr::$types_range[$type]) )
			exit('[]');

		$cl = LibFactory::GetInstance('sphinx_api');

		$cl->SetWeights ( array ( 1, 1, 1, 1, 1 ) );
		
		$cl->SetMatchMode ( SPH_MATCH_PHRASE );
		if ($_POST['match_any'])
			$cl->SetMatchMode ( SPH_MATCH_ANY );
		
		$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
		$cl->SetArrayResult ( true );
		
		$limit = (int) $_POST['limit'];
		if ( $limit <= 0 || $limit > 1000 )
			$limit = 20;

		if (strlen($code) < 22)
			$code .= str_repeat('0', 22-strlen($code));

		//var_dump(PlaceSimpleMgr::$types_range[$type]);
		$cl->SetLimits(0, $limit );
		$cl->SetFilter('typeid', PlaceSimpleMgr::$types_range[$type], false);
		$cl->SetFilter('citycode', array(sprintf("%u", crc32($code))), false);
		
		if ($OBJECTS['user']->ID == 1) {
			//$cl->SetFilter('new', array(1), false);
		} else
			$cl->SetFilter('new', array(0), false);

		if ($_POST['IsVerified'])
			$cl->SetFilter('IsVerified', array(1), false);
		
		$query = $cl->EscapeString($query);
		$query = implode('* ',explode(' ', $query)).'*';
		//$result = $cl->query ('('.$query.') @City "'.$city.'"', 'place_name' );
		//echo $query;
		$result = $cl->query ($query, 'place_name' );

		if ( $result === false || !is_array($result['matches']) || !sizeof($result['matches']) ) {
			if ($result === false)
				error_log("Search query failed: " . $cl->GetLastError());			
				
			exit('[]');
		}
		
		$places = array();
		foreach ($result['matches'] as &$place) {
			$place = PlaceSimpleMgr::getInstance()->GetPlace($place['id']);
			$places[] = array(
				'PlaceID' => $place->ID,
				'Name' => html_entity_decode($place->Name),
			);
		}
//		exit($json->encode($places));
		return $places;
	}
	elseif ($_POST['action'] == 'search_place_position')
	{
		$result = array();
//		include_once ENGINE_PATH.'include/json.php';
//		$json = new Services_JSON();
//		$json->charset = 'WINDOWS-1251';
		
		$query = trim(str_replace("%", "", $_POST['query']),"\n ");	
		$query = iconv('UTF-8', 'Windows-1251', $query);
		if ( empty($query) )
			exit;
		
		
		$limit = (int) $_POST['limit'];
		if ( $limit <= 0 || $limit > 1000 )
			$limit = 20;
		
		$_db = DBFactory::GetInstance('places');
		
		$sql = 'SELECT Position FROM PlaceSimpleRef WHERE Position LIKE \''.addslashes($query).'%\'';
		$sql.= ' LIMIT '.$limit;
		
		$res = $_db->query($sql);
		while(false != ($row = $res->fetch_row()))
		{			
			$result[] = array(
				'Text' => $row[0]
			);
		}
		$result = array_unique($result);
//		exit($json->encode($result));
		return $result;
	}
	elseif ($_POST['action'] == 'searchdouble')
	{
		$result = array();
//		include_once ENGINE_PATH.'include/json.php';
//		$json = new Services_JSON();
//		$json->charset = 'WINDOWS-1251';

		
		if (trim($_POST['text']) == '')
		{
			$result['status'] = 'empty';
//			exit($json->encode($result));
			return $result;
		}		
		LibFactory::GetMStatic('place', 'placesimplemgr');
		
		
		$filter = array(
			'field' => 'Name',
			'flags' => array(
				'TypeID' => array($_POST['type']),
				'IsVisible' => 1,
				'CityCode' => $_POST['city'],
				'IsVerified' => -1,
				'Name' => iconv('UTF-8', 'Windows-1251', trim($_POST['text'])),
			),
			'limit' => 50,
		);
		$places = PlaceSimpleMgr::getInstance()->GetPlaces($filter);
		if (sizeof($places) == 0)
			$result['status'] = 'empty';
		else
		{
			$result['status'] = 'ok';
			
			foreach ($places as $v)
			{
				if ($v['PlaceID'] == $_POST['id'])
					continue;
				$data = array();
				$data['id'] = $v['PlaceID'];
				$data['name'] = html_entity_decode($v['Name']);
				$data['count'] = PlaceSimpleMgr::getInstance()->GetUsersCount($v['PlaceID'], $v['TypeID']);
				
				$result['data'][] = $data;
			}
		}
		
		if ( !sizeof($result['data']) )
			$result['status'] = 'empty';
		
//		exit($json->encode($result));
		return $result;
	}
	else if ( $_POST['action'] == 'search_faculty' ) 
	{	
		$query = trim(str_replace("%", "", $_POST['query']),"\n ");		
		$query = iconv('UTF-8', 'Windows-1251', $query);
		
		if ( empty($query) )
			exit;
		
		$place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place']);
		$list = $place->GetFacultyList($query);
		if ( $list === null )	
			exit;
		
		foreach ($list as $v)
			echo iconv('WINDOWS-1251','UTF-8', html_entity_decode($v['Name']))."\t".$v['FacultyID']."\n";
		exit;
	}
	else if ( $_POST['action'] == 'search_faculty_json' ) 
	{	
		$query = trim(str_replace("%", "", $_POST['query']),"\n ");		
		$query = iconv('UTF-8', 'Windows-1251', $query);
		
		if ( empty($query) )
			exit('[]');
		
		if ( ($place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place'])) === null )
			exit('[]');

		$list = $place->GetFacultyList($query);
		if ( $list === null )	
			exit('[]');
		
		foreach ($list as &$v)
			$v = array(
				'FacultyID' => $v['FacultyID'],
				'Name' => html_entity_decode($v['Name']),
			);
		
//		exit($json->encode($list));
		return $list;
	}
	else if ( $_POST['action'] == 'search_chair' ) 
	{
		$text = str_replace("%", "", $_POST['query']);
		$text = iconv('UTF-8', 'Windows-1251', $text);
		if ( empty($text) )
			exit;

		$place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place']);
		
		$list = $place->GetChairList($_POST['faculty'], $text);
		if ( $list === null )	
			exit;
		
		foreach ($list as $v)
			echo iconv('WINDOWS-1251','UTF-8', html_entity_decode($v['Name']))."\t".$v['KafedraID']."\n";
		exit;
	}
	else if ( $_POST['action'] == 'search_chair_json' ) 
	{
		$query = trim(str_replace("%", "", $_POST['query']),"\n ");		
		$query = iconv('UTF-8', 'Windows-1251', $query);
		
		if ( empty($query) )
			exit('[]');
		
		if ( ($place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place'])) === null )
			exit('[]');

		$list = $place->GetChairList($_POST['faculty'], $query);
		if ( $list === null )	
			exit('[]');
		
		foreach ($list as &$v)
			$v = array(
				'KafedraID' => $v['FacultyID'],
				'Name' => html_entity_decode($v['Name']),
			);
		
//		exit($json->encode($list));
		return $list;
	}
	else if ( $_POST['action'] == 'search_spec' ) 
	{
		$text = str_replace("%", "", $_POST['query']);
		$text = iconv('UTF-8', 'Windows-1251', $text);
		if ( empty($text) )
			exit;
		
		$place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place']);
		
		$list = $place->GetSpecializeList($text);
		if ( $list === null )	
			exit;
		
		foreach ($list as $v)
			echo iconv('WINDOWS-1251','UTF-8', html_entity_decode($v['Name']))."\t".$v['ChairID']."\n";
		exit;
	}
	else if ( $_POST['action'] == 'search_spec_json' ) 
	{
		$query = trim(str_replace("%", "", $_POST['query']),"\n ");		
		$query = iconv('UTF-8', 'Windows-1251', $query);
		
		if ( empty($query) )
			exit('[]');
		
		if ( ($place = PlaceSimpleMgr::getInstance()->GetPlace($_POST['place'])) === null )
			exit('[]');
		
		$list = $place->GetSpecializeList($query);
		if ( $list === null )	
			exit('[]');
			
		foreach ($list as &$v)
			$v = array(
				'ChairID' => $v['ChairID'],
				'Name' => html_entity_decode($v['Name']),
			);
		
//		exit($json->encode($list));
		return $list;
	}
}


?>