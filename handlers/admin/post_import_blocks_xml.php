<?
	if(!$OBJECTS['user']->IsInRole('e_adm_block_import'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
	
	LibFactory::GetStatic('xml2');
	
	// в приоритете поле воода	
	$e = trim($this->controls['form']->GetControl('e_xml')->GetTitle());
	
	if ( empty($e) )
	{
		$e = trim($this->controls['form']->GetControl('f_xml')->GetContents());
	}
	
	$msg = XML2::Validate($e);
	
	$bl = BLFactory::GetInstance('system/blocks');
	
	if($msg !== true)
	{
		$this->controls['form']->GetControl('e_xml')->SetTitle($e);
		$OBJECTS['uerror']->AddErrorIndexed('xml', ERR_E_ADMIN_CUSTOM, $msg);
	}
		
	if($OBJECTS['uerror']->IsError())
		return false;	
	
	$bu = $this->controls['form']->GetControl('cb_backup')->GetChecked();

	if(!$bl->ImportFromXML($e, $bu))
	{
		$OBJECTS['uerror']->AddErrorIndexed('xml', ERR_E_ADMIN_UNKNOWN_ERROR);
		return false;
	}
	
	Response::Redirect($this->GetParentPath());
?>