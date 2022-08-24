<?

//if(!$OBJECTS['user']->IsInRole('e_adm_sections_view') && !$OBJECTS['user']->IsInRole('e_adm_sections_header_view'))
//	Response::Status(403, RS_SENDPAGE | RS_EXIT);

if($this->pathinfo['action'] == 'new')
	$item = $this->bl->GetNewNode();
else
{
	$item = STreeMgr::GetNodeByID($this->pathinfo['section'])->ToArray();
}

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));
// Идентификатор
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle($item['id']);
$this->controls['form']->AddItem('Идентификатор раздела', $label);

// Название
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_name'));
$this->controls['form']->AddItem('', $label);
$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'nameedit'));
$edit->SetTitle($item['name']);
$this->controls['form']->AddItem('Название', $edit);

//if ( $OBJECTS['user']->IsInRole('e_adm_sections_view') )
if (1)
{
	// Путь
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_path'));
	$this->controls['form']->AddItem('', $label);
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'pathedit'));
	$edit->SetTitle($item['path']);
	$this->controls['form']->AddItem('Путь', $edit);

	// Модуль, тут по идее надо селект и перебрать все доступные модули
	/*$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'modulesselect'));
	LibFactory::GetStatic('admin');
	$items = $this->bl->GetModules();
	foreach($items as $i)
	{
		$edit->AddItem($i, $i, ($i == $item['module']));
	}
	$this->controls['form']->AddItem('Модуль', $edit);*/
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'moduleedit'));
	$edit->SetTitle($item['module']);
	$this->controls['form']->AddItem('Модуль', $edit);


	// Тип
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_type'));
	$this->controls['form']->AddItem('', $label);
	$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'typeselect'));
	$items = $this->bl->GetTypes();
	foreach($items as $k=>$i)
	{
		$edit->AddItem($k, $i, ($k == $item['type']));
	}
	$this->controls['form']->AddItem('Тип', $edit);

	// Идентификатор для типа, свободный ввод пока
	//$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'typeidedit'));
	//$edit->SetTitle($item['t_id']);
	//$this->controls['form']->AddItem('Идентификатор типа', $edit);

	// Регион
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_regions'));
	$this->controls['form']->AddItem('', $label);
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'regionedit'));
	$edit->SetTitle($item['regions']);
	$this->controls['form']->AddItem('Регион', $edit);

	// Видиомсть
	$edit = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'visiblecb'));
	$edit->SetChecked($item['visible']==1);
	$edit->SetTitle('видимый');
	$this->controls['form']->AddItem('', $edit);

	// Удален
	$edit = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'deletedcb'));
	$edit->SetChecked($item['deleted']==1);
	$edit->SetTitle('удален');
	$this->controls['form']->AddItem('', $edit);

	// Дополнительные параметры
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'paramsedit'));
	$edit->SetMultiline(true);
	$edit->SetTitle($item['params']);
	$this->controls['form']->AddItem('Дополнительные параметры', $edit);

	// Только для админки
	$edit = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'restrictedcb'));
	$edit->SetChecked($item['restricted']==1);
	$edit->SetTitle('проверять права использования');
	$this->controls['form']->AddItem('', $edit);

	// Титульный сайт региона, устаревший
	$edit = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'istitlecb'));
	$edit->SetChecked($item['istitle']==1);
	$edit->SetTitle('титульный сайт региона');
	$this->controls['form']->AddItem('', $edit);

	// Использовать HTTPS
	$edit = ControlFactory::GetInstance('standart/checkbox', null, array('id' => 'sslcb'));
	$edit->SetChecked($item['ssl']==1);
	$edit->SetTitle('использовать HTTPS');
	$this->controls['form']->AddItem('', $edit);

	// Кодировка страницы, будет select
	$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'le_eencoding'));
	$this->controls['form']->AddItem('', $label);
	$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'eencodingselect'));
	$items = $this->bl->GetEncodings();
	foreach($items as $i)
	{
		$edit->AddItem($i, $i, ($i == $item['external_encoding']));
	}
	$this->controls['form']->AddItem('Кодировка страницы', $edit);

	// порядок сортировки (0 - титульный региона), пока едит, в будущем может будет spin
	//$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'ordedit'));
	//$edit->SetTitle($item['ord']);
	//$this->controls['form']->AddItem('Порядок сортировки', $edit);
}


//if ( $OBJECTS['user']->IsInRole('e_adm_sections_header_view') )
if (1)
{
	// Действие
	$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'header_title_action_select'));
	$edit->AddItem(0, 'добавить в начало название раздела', (0 == $item['header_title_action']));
	$edit->AddItem(1, 'добавить в начало', (1 == $item['header_title_action']));
	$edit->AddItem(2, 'добавить в конец', (2 == $item['header_title_action']));
	$edit->AddItem(3, 'заменить', (3 == $item['header_title_action']));
	$this->controls['form']->AddItem('Title', $edit);

	// Title
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'header_title_edit'));
	$edit->SetTitle($item['header_title']);
	$this->controls['form']->AddItem('', $edit);

	// Действие
	$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'header_keywords_action_select'));
	$edit->AddItem(0, 'не указано', (0 == $item['header_keywords_action']));
	$edit->AddItem(1, 'добавить в начало', (1 == $item['header_keywords_action']));
	$edit->AddItem(2, 'добавить в конец', (2 == $item['header_keywords_action']));
	$edit->AddItem(3, 'заменить', (3 == $item['header_keywords_action']));
	$this->controls['form']->AddItem('Keywords', $edit);

	// Ключевые слова
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'header_keywords_edit'));
	$edit->SetTitle($item['header_keywords']);
	$this->controls['form']->AddItem('', $edit);

	// Действие
	$edit = ControlFactory::GetInstance('standart/select', null, array('id' => 'header_description_action_select'));
	$edit->AddItem(0, 'не указано', (0 == $item['header_description_action']));
	$edit->AddItem(1, 'добавить в начало', (1 == $item['header_description_action']));
	$edit->AddItem(2, 'добавить в конец', (2 == $item['header_description_action']));
	$edit->AddItem(3, 'заменить', (3 == $item['header_description_action']));
	$this->controls['form']->AddItem('Description', $edit);

	// Описание
	$edit = ControlFactory::GetInstance('standart/edit', null, array('id' => 'header_description_edit'));
	$edit->SetTitle($item['header_description']);
	$this->controls['form']->AddItem('', $edit);
}

/*if( 
	( $this->pathinfo['action'] == 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_create') ) ||
	( $this->pathinfo['action'] != 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_edit') )
	)*/
	$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('reset');
if($this->pathinfo['action'] == 'new')
	$this->controls['form']->AddButton('back', array('url' => $this->GetCurrentPath()));
else
	$this->controls['form']->AddButton('back', array('url' => $this->GetParentPath()));

?>
