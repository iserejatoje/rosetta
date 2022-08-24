<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {control} function plugin
 *
 * Type:     function<br>
 * Name:     control<br>
 * @param array
 * @param Smarty
 */
function smarty_function_banner($params, &$smarty)
{
    if (!isset($params['id']) || $params['id'] == '') 
	{
        $smarty->trigger_error("control: missing 'id' parameter");
        return;
    }

	$id = $params['id'];
	if(!empty($params['page']))
		$page = "&amp;p=\".{$params['page']}.\"";	
		
	return "<script language=\"javascript\" type=\"text/javascript\" src=\"".smarty_function_banner_class::GetPath()."?c=".$id.$page."\"></script>";
}
class smarty_function_banner_class {
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
}

/* vim: set expandtab: */

?>
