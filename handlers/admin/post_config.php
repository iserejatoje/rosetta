<?
	if(!$OBJECTS['user']->IsInRole('e_adm_config_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
	$type = $this->controls['form']->GetControl('typelabel')->GetTitle();
	$id = $this->controls['form']->GetControl('idlabel')->GetTitle();
	
	LibFactory::GetStatic('xml');	
	
	$e = $this->controls['form']->GetControl('e_config')->GetTitle();		
	//$e = stripslashes($e);
	$msg = XML::Validate($e);
	
	if($msg !== true)
	{
		$this->controls['form']->GetControl('e_config')->SetTitle($e);
		$OBJECTS['uerror']->AddErrorIndexed('config', ERR_E_ADMIN_CUSTOM, $msg);
	}
	else
		$config = XML::FromXML($e);

	if($OBJECTS['uerror']->IsError())
		return false;	
	
	$bu = $this->controls['form']->GetControl('cb_backup')->GetChecked();
	
	$bl = BLFactory::GetInstance('system/config');

	if(!$bl->SaveConfig($type, $id, $config, $bu))
	{
		$OBJECTS['uerror']->AddErrorIndexed('config', ERR_E_ADMIN_UNKNOWN_ERROR);
		return false;
	}
	
	Response::Redirect($this->GetParentPath());
?>