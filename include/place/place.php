<?php

require_once ($CONFIG['engine_path'].'include/place/contactinfo.php');
require_once ($CONFIG['engine_path'].'include/place/placeextralocationmgr.php');


class Place
{
	private $_mgr;

	public $ID;
	public $UserID;
	public $Created;
	public $LastUpdated;
	public $ActualDate;
	public $Name;
	public $ShortName;
	public $LegalType;
	public $Ord;

	public $AddressTemp;
	public $Location;
	public $House;
	public $PostfixExtra;

	public $ContactName;
	public $ContactPhone;
	public $ContactFax;
	public $ContactEmail;
	public $ContactUrl;

	private $LogotypeSmall;
	private $LogotypeBig;
	private $LocationMap;
	private $PriceFile;

	public $RecipientEmail;
	public $Director;
	public $Info;
	public $AnnounceText;

	public $IsAnnounce;
	public $IsVerified;
	public $IsVisible;
	public $IsComments;
	protected $IsCommerce; // устарело
	protected $CommerceType;
	public $IsRating;
	public $IsEdited;

	public $LandmarkID;
	public $RegionID;
	public $MoreInfo;
	public $AccuracyID;
	
	public $AccuracySections;
	public $IsSelfEdited;
		
	public $LastCommentDate;
	public $LastCommentID;
	
	public $Source;

	private $_MapX = 0;
	private $_MapY = 0;

	private $_SpanX = 0;
	private $_SpanY = 0;
	private $_OnMap = 0;
	
	

	private $_images_dir = '/common_fs/i/firms/';
	private $_images_url = '/resources/fs/i/firms/';

	private $_files_dir = '/common_fs/f/firms/';
	private $_files_url = '/resources/fs/f/firms/';

	private $_photo_big_size = array('max_width' => 180, 'max_height' => 85);
	private $_photo_small_size = array('max_width' => 110, 'max_height' => 90);
	private $_photo_map_size = array('max_width' => 400, 'max_height' => 400);

	private $_photo_file_size = 716800; //700K
	private $_file_size = 2097152; // 2M

	function __construct(array $info)
	{
		global $OBJECTS;
		
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['placeid']) && Data::Is_Number($info['placeid']) )
			$this->ID = $info['placeid'];

		$this->UserID = 0;
		if ( Data::Is_Number($info['userid']) )
			$this->UserID = $info['userid'];

		$this->Created		= $info['created'];
		$this->LastUpdated	= $info['lastupdated'];
		$this->ActualDate	= $info['actualdate'];
		$this->Name			= $info['name'];
		$this->ShortName	= $info['shortname'];
		$this->LegalType	= $info['legaltype'];
		$this->RegionID		= $info['regionid'];

		$this->AddressTemp	= $info['addresstemp'];
		$this->Location		= $info['location'];
		$this->House		= str_replace("-", " ", $info['house']);
		$this->PostfixExtra	= $info['postfixextra'];

		$this->ContactName	= $info['contactname'];
		$this->ContactPhone	= $info['contactphone'];
		$this->ContactFax	= $info['contactfax'];
		$this->ContactEmail	= $info['contactemail'];
		$this->ContactUrl	= $info['contacturl'];

		$this->LogotypeSmall = $info['logotypesmall'];
		$this->LogotypeBig	= $info['logotypebig'];
		$this->LocationMap	= $info['locationmap'];
		$this->PriceFile	= $info['pricefile'];
		
		$this->LastCommentDate	= $info['lastcommentdate'];
		$this->LastCommentID	= $info['lastcommentid'];

		$this->Ord = 0;
		if ( isset($info['ord']) )
			$this->Ord = (int) $info['ord'];

		$this->RecipientEmail = $info['recipientemail'];
		$this->Director		= $info['director'];
		$this->Info			= $info['info'];
		$this->AnnounceText	= $info['announcetext'];
		$this->IsAnnounce	= $info['isannounce'] ? true : false;
		$this->IsVerified	= $info['isverified'] ? true : false;
		$this->IsVisible	= $info['isvisible']  ? true : false;
		$this->IsComments	= $info['iscomments'] ? true : false;
		$this->IsCommerce	= $info['iscommerce'] ? true : false;
		
		$this->CommerceType	= intval($info['commercetype']);

		$this->IsRating		= $info['israting'] ? true : false;
		$this->IsEdited		= $info['isedited'] ? true : false;

		$this->AccuracyID	= isset($info['accuracyid']) ? $info['accuracyid'] : null;
		$this->AccuracySections = isset($info['sections']) ? $info['sections'] : null;
		$this->IsSelfEdited = isset($info['isselfedited']) ? $info['isselfedited'] : null;		
		
		$this->LandmarkID	= 0;
		if (isset($info['landmarkid']) && Data::Is_Number($info['landmarkid']))
			$this->LandmarkID		= $info['landmarkid'];
			
		if ( isset($info['moreinfo']) )
		{
			if (strlen($info['moreinfo']) > 3000) //Режем сильно большое сообщение
				$info['moreinfo'] = substr($info['moreinfo'], 0, 3000);
			$this->MoreInfo = $info['moreinfo'];
		}

		$this->_OnMap = 0;
		if ($info['onmap'] == 1) {		
			$this->_MapX	= Data::NormalizeFloat($info['mapx']);
			$this->_MapY	= Data::NormalizeFloat($info['mapy']);

			$this->_SpanX	= Data::NormalizeFloat($info['spanx']);
			$this->_SpanY	= Data::NormalizeFloat($info['spany']);
			$this->_OnMap	= 1;
		}
		
		$this->Source	= $info['source'];
	}

	/**
	 * сохранить информацию о неточности в базе
	 * использует метод плагина и метод PlaceMgr
	 * @param $self_edited -  изменения добавлены владельцем
	 */
	public function AddInaccuracy($self_edited = false)
	{
		if ( $this->ID === null )
			return false;
	
		$info = array(
			'UserID'		=> $this->UserID,

			'Name'			=> $this->Name,
			'ShortName'		=> $this->ShortName,
			'ActualDate'	=> $this->ActualDate,
			'LegalType'		=> $this->LegalType,

			'AddressTemp'	=> $this->AddressTemp,
			'Location'		=> $this->Location,
			'House'			=> $this->House,
			'PostfixExtra'	=> $this->PostfixExtra,

			'ContactEmail'	=> $this->ContactEmail,
			'ContactName'	=> $this->ContactName,
			'ContactPhone'	=> $this->ContactPhone,
			'ContactFax'	=> $this->ContactFax,
			'ContactUrl'	=> $this->ContactUrl,

			'Director'		=> $this->Director,
			'RecipientEmail'=> $this->RecipientEmail,
			'Info'			=> $this->Info,
			'AnnonuceText'	=> $this->AnnounceText,

			'LogotypeSmall' => $this->LogotypeSmall,
			'LogotypeBig'	=> $this->LogotypeBig,
			'PriceFile'		=> $this->PriceFile,

			'IsAnnounce'	=> (int) $this->IsAnnounce,
			'IsVerified'	=> (int) $this->IsVerified,
			'IsVisible'		=> (int) $this->IsVisible,
			'IsComments'	=> (int) $this->IsComments,
			'IsCommerce'	=> (int) $this->IsCommerce, // устарело
			'IsRating'		=> (int) $this->IsRating,
			'Ord'			=> (int) $this->Ord,

			'LandmarkID'	=> (int) $this->LandmarkID,
			'MoreInfo'		=> $this->MoreInfo,
			'RegionID'		=> $this->RegionID,
		);
		
		if ( $self_edited ){
			$info['IsSelfEdited'] = '1';
			PlaceMgr::getInstance()->RemoveSelfEditedAccuracy($this->ID);
			PlaceMgr::getInstance()->SetIsEdited($this->ID);
		}
		
		if(is_array($this->AccuracySections))
			$info['Sections'] = implode(",", $this->AccuracySections);


		$info['PlaceID'] = $this->ID;
		if ( false !== PlaceMgr::getInstance()->AddInaccuracy($info))
			return true;
		
		return false;
	}


	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод PlaceMgr
	 */
	public function Update()
	{
		$info = array(
			'UserID'	=> $this->UserID,

			'Name'			=> $this->Name,
			'ShortName'		=> $this->ShortName,
			'ActualDate'	=> $this->ActualDate,
			'LegalType'		=> $this->LegalType,

			'AddressTemp'	=> $this->AddressTemp,
			'Location'		=> $this->Location,
			'House'			=> $this->House,
			//'PostfixExtra'	=> $this->PostfixExtra,

			'ContactEmail'	=> $this->ContactEmail,
			'ContactName'	=> $this->ContactName,
			'ContactPhone'	=> $this->ContactPhone,
			'ContactFax'	=> $this->ContactFax,
			'ContactUrl'	=> $this->ContactUrl,

			'Director'		=> $this->Director,
			'RecipientEmail'=> $this->RecipientEmail,
			'Info'			=> $this->Info,
			'AnnounceText'	=> $this->AnnounceText,

			'LogotypeSmall' => $this->LogotypeSmall,
			'LogotypeBig'	=> $this->LogotypeBig,
			'LocationMap'	=> $this->LocationMap,
			'PriceFile'		=> $this->PriceFile,
			
			'LastCommentDate'	=> $this->LastCommentDate,
			'LastCommentID'	=> $this->LastCommentID,

			'IsAnnounce'	=> (int) $this->IsAnnounce,
			'IsVerified'	=> (int) $this->IsVerified,
			'IsVisible'		=> (int) $this->IsVisible,
			'IsComments'	=> (int) $this->IsComments,
			'IsCommerce'	=> (int) $this->IsCommerce, // устарело
			'IsRating'		=> (int) $this->IsRating,
			'IsEdited'		=> (int) $this->IsEdited,
			'Ord'			=> (int) $this->Ord,

			'LandmarkID'	=> (int) $this->LandmarkID,

			'MapX'			=> $this->_MapX,
			'MapY'			=> $this->_MapY,

			'SpanX'			=> $this->_SpanX,
			'SpanY'			=> $this->_SpanY,
			'OnMap'			=> $this->_OnMap,
			'RegionID'		=> $this->RegionID,
		);

		if ( $this->ID !== null ) {
			$info['PlaceID'] = $this->ID;
			if ( false !== PlaceMgr::getInstance()->Update($info)) {

				$sections = $this->GetSectionRef(true);
				foreach($sections as $sid)
					$this->_updateItemsCount($sid);

				return true;
			}
		} else if ( false !== ($new_id = PlaceMgr::getInstance()->Add($info))) {
			$this->ID = $new_id;

			$sections = $this->GetSectionRef(true);
			foreach($sections as $sid)
				$this->_updateItemsCount($sid);

			return $new_id;
		}

		return false;
	}
	
	/**
	 * сохранить информацию по координатам (дата последнего обновления не затрагивается)
	 */
	public function UpdateCoords()
	{
		if ($this->ID === null)
			return false;

		$lc = localeconv();
		return PlaceMgr::getInstance()->Update(array(
			'PlaceID' => $this->ID,
			'MapX' => str_replace($lc['decimal_point'], '.', (float) $this->_MapX),
			'MapY' => str_replace($lc['decimal_point'], '.', (float) $this->_MapY),
			'SpanX' => str_replace($lc['decimal_point'], '.', (float) $this->_SpanX),
			'SpanY' => str_replace($lc['decimal_point'], '.', (float) $this->_SpanY),
			'OnMap' => $this->_OnMap,
		));
	}
	
	//олучает массив всех дополнительных мест
	public function GetExtraLocations($use_master = false){
		if (!$this->ID)
			return false;
			
		return PlaceExtraLocationMgr::getInstance()->GetExtraLocations( $this->ID , $use_master );
	}
	
	//Устанавливает список дополнительных мест, при этом старые значения удаляются
	public function SetExtraLocations( $e_locations = array() ){
		if (!$this->ID)
			return false;
		//удаляем старые
		if ( PlaceExtraLocationMgr::getInstance()->RemoveAllForPlace( $this->ID ) === false)
			return false;
		//добавляем новые
		foreach ( $e_locations as $eloc ){
			if ( PlaceExtraLocationMgr::getInstance()->Add( $eloc, $this->ID ) === false ){
				//если была ошибка добавления, возвращаем false и удаляем добавленные ранее
				PlaceExtraLocationMgr::getInstance()->RemoveAllForPlace( $this->ID );
				return false;
			}
		}
			
		return true;
	}

	public function GetRefBySection($section) {
		if (!$this->ID)
			return null;

		if ( !Data::Is_Number($section) )
			return null;

		$sql = 'SELECT '.PlaceMgr::getInstance()->_tables['ref'].'.UniqueID FROM '.PlaceMgr::getInstance()->_tables['ref'].'';
		$sql.= ' STRAIGHT_JOIN '.PlaceMgr::getInstance()->_tables['tree'].' ON('.PlaceMgr::getInstance()->_tables['tree'].'.NodeID = '.PlaceMgr::getInstance()->_tables['ref'].'.NodeID) ';
		$sql.= ' WHERE '.PlaceMgr::getInstance()->_tables['ref'].'.NodeID = '.$section.' ';
		$sql.= ' AND '.PlaceMgr::getInstance()->_tables['ref'].'.placeid = '.$this->ID.' ';

		if (false == ($res = PlaceMgr::getInstance()->_db->query($sql)))
			return null;

		$row = $res->fetch_row();
		return $row[0];
	}

	public function GetAllReference() {

		$sql = 'SELECT '.PlaceMgr::getInstance()->_tables['ref'].'.UniqueID FROM '.PlaceMgr::getInstance()->_tables['ref'].'';
		$sql.= ' STRAIGHT_JOIN '.PlaceMgr::getInstance()->_tables['tree'].' ON('.PlaceMgr::getInstance()->_tables['tree'].'.NodeID = '.PlaceMgr::getInstance()->_tables['ref'].'.NodeID) ';
		$sql.= ' WHERE '.PlaceMgr::getInstance()->_tables['ref'].'.placeid = '.$this->ID.' ';

		if (false == ($res = PlaceMgr::getInstance()->_db->query($sql)))
			return array();

		$uniqueid = array();
		$res = PlaceMgr::getInstance()->_db->query($sql);
		while(false != ($row = $res->fetch_row())) {
			$uniqueid[] = $row[0];
		}
		return $uniqueid;
	}

	public function GetSectionRef($full = false, $treeid = null, $list = false) {
		return PlaceMgr::getInstance()->GetPlaceSectionRef($this->ID, $treeid, $full, $list);
	}
	
	public function inReference($id) {

		$sql = 'SELECT '.PlaceMgr::getInstance()->_tables['ref'].'.UniqueID FROM '.PlaceMgr::getInstance()->_tables['ref'].'';
		$sql.= ' STRAIGHT_JOIN '.PlaceMgr::getInstance()->_tables['tree'].' ON('.PlaceMgr::getInstance()->_tables['tree'].'.NodeID = '.PlaceMgr::getInstance()->_tables['ref'].'.NodeID) ';
		$sql.= ' WHERE '.PlaceMgr::getInstance()->_tables['ref'].'.placeid = '.$this->ID.' ';
		$sql.= ' AND '.PlaceMgr::getInstance()->_tables['ref'].'.NodeID = '.$id;

		if (false == ($res = PlaceMgr::getInstance()->_db->query($sql)))
			return false;

		if ($res->num_rows == 1)
			return true;
		
		return false;
	}
		
	public function AddToSection($sections)
	{
		if ( $this->ID === null)
			return false;

		if ( !is_array($sections) )
			$sections = (array) $sections;

		foreach($sections as $type=>$nodes) 
		{
			foreach($nodes as $nodeid)
			{
				if (!$nodeid || !Data::Is_Number($nodeid))
					continue;

				$sql = 'INSERT IGNORE INTO '.PlaceMgr::getInstance()->_tables['ref'].' SET ';
				$sql .= ' NodeID = '.$nodeid;
				$sql .= ' ,PlaceID = '.$this->ID;
				$sql .= ' ,CommerceType = '.$type;
				if ($this->LastCommentID > 0) {
					$sql .= ' ,LastCommentDate = \''.addslashes($this->LastCommentDate).'\'';
					$sql .= ' ,LastCommentID = '.(int) $this->LastCommentID;
				}

				$sql.= ' ON DUPLICATE KEY UPDATE `CommerceType` = IF(`CommerceType` != '.$type.', '.$type.', `CommerceType`)';

				PlaceMgr::getInstance()->_db->query($sql);
				$this->_updateItemsCount($nodeid);
			}
		}

		return true;
	}

	/**
	 * удалить из раздела
	 *
	 * @param sections    разделы
	 */
	public function RemoveFromSection($sections)
	{
		if ( $this->ID === null)
			return false;

		if ( !is_array($sections) )
			$sections = (array) $sections;

		$old_sections = $this->GetSectionRef(true);
		
		foreach($sections as $sid) {

			if (!$sid || !Data::Is_Number($sid))
				continue;

			$sql = 'DELETE FROM '.PlaceMgr::getInstance()->_tables['ref'].' WHERE';
			$sql .= ' NodeID = '.$sid;
			$sql .= ' AND PlaceID = '.$this->ID;

			PlaceMgr::getInstance()->_db->query($sql);
		}

		foreach($old_sections as $sid)
			$this->_updateItemsCount($sid);

		return true;
	}

	public function Remove() {
		if ( $this->ID === null)
			return false;

		$old_sections = $this->GetSectionRef(true);
		PlaceMgr::getInstance()->Remove($this->ID);

		foreach($old_sections as $sid)
			$this->_updateItemsCount($sid);

	}

	private function _updateItemsCount($sid) {
		$count = PlaceMgr::getInstance()->getItemsCount($sid);
		if ($count !== false) {

			$sql = 'UPDATE '.PlaceMgr::getInstance()->_tables['tree'].' SET ItemsCount = '.(int) $count;
			$sql.= ' WHERE NodeID = '.$sid;

			PlaceMgr::getInstance()->_db->query($sql);
		}
	}

	public function UploadLogotypeSmall() {

		$result = $this->_uploadImages(array(
			'small' => 'logotypesmall'
		));

		if ($result === true)
			return $result;

		$this->__set('LogotypeSmall', null);
		return $result;
	}

	public function UploadLogotypeBig() {

		$result = $this->_uploadImages(array(
			'big' => 'logotypebig'
		));

		if ($result === true)
			return $result;

		$this->__set('LogotypeBig', null);
		return $result;
	}

	public function UploadLocationMap() {

		$result = $this->_uploadImages(array(
			'map' => 'locationmap'
		));

		if ($result !== true)
			$this->__set('LocationMap', null);

		return $result;
	}

	private function _uploadImages(array $images) {
		global $OBJECTS;
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		$images = array_change_key_case($images, CASE_LOWER);

		$errors = array();
		foreach($images as $k => $v) {
			if (!in_array((string) $k, array('small', 'big', 'map')) )
				continue ;

			if (empty($_FILES[$v]['name']))
				continue ;

			$pname = FileStore::Upload_NEW(
				$v, $this->_images_dir, $this->ID.'_'.$k,
				FileMagic::MT_WIMAGE, $this->_photo_file_size,
				array(
					'resize' => array(
						'tr' => 3,
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
	
	public function UploadFile(array $files) {
		global $ERROR;

		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		$files = array_change_key_case($files, CASE_LOWER);

		foreach($files as $k => $v)
		{
			if (!in_array((string) $k, array('price')) )
				continue ;

			if (empty($_FILES[$v]['name']))
				continue ;

			$pname = FileStore::Upload_NEW(
				$v, $this->_files_dir, $this->ID.'_'.$k,
				FileMagic::MT_OFFICE, $this->_file_size,
				array()
			);

			$pname = FileStore::GetPath_NEW($pname);
			$file = FileStore::PrepareFileToObject($pname, $this->_files_dir);
			$pname = FileStore::ObjectToString($file);
			
			$this->__set($v, $pname);
		}

		return true;
	}
	
	public function __set($name, $value) {
		
		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

		$name = strtolower($name);
		switch($name) {
			case 'logotypesmall':
				if ($value === null) {
					if ($this->LogotypeSmall) 
						$this->_deleteImage($this->LogotypeSmall);
					
					$this->LogotypeSmall = '';
					return $value;
				}
				
				try 
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->LogotypeSmall = FileStore::ObjectToString($img_obj);
						}
					}
				} 
				catch(MyException $e) { }
				
			break;
			case 'logotypebig':
				if ($value === null) {
					if ($this->LogotypeBig) 
						$this->_deleteImage($this->LogotypeBig);
					
					$this->LogotypeBig = '';
					return $value;
				}
				
				try 
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->LogotypeBig = FileStore::ObjectToString($img_obj);
						}
					}
				} 
				catch(MyException $e) { }
			break;
			case 'locationmap':
				if ($value === null) {
					if ($this->LocationMap) 
						$this->_deleteImage($this->LocationMap);
					
					$this->LocationMap = '';
					return $value;
				}
				
				try 
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);
							return $this->LocationMap = FileStore::ObjectToString($img_obj);
						}
					}
				} 
				catch(MyException $e) { }
				
			break;
			case 'pricefile':
				if ($value === null) {
					if ($this->PriceFile) {
						try 
						{
							if( ($img_obj = FileStore::ObjectFromString($this->PriceFile)) !== false )
							{
								$aname = FileStore::GetPath_NEW($img_obj['file']);
								if (FileStore::IsFile($this->_files_dir.$aname))
									return FileStore::Delete_NEW($this->_files_dir.$aname);
							}
						} 
						catch(MyException $e) { }
					}

					$this->PriceFile = '';
					return $value;
				}

				try 
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$aname = FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($this->_files_dir.$aname)) {
							$this->__set($name, null);
							return $this->PriceFile = FileStore::ObjectToString($img_obj);
						}
					}
				} 
				catch(MyException $e) { }
			break;

			case 'mapx':
				$this->_MapX = Data::NormalizeFloat((float) $value);
			break;
			case 'mapy':
				$this->_MapY = Data::NormalizeFloat((float) $value);
			break;

			case 'spanx':
				$this->_SpanX = Data::NormalizeFloat((float) $value);
			break;
			case 'spany':
				$this->_SpanY = Data::NormalizeFloat((float) $value);
			break;
			
			case 'onmap':
				$this->_OnMap = ($value ? 1 : 0);
			break;
			
			case 'iscommerce':
				$this->IsCommerce = $value;
			break;
		}
		return null;
	}

	public function __get($name) {

		$name = strtolower($name);
		switch($name) {
			case 'logotypesmall':
				if (!$this->LogotypeSmall)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($this->LogotypeSmall);					
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
			case 'logotypebig':
				if (!$this->LogotypeBig)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($this->LogotypeBig);
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
			case 'locationmap':
				if (!$this->LocationMap)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($this->LocationMap);
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
			case 'pricefile':
				if (!$this->PriceFile)
					return null;

				LibFactory::GetStatic('filestore');
				try
				{
					$img_obj = FileStore::ObjectFromString($this->PriceFile);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedFile = FileStore::PrepareFileFromObject($img_obj, 
						$this->_files_dir, $this->_files_url);

					if (empty($preparedFile))
						return null;
				}
				catch ( MyException $e )
				{
					return null;
				}
				
				return $preparedFile['url'];
			break;
			case 'mapx':
				return $this->_MapX;
			break;
			case 'mapy':
				return $this->_MapY;
			break;

			case 'spanx':
				return $this->_SpanX;
			break;
			case 'spany':
				return $this->_SpanY;
			break;
			
			case 'onmap':
				return $this->_OnMap;
			break;
			case 'iscommerce':
				return ($this->CommerceType ? true : false);
			break;
			case 'commercetype':
				return $this->CommerceType;
			break;
			
		}

		return null;
	}

	function __destruct()
	{

	}
}

