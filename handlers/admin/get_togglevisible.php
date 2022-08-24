<?
include_once ENGINE_PATH.'include/json.php';
$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';
if(!$OBJECTS['user']->IsInRole('e_adm_sections_edit'))
{	
	echo $json->encode(array('success' => false));
}
else
{
	$sectionid = App::$Request->Get['id']->Int(0);
	$visible = App::$Request->Get['visible']->Int(0);
	if($sectionid == 0)
	{
		echo $json->encode(array('success' => false));
		exit;
	}
	$node = STreeMgr::GetNodeByID($sectionid);
	if($node !== null)
	{
		$node->IsVisible = $visible?true:false;
		$node->Store();
		echo $json->encode(array('success' => true));
	}
	else
	{
		echo $json->encode(array('success' => false));
	}	
}

exit;

?>