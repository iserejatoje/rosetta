<?php

class SphinxPlugin_Passport extends SphinxPluginTrait {

	protected $_type = Sphinx::PT_NAMED;

	protected $_rules = array(
		'source' => array(
			'passport_main' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'passport.r2.mysql',
				'sql_user'	=> 'passport',
				'sql_pass'	=> 'passport',
				'sql_db'	=> 'passport',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query_range' => 'SELECT MIN(UserID),MAX(UserID) FROM users WHERE UserID > 0',
				'sql_range_step' => 1000,

				# main document fetch query
				# mandatory, integer document ID field MUST be the first selected column
				'sql_query'		=> 'SELECT users.UserID, UNIX_TIMESTAMP(users.Registered) AS Registered, \
		CONCAT(profile_general.LastName, \' \', profile_general.FirstName,\' \',profile_general.MidName) as Name,\
		\
		profile_general.FirstName, \
		profile_general.LastName, \
		profile_general.MidName, \
		\
		profile_general.About, \
		profile_general.WorkPlace, \
		profile_general.Position, \
		profile_general.Site, \
		\
		profile_general.FirstName as FirstNameOrd, \
		profile_general.LastName as LastNameOrd, \
		profile_general.MidName as MidNameOrd, \
		profile_general.WorkPlace as WorkPlaceOrd, \
		profile_general.Position as PositionOrd, \
		profile_general.Site as SiteOrd, \
		\
		profile_general.Gender, \
		IF(LEFT(profile_general.Birthday,4) != \'0000\', TRUNCATE(( ( YEAR(CURDATE()) * 12 + MONTH(CURDATE()) ) - ( LEFT(profile_general.Birthday,4) *12 + IF(SUBSTRING(profile_general.Birthday,6,2) != \'00\', SUBSTRING(profile_general.Birthday,6,2)  ,0) ) )/12,0 ),0) as Birthday, \
		IF(profile_general.Photo = \'\', 0, 1) as Photo, \
		\
		profile_location.Current as City, \
		users.RegionID, \
		IF( users.IsBirthdayToday > 0, 1, 0 ) as IsBirthdayToday \
		\
		FROM passport.users LEFT JOIN passport.profile_general ON(profile_general.UserID = users.UserID) LEFT JOIN passport.profile_location ON(profile_location.UserID = users.UserID) WHERE users.UserID >= $start AND users.UserID <= $end AND users.IsDel = 0 ORDER by RAND()',

				'sql_attr_uint'	=> array(
					'Photo', 'Gender', 'Birthday', 'RegionID', 'IsBirthdayToday',
				),
				'sql_attr_str2ordinal'	=> array(
					'FirstNameOrd', 'LastNameOrd', 'MidNameOrd', 'WorkPlaceOrd', 'PositionOrd', 'SiteOrd',
				),

				'sql_attr_timestamp'	=> 'Registered',

				# ranged query throttling, in milliseconds
				# optional, default is 0 which means no delay
				# enforces given delay before each query step
				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'passport_main' => array(
				'source'		=> 'passport_main',
				'path'			=> '%VAR_DIR%/passport/main',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'charset_type'		=> 'utf-8',
				'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 2,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
				'min_stemming_len'	=> 4,
			),
		),
	);
}
