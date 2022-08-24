<?
//include_once "smarty/Smarty.class.php";
include_once SMARTY_DIR."Smarty.class.php";

class CSmarty extends Smarty
{
	var $_smarty_mysql_cache_handler = null;
	
	function CSmarty($initpath = true)
	{
		global $CONFIG;
		$this->Smarty();
		
		// добавляем переменную - ссылку на объект smarty
		$this->assign_by_ref('SMARTY', $this);
		
		$this->use_sub_dirs = true;

		if($initpath === true)
		{
			$sn = STreeMgr::GetNodeByID($CONFIG['env']['site']['tree_id']);
			
			$this->template_dir = ENGINE_PATH."/templates/smarty/";
			$this->compile_dir 	= SMARTY_COMPILE_DIR.$sn->Name."/";
			$this->cache_dir 	= SMARTY_CACHE_DIR.$sn->Name."/";
			
			if(!is_dir($this->compile_dir))
				mkdir($this->compile_dir, 0777, true);
			if(!is_dir($this->cache_dir))
				mkdir($this->cache_dir, 0777, true);
		}
		
		$this->register_block('dynamic', '__smarty_block_dynamic', false);
	}
	
	
	function fetch()
	{
		if( $this->caching !== 0 && $this->caching !== 1  && $this->caching !== 2 )
			Data::e_backtrace(__CLASS__.': Current value of CSmarty->caching is "'.var_export($this->caching, true).'". The system can go down!!!');
		$args = func_get_args();
		if(count($args)<1)
		{
			error_log("[".__CLASS__." error] function 'fetch' expect at least 1 parameter.");
			return "";
		}
		/* && $GLOBALS['LOG_SMARTY_ERROR'] == true*/
		if(substr($args[0], 0, 1) == '/')
			$path = $args[0];
		else
			$path = $this->template_dir.$args[0];
		if(!is_file($path))
		{
			if($_GET['backtrace']>10)
			{
				$ar = debug_backtrace();
				$er = "";
				$tab = "";
				$er .= $tab.'template_dir: '.$this->template_dir."\ncompile_dir: ".$this->compile_dir."\ncache_dir:".$this->cache_dir."\n";
				if(count($ar)>0)
				{
					foreach($ar as $k=>$v)
					{
						$er .= ($er!=""?"\n":"");
						$er .= $tab.'file: '.$v['file'].':'.$v['line']."\n";
						if(count($v['args'])>0){
							$er .= $tab.$v['class'].$v['type'].$v['function']."(\n";
							$er .= $this->dump_args($v['args'], $tab."\t", "\n");
							$er .= $tab.")\n";
						}
						else
							$er .= $tab.$v['class'].$v['type'].$v['function']."()\n";
						//$tab .= "\t";
					}
				}
				echo "<pre>".$er."</pre>";
			}
			else
			{
				Data::e_backtrace("Template not found: '".$args[0]."'");				
			}
			return "";
		}
		if($GLOBALS['LOG_SMARTY'])
		{
			$start = microtime(true);
			//$res = parent::fetch($resource_name, $cache_id, $compile_id, $display);
			$res = call_user_func_array(array(parent, 'fetch'), $args);
			$all = microtime(true) - $start;
			$GLOBALS['LOG_SMARTY_ERR']['buffer'][] = number_format($all, 6, ",", " ")."\t".date('Y-m-d H:i:s')."\t".var_export($this->caching, true)."\t".$this->template_dir.$args[0];
			$GLOBALS['LOG_SMARTY_ERR']['all'] += $all;
			return $res;
		}
		else
			return call_user_func_array(array(parent, 'fetch'), $args);;
	}
	
	
	function is_template($template = "")
	{
		if($template == '')
			return false;
		if(substr(strval($template), 0, 1) == '/')
			return is_file($template);
		else
			return is_file($this->template_dir.$template);
	}
	
	function dump_args($var, $pref = "", $post = "")
	{
		$er = "";
		foreach($var as $k=>$v)
		{
			$er .= $pref.$k." => ";
			if(is_string($v))
				$er .= "'".$v."'";
			else if(is_null($v))
				$er .= "NULL";
			else if(is_array($v))
				$er .= "array(".$post.$this->dump_args($v, $pref.substr($pref, -1), $post).$pref.")";
			else if(is_object($v))
				$er .= "[Objects]";
			else
				$er .= $v;
			$er .= $post;
		}
		return $er;
	}
	
}

function __smarty_block_dynamic($param, $content, &$smarty) {
    return $content;
}

?>