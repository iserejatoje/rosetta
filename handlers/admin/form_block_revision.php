<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_view'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/blocks');

$blockid = App::$Request->Get['blockid']->Int(0);
$revision = App::$Request->Get['revision']->Int(0);

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));
// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($blockid);
$this->controls['form']->AddItem('Идентификатор раздела', $label);

// Ревизия
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_revision'));
$label->SetTitle($revision);
$this->controls['form']->AddItem('ревизия', $label);

LibFactory::GetStatic('uarray');

$revision_block = $bl->LoadBlock($blockid, $revision);
unset($revision_block['Revision']);
unset($revision_block['Date']);
$current_block = $bl->LoadBlock($blockid);

$_revision_block = UArray::ToLinear($revision_block);
$_current_block = UArray::ToLinear($current_block);

$_added_keys = array_diff_key($_current_block, $_revision_block);
$_deleted_keys = array_diff_key($_revision_block, $_current_block);
$_changed_keys = array_diff_key(array_diff_assoc($_current_block, $_revision_block), $_added_keys);

$added_keys = UArray::FromLinear($_added_keys);
$deleted_keys = UArray::FromLinear($_deleted_keys);
$changed_keys = UArray::FromLinear($_changed_keys);

// Блок
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env'));
$edit->SetMultiline(true);
$edit->SetHeight("350px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($revision_block));
$this->controls['form']->AddItem('Окружение', $edit);

// Изменения
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env_deleter'));
$edit->SetHeight("200px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($deleted_keys));
$this->controls['form']->AddItem('Удаленные элементы', $edit);

$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env_added'));
$edit->SetHeight("200px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($added_keys));
$this->controls['form']->AddItem('Добавленные элементы', $edit);

$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env_changed'));
$edit->SetHeight("200px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($changed_keys));
$this->controls['form']->AddItem('Измененные элементы', $edit);

unset(App::$Request->Get['revision']);

if($OBJECTS['user']->IsInRole('e_adm_block_edit'))
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('back', array('url' => $this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.editblock'. $this->controls['treepath']->GetStateUrl(true, true)));

?>