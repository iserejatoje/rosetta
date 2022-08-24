<?
class WebObjects
{
	function GetTree()
	{
		LibFactory::GetStatic('tree');
		$db = DBFactory::GetInstance('site');
		
		$sql = "SELECT id, parent, name, type, t_id, visible
				FROM tree
				ORDER BY name";		
		$res = $db->query($sql);
		
		while($row = $res->fetch_assoc())
			$treedata[$row['id']] = array('parent' => $row['parent'], 'data' => array('Name' => $row['name'], 'Visible' => $row['visible'], 'Type' => $row['type'], 'TID' => $row['t_id']), 'name' => $row['id']);	
		$tree = new Tree();
		$tree->BuildTree($treedata, 4974);
		return $tree;
	}
}
?>