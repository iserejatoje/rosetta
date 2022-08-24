<?
class PRolesProvider_passport_gallery extends PRolesProviderObject
{
	protected $usersType = null;
	protected $communitiesType = null;
	
	// GroupClosed		= 0x01;
	// GroupOpened		= 0x02;
	
	// UserNotInCommunity	= -0x01
	// UserNotConfirmed		=  0x00
	// User					=  0x01	
	// UserModerator		=  0x02
	// UserOwner			=  0x03
	static protected $roles = array(
		'a_gallery_view' 			=> array(true, true),
		'a_gallery_photo_view' 		=> array(true, true),
		'a_gallery_photo_edit' 		=> array(false, true),
		'a_gallery_photo_add' 		=> array(false, true),
		'a_gallery_photo_owner_edit' => array(false, true),
		'a_gallery_album_view' 		=> array(true, true),
		'a_gallery_album_edit' 		=> array(false, true),
		'a_gallery_album_add' 		=> array(false, true),
		'a_gallery_album_owner_edit' => array(false, true),
		);
	
	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	function IsInRole($roleName, $addKey = null)
	{
		if($addKey === null)
			return false;

		$id = intval(substr($addKey, 1));
		if($id === false)
			return false;
		
		if ($id == $this->user->ID)
			$i = 1;
		else
			$i = 0;
		
		return self::$roles[$roleName][$i];
	}
	
	/**
	 * Получить объекты для роли
	 *
	 * @param string roleName имя роли
	 * @return array список объектов для которых назначена данная роль
	 */
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_passport_gallery_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>