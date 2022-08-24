<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_import'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$bl = BLFactory::GetInstance('system/blocks');

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));
$this->controls['form']->SetEncType('multipart/form-data');

// Окружение
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_xml'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_xml'));
$edit->SetMultiline(true);
$edit->SetHeight("350px");
$edit->SetTitle('');
$this->controls['form']->AddItem('Структура блоков', $edit);

// Импорт файла
//if($OBJECTS['user']->IsInRole('e_adm_env_import'))
{
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'l_import'));
	$file = ControlFactory::GetInstance('standart/file', null, array('id' => 'f_xml'));
	$this->controls['form']->AddItem('Импорт XML', $file);
}

// Создавать резервную копию
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_backup'));
$cb->SetChecked(true);
$cb->SetTitle('Создать резервную копию');
$this->controls['form']->AddItem('', $cb);
/*
// Резервные копии
$b = $bl->GetBackupRevisions($this->pathinfo['section']);
if(count($b) > 0)
{
	$list = ControlFactory::GetInstance('list/list', null, array('id' => 'l_backups'));
	$list->GetPager()->SetVisible(false);
	$list->SetSortable(false);
	$list->AddColumn("Ревизия", 'revision', array('href' => 'url'));
	$list->AddColumn("Дата", 'date', array('href' => 'url'));
	$list->SetWidth("300px");

	foreach($b as $r)
	{
		$r['url'] = $this->params['uri'].$this->bl->GetNodePathByID($this->pathinfo['section']).'.revision/?revision='.$r['revision'].'&'.$this->controls['treepath']->GetStateUrl(false, true);
		$r['date'] = date("d.m.Y H:i:s", strtotime($r['date']));
		$list->AddItem($r['revision'], $r);
	}
	
	$this->controls['form']->AddItem('Резервные копии', $list);
}*/

$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('reset');
$this->controls['form']->AddButton('back', array('url' => $this->GetParentPath()));

?>