<?

$sectionid = App::$Request->Get['sectionid']->Int(0);

if ( $sectionid == 0 )
	exit;


$namespaceid = ModuleFactory::GetNamespaceIdBySectionID($sectionid);
$namespace =   ModuleFactory::GetNamespaceBySectionID($sectionid);

$list = $namespace->GetConfigList($sectionid, true);

//echo '<pre>';
//print_r($list);

if ( $list === null || count($list) == 0 )
	exit;

LibFactory::GetStatic('bl');
$bl = BLFactory::GetInstance('system/config');

$url = $this->params['uri'] . $this->baseurl.$this->bl->GetNodePathByID($sectionid) .'.config/?';

echo "<ul id=\"config_list\">\n";
foreach ( $list as $fld => $l1 )
{
	if ( array_key_exists('ID', $l1) )
	{
		echo "\t<li><a href=\"". $url. "type=". $l1['Type'] ."&id=". $l1['ID'] ."\">".BL_system_config::$type_info[$l1['Type']]['title'] ." (". $l1['ID'] .")</a></li>\n";
		continue;
	}
	
	if ( $fld == '' )
	{
		foreach ( $l1 as $l )
		{
			$config = $bl->LoadConfig($l['Type'], $l['ID']);
			
			if ( $config !== null && count($config) )
				echo "\t<li><a href=\"". $url. "type=". $l['Type'] ."&id=". $l['ID'] ."\">". BL_system_config::$type_info[$l['Type']]['title'] ." (". $l['ID'] .")</a></li>\n";
		}
		continue;
	}
	
	$html = '';
	foreach ( $l1 as $domain => $l2 )
	{
		$html1 = '';
		foreach ( $l2 as $l )
		{
			$config = $bl->LoadConfig($l['Type'], $l['ID']);
			
			if ( !empty($l['Type']) && !empty($l['ID']) )
			{
				if ( $config !== null && count($config) )
					$html1.= "\t\t\t\t\t<li><a href=\"". $url. "type=". $l['Type'] ."&id=". $l['ID'] ."\">".BL_system_config::$type_info[$l['Type']]['title'] ." (". $l['ID'] .")</a></li>\n";
				else
					$html1.= "\t\t\t\t\t<li><a href=\"". $url. "type=". $l['Type'] ."&id=". $l['ID'] ."\" style=\"color:red\">". BL_system_config::$type_info[$l['Type']]['title'] ." (". $l['ID'] .")</a></li>\n";
			}
		}
		if ( !empty($html1) )
		{
			$html.= "\t\t\t<li><a><small>&#x25C4;</small> ". $domain ."</a>\n";
			$html.= "\t\t\t\t<ul>\n";
			$html.= $html1;
			$html.= "\t\t\t\t</ul>\n";
			$html.= "\t\t\t</li>\n";
		}
	}
	
	if ( !empty($html) )
	{
		echo "\t<li><a><small>&#x25C4;</small> ". $fld ."</a>\n";
		echo "\t\t<ul>\n";
		echo $html;
		echo "\t\t</ul>\n";
		echo "\t</li>\n";
	}
}
echo "</ul>";

exit;

?>
