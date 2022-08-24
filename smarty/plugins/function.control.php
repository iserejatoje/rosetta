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
function smarty_function_control($params, &$smarty)
{

    if (!isset($params['id']) || $params['id'] == '') 
	{
        $smarty->trigger_error("control: missing 'id' parameter");
        return;
    }
	
	if (!isset($params['ctrl']) || $params['ctrl'] == '') 
	{
        $smarty->trigger_error("control: missing 'ctrl' parameter");
        return;
    }

    LibFactory::GetStatic('control');	
	$ps = array();
	
	foreach($params as $k => $p)
	{
		if($k != 'ctrl')
			$ps[$k] = $p;
	}
	
	$ctrl = ControlFactory::GetInstance($params['ctrl'], $ps);

    return $ctrl->Render();
}

/* vim: set expandtab: */

?>
