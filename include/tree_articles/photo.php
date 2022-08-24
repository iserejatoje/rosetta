<?

class TreeArticlePhoto
{
	private $_mgr;

	public $ID;
	public $ArticleID;
	public $Name;
	public $IsVisible;
	public $Ord;

	private $PhotoSmall;
	private $PhotoLarge;

	private $_images_dir = '/common_fs/i/tree_articles_photos/';
	private $_images_url = '/resources/fs/i/tree_articles_photos/';

	private $_photo_small_size = array('max_width' => 127, 'max_height' => 127);
	private $_photo_large_size = array('max_width' => 1024, 'max_height' => 768);
	private $_photo_file_size = 10485760; //700K

	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['photoid']) && Data::Is_Number($info['photoid']) )
			$this->ID = $info['photoid'];

		$this->ArticleID	= (int) $info['articleid'];
		$this->Name			= $info['name'];
		$this->Ord			= $info['ord'];
		$this->PhotoSmall	= $info['photosmall'];
		$this->PhotoLarge	= $info['photolarge'];
		$this->IsVisible	= $info['isvisible']  ? true : false;
	}

	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод EShopMgr
	 */
	public function Update()
	{
		$info = array(
			'ArticleID'		=> $this->ArticleID,
			'Name'			=> $this->Name,
			'Ord'			=> (int) $this->Ord,
			'IsVisible'		=> (int) $this->IsVisible,
			'PhotoSmall'	=> $this->PhotoSmall,
			'PhotoLarge'	=> $this->PhotoLarge,
		);

		if ( $this->ID !== null )
		{
			$info['PhotoID'] = $this->ID;
			if (TreeArticleMgr::getInstance()->UpdatePhoto($info) !== false)
				return true;
		}
		else if ( ($new_id = TreeArticleMgr::getInstance()->AddPhoto($info)) !== false)
		{
			$this->ID = $new_id;
			return $new_id;
		}

		return false;
	}

	public function Remove()
	{
		if ( $this->ID === null)
			return false;

		TreeArticleMgr::getInstance()->RemovePhoto($this->ID);
	}

	public function UploadPhotoSmall() {

		$result = $this->_uploadImages(array(
			'small' => 'photosmall'
		));

		if ($result === true)
			return $result;

		$this->__set('PhotoSmall', null);
		return $result;
	}

	public function UploadPhotoLarge() {
		$result = $this->_uploadImages(array(
			'large' => 'photolarge'
		));

		if ($result === true)
			return $result;

		$this->__set('PhotoLarge', null);
		return $result;
	}

	private function _uploadImages(array $images) {
		global $OBJECTS;
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		$images = array_change_key_case($images, CASE_LOWER);

		$errors = array();

		foreach($images as $k => $v) {
			if (!in_array((string) $k, array('small',  'large')) )
				continue ;

			if (empty($_FILES[$v]['name']))
				continue ;

			$tr = 0;
			if ($k == 'small')
				$tr = 3;

			$pname = FileStore::Upload_NEW(
				$v, $this->_images_dir, rand(1000, 9999).$this->ID.'_'.$k,
				FileMagic::MT_WIMAGE, $this->_photo_file_size,
				array(
					'resize' => array(
						'tr' => $tr,
						'w'  => $this->{"_photo_{$k}_size"}['max_width'],
						'h'  => $this->{"_photo_{$k}_size"}['max_height'],
					),
				)
			);

			$pname = FileStore::GetPath_NEW($pname);
			$thumbNew = Images::PrepareImageToObject($pname, $this->_images_dir);
			$pname = FileStore::ObjectToString($thumbNew);

			$this->__set($v, $pname);
		}

		return true;
	}

	/**
	 * Удаляет файл картинки .
	 *
	 * @param string name - имя файла либо объект
	 * @return boolean - если удалился, то true
	 */
	private function _deleteImage($name)
	{
		try
		{
			if( ($img_obj = FileStore::ObjectFromString($name)) !== false )
			{
				$del_file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
				if (FileStore::IsFile($del_file))
					return FileStore::Delete_NEW($del_file);
			}
		}
		catch(MyException $e) { }
		return false;
	}

	public function __set($name, $value) {

		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

		$name = strtolower($name);
		switch($name) {
			case 'photosmall':
				if ($value === null) {
					if ($this->PhotoSmall)
						$this->_deleteImage($this->PhotoSmall);

					$this->PhotoSmall = '';
					return $value;
				}

				try
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->PhotoSmall = FileStore::ObjectToString($img_obj);
						}
					}
				}
				catch(MyException $e) { }

			break;

			case 'photolarge':
				if ($value === null) {
					if ($this->PhotoLarge)
						$this->_deleteImage($this->PhotoLarge);

					$this->PhotoLarge = '';
					return $value;
				}

				try
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->PhotoLarge = FileStore::ObjectToString($img_obj);
						}
					}
				}
				catch(MyException $e) { }
			break;
		}
		return null;
	}

	public function __get($name) {

		$name = strtolower($name);
		switch($name) {
			case 'photosmall':
				if (!$this->PhotoSmall)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');

				try
				{
					$img_obj = FileStore::ObjectFromString($this->PhotoSmall);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj,
						$this->_images_dir, $this->_images_url);
					unset($img_obj);
					if (empty($preparedImage))
						return null;
				}
				catch ( MyException $e )
				{
					return null;
				}

				return array(
					'f' => $preparedImage['url'],
					'file' => $preparedImage['file'],
					'w' => $preparedImage['w'],
					'h' => $preparedImage['h'],
				);
			break;
			case 'photolarge':
				if (!$this->PhotoLarge)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');

				try
				{
					$img_obj = FileStore::ObjectFromString($this->PhotoLarge);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj,
						$this->_images_dir, $this->_images_url);
					unset($img_obj);
					if (empty($preparedImage))
						return null;
				}
				catch ( MyException $e )
				{
					return null;
				}

				return array(
					'f' => $preparedImage['url'],
					'file' => $preparedImage['file'],
					'w' => $preparedImage['w'],
					'h' => $preparedImage['h'],
				);
			break;
		}

		return null;
	}

	function __destruct()
	{

	}
}

