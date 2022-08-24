<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_view'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/blocks');

$id = App::$Request->Get['blockid']->Int(0);

$item = $bl->LoadBlock($id);

// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($item['BlockID']);
$this->controls['form']->AddItem('Идентификатор блока', $label);

// Родитель
$select = ControlFactory::GetInstance('standart/select', null, array('id' => 'parentselect'));
$select->AddItem(0,'- корень -');
$blocks = BlockFactory::GetIterator($this->pathinfo['section']);
foreach ( $blocks as $block )
{
	if ( $block['BlockID'] == $id )
		continue;
		
	$select->AddItem($block['BlockID'], str_repeat('&nbsp;&nbsp;', $block['Level'] + 1).$block['BlockKey']." - ".$block['Name']);
}
$select->SetSelected($item['ParentID']);
$this->controls['form']->AddItem('Родитель', $select);

// Имя
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_name'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'nameedit'));
$edit->SetTitle($item['Name']);
$this->controls['form']->AddItem('Имя', $edit);

// Ключ
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_blockkey'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'blockkeyedit'));
$edit->SetTitle($item['BlockKey']);
$this->controls['form']->AddItem('Ключ', $edit);

// Тип
$select = ControlFactory::GetInstance('standart/select', null, array('id' => 'typeselect'));
foreach ( BL_system_blocks::$Types as $type => $name )
	$select->AddItem($type, $name);
$select->SetSelected($item['Type']);
$this->controls['form']->AddItem('Тип блока', $select);

// Раздел блока
// 2do: тут селект по разделам
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_blocksectionid'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'blocksectionidedit'));
$edit->SetTitle($item['BlockSectionID']);
$this->controls['form']->AddItem('Раздел блока', $edit);

// Шаблон
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'templateedit'));
$edit->SetTitle($item['Template']);
$this->controls['form']->AddItem('Шаблон', $edit);

// Кэш
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_cache'));
$cb->SetChecked($item['Cache'] ? true : false);
$cb->SetTitle('Кэшировать');
$this->controls['form']->AddItem('', $cb);

// Время жизни
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'lifetimeedit'));
$edit->SetTitle($item['Lifetime']);
$this->controls['form']->AddItem('Время жизни кэша', $edit);

// Последний
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_last'));
$cb->SetChecked($item['IsLast'] ? true : false);
$cb->SetTitle('Последний');
$this->controls['form']->AddItem('', $cb);

// Rand
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_rand'));
$cb->SetChecked($item['IsRand'] ? true : false);
$cb->SetTitle('Перемешать дочерние блоки');
$this->controls['form']->AddItem('', $cb);

// Видимый
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_visible'));
$cb->SetChecked($item['IsVisible'] ? true : false);
$cb->SetTitle('Видимый');
$this->controls['form']->AddItem('', $cb);


// Параметры
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_params'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_params'));
$edit->SetMultiline(true);
$edit->SetHeight("150px");
$edit->SetTitle(XML::ToXML($item['params']));
$this->controls['form']->AddItem('Параметры блока', $edit);

// Условия
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_conditions'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_conditions'));
$edit->SetMultiline(true);
$edit->SetHeight("150px");
$edit->SetTitle(XML::ToXML($item['conditions']));
$this->controls['form']->AddItem('Условия', $edit);

// Связи
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_links'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('codemirror/edit', null, array('id' => 'e_links'));
$edit->SetMultiline(true);
$edit->SetHeight("150px");
$edit->SetTitle(XML::ToXML($item['links']));
$this->controls['form']->AddItem('Связи', $edit);

// Создавать резервную копию
$cb = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'cb_backup'));
$cb->SetChecked(true);
$cb->SetTitle('Создать резервную копию');
$this->controls['form']->AddItem('', $cb);

// Резервные копии
$b = $bl->GetBackupRevisions($id);
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
		$r['url'] = $this->params['uri'].$this->bl->GetNodePathByID($this->pathinfo['section']).'.block_revision/?revision='.$r['revision'].'&'.$this->controls['treepath']->GetStateUrl(false, true);
		$r['date'] = date("d.m.Y H:i:s", strtotime($r['date']));
		$list->AddItem($r['revision'], $r);
	}
	
	$this->controls['form']->AddItem('Резервные копии', $list);
}

if($OBJECTS['user']->IsInRole('e_adm_block_edit'))
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('reset');
$this->controls['form']->AddButton('back', array('url' => $this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.blocks'. $this->controls['treepath']->GetStateUrl(true, true)));

?> 