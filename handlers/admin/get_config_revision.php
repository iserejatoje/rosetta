<?
if(!$OBJECTS['user']->IsInRole('e_adm_config_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);

$error = $OBJECTS['uerror']->GetErrorsArray();

$this->SetTitle('Восстановление резервной копии');

return STPL::Fetch('handlers/admin/revision',
	array('form' => $this->controls['form'])
);
?>