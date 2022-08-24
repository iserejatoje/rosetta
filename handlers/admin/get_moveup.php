<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_edit'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$blockid = App::$Request->Get['blockid']->Int(0);

$bl = BLFactory::GetInstance('system/blocks');
$bl->ReorderBlock($blockid, -1, false);

Response::Redirect($this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.blocks'. $this->controls['treepath']->GetStateUrl(true, true) );

?>