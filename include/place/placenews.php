<?

class PlaceNews
{
	public $ID;
	public $PlaceID;
	public $IsVisible;
	public $IsVerified;
	public $Name;
	public $Text;
	public $Created;
	public $Updated;

	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['newsid']) && Data::Is_Number($info['newsid']) )
			$this->ID = $info['newsid'];

		$this->PlaceID = 0;
		if ( Data::Is_Number($info['placeid']) )
			$this->PlaceID = $info['placeid'];
		
		$this->IsVisible		= $info['isvisible'] > 0;
		$this->IsVerified		= $info['isverified'] > 0;
		$this->Name				= $info['name'];
		$this->Text				= $info['text'];
		$this->Created			= strtotime($info['created']);
		$this->Updated			= strtotime(date("Y-m-d H:i:s"));
	}
	
	public function Remove() 
	{
		if ( $this->ID === null)
			return false;
		
		PlaceNewsMgr::getInstance()->Remove($this->ID);
	}
	
	public function Update()
	{
		$info = array(
			'PlaceID'		=> $this->PlaceID,
			'IsVisible'		=> $this->IsVisible,
			'IsVerified'	=> $this->IsVerified,
			'Name'			=> $this->Name,
			'Text'			=> $this->Text,
			'Created'		=> date("Y-m-d H:i:s", $this->Created),
			'Updated'		=> date("Y-m-d H:i:s", $this->Updated),
		);
		
		if ( $this->ID !== null ) 
		{
			$info['NewsID'] = $this->ID;
			return PlaceNewsMgr::getInstance()->Update($info);
		
		} 
		else if (($newsid = PlaceNewsMgr::getInstance()->Add($info)) !== false)
		{
			$this->ID = $newsid;
			return $newsid;
		}

		return false;
	}
	
	public function __set($name, $value) 
	{
		return null;
	}

	public function __get($name)
	{
		return null;
	}

	function __destruct()
	{
	}
}