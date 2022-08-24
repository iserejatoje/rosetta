<?

if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$id = App::$Request->Get['id']->Int(0);

$bl = BLFactory::GetInstance('system/site');
$bl->ReorderSection($id, 1);

Response::Redirect($this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) . $this->controls['treepath']->GetStateUrl(true, true) );

?>