<?
	if(!$OBJECTS['user']->IsInRole('e_adm_config_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
	$type = App::$Request->Get['type']->Value();
	$id = App::$Request->Get['id']->Value();
	$revision = $this->controls['form']->GetControl('le_revision')->GetTitle();
	
	LibFactory::GetStatic('xml');
	
	$bl = BLFactory::GetInstance('system/config');

	if ( !($bl->Backup($type, $id) && $bl->Restore($type, $id, $revision)) )
	{
		$OBJECTS['uerror']->AddErrorIndexed('env', ERR_E_ADMIN_UNKNOWN_ERROR);
		return false;
	}
	
	Response::Redirect($this->GetParentPath());
?>