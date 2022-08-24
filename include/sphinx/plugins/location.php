<?php

class SphinxPlugin_Location extends SphinxPluginTrait {

	protected $_type = Sphinx::PT_NAMED;

	protected $_rules = array(
		'source' => array(
	/*********************************************************************************
		Objects
	*/
			'location_objects' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'sources.r2.mysql',
				'sql_user'	=> 'sources',
				'sql_pass'	=> 'sources',
				'sql_db'	=> 'sources',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		o.`ObjectID` as `id`, \
		o.`Name`, \
		s.`Normalized`, \
		o.`Type`, \
		o.`IsVisible`, \
		CONV(o.`Code`,36,10) as `Code`, \
		CONV(o.`ContinentCode`,36,10) as `ContinentCode`, \
		CONV(o.`CountryCode`,36,10) as `CountryCode`, \
		CONV(o.`RegionCode`,36,10) as `RegionCode`, \
		CONV(o.`DistrictCode`,36,10) as `DistrictCode`, \
		CONV(o.`CityCode`,36,10) as `CityCode`, \
		CONV(o.`VillageCode`,36,10) as `VillageCode`, \
		CONV(o.`StreetCode`,36,10) as `StreetCode`, \
		o.`ActualCode`, \
		o.`Important`, \
		s.`Weight` \
	FROM sources.`location_objects_new` o \
	INNER JOIN sources.`location_objects_sphinx` s ON s.`ObjectID` = o .`ObjectID` \
	WHERE \
		o.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', 'IsVisible', 'Code',
					'ContinentCode', 'CountryCode', 'RegionCode',
					'DistrictCode', 'CityCode', 'VillageCode', 'StreetCode',
					'ActualCode', 'Important', 'Weight'
				),
				'sql_attr_str2ordinal'	=> array(
					'Name'
				),

				'sql_ranged_throttle'	=> 200,
			),


	/*********************************************************************************
		Landmarks
	*/
			'location_landmarks' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'sources.r2.mysql',
				'sql_user'	=> 'sources',
				'sql_pass'	=> 'sources',
				'sql_db'	=> 'sources',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		l.`LandmarkID` as `id`, \
		l.`Name`, \
		l.`Type`, \
		l.`Socr`, \
		CONV(l.`Code`,36,10) as `Code`, \
		CONV(l.`ContinentCode`,36,10) as `ContinentCode`, \
		CONV(l.`CountryCode`,36,10) as `CountryCode`, \
		CONV(l.`RegionCode`,36,10) as `RegionCode`, \
		CONV(l.`DistrictCode`,36,10) as `DistrictCode`, \
		CONV(l.`CityCode`,36,10) as `CityCode`, \
		CONV(l.`VillageCode`,36,10) as `VillageCode`, \
		CONV(l.`StreetCode`,36,10) as `StreetCode`, \
		CONV(l.`LandmarkCode`,36,10) as `LandmarkCode`, \
		l.`ActualCode`, \
		l.`Important`, \
		l.`IsVisible`, \
		l.`IsNew` \
	FROM sources.`location_landmarks` l \
	WHERE \
		l.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', 'Code', 'ContinentCode', 'CountryCode', 'RegionCode',
					'DistrictCode', 'CityCode', 'VillageCode', 'StreetCode',
					'ActualCode', 'Important', 'IsNew', 'IsVisible'
				),

				'sql_ranged_throttle'	=> 200,
			),

	/*********************************************************************************
		Areas
	*/
			'location_areas' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'sources.r2.mysql',
				'sql_user'	=> 'sources',
				'sql_pass'	=> 'sources',
				'sql_db'	=> 'sources',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		a.`AreaID` as `id`, \
		a.`Name`, \
		a.`Type`, \
		a.`Socr`, \
		a.`IsVisible`, \
		CONV(a.`Code`,36,10) as `Code`, \
		CONV(a.`ContinentCode`,36,10) as `ContinentCode`, \
		CONV(a.`CountryCode`,36,10) as `CountryCode`, \
		CONV(a.`RegionCode`,36,10) as `RegionCode`, \
		CONV(a.`DistrictCode`,36,10) as `DistrictCode`, \
		CONV(a.`CityCode`,36,10) as `CityCode`, \
		CONV(a.`VillageCode`,36,10) as `VillageCode`, \
		CONV(a.`AreaCode`,36,10) as `AreaCode` \
	FROM sources.`location_areas_new` a \
	WHERE \
		a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', 'IsVisible', 'Code',
					'ContinentCode', 'CountryCode', 'RegionCode',
					'DistrictCode', 'CityCode', 'VillageCode', 'AreaCode'
				),

				'sql_ranged_throttle'	=> 200,
			),

		),



		'index' => array(
			'location_objects' => array(
				'source'			=> 'location_objects',
				'path'				=> '%VAR_DIR%/location/objects',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				//'morphology'		=> 'stem_en, stem_ru',
				'morphology'		=> 'none',
				//'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 1,
				'charset_type'		=> 'utf-8',
				//'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 1,
				//'min_infix_len'		=> 3,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
			),
			'location_landmarks : location_objects' => array(
				'source'			=> 'location_landmarks',
				'path'				=> '%VAR_DIR%/location/landmarks',
			),
			'location_areas : location_objects' => array(
				'source'			=> 'location_areas',
				'path'				=> '%VAR_DIR%/location/areas',
			),
		),
	);
}
