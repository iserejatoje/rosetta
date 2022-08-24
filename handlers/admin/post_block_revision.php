<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_edit'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);
	
$blockid = App::$Request->Get['blockid']->Value();
$revision = $this->controls['form']->GetControl('le_revision')->GetTitle();

LibFactory::GetStatic('xml');

$bl = BLFactory::GetInstance('system/blocks');

if ( !($bl->Backup($blockid) && $bl->Restore($blockid, $revision)) )
{
	$OBJECTS['uerror']->AddErrorIndexed('env', ERR_E_ADMIN_UNKNOWN_ERROR);
	return false;
}

Response::Redirect($this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.blocks'. $this->controls['treepath']->GetStateUrl(true, true) );

?>