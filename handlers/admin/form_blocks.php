<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_view'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$bl = BLFactory::GetInstance('system/blocks');
$source = $bl->GetBlockSource();
$source->setparam('sectionid', $this->pathinfo['section']);

$this->controls['treeform'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'treeform'));
$this->controls['treeform']->SetTemplate('controls/extend/form/blank');

$treelist = ControlFactory::GetInstance('list/list', null, array('id' => 'treelist', 'source' => $source));
$treelist->SetRowTemplate('admin/controls/list/blockrow');
$treelist->GetPager()->SetItemsPerPage(20);
$treelist->SetDefaultSort(10,0);
$treelist->SetSelectMode('multi');

$treelist->AddColumn('ID', 'BlockID');
$treelist->AddColumn('Имя', 'Name');
$treelist->AddColumn('Ключ','BlockKey');
$treelist->AddColumn('Тип','Type');
$treelist->AddColumn('Раздел блока','BlockSectionID', array('width' => '100'));
$treelist->AddColumn('Кэш','Cache', array('width' => '30'));
$treelist->AddColumn('Время жизни','Lifetime', array('width' => '100'));
$treelist->AddColumn('Последний','IsLast', array('width' => '30'));
$treelist->AddColumn('RND','IsRand', array('width' => '30'));
$treelist->AddColumn('Видимый','IsVisible', array('width' => '30'));
$treelist->AddColumn('Порядок','Ord', array('width' => '30'));

$this->controls['treeform']->AddItem('', $treelist);

$this->controls['treemenu'] = ControlFactory::GetInstance('extend/menu', null, array('id' => 'treemenu'));
if($OBJECTS['user']->IsInRole('e_adm_block_create'))
	$this->controls['treemenu']->AddItem('Создать новый', $this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.newblock');
$this->controls['treemenu']->AddItem('Экспорт', $this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.export_blocks_xml?'.time());
$this->controls['treemenu']->AddItem('Импорт', $this->params['uri'] . $this->bl->GetNodePathByID($this->pathinfo['section']) .'.import_blocks_xml');

?>