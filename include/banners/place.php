<?php

class BannerPlace
{
	private $_mgr;

	public $ID;
	public $Name;
	public $Banners;
	public $Interval;
	public $IsVisible;
	
	private $cache;

	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['placeid']) && Data::Is_Number($info['placeid']) )
			$this->ID = $info['placeid'];

		$this->Name			= stripslashes($info['name']);
		$this->Interval		= intval($info['interval']);
		$this->Banners		= intval($info['banners']);
		$this->IsVisible	= $info['isvisible'] ? true : false;		
		
		$this->cache = BannerMgr::GetInstance()->GetCache();
	}

	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод EShopMgr
	 */
	public function Update()
	{
		$info = array(						
			'Name' 			=> stripslashes($this->Name),
			'Interval' 		=> (int) $this->Interval,
			'Banners' 		=> (int) $this->Banners,
			'IsVisible' 	=> (int) $this->IsVisible,
		);

		if ( $this->ID !== null )
		{
			$info['PlaceID'] = $this->ID;
			if ( false !== BannerMgr::getInstance()->UpdatePlace($info))
				return true;
		}
		else if ( false !== ($new_id = BannerMgr::getInstance()->AddPlace($info)))
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

		BannerMgr::getInstance()->RemovePlace($this->ID);
	}
	
	function __destruct()
	{

	}
}

