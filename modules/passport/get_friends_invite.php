<?

if (  App::$Request->Get['rtype']->Value() != 'ajax' && !$OBJECTS['user']->IsAuth() ) 
	$this->redirect_not_authorized();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Добавление друга');
	
if (  App::$Request->Get['rtype']->Value() != 'ajax')
	return $this->_Get_Friends_Invite();
	
Response::NoCache();

if($template === null)
	$template = $this->_config['templates']['friends_ajax_invite'];

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';
	
if ( !$OBJECTS['user']->IsAuth() ) {
	$template = $this->_config['templates']['ssections']['login_ajax'];
	$response = array(
		'status' => 'login', 
		'data' => $this->RenderBlock($template, null, array($this, '_Get_Login'))
	);
} else 
	$response = array(
		'status' => 'ok', 
		'data' => $this->RenderBlock($template, null, array($this, '_Get_Friends_Invite'))
	);

echo $json->encode( $response );
exit();

?>