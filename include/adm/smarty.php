<?
include_once SMARTY_DIR."Smarty.class.php";

class CSmartyAdm extends Smarty
{
	function __construct()
	{
		global $CONFIG;
		$this->Smarty();
		
		$this->caching = 0;
		$this->force_compile = true;

		$this->template_dir = ENGINE_PATH."/templates/smarty/modules/admin/";
		$this->compile_dir 	= SMARTY_COMPILE_DIR."admin/";
		$this->cache_dir 	= SMARTY_CACHE_DIR."admin/";
		
		if(!is_dir($this->compile_dir))
			mkdir($this->compile_dir, 0777, true);
		if(!is_dir($this->cache_dir))
			mkdir($this->cache_dir, 0777, true);
	}
}
?>