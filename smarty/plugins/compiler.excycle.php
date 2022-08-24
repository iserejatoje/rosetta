<?
/*
 * Smarty plugin
 * -----------------------------------------------------------
 * File:		compiler.excycle.php
 * Type:		compiler
 * Name:		excycle
 * Params:		values - список значений
 * 				separator - разделитель значений (по умолчанию ,)
 * 				print - печатать или нет (по умолчанию true)
 * 				reset - true = начало с первого
 * 				name - имя для цикла (по умолчанию: default)
 */

function smarty_compiler_excycle($tag_arg, &$smarty)
{
	$_params = $smarty->_parse_attrs($tag_arg);
		
	if(empty($_params['print']))
	{
		if(empty($_params['values']))
			$_params['print'] = 'true';
		else
			$_params['print'] = 'false';
	}
	if(is_bool($_params['print']))
		$_params['print'] = $_params['print']?'true':'false';
	$_params['print'] = $smarty->_dequote($_params['print']);

	if(empty($_params['name']))
		$_params['name'] = 'default';
	$_params['name'] = $smarty->_dequote($_params['name']);
		
	if(empty($_params['separator']))
		$_params['separator'] = ',';
		
	if(!empty($_params['values']))
	{
		$values = explode($smarty->_dequote($_params['separator']), $smarty->_dequote($_params['values']));
		for($i = 0; $i < sizeof($values); $i++)
			$values[$i] = '\''.$values[$i].'\'';
		$ret = "\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'] = array(0, array(".implode(',',$values)."));\n";
		if($_params['print']=='true')
		{
			$ret.= "echo \$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][1][\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]];\n";
			$ret.= "\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]++;\n";
			$ret.= "if(\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0] >= sizeof(\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][1])) \$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]=0;\n";
		}
		return $ret;
	}
	
	if($_params['reset'])
	{
		$ret = "\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]=0;\n";
	}
	
	if($_params['print'] == 'true')
	{
		$ret.= "echo \$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][1][\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]];\n";
		$ret.= "\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]++;\n";
		$ret.= "if(\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0] >= sizeof(\$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][1])) \$this->_tpl_vars['_excycle_vars']['{$_params['name']}'][0]=0;\n";
	}
	return $ret;
}
?>