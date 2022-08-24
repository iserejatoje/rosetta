<?
function source_db_price($params)
{
	$sql = "SELECT `RegionID`, IF( `RegionID` = 74, 3, IF(COUNT(*) > 1, 2, 1) ) as `Ord`";
	$sql.= " FROM `price_groups`";
	$sql.= " WHERE `IsVisible` = 1";
	$sql.= " GROUP BY `RegionID` ORDER BY `Ord` DESC";

	$_db = DBFactory::GetInstance('group_price');

	$res = $_db->query($sql);

	$prices = array();
	while ( $row = $res->fetch_assoc() )
		$prices['r'.$row['RegionID']] = $row;

	if ( empty($prices) )
		return false;

	LibFactory::GetStatic('bl');
	$bl_env = BLFactory::GetInstance('system/env');

	$data = array();

	$it = STreeMgr::Iterator(array(
		'type' => 1,
		'deleted' => 0,
		'istitle' => 1,
	));

	foreach ( $it as $l => $site )
	{
		if (array_key_exists('r'.$site->Regions, $prices))
		{
			$env = $bl_env->LoadEnv($site->ID);
			$prices['r'.$site->Regions]['domain'] = $env['domain'];
			$prices['r'.$site->Regions]['name'] = $env['name'];
		}
	}
	return $prices;
}
?>