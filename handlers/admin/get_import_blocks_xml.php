<?
if(!$OBJECTS['user']->IsInRole('e_adm_block_import'))
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
$error = $OBJECTS['uerror']->GetErrorsArray();

// Кодировка страницы, будет select
if(isset($error['xml']))
	$this->controls['form']->GetControl('le_xml')->SetTitle($error['xml']);

$this->SetTitle('Импорт структуры блоков из XML');
return STPL::Fetch('handlers/admin/env',
	array('form' => $this->controls['form'])
);
?>