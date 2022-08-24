<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_create'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

// родитель
$item['SectionID'] = $this->pathinfo['section'];
$s = $this->controls['form']->GetControl('parentselect')->GetSelected();
$item['ParentID'] = $s[0];

// наименование
$n = $this->controls['form']->GetControl('nameedit')->GetTitle();
if(empty($n))
	$OBJECTS['uerror']->AddErrorIndexed('name', ERR_E_ADMIN_WRONG_NAME);
else
	$item['Name'] = $n;

// ключ
$n = $this->controls['form']->GetControl('blockkeyedit')->GetTitle();
if(empty($n))
	$OBJECTS['uerror']->AddErrorIndexed('blockkey', ERR_E_ADMIN_WRONG_BLOCKKEY);
else
	$item['BlockKey'] = $n;


// тип блока
$s = $this->controls['form']->GetControl('typeselect')->GetSelected();
$item['Type'] = $s[0];

// раздел блока
$n = $this->controls['form']->GetControl('blocksectionidedit')->GetTitle();
//if( $item['Type'] == 'block' && empty($n))
//	$OBJECTS['uerror']->AddErrorIndexed('blocksectionid', ERR_E_ADMIN_WRONG_BLOCKSECTION);
//else
	$item['BlockSectionID'] = $n;

// шаблон
$item['Template'] = $this->controls['form']->GetControl('templateedit')->GetTitle();

// кэшировать
$item['Cache'] = $this->controls['form']->GetControl('cb_cache')->GetChecked();

// время жизни
$item['Lifetime'] = $this->controls['form']->GetControl('lifetimeedit')->GetTitle();

// последний
$item['IsLast'] = $this->controls['form']->GetControl('cb_last')->GetChecked();

// rand
$item['IsRand'] = $this->controls['form']->GetControl('cb_rand')->GetChecked();

// видимый
$item['IsVisible'] = $this->controls['form']->GetControl('cb_visible')->GetChecked();

if($OBJECTS['uerror']->IsError())
	return false;

$bl = BLFactory::GetInstance('system/blocks');
if ( !$bl->SaveBlock($item) )
{
	$OBJECTS['uerror']->AddErrorIndexed('config', ERR_E_ADMIN_UNKNOWN_ERROR);
	return false;
}


LibFactory::GetStatic('xml');

// параметры
$e = $this->controls['form']->GetControl('e_params')->GetTitle();		
$msg = XML::Validate($e);
if($msg !== true)
	$OBJECTS['uerror']->AddErrorIndexed('params', ERR_E_ADMIN_CUSTOM, $msg);
else
	$item['params'] = XML::FromXML($e);

// условия
$e = $this->controls['form']->GetControl('e_conditions')->GetTitle();		
$msg = XML::Validate($e);
if($msg !== true)
	$OBJECTS['uerror']->AddErrorIndexed('conditions', ERR_E_ADMIN_CUSTOM, $msg);
else
	$item['conditions'] = XML::FromXML($e);

// связи
$e = $this->controls['form']->GetControl('e_links')->GetTitle();		
$msg = XML::Validate($e);
if($msg !== true)
	$OBJECTS['uerror']->AddErrorIndexed('links', ERR_E_ADMIN_CUSTOM, $msg);
else
	$item['links'] = XML::FromXML($e);

Response::Redirect($this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.blocks'. $this->controls['treepath']->GetStateUrl(true, true) );

?>