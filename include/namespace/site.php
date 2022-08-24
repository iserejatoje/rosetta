<?
LibFactory::GetStatic('config');
class Namespace_site extends NamespaceBase
{
	public function ParseLink($site, $url)
	{
		$sectionid = null;
		$parray = explode('/',$url);

		$fp = $parray;
		$fpos = $pos = 0;

		$pa = array();
		foreach($parray as $pa_)
			if(!empty($pa_))
				$pa[] = $pa_;
		$parray = $pa;

		if(sizeof($parray) == 0)
			return array(0, array(), '');
		$path = '';
		do
		{
			$path.= ($path?'/':'').array_shift($parray);
			$pos++;
			$p = STreeMgr::GetSectionIDByTreePath($site, $path);
			if($p !== null)
			{
				$sectionid = $p;
				$fpos = $pos;
			}
		}while(sizeof($parray));
		$params = '';
		$parray = array_slice($fp, $fpos);
		do
		{
			if(strlen($params) > 0)
				$params.= '/';
			$params.= array_shift($parray);
		}while(sizeof($parray));
		return array($sectionid, array(), $params);
	}

	public function SetTitle($params = null)
	{
	}

	public function GetLink($sectionid = 0, $params = array(), $withdomain = true)
	{
		global $CONFIG;

		$sinfo = STreeMgr::GetNodeByID($sectionid);	
		
		if( $sinfo && $sinfo->ParentID > 0 )
		{
			$d = '';
			if($sinfo->TypeInt != 1 && $withdomain == true)
				$d = $sinfo->Parent->Path.'/';
			return $d.$sinfo->Path.($withdomain?'/':'');
		}
		else
			return false;
	}
}
?>
