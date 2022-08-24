<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {keyword} function plugin
 * Purpose:  вывод слов из базы заданных местом или именем
 * @param array parameters
 * @param Smarty
 * @return string
 */
function smarty_function_keyword($params, &$smarty)
{
        global $CONFIG;
        if(!isset($CONFIG['engine_path'])){
                $CONFIG['engine_path'] = ENGINE_PATH;
                if(!class_exists('DBFactory'))
                {
                        include_once $CONFIG['engine_path'].'include/db.php';
                        include_once $CONFIG['engine_path'].'include/patterns.php';
                }
                include_once $CONFIG['engine_path'].'configure/engine.php';
        }
	$keywords = LibFactory::GetInstance('keywords');
	
    if (!isset($params['id']) && !isset($params['name'])) {
        $smarty->trigger_error("keyword: missing 'id' or 'name' parameter");
        return;
    }
    
    //if (!isset($params['uid'])) {
    //    $smarty->trigger_error("keyword: missing 'uid' parameter");
    //    return;
    //}
    
    if(isset($params['id']))
    	return $keywords->GetTextById($params['id'],$params['uid'],$params['site'],$params['default']);
    else
    	return $keywords->GetTextByName($params['name'],$params['uid'],$params['site'],$params['default']);
}

/* vim: set expandtab: */

?>
