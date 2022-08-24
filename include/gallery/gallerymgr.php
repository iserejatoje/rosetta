<?php

require_once ($CONFIG['engine_path'].'include/gallery/gallery.php');
require_once ($CONFIG['engine_path'].'include/gallery/galleryalbum.php');
require_once ($CONFIG['engine_path'].'include/gallery/galleryphoto.php');
require_once ($CONFIG['engine_path'].'include/gallery/galleryalbumiterator.php');
require_once ($CONFIG['engine_path'].'include/gallery/galleryphotoiterator.php');

/**
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:37
 */
class GalleryMgr
{
	private $_DB = null;
	private $_Tables = array();
	private $_Cfg = array();

	public function __construct($db, $tables, $cfg)
	{		
		$this->_DB = DBFactory::GetInstance($db);
		$this->_Tables = $tables;
		$this->_Cfg = $cfg;
    }
	
	/**
	 * 
	 * @param uniqueid
	 * @param id
	 */
	public function GetGallery($uniqueid, $id = null)
	{
		return new Gallery($uniqueid, $id, $this);
	}

	/**
	 * 
	 * @param uniqueid
	 * @param id
	 */
	public function GetAlbum($uniqueid, $id = null)
	{
		if($id === null)
			$id = GalleryAlbum::GetAlbumID($uniqueid, $mgr);
		return new GalleryAlbum($uniqueid, $id, null, $this);
	}	
	
	public function GetAlbumForPhoto($uniqueid, $id)
	{
		$sql = "SELECT * FROM ".$this->_Tables['photos'];
		$sql.= " WHERE PhotoID=".$id;
		$res = $this->_DB->query($sql);
		$row = $res->fetch_assoc();
		if($row === false)
			return null;
		return new GalleryAlbum($uniqueid, $row['AlbumID'], null, $this);
	}
		
	public function CheckPhoto($photo)
	{
		$fsize = filesize($photo);
		list($width, $height) = getimagesize($photo);

		if($fsize > $this->_Cfg['max']['size'] || $width > $this->_Cfg['max']['width'] || $height > $this->_Cfg['max']['height'])
			return false;
		else
			return true;
    }
	
	/**
     * Создать галерею
     * @param int $uniqueid
     * @param string $title
     * @param string $descr
     * @param int $isvisible не используется
     */
	public function CreateGallery($uniqueid, $title, $descr, $isvisible = 0)
	{
		$sql = "INSERT INTO ".$this->_Tables['galleries'];
		$sql.= " SET";
		$sql.= " Created=Now(),";
		$sql.= " UniqueID=".intval($uniqueid).',';
		$sql.= " Title='".addslashes($title)."',";
		$sql.= " Descr='".addslashes($descr)."',";
		$sql.= " IsVisible=".$isvisible;
		if($this->_DB->query($sql))
			return $this->_DB->insert_id;
		else
			return null;
    }
	
	/**
	 * Копирование альбомов и фотографий из одной галереи в другую
	 * Создаётся новая галерея с параметрами исходной и происсходит физическое копирование
	 *
	 * @param srcUniqueid int - идентификатор исходной галереи (н-р: NewsID)
	 * @param dstUniqueid int - идентификатор к чему привязывать
	 * @return bool
	 */
	public function Copy($srcUniqueid, $dstUniqueid)
	{
		try 
		{
			$srcGallery = $this->GetGallery($srcUniqueid);
			if ( sizeof($srcGallery->Albums) == 0 ) 
				return false;
		}
		catch(Exception $e)
		{
			return false;
		}
		
		try
		{
			$dstGallery = $this->GetGallery($dstUniqueid);
		}
		catch(Exception $e)
		{
			return false;
		}

		
		//Цикл по альбомам
		foreach($srcGallery->Albums as $album)
		{
			try
			{
				$copyAlbum = $dstGallery->CreateAlbum();
				$copyAlbum->User = $album->User->ID;
				$copyAlbum->Title = $album->Title;
				$copyAlbum->Description = $album->Description;
				$copyAlbum->Update();
			}
			catch(Exception $e)
			{
				continue;
			}
			
			foreach ($album->Photos as $photo)
			{
				try
				{
					$newPhotoArr = $photo->CopyPhoto();
					$newThumbArr = $photo->CopyThumb();
				}
				catch(Exception $e)
				{
					continue;
				}
				
				$copyPhoto = $copyAlbum->CreatePhoto();
				$copyPhoto->User = $photo->User->ID;
				$copyPhoto->Title = $photo->Title;
				$copyPhoto->Description = $photo->Description;
				$copyPhoto->order = $photo->order;
				$copyPhoto->IsVisible = $photo->IsVisible;
				$copyPhoto->Photo = $newPhotoArr['file'];
				$copyPhoto->Thumb = $newThumbArr['file'];
				$copyPhoto->Update();
			}
		}
	}

	/**
	 * 
	 * @param name
	 */
	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'db':
				return $this->_DB;
			case 'tables':
				return $this->_Tables;
			case 'config':
				return $this->_Cfg;
        }
	}

	/**
	 * 
	 * @param name
	 */
	public function __isset($name)
	{
	}

	/**
	 * 
	 * @param name
	 */
	public function __unset($name)
	{
	}

	/**
	 * 
	 * @param name
	 * @param value
	 */
	public function __set($name, $value)
	{
	}
}
?>