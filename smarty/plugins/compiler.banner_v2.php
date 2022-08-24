<?
/*
 * Smarty plugin
 * -----------------------------------------------------------
 * File:		compiler.banner_v2.php
 * Type:		compiler
 * Name:		banner
 * Params:		id (int) - identifier
 *				type (string) - multi|single
 * 				width (string) - width with % or px
 * 				height (string) - height with % or px
 *				text (boolean) - with text if true
 * 				page (string) - page for banner
 * 				visible (boolean) - show place or hidden (popunder doesnt need to show)
 */

function smarty_compiler_banner_v2($tag_arg, &$smarty)
{ 	
	$_params = $smarty->_parse_attrs($tag_arg);
	if(count($_params)>0)
		foreach($_params as $k=>$v)
			if(preg_match("@^\'(.+)\'$@", $v, $rg))
				$_params[$k] = $rg[1];

	if(!isset($_params['id']))
	{
		$smarty->_syntax_error("banner: missing 'id' parameter", E_USER_WARNING);
		return;
	}
    
	$styles = "text-align: center;";
	$params = array();
	// VISIBLE
	if(isset($_params['visible']))
		if($_params['visible'] == false || $_params['visible'] == 0)
			$styles.= "display:none;";
	// WIDTH
	if(!empty($_params['width'])){
		if(preg_match("@\d$@", $_params['width'])) $_params['width'].= "px";
		$styles.= "width:".$_params['width'].";";
	}
	// HEIGHT
	if(!empty($_params['height'])){
		if(preg_match("@\d$@", $_params['height'])) $_params['height'].= "px";
		$styles.= "height:".$_params['height'].";";
	}
	// TEXT
	if($_params['text'] == true || $_params['text'] == 1)
		$params['withText'] = "1";
	// PAGE
	if(!empty($_params['page']))
		$params['page'] = $_params['page'];
	// TYPE
	if(in_array($_params['type'], array("single", "multi")))
		$params['type'] = $_params['type'];
		
	// временный вариант
	/*if(!empty($_params['page']))
		$page = "&amp;page=".$_params['page'];	
	$text = "echo \"<script language=\\\"JavaScript\\\" src=\\\"http://www.surbis.ru/cgi-bin/banjs.cgi?clientID=".$_params['id'].$page."\\\" type=\\\"text/javascript\\\"></script>\";";
	*/
	// как рамблер поднимется
	$text = "echo \"<div class=\\\"surbis_banner\\\" id=\\\"sb_".$_params['id']."\\\"".($styles!=""?" style=\\\"".$styles."\\\"":"").">";
	if(count($params)>0)
		foreach ($params as $k=>$v)
			$text.= "<p class=\\\"".$k."\\\" style=\\\"display:none;\\\">".$v."</p>";
	$text.= "</div>\";";
	unset($params); unset($id); unset($_params); unset($styles);
	return $text;
}
?>