<?
class PRolesProvider_blogs_comments extends PRolesProviderObject
{

	function IsInRole($roleName, $addKey = null)
	{
		global $OBJECTS;

		$BlogUserKey = substr($addKey, 1);
		
//		error_log($BlogUserKey." == ".$OBJECTS['user']->ID);
		
		if ( $roleName == 'a_comment_edit' && $BlogUserKey == $OBJECTS['user']->ID)
			return true;
						
		if ( $roleName == 'a_comment_add' )
			return true;		
			
		return false;
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_blogs_comments_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>