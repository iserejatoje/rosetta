<?
if(!$OBJECTS['user']->IsInRole('e_adm_config_edit'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
$error = $OBJECTS['uerror']->GetErrorsArray();

if(isset($error['config']))
	$this->controls['form']->GetControl('le_config')->SetTitle($error['config']);

$this->SetTitle('Редактирование конфига');
return STPL::Fetch('handlers/admin/config',
	array('form' => $this->controls['form'])
);
?>
