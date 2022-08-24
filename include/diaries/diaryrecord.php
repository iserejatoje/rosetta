<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/diaries/diarymgr.php');
require_once ($CONFIG['engine_path'].'include/diaries/diarytagmgr.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 17:23 16 ноября 2009 г.
 */
class DiaryRecord
{
	public $ID					= null;
	public $DiaryID				= null;
	public $RegionID			= null;
	public $UserID				= null;
	public $Created				= null;
	public $Title				= null;
	private $Text				= null;
	private $TextHTML			= null;
	public $PublicState			= null;
	public $IsVisible			= null;
	public $IsAllowComments		= null;
	public $IsConverted			= null;
	public $ComplaintCount  	= null;
	public $OldID				= null;
	public $IsMain 				= null;
	private $Points				= null;
	public $Views				= null;


	function __construct(array $info) {

		LibFactory::GetStatic('bbtags');
		LibFactory::GetStatic('smiles');

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['diaryid']) && Data::Is_Number($info['diaryid']) )
			$this->DiaryID = $info['diaryid'];
		else
			return false;

		if ( isset($info['recordid']) && Data::Is_Number($info['recordid']) )
			$this->ID = $info['recordid'];

		if ( isset($info['regionid']) && Data::Is_Number($info['regionid']) )
			$this->RegionID = $info['regionid'];

		if ( isset($info['userid']) && Data::Is_Number($info['userid']) )
			$this->UserID = $info['userid'];

		if ( isset($info['created']) )
			$this->Created		= strtotime($info['created']);
		else
			$this->Created		= time();


		$this->Title						= $info['title'];
		$this->Text						= $info['text'];
		$this->TextHTML				= $info['texthtml'];

		$this->PublicState			= $info['publicstate'];

		$this->IsVisible				= $info['isvisible']  ? true : false;
		$this->IsAllowComments	= $info['isallowcomments'];
		$this->IsConverted			= $info['isconverted'] ? true : false;

		$this->ComplaintCount	= (int) $info['complaintcount'];
		$this->OldID					= (int) $info['oldid'];
		$this->IsMain					= $info['ismain'] > 0 ? 1 : 0;
		$this->Views					= $info['views'];
	}


	/**
	 * сохранить информацию в базе
	 * использует метод метод DiaryRecordsMgr
	 * $byold - проверка по $oldid
	 */
	public function Update( $byold = false ) {

		$info = array(
			'Created'					=> strftime("%G-%m-%d %H:%M:%S",$this->Created),

			'Title'						=> $this->Title,
			'Text'						=> $this->Text,
			'TextHTML'				=> $this->TextHTML,
			'PublicState'				=> (int)$this->PublicState,

			'IsAllowComments'	=> (int) $this->IsAllowComments,
			'IsVisible'					=> (int) $this->IsVisible,
			'ComplaintCount'		=> (int) $this->ComplaintCount,
			'IsConverted'			=> (int) $this->IsConverted,
			'OldID'						=> (int) $this->OldID,
			'IsMain'					=> (int) $this->IsMain,
		);


		$info['RecordID'] = $this->ID;
		$info['DiaryID']	= $this->DiaryID;
		$info['RegionID']	= $this->RegionID;
		$info['UserID']	= $this->UserID;

		if ( $byold !== true )
			$id = DiaryMgr::getInstance()->UpdateRecord($info);
		else
			$id = DiaryMgr::getInstance()->UpdateOldRecord($info);

		if ( $id !== false )
			$this->ID = $id;

		DiaryMgr::getInstance()->removeRecordRef2Image($this->ID);
		$photos = array();
		if (preg_match_all('@\[UGALLERY=(\d+)\]([^\]\[]*\[/UGALLERY\])?@i', $this->Text, $photos))
			DiaryMgr::getInstance()->addRecordRef2Image($this->ID, $photos[1]);

		return $id;
	}


	public function Remove() {

		if ( $this->ID === null)
			return false;

		$this->DeleteComplaints();

		DiaryTagMgr::getInstance()->UnlinkTags( $this->DiaryID, $this->ID );
		DiaryMgr::getInstance()->RemoveRecord($this->ID);
	}


	public function AddComplaint( $text )
	{

		return DiaryMgr::getInstance()->AddComplaint( $this->ID, $text );
	}


	public function GetComplaints( )
	{

		return DiaryMgr::getInstance()->GetComplaints( $this->ID );
	}


	public function DeleteComplaints( )
	{

		return DiaryMgr::getInstance()->DeleteComplaints( $this->ID );
	}


	public function SetTags( array $tags ){

		//DiaryTagMgr::getInstance()->UnlinkTags( $this->DiaryID, $this->ID );

		foreach($tags as $k => $v){
			$tags[$k] = trim($v);
		}

		$old = self::GetTags( array(), true);

		$old_tags = array();

		foreach ( $old as $tag ){
			$old_tags[] = $tag['Name'];
		}

		$new_tags = array_diff($tags, $old_tags);
		$del_tags = array_diff($old_tags, $tags);

		//error_log(print_r($new_tags, true));
		//error_log(print_r($del_tags, true));
		//error_log(print_r($old_tags, true));
		//error_log(print_r($tags, true));

		foreach ( $new_tags as $name ){
			$tag = DiaryTagMgr::getInstance()->Create( $name );
			if ( !empty($tag) )
				DiaryTagMgr::getInstance()->LinkTag( $tag->ID, $this );
				//DiaryTagMgr::getInstance()->LinkTag( $tag->ID, $this->DiaryID, $this->ID, $this->RegionID );
			else
				return false;
		}

		foreach ( $del_tags as $name ){
			$tag = DiaryTagMgr::getInstance()->Create( $name );
			if ( !empty($tag) )
				DiaryTagMgr::getInstance()->UnlinkTag( $tag->ID, $this->DiaryID, $this->ID );
			else
				return false;
		}

		DiaryTagMgr::getInstance()->UpdateOptDate( $this );

		return true;
	}


	public function GetTags( array $filter, $as_array = false ){

		$filter['diaryid'] = $this->DiaryID;
		$filter['recordid'] = $this->ID;

		return DiaryTagMgr::getInstance()->GetTags( $filter, $as_array );
	}


	public function IncPoints( $points = 1){

		if ( $this->ID === null)
			return false;

		return DiaryMgr::getInstance()->IncRecordPoints( $this->ID, $points );
	}


	public function DecPoints( $points = 1){

		if ( $this->ID === null)
			return false;

		return DiaryMgr::getInstance()->DecRecordPoints( $this->ID, $points );
	}


	public function __set($name, $value) {

		if ( strtolower($name) == 'text' ){
			$this->Text = $value;
			$this->TextHTML = bbtags::BBTagsConvert($value);
			$this->TextHTML = Smiles::Convert($this->TextHTML);
		} elseif( strtolower($name) == 'gallerymgr'){

			bbtags::$GalleryMgr = $value;
		}

		return null;
	}


	public function __get($name) {

		switch ( strtolower($name) ){

			case 'text':
				return $this->Text;
			case 'texthtml':
				return $this->TextHTML;
			case 'points':
				return $this->Points;
		}

		return null;
	}


	function __destruct() {

	}
}
?>