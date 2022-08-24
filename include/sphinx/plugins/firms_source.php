<?php

class SphinxPlugin_Firms_Source extends SphinxPluginTrait {

	protected $_module = 'firms';
	
	protected $_type = Sphinx::PT_NAMED;

	protected $_rights = array();

	protected $_rules = array(
		'source' => array(
			'firms_source' => array(

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
		p.PlaceID as PlaceID, \
		UNIX_TIMESTAMP(p.`Created`) as created, \
		CONCAT(t.Title, \' \', p.Name) as title, \
		LOWER(p.Name) as ordName, \
		p.OnMap, \
		p.MapX as MapX, \
		p.MapY as MapY, \
		r.NodeID as NodeID, \
		t.TreeID as SECTIONID, \
		t.SiteID as SITEID, \
		t.RegionID as REGID \
	FROM \
		places.place_data as p \
		INNER JOIN places.place_tree_ref as r ON (r.PlaceID = p.PlaceID) \
		INNER JOIN places.place_tree as t ON (t.NodeID = r.NodeID) \
	WHERE \
		p.isVisible = 1 \
		AND r.IsActive = 1 \
		AND t.isVisible = 1 \
		AND t.Right - t.Left = 1',

				'sql_attr_timestamp'	=> 'Created',
				'sql_attr_uint'			=> array(
					'NodeID', 'PlaceID', 'SECTIONID', 'REGID', 'SITEID', 'OnMap'
				),
				'sql_attr_float' => array(
					'MapX', 'MapY'
				),

				'sql_attr_str2ordinal' => array(
					'ordName'
				),

				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'firms_source' => array(
				'source'			=> 'firms_source',
				'path'				=> '%VAR_DIR%/firms/source',
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
	}
}
