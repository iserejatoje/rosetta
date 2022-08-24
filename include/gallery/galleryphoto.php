<?php


/**
 * фотография привязана всегда к альбому и никак иначе
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:35
 */
class GalleryPhoto
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
	public function __construct($id = null, $parent = null, $mgr = null)
	{
		global $OBJECTS;
		if(!is_numeric($id)) $id = null;
		if(!is_a($parent, 'GalleryAlbum')) $parent = null;
		if(!is_a($mgr, 'GalleryMgr')) $mgr = null;
		
		if($parent === null || $mgr === null)
			throw new exception("Can't create GalleryPhoto object directly.");

		$this->_ID		= $id;
		$this->_Parent	= $parent;
		$this->_Mgr		= $mgr;
		
		if($id !== null)
		{
			$sql = "SELECT * FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE PhotoID=".$id;
			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_assoc();
			
			if(!$row)
				throw new exception("Can't find photo");
				
			if(isset($this->_Mgr->Config['rights']) && $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']] != null)
			{
				$rights = $OBJECTS['user']->Plugins->Rights[$this->_Mgr->Config['rights']]->GetRights(array('id' => $this->Parent->UniqueID));
				if(!in_array($row['IsVisible'], $rights) && $row['UserID'] != $OBJECTS['user']->ID)
					throw new exception("Can't find photo");
			}
				
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
		$sql = "SELECT UserID FROM ".$this->_Mgr->Tables['albums'];
		$sql.= " WHERE AlbumID = ".$AlbumID;
		
		$res = $this->_Mgr->DB->query($sql);
		if ($res->num_rows == 0)
		{
			return -1;
		}
		$row = $res->fetch_assoc();
		if ($row['UserID'] != $this->_User)
		{
			return -2;
		}
		
		$sql = "UPDATE ".$this->_Mgr->Tables['photos'];
		$sql.= " SET AlbumID = ".$AlbumID;
		$sql.= " WHERE PhotoID = ".$this->_ID;
		
		$this->_Mgr->DB->query($sql);
		
		if ($this->_Parent->Thumb == $this->Thumb)
		{
			$old_album = $this->_Parent->ID;
			
			$sql = "SELECT COUNT(*) FROM ".$this->_Mgr->Tables['photos'];
			$sql.= " WHERE AlbumID = ".$old_album;
			$sql.= " AND Thumb != '".$this->Thumb."'";

			$res = $this->_Mgr->DB->query($sql);
			$row = $res->fetch_row();
			
			if ($row[0] > 0)
			{
				$sql = "SELECT Thumb, ThumbWidth, ThumbHeight, ThumbSize FROM ".$this->_Mgr->Tables['photos'];
				$sql.= " WHERE AlbumID = ".$old_album;
				$sql.= " AND Thumb != '".$this->Thumb."'";
				$sql.= " LIMIT 1";
				
				$res = $this->_Mgr->DB->query($sql);
				$row = $res->fetch_row();
				
				$sql = "UPDATE ".$this->_Mgr->Tables['albums'];
				$sql.= " SET Thumb = '".$row[0]."', ThumbWidth = '".$row[1]."', ThumbHeight = '".$row[2]."', ThumbSize = '".$row[3]."' ";
				$sql.= " WHERE AlbumID = ".$old_album;
				
				$this->_Mgr->DB->query($sql);
			}
			else
			{
				$sql = "UPDATE ".$this->_Mgr->Tables['albums'];
				$sql.= " SET Thumb = '', ThumbWidth = '', ThumbHeight = '', ThumbSize = '' ";
				$sql.= " WHERE AlbumID = ".$old_album;
				
				$this->_Mgr->DB->query($sql);
			}
		}
		
		$this->_Parent->ID = $AlbumID;
		
		
		
		return true;
	}
	
	
	public function Update($setmain = false, $isconverted = false)
	{
		$res = $this->_Parent->UpdatePhoto($this, $setmain, $isconverted);

		if ($this->_ID === null)
			if($res)
				$this->_ID = $res;
		return $res;
	}

	public function Remove()
	{
		if($this->ID !== null)
			$this->_Parent->RemovePhoto($this->ID);
	}
	
	// для конвертации галерей
	public function UploadPhotoWithPrefix($file, $prefix, $index = null, $security = null) {
		$this->UploadPhoto($file, $index, $security, $prefix);
	}
	
	public function UploadPhoto($file, $index = null, $security = null, $prefix = null)
	{
		global $OBJECTS;
		if ($index !== null && !is_file($_FILES[$file]['tmp_name'][$index]))
			return false;
		else if ($index === null && !is_file($_FILES[$file]['tmp_name']))
			return false;

		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		if ( $security !== null ) {
			$result = FileStore::Upload_NEW(
				$file, $this->_Mgr->Config['photo']['path'], $prefix.rand(1000000, 9999999),
				FileMagic::MT_WIMAGE, $this->_Mgr->Config['photo']['file_size'],
				array(
					'resize' => array(
						'tr' => 0,
						'w'  => $this->_Mgr->Config['photo']['img_size']['max_height'],
						'h'  => $this->_Mgr->Config['photo']['img_size']['max_width'],
					),
					'security' => $security,
				),
				$index
			);
		} else {
			$result = FileStore::Upload_NEW(
				$file, $this->_Mgr->Config['photo']['path'], $prefix.rand(1000000, 9999999),
				FileMagic::MT_WIMAGE, $this->_Mgr->Config['photo']['file_size'],
				array(
					'resize' => array(
						'tr' => 0,
						'w'  => $this->_Mgr->Config['photo']['img_size']['max_height'],
						'h'  => $this->_Mgr->Config['photo']['img_size']['max_width'],
					),
				),
				$index
			);
		}
		
		LibFactory::GetStatic('images');
		$pname = FileStore::GetPath_NEW($result);
		$preparedPhoto = Images::PrepareImageToObject($pname, $this->_Mgr->Config['photo']['path']);
		$result = FileStore::ObjectToString($preparedPhoto);
		
		if (empty($preparedPhoto))
			return false;

		try {
			if ( $this->PhotoPath )
				filestore::Delete_NEW($this->PhotoPath);
		} catch(MyException $e) {}
		
		
		
		$this->_Photo = array();
		$this->_Photo['file'] = $result;
		$this->_Photo['width'] = $preparedPhoto['w'];
		$this->_Photo['height'] = $preparedPhoto['h'];
		$this->_Photo['size'] = $preparedPhoto['size'];
		$this->_Photo['url'] = $this->_Mgr->Config['photo']['url'].$pname;
		$this->_Photo['path'] = $this->_Mgr->Config['photo']['path'].$pname;

		return true ;
    }
	
	// для конвертации галерей
	public function UploadThumbWithPrefix($file, $prefix, $index = null) {
		$this->UploadThumb($file, $index, $prefix);
	}
	
	public function UploadThumb($file, $index = null, $prefix = null)
	{
		global $OBJECTS;
		if ($index !== null && !is_file($_FILES[$file]['tmp_name'][$index]))
			return false;
		else if ($index === null && !is_file($_FILES[$file]['tmp_name']))
			return false;

		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		$result = FileStore::Upload_NEW(
			$file, $this->_Mgr->Config['thumb']['path'], $prefix.rand(1000000, 9999999),
			FileMagic::MT_WIMAGE, $this->_Mgr->Config['thumb']['file_size'],
			array(
				'resize' => array(
					'tr' => 3,
					'w'  => $this->_Mgr->Config['thumb']['img_size']['max_height'],
					'h'  => $this->_Mgr->Config['thumb']['img_size']['max_width'],
				),
			),
			$index
		);

		LibFactory::GetStatic('images');
		
		$pname = FileStore::GetPath_NEW($result);
		$preparedThumb = Images::PrepareImageToObject($pname, $this->_Mgr->Config['thumb']['path']);
		$result = FileStore::ObjectToString($preparedThumb);
		
		if (empty($preparedThumb))
			return false;

		try {
			if ( $this->ThumbPath )
				filestore::Delete_NEW($this->ThumbPath);
		} catch(MyException $e) {}
		
		$this->_Thumb = array();
		$this->_Thumb['file'] = $result;
		$this->_Thumb['width'] = $preparedThumb['w'];
		$this->_Thumb['height'] = $preparedThumb['h'];
		$this->_Thumb['size'] = $preparedThumb['size'];
		$this->_Thumb['url'] = $this->_Mgr->Config['thumb']['url'].$pname;
		$this->_Thumb['path'] = $this->_Mgr->Config['thumb']['path'].$pname;

		return true ;
    }
	
	/**
	 * Физически копирует текущую фотографию
	 *
	 * @param prefix string - префикс для имени файла
	 * @return array - массив фотки (file, width, height, size, url, path), либо false - в случае ошибки
	 */
	public function CopyPhoto($prefix = null)
	{
		if (empty($this->_Photo) || $this->_Photo['file'] == '')
			return false;

		LibFactory::GetStatic('filestore');
		try
		{
                        $photo_obj = FileStore::ObjectFromString($this->_Photo['file']);
			$file = $this->_Mgr->Config['photo']['path'].FileStore::GetPath_NEW($photo_obj['file']);
			$name = FileStore::CreateName_NEW($prefix.rand(1000000, 9999999), $file);
			$pname = FileStore::GetPath_NEW($name);
			FileStore::Copy($file, $this->_Mgr->Config['photo']['path'].$pname);
			
			LibFactory::GetStatic('images');
			$preparedPhoto = Images::PrepareImageToObject($pname, $this->_Mgr->Config['photo']['path']);
			$name = FileStore::ObjectToString($preparedPhoto);
		}
		catch(Exception $e)
		{
			$del_file = $this->_Mgr->Config['photo']['path'].$pname;
			if (FileStore::IsFile($del_file))
				FileStore::Delete($del_file);
			return false;
		}
		
		if (empty($preparedPhoto))
				return false;
		
		
			LibFactory::GetStatic('images');
			
		
		
		return array(
			'file' 		=> $name,
			'width' 	=> $preparedPhoto['w'],
			'height' 	=> $preparedPhoto['h'],
			'size' 		=> $preparedPhoto['size'],
			'url' 		=> $this->_Mgr->Config['photo']['url'].$pname,
			'path' 		=> $this->_Mgr->Config['photo']['path'].$pname,
		);
	}
	
	/**
	 * Физически копирует текущий thumb
	 *
	 * @param prefix string - префикс для имени файла
	 * @return array - массив фотки (file, width, height, size, url, path), либо false - в случае ошибки
	 */
	public function CopyThumb($prefix = null)
	{
		if (empty($this->_Thumb) || $this->_Thumb['file'] == '')
			return false;

		LibFactory::GetStatic('filestore');
		try
		{
                        $thumb_obj = FileStore::ObjectFromString($this->_Thumb['file']);
			$file = $this->_Mgr->Config['thumb']['path'].FileStore::GetPath_NEW($thumb_obj['file']);
			$name = FileStore::CreateName_NEW($prefix.rand(1000000, 9999999), $file);
			$pname = FileStore::GetPath_NEW($name);
			FileStore::Copy($file, $this->_Mgr->Config['thumb']['path'].$pname);
			
			LibFactory::GetStatic('images');
			$preparedThumb = Images::PrepareImageToObject($pname, $this->_Mgr->Config['thumb']['path']);
			$name = FileStore::ObjectToString($preparedThumb);
			
		}
		catch(Exception $e)
		{
			$del_file = $this->_Mgr->Config['thumb']['path'].$pname;
			if (FileStore::IsFile($del_file))
				FileStore::Delete($del_file);
			return false;
		}
		
		if (empty($preparedThumb))
				return false;
		
		
		LibFactory::GetStatic('images');
		
		
		
		return array(
			'file' 		=> $name,
			'width' 	=> $preparedThumb['w'],
			'height' 	=> $preparedThumb['h'],
			'size' 		=> $preparedThumb['size'],
			'url' 		=> $this->_Mgr->Config['thumb']['url'].$pname,
			'path' 		=> $this->_Mgr->Config['thumb']['path'].$pname,
		);
	}
	
	public function CropPhoto($params)
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		if ($this->_ID === null || !$this->PhotoPath)
			return false;

		$new_file = FileStore::CreateName_NEW($this->_ID.'_'.rand(100, 999), $this->PhotoPath, FileMagic::MT_WIMAGE);
		$dest_file = $this->_Mgr->Config['thumb']['path'].FileStore::GetPath_NEW($new_file);

		$params = array(
			'crop' => array(
				'w' => $params['width'],
				'h' => $params['height'],
				'x' => $params['left'],
				'y' => $params['top'],
			),
			'resize' => array(
				'tr' => 0,
				'w'  => $this->_Mgr->Config['thumb']['img_size']['max_height'],
				'h'  => $this->_Mgr->Config['thumb']['img_size']['max_width'],
			),
		);

		FileStore::Save_NEW($this->PhotoPath, $dest_file, null, $params);

		LibFactory::GetStatic('images');
		$pname = FileStore::GetPath_NEW($new_file);
		$preparedPhoto = Images::PrepareImageToObject($pname, $this->_Mgr->Config['thumb']['path']);
		$name = FileStore::ObjectToString($preparedPhoto);
		
		if (empty($preparedPhoto))
			return false;

		try {
			if ( $this->ThumbPath )
				filestore::Delete_NEW($this->ThumbPath);
		} catch(MyException $e) {}

		$this->_Thumb = array();
		$this->_Thumb['file'] = $name;
		$this->_Thumb['width'] = $preparedPhoto['w'];
		$this->_Thumb['height'] = $preparedPhoto['h'];
		$this->_Thumb['size'] = $preparedPhoto['size'];
		$this->_Thumb['url'] = $this->_Mgr->Config['thumb']['url'].$pname;
		$this->_Thumb['path'] = $this->_Mgr->Config['thumb']['path'].$pname;

		return true;
    }

	/**
	 * 
	 * @param data
	 */
	public static function CreateFromArray($data, $parent, $mgr)
	{
		$obj = new self(null, $parent, $mgr);
		
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
	
	/** Голосовать за фото
	 * Каждый пользователь может только 1 раз голосовать за одно фото
	 * При добавлении пересчитывает: Сумму голосов, Средний бал, Количество проголосовавших
	 * @param putUserId - тот, кто поставил голос
	 * @param rating - рейтинг (от 1 до 5)	 
	 * return bool
	 */
	public function Vote($putUserId, $rating, $comment)
	{
		if (empty($this->_User) || empty($putUserId) || empty($this->_ID))
			return false;
			
		if (empty($this->_Mgr->Tables['rating']))
			return false;
		
		if (!in_array($rating, array(1,2,3,4,5)))
			return false;
		
		$sql = "INSERT IGNORE INTO ".$this->_Mgr->Tables['rating']." SET ";
		$sql.= " PhotoID = ".intval($this->_ID);
		$sql.= ", AlbumID = ".intval($this->_Parent);
		$sql.= ", UserID = ".intval($this->_User);
		$sql.= ", PutUserID = ".intval($putUserId);
		$sql.= ", Rating = ".intval($rating);
		$sql.= ", Date = NOW()";		
		$sql.= ", Comment = '".addslashes($comment)."'";		
		
		$this->_Mgr->DB->query($sql);

		$sql = "SELECT sum(Rating), avg(Rating), count(PutUserID) FROM ".$this->_Mgr->Tables['rating'];
		$sql.= " WHERE PhotoID = ".$this->_ID;
		$res = $this->_Mgr->DB->query($sql);
		list($sum, $avg, $count) = $res->fetch_row();
		
		if (!empty($sum) && !empty($avg) && empty($count))
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['photos']." SET ";
			$sql = " CountVote = ".(int) $count;
			$sql = " SumVote = ".(int) $sum;
			$sql = " AvgVote = ".floatval($avg);
			$sql = " WHERE PhotoID = ".$this->_ID;
			$this->_Mgr->DB->query($sql);
		}
		return true;		
	}
		
	/** Получить голоса
	 * Получить все голоса для пользователя, который создавал фотку
	 * @return array
	 */
	public function GetVotes()
	{
		if (empty($this->_User)			
			|| empty($this->_ID)
			|| empty($this->_Mgr->Tables['rating'])
		)
		{
			return array();
		}
		
		$votes = array();
		
		$sql = "SELECT * FROM ".$this->_Mgr->Tables['rating']." WHERE ";
		$sql.= " PhotoID=".$this->_ID;
		$sql.= " AND UserID = ".$this->_User;
		$res = $this->_Mgr->DB->query($sql);
		while($row = $res->fetch_assoc())
		{
			$votes[] = $row;
		}
		
		return $votes;
	}
	
	/**
	 * Возвращает все оценки для объекта. В массиве по PhotoID
	 */
	public static function GetVotesByUniqueID($filter, $mgr)
	{
		if (empty($mgr->Tables['rating']))		
			return array();
		
		if (!isset($filter['UniqueID']) || !is_numeric($filter['UniqueID']))
			return array();
		
		$votes = array();
		
		if ($filter['calc'] === true)
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".$mgr->Tables['rating']." WHERE ";
		else
			$sql = "SELECT * FROM ".$mgr->Tables['rating']." WHERE ";
			
		$sql.= " UserID = ".$filter['UniqueID'];			
		$sql.= " ORDER BY Date ASC";
		if ( $filter['limit'] ) 
		{
			$sql .= " LIMIT ";
			if ( $filter['offset'] )
				$sql .= $filter['offset'].", ";
			$sql .= $filter['limit'];
		}
		
		$res = $mgr->DB->query($sql);
		while($row = $res->fetch_assoc())
		{
			$votes[$row['PhotoID']][] = $row;
		}
		
		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $mgr->DB->query($sql)->fetch_row();		
			return array($votes, $count);
		}
		
		return $votes;
	}
	
	/**
	 * Получить голос опреденного пользователя для текущей фотографии
	 * @return array
	 */
	public function GetVoteByUser($userId)
	{
		if (empty($this->_User)			
			|| empty($this->_ID)
			|| empty($userId)
			|| empty($this->_Mgr->Tables['rating'])
		)
		{
			return array();
		}
		
		$sql = "SELECT * FROM ".$this->_Mgr->Tables['rating']." WHERE ";
		$sql.= " PhotoID=".$this->_ID;
		$sql.= " AND UserID = ".$this->_User->ID;
		$sql.= " AND PutUserID = ".$userId;
		
		$res = $this->_Mgr->DB->query($sql);
		if (($row = $res->fetch_assoc()) !== false)
		{
			return $row;
		}
		
		return array();
	}
	
	/** Удалить голос определенного пользователя
	 * Удалить голос определенного пользователя, при этом пересчитывает: Сумму голосов, Средний бал, Количество проголосовавших
	 * $param userId - id-шник пользователя, чей голос удаляется (может быть массивом)
	 */
	public function RemoveVote($userId)	
	{
		if (empty($this->_User) 
			|| empty($userId) 
			|| empty($this->_ID)
			|| empty($this->_Mgr->Tables['rating'])
		)
		{
			return false;
		}
		
		$sql = "DELETE FROM ".$this->_Mgr->Tables['rating']." WHERE ";
		$sql.= " PhotoID = ".$this->_ID;
		$sql.= " UserID = ".$this->_User;
		if (is_array($userId) && count($userId) > 0)
			$sql.= " PutUserID IN (".implode(',', $userId).")";
		else
			$sql.= " PutUserID = ".$userId;
		$this->_Mgr->DB->query($sql);
		
		$sql = "SELECT sum(Rating), avg(Rating), count(PutUserID) FROM ".$this->_Mgr->Tables['rating'];
		$sql.= " WHERE PhotoID = ".$this->_ID;
		$res = $this->_Mgr->DB->query($sql);
		list($sum, $avg, $count) = $res->fetch_row();
		
		if (!empty($sum) && !empty($avg) && empty($count))
		{
			$sql = "UPDATE ".$this->_Mgr->Tables['photos']." SET ";
			$sql = " CountVote = ".(int) $count;
			$sql = " SumVote = ".(int) $sum;
			$sql = " AvgVote = ".floatval($avg);
			$sql = " WHERE PhotoID = ".$this->_ID;
			$this->_Mgr->DB->query($sql);
		}
		
		return true;
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
				return $this->_Parent;
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
				if (!is_array($this->_Thumb) || trim($this->_Thumb['file']) == '')
					return null;

				if (!isset($this->_Thumb['path']) || !isset($this->_Thumb['url'])) {
					
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
				if (!is_array($this->_Photo) || trim($this->_Photo['file']) == '')
					return null;

				if (!isset($this->_Photo['path']) || !isset($this->_Photo['url'])) {
				
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
				//else
					//error_log("Can't set user");
				break;
			case 'title':
				$this->_Title = $value;
				break;
			case 'description':
				$this->_Description = $value;
				break;
			case 'thumb':
				$this->_Thumb = array(
					'file' => $value
				);
				break;
			case 'photo':
				$this->_Photo = array(
					'file' => $value
				);
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