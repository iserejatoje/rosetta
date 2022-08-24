<?
/*
 *	Баннер
 *		version (int) - banner version (1|2), default 2
 *		type (string) - multi|single
 * 		width (string) - width with % or px
 * 		height (string) - height with % or px
 *		text (boolean) - with text if true
 * 		page (string) - page for banner
 * 		visible (boolean) - show place or hidden (popunder doesnt need to show)
 */

if ( !defined('STPL_BANNER_PATH') )
{
	LibFactory::GetStatic('rand');
	define('STPL_BANNER_PATH', Rand::RandStrByRule(Rand::$Rules['banner_single']));
}

if(!isset($vars['id']))
{
	error_log("banner: missing 'id' parameter");
	return;
}

$styles = "text-align: center;";
$params = array( 'version' => 2 );
// VISIBLE
if(isset($vars['visible']))
	if($vars['visible'] == false || $vars['visible'] == 0)
		$styles.= "display:none;";
// WIDTH
if(!empty($vars['width'])){
	if(preg_match("@\d$@", $vars['width'])) $vars['width'].= "px";
	$styles.= "width:".$vars['width'].";";
}
// HEIGHT
if(!empty($vars['height'])){
	if(preg_match("@\d$@", $vars['height'])) $vars['height'].= "px";
	$styles.= "height:".$vars['height'].";";
}
// TEXT
if($vars['text'] == true || $vars['text'] == 1)
	$params['withText'] = "1";
// PAGE
if(!empty($vars['page']))
	$params['page'] = $vars['page'];
// TYPE
if(in_array($vars['type'], array("single", "multi")))
	$params['type'] = $vars['type'];
// VERSION
if(in_array($vars['version'], array(1,2)))
	$params['version'] = $vars['version'];

if ( $params['version'] == 1 )
{
	$id = $vars['id'];
	if ( !empty($vars['page']) )
		$page = "&amp;p=\".{$vars['page']}.\"";	
		
	echo "<script language=\"javascript\" type=\"text/javascript\" src=\"". STPL_BANNER_PATH ."?c=".$id.$page."\"></script>";

}
else if ( $params['version'] == 2 )
{
	echo "<div class=\"surbis_banner\" id=\"sb_".$vars['id']."\"".($styles!=""?" style=\"".$styles."\"":"").">";
	if(count($params)>0)
		foreach ($params as $k=>$v)
			echo "<p class=\"".$k."\" style=\"display:none;\">".$v."</p>";
	echo "</div>";
	unset($params); unset($id); unset($_params); unset($styles);

	echo $text;
}

/*
class stpl_banner_class {
	static private $path = null;
	
	static public function GetPath()
	{
		if( self::$path === null  )
		{
			LibFactory::GetStatic('rand');
			self::$path = Rand::RandStrByRule(Rand::$Rules['banner_single']);
		}
		return self::$path;
	}
}*/

?>
