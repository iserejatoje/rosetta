<?php


/**
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:33
 */
class Gallery
{
	private $_Mgr			= null;
	private $_ID			= null;
	private $_UniqueID		= null;
	private $_Albums		= null;
	private $_Title			= null;
	private $_Description	= null;
	private $_IsVisible		= null;
	
	private $_PhotosCount		= null;

	/**
	 * 
	 * @param uniqueid
	 * @param id
	 */
	public function __construct($uniqueid = null, $id = null, $mgr = null)
	{		
		if(!is_numeric($id)) $id = null;
		if(!is_numeric($uniqueid)) $uniqueid = null;
		if(!is_a($mgr, 'GalleryMgr')) $mgr = null;

		$this->_UniqueID = $uniqueid;
		$this->_ID = $id;
		$this->_Mgr = $mgr;

		if($id === null)
		{
			$sql = "SELECT GalleryID FROM ".$this->_Mgr->Tables['galleries'];
			$sql.= " WHERE UniqueID=".$uniqueid;
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			if(!$row)
			{
				$id = $this->_Mgr->CreateGallery($uniqueid, $uniqueid, '', 1);
				
				//throw new exception("Can't find gallery");
			}
			else
				$id = $row['GalleryID'];
		}
		
		if($uniqueid === null || $id === null || $mgr === null)
			throw new exception("Can't create Gallery object directly.");

		if($id !== null)
		{
			$sql = "SELECT * FROM ".$this->_Mgr->Tables['galleries'];
			$sql.= " WHERE GalleryID=".$id." AND UniqueID=".$uniqueid;
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			if(!$row)
				throw new exception("Can't find gallery");
				
			$this->_ID			= $id;
			$this->_Created		= $row['Created'];
			$this->_Title		= $row['Title'];
			$this->_Description = $row['Descr'];
			$this->_IsVisible	= $row['IsVisible'];
		}
	}

	public function Update()
	{
		if($this->_ID === null)
		{
			$parent = 0;
			if($this->_Parent !== null)
				$parent = $this->_Parent->ID;
			$sql = "INSERT INTO ".$this->_Mgr->Tables['galleries'];
			$sql.= " SET UiqueID=".$this->_UniqueID.",";
			$sql.= " Created=NOW(),";
			$sql.= " UserID=".$this->User->ID.",";
			$sql.= " GalleryID=".$parent.",";
        }
		else
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['galleries'];
			$sql.= " SET ";
        }
		
		$sql.= " Title='".addslashes($this->_Title)."',";
		$sql.= " Descr='".addslashes($this->_Description)."',";
		$sql.= " IsVisible=".($this->_IsVisible?1:0).",";

		if($this->_ID !== null)
		{
			$sql.= "WHERE GalleryID=".$this->_ID;
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
		if($this->_ID !== null)
		{
			$sql = "DELETE FROM ".$this->_Mgr->Tables['galleries']." WHERE GalleryID=".$this->_ID;
			$this->_Mgr->DB->query($sql);
		}
	}

	/**
	 * 
	 * @param album
	 */
	public function UpdateAlbum($album)
	{
		if(is_a($album, ''))
			$album->Update();
	}

	/**
	 * 
	 * @param albumid
	 */
	public function RemoveAlbum($albumid)
	{
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
		}
	}

	/**
	 * 
	 * @param id
	 */
	public function GetAlbum($id)
	{
		return new GalleryAlbum($this->_UniqueID, $id, $this, $this->_Mgr);
	}
	
	public function CreateAlbum()
	{
		return new GalleryAlbum($this->_UniqueID, null, $this, $this->_Mgr);
    }

	/**
	 * Galleries
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
			case 'id':
				return $this->_ID;
			case 'uniqueid':
				return $this->_UniqueID;
			case 'albums':
				if($this->_ID === null)
					return null;
				if($this->_Albums === null)
				{
					$rights = null;
					if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
					{
						$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->_UniqueID));
					}
					$filter = array('galleryid' => $this->_ID, 'rights' => $rights);
					$this->_Albums = new GalleryAlbumIterator($filter, $this, $this->_Mgr);
                }
				return $this->_Albums;
			case 'photoscount':
				if($this->_ID === null)
					return null;
				
				if($this->_PhotosCount === null)
				{
					$sql .= "SELECT COUNT(*) FROM ".$this->_Mgr->Tables['photos'].' as p';
					$sql .= " INNER JOIN ".$this->_Mgr->Tables['albums'].' as a ON(a.AlbumID = p.AlbumID) ';
					$sql.= " WHERE a.UniqueID=".$this->_UniqueID." AND a.GalleryID=".$this->_ID;

					$res = $this->_Mgr->DB->query($sql);
					if ( !$res || !$res->num_rows )
						$this->_PhotosCount = 0;
					else
						list($this->_PhotosCount) = $res->fetch_row();
                }
				return $this->_PhotosCount;
			case 'title':
				return $this->_Title;
			case 'description':
				return $this->_Description;
			case 'isvisible':
				return $this->_IsVisible;
		}
	}

	/**
	 * 
	 * @param name
	 */
	public function __isset($name)
	{
		if( $name == 'mgr' ||
			$name == 'id' ||
			$name == 'uniqueid' ||
			$name == 'title' ||
			$name == 'description' ||
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
			case 'title':
				$this->_Title = $value;
				break;
			case 'description':
				$this->_Description = $value;
				break;
			case 'isvisible':
				$this->_IsVisible = $value;
				break;
		}
	}

}
?>