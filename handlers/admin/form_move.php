<?
if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))	
	Response::Status(403, RS_SENDPAGE | RS_EXIT);
	
$ids = App::$Request->Get['ids']->Value();
unset(App::$Request->Get['ids']);	// забрали и удалили

$this->controls['form'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'form'));

// список разделов
$ids = explode(',', $ids);
$idss = array();
$names = array();
foreach($ids as $id)
{
	$n = STreeMgr::GetNodeByID($id);
	if($n !== null)
	{
		$idss[] = $id;
		$name = '';
		do
		{
			$name = ' &gt; '.$n->Name.$name;
			$n = $n->Parent;
		} while($n !== null);
		$names[] = $name;
	}
}

// Скрытый список разделов
$label = ControlFactory::GetInstance('standart/hidden', null, array('id' => 'ids'));
$label->SetTitle(implode(",", $idss));
$this->controls['form']->AddItem('', $label);


// Разделы
$label = ControlFactory::GetInstance('standart/label', null, array('id' => 'idlabel'));
$label->SetTitle(implode("<br>", $names));
$this->controls['form']->AddItem('Разделы для перемещения', $label);

// в настоящий момент нет контрола для выбора раздела, реализовано все через опу, т.к. контролы с ajax не работают
// Куда перемещаем
$label = ControlFactory::GetInstance('crutches/mselect', null, array('id' => 'to'));
$label->SetUrl('/service/admin/.tree_ajax');	// источник данных
$this->controls['form']->AddItem('Переместить в', $label);

// куда перейти
$label = ControlFactory::GetInstance('standart/select', null, array('id' => 'afteraction'));
$label->SetTemplate('controls/standart/select/radiobox');
$label->AddItem('destination', 'В раздел назначения', true);
$label->AddItem('source', 'В раздел источника', false);
$label->SetType('single');
$this->controls['form']->AddItem('Перейти в', $label);

$this->controls['form']->AddButton('submit');
$this->controls['form']->AddButton('back', array('url' => $this->GetCurrentPath()));
?>