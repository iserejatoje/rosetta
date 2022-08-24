<?
class PRolesProvider_conference_comments extends PRolesProviderObject
{

	function IsInRole($roleName, $addKey = null)
	{
		global $OBJECTS;
		
		if ( $roleName == 'a_comment_edit' )
			return false;
			
		if ( $roleName != 'a_comment_add')
			return true;
			
		list($sectionid, $conferenceid) = explode('_', $addKey);
		
		
		$config = ModuleFactory::GetConfigById('section', $sectionid);
		if ( !$config || !$conferenceid )
			return false;

		$_db = DBFactory::GetInstance($config['db']);
		
		$sql = 'SELECT isNow FROM '.$config['tables']['article'];
		$sql.= ' WHERE ConferenceID = '.(int) $conferenceid;
		$sql.= ' AND isVisible = 1 ';
		
		$res = $_db->query($sql);
		list($isNow) = $res->fetch_row();

		if ( $isNow >= 2 )
			return true;
		
		return false;
	}
	
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_conference_comments_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>