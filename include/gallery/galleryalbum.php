<?php


/**
 * альбом, может быть привязан к галереии в этом случае у него _Parent содержит
 * ссылку на галерею или сам по себе, в этом случае null
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:34
 */
class GalleryAlbum
{
	private $_Mgr			= null;
	private $_Parent		= null;
	private $_ID			= null;
	private $_UniqueID		= null;
	private $_Photos		= null;
	private $_Created		= null;
	private $_User			= null;
	private $_Title			= null;
	private $_Description	= null;
	private $_IsNew			= true;
	private $_IsVisible		= null;
	private $_Thumb			= null;

	/**
	 * 
	 * @param uniqueid
	 * @param id
	 * @param parent
	 */
	public function __construct($uniqueid = null, $id = null, $parent = null, $mgr = null)
	{
		global $OBJECTS;
		if(!is_numeric($id)) $id = null;
		if(!is_numeric($uniqueid)) $uniqueid = null;
		if($parent !== null && !is_a($parent, 'Gallery')) $parent = null;
		if(!is_a($mgr, 'GalleryMgr')) $mgr = null;
		
		if($uniqueid === null || $mgr === null)
			throw new exception("Can't create GalleryAlbum object directly.");

		$this->_UniqueID = $uniqueid;
		$this->_ID = $id;
		$this->_Parent = $parent;
		$this->_Mgr = $mgr;

		if($id !== null)
		{
			$sql = "SELECT * FROM ".$this->_Mgr->Tables['albums'];
			$sql.= " WHERE AlbumID=".$id;
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			if(!$row)
				throw new exception("Can't find album");

			if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
			{		
				$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
				if(!in_array($row['IsVisible'], $rights) && $row['UserID'] != $OBJECTS['user']->ID)
					throw new exception("Can't find album");
			}

			if($row['GalleryID'] > 0)
				$this->_Parent = $this->_Mgr->GetGallery($this->_UniqueID, $row['GalleryID'], $this->_Mgr);
				
			$this->_ID			= $id;
			$this->_User		= $row['UserID'];
			$this->_Created		= $row['Created'];
			$this->_Title		= $row['Title'];
			$this->_Description = $row['Descr'];
			$this->_IsNew		= $row['IsNew'];
			$this->_IsVisible	= $row['IsVisible'];
			$this->_Thumb = array(
				'file'		=> $row['Thumb'],
				'size'		=> $row['ThumbSize'],
				'width'		=> $row['ThumbWidth'],
				'height'	=> $row['ThumbHeight']);
		}
	}
	
	public static function GetAlbumID($uniqueid, $mgr)
	{
		if(!is_numeric($uniqieid) || $uniqueid <= 0)
			return null;
		$sql = "SELECT * FROM ".$this->_Mgr->Tables['albums'];
		$sql.= " WHERE UniqueID=".$uniqueid;
		$res = $mgr->DB->query($sql);
		$row = $res->fetch_assoc();
		if(!$row)
			return null;
		else
			return $row['AlbumID'];
    }
	
	/** 
     * Получает альбому по uniqueid	
	 */
	public static function GetAlbumsForUniqueId($uniqueid, $mgr)
	{
		if (empty($uniqueid) )		
			return array();
		
			
		$sql = "SELECT * FROM ".$mgr->Tables['albums']." WHERE";		
		$sql.= " UniqueID = ".$uniqueid;
		
		$albums = array();
		
		$res = $mgr->DB->query($sql);		
		while($row = $res->fetch_assoc())
		{
			if (!isset($albums[$row['AlbumID']]))
			{
				
				$albums[$row['AlbumID']] = $mgr->GetAlbum($uniqueid, $row['AlbumID']);
			}
		}
		return $albums;
	}

	/**
	*
	*$isconverted - флаг для установки факта конвертирования
	*/
	public function Update($isconverted=null)
	{
		global $OBJECTS;
		//$this->_IsNew = true;

		if($this->_ID === null)
		{
			if($this->User === null)
				throw new exception('User not set');
			$parent = 0;
			if($this->_Parent !== null)
				$parent = $this->_Parent->ID;
				
			if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
				$this->_IsVisible = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetDefault();
			
			$sql = "INSERT INTO ".$this->_Mgr->Tables['albums'];
			$sql.= " SET UniqueID=".$this->_UniqueID.",";
			$sql.= " Created=NOW(),";
			$sql.= " UserID=".$this->User->ID.",";
			$sql.= " GalleryID=".$parent.",";
			
			if ( isset($isconverted) )
				$sql.= " IsConverted=".(int)$isconverted.",";
        }
		else
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['albums'];
			$sql.= " SET ";
        }

		$sql.= " Title='".addslashes($this->_Title)."',";
		$sql.= " Descr='".addslashes($this->_Description)."',";
		$sql.= " IsVisible=".intval($this->_IsVisible).",";
		$sql.= " IsNew=".($this->_IsNew?1:0);

		if($this->_ID !== null)
		{
			$sql.= " WHERE AlbumID=".$this->_ID;
        }

		$this->_Mgr->DB->query($sql);
		if($this->_ID === null)
		{
			$this->_ID = $this->_Mgr->DB->insert_id;
			return $this->_ID;
        }
		else
			return true;
	}

	public function Remove()
	{
		$albumid = $this->_ID;
		if(is_numeric($albumid))
		{
			$sql = "SELECT Thumb, Photo FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE AlbumID=".$albumid;
			
			$res = $this->_Mgr->DB->query($sql);
			if ($res && $res->num_rows) {
				LibFactory::GetStatic('filestore');
				while(false != ($row = $res->fetch_assoc()))
				{
					try {
						$file = FileStore::GetPath_NEW($row['Thumb']);
						if ( $row['Thumb'] != '' && filestore::IsFile($this->_Mgr->Config['thumb']['path'].$file) )
							filestore::Delete_NEW($this->_Mgr->Config['thumb']['path'].$file);

						$file = FileStore::GetPath_NEW($row['Photo']);
						if ( $row['Photo'] != '' && filestore::IsFile($this->_Mgr->Config['photo']['path'].$file) )
							filestore::Delete_NEW($this->_Mgr->Config['photo']['path'].$file);
					}
					catch (MyException $e) {}
				}
			}
			
			$sql = "DELETE FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE AlbumID=".$albumid;
			$this->_Mgr->DB->query($sql);
			
			$sql = "DELETE FROM ".$this->_Mgr->Tables['albums']." WHERE AlbumID=".$albumid;
			$this->_Mgr->DB->query($sql);
			
			if (isset($this->_Mgr->Tables['rating']) && !empty($this->_Mgr->Tables['rating']))
			{			
				$sql = "DELETE FROM ".$this->_Mgr->Tables['rating']." WHERE AlbumID=".$albumid;
				$this->_Mgr->DB->query($sql);
			}
		}
	}

	/**
	 * 
	 * @param photo
	 */
	public function UpdatePhoto($photo, $setmain = false)
	{
		global $OBJECTS;
		
		if(!$photo->ThumbPath || !$photo->PhotoPath)
			return false;

		//LibFactory::GetStatic('filestore');
		//if(!filestore::IsFile($photo->ThumbPath) || !filestore::IsFile($photo->PhotoPath))
		//	return false;
			
		if(empty($this->_Thumb['file']) || $setmain === true)
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['albums'];
			$sql.= " SET ";
			$sql.= " Thumb='".addslashes($photo->Thumb)."',";
			$sql.= " ThumbSize='".$photo->ThumbSize."',";
			$sql.= " ThumbWidth='".$photo->ThumbWidth."',";
			$sql.= " ThumbHeight='".$photo->ThumbHeight."'";
			$sql.= "WHERE AlbumID=".$this->_ID;
			$this->_Mgr->DB->query($sql);
			
			$this->_Thumb['file'] = $photo->Thumb;
			$this->_Thumb['size'] = $photo->ThumbSize;
			$this->_Thumb['width'] = $photo->ThumbWidth;
			$this->_Thumb['height'] = $photo->ThumbHeight;
        }

		if($photo->ID === null)
		{
			if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
				$photo->IsVisible = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetDefault();
			
			$parent = $this->_ID;
			$sql = "INSERT INTO ".$this->_Mgr->Tables['photos'];
			$sql.= " SET ";
			$sql.= " Created=NOW(),";
			$sql.= " UserID=".$photo->User->ID.",";
			$sql.= " AlbumID=".$parent.",";
        }
		else
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['photos'];
			$sql.= " SET ";
        }
		
		$sql.= " Title='".addslashes($photo->Title)."',";
		$sql.= " Descr='".addslashes($photo->Description)."',";
		$sql.= " IsVisible=".intval($photo->IsVisible).",";
		$sql.= " `Order`=".intval($photo->Order).",";
		$sql.= " IsNew=".($photo->IsNew?1:0).",";
		
		$sql.= " Photo='".addslashes($photo->Photo)."',";
		$sql.= " PhotoSize='".$photo->PhotoSize."',";
		$sql.= " PhotoWidth='".$photo->PhotoWidth."',";
		$sql.= " PhotoHeight='".$photo->PhotoHeight."',";
		
		$sql.= " Thumb='".addslashes($photo->Thumb)."',";
		$sql.= " ThumbSize='".$photo->ThumbSize."',";
		$sql.= " ThumbWidth='".$photo->ThumbWidth."',";
		$sql.= " ThumbHeight='".$photo->ThumbHeight."'";

		if($photo->ID !== null)
		{
			$sql.= " WHERE PhotoID=".$photo->ID;
        }

		if ($this->_Mgr->DB->query($sql) !== false) {
			if($photo->ID === null)
			{
				return $this->_Mgr->DB->insert_id;
			}
			else
				return true;
		} else
			return false;
	}

	/**
	 * 
	 * @param id
	 */
	public function RemovePhoto($id)
	{
		$photo = $this->GetPhoto($id);
		LibFactory::GetStatic('filestore');

		try {
			if ( $photo->PhotoPath )
				filestore::Delete_NEW($photo->PhotoPath);
		
			if ( $photo->ThumbPath )
				filestore::Delete_NEW($photo->ThumbPath);
		}
		catch (MyException $e) {}

		$sql = "DELETE FROM ".$this->_Mgr->Tables['photos']." WHERE PhotoID=".$id;
		$this->_Mgr->DB->query($sql);
		
		if (isset($this->_Mgr->Tables['rating']) && !empty($this->_Mgr->Tables['rating']))
		{
			$sql = "DELETE FROM ".$this->_Mgr->Tables['rating']." WHERE PhotoID=".$id;
			$this->_Mgr->DB->query($sql);
		}
		
		// объект еще живой, так что данные актуальны
		if($this->Thumb == $photo->Thumb) // удалили активную фотку, берем первую попавшуюся из альбома или удаляем
		{
			$sql = "SELECT Thumb, ThumbWidth, ThumbHeight, ThumbSize FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE AlbumID=".$this->_ID;
			$sql.= " LIMIT 1";
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			if($row)
			{
				$this->_Thumb['file']	= $row['Thumb'];
				$this->_Thumb['size']	= $row['ThumbSize'];
				$this->_Thumb['width']	= $row['ThumbWidth'];
				$this->_Thumb['height'] = $row['ThumbHeight'];
            }
			else
			{
				$this->_Thumb['file']	= '';
				$this->_Thumb['size']	= '';
				$this->_Thumb['width']	= '';
				$this->_Thumb['height'] = '';
            }
			
			$sql = "UPDATE ".$this->_Mgr->Tables['albums'];
			$sql.= " SET ";
			$sql.= " Thumb='".addslashes($this->_Thumb['file'])."',";
			$sql.= " ThumbSize='".$this->_Thumb['size']."',";
			$sql.= " ThumbWidth='".$this->_Thumb['width']."',";
			$sql.= " ThumbHeight='".$this->_Thumb['height']."'";
			$sql.= "WHERE AlbumID=".$this->_ID;
			$this->_Mgr->DB->query($sql);
        }
	}

	/**
	 * 
	 * @param id
	 */
	public function GetPhoto($id)
	{
		return new GalleryPhoto($id, $this, $this->_Mgr);
	}

	public function GetNextPhoto($id, $filter, $rights = null)
	{
		if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
		{
			$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
		}

		$filter = array_merge($filter, array(
			'albumid'	=> $this->ID, 
			'limit'		=> 1,
			'rights'	=> $rights,
			'next'		=> (int) $id,
		));
				
		$photo = new GalleryPhotoIterator($filter, $this, $this->_Mgr);
		if ($photo->count())
			return $photo->current();
			
		return null;
	}
	
	public function GetPreviousPhoto($id, $filter, $rights = null)
	{		
		if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
		{
			$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
		}

		$filter = array_merge($filter, array(
			'albumid'	=> $this->ID, 
			'limit'		=> 1,
			'rights'	=> $rights,
			'prev'		=> (int) $id,
		));

		$photo = new GalleryPhotoIterator($filter, $this, $this->_Mgr);
		if ($photo->count())
			return $photo->current();
			
		return null;
	}
	
	public function GetLastPhoto($filter = array())
	{
		$rights = null;
		if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
		{
			$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
		}

		$filter = array_merge($filter, array(
			'albumid'	=> $this->ID, 
			'limit'		=> 1,
			'rights'	=> $rights,
			'dir'		=> 'desc',
		));

		$photo = new GalleryPhotoIterator($filter, $this, $this->_Mgr);
		if ($photo->count())
			return $photo->current();
			
		return null;
	}
	
	public function CreatePhoto()
	{
		if($this->_ID === null)
			return null;
			
		return new GalleryPhoto(null, $this, $this->_Mgr);
    }

	/**
	 * 
	 * @param daa
	 */
	public static function CreateFromArray($data, $uniqueid, $parent, $mgr)
	{
		$obj = new self($uniqueid, null, $parent, $mgr);
		
		$obj->_ID			= $data['AlbumID'];
		$obj->_User			= $data['UserID'];
		$obj->_Created		= $data['Created'];
		$obj->_Title		= $data['Title'];
		$obj->_Description	= $data['Descr'];
		$obj->_IsNew		= $data['IsNew'];
		$obj->_IsVisible	= $data['IsVisible'];
		$obj->_Thumb = array(
				'file'		=> $data['Thumb'],
				'size'		=> $data['ThumbSize'],
				'width'		=> $data['ThumbWidth'],
				'height'	=> $data['ThumbHeight']);
		
		return $obj;
	}
	
	/**
	 * Параметры Photos
	 * 
	 * @param name
	 */
	public function __get($name)
	{
		global $OBJECTS;
		$name = strtolower($name);
		switch($name)
		{
			case 'mgr';
				return $this->_Mgr;
			case 'parent';
				return $this->_Parent;
			case 'id';
				return $this->_ID;
			case 'uniqueid';
				return $this->_UniqueID;
			case 'created';
				return $this->_Created;
			case 'user';
				if($this->_User !== null && is_numeric($this->_User))
					$this->_User = $OBJECTS['usersMgr']->GetUser($this->_User);
				return $this->_User;
			case 'photos':
				if($this->_ID === null)
					return null;				
				
				if($this->_Photos === null)
				{
					$rights = null;
					if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
					{
						$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
					}
					$filter = array('albumid' => $this->_ID, 'rights' => $rights);

					$this->_Photos = new GalleryPhotoIterator($filter, $this, $this->_Mgr);
				}
				return $this->_Photos;
			case 'title';
				return $this->_Title;
			case 'description';
				return $this->_Description;
			case 'isnew';
				return $this->_IsNew;
			case 'isvisible';
				return $this->_IsVisible;
				
			case 'thumb':
			case 'thumbsize':
			case 'thumbwidth':
			case 'thumbheight':
			case 'thumburl':
			case 'thumbpath':
				if (!is_array($this->_Thumb) || trim($this->_Thumb['file']) == '')
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
		}
	}

	/**
	 * 
	 * @param name
	 */
	public function __isset($name)
	{
		if( $name == 'mgr' || 
			$name == 'parent' || 
			$name == 'id' || 
			$name == 'uniqueid' || 
			$name == 'created' || 
			$name == 'user' || 
			$name == 'title' || 
			$name == 'description' || 
			$name == 'thumb' ||
			$name == 'thumbsize' ||
			$name == 'thumbwidth' ||
			$name == 'thumbheight' ||
			$name == 'isnew' || 
			$name == 'isvisible')
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
			case 'isnew':
				$this->_IsNew = $value;
				break;
			case 'isvisible':
				$this->_IsVisible = $value;
				break;
			case 'id':
				$this->_ID = $value;
				break;
		}
	}

}
?>