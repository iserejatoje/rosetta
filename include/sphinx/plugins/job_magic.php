<?php

class SphinxPlugin_Job_Magic extends SphinxPluginTrait {

	protected $_module = 'job_magic';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 100;
	
	protected $_rights = array(
		'deny' => array(
			'sections' => array(1114, 1116, 4275, 1016),
			'sites' => array(
				984,1015,9772,4319,10522,5016,5019,5021,5023,5025,
				5027,5029,5031,9131,10570,10578,10590,10602,10614,10626,10637,10698 // всяки вапы и т.п.
			),
		),
	);

	protected $_rules = array(
		'source' => array(

	////////// Вакансии


			'job_magic_v' => array(

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
		(v.vid << 32) + %SECTIONID% as id, v.vid as _source, v.pdate as created, v.dolgnost as Title, 1 as Type, \
		CONCAT(r.name, \' \', v.dolgnost, \' \', v.paysum_text, \
		\' \', IF( \
			v.payform = 1,  CONVERT(\'Оклад\' USING utf8 ), \
			IF( \
				v.payform = 2,  CONVERT(\'Оклад+%%\' USING utf8 ), \
				IF( \
					v.payform = 3, \'%%\', \
					IF( \
						v.payform = 4,  CONVERT(\'Подряд\' USING utf8 ), \
						IF( \
							v.payform = 5,  CONVERT(\'Почасовая\' USING utf8 ), \
							IF(v.payform = 6,  CONVERT(\'Сдельная\' USING utf8 ),  CONVERT(\'Другая\' USING utf8 )) \
						) \
					) \
				) \
			) \
		), \
	 \
		\' \', IF( \
			v.jtype = 1,  CONVERT(\'Постоянная\' USING utf8 ), \
			IF( \
				v.jtype = 2,  CONVERT(\'По совместительству\' USING utf8 ), \
				IF(v.jtype = 3,  CONVERT(\'Временная\' USING utf8 ), \'\') \
			) \
		), \
	 \
		\' \', IF( \
			v.grafik = 1,  CONVERT(\'Полный рабочий день\' USING utf8 ), \
			IF( \
				v.grafik = 2,  CONVERT(\'Неполный рабочий день\' USING utf8 ), \
				IF( \
					v.grafik = 3,  CONVERT(\'Свободный\' USING utf8 ), \
					IF(v.grafik = 4,  CONVERT(\'Вахтовый\' USING utf8 ), \'\') \
				) \
			) \
		), \
	 \
		\' \', v.uslov, \
		\' \', v.treb, \
		\' \', v.obyaz, \
		\' \', v.firm_about, \
	 \
		\' \', IF( \
			educat = 1,  CONVERT(\'Высшее\' USING utf8 ), \
			IF( \
				educat = 2,  CONVERT(\'Неоконченное высшее\' USING utf8 ), \
				IF( \
					educat = 3,  CONVERT(\'Среднее\' USING utf8 ), \
					IF( \
						educat = 4,  CONVERT(\'Среднее специальное\' USING utf8 ), \
						IF(educat = 5,  CONVERT(\'Другое\' USING utf8 ), \'\')) \
				) \
			) \
		), \
		\' \', v.lang, \
		\' \', v.comp, \
		\' \', v.baeduc, \
		\' \', v.firm, \
		\' \', v.addr, \
		\' \', v.phones, \
		\' \', v.contact, \
		\' \', v.faxes, \
		\' \', v.http, \
		\' \', v.email, \
	 \
		\' \', IF( \
			v.ability = 1,  CONVERT(\'I степень - физический и умственный труд с небольшими ограничениями\' USING utf8 ), \
			IF( \
				v.ability = 2,  CONVERT(\'II степень - физический труд с ограничениями, умственный - без ограничений\' USING utf8 ), \
				IF(v.ability = 3,  CONVERT(\'III степень - невозможно заниматься тяжелым умственным или физическим трудом\' USING utf8 ), \'\') \
			) \
		), \
	 \
		\' \', IF( \
			v.pol = 1,  CONVERT(\'Мужской\' USING utf8 ), \
			IF(v.pol = 2,  CONVERT(\'Женский\' USING utf8 ), \'\') \
		)) as Text, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.%tables/j_vacancy% as v \
	INNER JOIN rugion.j_razdel as r ON(v.rid = r.rid) \
	WHERE \
		v.hide = 0 AND v.in_state = 0',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,
			),






	///////// Резюме









			'job_magic_r : job_magic_v' => array(

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				'sql_query'		=> ' \
	SELECT \
		(res.resid << 32) + %SECTIONID% as id, res.resid as _source, res.pdate as created, res.dolgnost as Title, 2 as Type, \
		CONCAT(r.name, \' \', res.fio, \' \', res.dolgnost, \' \', res.paysum_text, \
	 \
		\' \', IF( \
			res.jtype = 1, CONVERT(\'Постоянная\' USING utf8 ), \
			IF( \
				res.jtype = 2,  CONVERT(\'По совместительству\' USING utf8 ), \
				IF(res.jtype = 3,  CONVERT(\'Временная\' USING utf8 ), \'\') \
			) \
		), \
	 \
		\' \', IF( \
			res.grafik = 1,  CONVERT(\'Полный рабочий день\' USING utf8 ), \
			IF( \
				res.grafik = 2,  CONVERT(\'Неполный рабочий день\' USING utf8 ), \
				IF( \
					res.grafik = 3,  CONVERT(\'Свободный\' USING utf8 ), \
					IF(res.grafik = 4,  CONVERT(\'Вахтовый\' USING utf8 ), \'\') \
				) \
			) \
		), \
	 \
		\' \', res.vuz, \
		\' \', res.prevrab, \
		\' \', res.lang, \
		\' \', res.comp, \
		\' \', res.baeduc, \
		\' \', res.dopsv, \
		\' \', res.addr, \
		\' \', res.phone, \
		\' \', res.http, \
		\' \', res.email, \
	 \
		\' \', IF( \
			educat = 1,  CONVERT(\'Высшее\' USING utf8 ), \
			IF( \
				educat = 2,  CONVERT(\'Неоконченное высшее\' USING utf8 ), \
				IF( \
					educat = 3,  CONVERT(\'Среднее\' USING utf8 ), \
					IF( \
						educat = 4,  CONVERT(\'Среднее специальное\' USING utf8 ), \
						IF(educat = 5,  CONVERT(\'Другое\' USING utf8 ), \'\')) \
				) \
			) \
		), \
	 \
		\' \', IF( \
			res.ability = 1,  CONVERT(\'I степень - физический и умственный труд с небольшими ограничениями\' USING utf8 ), \
			IF( \
				res.ability = 2,  CONVERT(\'II степень - физический труд с ограничениями, умственный - без ограничений\' USING utf8 ), \
				IF(res.ability = 3,  CONVERT(\'III степень - невозможно заниматься тяжелым умственным или физическим трудом\' USING utf8 ), \'\') \
			) \
		), \
	 \
		\' \', IF( \
			res.pol = 1,  CONVERT(\'Мужской\' USING utf8 ), \
			IF(res.pol = 2,  CONVERT(\'Женский\' USING utf8 ), \'\') \
		), \
	 \
		\' \', IF( \
			res.imp_type = 1,  CONVERT(\'Срочно\' USING utf8 ), \
			IF( \
				res.imp_type = 2,  CONVERT(\'Не очень срочно\' USING utf8 ),  \
				IF(res.imp_type = 3,  CONVERT(\'Сейчас работаю, но интересный вариант готов рассмотреть\' USING utf8 ), \'\') \
			) \
		)) as Text, \
	 \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM %db%.%tables/j_resume% as res \
	INNER JOIN rugion.j_razdel as r ON(res.rid = r.rid) \
	WHERE \
		res.in_state = 0 AND res.hide = 0',

			),
		),


		'index' => array(
			'job_magic_v' => array(
				'source'			=> 'job_magic_v',
				'path'				=> '%VAR_DIR%/job_magic/vacancy',
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

			'job_magic_r : job_magic_v' => array(
				'source'			=> 'job_magic_r',
				'path'				=> '%VAR_DIR%/job_magic/resume',
			),
		),
	);

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$fields = array(
			'fio'			=> array('ФИО',),
			'paysum_text'	=> array('Зарплата',),
			'jtype'			=>
				array(
					'Тип работы',
				array(
					1 => 'Постоянная',
					2 => 'По совместительству',
					3 => 'Временная'
				)
			),
			'payform'		=> array(
				'Форма оплаты',
				array(
					1 => 'Оклад',
					2 => 'Оклад+%',
					3 => '%',
					4 => 'Подряд',
					5 => 'Почасовая',
					6 => 'Сдельная',
					7 => 'Другая'
				)
			),

			'grafik'		=> array(
				'График работы',
				array(
					1 => 'Полный рабочий день',
					2 => 'Неполный рабочий день',
					3 => 'Свободный',
					4 => 'Вахтовый'
				)
			),
			'uslov'			=> array('Условия',),
			'treb'			=> array('Требования',),
			'obyaz'			=> array('Обязанности',),
			'firm_about'	=> array('О компании',),
			'educat'		=> array(
				'Образование',
				array(
					1 => 'Высшее',
					2 => 'Неоконченное высшее',
					3 => 'Среднее',
					4 => 'Среднее специальное',
					5 => 'Другое'
				)
			),
			'vuz'			=> array('Учебное заведение',),
			'prevrab'		=> array('Места предыдущей работы',),
			'lang'			=> array('Знание языков',),
			'comp'			=> array('Знание компьютера',),
			'baeduc'		=> array('Бизнес-образование',),
			'dopsv'			=> array('Дополнительные сведения',),
			'imp_type'		=> array(
				'Важность',
				array(
					1 => 'Срочно',
					2 => 'Не очень срочно',
					3 => 'Сейчас работаю, но интересный вариант готов рассмотреть',
				)
			),
			'ability'		=> array('Степень ограничения трудоспособности',),
			'pol'			=> array(
				'Пол',
				array(
					1 => 'Мужской',
					2 => 'Женский'
				)
			),

			'firm'			=> array('Компания',),
			'contact'		=> array('Контактное лицо',),
			'addr'			=> array('Адрес',),
			'phone'			=> array('Телефон',),
			'phones'		=> array('Телефон',),
			'faxes'			=> array('Факс',),
			'http'			=> array('http',),
			'email'			=> array('E-mail',),
		);

		$db = DBFactory::GetInstance($config['db']);

		if ( $attr['type'] == 1 ) {

			$sql = 'SELECT vid, dolgnost, paysum_text, payform, jtype, grafik, ';
			$sql .= ' uslov, treb, obyaz, firm_about, educat, lang, ';
			$sql .= ' comp, baeduc, pol, ability, firm, addr, phones, ';
			$sql .= ' contact, faxes, http, email, pdate as created FROM '.$config['tables']['j_vacancy'];
			$sql .= ' WHERE `vid` = '.(int) $attr['_source'].' AND ';
			$sql .= ' `hide` = 0 AND in_state IN(0,1)';

		} else if ( $attr['type'] == 2 ) {
			$sql = 'SELECT resid, dolgnost,paysum_text, jtype, grafik, ';
			$sql .= ' imp_type, educat, lang, dopsv, ';
			$sql .= ' comp, baeduc, pol, ability, vuz, addr, phone, ';
			$sql .= ' prevrab, fio, http, email, pdate as created FROM '.$config['tables']['j_resume'];
			$sql .= ' WHERE `resid` = '.(int) $attr['_source'].' AND ';
			$sql .= ' `hide` = 0 AND in_state IN(0,1)';

		}

		$res = $db->query($sql);
		if ( !$res || !$res->num_rows )
				return null;

		$pData = array();
		$data = $res->fetch_assoc();
		foreach ($fields as $name => $f_data) {

			if ( !isset($data[$name]) || empty($data[$name]) )
				continue ;

			if ( is_array($f_data[1]) && $f_data[1][$data[$name]] )
				$data[$name] = $f_data[1][$data[$name]];

			$pData[$name] = $f_data[0].': '.$data[$name];
		}

		$pData['text'] = implode(' ', $pData);
		$pData['created'] = $data['created'];
		$pData['title'] = $data['dolgnost'];

		if ( $attr['type'] == 1) {
			$pData['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'vacancy/'.$data['vid'].'.html';
			$pData['index'] = 'job_magic_v';
		} else if ( $attr['type'] == 2) {
			$pData['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'resume/'.$data['resid'].'.html';
			$pData['index'] = 'job_magic_r';
		}

		return $pData;
	}
}
