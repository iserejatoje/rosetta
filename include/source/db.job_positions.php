<?
function source_db_job_positions($params)
{
	$query = iconv('UTF-8', 'WINDOWS-1251', $params['query']);
	$sql = "SELECT * FROM `positions` WHERE `Name` LIKE '".addslashes($query)."%' LIMIT 0,".(int)$params['limit'];
	$db = DBFactory::getInstance("g_job");

	$res = $db->query($sql);
	while ($row = $res->fetch_assoc())
		$positions[] = $row['Name'];

	return array('list' => $positions);
}
?>