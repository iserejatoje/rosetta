<?
if(!$OBJECTS['user']->IsInRole('e_adm_block_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);

$error = $OBJECTS['uerror']->GetErrorsArray();

$this->SetTitle('Востановление резвервной копии');
return STPL::Fetch('handlers/admin/revision',
	array('form' => $this->controls['form'])
);
?>