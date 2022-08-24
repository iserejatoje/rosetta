<?php

class SphinxPlugin_Consult_v2 extends SphinxPluginTrait {

	protected $_module = 'consult_v2';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 100;
	
	protected $_rules = array(
		'source' => array(
			'advice' => array(

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

				'sql_query'		=> ' \
	SELECT \
		(q.id << 32) + %SECTIONID% as id, \
		q.id as _source, \
		UNIX_TIMESTAMP(q.date) as created, \
		CONCAT(r.name,\': \', f.name) as title, \
		CONCAT(q.otziv, \' \', q.answer) as text, \
		0 as Type, \
	\
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %tables/question% as q \
	INNER JOIN %tables/consult% as c ON (c.id = q.st_id) \
	INNER JOIN %tables/rub% as r ON (r.id = c.rid) \
	INNER JOIN %tables/firm% as f ON (f.id = c.fid) \
	WHERE \
		q.`onboard` = 1 AND c.visible = 1 AND r.visible = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'advice' => array(
				'source'			=> 'advice',
				'path'				=> '%VAR_DIR%/advice/default',
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
				'preopen'			=> 0,
				'min_stemming_len'	=> 4,
			),
		),
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);

		$sql = 'SELECT q.id, q.st_id, q.date as created, ';
		$sql .= ' CONCAT(r.name,\': \', f.name) as title, ';
		$sql .= ' q.otziv, q.answer ';
		$sql .= ' FROM advice_v2_question as q ';
		$sql .= ' INNER JOIN advice_v2_consult as c ON (c.id = q.st_id)	';
		$sql .= ' INNER JOIN advice_v2_rub as r ON (r.id = c.rid)	';
		$sql .= ' INNER JOIN advice_v2_firm as f ON (f.id = c.fid)	';
		$sql .= ' WHERE q.id = '.(int) $attr['_source'].' AND q.`onboard` = 1 AND c.visible = 1 AND r.visible = 1 ';

		$res = $db->query($sql);

		if ( !$res || !$res->num_rows )
			return null;

		$data = $res->fetch_assoc();

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']);
		$data['url'].= 'comment/'.$data['st_id'].'/'.$data['id'].'.html';

		$data['text'] = 'Вопрос: '.$data['otziv'];
		if ( trim($data['answer']) != '' )
			$data['text'] .= ' Ответ: '.$data['answer'];

		$data['index'] = 'advice';
		return $data;
	}
}
