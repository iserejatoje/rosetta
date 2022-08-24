<?
class PRolesProvider_place_comments extends PRolesProviderObject
{

	function IsInRole($roleName, $addKey = null)
	{
		global $OBJECTS;

		if ( $roleName == 'a_comment_add' )
			return true;
		return false;
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_place_comments_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>