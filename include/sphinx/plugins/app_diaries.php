<?php

class SphinxPlugin_App_Diaries extends SphinxPluginTrait {

	protected $_module = 'app_diaries';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 7;
	
	protected $_rights = array();

	protected $_rules = array(
		'source' => array(
			'app_diaries_records' => array(

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
		RecordID as id, RecordID as _source, UNIX_TIMESTAMP(Created) as created, 1 as Type, \
		Title, \
		TextHTML as Text, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID, \
		1 as Priority \
	FROM users_diaries_records\
	WHERE \
		RegionID = %REGID% AND PublicState = 2 AND `Created` < NOW()',
				'sql_attr_uint'			=> array(
					'Type', '_source', 'SECTIONID', 'REGID', 'SITEID', 'Priority',
				),
				'sql_attr_timestamp'	=> 'Created',
				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'app_diaries_records' => array(
				'source'			=> 'app_diaries_records',
				'path'				=> '%VAR_DIR%/app_diaries/records',
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

		LibFactory::GetMStatic('diaries', 'diarymgr');
	
		$record = DiaryMgr::getInstance()->GetRecordByID($attr['_source'], null, true);
		if ($record === null)
			return null;

		$pData['title'] = $record['Title'];
		$pData['text'] = strip_tags($record['TextHTML']);
		$pData['created'] = $record['Created'];

		$pData['url'] = ModuleFactory::GetLinkBySectionId($attr['sectionid']).'post/'.$record['UserID'].'/'.$record['RecordID'].'.php';

		return $pData;
	}
}
