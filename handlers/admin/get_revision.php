<?
$error = $OBJECTS['uerror']->GetErrorsArray();

$this->SetTitle('Восстановление резервной копии');
return STPL::Fetch('handlers/admin/revision',
	array('form' => $this->controls['form'])
);
?>