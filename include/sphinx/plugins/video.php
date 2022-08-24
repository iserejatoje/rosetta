<?php

class SphinxPlugin_Video extends SphinxPluginTrait {

	protected $_module = 'video';

	protected $_type = Sphinx::PT_SINGLE_REF;

	protected $_group = 5;

	protected $_rights = array();

	protected $_rules = array(
		'source' => array(
			'video_search' => array(

				'type'		=> 'mysql',
				'sql_host'	=> 'video.r2.mysql',
				'sql_user'	=> 'video',
				'sql_pass'	=> 'video',
				'sql_db'	=> 'video',
				'sql_port'	=> 3306,
				#'mysql_connect_flags'	=> 32,

				'sql_query_pre'	=> array(
					'SET NAMES utf8',
					'SET SESSION query_cache_type=OFF',
				),

				//'sql_query_range' => 'SELECT MIN(video.videos.VideoID),MAX(video.videos.VideoID) FROM video.videos WHERE video.videos.VideoID > 0',
				//'sql_range_step' => 1000,

				'sql_query'		=> 'SELECT \
		video.videos_ref.RefID as id, \
		UNIX_TIMESTAMP(video.videos.Date) as created, \
		video.videos.VideoID as _source, \
		video.videos.Name as title, \
		video.videos.Description as text, \
		0 as `Type`, \
		%SECTIONID% as SECTIONID, \
		%REGID% as REGID, \
		%SITEID% as SITEID \
	FROM \
		video.videos \
		INNER JOIN video.videos_ref ON (video.videos_ref.VideoID = video.videos.VideoID) \
	WHERE \
		video.videos.IsActive = 1 \
		AND video.videos_ref.RegionID = %REGID% \
	GROUP by video.videos.VideoID',

				'sql_attr_uint'	=> array(
					'Type', '_source', 'sectionid', 'siteid', 'regid'
				),

				'sql_attr_timestamp'	=> 'created',

				# ranged query throttling, in milliseconds
				# optional, default is 0 which means no delay
				# enforces given delay before each query step
				'sql_ranged_throttle'	=> 0,
			),
		),


		'index' => array(
			'video_search' => array(
				'source'		=> 'video_search',
				'path'			=> '%VAR_DIR%/video/search',
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

	public function GetObjectData(array $attr) {

		$config = ModuleFactory::GetConfigById('section', $attr['sectionid']);
		if (empty($config))
			return null;

		$db = DBFactory::GetInstance($config['db']);

		$sql = 'SELECT * FROM '.$config['tables']['video'];
		$sql.= ' WHERE VideoID = '.(int) $attr['_source'];

		$res = $db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		$video = $res->fetch_assoc();

		if ($video['Thumb']) {
			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('images');
			
			try
			{
				$img_obj = FileStore::ObjectFromString($video['Thumb']);
				$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
				$data['Thumb']  = Images::PrepareImageFromObject($img_obj, 
						$config['thumb']['path'], $config['thumb']['url']);
				
				unset($img_obj);
			}
			catch ( MyException $e ) { }

		}

		$data['title'] = $video['Name'];
		$data['text'] = $video['Description'];
		$data['created'] = $video['Date'];
		$data['Views'] = $video['Views'];
		$data['Duration'] = date('i:s',$video['Duration']);

		$sql = "SELECT * FROM ".$config['tables']['ref'];
		$sql.= " WHERE RegionID=".App::$Env['regid']." AND IsActive=1";
		$sql.= " AND VideoID = ".(int) $attr['_source'];

		$res = $db->query($sql);
		if ($res && $res->num_rows) {
			while(false != ($row = $res->fetch_assoc()))
			{
				if ($row['Module'] == 'news_magic')	{
					$data['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
				} elseif ($row['Module'] == 'conference') {
					$data['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
				} elseif ($row['Module'] == 'rating_v2') {
					$data['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".php";
				}
				break ;
			}
		} else
			return array();

		$data['index'] = 'video_search';

		return $data;
	}
}
