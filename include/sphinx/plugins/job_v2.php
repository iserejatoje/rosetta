<?php

class SphinxPlugin_Job_v2 extends SphinxPluginTrait {

	protected $_module = 'job_v2';

	protected $_type = Sphinx::PT_SINGLE_REF;
	
	protected $_group = 100;

	protected $_rights = array(
		/*'deny' => array(
			'sites' => array(
				984,1015,9772,4319,10522,5016,5019,5021,5023,5025,
				5027,5029,5031,9131,10570,10578,10590,10602,10614,10626,10637,10698 // всяки вапы и т.п.
			),
		),*/
		
		'allow' => array(
			'sections' => array(1019, 1023, 1018, 1006, 1022, 1016, 866, 1488),
		),
	);

	protected $_rules = array(
		'source' => array(
	/*********************************************************************************
		Objects
	*/

			'vacancy_search' => array(

				/* Если так делать - перенести определение команды в конструктор и использовать ENGINE_PATH
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				*/

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

				'sql_range_step' => 1000,

				'sql_query'		=> ' \
		SELECT \
			(v.vid << 32) + %SECTIONID% as id, v.vid as _source, UNIX_TIMESTAMP(v.pdate) as created, 1 as Type, \
			UNIX_TIMESTAMP(v.pdate) as UpdateDate, \
			v.paysum as PaySum, \
			v.payform as PayForm, v.in_state as InState, \
			v.educat as Education, v.imp as Important, \
			v.grafik as Schedule, v.pol as Sex, \
			v.firm as Firm, \
			f.scope as Scope, \
			f.search_promote as Promote, \
			CONCAT( \
				GROUP_CONCAT(IF(isnull(p.Name),\'\',p.Name)) \
			) as Position, \
		CONCAT( \
				   IF(v.jtype & 1, \'_1_\', \'\'), \
				   IF(v.jtype & 4, \'_4_\', \'\'), \
				   IF(v.jtype & 8, \'_8_\', \'\'), \
				   IF(v.jtype & 16, \'_16_\', \'\'), \
				   IF(v.jtype & 32, \'_32_\', \'\'), \
				   IF(v.jtype & 64, \'_64_\', \'\'), \
				   IF(v.jtype & 128, \'_128_\', \'\'), \
				   IF(v.jtype & 256, \'_256_\', \'\') \
			) as `WorkType`, \
			v.city_id as LocationID, \
			v.region as RegionID, \
			%SECTIONID% as SECTIONID, \
			%REGID% as REGID, \
			%SITEID% as SITEID, \
			1 as Priority \
		FROM %db%.%tables/j_vacancy% as v \
		INNER JOIN %db%.%tables/j_vac_branch_ref% as b ON(b.VacancyID = v.vid) \
		LEFT JOIN rugion.j_position as p ON(p.PositionID = b.PositionID) \
		LEFT JOIN %db%.%tables/firm% as f ON (f.fid = v.fid) \
		WHERE \
			v.hide = 0 AND v.in_state = 0 AND v.Is_New IN(0,1) GROUP by v.vid',
				'sql_attr_timestamp'	=> array('created', 'UpdateDate'),
				'sql_attr_uint'			=> array(
					'Type', '_source', 'PayForm', 'PaySum', 'InState', 'Education', 'Important', 'Priority',
					'Schedule', 'Sex', 'SECTIONID', 'REGID', 'SITEID', 'LocationID', 'RegionID', 'Scope', 'Promote'
				),

				'sql_attr_multi'		=> array(
						'uint PositionID from query; \
		SELECT (d.vid << 32) + %SECTIONID% as id, r.PositionID \
		FROM %db%.%tables/j_vacancy% as d \
		INNER JOIN %db%.%tables/j_vac_branch_ref% as r ON(r.VacancyID = d.vid) \
		WHERE d.`Hide` = 0 AND d.In_State IN(0,1) AND d.`Is_New` IN(0,1)',

						'uint SpecialityID from query; \
		SELECT (d.vid << 32) + %SECTIONID% as id, r.SpecialityID \
		FROM %db%.%tables/j_vacancy% as d \
		INNER JOIN %db%.%tables/j_vac_branch_ref% as r ON(r.VacancyID = d.vid AND r.SpecialityID > 0) \
		WHERE d.`Hide` = 0 AND d.In_State IN(0,1) AND d.`Is_New` IN(0,1)',

						'uint BranchID from query; \
		SELECT (b.VacancyID << 32) + %SECTIONID% as id, b.BranchID \
		FROM %db%.%tables/j_vac_branches_ref% as b \
		WHERE b.`Hide` = 0 AND b.InState IN(0,1) AND b.`IsNew` IN(0,1)'
					),

				'sql_ranged_throttle'	=> 200,
			),

			'resume_search' => array(

                /*
				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				*/

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

				'sql_range_step' => 1000,

				'sql_query'		=> ' \
	SELECT (r.`ResumeID` << 32) + %SECTIONID% as id, r.ResumeID as _source, \
	UNIX_TIMESTAMP(r.`UpdateDate`) as created, UNIX_TIMESTAMP(r.`UpdateDate`) as UpdateDate, 2 as Type, \
	r.`Education`, r.`Schedule`, r.`Sex`, r.`InState`, r.`Important`, \
	IF(LEFT(r.Birthday,4) != \'0000\', TRUNCATE(( ( YEAR(CURDATE()) * 12 + MONTH(CURDATE()) ) - ( LEFT(r.Birthday,4) *12 + IF(SUBSTRING(r.Birthday,6,2) != \'00\', SUBSTRING(r.Birthday,6,2)  ,0) ) )/12,0 ),0) as Birthday, \
	CONCAT(r.MidName, \' \', r.FirstName, \' \', r.LastName, \' \', r.Position, \' \', \
		\' \', r.CareerTemp, \
		\' \', r.FurtherEducation, \
		\' \', r.ProfessionalSkills, \
		\' \', r.About, \
		\' \', r.AddressTemp, \
		\' \', r.Phone, \
		\' \', r.HTTP, \
		\' \', r.Email, \
		\' \', GROUP_CONCAT(IF(isnull(p.Name),\'\',p.Name)), \
		\' \', GROUP_CONCAT(IF(isnull(br.Name),\'\',br.Name)) \
	) as Text, \
	IF(isnull(cc.ObjectID), 0, cc.ObjectID) as LocationID, \
	CONCAT( \
			   IF(r.WorkType & 1, \'_1_\', \'\'), \
			   IF(r.WorkType & 4, \'_4_\', \'\'), \
			   IF(r.WorkType & 8, \'_8_\', \'\'), \
			   IF(r.WorkType & 16, \'_16_\', \'\'), \
			   IF(r.WorkType & 32, \'_32_\', \'\'), \
			   IF(r.WorkType & 64, \'_64_\', \'\'), \
			   IF(r.WorkType & 128, \'_128_\', \'\'), \
			   IF(r.WorkType & 256, \'_256_\', \'\') \
		) as `WorkType`, \
	%SECTIONID% as SECTIONID, \
	%REGID% as REGID, \
	%SITEID% as SITEID, \
	1 as Priority \
	FROM %db%.%tables/j_resume% as r \
	INNER JOIN %db%.%tables/j_res_branch_ref% as b ON(b.ResumeID = r.ResumeID) \
	LEFT JOIN rugion.j_branch as br ON(br.BranchID = b.BranchID) \
	LEFT JOIN rugion.j_position as p ON(p.PositionID = b.PositionID) \
	LEFT JOIN sources.location_objects_new as cc ON(cc.Code = IF(LENGTh(r.LocationCity)=22,r.LocationCity,CONCAT(r.LocationCity,\'0000\'))) \
	WHERE \
		 r.`Hide` = 0 AND \
		 r.`InState` IN(0,1) AND \
		 r.`IsNew` IN(0,1) GROUP by r.ResumeID',
				'sql_attr_timestamp'	=> array('created', 'UpdateDate'),
				'sql_attr_uint'			=> array(
					'Type', '_source', 'Priority', 'InState', 'LocationID', 'Education', 'Important', 'Schedule', 'Sex', 'Birthday', 'SECTIONID', 'REGID', 'SITEID',
				),

				'sql_attr_multi'		=> array(
						'uint PositionID from query; \
		SELECT (d.ResumeID << 32) + %SECTIONID% as id, r.PositionID \
		FROM %db%.%tables/j_resume% as d \
		INNER JOIN %db%.%tables/j_res_branch_ref% as r ON(r.ResumeID = d.ResumeID) \
		WHERE d.`Hide` = 0 AND d.InState IN(0,1) AND d.`IsNew` IN(0,1)',

						'uint SpecialityID from query; \
		SELECT (d.ResumeID << 32) + %SECTIONID% as id, r.SpecialityID \
		FROM %db%.%tables/j_resume% as d \
		INNER JOIN %db%.%tables/j_res_branch_ref% as r ON(r.ResumeID = d.ResumeID AND r.SpecialityID > 0) \
		WHERE d.`Hide` = 0 AND d.InState IN(0,1) AND d.`IsNew` IN(0,1)',

						'uint BranchID from query; \
		SELECT (b.ResumeID << 32) + %SECTIONID% as id, b.BranchID \
		FROM %db%.%tables/j_res_branches_ref% as b \
		WHERE b.`Hide` = 0 AND b.InState IN(0,1) AND b.`IsNew` IN(0,1)'
					),
				'sql_ranged_throttle'	=> 200,
			),
		),
		///home/codemaker/sphinx/production/bin/indexer --config /home/codemaker/sphinx/production%CONF_DIR%.conf resume_search


		'index' => array(

			'vacancy_search' => array(
				'source'			=> 'vacancy_search',
				'path'				=> '%VAR_DIR%/job_v2/vacancy',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_ru, stem_en',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 3,
				'charset_type'		=> 'utf-8',
				'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 1,
				//'min_infix_len'		=> 3,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
			),

			'resume_search' => array(
				'source'			=> 'resume_search',
				'path'				=> '%VAR_DIR%/job_v2/resume',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_ru, stem_en',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'min_prefix_len'	=> 2,
				'charset_type'		=> 'utf-8',
				'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 1,
				//'min_infix_len'		=> 3,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
			),
		),
	);

	function __construct()
	{
		parent::__construct();
		/*
		$this->_rules['source']['vacancy_search']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/job_v2:vacancy sectionid=%SECTIONID%';
		$this->_rules['source']['resume_search']['xmlpipe_command'] = ENGINE_PATH .'shell.sh action=sphinx/source/job_v2:resume sectionid=%SECTIONID%';
		*/
	}
	
	public function GetObjectData(array $attr) {
		
		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		

		if ($attr['type'] == 1) {
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
		} else if ($attr['type'] == 2) {
			$fields = array(
				'Name'			=> array('ФИО',),
				'WageText'	=> array('Зарплата',),
				'WorkType'			=>
					array(
						'Тип работы',
					array(
						1 => 'Постоянная',
						2 => 'По совместительству',
						3 => 'Временная'
					)
				),

				'Schedule'		=> array(
					'График работы',
					array(
						1 => 'Полный рабочий день',
						2 => 'Неполный рабочий день',
						3 => 'Свободный',
						4 => 'Вахтовый'
					)
				),
				'Education'		=> array(
					'Образование',
					array(
						1 => 'Высшее',
						2 => 'Неоконченное высшее',
						3 => 'Среднее',
						4 => 'Среднее специальное',
						5 => 'Другое'
					)
				),
				'CareerTemp'			=> array('Места предыдущей работы',),
				'ProfessionalSkills'	=> array('Профессиональные навыки',),
				'FurtherEducation'		=> array('Дополнительно образование',),
				'About'					=> array('О себе',),
				'Importance'			=> array(
					'Важность',
					array(
						1 => 'Срочно',
						2 => 'Не очень срочно',
						3 => 'Сейчас работаю, но интересный вариант готов рассмотреть',
					)
				),
				'Ability'		=> array('Степень ограничения трудоспособности',),
				'Sex'			=> array(
					'Пол',
					array(
						1 => 'Мужской',
						2 => 'Женский'
					)
				),

				'AddressTemp'			=> array('Адрес',),
				'Phone'			=> array('Телефон',),
				'HTTP'			=> array('http',),
				'Email'			=> array('E-mail',),
			);
		}

		$db = DBFactory::GetInstance($config['db']);

		if ( $attr['type'] == 1 ) {
			$sql = 'SELECT vid, dolgnost, paysum_text, payform, jtype, grafik, ';
			$sql .= ' uslov, treb, obyaz, firm_about, educat, lang, ';
			$sql .= ' comp, baeduc, pol, ability, firm, addr, phones, ';
			$sql .= ' contact, faxes, http, email, pdate as created FROM '.$config['tables']['j_vacancy'];
			$sql .= ' WHERE `vid` = '.(int) $attr['_source'].' AND ';
			$sql .= ' `hide` = 0 AND in_state IN(0,1)';

		} else if ( $attr['type'] == 2 ) {
			$sql = 'SELECT ResumeID, Position, WageText, WorkType, Schedule, ';
			$sql .= ' Importance, Education, About, ';
			$sql .= ' Sex, Ability, AddressTemp, Phone, ProfessionalSkills, FurtherEducation';
			$sql .= ' CareerTemp, concat(`MidName`,\' \',`FirstName`,\' \',`LastName`) as Name, HTTP, Email, UpdateDate FROM '.$config['tables']['j_resume'];
			$sql .= ' WHERE `ResumeID` = '.(int) $attr['_source'].' AND ';
			$sql .= ' `Hide` = 0 AND InState IN(0,1)';
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

		if ( $attr['type'] == 1) {
			$pData['title'] = $data['dolgnost'];
			$pData['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'vacancy/'.$data['vid'].'.html';
			$pData['index'] = 'vacancy_search';
			if ( empty($pData['title']) )
				$pData['title'] = 'Вакансия №'. $data['vid'];
		} else if ( $attr['type'] == 2) {
			$pData['title'] = $data['Position'];
			$pData['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'resume/'.$data['ResumeID'].'.html';
			$pData['index'] = 'resume_search';
			if ( empty($pData['title']) )
				$pData['title'] = 'Резюме №'. $data['ResumeID'];
		}

		return $pData;
	}
}
