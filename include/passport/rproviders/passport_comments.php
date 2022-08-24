<?
class PRolesProvider_passport_comments extends PRolesProviderObject
{
	static protected $roles = array(
		'a_comment_add' 			=> array(true, true),
		'a_comment_edit' 			=> array(false, true),
		'a_comment_owner_edit' 		=> array(false, true),
		);
	
	function IsInRole($roleName, $addKey = null)
	{	
		if($addKey === null)
			return false;
			
		$id = intval(substr($addKey, 1));
		if($id === 0)
			return false;
		
		if ($id == $this->user->ID)
			$i = 1;
		else
			$i = 0;
		
		return self::$roles[$roleName][$i];
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_passport_comments_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>