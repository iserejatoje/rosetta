<?
if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))	
	Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
$this->SetTitle('Перемещение разделов');
return STPL::Fetch('handlers/admin/move',
	array('form' => $this->controls['form'])
);
?>