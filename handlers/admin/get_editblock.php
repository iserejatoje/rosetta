<?
$error = $OBJECTS['uerror']->GetErrorsArray();

if(isset($error['name']))
	$this->controls['form']->GetControl('le_name')->SetTitle($error['name']);
	
if(isset($error['blockkey']))
	$this->controls['form']->GetControl('le_blockkey')->SetTitle($error['blockkey']);

if(isset($error['blocksectionid']))
	$this->controls['form']->GetControl('le_blocksectionid')->SetTitle($error['blocksectionid']);

if(isset($error['type']))
	$this->controls['form']->GetControl('le_type')->SetTitle($error['type']);

$this->SetTitle('Редактирование блока');
return STPL::Fetch('handlers/admin/block',
	array('form' => $this->controls['form'])
);
?>