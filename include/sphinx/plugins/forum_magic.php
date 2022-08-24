<?php

class SphinxPlugin_Forum_Magic extends SphinxPluginTrait {

	protected $_module = 'forum_magic';

	protected $_type = Sphinx::PT_NAMED_REF;

	protected $_group = 2;

	protected $_rules = array(
		'source' => array(
			'forum_magic' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'rugion_forum.r2.mysql',
				'sql_user'	=> 'rugion_forum',
				'sql_pass'	=> 'rugion_forum',
				'sql_db'	=> 'rugion_forum',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT STRAIGHT_JOIN \
		m.id as id, \
		m.id as _source, \
		UNIX_TIMESTAMP(m.created) as created, \
		IF(m.is_theme = 1, t.name, \'\') as title, \
		m.message as text, \
		0 as Type, \
	\
		s.treeid as SECTIONID, \
		s.regid as REGID, \
		s.siteid as SITEID, \
		0 as Priority \
	FROM messages m \
	INNER JOIN themes t ON (t.id = m.theme_id) \
	INNER JOIN sections s ON (s.id = t.sec_id) \
	WHERE \
		s.treeid != 0 \
		AND m.is_del = 0 AND m.visible = 1 \
		AND s.is_del = 0 AND s.visible = 1 \
		AND t.is_del = 0 AND t.visible = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),



				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 1000,
			),
		),


		'index' => array(
			'forum_magic' => array(
				'source'			=> 'forum_magic',
				'path'				=> '%VAR_DIR%/forum/main',
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

	function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);

		$sql = 'SELECT m.id, m.theme_id, m.created, t.name as title, m.message as text';
		$sql .= ' FROM '.$config['tables']['messages'].' m ';
		$sql .= ' INNER JOIN themes t ON (t.id = m.theme_id) ';
		$sql .= ' WHERE m.id = '.(int) $attr['_source'];

		$res = $db->query($sql);

		if ( !$res || !$res->num_rows )
			return null;

		$data = $res->fetch_assoc();

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']);
		$data['url'].= 'theme.php?id='.$data['theme_id'].'&act=message&mid='.$data['id'];

		$data['index'] = 'forum_magic';

		return $data;

	}
}
