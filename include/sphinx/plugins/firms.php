<?php

class SphinxPlugin_Firms extends SphinxPluginTrait {

	protected $_module = 'firms';
	
	protected $_type = Sphinx::PT_NAMED_REF;

	protected $_group = 3;

	protected $_rights = array(
		'deny' => array(
			'sites' => array(
				984,1015,9772,4319,10522,5016,5019,5021,5023,5025,5027,
				5029,5031,10570,10578,10590,10602,10614,10626,10637,10698 // всяки вапы и т.п.
			),
		),
	);

	protected $_rules = array(
		'source' => array(
			'firms_search' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'places.r2.mysql',
				'sql_user'	=> 'places',
				'sql_pass'	=> 'places',
				'sql_db'	=> 'places',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		r.UniqueID as id, \
		r.UniqueID as _source, \
		p.PlaceID as PlaceID, \
		UNIX_TIMESTAMP(p.`Created`) as created, \
		CONCAT(t.Title, \' \', p.Name) as title, \
		CONCAT( \
			p.ContactName, \' \', \
			p.ContactPhone, \' \', \
			p.ContactFax, \' \', \
			p.ContactEmail, \' \', \
			p.ContactUrl, \' \', \
			p.Director, \' \', \
			p.Info, \' \' \
		) as `text`, \
		0 as Type, \
		p.OnMap, \
		p.MapX as MapX, \
		p.MapY as MapY, \
		r.NodeID as NodeID, \
		t.TreeID as SECTIONID, \
		t.SiteID as SITEID, \
		t.RegionID as REGID, \
		3 as Priority \
	FROM \
		places.place_data as p \
		INNER JOIN places.place_tree_ref as r ON (r.PlaceID = p.PlaceID) \
		INNER JOIN places.place_tree as t ON (t.NodeID = r.NodeID) \
	WHERE \
		p.isVisible = 1 \
		AND r.IsActive = 1 \
		AND t.isVisible = 1 \
		AND t.Right - t.Left = 1 AND t.SiteID != 35',

				'sql_attr_timestamp'	=> 'Created',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'NodeID', 'PlaceID', 'SECTIONID', 'REGID', 'SITEID', 'Priority','OnMap'
				),
				'sql_attr_float' => array(
					'MapX', 'MapY'
				),

				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'firms_search' => array(
				'source'			=> 'firms_search',
				'path'				=> '%VAR_DIR%/firms/search',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'charset_type'		=> 'utf-8',
				//'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 2,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
				'min_stemming_len'	=> 4,
			),
		),
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);

		$sql = 'SELECT p.Name as title, ';
		$sql .= ' CONCAT(
				p.Info, \' \',
				p.Director, \' \',
				p.ContactName, \' \',
				p.ContactPhone, \' \',
				p.ContactFax, \' \',
				p.ContactEmail, \' \',
				p.ContactUrl, \' \'
			) as `text`, p.created, r.* ';
		$sql .= ' FROM '.$config['tables']['ref'].' r ';
		$sql .= ' INNER JOIN '.$config['tables']['data'].' as p USING(PlaceID) ';
		$sql .= ' WHERE r.`UniqueID` = '.(int) $attr['_source'];

		$res = $db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$data = $res->fetch_assoc();

		LibFactory::GetMStatic('tree', 'nstreemgr');
		$tree = new NSTreeMgr($db, $config['tables']['tree'], $config['fields']);
		$node = $tree->getNode($data['NodeID']);

		$tree->setTreeId($node->treeid, false);
		$path = $node->getPath(false, true);

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']);
		foreach($path as $id) {
			if ($config['root'] && $config['root'] == $id)
				break ;
			$node = $tree->getNode($id);

			if ($node->IsVisible != 1)
				return null;

			$data['url'] .= $node->NameID.'/';
		}

		$data['url'] .= $data['PlaceID'].'.html';

		LibFactory::GetMStatic('place', 'placemgr');
		$nodes = PlaceMgr::getInstance()->GetPlaceSectionRef($data['PlaceID']);

		$urls = array();

		foreach($nodes as $node)
		{
			$node = $tree->getNode($node);
			$root = $tree->setTreeId($node->treeid);

			$nn = STreeMgr::GetNodeByID($node->treeid);
			if($nn === null || $nn->Module != 'firms' || !$nn->IsVisible)
				continue ;

			$path = $node->getPath(true);
			if (empty($path))
				continue ;

			foreach($path as $n) {
				if (!$n->isVisible)
					continue 2;
			}

			$config = ModuleFactory::GetConfigById('section', $node->treeid);
			if (isset($config['root'])) {
				$root = $tree->getNode($config['root']);
				$tree->setTreeId($root->treeid, false);
			}

			$base = '';
			foreach($path as $v) {
				if ($v->level <= $root->level)
					continue ;

				$base .= $v->NameID.'/';
			}

			$path = ModuleFactory::GetLinkBySectionId($node->treeid).$base;
			$urls[] = array(
				'path'	=> $path,
				'title'	=> $node->Title,
			);
		}

		$data['sections'] = $urls;
		$data['index'] = 'firms_search';

		return $data;

	}
}
