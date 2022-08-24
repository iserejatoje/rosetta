<?
	if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))	
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
		
	$ids = $this->controls['treeform']->GetControl('treelist')->GetSelected();
	
	Response::Redirect($this->GetCurrentPath('move').'ids='.implode(',', $ids));
?>