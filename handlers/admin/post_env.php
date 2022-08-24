<?
	if(!$OBJECTS['user']->IsInRole('e_adm_env_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);

	$sectionid = $this->controls['form']->GetControl('idlabel')->GetTitle();
	
	LibFactory::GetStatic('xml');
	
	$e = $this->controls['form']->GetControl('e_env')->GetTitle();
	
	$e = stripslashes($e);
	
	$msg = XML::Validate($e);
	
	$bl = BLFactory::GetInstance('system/env');
	
	if($msg !== true)
	{
		$this->controls['form']->GetControl('e_env')->SetTitle($e);
		$OBJECTS['uerror']->AddErrorIndexed('env', ERR_E_ADMIN_CUSTOM, $msg);
	}
	else
	{
		$env = XML::FromXML($e);
	}
		
	if($OBJECTS['uerror']->IsError())
		return false;	
	
	$bu = $this->controls['form']->GetControl('cb_backup')->GetChecked();

	if(!$bl->SaveEnv($sectionid, $env, $bu))
	{
		$OBJECTS['uerror']->AddErrorIndexed('env', ERR_E_ADMIN_UNKNOWN_ERROR);
		return false;
	}
	
	Response::Redirect($this->GetParentPath());
?>