<?php

LibFactory::GetStatic('arrays');

class TArticle
{
	private $_mgr;

	public $ID;
	public $SectionID;
	public $ParentID;
	public $NameID;
	public $Created;
	public $LastUpdated;
	public $Date;
	public $ShortTitle;
	public $Title;
	public $AnnounceText;
	public $Text;
	public $IsVisible;
	public $IsComments;
	public $IsRSS;
	public $IsMain;
	public $IsImportant;
	public $Views;
	public $CountComments;
	public $SeoTitle;
	public $SeoDescription;
	public $SeoKeywords;
	public $SeoText;

	private $Thumb;

	private $_cachePhotos = null;
	private $_cacheUrl = null;

	private $_images_dir = '/common_fs/i/tarticles/';
	private $_images_url = '/resources/fs/i/tarticles/';

	private $_files_dir = '/common_fs/f/tarticles/';
	private $_files_url = '/resources/fs/f/tarticles/';

	private $thumb_size = array('max_width' => 90, 'max_height' => 90);

	private $photo_file_size = 10485760; //700K
	private $file_size = 10485760; // 2M



	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['articleid']) && Data::Is_Number($info['articleid']) )
			$this->ID = $info['articleid'];

		$this->SectionID		= (int) $info['sectionid'];
		$this->NameID			= stripslashes($info['nameid']);
		$this->ParentID			= (int) $info['parentid'];
		$this->Created			= $info['created'];
		$this->LastUpdated		= $info['lastupdated'];
		$this->Date				= $info['date'];
		$this->ShortTitle		= stripslashes($info['shorttitle']);
		$this->Title			= stripslashes($info['title']);
		$this->AnnounceText		= stripslashes($info['announcetext']);
		$this->Text				= stripslashes($info['text']);
		$this->IsVisible		= $info['isvisible'] ? true : false;
		$this->IsComments		= $info['iscomments'] ? true : false;
		$this->IsRSS			= $info['isrss'] ? true : false;
		$this->IsMain			= $info['ismain'] ? true : false;
		$this->IsImportant		= $info['isimportant'] ? true : false;
		$this->Views			= (int) $info['views'];
		$this->CountComments	= (int) $info['countcomments'];
		$this->Thumb			= $info['thumb'];
		$this->SeoTitle			= stripslashes($info['seotitle']);
		$this->SeoDescription	= stripslashes($info['seodescription']);
		$this->SeoKeywords		= stripslashes($info['seokeywords']);
		$this->SeoText			= stripslashes($info['seotext']);
	}


	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод TreeArticleMgr
	 */
	public function Update()
	{
		$info = array(
            'SectionID'        	=> (int) $this->SectionID,
            'ParentID'        	=> (int) $this->ParentID,
            'NameID'        	=> stripslashes($this->NameID),
            'Date'            	=> $this->Date,
			'ShortTitle'		=> stripslashes($this->ShortTitle),
			'Title'				=> stripslashes($this->Title),
			'AnnounceText'		=> stripslashes($this->AnnounceText),
			'Text'				=> stripslashes($this->Text),
			'IsVisible'			=> (int) $this->IsVisible,
			'IsComments'		=> (int) $this->IsComments,
			'IsRSS'				=> (int) $this->IsRSS,
			'IsMain'			=> (int) $this->IsMain,
			'IsImportant'		=> (int) $this->IsImportant,
			'Views'				=> (int) $this->Views,
			'CountComments'		=> (int) $this->CountComments,
			'Thumb'				=> $this->Thumb,
			'SeoTitle'			=> stripslashes($this->SeoTitle),
			'SeoDescription'	=> stripslashes($this->SeoDescription),
			'SeoKeywords'		=> stripslashes($this->SeoKeywords),
			'SeoText'			=> stripslashes($this->SeoText),
		);

		if ( $this->ID !== null )
		{
			$info['ArticleID'] = $this->ID;
			if ( false !== TreeArticleMgr::getInstance()->Update($info))
			{
				return true;
			}
		}
		else if ( false !== ($new_id = TreeArticleMgr::getInstance()->Add($info)))
		{
			$this->ID = $new_id;
			return $new_id;
		}

		return false;
	}

	public function UpdateViews()
	{
		TreeArticleMgr::getInstance()->UpdateViews($this->ID);
	}

	public function Remove()
	{
		if ( $this->ID === null)
			return false;

		TreeArticleMgr::getInstance()->Remove($this->ID);
	}

	public function GetCountChilds()
	{
		$sql = "SELECT count(0) FROM ".TreeArticleMgr::GetInstance()->_tables['articles'];
		$sql.= " WHERE ParentID = ".$this->ID;
		$res = TreeArticleMgr::GetInstance()->_db->query($sql);
		list($cnt) = $res->fetch_row();
		return intval($cnt);
	}

	private $path = array();
	public function GetURL()
	{
		if ($this->ParentID == 0)
			return $this->NameID."/";

		$this->path = array();
		$path = $this->get_recursive_path($this->ParentID);
		return implode("/",array_reverse($path))."/".$this->NameID."/";
	}


	private function get_recursive_path($parentid)
	{
		$sql = "SELECT ParentID, NameID FROM ".TreeArticleMgr::GetInstance()->_tables['articles'];
		$sql.= " WHERE ArticleID = ".$parentid;

		$res = TreeArticleMgr::GetInstance()->_db->query($sql);
		list($parentid,$nameid) = $res->fetch_row();

		$this->path[] = $nameid;
		$parentid = intval($parentid);
		if ($parentid > 0)
			$this->get_recursive_path($parentid);

		return $this->path;
	}

	private function _deleteThumb()
	{
		try
		{
			if( ($img_obj = FileStore::ObjectFromString($this->Thumb)) !== false )
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

		global $OBJECTS;
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		if (empty($_FILES['Thumb']['name']))
			return "";

		$pname = FileStore::Upload_NEW(
			'Thumb', $this->_images_dir, rand(1000, 9999).$this->ID.'_thumb',
			FileMagic::MT_WIMAGE, $this->photo_file_size,
			array(
				'resize' => array(
					'tr' => 3,
					'w'  => $this->thumb_size['max_width'],
					'h'  => $this->thumb_size['max_height'],
				),
			)
		);

		$pname = FileStore::GetPath_NEW($pname);
		$thumbNew = Images::PrepareImageToObject($pname, $this->_images_dir);
		$pname = FileStore::ObjectToString($thumbNew);

		$this->__set('Thumb', $pname);
		return $result;
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
			case 'photos':
				// if ($this->_cachePhotos !== null)
				// 	return $this->_cachePhotos;

				$filter = array(
					'flags' => array(
						'objects' => true,
						'ArticleID' => $this->ID,
					),
					'field' => array(
						'Ord',
					),
					'dir' => array(
						'ASC',
					),
					'dbg' => 0,
				);

				$this->_cachePhotos = TreeArticleMgr::getInstance()->GetPhotos($filter);
				return $this->_cachePhotos;
			case 'url':
				if ($this->_cacheUrl !== null)
					return $this->_cacheUrl;
				$this->_cacheUrl = ModuleFactory::GetLinkBySectionId($this->SectionID).$this->ID."/";
				return $this->_cacheUrl;
		}

		return null;
	}

	function __destruct()
	{

	}
}