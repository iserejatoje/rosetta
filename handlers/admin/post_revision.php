<?
	if(!$OBJECTS['user']->IsInRole('e_adm_env_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
	$sectionid = $this->controls['form']->GetControl('idlabel')->GetTitle();
	$revision = $this->controls['form']->GetControl('le_revision')->GetTitle();
	
	LibFactory::GetStatic('xml');
	
	$bl = BLFactory::GetInstance('system/env');

	if(!($bl->Backup($sectionid) && $bl->Restore($sectionid, $revision)))
	{
		$OBJECTS['uerror']->AddErrorIndexed('env', ERR_E_ADMIN_UNKNOWN_ERROR);
		return false;
	}
	
	Response::Redirect($this->GetParentPath());
?>