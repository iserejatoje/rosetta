<?php

require_once ($CONFIG['engine_path'].'include/gallery/galleryphoto.php');
/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 17:20 25 ноября 2009 г.
 */
class StandAloneGalleryPhoto extends GalleryPhoto
{
	private $_Mgr			= null;
	private $_Parent		= null;
	private $_ID			= null;
	private $_User			= null;
	private $_Created		= null;
	private $_Title			= null;
	private $_Description	= null;
	private $_Thumb			= null;
	private $_Photo			= null;
	private $_IsNew			= null;
	private $_IsVisible		= null;
	private $_Order			= null;

	/**
	 * 
	 * @param id
	 * @param parent
	 */
	public function __construct($id = null, $mgr = null)
	{
		global $OBJECTS;
		if(!is_numeric($id)) $id = null;		
		if(!is_a($mgr, 'GalleryMgr')) $mgr = null;
		
		if($mgr === null)
			return null;

		$this->_ID		= $id;		
		$this->_Mgr		= $mgr;
		
		if($id !== null)
		{
			$sql = "SELECT * FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE PhotoID=".$id;
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			
			if(!$row)
				return null;
										
			$this->_ID			= $id;
			$this->_User		= $row['UserID'];
			$this->_Created		= $row['Created'];
			$this->_Title		= $row['Title'];
			$this->_Description = $row['Descr'];
			$this->_Thumb = array(
				'file'		=> $row['Thumb'],
				'size'		=> $row['ThumbSize'],
				'width'		=> $row['ThumbWidth'],
				'height'	=> $row['ThumbHeight']);
			$this->_Photo = array(
				'file'		=> $row['Photo'],
				'size'		=> $row['PhotoSize'],
				'width'		=> $row['PhotoWidth'],
				'height'	=> $row['PhotoHeight']);
			$this->_IsNew		= $row['IsNew'];
			$this->_IsVisible	= $row['IsVisible'];
			$this->_Order	= $row['Order'];
		}
		else
		{
			$this->_Thumb = array();
			$this->_Photo = array();
        }
	}
	
	public function MovePhoto($AlbumID)
	{				
		return false;
	}
	
	public function Update($setmain = false, $isconverted = false)
	{
		return false;
	}

	public function Remove()
	{
		return false;
	}
	
	// для конвертации галерей
	public function UploadPhotoWithPrefix($file, $prefix, $index = null, $security = null) {
		return false;
	}
	
	public function UploadPhoto($file, $index = null, $security = null, $prefix = null)
	{
		return false;
    }
	
	// для конвертации галерей
	public function UploadThumbWithPrefix($file, $prefix, $index = null) {
		return false;
	}
	
	public function UploadThumb($file, $index = null, $prefix = null)
	{
		return false;
    }
	
	public function CropPhoto($params)
	{
		return false;
    }

	/**
	 * 
	 * @param data
	 */
	public static function CreateFromArray($data, $parent, $mgr)
	{
		$obj = new self(null, $mgr);
		
		$obj->_ID			= $data['PhotoID'];
		$obj->_User			= $data['UserID'];
		$obj->_Created		= $data['Created'];
		$obj->_Title		= $data['Title'];
		$obj->_Description	= $data['Descr'];
		$obj->_Thumb = array(
			'file'		=> $data['Thumb'],
			'size'		=> $data['ThumbSize'],
			'width'		=> $data['ThumbWidth'],
			'height'	=> $data['ThumbHeight']);
		$obj->_Photo = array(
			'file'		=> $data['Photo'],
			'size'		=> $data['PhotoSize'],
			'width'		=> $data['PhotoWidth'],
			'height'	=> $data['PhotoHeight']);
		$obj->_IsNew		= $data['IsNew'];
		$obj->_IsVisible	= $data['IsVisible'];
		$obj->_Order	= $data['Order'];
		return $obj;
	}

	/**
	 * 
	 * @param name
	 */
	public function __get($name)
	{
		global $OBJECTS;
		$name = strtolower($name);
		switch($name)
		{
			case 'mgr':
				return $this->_Mgr;
			case 'parent':
				return null;
			case 'id':
				return $this->_ID;
			case 'user':
				if($this->_User !== null && is_numeric($this->_User))
					$this->_User = $OBJECTS['usersMgr']->GetUser($this->_User);
				return $this->_User;
			case 'created':
				return $this->_Created;
			case 'title':
				return $this->_Title;
			case 'description':
				return $this->_Description;
			case 'isnew':
				return $this->_IsNew;
			case 'isvisible':
				return $this->_IsVisible;
			case 'order':
				return $this->_Order;

			// Thumb [S]
			case 'thumb':
			case 'thumbsize':
			case 'thumbwidth':
			case 'thumbheight':
			case 'thumburl':
			case 'thumbpath':
				if (!is_array($this->_Thumb))
					return null;

				if (empty($this->_Thumb['path']) || empty($this->_Thumb['url'])) {
					LibFactory::GetStatic('images');
					LibFactory::GetStatic('filestore');
					
					try
					{
						$thumb_obj = FileStore::ObjectFromString($this->_Thumb['file']);
						$thumb_obj['file'] = FileStore::GetPath_NEW($thumb_obj['file']);
						$preparedThumb = Images::PrepareImageFromObject($thumb_obj, 
							$this->_Mgr->Config['thumb']['path'], $this->_Mgr->Config['thumb']['url']);
						unset($thumb_obj);
					}
					catch ( MyException $e )
					{
						$this->_Thumb['url'] = '';
						$this->_Thumb['path'] = '';
				
						return null;
					}
			
					if (empty($preparedThumb))
							return null;
					
					$this->_Thumb['width'] = $preparedThumb['w'];
					$this->_Thumb['height'] = $preparedThumb['h'];
					$this->_Thumb['size'] = $preparedThumb['size'];
					$this->_Thumb['url'] = $preparedThumb['url'];
					$this->_Thumb['path'] = $preparedThumb['path'];
				}

				if ($name == 'thumbsize') {
					return $this->_Thumb['size'];
				} else if ($name == 'thumbwidth') {
					return $this->_Thumb['width'];
				} else if ($name == 'thumbheight') {
					return $this->_Thumb['height'];
				} else if ($name == 'thumburl') {
					return $this->_Thumb['url'];
				} else  if ($name == 'thumbpath') {
					return $this->_Thumb['path'];
				} else if ($name == 'thumb') {
					return $this->_Thumb['file'];
				}

				return $this->_Thumb[$name];
			break ;
			// Thumb [E]

			// Photo [S]
			case 'photo':
			case 'photosize':
			case 'photowidth':
			case 'photoheight':
			case 'photourl':
			case 'photopath':
				if (!is_array($this->_Photo))
					return null;

				if (empty($this->_Photo['path']) || empty($this->_Photo['url'])) {
					LibFactory::GetStatic('images');
					LibFactory::GetStatic('filestore');
					
					try
					{
						$photo_obj = FileStore::ObjectFromString($this->_Photo['file']);
						$photo_obj['file'] = FileStore::GetPath_NEW($photo_obj['file']);
						$preparedPhoto = Images::PrepareImageFromObject($photo_obj, 
							$this->_Mgr->Config['photo']['path'], $this->_Mgr->Config['photo']['url']);
						unset($photo_obj);
					}
					catch ( MyException $e )
					{
						$this->_Photo['url'] = '';
						$this->_Photo['path'] = '';
				
						return null;
					}
			
					if (empty($preparedPhoto))
							return null;
					
					$this->_Photo['width'] = $preparedPhoto['w'];
					$this->_Photo['height'] = $preparedPhoto['h'];
					$this->_Photo['size'] = $preparedPhoto['size'];
					$this->_Photo['url'] = $preparedPhoto['url'];
					$this->_Photo['path'] = $preparedPhoto['path'];
				}

				if ($name == 'photosize') {
					return $this->_Photo['size'];
				} else if ($name == 'photowidth') {
					return $this->_Photo['width'];
				} else if ($name == 'photoheight') {
					return $this->_Photo['height'];
				} else if ($name == 'photourl') {
					return $this->_Photo['url'];
				} else  if ($name == 'photopath') {
					return $this->_Photo['path'];
				} else if ($name == 'photo') {
					return $this->_Photo['file'];
				}

				return $this->_Photo[$name];
			break ;
			// Photo [E]
        }
	}

	/**
	 * 
	 * @param name
	 */
	public function __isset($name)
	{
		$name = strtolower($name);
		if(
			$name == 'mgr' ||
			$name == 'parent' ||
			$name == 'id' ||
			$name == 'user' ||
			$name == 'created' ||
			$name == 'title' ||
			$name == 'description' ||
			$name == 'thumb' ||
			$name == 'thumbsize' ||
			$name == 'thumbwidth' ||
			$name == 'thumbheight' ||
			$name == 'thumbpath' ||
			$name == 'thumburl' ||
			$name == 'photo' ||
			$name == 'photosize' ||
			$name == 'photowidth' ||
			$name == 'photoheight' ||
			$name == 'photopath' ||
			$name == 'photourl' ||
			$name == 'isnew' ||
			$name == 'isvisible' ||
			$name == 'order')
			return true;
		else 
			return false;

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
		global $OBJECTS;
		$name = strtolower($name);

		switch($name)
		{
			case 'user':
				if(is_numeric($value))
					$this->_User = $value;
				else
					error_log("Can't set user");
				break;
			case 'title':
				$this->_Title = $value;
				break;
			case 'description':
				$this->_Description = $value;
				break;
			case 'thumb':
				$this->_Thumb['file'] = $value;
				break;
			case 'photo':
				$this->_Photo['file'] = $value;
				break;
			case 'isnew':
				$this->_IsNew = $value;
				break;
			case 'isvisible':
				$this->_IsVisible = $value;
				break;
			case 'order':
				$this->_Order = $value;
				break;
        }		
	}

}
?>