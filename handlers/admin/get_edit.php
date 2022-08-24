<?

if(!App::$User->IsInRole('e_adm_execute_users') && !App::$User->IsInRole('e_adm_execute_section')) {
    Response::Redirect('/admin/');
}

$error = $OBJECTS['uerror']->GetErrorsArray();

if(isset($error['name']))
	$this->controls['form']->GetControl('le_name')->SetTitle($error['name']);

if(isset($error['path']))
	$this->controls['form']->GetControl('le_path')->SetTitle($error['path']);

// Тип, тут селект будет
if(isset($error['type']))
	$this->controls['form']->GetControl('le_type')->SetTitle($error['type']);

// Регион
if(isset($error['regions']))
	$this->controls['form']->GetControl('le_regions')->SetTitle($error['regions']);

// Кодировка страницы, будет select
if(isset($error['encoding']))
	$this->controls['form']->GetControl('le_eencoding')->SetTitle($error['encoding']);

$this->SetTitle('Редактирование раздела');

return STPL::Fetch('handlers/admin/edit',
	array('form' => $this->controls['form'])
);
?>