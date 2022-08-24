<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {range} compiler function plugin
 *
 * Type:     compiler function<br>
 * Name:     range<br>
 * Purpose:  Create an array containing a range of elements
 * @param string containing var-attribute and value-attribute
 * @param Smarty_Compiler
 */
function smarty_compiler_range($tag_attrs, &$compiler)
{
    $_params = $compiler->_parse_attrs($tag_attrs);

    if (!isset($_params['var'])) {
        $compiler->_syntax_error("assign: missing 'var' parameter", E_USER_WARNING);
        return;
    }

    if (!isset($_params['start'])) {
        $compiler->_syntax_error("assign: missing 'start' parameter", E_USER_WARNING);
        return;
    }
	if (!isset($_params['end'])) {
        $compiler->_syntax_error("assign: missing 'end' parameter", E_USER_WARNING);
        return;
    }

    return "\$this->assign({$_params['var']}, range({$_params['start']},{$_params['end']}));";
}

/* vim: set expandtab: */

?>
