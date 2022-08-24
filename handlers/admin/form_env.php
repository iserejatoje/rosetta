<?

if(!$OBJECTS['user']->IsInRole('e_adm_env_view'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$bl = BLFactory::GetInstance('system/env');

$item = STreeMgr::GetNodeByID($this->pathinfo['section']);

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));
$this->controls['form']->SetEncType('multipart/form-data');
// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($item->ID);
$this->controls['form']->AddItem('Идентификатор раздела', $label);

// Название
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_name'));
$label->SetTitle($item->Name);
$this->controls['form']->AddItem('Название', $label);

// Окружение
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_env'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_env'));
$edit->SetMultiline(true);
$edit->SetHeight("350px");
$edit->SetTitle(XML::ToXML($bl->LoadEnv($this->pathinfo['section'])));
$this->controls['form']->AddItem('Окружение', $edit);

/*
// Импорт файла
if($OBJECTS['user']->IsInRole('e_adm_env_import'))
{
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'l_import'));
	$file = ControlFactory::GetInstance('standart/file', null, array('id' => 'f_xml'));
	$this->controls['form']->AddItem('Импорт XML', $file);
}

// Ссылка на XML
if($OBJECTS['user']->IsInRole('e_adm_env_export'))
{
	$xml_url = 'http://'. $CONFIG['env']['site']['domain'] . $this->params['uri'] . $this->baseurl.$this->bl->GetNodePathByID($sectionid) .'.env_xml/?id='. $item['id'];
	$export = ControlFactory::GetInstance('standart/label', null, array('id' => 'l_xml'));
	$export->SetTitle('<a href="'. $xml_url .'">'. $xml_url .'</a>');
	$this->controls['form']->AddItem('Ссылка на XML', $export);
} */

// Создавать резервную копию
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_backup'));
$cb->SetChecked(true);
$cb->SetTitle('Создать резервную копию');
$this->controls['form']->AddItem('', $cb);

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
}

if($OBJECTS['user']->IsInRole('e_adm_env_edit'))
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('reset');
$this->controls['form']->AddButton('back', array('url' => $this->GetParentPath()));

?>