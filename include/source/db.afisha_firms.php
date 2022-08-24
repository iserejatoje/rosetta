<?php

/**
 * Получение списка объектов
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_afisha_firms($params)
{
	global $CONFIG;
	
	$node = STreeMgr::GetNodeByID($params['sectionid']);
	foreach($node->Parent->Children as $n)
	{
		if ($n->Module!='firms' && $n->Module!='firms2_new')
			continue;
		
		$params['firms_sectionid'] = $n->ID;
		return _new_afisha_firms($params);
	}
}

function _new_afisha_firms($params)
{
	$db = DBFactory::GetInstance('afisha');
	
	$sql = "SELECT *
			FROM places
			WHERE id='".$params['id']."'";
	$res = $db->query($sql);
	$row = $res->fetch_assoc();

	if($row === null || !isset($params['sectionid']))
		return array();
	
	$PlaceID = $row['PlaceID'];
	
	LibFactory::GetMStatic('place', 'placemgr');
		
	$placeMgr = PlaceMgr::getInstance();
	
	$data = array();

	$place = $placeMgr->GetPlace($PlaceID); 
	
	if ($place)
	{
		$link = ModuleFactory::GetLinkBySectionId($params['firms_sectionid']);
		
		$_db_places = DBFactory::GetInstance('places');
		
		$nstree = new NSTreeMgr($_db_places, $placeMgr->_tables['tree']);				
		$root = $nstree->setTreeId($params['firms_sectionid']);
		
		$sections = $place->GetSectionRef(true, $root->treeid);
		foreach($sections as $section)
		{
			$node = $nstree->getNode($section);
			if ($node->isLeaf()) {
				$path_list = $node->getPath(true);
				$path = rtrim(_getNamePath($path_list, $root),'/');
				break;
			}
		}
		
		$data = array(
			'id' => $place->ID,
			'name' => ($place->ShortName?$place->ShortName:$place->Name),
			'url' => $link.$path.'/'.$place->ID.'.html',
		);
		
		
	}	
	
	return $data;
}

function _getNamePath(PNSTreeNodeIterator $path, $root)
{
	$base = '';
	foreach($path as $v) {	
		if ($v->level <= $root->level)
			continue ;
		   
		$base .= $v->NameID.'/';
	}
	return $base;
}

?>
