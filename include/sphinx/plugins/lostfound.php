<?php

class SphinxPlugin_LostFound extends SphinxPluginTrait {

	protected $_module = 'lostfound';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_rules = array(
		'source' => array(
	// Таблица животных
			'lostfound_animals' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`Breed` as `Breed`, \
		m.`Color` as `Color`, \
		m.`Item` as `Item`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_animals` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

	// Таблица одежды/обуви
	'lostfound_clothing' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
	  m.`Color` as `Color`, \
		m.`Size` as `Size`, \
		m.`Item` as `Item`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_clothing` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),


	// Таблица документов
	'lostfound_documents' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
		m.`Number` as `Number`, \
		m.`OnName` as `OnName`, \
		m.`Item` as `Item`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_documents` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),


	// Таблица инвентаря
	'lostfound_equipment' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
		m.`Brand` as `Brand`, \
		m.`Size` as `Size`, \
		m.`Item` as `Item`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_equipment` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),


	// Таблица разного
	'lostfound_other' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
		m.`Color` as `Color`, \
		m.`Item` as `Item`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_other` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),


	// Таблица техники(машины и компьютерная техника)
	'lostfound_technics' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
		m.`Item` as `Item`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
		m.`Brand` as `Brand`, \
		m.`Model` as `Model`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_technics` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),


	// Таблица свидетелей
	'lostfound_witnesses' => array(

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
		m.`AdvID` as `id`, \
		m.`AdvID` as `_source`, \
		UNIX_TIMESTAMP(m.`DateCreate`) as `Created`, \
		m.`RubricID` as `RubricID`, \
		m.`RubricID` as `Type`, \
		m.`Section` as `Section`, \
		CONV(SUBSTRING(m.`Area`,LENGTH(m.`Area`)-3),36,10) as `Area`, \
		m.`Item` as `Item`, \
		m.`UserID` as `UserID`, \
		m.`Contacts` as `Contacts`, \
	  m.`Phone` as `Phone`, \
		m.`Email` as `Email`, \
		m.`Visible` as `Visible`, \
		m.`opt_Photo` as `opt_Photo`, \
		m.`Detail` as `Text`, \
		%SECTIONID% as `SECTIONID`, \
		%REGID% as `REGID`, \
		%SITEID% as `SITEID`, \
		1 as `Priority` \
	FROM %db%.`%REGID%_witnesses` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'Type', 'RubricID', 'Section', 'opt_Photo', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority', 'Area', 'Visible'
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),
		),


		'index' => array(
			'lostfound_animals' => array(
				'source'			=> 'lostfound_animals',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_animals',
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
			'lostfound_clothing' => array(
				'source'			=> 'lostfound_clothing',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_clothing',
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
			'lostfound_documents' => array(
				'source'			=> 'lostfound_documents',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_documents',
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
		'lostfound_equipment' => array(
				'source'			=> 'lostfound_equipment',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_equipment',
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
			'lostfound_other' => array(
				'source'			=> 'lostfound_other',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_other',
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
		'lostfound_technics' => array(
				'source'			=> 'lostfound_technics',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_technics',
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
			'lostfound_witnesses' => array(
				'source'			=> 'lostfound_witnesses',
				'path'				=> '%VAR_DIR%/lostfound/lostfound_witnesses',
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
			)
		),
	);

	private $_paths = array(
		4 => array( 'path' => 'lostfound/animals/birds', 'url' => 'animals/birds', 'index' => 'lostfound_animals' ),
		2 => array( 'path' => 'lostfound/animals/cats', 'url' => 'animals/cats', 'index' => 'lostfound_animals' ),
		3 => array( 'path' => 'lostfound/animals/dogs', 'url' => 'animals/dogs', 'index' => 'lostfound_animals' ),
		5 => array( 'path' => 'lostfound/animals/other', 'url' => 'animals/other', 'index' => 'lostfound_animals' ),
		11 => array( 'path' => 'lostfound/clothing/cap', 'url' => 'clothing/cap', 'index' => 'lostfound_clothing' ),
		9 => array( 'path' => 'lostfound/clothing/gloves', 'url' => 'clothing/gloves', 'index' => 'lostfound_clothing' ),
		8 => array( 'path' => 'lostfound/clothing/jacket', 'url' => 'clothing/jacket', 'index' => 'lostfound_clothing' ),
		6 => array( 'path' => 'lostfound/clothing/mittens', 'url' => 'clothing/mittens', 'index' => 'lostfound_clothing' ),
		12 => array( 'path' => 'lostfound/clothing/other', 'url' => 'clothing/other', 'index' => 'lostfound_clothing' ),
		45 => array( 'path' => 'lostfound/clothing/scarf', 'url' => 'clothing/scarf', 'index' => 'lostfound_clothing' ),
		10 => array( 'path' => 'lostfound/clothing/shoes', 'url' => 'clothing/shoes', 'index' => 'lostfound_clothing' ),
		7 => array( 'path' => 'lostfound/clothing/sneakers', 'url' => 'clothing/sneakers', 'index' => 'lostfound_clothing' ),
		18 => array( 'path' => 'lostfound/documents/credential', 'url' => 'documents/credential', 'index' => 'lostfound_documents' ),
		17 => array( 'path' => 'lostfound/documents/employment', 'url' => 'documents/employment', 'index' => 'lostfound_documents' ),
		20 => array( 'path' => 'lostfound/documents/library', 'url' => 'documents/library', 'index' => 'lostfound_documents' ),
		14 => array( 'path' => 'lostfound/documents/licence', 'url' => 'documents/licence', 'index' => 'lostfound_documents' ),
		15 => array( 'path' => 'lostfound/documents/military', 'url' => 'documents/military', 'index' => 'lostfound_documents' ),
		21 => array( 'path' => 'lostfound/documents/other', 'url' => 'documents/other', 'index' => 'lostfound_documents' ),
		13 => array( 'path' => 'lostfound/documents/passport', 'url' => 'documents/passport', 'index' => 'lostfound_documents' ),
		19 => array( 'path' => 'lostfound/documents/student', 'url' => 'documents/student', 'index' => 'lostfound_documents' ),
		16 => array( 'path' => 'lostfound/documents/technical', 'url' => 'documents/technical', 'index' => 'lostfound_documents' ),
		27 => array( 'path' => 'lostfound/electronics/camcorder', 'url' => 'electronics/camcorder', 'index' => 'lostfound_technics' ),
		25 => array( 'path' => 'lostfound/electronics/camera', 'url' => 'electronics/camera', 'index' => 'lostfound_technics' ),
		22 => array( 'path' => 'lostfound/electronics/notebook', 'url' => 'electronics/notebook', 'index' => 'lostfound_technics' ),
		28 => array( 'path' => 'lostfound/electronics/other', 'url' => 'electronics/other', 'index' => 'lostfound_technics' ),
		26 => array( 'path' => 'lostfound/electronics/pda', 'url' => 'electronics/pda', 'index' => 'lostfound_technics' ),
		23 => array( 'path' => 'lostfound/electronics/phone', 'url' => 'electronics/phone', 'index' => 'lostfound_technics' ),
		24 => array( 'path' => 'lostfound/electronics/player', 'url' => 'electronics/player', 'index' => 'lostfound_technics' ),
		35 => array( 'path' => 'lostfound/equipment/other', 'url' => 'equipment/other', 'index' => 'lostfound_equipment' ),
		31 => array( 'path' => 'lostfound/equipment/racket', 'url' => 'equipment/racket', 'index' => 'lostfound_equipment' ),
		32 => array( 'path' => 'lostfound/equipment/rollers', 'url' => 'equipment/rollers', 'index' => 'lostfound_equipment' ),
		29 => array( 'path' => 'lostfound/equipment/skates', 'url' => 'equipment/skates', 'index' => 'lostfound_equipment' ),
		30 => array( 'path' => 'lostfound/equipment/skiing', 'url' => 'equipment/skiing', 'index' => 'lostfound_equipment' ),
		33 => array( 'path' => 'lostfound/equipment/sled', 'url' => 'equipment/sled', 'index' => 'lostfound_equipment' ),
		34 => array( 'path' => 'lostfound/equipment/snowboard', 'url' => 'equipment/snowboard', 'index' => 'lostfound_equipment' ),
		37 => array( 'path' => 'lostfound/transport/bike', 'url' => 'transport/bike', 'index' => 'lostfound_technics' ),
		36 => array( 'path' => 'lostfound/transport/car', 'url' => 'transport/car', 'index' => 'lostfound_technics' ),
		38 => array( 'path' => 'lostfound/transport/moped', 'url' => 'transport/moped', 'index' => 'lostfound_technics' ),
		39 => array( 'path' => 'lostfound/transport/motorcycle', 'url' => 'transport/motorcycle', 'index' => 'lostfound_technics' ),
		40 => array( 'path' => 'lostfound/transport/other', 'url' => 'transport/other', 'index' => 'lostfound_technics' ),
		42 => array( 'path' => 'lostfound/witnesses/accident', 'url' => 'witnesses/accident', 'index' => 'lostfound_witnesses' ),
		41 => array( 'path' => 'lostfound/witnesses/fire', 'url' => 'witnesses/fire', 'index' => 'lostfound_witnesses' ),
		43 => array( 'path' => 'lostfound/witnesses/incidents', 'url' => 'witnesses/incidents', 'index' => 'lostfound_witnesses' ),
		44 => array( 'path' => 'lostfound/witnesses/other', 'url' => 'witnesses/other', 'index' => 'lostfound_witnesses' ),
		1 => array( 'path' => 'lostfound/other', 'url' => 'other', 'index' => 'lostfound_other' )
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		LibFactory::GetMStatic('advertise','advmgr');
		LibFactory::GetStatic('filestore');

		if ( !is_array($this->_paths[$attr['type']]) )
			return null;

		$obj = AdvMgr::GetSheme($this->_paths[$attr['type']]['path'], $config['regid']);
		if ( $obj === null )
			return null;

		$adv = $obj->GetAdv((int) $attr['_source']);

		if (empty($adv))
			return null;

		$data = $adv->GetData(true);
		$Section = $data['Section'];
		unset($data['Section']);
		$data['section'] = array();

		if ($Section)
		{
			$data['section']['name'] = 'found';
		}
		else
		{
			$data['section']['name'] = 'lost';
		}

		// Формируем ссылку на подробный просмотр
		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).$data['section']['name'] ."/". $this->_paths[$attr['type']]['url'] ."/detail/". $data['AdvID'] .".php";

		// подставляем район
		if ( !empty($data['Area']) )
		{
			LibFactory::GetStatic('location');
			if ( !isset($areas[$data['Area']]) )
				list($areas[$data['Area']]) = Location::GetAreas( Location::ParseCode($data['Area'], true) );
			if ( is_array($areas[$data['Area']]) && count($areas[$data['Area']]) )
				$data['Area'] = $areas[$data['Area']]['FullName'];
			else
				unset( $data['Area'] );
		}
    // Подрезаем подробное описание
		if (strlen($data['Detail']) > 200)
			$data['Detail'] = substr($data['Detail'], 0, 200)."...";

		if ( count($data['Photo']) > 0 )
		{
			if (trim($data['Photo'][0]['PhotoSmall']) != '') {
				LibFactory::GetStatic('filestore');
				LibFactory::GetStatic('images');

				try {
					$img_obj = FileStore::ObjectFromString($data['Photo'][0]['PhotoSmall']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$info = Images::PrepareImageFromObject($img_obj, $config['photo']['large']['path'], $config['photo']['url'] .'large/');
					unset($img_obj);
					$data['Photo'] = array(
						'file' => $info['url'],
						'w' => $info['w'],
						'h' => $info['h'],
					);
				} catch(MyException $e) {}
			}
		}

		$data['title'] = $data['opt_Title'];
		$data['text'] = $data['Detail'];
		$data['index'] = $this->_paths[$attr['type']]['index'];
trace::vardump($data);
		return $data;
	}
}
