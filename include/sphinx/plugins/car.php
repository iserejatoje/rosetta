<?php

class SphinxPlugin_Car extends SphinxPluginTrait {

	protected $_module = 'car';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 6;

	protected $_rights = array(
		'allow' => array(
			'regions' => array(74),
			'sections' => array(601),
		),
	);

	protected $_rules = array(
		'source' => array(

	/**
		auto_cars
	*/
			'auto_cars' => array(
				
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				

				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONCAT( \
			br.`name`, \
			\' \', m.`name` \
		) as title, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Тип руля \' USING utf8), \
			IF(a.`Rudder` = 0, CONVERT(\'Левый\' USING utf8), \
				IF(a.`Rudder` = 1, CONVERT(\'Правый\' USING utf8), \'\') \
			), \
	 \
			\' \', CONVERT(\'Год выпуска \' USING utf8), a.`Year`, \
			\' \', CONVERT(\'Пробег, км \' USING utf8), a.`Mileage`, \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', IF( \
				isnull(c.`name`), \'\', \
				CONCAT(CONVERT(\'Цвет кузова \' USING utf8), CONVERT(c.`name` USING utf8)) \
			), \
	 \
			\' \',IF( \
				isnull(gb.`name`), \'\', \
				CONCAT(CONVERT(\'Тип коробки \' USING utf8), CONVERT(gb.`name` USING utf8)) \
			), \
	 \
			\' \', IF( \
				a.`EngineCapacity` = 0, \'\', \
				CONCAT(CONVERT(\'Объем двигателя \' USING utf8), \
					IF( \
						((a.`EngineCapacity`-1)*0.1+0.5) <= 8, \
						(a.`EngineCapacity`-1)*0.1+0.5, \
						CONVERT(\'более 8.0\' USING utf8) \
					) \
				) \
			), \
	 \
			\' \', IF( \
				isnull(b.`name`), \'\', \
				CONCAT(CONVERT(\'Тип кузова \' USING utf8), CONVERT(b.`name` USING utf8)) \
			), \
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as Text, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_cars` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	LEFT JOIN adv_auto.`auto_color` as c ON(c.`id` = a.`Color`) \
	LEFT JOIN adv_auto.`auto_gearbox` as gb ON(gb.`id` = a.`GearBox`) \
	LEFT JOIN adv_auto.`auto_body` as b ON(b.`id` = a.`BodyType`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),
		
	/*
		auto_parts
	*/
			'auto_parts' => array(
	
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONVERT(a.`Name` USING utf8) as `Title`, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as `Text`, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_parts` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),
	/**
		auto_trailers
	*/
			'auto_trailers' => array(

				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONCAT( \
			\' \', CONVERT(br.`name` USING utf8), \
			\' \', CONVERT(m.`name` USING utf8) \
		) as `Title`, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Год выпуска \' USING utf8), a.`Year`, \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', IF( \
				isnull(c.`name`), \'\', \
				CONCAT(CONVERT(\'Цвет кузова \' USING utf8), CONVERT(c.`name` USING utf8)) \
			), \
	 \
			\' \', IF( \
				isnull(b.`name`), \'\', \
				CONCAT(CONVERT(\'Тип кузова \' USING utf8), CONVERT(b.`name` USING utf8)) \
			), \
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as `Text`, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_trailers` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	LEFT JOIN adv_auto.`auto_color` as c ON(c.`id` = a.`Color`) \
	LEFT JOIN adv_auto.`auto_body` as b ON(b.`id` = a.`BodyType`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),

	/**
		auto_special
	*/
			'auto_special' => array(
				
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONCAT( \
			\' \', CONVERT(br.`name` USING utf8), \
			\' \', CONVERT(m.`name` USING utf8) \
		) as `Title`, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Год выпуска \' USING utf8), a.`Year`, \
			\' \', CONVERT(\'Пробег, км \' USING utf8), a.`Mileage`, \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', IF( \
				isnull(c.`name`), \'\', \
				CONCAT(CONVERT(\'Цвет кузова \' USING utf8), CONVERT(c.`name` USING utf8)) \
			), \
	 \
			\' \',IF( \
				isnull(gb.`name`), \'\', \
				CONCAT(CONVERT(\'Тип коробки \' USING utf8), CONVERT(gb.`name` USING utf8)) \
			), \
	 \
			\' \', IF( \
				a.`EngineCapacity` = 0, \'\', \
				CONCAT(CONVERT(\'Объем двигателя \' USING utf8), \
					IF( \
						((a.`EngineCapacity`-1)*0.1+0.5) <= 8, \
						(a.`EngineCapacity`-1)*0.1+0.5, \
						CONVERT(\'более 8.0\' USING utf8) \
					) \
				) \
			), \
	 \
			\' \', IF( \
				isnull(b.`name`), \'\', \
				CONCAT(CONVERT(\'Тип кузова \' USING utf8), CONVERT(b.`name` USING utf8)) \
			), \
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as `Text`, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_special` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	LEFT JOIN adv_auto.`auto_color` as c ON(c.`id` = a.`Color`) \
	LEFT JOIN adv_auto.`auto_gearbox` as gb ON(gb.`id` = a.`GearBox`) \
	LEFT JOIN adv_auto.`auto_body` as b ON(b.`id` = a.`BodyType`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),

	/**
		auto_moto
	*/
			'auto_moto' => array(

				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONCAT( \
			\' \', CONVERT(br.`name` USING utf8), \
			\' \', CONVERT(m.`name` USING utf8) \
		) as `Title`, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Год выпуска \' USING utf8), a.`Year`, \
			\' \', CONVERT(\'Пробег, км \' USING utf8), a.`Mileage`, \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', IF( \
				isnull(c.`name`), \'\', \
				CONCAT(CONVERT(\'Цвет кузова \' USING utf8), CONVERT(c.`name` USING utf8)) \
			), \
	 \
			\' \', IF( \
				a.`EngineCapacity` = 0, \'\', \
				CONCAT(CONVERT(\'Объем двигателя \' USING utf8), \
					IF( \
						((a.`EngineCapacity`-1)*0.1+0.5) <= 8, \
						(a.`EngineCapacity`-1)*0.1+0.5, \
						CONVERT(\'более 8.0\' USING utf8) \
					) \
				) \
			), \
	 \
			\' \', IF( \
				isnull(b.`name`), \'\', \
				CONCAT(CONVERT(\'Тип кузова \' USING utf8), CONVERT(b.`name` USING utf8)) \
			), \
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as `Text`, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_moto` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	LEFT JOIN adv_auto.`auto_color` as c ON(c.`id` = a.`Color`) \
	LEFT JOIN adv_auto.`auto_body` as b ON(b.`id` = a.`BodyType`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),

	/**
		auto_water
	*/
			'auto_water' => array(
				
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				/*
				'type'		=> 'mysql',
				'sql_host'	=> '%db%.r2.mysql',
				'sql_user'	=> 'dpsearch',
				'sql_pass'	=> 'dpsearch',
				'sql_db'	=> '%db%',
				'sql_port'	=> 3306,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(a.`AdvID` << 32) + %SECTIONID% as `id`, \
		a.`AdvID` as `_source`,  \
		UNIX_TIMESTAMP(a.`DateUpdate`) as `Created`, \
		a.`RubricID` as `Type`, \
	 \
		CONCAT( \
			\' \', CONVERT(br.`name` USING utf8), \
			\' \', CONVERT(m.`name` USING utf8) \
		) as `Title`, \
	\
		CONCAT( \
	 \
			CONVERT(m.`name` USING utf8), \
	 \
			\' \', CONVERT(\'Год выпуска \' USING utf8), a.`Year`, \
			\' \', CONVERT(\'Цена, руб \' USING utf8), a.`Price`, \
			\' \', CONVERT(a.`Contacts` USING utf8),\
	 \
			\' \', IF( \
				isnull(c.`name`), \'\', \
				CONCAT(CONVERT(\'Цвет кузова \' USING utf8), CONVERT(c.`name` USING utf8)) \
			), \
	 \
			\' \', IF( \
				a.`EngineCapacity` = 0, \'\', \
				CONCAT(CONVERT(\'Объем двигателя \' USING utf8), \
					IF( \
						((a.`EngineCapacity`-1)*0.1+0.5) <= 8, \
						(a.`EngineCapacity`-1)*0.1+0.5, \
						CONVERT(\'более 8.0\' USING utf8) \
					) \
				) \
			), \
	 \
			\' \', CONVERT(a.`Details` USING utf8) \
		) as `Text`, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.`%REGID%_water` as a \
	LEFT JOIN sources.`automarka` as br ON(br.`id` = a.`Brand`) \
	LEFT JOIN sources.`automarka` as m ON(m.`id` = a.`Model`) \
	LEFT JOIN adv_auto.`auto_color` as c ON(c.`id` = a.`Color`) \
	WHERE \
		a.`opt_InState` = 0 AND a.`IsVisible` = 1',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,*/
			),

		),


		'index' => array(
			'auto_cars' => array(
				'source'			=> 'auto_cars',
				'path'				=> '%VAR_DIR%/auto/cars',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'charset_type'		=> 'utf-8',
				'min_prefix_len'	=> 2,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
				'preopen'			=> 0,
				'min_stemming_len'	=> 4,
			),
			'auto_parts : auto_cars' => array(
				'source'			=> 'auto_parts',
				'path'				=> '%VAR_DIR%/auto/parts',
			),
			'auto_trailers : auto_cars' => array(
				'source'			=> 'auto_trailers',
				'path'				=> '%VAR_DIR%/auto/trailers',
			),
			'auto_special : auto_cars' => array(
				'source'			=> 'auto_special',
				'path'				=> '%VAR_DIR%/auto/special',
			),
			'auto_moto : auto_cars' => array(
				'source'			=> 'auto_moto',
				'path'				=> '%VAR_DIR%/auto/moto',
			),
			'auto_water : auto_cars' => array(
				'source'			=> 'auto_water',
				'path'				=> '%VAR_DIR%/auto/water',
			),
		),
	);

	private $_paths = array(
		6 => array( 'path' => 'auto/parts/gears', 'url' => 'gears', 'index' => 'auto_parts' ),
		8 => array( 'path' => 'auto/motors/rus', 'url' => 'motors/rus', 'index' => 'auto_cars' ),
		9 => array( 'path' => 'auto/motors/foreign', 'url' => 'motors/foreign', 'index' => 'auto_cars' ),
		10 => array( 'path' => 'auto/trailers/light', 'url' => 'motors/trailers', 'index' => 'auto_trailers' ),
		11 => array( 'path' => 'auto/motors/buses', 'url' => 'commercial/buses', 'index' => 'auto_cars' ),
		12 => array( 'path' => 'auto/motors/trucks', 'url' => 'commercial/trucks', 'index' => 'auto_cars' ),
		13 => array( 'path' => 'auto/motors/commercial', 'url' => 'commercial/small', 'index' => 'auto_cars' ),
		14 => array( 'path' => 'auto/trailers/cargo', 'url' => 'commercial/trailers', 'index' => 'auto_trailers' ),
		15 => array( 'path' => 'auto/special', 'url' => 'commercial/special', 'index' => 'auto_special' ),
		16 => array( 'path' => 'auto/moto/bikes', 'url' => 'moto/bikes', 'index' => 'auto_moto' ),
		17 => array( 'path' => 'auto/moto/quadro', 'url' => 'moto/quadro', 'index' => 'auto_moto' ),
		18 => array( 'path' => 'auto/moto/scooter', 'url' => 'moto/scooter', 'index' => 'auto_moto' ),
		19 => array( 'path' => 'auto/moto/snow', 'url' => 'moto/snow', 'index' => 'auto_moto' ),
		20 => array( 'path' => 'auto/water/hydros', 'url' => 'water/hydros', 'index' => 'auto_water' ),
		21 => array( 'path' => 'auto/water/yachts', 'url' => 'water/yachts', 'index' => 'auto_water' ),
		22 => array( 'path' => 'auto/water/boats', 'url' => 'water/boats', 'index' => 'auto_water' ),
		23 => array( 'path' => 'auto/parts/wheels', 'url' => 'parts/wheels', 'index' => 'auto_parts' ),
		24 => array( 'path' => 'auto/parts/tires', 'url' => 'parts/tires', 'index' => 'auto_parts' ),
	);

	function __construct()
	{
		parent::__construct();
		$this->_rules['source']['auto_cars']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:cars sectionid=%SECTIONID%';
		$this->_rules['source']['auto_parts']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:parts sectionid=%SECTIONID%';
		$this->_rules['source']['auto_trailers']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:trailers sectionid=%SECTIONID%';
		$this->_rules['source']['auto_special']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:special sectionid=%SECTIONID%';
		$this->_rules['source']['auto_moto']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:moto sectionid=%SECTIONID%';
		$this->_rules['source']['auto_water']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/car:water sectionid=%SECTIONID%';
	}
	
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

		$data = $adv->GetData();
		$data['id'] = (int) $attr['_source'];
		$data['created'] = $adv['DateCreate'];
		$data['text'] = $adv['Details'] ? $adv['Details'] : ' ';

		$fields = array(
			'Rudder'		=> array(
				'Тип руля',
				array(
					'Левый',
					'Правый',
				)
			),
			'Year'				=> array('Год выпуска',),
			'Mileage'			=> array('Пробег, км',),
			'Price'				=> array('Цена, руб',),
			'contacts'			=> array('Контактная информация',),
			'Color'				=> array('Цвет кузова',),
			'GearBox'			=> array('Тип коробки',),
			'EngineCapacity'	=> array('Объем двигателя',),
			'BodyType'			=> array('Тип кузова',),
		);

		foreach ($fields as $name => $f_data) {

			if ( !isset($data[$name]) || empty($data[$name]) )
				continue ;

			if ( is_array($f_data[1]) && $f_data[1][$data[$name]] )
				$data[$name] = $f_data[1][$data[$name]];

			$data[$name] = $f_data[0].': '.$data[$name];
		}

		$data['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).$this->_paths[$attr['type']]['url'];
		
		if ( !empty($data['Name']) ) {
			$data['title'] = $data['Name'];
		} else {
			$db = DBFactory::GetInstance('sources');
			if ( !empty($data['Brand']) )
			{
				$sql = "SELECT `Name`,`ModName` FROM `automarka`";
				$sql.= " WHERE `ID` = ". $data['Brand'];
				list($Brand,$url) = $db->query($sql)->fetch_row();
				$data['url'].= '/'. $url;
			}
			if ( !empty($data['Model']) )
			{
				$sql = "SELECT `Name`,`ModName` FROM `automarka`";
				$sql.= " WHERE `ID` = ". $data['Model'];
				list($Model,$url) = $db->query($sql)->fetch_row();
				$data['url'].= '/'. $url;
			}
			$data['title'] = implode(' ', array($Brand,$Model));
		}

		if ( count($adv['Photo']) > 0 )
		{
			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('images');

			try
			{
				$img_obj = FileStore::ObjectFromString($adv['Photo'][0]['PhotoSmall']);
				$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
				$data['Photo'] = Images::PrepareImageFromObject($img_obj, $config['photo']['small']['path'], $config['photo']['url'] .'small/');
				unset($img_obj);
			} catch(BTException $e) {}
		}

		$data['url'].= '/details/'.(int) $attr['_source'] .'.php';
		$data['index'] = $this->_paths[$attr['type']]['index'];

		return $data;
	}
}
