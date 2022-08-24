<?php

LibFactory::GetStatic('arrays');

class Contacts
{
	private $_mgr;

	public $ID;
	public $SectionID;
	public $Created;
	public $Text;
	public $TitleText;
	public $Title;
	public $Note;
	public $Link;
	public $IsVisible;
	public $Ord;

	private $Thumb;
	private $SmallThumb;

	private $_cachePhotos = null;
	private $_cacheUrl = null;

	private $_images_dir = '/common_fs/i/shares/';
	private $_images_url = '/resources/fs/i/shares/';

	private $_files_dir = '/common_fs/f/shares/';
	private $_files_url = '/resources/fs/f/shares/';

	private $thumb_size = array('max_width' => 283, 'max_height' => 283);
	private $small_thumb_size = array('max_width' => 90, 'max_height' => 90);

	private $photo_file_size = 2097152; //2M
	private $file_size = 2097152; // 2M

	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['shareid']) && Data::Is_Number($info['shareid']) )
			$this->ID = $info['shareid'];

		$this->SectionID  = (int)$info['sectionid'];
		$this->Created    = ($info['created']);
		$this->Text       = stripslashes($info['text']);
		$this->TitleText  = stripslashes($info['titletext']);
		$this->Title      = stripslashes($info['title']);
		$this->Note       = stripslashes($info['note']);
		$this->Link       = ($info['link']);
		$this->IsVisible  = $info['isvisible'] ? true : false;
		$this->Ord        = (int)$info['ord'];
		$this->Thumb      = $info['thumb'];
		$this->SmallThumb = $info['smallthumb'];
	}


	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод ArticleMgr
	 */
	public function Update()
	{
		$info = array(
			'SectionID'  => $this->SectionID,
			'Text'       => stripslashes($this->Text),
			'TitleText'  => stripslashes($this->TitleText),
			'Title'      => stripslashes($this->Title),
			'Note'       => stripslashes($this->Note),
			'Link'       => stripslashes($this->Link),
			'IsVisible'  => (int) $this->IsVisible,
			'Ord'        => (int) $this->Ord,
			'Thumb'      => $this->Thumb,
			'SmallThumb' => $this->SmallThumb,
		);

		if ( $this->ID !== null )
		{
			$info['ShareID'] = $this->ID;
			if ( false !== ShareMgr::getInstance()->Update($info))
			{
				return true;
			}
		}
		else if ( false !== ($new_id = ShareMgr::getInstance()->Add($info)))
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

		ShareMgr::getInstance()->Remove($this->ID);
	}

	private function _deleteThumb()
	{
		return $this->_deleteFile($this->Thumb);
	}

	private function _deleteSmallThumb()
	{
		return $this->_deleteFile($this->SmallThumb);
	}


	private function _deleteFile($image_string)
	{
		try
		{
			if( ($img_obj = FileStore::ObjectFromString($image_string)) !== false )
			{
				$del_file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
				if (FileStore::IsFile($del_file))
					return FileStore::Delete_NEW($del_file);
			}
		}
		catch(MyException $e) { }
		return false;
	}


	public function UploadThumb()
	{
		return $this->_uploadFile('Thumb', '_thumb');
	}
	public function UploadSmallThumb()
	{
		return $this->_uploadFile('SmallThumb', '_smallthumb');
	}

	private function _uploadFile($fieldName, $postfix)
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		if (empty($_FILES[$fieldName]['name']))
			return "";

		$pname = FileStore::Upload_NEW(
			$fieldName, $this->_images_dir, rand(1000, 9999).$this->ID.$postfix,
			FileMagic::MT_WIMAGE, $this->photo_file_size
			// ,
			// array(
			// 	'resize' => array(
			// 		'tr' => 3,
			// 		'w'  => $this->thumb_size['max_width'],
			// 		'h'  => $this->thumb_size['max_height'],
			// 	),
			// )
		);

		$pname = FileStore::GetPath_NEW($pname);
		$thumbNew = Images::PrepareImageToObject($pname, $this->_images_dir);
		$pname = FileStore::ObjectToString($thumbNew);

		$this->__set($fieldName, $pname);
		return $pname;
	}


	public function __set($name, $value)
	{
		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

		$name = strtolower($name);
		switch($name)
		{
			case 'thumb':
				if ($value === null)
				{
					if ($this->Thumb)
						$this->_deleteThumb($this->Thumb);

					$this->Thumb = '';
					return $value;
				}

				try
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->Thumb = FileStore::ObjectToString($img_obj);
						}
					}
				}
				catch(MyException $e) { }
			break;

			case 'smallthumb':
				if ($value === null)
				{
					if ($this->SmallThumb)
						$this->_deleteSmallThumb($this->SmallThumb);

					$this->SmallThumb = '';
					return $value;
				}

				try
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->SmallThumb = FileStore::ObjectToString($img_obj);
						}
					}
				}
				catch(MyException $e) { }
			break;

		}
		return null;
	}

	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'thumb':
				if (!$this->Thumb)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');

				try
				{
					$img_obj = FileStore::ObjectFromString($this->Thumb);
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
					'w' => $preparedImage['w'],
					'h' => $preparedImage['h'],
				);
			break;

			case 'smallthumb':
				if (!$this->SmallThumb)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');

				try
				{
					$img_obj = FileStore::ObjectFromString($this->SmallThumb);
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
