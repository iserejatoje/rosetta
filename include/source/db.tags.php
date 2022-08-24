<?php

function source_db_tags($params) {
	global $OBJECTS;
	
//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';

	if ( $_POST['action'] == 'search_json' ) {
		
		LibFactory::GetMStatic('tags', 'tagsmgr');
		
		$TagsMgr = TagsMgr::getInstance();
		
		$Name = App::$Request->Post['query']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_QUOTES);
		$Limit = App::$Request->Get['limit']->Int(20, Request::UNSIGNED_NUM);

		$filter = array(
			'Name'		=> iconv('UTF-8', 'WINDOWS-1251', $Name),
			'ExactName'	=> false,
			'limit'		=> $Limit,
		);
		
		$list = $TagsMgr->getTags($filter);
//		$json->send(array('status' => 'ok', 'list' => $list));
		$result = array('status' => 'ok', 'list' => $list);
	}
	
//	exit('[]');
	return $result;
}


?>