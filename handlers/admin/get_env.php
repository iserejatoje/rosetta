<?
$error = $OBJECTS['uerror']->GetErrorsArray();

// Кодировка страницы, будет select
if(isset($error['env']))
	$this->controls['form']->GetControl('le_env')->SetTitle($error['env']);

$this->SetTitle('Редактирование окружения');
return STPL::Fetch('handlers/admin/env',
	array('form' => $this->controls['form'])
);
?>