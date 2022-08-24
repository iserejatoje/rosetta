<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {word_for_number} function plugin
 *
 * Type:     function<br>
 * Name:     word_for_number<br>
 * @param array (first (1, 21, 31, ...), second (2-4, 22-24, 32-34, ...), third (other))
 * @param Smarty
 * @return string
 */
function smarty_function_word_for_number($params, &$smarty)
{
    if (empty($params['first']) ||
        empty($params['second']) ||
        empty($params['third']))
    {
        $smarty->trigger_error("word_for_number: missing parameter");
        return;
    }
    
    $number = intval($params['number']);
    
    if($number == 1 || ($number > 20 && $number % 10 == 1))
        $word = $params['first'];
    else if(($number >= 2 && $number <= 4) || ($number % 10 >= 2 && $number % 10 <= 4 && $number > 20))
        $word = $params['second'];
    else
        $word = $params['third'];
    echo $word;
}

/* vim: set expandtab: */

?>