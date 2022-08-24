<?

Response::NoCache();

if($template === null)
	$template = $this->_config['templates']['login_block'];
	
$messages = $OBJECTS['user']->Plugins->Messages;

$incoming_new = 0;
if(App::$User->IsAuth())
	$incoming_new = $messages->GetNewMessagesCount($filter);

$params['im']['incoming_new'] = $incoming_new;
return $this->RenderBlock($template, $params, null);
?>