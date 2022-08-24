<?

class lib_multimedia
{
	// типы
	// 0 - раздел
	// 1 - видео файл
	// 2 - аудио файл
	// 3 - плейлист
	// 4 - произвольный видео файл
	// 5 - произвольный аудио файл
	public $config = array(
		'path' => array(
			'types' => array(
				0 => '',
				1 => '/common_fs/i/stream/video/',
				2 => '/common_fs/i/stream/audio/',
				3 => '',
				4 => '',
				5 => '',
				6 => '/common_fs/i/stream/video_source/',
				7 => '/common_fs/i/stream/advertise/',
			),
			'preview' => '/common_fs/i/stream/preview/',
		),
		'url' => array(
			'types' => array(
				0 => '',
				1 => 'http://mediacontent.rugion.ru/_i/stream/video/',
				2 => 'http://mediacontent.rugion.ru/_i/stream/audio/',
				3 => '',
				4 => '',
				5 => '',
				6 => 'http://mediacontent.rugion.ru/_i/stream/video_source/',
				7 => 'http://mediacontent.rugion.ru/_i/stream/advertise/',
			),
			'player' => 'http://media.rugion.ru/m/',
			'preview' => 'http://mediacontent.rugion.ru/_i/stream/preview/',
		),
		'types' => array(
			'folder'		=> 0,
			'video'			=> 1,
			'audio'			=> 2,
			'playlist'		=> 3,
			'customvideo'	=> 4,
			'customaudio'	=> 5,
			'video_source'	=> 6,
			'advertise'		=> 7,
		),
		'selective_types' => array( // может указать пользователь
			1 => array('type' => 'video', 'title' => 'Видео'),
			2 => array('type' => 'audio', 'title' => 'Аудио'),
			7 => array('type' => 'advertise', 'title' => 'Реклама'),
		),
		// высота / ширина
		'selective_aspectratio' => array(
			'4:3' => array('ratio' => 0.75, 'title' => '4:3 (400x300)', 'width' => 400, 'height' => 300),
			'16:9' => array('ratio' => 0.5625, 'title' => '16:9 (400x225)', 'width' => 400, 'height' => 225),
			'16:9_2' => array('ratio' => 0.5625, 'title' => '16:9 (500x280)', 'width' => 500, 'height' => 280),
			//'16:10' => array('ration' => 0.625, 'title' => '16:10', 'width' => 400, 'height' => 250), // широкоформатные мониторы
		),
		'valid_types' => array(
			'application/octet-stream',
			'audio/mpeg',
			'video/x-msvideo',
			'video/mp4',
		),
		'db' => 'media',
		'tables' => array(
			'tree' 			=> 'tree',
			'plm_ref' 		=> 'playlist_media_ref',
			'links_list' 	=> 'links_list',
			'links_ref' 	=> 'links_ref',
			'acl'			=> 'BannersACL',
		),
		
		'acls'	 => array(
			'allow'		=> 'Разрешить',
			'deny'		=> 'Запретить',
		),
		'acl_field'	=> array(
			'site'	=> 'Сайт',
			'ref'		=> 'Реферер',
		),
		'acl_condition'	=> array(
			'equal'		=> 'Соответствует',
			'notequal'	=> 'Не соответствует',
			'contains'	=> 'Содержит',
		),
	);
	private $db = null;
	function __construct()
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		$this->config['path']['upload'] = '/common_fs/i/stream/upload/';
		$this->db = DBFactory::GetInstance($this->config['db']);
	}
	
	//Разработка библиотеки управление мультимедиа файлами (заливка, перемещение, удаление, работа с древовидными каталогами,
    //генерация хтмл, ББ кода для выставления на страницах, поддержка ссылок на другие источники)
	
	function GetConfig($id, $typePlayer = "", $ref = "")
	{
		$sql = "SELECT * FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE IsVisible=1 AND TreeID=".$id;
		
		$res = $this->db->query($sql);
		if($row = $res->fetch_assoc())
		{		
			if ($typePlayer=="AsFlash")
				return $this->GetConfigAsFlash($row, $ref);
			elseif ($typePlayer=="AudioAsFlash")
				return $this->GetConfigAudioAsFlash($row);
			else
				return $this->GetConfigFlowPlayer($row);
		}
		else
			return array();
	}
	
	/**
	 * Получить информацию о файле медиа
	 *
	 * @param int id - TreeID медиа-файла
	 * @return array(), в случае ошибки null
	 */
	function GetInfo($id) 
	{
		if ( ($row = $this->GetFile($id)) === null )
			return null;
		
		try
		{
			$preparedImage = $this->GetPreview($row['PreviewImage']);
			$img = $preparedImage['url'];
		}
		catch( MyException $e )
		{
			$img = "none";
		}
		
		try
		{
			$preparedFile = $this->GetMediaFile($row['Path'], $row['Type']);
			$media_url = $preparedFile['url'];
		}
		catch( MyException $e ) {
			return null;
		}
		
		return array(
			'MediaLink'		=> $media_url,
			'FileInfo'		=> $preparedFile['mime_type'],
			'PreviewImage'	=> $img,
			'showLogo'		=> (($row['ShowLogo'] == 0) ? false : true),
			'filesize_source' => $row['filesize_source'],
			'FlagDownload'	=> $row['path_download']!="" ? 1: 0,
			'width_source'	=> $row['Width'],
			'height_source' => $row['Height'],
			'duration' 		=> $row['duration'],
			'width' 		=> isset($this->config['selective_aspectratio'][$row['AspectRatio']]) 
								? $this->config['selective_aspectratio'][$row['AspectRatio']]['width']
								: $row['Width'],
			'height' 		=> isset($this->config['selective_aspectratio'][$row['AspectRatio']]) 
								? $this->config['selective_aspectratio'][$row['AspectRatio']]['height']+30
								: $row['Height']+30,
		);
	}
	
	/**
	 * Получить конфиг плеера AudioAsFlash (проигрыватель mp3)
	 * 
	 * @param array row - строчка из базы
	 * @return array()
	 */
	private function GetConfigAudioAsFlash($row)
	{		
		if($row['Type'] == 2)
		{
			try
			{
				$preparedFile = $this->GetMediaFile($row['Path'], $row['Type']);
				$media_url = $preparedFile['url'];
			}
			catch( MyException $e ) {
				return array();
			}
			
			return array(
				'AudioLink' => $media_url,
				'title' => strip_tags(addslashes($row['Title'])),
				'filesize_source' => $row['filesize_source'],
				'duration' => $row['duration'],
			);
		}
		else
			return array();
	}
	
	/**
	 * Получить конфиг плеера AsFlash
	 * 
	 * @param array row - строчка из базы
	 * @param string ref - реферер (для баннеров)
	 * @return array()
	 */
	private function GetConfigAsFlash($row, $ref)
	{
		try
		{
			$preparedFile = $this->GetMediaFile($row['Path'], $row['Type']);
			$media_url = $preparedFile['url'];
		}
		catch( MyException $e ) {
			return array();
		}
	
		if($row['Type'] == 1 || $row['Type'] == 7)
		{
			if ($row['ShowLogo'] == 1)
			{
				$banners = $this->GetBanners();
				$banner = current($banners);
				$bannerId = $banner['TreeID'];
			}
			elseif ($row['ShowAdvertise'] == 1)
			{
				//$this->ClearBannersCache();
				$banners = $this->GetBanners();
				
				$bannerId = 0;
				if (count($banners) > 0 && is_array($banners))
				{
					$showingBanners = array();
					foreach($banners as $banner)
						if ($this->IsAllow($banner, $ref))
							$showingBanners[] = $banner;
							
					$bannerId = $this->getRotateBanner($showingBanners);
				}
			}
			
			if(!empty($row['PreviewImage']))
			{
				try
				{
					$preview = $this->GetPreview($row['PreviewImage']); //Получить путь к файлу превьюшки
					$img = $preview['url'];
				}
				catch(MyException $e) {
					$img = "none";
				}
			}
			
			return array(
				'MediaLink'		=> $media_url,
				'PreviewImage'	=> $img,
				'showLogo'		=> (($row['ShowLogo'] == 0) ? false : true),
				'filesize_source' => $row['filesize_source'],
				'FlagDownload'	=> $row['path_download']!="" ? 1: 0,
				'width_source'	=> $row['Width'],
				'height_source' => $row['Height'],
				'duration' 		=> $row['duration'],
				'width' 		=> isset($this->config['selective_aspectratio'][$row['AspectRatio']]) 
									? $this->config['selective_aspectratio'][$row['AspectRatio']]['width']
									: $row['Width'],
				'height' 		=> isset($this->config['selective_aspectratio'][$row['AspectRatio']]) 
									? $this->config['selective_aspectratio'][$row['AspectRatio']]['height']+30
									: $row['Height']+30,
				'advertiseid'	=> $bannerId,
				'advertise'		=> $bannerId > 0 ? $banners[$bannerId]['url'] : '',
				'post'			=> $bannerId > 0 ? $banners[$bannerId]['IsPostRoll'] : '',
				'advertiseurl'	=> $bannerId > 0 ? $banners[$bannerId]['AdvertiseUrl'] : '',
			);
		}
		elseif($row['Type'] == 2)
		{
			return array(
				'AudioLink' => $media_url,
				'title' => strip_tags(addslashes($row['Title'])),
				'filesize_source' => $row['filesize_source'],
				'duration' => $row['duration'],
			);
		}
		else
			return array();
	}
	
	/**
	 * Получить конфиг для flow-player'а !!DEPRECATED
	 *
	 * @param array row - строка из базы 
	 * @return array()
	 */
	private function GetConfigFlowPlayer($row)
	{
		try
		{
			$preparedFile = $this->GetMediaFile($row['Path'], $row['Type']);
			$media_url = $preparedFile['url'];
		}
		catch( MyException $e ) {
			return array();
		}
		
		if($row['Type'] == 1)
		{
			return array(
				'clip' => array(
					'url' => $media_url,
					'autoPlay' => false,
					'scaling' => 'fit',
					'provider' => 'nginx',
				),
				'plugins' => array(
					'controls' => array(
						'url' => $this->config['url']['controls']
					),
					'nginx' => array(
						'url' => $this->config['url']['pseudostreaming']
					),
				)
			);
		}
		elseif($row['Type'] == 2)
		{
			return array(
				'clip' => array(
					'url' => $media_url,
					'autoPlay' => false,
					'scaling' => 'fit'
				),
				'plugins' => array(
					'controls' => array(
						'url' => $this->config['url']['controls'],
						'fullscreen' => false, 
						'height' => 30
					),
					'audio' => array(
						'url' => $this->config['url']['audio']
					),
				)
			);
		}
		elseif($row['Type'] == 3)
		{
			$playlist = array();
			$objects = $this->GetObjects(array('playlist' => $row['TreeID']));
			if(count($objects) > 0)
			{
				foreach($objects as $o)
				{
					$playlist[] = array(
						'url' => $media_url,
						'scaling' => 'fit'
					);
				}
				$playlist[0]['autoPlay'] = false;
			}
			return array(
				'clip' => array(
					//'autoPlay' => false,
				),
				'playlist' => $playlist,
				'plugins' => array(
					'controls' => array(
						'playlist' => true,
						'url' => $this->config['url']['controls']
					),
					'audio' => array(
						'url' => $this->config['url']['audio']
					),
				)
			);
		}
	}
	
	
	
	/**
	 * Получение дерева, под вопросом, если будет большое дерево, то жрать будет много
	 * Необходима только для админки
	 */
	function GetTree()
	{
		// Не используется
	}
	
	/**
	 * Получить список веток
	 *
	 * @param array types - необходиме типы
	 * @param int offset - смещение (для постранички)
	 * @param int limit - количество элементов (для постранички)
	 * @return array()
	 */
	function GetList(array $types = array(), $offset = null, $limit = null)
	{
		$sql = 'SELECT * FROM '.$this->config['tables']['tree'].' WHERE ';
		$sql.= ' Type IN('.implode(',',$types).')';
		$sql.= ' ORDER BY Created DESC';
		if($limit !== null)
		{
			$limit = intval($limit);
			$sql.= ' LIMIT ';
			if($offset !== null)
			{
				$offset = intval($offset);
				$sql.= $offset.',';
			}
			$sql.= $limit;
		}
		$res = $this->db->query($sql);
		$list = array();
		while($row = $res->fetch_assoc())
			$list[] = $row;
		return $list;
	}
	
	/**
	 * Получить количество веток
	 *
	 * @param array types - необходиме типы
	 * @return int - Количество элементов в ветке (если ошибка, то 0)
	 */
	function GetCountList(array $types = array())
	{
		$sql = 'SELECT count(*) FROM '.$this->config['tables']['tree'].' WHERE ';
		$sql.= ' Type IN('.implode(',',$types).')';
		$sql.= ' ORDER BY Type, Title';

		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			return $row[0];
		return 0;
	}
	
	/**
	 * Получить список ссылок
	 *
	 * @param int id - id-шник файла
	 * @param int offset - смещение (для постранички)
	 * @param int limit - количество элементов (для постранички)
	 * @return array()
	 */
	function GetLinks($id, $offset = null, $limit = null)
	{
		if(!is_numeric($id))
			return null;

		$sql = 'SELECT r.*, l.LinkData, SUM(ViewsCount) as ViewsCount, SUM(PlayCount) as PlayCount FROM '.$this->config['tables']['links_ref'].' as r ';
		$sql.= ' INNER JOIN '.$this->config['tables']['links_list'].' l ON (l.LinkID = r.LinkID)';
		$sql.= ' WHERE FileID = '.(int) $id;
		$sql.= ' GROUP BY r.LinkID';
		$sql.= ' ORDER BY l.LinkData';

		if($limit !== null)
		{
			$limit = intval($limit);
			$sql.= ' LIMIT ';
			if($offset !== null)
			{
				$offset = intval($offset);
				$sql.= $offset.',';
			}
			$sql.= $limit;
		}
		$res = $this->db->query($sql);
		$list = array();
		while($row = $res->fetch_assoc())
			$list[] = $row;
		return $list;
	}
	
	/**
	 * Получить количество ссылок
	 *
	 * @param int id - id-шник ссылки
	 * @return int - Количество ссылок (если ошибка, то 0)
	 */
	function GetCountLinks($id)
	{
		if(!is_numeric($id))
			return 0;

		$sql = 'SELECT count(DISTINCT LinkID) FROM '.$this->config['tables']['links_ref'].' WHERE ';
		$sql.= ' FileID = '.(int) $id;

		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			return $row[0];
		return 0;
	}
	
	/**
	 * Получить ссылку
	 *
	 * @param int id - id-шник ссылки
	 * @return array - Количество ссылок (если ошибка, то null)
	 */
	function GetLink($id)
	{
		if(!is_numeric($id))
			return null;

		$sql = "SELECT * FROM ".$this->config['tables']['links_list']." WHERE LinkID=".$id;
		$res = $this->db->query($sql);
		if($row = $res->fetch_assoc())
			return $row;
		else
			return null;
	}
	
	/**
	 * Получить конкретный уровень дерева по родителю
	 *
	 * @param int parent - родительский элемент
	 * @param int offset - смещение (для постранички)
	 * @param int limit - количество элементов (для постранички)
	 * @return array()
	 */
	function GetNodes($parent = 0, $offset = null, $limit = null)
	{
		if(!is_numeric($parent))
			return array();
		$sql = "SELECT * FROM ".$this->config['tables']['tree']." WHERE ParentID=".$parent." ORDER BY Type, Title";
		if($limit !== null)
		{
			$limit = intval($limit);
			$sql.= ' LIMIT ';
			if($offset !== null)
			{
				$offset = intval($offset);
				$sql.= $offset.',';
			}
			$sql.= $limit;
		}
		$res = $this->db->query($sql);
		$list = array();
		while($row = $res->fetch_assoc())
			$list[] = $row;
		return $list;
	}
	
	/**
	 * Получить количество нодов по родителю
	 *
	 * @param array parent - родительский нод
	 * @return int - Количество элементов в ветке (если ошибка, то 0)
	 */
	function GetNodesCount($parent = 0)
	{
		if(!is_numeric($parent))
			return 0;
		$sql = "SELECT count(*) FROM ".$this->config['tables']['tree']." WHERE ParentID=".$parent;
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			return $row[0];
		return 0;
	}
	
	/**
	 * Получить путь к папке
	 *
	 * @param int nodeid - текущий нод, для которого вытаскиваем путь до рута
	 * @return array - массив вида:
	 *    0 - рута
	 *    1 - нод уровня 1   и т.д.
	 */
	function GetPath($nodeid)
	{
		if(!is_numeric($nodeid))
			return array();
			
		$path = array();
		
		while($nodeid != 0)
		{
			$sql = "SELECT * FROM ".$this->config['tables']['tree']." WHERE TreeID=".$nodeid;
			$res = $this->db->query($sql);
			if($row = $res->fetch_assoc())
				array_unshift($path, $row);
			else
				return $path;
			$nodeid = $row['ParentID'];
		}
		array_unshift($path, array('TreeID' => 0, 'ParentID' => 0, 'Title' => 'Корень'));
		return $path;
	}
	
	/**
	 * Добавить папку в дерево
	 *
	 * @param int parent -родительский элемент
	 * @param string title - название видео
	 * @param string desc - описание
	 * @param int visible - видимость (по умолчанию 0)
	 * @return int - если нормально добавилось, иначе null
	 */
	function AddNode($parent, $title, $desc = '', $visible = 0)
	{
		$parent = intval($parent);
		$sql = "INSERT INTO ".$this->config['tables']['tree']." SET ";
		$sql.= "Created=NOW(),";
		$sql.= "ParentID=".$parent.",";
		$sql.= "Title='".addslashes($title)."',";
		$sql.= "Description='".addslashes($desc)."',";
		$sql.= "IsVisible=".($visible?1:0);
		if($this->db->query($sql))
			return $this->db->insert_id;
		else
			return null;
	}
	
	/**
	 * Изменить данные о папке, родителя изменить этим методом нельзя
	 *
	 * @param int id - изменяемый нод
	 * @param string title - название видео
	 * @param string desc - описание
	 * @param int visible - видимость (по умолчанию 0)
	 * @return int - если нормально добавилось, иначе null
	 */
	function UpdateNode($id, $title, $desc = '', $visible = 0)
	{
		$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
		$sql.= "Title='".addslashes($title)."',";
		$sql.= "Description='".addslashes($desc)."',";
		$sql.= "IsVisible=".($visible?1:0);
		$sql.= " WHERE TreeID=".$id;
		if($this->db->query($sql))
			return $id;
		else
			return null;
	}
	
	/**
	 * Изменить видимость
	 */
	function SetVisibleNode($id, $visible = 0)
	{
		$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
		$sql.= "IsVisible=".($visible?1:0);
		$sql.= " WHERE TreeID=".$id;
		$this->db->query($sql);
	}
	
	/**
	 * Изменить видимость
	 */
	function ToggleVisibleNode($id)
	{
		$sql = "SELECT IsVisible FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE TreeID=".$id;
		$res = $this->db->query($sql);

		if ($res && $res->num_rows) {
			list($IsVisible) = $res->fetch_row();

			$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
			$sql.= "IsVisible=1-IsVisible";
			$sql.= " WHERE TreeID=".$id;
			if (false != $this->db->query($sql))
				return 1-$IsVisible;
		}
		
		return false;
	}
	
	/**
	 * Удалить папку, рекурсивно
	 */
	function RemoveNode($id)
	{
		if(!is_numeric($id) || $id == 0)
			return;
		$this->_removenode($id);
	}
	
	/**
	 * Удалить нод (удаляет файл, превьюшку, запись в базе)
	 *
	 * @param int id - удаляемый нод
	 */
	private function _removenode($id)
	{		
		$sql = "SELECT * FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE ParentID=".$id;
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
		{
			if($row['Type'] == 0)
				$this->_removenode($row['TreeID']);
			elseif($row['Type'] == 3)
				$this->RemovePlaylist($row['TreeID']);
			else
				$this->RemoveFile($row['TreeID']);
		}
		
		//Удалить файл превьюшки
		$queryImage = "SELECT PreviewImage FROM ".$this->config['tables']['tree']." WHERE TreeID=".$id;
		$res = $this->db->query($queryImage);
		if($row = $res->fetch_assoc()) //Проверяем что картинка есть, и удаляем её
		{
			if(!empty($row['PreviewImage']))
			{
				try
				{
					$preview = $this->GetPreview($row['PreviewImage']); //Получить путь к файлу превьюшки
					FileStore::Delete_NEW($preview['path']); //Удалить файл
				}
				catch(MyException $e) { }
			}
		}
		
		// как вариант ставить флаг IsDel
		$sql = "DELETE FROM ".$this->config['tables']['tree']." WHERE TreeID=".$id;
		$this->db->query($sql);
	}
	
	/**
	 * 
	 */
	 /**
	 * Получить информацию о каталоге по id-шнику
	 *
	 * @param int id - идентификатор файла
	 * @return array - строка в базе, либо null
	 */
	function GetNode($id)
	{
		if(!is_numeric($id) || $id == 0)
			return null;
		$sql = "SELECT * FROM ".$this->config['tables']['tree']." WHERE TreeID=".$id;
		$res = $this->db->query($sql);
		if($row = $res->fetch_assoc())
			return $row;
		else
			return null;
	}
	
	/**
	 * Переместить папку
	 *
	 * @param int id - идентификатор исходной папки
	 * @param int newparent - идентификатор папки куда переместить
	 */
	function MoveNode($id, $newparent)
	{
		//Не реализован
	}
	
	/**
	 * Получить файл по id-шнику (в будущем можно навешать что-то еще, пока просто nzytv GetNode)
	 *
	 * @param int id - идентификатор файла
	 * @return array - строка в базе, либо null
	 */
	function GetFile($id)
	{
		return $this->GetNode($id);
	}
	
	/**
	 * Получить массив файлов по идентификаторам
	 * 
	 * @param array range - массив идентификаторов
	 * @return array - массив файлов (или пустой массив в случае ошибки)
	 */
	function GetFilesByRange($range)
	{
		if (!is_array($range))
			return array();
		
		if (count($range) == 1)
		{
			$file = $this->GetFile($range[0]);
			if ($file !== null)
				return array($file['TreeID'] => $file);
			return array();
		}
		
		$limit = 50;
		$offset = 0;
		$result = array();
		
		while(1)
		{
			$slice = array_slice($range, $offset, $limit);
			if (!is_array($slice) || count($slice) == 0)
				break;
			$sql = "SELECT * FROM ".$this->config['tables']['tree'];
			$sql.= " WHERE TreeID IN (".implode(',', $slice).")";
			
			$res = $this->db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$result[$row['TreeID']] = $row;
			}
			
			if (count($slice)<=$limit)
				break;
			
			$offset += $limit;
		}
		
		return $result;
	}
	
	/**
	 * deprecated
	 */
	function GetFiles($parent)
	{
		if(!is_numeric($parent))
			return null;
			
		$media = array();
		$sql = "SELECT * FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE Type>0 AND ParentID=".$parent;
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$media[] = $row;
			
		return $media;
	}
	
	/**
	 * Добавить файл в базу !!!Обработка файла медии идет в отдельном методе
	 *
	 * @param int parent - папка, куда добавляем
	 * @param int type - тип загружаемой медии
	 * @param string title - название файла
	 * @param string desc - описание файла
	 * @param string aratio - соотношение сторон видео-файла - по умолчанию 4:3
	 * @param int visible - видимость ролика - по умолчанию 0
	 * @param int ShowLogo - показывать логотип - по умолчанию 0 !!DEPRECATED
	 * @param string PreviewImageFile - ключ превьюшки в массиве $_FILES 
	 * @param int weight - вес рекламного ролика (по умолчанию 0), если больше 0, то реклама показывается
	 * @param int ShowAdvertise - показывать ли в основном ролике рекламу (по умолчанию 0)
	 * @param string AdvertiseUrl - ссылка при клике на рекламу (если пусто, то плашки с текстом "перейти на сайт рекламодателя" нет)
	 * @param int IsPostRoll - если 1, то реклама после проигрывания основного ролика, иначе в начале (смотрит  на флаг ShowAdvertise)
	 * @return int - идентификатор вставленной записи, иначе null
	 */
	function AddFile($parent, $type, $title, $desc = '', $aratio = '4:3', $visible = 0, $ShowLogo = 0, $PreviewImageFile = null, $weight=0, $ShowAdvertise = 0, $AdvertiseUrl = "", $IsPostRoll = 0)
	{
		$type = $this->config['types'][$type];
		if(empty($type))
			return null;
		
		$name = '';
		
		if ($_FILES[$PreviewImageFile]['tmp_name'] != '')
		{
			$name = $this->CreateFilePreviewImage($PreviewImageFile, $aratio); //Создать файл превьюшки
		}
		
		if ($AdvertiseUrl != '')
			$AdvertiseUrl = 'http://'.str_ireplace('http://', '', $AdvertiseUrl);
		
		$sql = "INSERT INTO ".$this->config['tables']['tree']." SET ";
		$sql.= "ParentID=".$parent.",";
		$sql.= "Type=".$type.",";
		$sql.= "AspectRatio='".addslashes($aratio)."',";
		$sql.= "Created=NOW(),";
		$sql.= "Title='".addslashes($title)."',";
		$sql.= "Description='".addslashes($desc)."',";
		$sql.= "IsVisible=".($visible?1:0).",";
		$sql.= "ShowLogo=".($ShowLogo?1:0);
		if ($name != '')
			$sql.= ",PreviewImage='".$name."'";
		$sql.= ",AdvertiseUrl='".addslashes($AdvertiseUrl)."'";
		$sql.= ",IsPostRoll=".($IsPostRoll ? 1 : 0);
		$sql.= ",ShowAdvertise=".($ShowAdvertise ? 1 : 0);
		$sql.= ",weight=".$weight;
		if($this->db->query($sql))
			return $this->db->insert_id;
		else
			return null;
		
	}
	
	/**
	 * Изменить файл  !!!Обработка файла медии идет в отдельном методе
	 *
	 * @param int id - идентификатор изменяемого файла
	 * @param int type - тип загружаемой медии
	 * @param string title - название файла
	 * @param string desc - описание файла
	 * @param string aratio - соотношение сторон видео-файла - по умолчанию 4:3
	 * @param int visible - видимость ролика - по умолчанию 0
	 * @param int ShowLogo - показывать логотип - по умолчанию 0 !!DEPRECATED
	 * @param string PreviewImageFile - ключ превьюшки в массиве $_FILES 
	 * @param int DeletePreviewFlag - если, true, то удалить существующий превью-файл
	 * @param int weight - вес рекламного ролика (по умолчанию 0), если больше 0, то реклама показывается
	 * @param int ShowAdvertise - показывать ли в основном ролике рекламу (по умолчанию 0)
	 * @param string AdvertiseUrl - ссылка при клике на рекламу (если пусто, то плашки с текстом "перейти на сайт рекламодателя" нет)
	 * @param int IsPostRoll - если 1, то реклама после проигрывания основного ролика, иначе в начале (смотрит  на флаг ShowAdvertise)
	 * @return int - идентификатор обновленной записи, иначе null
	 */
	function UpdateFile($id, $type, $title, $desc = '', $aratio = '4:3', $visible = 0, $ShowLogo = 0, $PreviewImageFile = null, $DeletePreviewFlag = false, $weight=0, $ShowAdvertise = 0, $AdvertiseUrl = "", $IsPostRoll = 0)
	{
		$type = $this->config['types'][$type];
		if(empty($type))
			return false;
		
		$changePreviewFlag = false;
		
		if ($DeletePreviewFlag)
		{
			$this->DeletePreview($id);
			$changePreviewFlag = true;
		}
		elseif ($_FILES[$PreviewImageFile]['tmp_name'] != '')//Если при изменении выбран файл
		{
			$this->DeletePreview($id);
			$name = $this->CreateFilePreviewImage($PreviewImageFile, $aratio); //Создать новый файл превьюшки
		
			if( $name != '' )
				$changePreviewFlag = true;
		}
		
		$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
		$sql.= "Type=".$type.",";
		$sql.= "AspectRatio='".addslashes($aratio)."',";
		$sql.= "Created=NOW(),";
		$sql.= "Title='".addslashes($title)."',";
		$sql.= "Description='".addslashes($desc)."',";
		$sql.= "IsVisible=".($visible?1:0).",";
		$sql.= "ShowLogo=".($ShowLogo?1:0);
		if ($changePreviewFlag)
			$sql.= ",PreviewImage='".$name."'";
		$sql.= ",AdvertiseUrl='".addslashes($AdvertiseUrl)."'";
		$sql.= ",IsPostRoll=".($IsPostRoll ? 1 : 0);
		$sql.= ",ShowAdvertise=".($ShowAdvertise ? 1 : 0);
		$sql.= ",weight=".$weight;
		$sql.= " WHERE TreeID=".$id;
		
		if($this->db->query($sql))
			return $id;
		else
			return null;
	}
	
	/**
	 * Переместить медиа-файл из временного хранилища в постоянное
	 *
	 * @param int id - идентификатор файла в базе
	 * @param string name - имя файла во временном хранилище (только имя фйла, без пути)
	 * @param array size - размеры файла
	 * @param int type - тип медии
	 * @return bool
	 */
	function MoveUploadedFile($id, $name, $size = null, $type = null)
	{
		global $OBJECTS;
		$from = $this->config['path']['upload'].$name;
		
		if(!is_numeric($id) || $id <= 0 || $type == null || !FileStore::IsFile($from)) // в будущем автоматическое определение типа
			return false;
		
		$type = $this->config['types'][$type];
		if(empty($type))
			return false;
		
		try
		{
			if ($type == $this->config['types']['video'])
				$fmtype = FileMagic::MT_VIDEO;
			elseif ($type == $this->config['types']['audio'])
				$fmtype = FileMagic::MT_AUDIO;
			elseif ($type == $this->config['types']['advertise'])
				$fmtype = FileMagic::MT_VIDEO;
			
			$fname = FileStore::CreateName_NEW(rand(1000000, 9999999), $from, $fmtype);
			
		}
		catch (MyException $e)
		{
			return false;
		}
		
		$fto = FileStore::GetPath_NEW($fname);
		$fto = $this->config['path']['types'][$type].$fto;
		try
		{
			if(FileStore::Copy_NEW($from, $fto))
			{
				$preparedFile = FileStore::PrepareFileToObject(FileStore::GetPath_NEW($fname), $this->config['path']['types'][$type]);
				$fname = FileStore::ObjectToString($preparedFile);
				
				if(!isset($size['width']) || !is_numeric($size['width']) || $size['width'] < 0) $size['width'] = 0;
				if(!isset($size['height']) || !is_numeric($size['height']) || $size['height'] < 0) $size['height'] = 0;
				
				// удалим старый, если был
				$sql = "SELECT * FROM ".$this->config['tables']['tree'];
				$sql.= " WHERE TreeID=".$id;
				$res = $this->db->query($sql);
				if($row = $res->fetch_assoc())
				{
					if(!empty($row['Path']))
					{
						try
						{
							$file = $this->GetMediaFile($row['Path'], $row['Type']);
							FileStore::Delete_NEW($file['path']);
						}
						catch(MyException $e) { }
					}
				}
				
				$fsize = FileStore::GetFilesize($fto);
				
				$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
				$sql.= "Type=".$type.',';
				$sql.= "Path='".addslashes($fname)."',";
				$sql.= "Status=1,";
				$sql.= "Width=".$size['width'].",";
				$sql.= "Height=".$size['height'].",";
				$sql.= "filesize=".intval($fsize);
				$sql.= " WHERE TreeID=".$id;
				
				$this->db->query($sql);
				return true;
			}
		}
		catch(MyException $e) { }
		
		return false;
	}
	
	/**
	 * Переименовать файл видео из .mp4 в .avi
	 * Используется для того, что FileMagic не может работать с файлом, у которого расширение .mp4 (см. lib.filemagic)
	 *
	 * @param string path - полный путь до файла (из папки upload)
	 * @return string - в случае успешного переимнования вернет новый путь, иначе null
	 */
	private function RenameFileMp4($path)
	{
		if (($pos = strrpos($path, ".")) !== false)
			$ext = strtolower(substr($path, $pos+1, strlen($path)-1));
		if ($ext != 'mp4')
			return $path;
		
		$new_path = str_replace($ext, "avi", $path);
		
		try
		{
			if (FileStore::Move_NEW($path,  $new_path) === true)
				return $new_path;
			else
				return null;
		}
		catch(MyException $e)
		{
			return null;
		}
	}
	
	/**
	 * Переместить медиа-файл для скачивания (avi,mp4) из временного хранилища в постоянное
	 * Если есть уже в базе файл по id, то удалит его
	 *
	 * @param int id - идентификатор файла в базе
	 * @param string name - имя файла во временном хранилище (только имя фйла, без пути)
	 * @param array size - размеры файла
	 * @return bool
	 */
	function MoveUploadedFileSource($id, $name, $size = null)
	{
		global $OBJECTS;
		$from = $this->config['path']['upload'].$name;

		if (!is_numeric($id) || $id <= 0)
			return false;

		if(!FileStore::IsFile($from)) // в будущем автоматическое определение типа
			return false;
		
		$from = $this->RenameFileMp4($from);
		if ($from === null || !FileStore::IsFile($from))
			return false;
		
		$type = $this->config['types']['video_source'];
		
		if(empty($type))
			return false;
			
		try
		{
			$fname = FileStore::CreateName_NEW(rand(1000000, 9999999), $from, FileMagic::MT_VIDEO);
		}
		catch (MyException $e)
		{
			return false;
		}
		
		$fto = FileStore::GetPath_NEW($fname);
		$fto = $this->config['path']['types'][$type].$fto;
		try
		{
			if(FileStore::Copy_NEW($from, $fto))
			{
				$preparedFile = FileStore::PrepareFileToObject(FileStore::GetPath_NEW($fname), 
									$this->config['path']['types'][$type]);
				$fname = FileStore::ObjectToString($preparedFile);
				
				//2do: удаление файла
				if(!isset($size['width']) || !is_numeric($size['width']) || $size['width'] < 0) $size['width'] = 0;
				if(!isset($size['height']) || !is_numeric($size['height']) || $size['height'] < 0) $size['height'] = 0;
				
				// удалим старый, если был
				$sql = "SELECT * FROM ".$this->config['tables']['tree'];
				$sql.= " WHERE TreeID=".$id;
				$res = $this->db->query($sql);
				if($row = $res->fetch_assoc())
				{
					if(!empty($row['path_download']))
					{
						try
						{
							$file = $this->GetMediaFile($row['path_download'], $this->config['types']['video_source']);
							FileStore::Delete_NEW($file['path']);
						}
						catch(MyException $e) { }
					}
				}
				
				$fsize = FileStore::GetFilesize($fto);
				
				$sql = "UPDATE ".$this->config['tables']['tree']." SET ";
				$sql.= " path_download='".addslashes($fname)."',";
				$sql.= " filesize_source='".addslashes($fsize)."'";
				$sql.= " WHERE TreeID=".$id;
				$this->db->query($sql);
				return true;
			}
		}
		catch(MyException $e) { }
		
		return false;
	}
	
	
	//Когда будет реализация, надо учесть что теперь 2 файла: flv и для скачки, и, соответственно, 2 поля в базе
	function DownloadFile($id, $url)
	{
		/*$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt();*/
	}
	
	/**
	 * Удалить файл из базы и с диска
	 * Удалит основной файл и файл для скачки
	 *
	 * @param int id - идентификатор удаляемого файла
	 * @return void
	 */
	function RemoveFile($id)
	{
		if(!is_numeric($id) || $id == 0)
			return;
		
		$sql = "SELECT * FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE TreeID=".$id;
		
		$res = $this->db->query($sql);
		if($row = $res->fetch_assoc())
		{
			
			//Удалим файл видео
			if(!empty($row['Path']))
				$this->DeleteMediaFile($row['Path'],  $this->config['types']['video']);
			
			//Удалим файл для скачивания
			if(!empty($row['path_download']))
				$this->DeleteMediaFile($row['path_download'],  $this->config['types']['video_source']);
		}
		
		$sql = "DELETE FROM ".$this->config['tables']['tree']." WHERE TreeID=".$id;
		$this->db->query($sql);

		EventMgr::Raise('multimedia/node/remove',
			array(
				'Source' => $id
		));
	}
	
	/**
	 * Удалить файл превьюшки если она есть в базе
	 *
	 * @param int id - идентификатор файла, для которого удаляется превьюшка
	 * @return void
	 */
	function DeletePreview($id)
	{
		$queryImage = "SELECT PreviewImage FROM ".$this->config['tables']['tree']." WHERE TreeID=".$id;
		$res = $this->db->query($queryImage);
		if($row = $res->fetch_assoc()) //Проверяем что картинка есть, и удаляем её
		{
			if(!empty($row['PreviewImage']))
			{
				try
				{
					$preview = $this->GetPreview($row['PreviewImage']);
					FileStore::Delete_NEW($preview['path']); //Удалить файл
					
					$queryImage = "UPDATE ".$this->config['tables']['tree']." SET PreviewImage='' WHERE TreeID=".$id;
					$this->db->query($queryImage);
				}
				catch(MyException $e) { }
			}
		}
	}
	
		
	/**
	 * Создать файл превьюшки к видео
	 *
	 * @param string $PreviewImageFile Имя ключа в массиве FILES
	 * @param string $aratio - соотношение сторон (для ресайза в соответствии с размером плеера)
	 * @return string - объект, картинки
	 */
	function CreateFilePreviewImage($PreviewImageFile, $aratio = '4:3')
	{
		global $OBJECTS;
		
		if ($PreviewImageFile == null)
			return null;
		
		//Если имя файла не передано
		if (!isset($_FILES[$PreviewImageFile]))
			return null;
			
		//*************Сохраняем картинку
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
	
		try
		{
			$name = FileStore::Upload_NEW(
				$PreviewImageFile,   //Имя ключа массива FILES
				$this->config['path']['preview'],   //директория назначения
				rand(1000000, 9999999),   //префикс Файла назначения
				FileMagic::MT_WIMAGE, 
				5000000,
				array(
					'resize' => array(
						'tr' => 0,
						'w'  => $this->config['selective_aspectratio'][$aratio]['width'],
						'h'  => $this->config['selective_aspectratio'][$aratio]['height'],
					),
				),
				null
			);
			
			$name = FileStore::GetPath_NEW($name);
			$preparedName = Images::PrepareImageToObject($name, $this->config['path']['preview']);
			$name = FileStore::ObjectToString($preparedName);
			
			return $name;
		}
		catch(MyException $e) { }
		return '';
	}
	
	
	/**
	 * Получить информацию о файле превьюшки
	 *
	 * @param string name - имя preview-файла
	 * @return array (path, url, w, h, size, mime)
	 * @exception InvalidArgumentMyException
	 * @exception InvalidArgumentBTException
	 */
	function GetPreview($name)
	{
		LibFactory::GetStatic('images');
		try
		{
			$img_obj = FileStore::ObjectFromString($name);
			$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
			
			$preparedImage = Images::PrepareImageFromObject($img_obj, 
				$this->config['path']['preview'], $this->config['url']['preview']);
			unset($img_obj);
		}
		catch ( MyException $e ) {
			throw $e;
		}
		
		return $preparedImage;
	}
	
	/**
	 * Получить информацию о медиа-файле
	 *
	 * @param string $name - имя файла в базе (в виде объекта)
	 * @param int type - тип медиа-файла
	 * @return array (path, url, size, mime)
	 * @exception InvalidArgumentMyException
	 * @exception InvalidArgumentBTException
	 */
	function GetMediaFile($name, $type)
	{
		if (empty($name))
			throw new InvalidArgumentBTException('Wrong name file: "'.$name.'"');
		if (!isset($this->config['path']['types'][$type]))
			throw new InvalidArgumentBTException('Wrong type media file by type='.$type);
		
		try
		{
			$file_obj = FileStore::ObjectFromString($name);
			$file_obj['file'] = FileStore::GetPath_NEW($file_obj['file']);
			
			$preparedFile = FileStore::PrepareFileFromObject($file_obj, 
				$this->config['path']['types'][$type], $this->config['url']['types'][$type]);
			unset($file_obj);
		}
		catch ( MyException $e ) {
			throw $e;
		}
		
		return $preparedFile;
	}
	
	/**
	 * Удалить медиа-файл
	 *
	 * @param string $name - имя файла в базе (в виде объекта)
	 * @param int type - тип медиа-файла
	 * @return bool
	 */
	public function DeleteMediaFile($name, $type)
	{
		if (!isset($this->config['path']['types'][$type]))
			return false;
		
		try
		{
			if( ($file_obj = FileStore::ObjectFromString($name)) !== false )
			{
				$del_file =$this->config['path']['types'][$type].FileStore::GetPath_NEW($file_obj['file']);
				FileStore::Delete_NEW($del_file);
				return true;
			}
		} 
		catch(MyException $e) 
		{ 
			try
			{
				$name = FileStore::GetPath_NEW($name);
				$del_file = $this->config['path']['types'][$type].$name;
				
				if (FileStore::IsFile($del_file))
					FileStore::Delete_NEW($del_file);
				return true;
			}
			catch(MyException $e)
			{
				return false;
			}
		}
		return false;
	}
	
	/**
	 * Получить URL для плеера
	 *
	 * @param int id - идентификатор файла, который будет проигрываться в плеере
	 * @return string - url
	 */
	function GetPlayerUrl($id = null)
	{
		$url = $this->config['url']['player'];
		if($id !== null)
			$url.= "?id=".$id;
		return $url;
	}
	
	function GetHTMLCode($id, $playerid = 'player')
	{
		global $OBJECTS;
		
		$n = $this->GetNode($id);
		//if($n['Width'] == 0 || $n['Height'] == 0)
		{		
			if(isset($this->config['selective_aspectratio'][ $n['AspectRatio'] ]))
			{
				$n['Width'] = $this->config['selective_aspectratio'][$n['AspectRatio']]['width'];
				$n['Height'] = $this->config['selective_aspectratio'][$n['AspectRatio']]['height'] + 30;
			}
			else
			{
				$n['Width'] = $this->config['selective_aspectratio']['4:3']['width'];
				$n['Height'] = $this->config['selective_aspectratio']['4:3']['height'] + 30;
			}	
		}
		
		if(isset($OBJECTS['title']))
			$OBJECTS['title']->AddScript($this->config['url']['jsapi']);
			
		$movie = $this->config['url']['player'].'?id='.$id;
			
		$html = '<object type="application/x-shockwave-flash"';
		$html.= ' id="'.$playerid.'"';
		
	
		if($n['Type'] == 2) //Если аудио плеер
		{	
			$html.= ' width="400"';
			$html.= ' height="30"';
		}
		else
		{
			$html.= ' width="'.$n['Width'].'"';
			$html.= ' height="'.($n['Height']).'"';
		}
		$html.= ' data="'.$movie.'" style="z-index:-1">';
		$html.= '<param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/>';
		$html.= '<param value="opaque" name="wmode" />';
		$html.= '<param name="movie" value="'.$movie.'" />';
		$html.= '</object>';
		
		return $html;
	}
	
	// получить мультимедиа объекты по фильтру
	function GetObjects($filter)
	{
		$ord = $sql = '';
		
		$fields = $where = array();
		if(isset($filter['type']))
		{
			if(is_array($filter['type']))
			{
				if(count($filter['type']) == 0)
					$where[] = "t.Type=-1";
				else
					$where[] = "t.Type IN(".implode(',',$filter['type']).")";
			}
			else
				$where[] = "t.Type=".$filter['type'];
		}
		
		if(isset($filter['id']))
		{
			if(is_array($filter['id']))
			{
				if(count($filter['id']) == 0)
					$where[] = "t.TreeID=-1";
				else
					$where[] = "t.TreeID IN(".implode(',',$filter['id']).")";
			}
			else
				$where[] = "t.TreeID=".$filter['id'];
		}
		
		if(isset($filter['playlist']))
		{
			$fields[] = 'p.Ord';
			$fields[] = 'p.RefID';
			$fields[] = 'p.PlaylistID';
			$sql.= " INNER JOIN ".$this->config['tables']['plm_ref']." AS p ON ";
			$on = array();
			$on[] = "t.TreeID=p.TreeID";
			if(is_array($filter['playlist']))
			{
				if(count($filter['playlist']) == 0)
					$on[] = "p.PlaylistID=-1";
				else
					$on[] = "p.PlaylistID IN(".implode(',',$filter['playlist']).")";
			}
			else
				$on[] = "p.PlaylistID=".$filter['playlist'];
				
			$sql.= implode(' AND ',$on);
			
			$ord = 'p.Ord ASC';
		}
		
		$sql_ = "SELECT t.*";
		if(count($fields) > 0)
			$sql_.= ",".implode(',', $fields);
		$sql = $sql_." FROM ".$this->config['tables']['tree']." AS t".$sql;
		
		if(count($where) > 0)
		{
			$sql.= " WHERE ";
			$sql.= implode(' AND ',$where);
		}
		if(!empty($ord))
			$sql.= ' ORDER BY '.$ord;
		$list = array();
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$list[] = $row;
		return $list;
	}

    function Upload($id, $findex)
	{
		
	}
	
	function Move($id, $newpath)
	{
	
	}
	
	function AddLink()
	{
	
	}
	
	function RemoveLink($id)
	{
	
	}
	
	// работа с playlist
	/**
	 * Добавляет файл(ы) в плейлист, уникальности нет, один файл хоть 100 раз, файлы добавляет в конец списка
	 */
	function AddToPlaylist($listid, $mediaid)
	{
		if(!is_numeric($listid) || $listid <= 0)
			return;
			
		if(is_numeric($mediaid))
			$mediaid = array($mediaid);
		
		if(!is_array($mediaid))
			return;
			
		// возьмем последний орд
		$ord = 1;
		$sql = "SELECT max(Ord) FROM ".$this->config['tables']['plm_ref'];
		$sql.= " WHERE PlaylistID=".$listid;
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$ord = $row[0]+1;
			
		
			
		foreach($mediaid as $mid)
		{
			if(!is_numeric($mid) || $mid <= 0)
				continue;
			$sql = "INSERT INTO ".$this->config['tables']['plm_ref']." SET";
			$sql.= " PlaylistID=".$listid.",";
			$sql.= " TreeID=".$mid.",";
			$sql.= " Ord=".($ord++);
			
			$this->db->query($sql);
		}
	}
	
	/**
	 * Удаляет файл(ы) их плейлиста, по идентификатору ссылки, так как нет уникальности
	 */
	function RemoveFromPlaylist($mediaid)
	{
		if(is_numeric($mediaid))
			$mediaid = array($mediaid);
		
		if(!is_array($mediaid))
			return;
		
		$mids = array();
		foreach($mediaid as $mid)
			if(is_numeric($mid) && $mid > 0) 
				$mids[] = $mid;
		
		if(count($mids) <= 0)
			return;
		
		$sql = "DELETE FROM ".$this->config['tables']['plm_ref'];
		$sql.= " WHERE RefID IN(".implode(',', $mids).")";
		$this->db->query($sql);
	}
	
	/**
	 * Удаляет плейлист, все файлы указанные в плейлисте не трогает
	 */
	function RemovePlaylist($listid)
	{
		if(!is_numeric($id))
			return;
			
		$sql = "DELETE FROM ".$this->config['tables']['plm_ref'];
		$sql.= " WHERE PlaylistID=".$id;
		$this->db->query($sql);
			
		$sql = "DELETE FROM ".$this->config['tables']['tree'];
		$sql.= " WHERE TreeID=".$id;
		
		$this->db->query($sql);
	}
	
	/**
	 * Обновление сортироки плейлиста
	 */
	function UpdatePlaylistOrd($data)
	{
		if(!is_array($data))
			return;
			  
		foreach($data as $l)
		{
			if(!is_numeric($l['ord']) || !is_numeric($l['id']))
				continue;
			$sql = "UPDATE ".$this->config['tables']['plm_ref']." SET";
			$sql.= " Ord=".$l['ord'];
			$sql.= " WHERE RefID=".$l['id'];
			$this->db->query($sql);
		}
	}
	
	/**
	 * Добавить правило таргетинга
	 *
	 * @param int - идентификатор рекламного ролика
	 * @param string - значение
	 * @param string - тип правила (allow, deny)
	 * @param string - поле для правила
	 * @param string - условие таргетинга
	 * @return bool
	 */
	public function AddRule($id, $value, $acl = 'allow', $field = 'site', $cond = 'equal')
	{
		if (!is_numeric($id) || $id <= 0)
			return false;
		
		if ($value == '')
			return false;
			
		if (
			!isset($this->config['acls'][$acl]) 
			|| !isset($this->config['acl_field'][$field]) 
			|| !isset($this->config['acl_condition'][$cond]) 
		)
		{
			return false;
		}
		$ord = 0;
		
		$sql = "SELECT Ord FROM ".$this->config['tables']['acl'];
		$sql.= " WHERE BannerID = ".$id;
		$sql.= " AND Field = '".$field."'";
		$sql.= " ORDER BY Ord DESC LIMIT 1";
		$res = $this->db->query($sql);
		if (($row = $res->fetch_assoc()))
		{
			$ord = $row['Ord']+1;
		}
		
		$value = str_replace(array('http://', 'www.'), array('',''), $value);
		
		$sql = "INSERT INTO ".$this->config['tables']['acl']." SET";
		$sql.= " `BannerID` = ".$id;
		$sql.= ", `Acl` = '".$acl."'";
		$sql.= ", `Field` = '".$field."'";
		$sql.= ", `Value` = '".addslashes($value)."'";
		$sql.= ", `Condition` = '".$cond."'";
		$sql.= ", `Ord` = ".$ord;
		
		$this->db->query($sql);
		
		$this->ClearAclsCache($id);
		return true;
	}
	
	/**
	 * Обновить правило таргетинга
	 *
	 * @param int - идентификатор рекламного ролика
	 * @param string - значение
	 * @param string - поле для правила
	 * @param int - порядок
	 * @param string - условие таргетинга
	 * @return bool
	 */
	public function EditRule($id, $value, $field, $ord, $cond = 'equal')
	{
		if (!is_numeric($id) || $id <= 0)
			return false;
		
		if ($value == '')
			return false;
		
		if (!isset($this->config['acl_condition'][$cond]))
			return false;
		
		$value = str_replace(array('http://', 'www.'), array('',''), $value);
		
		$sql = "UPDATE ".$this->config['tables']['acl']." SET";
		$sql.= " `Value` = '".addslashes($value)."'";
		$sql.= ", `Condition` = '".$cond."'";
		$sql.= " WHERE `BannerID` = ".$id;
		$sql.= " AND `Field` = '".$field."'";
		$sql.= " AND `Ord` = ".$ord;
		
		$this->db->query($sql);
		$this->ClearAclsCache($id);
		return true;
	}
	
	/**
	 * Получить правило таргетинга для рекламного ролика
	 *
	 * @param int - идентификатор рекламного ролика
	 * @param string - поле
	 * @param int - порядок
	 * @return array - массив одного правила
	 */
	public function GetRule($id, $field, $ord) 
	{
		if (!is_numeric($id) || $id <= 0)
			return array();
		
		if (!isset($this->config['acl_field'][$field]))
			return array();
		
		$sql = "SELECT * FROM ".$this->config['tables']['acl'];
		$sql.= " WHERE `BannerID` = ".$id;
		$sql.= " AND `Field` = '".$field."'";
		$sql.= " AND `Ord` = '".$ord."'";
		
		return $this->db->query($sql)->fetch_assoc();
	}
	
	/**
	 * Получить правила таргетинга для рекламного ролика
	 *
	 * @param int - идентификатор рекламного ролика
	 * @return array - массив отсортированных правил
	 */
	public function GetRules($id)
	{
		if (!is_numeric($id) || $id <= 0)
			return array();
		
		$cache = new Cache();
		$cache->Init('memcache', 'video_banners');
		$cacheid = 'acls_'.$id;
		
		$result = $cache->get($cacheid);
		if ($result === false)
		{
			$result = array();
			
			$sql = "SELECT * FROM ".$this->config['tables']['acl'];
			$sql.= " WHERE BannerID = ".$id;
			$sql.= " ORDER BY Field DESC, Ord ASC";
			
			$res = $this->db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$row['Value'] = strtolower($row['Value']);
				$result[] = $row;
			}

			$cache->set($cacheid, $result, 3600);
		}
		
		return $result;
	}
	
	/**
	 * Получить массив баннеров
	 * 
	 * Метод кеширует все баннера в мемкеше
	 *
	 * @return array
	 */
	public function GetBanners()
	{
		LibFactory::GetStatic('cache');
		
		$cache = new Cache();
		$cache->Init('memcache', 'video_banners');
		$cacheid = 'banners';
		
		$data = $cache->get($cacheid);
		
		if ($data === false)
		{
			$sql = "SELECT TreeID, Path, AdvertiseUrl, IsPostRoll, weight FROM ".$this->config['tables']['tree'];
			$sql.= " WHERE type = ".$this->config['types']['advertise'];
			$sql.= " AND IsVisible = 1";
			$res = $this->db->query($sql);
			while($row = $res->fetch_assoc())
			{
				try
				{
					$preparedFile = $this->GetMediaFile($row['Path'], 7);
					$row['url'] = $preparedFile['url'];
				}
				catch( MyException $e ) {
					continue;
				}
				
				$data[$row['TreeID']] = $row;
			}
			
			$cache->set($cacheid, $data, 3600);
		}
		
		return $data;
	}
	
	/**
	 * Чистка кеша баннеров
	 *
	 */
	public function ClearBannersCache()
	{
		LibFactory::GetStatic('cache');
		
		$cache = new Cache();
		$cache->Init('memcache', 'video_banners');
		$cache->remove('banners');
	}
	
	/**
	 * Чистка кеша правил для баннера
	 * 
	 * @param int - идентификатор рекламного ролика
	 * @return bool
	 */	
	public function ClearAclsCache($id)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;
		
		LibFactory::GetStatic('cache');
		
		$cache = new Cache();
		$cache->Init('memcache', 'video_banners');
		$cache->remove('acls_'.$id);
		return true;
	}
	/**
	 * Удалить правило
	 *
	 * @param int - идентификатор рекламного ролика
	 * @param string - поле
	 * @param int - порядок
	 * @return bool
	 */
	public function DeleteRule($id, $field, $ord)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;
			
		if (!isset($this->config['acl_field'][$field]))
			return false;
		
		if (!is_numeric($ord) || $ord < 0)
			return false;
		
		$sql = "DELETE FROM ".$this->config['tables']['acl'];
		$sql.= " WHERE `BannerID` = ".$id;
		$sql.= " AND `Field` = '".$field."'";
		$sql.= " AND `Ord` = ".$ord;
		$this->db->query($sql);
		
		$this->ClearAclsCache($id);
		
		return true;
	}
	
	private function IsAllow($banner, $str)
	{
		$acls = $this->GetRules($banner['TreeID']);
		
		if (count($acls) == 0)
			return true;
			
		$globalRule = $acls[0]['Acl'];
		
		$siteid = STreeMgr::  GetSectionIDByLink($str);
		$node = STreeMgr::GetNodeById($siteid);
		$site = $node->Parent->Name;
		
		$hit = false;
		for ($i = 0, $count = count($acls); $i < $count; $i++)
		{
			$acl = $acls[$i];
			if ( $acl['Field'] == 'site')
			{
				if ($acl['Condition'] == 'equal')
					$hit = $acl['Value'] == $site;
				elseif($acl['Condition'] === 'notequal')
					$hit = $acl['Value'] !== $site;
				elseif($acl['Condition'] === 'contains')
					$hit = strpos($acl['Value'], $site) !== false;
			}
			elseif ($acl['Field'] == 'ref')
			{
			}
			
			if($hit)
				return $globalRule == 'allow' ? true : false;
		}

		return false;
	}

	private function getRotateBanner($banners)
	{
		if (count($banners) == 0)
			return null;
		$rotation_interval = 60; // seconds
		
		$time_start = mktime(0, 0, 0);
		$time_now = time();
		
		$range = array();
		$i = 0;
		foreach($banners as $k=>$v)
		{
			$weight = $v['weight'];
			while($weight > 0)
			{
				$range[$i++] = $k;
				$weight--;
			}
		}
		
		$seconds_from_last_circle_start = ($time_now - $time_start) % (sizeof($range) * $rotation_interval);
		$number_of_banner = floor($seconds_from_last_circle_start / $rotation_interval);
		
		return $banners[$range[$number_of_banner]]['TreeID'];
	}
}
?>
