<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {repeat}{/repeat} block plugin
 * @param array['count'] count
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string repeated string
 */
function smarty_block_repeat($params, $content, &$smarty)
{
    if (is_null($content)) {
        return;
    }

    $count = intval($params['count']);
    if(empty($count))
    	return $content;
    	
    return str_repeat($content, $count);
}

/* vim: set expandtab: */

?>
