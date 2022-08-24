<?

if (!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

Response::NoCache();

$id = App::$Request->Get['id']->Value();

if (!empty($id))
	$OBJECTS['user']->Plugins->Messages->DeleteMessage($id);

if (App::$Request->Get['rurl']->Value(false))
	Response::Redirect(App::$Request->Get['rurl']->Value());
else
	Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['im_messages']['string'].'?folder='.$_GET['folder'].'&p='.$_GET['p']);
