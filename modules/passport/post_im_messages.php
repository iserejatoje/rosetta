<?

if (!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$ids = App::$Request->Post['ids']->AsArray(array());
if (count($ids) > 0)
{
	switch (App::$Request->Post['act']->Value())
	{
		case 'make_read':
			$OBJECTS['user']->Plugins->Messages->MakeRead(implode(',', $ids));
			//PUsersMgr::$db->call_free("MessagesSetIsNew", "isi", $OBJECTS['user']->ID, implode(',', $ids), 0);
			break;
		case 'make_unread':
			$OBJECTS['user']->Plugins->Messages->MakeRead(implode(',', $ids), false);
			//PUsersMgr::$db->call_free("MessagesSetIsNew", "isi", $OBJECTS['user']->ID, implode(',', $ids), 1);
			break;
		case 'delete':
			$OBJECTS['user']->Plugins->Messages->DeleteMessage(implode(',', $ids));
			//PUsersMgr::$db->call_free("MessagesDelete", "is", $OBJECTS['user']->ID, implode(',', $ids));
			break;
	}
}

if (isset($_POST['rurl']))
	Response::Redirect($_POST['rurl']);
else
	Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['im_messages']['string'].'?folder='.App::$Request->Post['folder']->Int(1, Request::UNSIGNED_NUM).'&p='.App::$Request->Post['p']->Int(1, Request::UNSIGNED_NUM));
