<?php

class SphinxPlugin_Love_v3 extends SphinxPluginTrait {

	protected $_module = 'love_v3';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_rights = array(
		'allow' => array(
			'sections' => array(
				800,867,880,881,882,883,1079,1098,1368,1377,1382,1387,
				1392,1397,1402,1407,1412,1417,1422,1427,1432,1437,1442,
				1447,1458,1463,1468,1473,1478,1495,1548,1575,4263,4154,
				4149,3985,3910,4655,4915,5865,9971
			),
		),
	);

	protected $_rules = array(
		'source' => array(
			'love_v3' => array(

				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				'xmlpipe_fixup_utf8' => 1,
			),

			'love_v3_meetings' => array(

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
		(md.`Index` << 32) + %SECTIONID% as id, \
		users.UserID as `_source`, \
		UNIX_TIMESTAMP(md.`Date`) as `Created`, \
		users.Gender, \
		users.`GenderNeed`, \
		users.Age as Birthday, \
		users.Location as City, \
		\
		IF(users.CountPhoto > 0, 1, 0) as withPhoto, \
		IF(m.That & 1, 1, 0) as `That_1`, \
		IF(m.That & pow(2, 1), 1, 0) as `That_2`, \
		IF(m.That & pow(2, 2), 1, 0) as `That_3`, \
		IF(m.That & pow(2, 3), 1, 0) as `That_4`, \
		IF(m.That & pow(2, 4), 1, 0) as `That_5`, \
		IF(m.That & pow(2, 5), 1, 0) as `That_6`, \
		IF(m.That & pow(2, 6), 1, 0) as `That_7`, \
		IF(m.That & pow(2, 7), 1, 0) as `That_8`, \
		IF(m.That & pow(2, 8), 1, 0) as `That_9`, \
		IF(m.That & pow(2, 9), 1, 0) as `That_1_0`, \
		IF(m.That & pow(2, 10), 1, 0) as `That_1_1`, \
		IF(m.That & pow(2, 11), 1, 0) as `That_1_2`, \
		IF(m.That & pow(2, 12), 1, 0) as `That_1_3`, \
		IF(m.That & pow(2, 13), 1, 0) as `That_1_4`, \
		IF(m.That & pow(2, 14), 1, 0) as `That_1_5`, \
		IF(m.That & pow(2, 15), 1, 0) as `That_1_6`, \
		IF(m.That & pow(2, 16), 1, 0) as `That_1_7`, \
		IF(m.That & pow(2, 17), 1, 0) as `That_1_8`, \
		IF(m.That & pow(2, 18), 1, 0) as `That_1_9`, \
		IF(m.That & pow(2, 19), 1, 0) as `That_2_0`, \
		IF(m.That & pow(2, 20), 1, 0) as `That_2_1`, \
		IF(m.That & pow(2, 21), 1, 0) as `That_2_2`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID \
	FROM \
		%db%.%tables/users% as `users` \
	INNER JOIN %db%.%tables/meeting_date% as `md` ON (md.`UserID` = users.`UserID`) \
	INNER JOIN %db%.%tables/meeting% as `m` ON (m.`UserID` = users.`UserID`) \
	WHERE \
		current_date() <= md.`Date`',

				'sql_attr_timestamp'	=> 'Created',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID',
					'withPhoto', 'Birthday', 'GenderNeed', 'Gender',
					'That_1', 'That_2', 'That_3', 'That_4', 'That_5', 'That_6', 'That_7', 'That_8', 'That_9', 'That_1_0',
					'That_1_1', 'That_1_2', 'That_1_3', 'That_1_4', 'That_1_5', 'That_1_6', 'That_1_7', 'That_1_8', 'That_1_9', 'That_2_0',
					'That_2_1', 'That_2_2',
				),
				'sql_ranged_throttle'	=> 0,
			),
		),

	///home/codemaker/sphinx/debug/bin/indexer --config /home/codemaker/sphinx/debug%CONF_DIR%.conf board_74_35_10266 --rotate
		'index' => array(
			'love_v3' => array(
				'source'			=> 'love_v3',
				'path'				=> '%VAR_DIR%/love_v3/search',
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
				'min_stemming_len'	=> 4,
			),

			'love_v3_meetings : love_v3' => array(
				'source'			=> 'love_v3_meetings',
				'path'				=> '%VAR_DIR%/love_v3/search_meeteings',
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
				'min_stemming_len'	=> 4,
			),
		),
	);
	
	function __construct()
	{
		parent::__construct();
		$this->_rules['source']['love_v3']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/love_v3:love_v3 sectionid=%SECTIONID%';
	}

}
