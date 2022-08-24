<?

class Page
{
	private $_mgr;
	
	public $ID;
	public $SectionID;
	public $Created;
	public $LastUpdated;
	public $Name;
	public $Text;
	public $AnnounceText;
	public $IsVisible;
	
	function __construct(array $info)
	{
		global $OBJECTS;
		
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['pageid']) && Data::Is_Number($info['pageid']) )
			$this->ID = $info['pageid'];
		
		$this->SectionID	= (int)$info['sectionid'];
		$this->Created		= $info['created'];
		$this->LastUpdated	= $info['lastupdated'];
		$this->Name			= $info['name'];
		$this->Text			= $info['text'];
		$this->AnnounceText	= $info['announcetext'];
		$this->IsVisible	= $info['isvisible']  ? true : false;
	}
	
	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод EShopMgr
	 */
	public function Update()
	{
		$info = array(
			'SectionID'		=> $this->SectionID,
			'Name'			=> $this->Name,
			'IsVisible'		=> (int) $this->IsVisible,
			'Text'			=> $this->Text,
			'AnnounceText'	=> $this->AnnounceText,
		);
		
		if ( $this->ID !== null )
		{
			$info['PageID'] = $this->ID;			
			if (PageMgr::getInstance()->Update($info) !== false) 
				return true;			
		} 
		else if ( ($new_id = PageMgr::getInstance()->Add($info)) !== false)
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
		
		PageMgr::getInstance()->Remove($this->ID);
	}

	function __destruct()
	{

	}
}

