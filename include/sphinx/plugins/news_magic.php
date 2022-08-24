<?php

class SphinxPlugin_News_Magic extends SphinxPluginTrait {

	protected $_module = 'news_magic';

	protected $_type = Sphinx::PT_NAMED_REF;

	protected $_group = 1;

	protected $_rights = array();

	protected $_rules = array(
		'source' => array(
			'news_magic' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'news.r2.mysql',
				'sql_user'	=> 'news',
				'sql_pass'	=> 'news',
				'sql_db'	=> 'news',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		r.RefID as id, \
		a.NewsID as _source, \
		UNIX_TIMESTAMP(a.`Date`) as created, \
		a.Title as title, \
	\
		IF( CHAR_LENGTH(a.Text) > 100, a.Text, a.Anon ) as text, \
		IF( CHAR_LENGTH(a.Text) > 100, 0, 1 ) as Type, \
	\
		r.SectionID as SECTIONID, \
		r.RegionID as REGID, \
		r.SiteID as SITEID, \
		4 as Priority \
	FROM news a \
	INNER JOIN news_ref r ON (r.NewsID = a.NewsID) \
	WHERE \
		a.isVisible = 1 AND a.`Date` <= NOW() \
		AND r.SiteID NOT IN(984,1015,9772,4319,10522,5016,5019,5021,5023,5025,5027,5029,5031,10570,10578,10590,10602,10614,10626,10637,10698)',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),

				'sql_attr_timestamp'	=> 'Created',
			),
		),


		'index' => array(
			'news_magic' => array(
				'source'			=> 'news_magic',
				'path'				=> '%VAR_DIR%/news/main',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'charset_type'		=> 'utf-8',
				'charset_table'		=> '0..9, A..Z->a..z, _, a..z, U+410..U+42F->U+430..U+44F, U+430..U+44F, U+401->U+451, U+AD',
				'ignore_chars'		=> '',
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

		if (!isset($attr['sectionid']))
			return null;

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);

		$sql = 'SELECT a.NewsID, a.`Date` as created, a.title, ';
		if ( $type == 0 )
			$sql .= ' a.text ';
		else
			$sql .= ' a.anon as text ';

		$sql .= ' FROM '.$config['tables']['article'].' a ';
		$sql .= ' INNER JOIN '.$config['tables']['ref'].' r ON (r.NewsID = a.NewsID) ';
		$sql .= ' WHERE a.NewsID = '.(int) $attr['_source'];

		$res = $db->query($sql);

		if ( !$res || !$res->num_rows )
			return null;

		$data = $res->fetch_assoc();

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).$data['NewsID'].'.html';
		$data['index'] = 'news_magic';

		return $data;
	}
}
