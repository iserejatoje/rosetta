<?

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/env');

$item = $this->bl->GetNode($this->pathinfo['section']);

$revision = App::$Request->Get['revision']->Int(0);

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));
// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($item['id']);
$this->controls['form']->AddItem('Идентификатор раздела', $label);

// Название
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_name'));
$label->SetTitle($item['name']);
$this->controls['form']->AddItem('Название', $label);

// Ревизия
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_revision'));
$label->SetTitle($revision);
$this->controls['form']->AddItem('ревизия', $label);

$revision_env = $bl->LoadEnv($this->pathinfo['section'], $revision);
$current_env = $bl->LoadEnv($this->pathinfo['section']);

$added_keys = array_diff_key($current_env, $revision_env);
$deleted_keys = array_diff_key($revision_env, $current_env);
$changed_keys = array_diff_key(array_diff_assoc($current_env, $revision_env), $added_keys);

// Окружение
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env'));
$edit->SetMultiline(true);
$edit->SetHeight("350px");
$edit->SetReadOnly(true);
$edit->SetTitle(XML::ToXML($revision_env));
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

if($OBJECTS['user']->IsInRole('e_adm_env_edit'))
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('back', array('url' => $this->GetCurrentPath('env')));

?>