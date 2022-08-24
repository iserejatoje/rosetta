<?

class TagsPlugin_Video extends TagsPluginTrait
{
	private $_cache = null;
	
	public function GetData($items)
	{
		$videoSections = $this->getSectionsVideo();
		$SectionIdModule = $videoSections[App::$Env['regid']];
		$node = STreeMgr::GetNodeById($SectionIdModule);

		$sections[$SectionIdModule] = array(
			'Name' => $node->Name,
			'Link' => ModuleFactory::GetLinkBySectionId($SectionIdModule, array(), true),
		);

		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'video');

		$db = DBFactory::GetInstance($config['db']);
		$ids = array();
		$regionIds = array();
		foreach($items as $item)
		{
			$ids[] = $item['UniqueID'];
			if (!in_array($item['RegionID'], $regionIds))
				$regionIds[] = $item['RegionID'];
		}

		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');
		LibFactory::GetStatic('datetime_my');

		$sql = "SELECT v.*, r.*, r.Date d FROM ".$config['tables']['video']." v";
		$sql.= " INNER JOIN ".$config['tables']['ref']." r ON (r.VideoID=v.VideoID)";
		$sql.= " WHERE r.RegionID IN (".implode(',', $regionIds).")";
		$sql.= " AND v.IsActive=1";
		$sql.= " AND v.VideoID IN (".implode(',', $ids).")";
		$sql.= " GROUP by v.videoid";

		$result = array();
		$res = $db->query($sql);
		while($row = $res->fetch_assoc())
		{
			if (trim($row['Thumb']) != '')
			{
				$thumb = array();
				try
				{
					$img_obj = FileStore::ObjectFromString($row['Thumb']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$thumb = Images::PrepareImageFromObject($img_obj,
						$config['thumb']['path'], $config['thumb']['url']);

					if (empty($thumb))
						continue;

					unset($img_obj);
				}
				catch ( MyException $e )
				{
					continue;
				}

			}
			else
			{
				continue;
			}


			if ($row['Module'] == 'news_magic')
				$url = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
			elseif ($row['Module'] == 'conference')
				$url = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
			elseif ($row['Module'] == 'rating_v2')
				$url = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".php";


			$result[$row['VideoID']] = array(
				'Url'		=> $url,
				'Title'		=> $row['Name'],
				'Text'		=> $row['Description'],
				'Sections'	=> $sections,
				'Time'		=> strtotime(Datetime_my::NowOffset(null, strtotime($row['d']))),
				'ThumbnailImg' 	=> array (
					'File' 		=> $thumb['url'],
					'Width' 	=> $thumb['w'],
					'Height' 	=> $thumb['h'],
				),
			);
		}

		return $result;
	}

	/**
	 * Получить список разедлов на модуле video, с разбивкой по регионам
	 * Кеширует на 6 часов в мемшкеше
	 * @return array - соответсвие regionid и sectionid
	 */
	private function getSectionsVideo()
	{
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'tags_plugin');

		$video_sections = $this->_cache->get('video_sections_list');
		if($video_sections === false)
		{
		    $filter = array(
			    'module'    => 'video',
			    'isvisible' => 1,
			    'deleted'   => 0,
		    );
		    $nodes = STreeMgr::Iterator($filter);
		    foreach($nodes as $node)
		    {
			$video_sections[$node->Regions] = $node->ID;
		    }

		    $this->_cache->set('video_sections_list', $video_sections, 3600*6);
		}

		return $video_sections;
	}
}