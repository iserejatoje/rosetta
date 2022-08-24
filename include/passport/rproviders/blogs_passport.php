<?
class PRolesProvider_blogs_passport extends PRolesProviderObject
{

	function IsInRole($roleName, $addKey = null)
	{
		global $OBJECTS;

		if ( $roleName == 'a_record_edit' )
			return false;
		return true;
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_blogs_passport_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>