<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();
		
	$html = STPL::Fetch('modules/reviews/list', $this->_get_list());
	
	echo $json->encode(array(
		'status' => 'ok',
		'html' => $html,
	));
	
	exit;