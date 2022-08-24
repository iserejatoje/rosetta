<?php
/**
 * @author Чурюмов Иван
 * @version 1.0
 * @created 16:08 22.09.2009
 */
class UserGalleryPhotoIterator extends GalleryPhotoIterator
{
	private $galleries = array();
	
	public function __construct($filter = null, $mgr = null)
	{
		global $OBJECTS;
		if($filter === null || $mgr === null)
			throw new exception("Can't create UserGalleryPhotoIterator object directly");

		$this->_Mgr = $mgr;
		$this->_Parent = null;

		$sql = "SELECT photos.*, users.RegionID, galleries.GalleryID, galleries.UniqueID FROM ".$this->_Mgr->Tables['photos']." photos";
		$sql.= ", ".$this->_Mgr->Tables['albums']." albums";
		$sql.= ", ".$this->_Mgr->Tables['galleries']." galleries";
		$sql.= ", ".$this->_Mgr->Tables['users']." users";
		$sql.= " WHERE photos.UserID=users.UserID ";
		$sql.= " AND photos.AlbumID=albums.AlbumID ";
		$sql.= " AND albums.GalleryID=galleries.GalleryID ";
		$sql.= " AND albums.IsDel=0 ";
		$sql.= " AND albums.IsVisible=1 ";
		if(isset($filter['albumid']))
			$sql.= " AND AlbumID=".$filter['albumid'];
			
		if(isset($filter['regionid']))
			$sql.= " AND users.RegionID=".$filter['regionid'];
			
		if(isset($filter['isnew']) && ($filter['isnew'] == 0 || $filter['isnew'] == 1))
			$sql.= " AND IsNew=".$filter['isnew'];
			
		if(isset($filter['rights']) && is_array($filter['rights']) && count($filter['rights']) > 0)
		{
			$sql.= " AND (IsVisible IN(".implode(',', $filter['rights']).")";
			$sql.= " OR photos.UserID=".$OBJECTS['user']->ID.")";
		}

		if (isset($filter['order']) && $filter['order'] == 'desc')
			$sql.= " ORDER by `Order` ASC, Created DESC ";
		else
			$sql.= " ORDER by `Order` ASC, Created ASC ";
		
		if(isset($filter['limit']))
		{
			$sql.= " LIMIT ";
			if(isset($filter['offset']))
				$sql.= $filter['offset'].",";
			$sql.= $filter['limit'];
        }

		$res = $this->_Mgr->DB->query($sql);
		while($row = $res->fetch_assoc())
		{
			$this->data[] = $row;			
        }
	}
	
	// Iterator
	public function current()
	{
		if($this->data === null)
			return null;
			
        $k = key($this->data);
        if(!isset($this->objects[$k]))
        {
			//получаем галерею
			if(!isset($this->galleries[$this->data[$k]['GalleryID']])){
				$this->galleries[$this->data[$k]['GalleryID']] = $this->_Mgr->GetGallery($this->data[$k]['UniqueID'], $this->data[$k]['GalleryID']);
			}
			//альбом
			$album = $this->galleries[$this->data[$k]['GalleryID']]->GetAlbum($this->data[$k]['AlbumID']);
			//фото
			$this->objects[$k] = GalleryPhoto::CreateFromArray($this->data[$k], $album, $this->_Mgr);
        }
        return $this->objects[$k];
	}
	
	/**
	 * 
	 * @param data
	 */
	private function _createFromArray($data, $parent, $mgr)
	{
		$album = new GalleryAlbum($data['UserID'], $data['AlbumID'], null, $mgr);		
		return GalleryPhoto::CreateFromArray($data, $album, $mgr);
	}
}

?>