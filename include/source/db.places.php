<?php

function source_db_places($params)
{
	global $CONFIG,  $OBJECTS;

	LibFactory::GetStatic('location');
	LibFactory::GetStatic('cache');
	LibFactory::GetStatic('app_comment_tree');
	LibFactory::GetMStatic('place', 'placemgr');
	LibFactory::GetMStatic('tree', 'nstreemgr');

//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';

	$result = array();

	if (!isset($params['sectionid'])) {
		$cache = new Cache();
		$cache->Init('memcache', 'db_places');

		$list = $cache->get('firms_sections_list');
		if($list === false)
		{
			$filter = array(
				'module'	=> 'firms',
				'path'		=> 'firms',
				'deleted'   => 0,
			);

			$list = array();
			$nodes = STreeMgr::Iterator($filter);
			foreach($nodes as $node) {
				if (!$node->Parent->IsTitle)
					continue ;

				$list[$node->Regions] = $node->ID;
			}

			$cache->set('firms_sections_list', $list, 10800);
		}

		$params['sectionid'] = $list[App::$CurrentEnv['regid']];
	}

	switch($params['action']) {
		case 'onmap_by_coords':

			if (trim($params['coords']) == '')
				break ;

			$params['coords'] = explode('|', $params['coords']);

			$_place = PlaceMgr::GetInstance();
			foreach($params['coords'] as $coords) {
				list($x, $y) = explode(',', $coords);

				$x = str_replace(',', '.', floatval($x));
				$y = str_replace(',', '.', floatval($y));

				$cl = LibFactory::GetInstance('sphinx_api');
				$cl->SetMatchMode ( SPH_MATCH_FULLSCAN );
				$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
				$cl->SetArrayResult ( true );
				$cl->SetConnectTimeout ( 3 );
				$cl->SetLimits(0, 1000);

				$cl->SetFilter ( 'SECTIONID', array($params['sectionid']), false );
				$cl->SetFilter ( 'OnMap', array(1), false );
				$cl->SetGroupBy ( "placeid", SPH_GROUPBY_ATTR);

				$cl->SetFilterFloatRange ( 'MapX', (float) $x, (float) $x, false );
				$cl->SetFilterFloatRange ( 'MapY', (float) $y, (float) $y, false );

				$res = $cl->Query ('', 'firms_source');
				if (is_array($res['matches'])) {
					$result['count'] = $res['total_found'];
					foreach($res['matches'] as $r) {
						if (null === ($place = $_place->getPlace($r['attrs']['placeid']))) {
							$result['list'][$key][] = array();
							continue ;
						}

						$key = $place->MapX.','.$place->MapY;
						if (!isset($result['list'][$key]))
							$result['list'][$key] = array();

						$result['list'][$key][] =  array(
							'Index'	=> $offset+sizeof($result['list'])+1,
							'Name' => $place->Name,
							'ID' => $place->ID,
							'AnyMetaData' => array(
								'Link'			=> '/service/firms/'.$place->ID.'.html',
								'ContactPhone'	=> $place->ContactPhone,
							),
							'Point' => array(
								'X' => $place->MapX,
								'Y' => $place->MapY,
							),
						);

						$result['list'][$key] = $result['list'][$key];
					}

					foreach($result['list'] as $k => $v) {
						shuffle($v);
						$result['list'][$k] = array_values($v);
					}
				}

			}
		break;

		case 'onmap_search':

			function _getNamePath($_root, PNSTreeNodeIterator $path) {
				$base = '';
				foreach($path as $v) {
					if (!$v->isVisible)
						return false;

					if ($v->level <= $_root->level)
						continue ;

					$base .= $v->NameID.'/';
				}
				return $base;
			}

			$result['list'] = array();
			$result['count'] = 0;

			if ($params['page'] <= 0)
				$params['page'] = 1;

			$coords = array();
			$limit = 10;
			if (1000 < ($offset = ($params['page'] > 0 ? ($params['page']-1)*$limit : 0))) {
				$offset = 0;
				$params['page'] = 1;
			}

			$cl = LibFactory::GetInstance('sphinx_api');
			$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
			$cl->SetArrayResult ( true );
			$cl->SetConnectTimeout ( 3 );
			$cl->SetLimits($offset, (int) $limit);
			$cl->SetSortMode ( SPH_SORT_EXTENDED, 'ordName ASC');
			$cl->SetGroupBy ( "placeid", SPH_GROUPBY_ATTR);

			$cl->SetFilter ( 'SECTIONID', array($params['sectionid']), false );
			$cl->SetFilter ( 'OnMap', array(1), false );

			if (isset($params['coords'])) {
				$params['coords'] = explode(',', $params['coords']);
				$cl->SetFilterFloatRange ( 'MapX', (float) $params['coords'][0], (float) $params['coords'][0], false );
				$cl->SetFilterFloatRange ( 'MapY', (float) $params['coords'][1], (float) $params['coords'][1], false );

				$params['query'] = '';
				$cl->SetMatchMode ( SPH_MATCH_FULLSCAN );
			} else
				$cl->SetMatchMode ( SPH_MATCH_ALL );

			$res = $cl->Query ($params['query'], 'firms_source');
			if ($res !== false && $res['total_found'] > 0 ) {

				$result['count'] = $res['total_found'];

				$result['pages'] = Data::GetNavigationPagesNumber(
					$limit, 5, $result['count'], $params['page'], '@p@', 1);

				$_baseUrl = ModuleFactory::GetLinkBySectionId($params['sectionid'], array(), true);
				$_config = ModuleFactory::GetConfigById('section', $params['sectionid']);
				$_place = PlaceMgr::GetInstance();
				$_db = DBFactory::GetInstance($_config['db']);

				AppCommentTree::$db = $_db;
				AppCommentTree::$tables = array(
					'comments' 		=> $_config['tables']['comments'],
					'votes'			=> $_config['tables']['comments_votes'],
					'ref'			=> $_config['tables']['comments_ref'],
				);
				AppCommentTree::$uniqueid = 0;

				$_tree = new NSTreeMgr($_db,$_config['tables']['tree'], $_config['fields']);

				if (isset($_config['root'])) {
					$_root = $_tree->getNode($_config['root']);
					$_tree->setTreeId($_root->treeid, false);
				} else
					$_root = $_tree->setTreeId($sectionid);

				if (isset($_config['tables']['tree']) && isset($_config['tables']['ref']) && isset($_config['tables']['data'])) {
					$_place->_tables['tree'] = $_config['tables']['tree'];
					$_place->_tables['ref']  = $_config['tables']['ref'];
					$_place->_tables['data'] = $_config['tables']['data'];
				}

				foreach($res['matches'] as $r) {
					if (null === ($place = $_place->getPlace($r['attrs']['placeid'])))
						continue ;

					if (trim($place->AddressTemp) == '' && $place->Location && !isset($locations[$place->Location])) {
						$pc = Location::ParseCode($place->Location);
						if (($l = Location::GetObjects($pc)) && $l[0]['IsVisible']) {

							do {
								$abbr_text = Location::GetAbbrByType($l[0]['Type']);
								$l[0]['FullName'] = $abbr_text.'. '.$l[0]['Name'];

								$locations[$place->Location][] = $l[0];
								$l = Location::GetParentObject(Location::ParseCode($l[0]['Code']));
								$pc = Location::ParseCode($l[0]['Code']);
							} while(Location::ObjectLevel($pc) >= Location::OL_CITIES);
						}
						$locations[$place->Location] = array_reverse($locations[$place->Location]);

						foreach($locations[$place->Location] as &$v) {
							$v = $v['FullName'];
						}

						$locations[$place->Location] = implode(', ', $locations[$place->Location]);
					}

					if ($place->LogotypeSmall) {
						$LogotypeSmall = array(
							'src'	=> $place->LogotypeSmall['f'],
							'w'		=> $place->LogotypeSmall['w'],
							'h'		=> $place->LogotypeSmall['h'],
							'show'	=> 'block',
						);
					} else
						$LogotypeSmall = array();

					$Location = $place->AddressTemp;
					if ($locations[$place->Location])
						$Location = $locations[$place->Location].($place->House ? ', '.$place->House : '');

					$placeNodesOM = array();
					$placeNodes = $place->GetSectionRef(false, $_root->treeid);
					foreach($placeNodes as $k => $v) {
						$treeNode = $_tree->getNode($v);
						if ($treeNode === null)
							continue ;

						$namePath = _getNamePath($_root, $treeNode->getPath(true));
						if ($namePath === false)
							continue ;

						$placeNodesOM[] = array(
							'ID' => $treeNode->ID,
							'Title' => $treeNode->Title,
							'Link' => $_baseUrl.$namePath
						);
					}

					$commentCount = AppCommentTree::GetCommentsCount(array(
						'fields' => array(
							'uniqueid'	=> $place->ID,
						),
					));

					$result['list'][] =  array(
						'Index'	=> $offset+sizeof($result['list'])+1,
						'Name' => $place->Name,
						'ID' => $place->ID,
						'AnyMetaData' => array(
							'LogotypeSmall'	=> $LogotypeSmall,
							'Link'			=> '/service/firms/'.$place->ID.'.html',
							'commentCount'	=> $commentCount,
							'Location'		=> $Location,
							'ContactPhone'	=> $place->ContactPhone,
							'placeNodes'	=> $placeNodesOM,
						),
						'Point' => array(
							'X' => $place->MapX,
							'Y' => $place->MapY,
						),
					);

					$coords[] = $place->MapX.','.$place->MapY;
				}

				if (empty($coords))
					break ;

				$coords = implode('|', array_unique($coords));
				$result['byCoords'] = source_db_places(array(
					'coords' => $coords,
					'action' => 'onmap_by_coords'
				));

			}

		break;
		case 'onmap':

			$_config = ModuleFactory::GetConfigById('section', $params['sectionid']);
			$_place = PlaceMgr::GetInstance();
			$_db = DBFactory::GetInstance($_config['db']);

			AppCommentTree::$db = $_db;
			AppCommentTree::$tables = array(
				'comments' 		=> $_config['tables']['comments'],
				'votes'			=> $_config['tables']['comments_votes'],
				'ref'			=> $_config['tables']['comments_ref'],
			);
			AppCommentTree::$uniqueid = 0;

			$_tree = new NSTreeMgr($_db,$_config['tables']['tree'], $_config['fields']);

			if (isset($_config['root'])) {
				$_root = $_tree->getNode($_config['root']);
				$_tree->setTreeId($_root->treeid, false);
			} else
				$_root = $_tree->setTreeId($sectionid);

			if (isset($_config['tables']['tree']) && isset($_config['tables']['ref']) && isset($_config['tables']['data'])) {
				$_place->_tables['tree'] = $_config['tables']['tree'];
				$_place->_tables['ref']  = $_config['tables']['ref'];
				$_place->_tables['data'] = $_config['tables']['data'];
			}

			if (null === ($node = $_tree->getNode($params['nodeid'])))
				break ;

			$result['node'] = array(
				'Title' => $node->Title,
				'Type' => '',
			);

			if (null === ($result['node']['Type'] = $_config['YandexMapTypeList'][$node->isYandexMap]))
				$result['node']['Type'] = '';

			$pnode = $node;
			do {
				if (!isset($_config['YandexMapTypeList'][$pnode->isYandexMap]))
					continue ;

				$result['node']['Type'] = $_config['YandexMapTypeList'][$pnode->isYandexMap];
				break ;
			} while(null !== ($pnode = $pnode->parent));

			$result['count'] = 0;
			$result['list'] = array();
			if ($params['page'] <= 0)
				$params['page'] = 1;

			$coords = array();
			$limit = 10;
			$offset = ($params['page'] > 0 ? ($params['page']-1)*$limit : 0);

			$cl = LibFactory::GetInstance('sphinx_api');
			$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
			$cl->SetMatchMode ( SPH_MATCH_FULLSCAN );
			$cl->SetArrayResult ( true );
			$cl->SetConnectTimeout ( 3 );
			$cl->SetLimits($offset, (int) $limit);
			$cl->SetSortMode ( SPH_SORT_EXTENDED, 'ordName ASC');
			$cl->SetGroupBy ( "placeid", SPH_GROUPBY_ATTR);

			if ($node->hasChildren()) {
				$nodes = $node->getChildNodesLeafID(1,0);
				if (!is_array($nodes) || !sizeof($nodes))
					break ;
			} else
				$nodes = array($node->ID);

			$cl->SetFilter ( 'NodeID', $nodes, false );
			$cl->SetFilter ( 'OnMap', array(1), false );

			$res = $cl->Query ($params['query'], 'firms_source');
			if ($res !== false && $res['total_found'] > 0 ) {

				$result['count'] = $res['total_found'];
				$result['pages'] = Data::GetNavigationPagesNumber(
					$limit, 5, $result['count'], $params['page'], '@p@', 1);

				foreach($res['matches'] as $r) {

					if (null === ($place = $_place->getPlace($r['attrs']['placeid'])))
						continue ;

					if (trim($place->AddressTemp) == '' && $place->Location && !isset($locations[$place->Location])) {

						$pc = Location::ParseCode($place->Location);
						if (($l = Location::GetObjects($pc)) && $l[0]['IsVisible']) {

							do {
								$abbr_text = Location::GetAbbrByType($l[0]['Type']);
								$l[0]['FullName'] = $abbr_text.'. '.$l[0]['Name'];

								$locations[$place->Location][] = $l[0];
								$l = Location::GetParentObject(Location::ParseCode($l[0]['Code']));
								$pc = Location::ParseCode($l[0]['Code']);
							} while(Location::ObjectLevel($pc) >= Location::OL_CITIES);
						}
						$locations[$place->Location] = array_reverse($locations[$place->Location]);

						foreach($locations[$place->Location] as &$v) {
							$v = $v['FullName'];
						}

						$locations[$place->Location] = implode(', ', $locations[$place->Location]);
					}

					if ($place->LogotypeSmall) {
						$LogotypeSmall = array(
							'src'	=> $place->LogotypeSmall['f'],
							'w'		=> $place->LogotypeSmall['w'],
							'h'		=> $place->LogotypeSmall['h'],
							'show'	=> 'block',
						);
					} else
						$LogotypeSmall = array();

					$Location = $place->AddressTemp;
					if ($locations[$place->Location])
						$Location = $locations[$place->Location].($place->House ? ', '.$place->House : '');

					$placeNodesOM = array();
					$placeNodes = $place->GetSectionRef(false, $_root->treeid);
					foreach($placeNodes as $k => $v) {
						$treeNode = $_tree->getNode($v);
						if ($treeNode === null)
							continue ;

						$placeNodesOM[] = array(
							'ID' => $treeNode->ID,
							'Title' => $treeNode->Title,
						);
					}

					$commentCount = AppCommentTree::GetCommentsCount(array(
						'fields' => array(
							'uniqueid'	=> $place->ID,
						),
					));

					$result['list'][] =  array(
						'Index'	=> $offset+sizeof($result['list'])+1,
						'Name' => $place->Name,
						'ID' => $place->ID,
						'AnyMetaData' => array(
							'LogotypeSmall'	=> $LogotypeSmall,
							'Link'			=> '/service/firms/'.$place->ID.'.html',
							'commentCount'	=> $commentCount,
							'Location'		=> $Location,
							'ContactPhone'	=> $place->ContactPhone,
							'placeNodes'	=> $placeNodesOM,
						),
						'Point' => array(
							'X' => $place->MapX,
							'Y' => $place->MapY,
						),
					);

					$coords[] = $place->MapX.','.$place->MapY;
				}
			}

			if (empty($coords))
				break ;

			$coords = implode('|', array_unique($coords));
			$result['byCoords'] = source_db_places(array(
				'coords' => $coords,
				'action' => 'onmap_by_coords'
			));
		break;
		default:
			$result['list'] = array();

			$query = iconv('UTF-8', 'WINDOWS-1251', $params['query']);

			$sectionid = intval($params['sectionid']);
			if ($sectionid == 0)
			{
//				$json->send($result);
				return $result;
			}
			$config = ModuleFactory::GetConfigById('section', $sectionid);
			if ($config == null)
			{
//				$json->send($result);
				return $result;
			}

			$db = DBFactory::GetInstance($config['db']);

			$tree = new NSTreeMgr($db, $config['tables']['tree'], $config['fields']);

			if (isset($config['root'])) {
					$root = $tree->getNode($config['root']);
					$tree->setTreeId($root->treeid, false);
				} else
					$root = $tree->setTreeId($sectionid);

			$filter = array(
					'flags' => array(
						'NodeID' => $root->Id,
						'IsVisible'	=> 1,
						'NameStart' => $query,
					),

					'field'	=> array(
						'Name',
					),
					'dir'	=> array(
						'ASC',
					),
					'limit' => 20,
					'calc' => true,
			);



			list($places, $count) = PlaceMgr::GetInstance()->GetPlaces($filter);

			$i = 0;
			foreach($places as $place)
			{
				$item = array(
							'id'		=> $i++,
							'name'		=> $place['Name'],
							'placeid'	=> $place['PlaceID'],
							);
				$result['list'][] =$item;
			}
	}
//	$json->send($result);
	return $result;
}

?>
