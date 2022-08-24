<?

if(!$OBJECTS['user']->IsInRole('e_adm_config_view'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/config');

$type = App::$Request->Get['type']->Value();
$id = App::$Request->Get['id']->Value();

$revision = App::$Request->Get['revision']->Int(0);

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));

// Тип
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_type'));
$label->SetTitle($type);
$this->controls['form']->AddItem('Тип', $label);

// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($id);
$this->controls['form']->AddItem('Идентификатор раздела', $label);

// Ревизия
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_revision'));
$label->SetTitle($revision);
$this->controls['form']->AddItem('ревизия', $label);

$revision_config = $bl->LoadConfig($type, $id, $revision);
$current_config = $bl->LoadConfig($type, $id);

LibFactory::GetStatic('uarray');

$_revision_config = UArray::ToLinear($revision_config);
$_current_config = UArray::ToLinear($current_config);

$_added_keys = array_diff_key($_current_config, $_revision_config);
$_deleted_keys = array_diff_key($_revision_config, $_current_config);
$_changed_keys = array_diff_key(array_diff_assoc($_current_config, $_revision_config), $_added_keys);

$added_keys = UArray::FromLinear($_added_keys);
$deleted_keys = UArray::FromLinear($_deleted_keys);
$changed_keys = UArray::FromLinear($_changed_keys);

// Конфиг
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env'));
$edit->SetMultiline(true);
$edit->SetHeight("350px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($revision_config));
$this->controls['form']->AddItem('Конфиг', $edit);

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

if($OBJECTS['user']->IsInRole('e_adm_config_edit'))
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('back', array('url' => $this->GetCurrentPath('env')));

?>