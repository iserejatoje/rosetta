<?
if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))	
	Response::Status(403, RS_SENDPAGE | RS_EXIT);
	
$ids = explode(',', $this->controls['form']->GetControl('ids')->GetTitle());
$parent = $this->controls['form']->GetControl('to')->GetSelected();
$afac = $this->controls['form']->GetControl('afteraction')->GetSelected();

foreach($ids as $id)
{
	// проверим, можно ли переместить
	$np = STreeMgr::GetNodeByID($parent);
	do
	{
		if($np->ID == $id)
		{
			break 2; // выходим с цикла совсем, т.к. перемещаем разделы только с одного уровня
					 // но обработаем на каждой итерации, вдруг кто что напартачит в урле
		}
		$np = $np->Parent;
	}while($np !== null);
	$n = STreeMgr::GetNodeByID($id);
	$n->ParentID = $parent;
	$n->Store();
}

$path = '';
$afac = array_shift($afac);
if($afac == 'destination')
{
	$path = $this->params['uri'].$this->bl->GetNodePathByID($parent);
	
	$path.= $this->controls['treepath']->GetStateUrl(true, true);
}
else
{
	$path = $this->GetCurrentPath();
}

Response::Redirect($path);
?>