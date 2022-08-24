<?php

class SphinxPlugin_Board extends SphinxPluginTrait {

	protected $_module = 'board';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 6;

	protected $_rules = array(
		'source' => array(
			'board' => array(

				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> '%db%',
				'sql_pass'	=> '%db%',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),
				'sql_range_step' => 1000,

				'sql_query'		=> ' \
	SELECT \
		(m.`AdvID` << 32) + %SECTIONID% as `id`, \
		m.`AdvID` as _source, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`Deal` as `Deal`, \
		m.`RubricID` as `RubricID`, \
		m.`BrandID` as `BrandID`, \
		m.`Title` as `Title`, \
		m.`Text` as `Text`, \
		m.`Model` as `Model`, \
		m.`Contacts` as `Contacts`, \
		m.`Price` as `Price`, \
		UNIX_TIMESTAMP(m.`DateUpdate`) as `DateUpdate`, \
		m.`opt_Photo` as `opt_Photo`, \
		0 as `Type`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_advertise` m \
	WHERE \
		m.opt_InState = 0 AND m.IsNew IN (0,1)',

				'sql_attr_uint'			=> array(
					'Type', 'Deal', 'RubricID', 'BrandID', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_float'		=> 'Price',
				'sql_attr_timestamp'	=> array(
					'DateUpdate', 'Created'
				),

				'sql_ranged_throttle'	=> 200,
			),
		),

		'index' => array(
			'board' => array(
				'source'			=> 'board',
				'path'				=> '%VAR_DIR%/board/search',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 3,
				'charset_type'		=> 'utf-8',
				//'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 3,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
			),
		),
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);
		$sql = 'SELECT AdvID as id, Title as title, Text as text, DateUpdate as created FROM '.$config['regid'].'_advertise WHERE AdvID='.(int) $attr['_source'];
		$res = $db->query($sql);

		if ( !$res || !$res->num_rows )
			return null;

		$data = $res->fetch_assoc();
		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'detail/'. $data['id'].'.php';
		$data['index'] = 'board';

		return $data;
	}
}
