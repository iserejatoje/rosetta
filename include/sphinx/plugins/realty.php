<?php

class SphinxPlugin_Realty extends SphinxPluginTrait {

	protected $_module = 'realty';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 6;

	protected $_rules = array(
		'source' => array(
			'realty_new_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_new_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),

				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_new_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_new_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_secondary_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_secondary_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_secondary_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_secondary_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_commerce_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_commerce_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_commerce_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_commerce_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_garage_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_garage_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_garage_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_garage_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_houses_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_houses_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_houses_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_houses_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_land_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_land_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_land_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_land_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_parking_offer' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_parking_offer` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_parking_demand' => array(

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
		m.`Rubric` as `Type`, \
		m.`opt_Address` as `Title`, \
		m.`Details` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_parking_demand` m \
	WHERE \
		m.opt_InState = 0',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),

			'realty_firms' => array(

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
		(m.`FirmID` << 32) + %SECTIONID% as `id`, \
		m.`FirmID` as _source, \
		UNIX_TIMESTAMP(m.`LastUpdate`) as `Created`, \
		100 as `Type`, \
		CONCAT(m.`Firm`,m.`Name`) as `Title`, \
		m.`About` as `Text`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		3 as Priority \
	FROM %db%.`%REGID%_firms` m',
				'sql_attr_uint'			=> array(
					'_source', 'SECTIONID', 'REGID', 'SITEID', 'Type', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 200,
			),
		),


		'index' => array(
			'realty_new_offer' => array(
				'source'			=> 'realty_new_offer',
				'path'				=> '%VAR_DIR%/realty/new_offer',
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
			'realty_new_demand : realty_new_offer' => array(
				'source'			=> 'realty_new_demand',
				'path'				=> '%VAR_DIR%/realty/new_demand',
			),
			'realty_secondary_offer : realty_new_offer' => array(
				'source'			=> 'realty_secondary_offer',
				'path'				=> '%VAR_DIR%/realty/secondary_offer',
			),
			'realty_secondary_demand : realty_new_offer' => array(
				'source'			=> 'realty_secondary_demand',
				'path'				=> '%VAR_DIR%/realty/secondary_demand',
			),
			'realty_commerce_offer : realty_new_offer' => array(
				'source'			=> 'realty_commerce_offer',
				'path'				=> '%VAR_DIR%/realty/commerce_offer',
			),
			'realty_commerce_demand : realty_new_offer' => array(
				'source'			=> 'realty_commerce_demand',
				'path'				=> '%VAR_DIR%/realty/commerce_demand',
			),
			'realty_garage_offer : realty_new_offer' => array(
				'source'			=> 'realty_garage_offer',
				'path'				=> '%VAR_DIR%/realty/garage_offer',
			),
			'realty_garage_demand : realty_new_offer' => array(
				'source'			=> 'realty_garage_demand',
				'path'				=> '%VAR_DIR%/realty/garage_demand',
			),
			'realty_houses_offer : realty_new_offer' => array(
				'source'			=> 'realty_houses_offer',
				'path'				=> '%VAR_DIR%/realty/houses_offer',
			),
			'realty_houses_demand : realty_new_offer' => array(
				'source'			=> 'realty_houses_demand',
				'path'				=> '%VAR_DIR%/realty/houses_demand',
			),
			'realty_land_offer : realty_new_offer' => array(
				'source'			=> 'realty_land_offer',
				'path'				=> '%VAR_DIR%/realty/land_offer',
			),
			'realty_land_demand : realty_new_offer' => array(
				'source'			=> 'realty_land_demand',
				'path'				=> '%VAR_DIR%/realty/land_demand',
			),
			'realty_parking_offer : realty_new_offer' => array(
				'source'			=> 'realty_parking_offer',
				'path'				=> '%VAR_DIR%/realty/parking_offer',
			),
			'realty_parking_demand : realty_new_offer' => array(
				'source'			=> 'realty_parking_demand',
				'path'				=> '%VAR_DIR%/realty/parking_demand',
			),
			'realty_firms : realty_new_offer' => array(
				'source'			=> 'realty_firms',
				'path'				=> '%VAR_DIR%/realty/firms',
			),
		),
	);

	private $_path = array(
		1 => array('path' => 'realty/new/offer/sell', 'url' => 'sell/residential/new', 'index' => 'realty_new_offer'),
		5 => array('path' => 'realty/secondary/offer/sell', 'url' => 'sell/residential/secondary', 'index' => 'realty_secondary_offer'),
		10 => array('path' => 'realty/houses/offer/sell', 'url' => 'sell/residential/houses', 'index' => 'realty_houses_offer'),
		15 => array('path' => 'realty/gardens/offer/sell', 'url' => 'sell/residential/gardens', 'index' => 'realty_land_offer'),
		19 => array('path' => 'realty/land/housing/offer/sell', 'url' => 'sell/land/housing', 'index' => 'realty_land_offer'),
		23 => array('path' => 'realty/land/agricultural/offer/sell', 'url' => 'sell/land/agricultural', 'index' => 'realty_land_offer'),
		27 => array('path' => 'realty/land/commercial/offer/sell', 'url' => 'sell/land/commercial', 'index' => 'realty_land_offer'),
		31 => array('path' => 'realty/garage/cooperative/offer/sell', 'url' => 'sell/garage/cooperative', 'index' => 'realty_garage_offer'),
		35 => array('path' => 'realty/garage/single/offer/sell', 'url' => 'sell/garage/single', 'index' => 'realty_garage_offer'),
		39 => array('path' => 'realty/garage/parking/offer/sell', 'url' => 'sell/garage/parking', 'index' => 'realty_parking_offer'),
		43 => array('path' => 'realty/commerce/office/offer/sell', 'url' => 'sell/commerce/office', 'index' => 'realty_commerce_offer'),
		47 => array('path' => 'realty/commerce/trade/offer/sell', 'url' => 'sell/commerce/trade', 'index' => 'realty_commerce_offer'),
		51 => array('path' => 'realty/commerce/production/offer/sell', 'url' => 'sell/commerce/production', 'index' => 'realty_commerce_offer'),
		55 => array('path' => 'realty/commerce/warehouse/offer/sell', 'url' => 'sell/commerce/warehouse', 'index' => 'realty_commerce_offer'),
		59 => array('path' => 'realty/commerce/other/offer/sell', 'url' => 'sell/commerce/other', 'index' => 'realty_commerce_offer'),
		63 => array('path' => 'realty/foreign/new/offer/sell', 'url' => 'sell/foreign/new', 'index' => 'realty_new_offer'),
		67 => array('path' => 'realty/foreign/secondary/offer/sell', 'url' => 'sell/foreign/secondary', 'index' => 'realty_secondary_offer'),
		71 => array('path' => 'realty/foreign/houses/offer/sell', 'url' => 'sell/foreign/houses', 'index' => 'realty_houses_offer'),
		2 => array('path' => 'realty/new/demand/buy', 'url' => 'buy/residential/new', 'index' => 'realty_new_demand'),
		6 => array('path' => 'realty/secondary/demand/buy', 'url' => 'buy/residential/secondary', 'index' => 'realty_secondary_demand'),
		11 => array('path' => 'realty/houses/demand/buy', 'url' => 'buy/residential/houses', 'index' => 'realty_houses_demand'),
		16 => array('path' => 'realty/gardens/demand/buy', 'url' => 'buy/residential/gardens', 'index' => 'realty_land_demand'),
		20 => array('path' => 'realty/land/housing/demand/buy', 'url' => 'buy/land/housing', 'index' => 'realty_land_demand'),
		24 => array('path' => 'realty/land/agricultural/demand/buy', 'url' => 'buy/land/agricultural', 'index' => 'realty_land_demand'),
		28 => array('path' => 'realty/land/commercial/demand/buy', 'url' => 'buy/land/commercial', 'index' => 'realty_land_demand'),
		32 => array('path' => 'realty/garage/cooperative/demand/buy', 'url' => 'buy/garage/cooperative', 'index' => 'realty_garage_demand'),
		36 => array('path' => 'realty/garage/single/demand/buy', 'url' => 'buy/garage/single', 'index' => 'realty_garage_demand'),
		40 => array('path' => 'realty/garage/parking/demand/buy', 'url' => 'buy/garage/parking', 'index' => 'realty_parking_demand'),
		44 => array('path' => 'realty/commerce/office/demand/buy', 'url' => 'buy/commerce/office', 'index' => 'realty_commerce_demand'),
		48 => array('path' => 'realty/commerce/trade/demand/buy', 'url' => 'buy/commerce/trade', 'index' => 'realty_commerce_demand'),
		52 => array('path' => 'realty/commerce/production/demand/buy', 'url' => 'buy/commerce/production', 'index' => 'realty_commerce_demand'),
		56 => array('path' => 'realty/commerce/warehouse/demand/buy', 'url' => 'buy/commerce/warehouse', 'index' => 'realty_commerce_demand'),
		60 => array('path' => 'realty/commerce/other/demand/buy', 'url' => 'buy/commerce/other', 'index' => 'realty_commerce_demand'),
		64 => array('path' => 'realty/foreign/new/demand/buy', 'url' => 'buy/foreign/new', 'index' => 'realty_new_demand'),
		68 => array('path' => 'realty/foreign/secondary/demand/buy', 'url' => 'buy/foreign/secondary', 'index' => 'realty_secondary_demand'),
		72 => array('path' => 'realty/foreign/houses/demand/buy', 'url' => 'buy/foreign/houses', 'index' => 'realty_houses_demand'),
		3 => array('path' => 'realty/new/offer/lease', 'url' => 'lease/residential/new', 'index' => 'realty_new_offer'),
		7 => array('path' => 'realty/secondary/offer/lease', 'url' => 'lease/residential/secondary', 'index' => 'realty_secondary_offer'),
		12 => array('path' => 'realty/houses/offer/lease', 'url' => 'lease/residential/houses', 'index' => 'realty_houses_offer'),
		17 => array('path' => 'realty/gardens/offer/lease', 'url' => 'lease/residential/gardens', 'index' => 'realty_land_offer'),
		21 => array('path' => 'realty/land/housing/offer/lease', 'url' => 'lease/land/housing', 'index' => 'realty_land_offer'),
		25 => array('path' => 'realty/land/agricultural/offer/lease', 'url' => 'lease/land/agricultural', 'index' => 'realty_land_offer'),
		29 => array('path' => 'realty/land/commercial/offer/lease', 'url' => 'lease/land/commercial', 'index' => 'realty_land_offer'),
		33 => array('path' => 'realty/garage/cooperative/offer/lease', 'url' => 'lease/garage/cooperative', 'index' => 'realty_garage_offer'),
		37 => array('path' => 'realty/garage/single/offer/lease', 'url' => 'lease/garage/single', 'index' => 'realty_garage_offer'),
		41 => array('path' => 'realty/garage/parking/offer/lease', 'url' => 'lease/garage/parking', 'index' => 'realty_parking_offer'),
		45 => array('path' => 'realty/commerce/office/offer/lease', 'url' => 'lease/commerce/office', 'index' => 'realty_commerce_offer'),
		49 => array('path' => 'realty/commerce/trade/offer/lease', 'url' => 'lease/commerce/trade', 'index' => 'realty_commerce_offer'),
		53 => array('path' => 'realty/commerce/production/offer/lease', 'url' => 'lease/commerce/production', 'index' => 'realty_commerce_offer'),
		57 => array('path' => 'realty/commerce/warehouse/offer/lease', 'url' => 'lease/commerce/warehouse', 'index' => 'realty_commerce_offer'),
		61 => array('path' => 'realty/commerce/other/offer/lease', 'url' => 'lease/commerce/other', 'index' => 'realty_commerce_offer'),
		65 => array('path' => 'realty/foreign/new/offer/lease', 'url' => 'lease/foreign/new', 'index' => 'realty_new_offer'),
		69 => array('path' => 'realty/foreign/secondary/offer/lease', 'url' => 'lease/foreign/secondary', 'index' => 'realty_secondary_offer'),
		73 => array('path' => 'realty/foreign/houses/offer/lease', 'url' => 'lease/foreign/houses', 'index' => 'realty_houses_offer'),
		4 => array('path' => 'realty/new/demand/rent', 'url' => 'rent/residential/new', 'index' => 'realty_new_demand'),
		9 => array('path' => 'realty/secondary/demand/rent', 'url' => 'rent/residential/secondary', 'index' => 'realty_secondary_demand'),
		14 => array('path' => 'realty/houses/demand/rent', 'url' => 'rent/residential/houses', 'index' => 'realty_houses_demand'),
		18 => array('path' => 'realty/gardens/demand/rent', 'url' => 'rent/residential/gardens', 'index' => 'realty_land_demand'),
		22 => array('path' => 'realty/land/housing/demand/rent', 'url' => 'rent/land/housing', 'index' => 'realty_land_demand'),
		26 => array('path' => 'realty/land/agricultural/demand/rent', 'url' => 'rent/land/agricultural', 'index' => 'realty_land_demand'),
		30 => array('path' => 'realty/land/commercial/demand/rent', 'url' => 'rent/land/commercial', 'index' => 'realty_land_demand'),
		34 => array('path' => 'realty/garage/cooperative/demand/rent', 'url' => 'rent/garage/cooperative', 'index' => 'realty_garage_demand'),
		38 => array('path' => 'realty/garage/single/demand/rent', 'url' => 'rent/garage/single', 'index' => 'realty_garage_demand'),
		42 => array('path' => 'realty/garage/parking/demand/rent', 'url' => 'rent/garage/parking', 'index' => 'realty_parking_demand'),
		46 => array('path' => 'realty/commerce/office/demand/rent', 'url' => 'rent/commerce/office', 'index' => 'realty_commerce_demand'),
		50 => array('path' => 'realty/commerce/trade/demand/rent', 'url' => 'rent/commerce/trade', 'index' => 'realty_commerce_demand'),
		54 => array('path' => 'realty/commerce/production/demand/rent', 'url' => 'rent/commerce/production', 'index' => 'realty_commerce_demand'),
		58 => array('path' => 'realty/commerce/warehouse/demand/rent', 'url' => 'rent/commerce/warehouse', 'index' => 'realty_commerce_demand'),
		62 => array('path' => 'realty/commerce/other/demand/rent', 'url' => 'rent/commerce/other', 'index' => 'realty_commerce_demand'),
		66 => array('path' => 'realty/foreign/new/demand/rent', 'url' => 'rent/foreign/new', 'index' => 'realty_new_demand'),
		70 => array('path' => 'realty/foreign/secondary/demand/rent', 'url' => 'rent/foreign/secondary', 'index' => 'realty_secondary_demand'),
		74 => array('path' => 'realty/foreign/houses/demand/rent', 'url' => 'rent/foreign/houses', 'index' => 'realty_houses_demand'),
		8 => array('path' => 'realty/secondary/offer/daily', 'url' => 'daily/residential/secondary', 'index' => 'realty_secondary_offer'),
		13 => array('path' => 'realty/houses/offer/daily', 'url' => 'daily/residential/houses', 'index' => 'realty_houses_offer'),
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		if ( $attr['type'] == 100 )
		{
			$db = DBFactory::GetInstance($config['db']);

			$sql = "SELECT * FROM `". $config['regid'] . "_firms`";
			$sql.= " WHERE `FirmID` = ". (int) $attr['_source'];

			$res = $db->query($sql);
			if ( $res === false || false === ($row = $res->fetch_assoc()) )
				return array();
			
			$data = array();
			$data['id'] = (int) $attr['_source'];
			$data['created'] = $row['LastUpdate'];
			$data['text'] = $row['About'] ? $row['About'] : ' ';
			$data['title'] = $row['Firm'] ? $row['Firm'] : $row['Name'];
			$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'firm/'.(int) $attr['_source'] .'.php';
			$data['index'] = 'realty_firms';

			return $data;
		}

		LibFactory::GetMStatic('advertise','advmgr');
		LibFactory::GetStatic('location');

		if ( !is_array($this->_path[$attr['type']]) )
			return array();
		
		try
		{
			$obj = AdvMgr::GetSheme($this->_path[$attr['type']]['path'], $config['regid']);
		}
		catch (MyException $e)
		{
			return array();
		}

		$adv = $obj->GetAdv((int) $attr['_source']);
		if ( $adv === null )
			return array();

		$area = Location::GetAreas(Location::ParseCode($adv['Area']));

		$data = array();
		$data['id'] = (int) $attr['_source'];
		$data['created'] = $adv['DateCreate'];
		$data['text'] = $adv['Details'] ? $adv['Details'] : ' ';
		$data['title'] = $adv['opt_Address'];
		$data['Area'] = 'Район: '. $area[0]['Name'];
		if ( $adv['RoomCount'] > 0 )
			$data['RoomCount'] = 'Комнат: '. $config['arrays']['Rooms'][$adv['RoomCount']]['b'];
		if ( $adv['BuildingArea'] >0 )
			$data['BuildingArea'] = 'Площадь помещения: '. $adv['BuildingArea'];
		if ( $adv['LandArea'] > 0 )
			$data['LandArea'] = 'Площадь помещения: '. $adv['LandArea'];
		if ( $adv['BuildingType'] > 0 )
			$data['BuildingType'] = 'Тип дома: '. $config['arrays']['BuildingType'][$adv['BuildingType']]['b'];
		if ( $adv['Series'] > 0 )
			$data['Series'] = 'Серия: '. $config['arrays']['Series'][$adv['Series']]['b'];
		if ( $adv['Floor'] > 0 )
		{
			$data['Floor'] = 'Этаж: '. $config['arrays']['Floor'][$adv['Floor']]['b'];
			if ( $adv['Floors'] > 0 )
				$data['Floor'].= '/'. $config['arrays']['Floor'][$adv['Floors']]['b'];
		}
		else if ( $adv['Floors'] > 0 )
				$data['Floor'] = 'Этажность: '. $config['arrays']['Floor'][$adv['Floors']]['b'];

		if ( count($adv['Photo']) > 0 )
		{
			if (trim($adv['Photo'][0]['PhotoSmall']) != '')
			{
				LibFactory::GetStatic('filestore');
				LibFactory::GetStatic('images');

				try
				{
					$img_obj = FileStore::ObjectFromString($adv['Photo'][0]['PhotoSmall']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$info = Images::PrepareImageFromObject($img_obj, $config['photo']['small']['path'], $config['photo']['url'] .'small/');
					unset($img_obj);
					$data['Photo'] = array(
						'file' => $info['url'],
						'w' => $info['w'],
						'h' => $info['h'],
					);
				}
				catch ( MyException $e ){}
			}
		}

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).$this->_path[$attr['type']]['url']. '/detail/'.(int) $attr['_source'] .'.php';
		$data['index'] = $this->_path[$attr['type']]['index'];

		return $data;
	}
}
