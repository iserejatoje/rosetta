<?
class PRolesProvider_afisha_comments extends PRolesProviderObject
{

	function IsInRole($roleName, $addKey = null)
	{
		global $OBJECTS;

		/*if ( $OBJECTS['user']->IsAuth() )
			return true;
		return false;*/

		if ( $roleName == 'a_comment_edit' )
			return false;
		return true;
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_afisha_comments_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>