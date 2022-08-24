<?
include_once ENGINE_PATH.'include/json.php';
$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

LibFactory::GetStatic('bl');
$bl = BLFactory::GetInstance('system/site');

$parent = App::$Request->Post['parent']->Int(00);

$iterator = $bl->GetTreeSiteSource();
$iterator->setparam('parent', $parent);
$iterator->setsort('name', 'ASC');

foreach($iterator as $k => $n)
{
	$node = STreeMgr::GetNodeByID($k);
	$items[] = array(
		'id' => $k,
		'name' => $n['name'],
		'visible' => $n['visible'],
		'ord' => $n['ord'],
		'last' => !$node->HasChildren,
	);
}

echo $json->encode(array('success' => 'ok', 'list' => $items));
exit;

?>