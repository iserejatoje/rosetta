<?

// проверка прав по разделам

$OBJECTS['user']->SectionID = $this->pathinfo['section'];
if(!$OBJECTS['user']->IsInRole('e_adm_execute_section'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$this->module = ModuleFactory::GetAdminInstance($this->pathinfo['section'], array(
	'section' => $this->pathinfo['section'],
	'path' => $this->pathinfo['path']
	));
if($this->module !== null)
	$this->module->Action(array());
?>