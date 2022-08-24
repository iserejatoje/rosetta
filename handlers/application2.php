<?
/**
 * Хендлер для работы с приложениями
 * @package Handlers
 */
 
class Handler_application2 extends IHandler
{
	private $blocks = array();
	private $objects = array();
	private $params = array();
	private $application = null;
	
	public function Init($params)
	{
		global $OBJECTS, $CONFIG;
		$this->params = $params;

		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		include_once $CONFIG['engine_path']."include/misc.php";
		include_once $CONFIG['engine_path']."include/json.php";
		include_once $CONFIG['engine_path']."include/title.php";
		LibFactory::GetStatic('application2');
		LibFactory::GetStatic('data');

		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		if(strpos($host, 'dvp.') === 0)
			$host = substr($host, 4);

		$CONFIG['env']['site']	= ModuleFactory::GetConfigById('site', $CONFIG['siteid_v2'][$host]);
		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['regid']	= Data::Is_Number($CONFIG['tree'][ $CONFIG['env']['site']['tree_id'] ]['regions'])?$CONFIG['tree'][ $CONFIG['env']['site']['tree_id'] ]['regions']:0;
		$CONFIG['env']['section'] = $params['params']['section'];

		// TEMPORARY
		if(in_array($CONFIG['env']['regid'], $CONFIG['env']['svoi_regions']))
			$CONFIG['env']['svoi'] = true;

		$OBJECTS['title'] = new Title();
		$OBJECTS['smarty'] = new CSmarty();
		if($_GET['nocache'] > 10)
		{
			$OBJECTS['smarty']->caching = 0;
			$OBJECTS['smarty']->force_compile = true;
        }
		else
		{
			$OBJECTS['smarty']->caching = $CONFIG['env']['site']['cache_mode'];
			$OBJECTS['smarty']->force_compile = $CONFIG['env']['site']['debug'];
		}

		$OBJECTS['smarty']->assign_by_ref('GLOBAL_ENV', App::$Global);
		$OBJECTS['smarty']->assign_by_ref('CURRENT_ENV', $CONFIG['env']);		

		$OBJECTS['smarty']->assign_by_ref('TITLE', $OBJECTS['title']);
		$OBJECTS['smarty']->assign_by_ref('UERROR', $OBJECTS['uerror']);
		$OBJECTS['smarty']->assign_by_ref('BLOCKS', $this->blocks);
		$OBJECTS['smarty']->assign_by_ref('USER', $OBJECTS['user']);
		
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS, $CONFIG;

		LibFactory::GetStatic('application2');
		$app = new Application2Mgr();
		var_dump($app->ParseUrl('test/test/show/1/test/show/5'));
		
		return true;
	}

	public function IsLast()
	{
		return true;
	}
	
	public function Dispose()
	{
		//$this->application->Dispose();
		return true;
	}
}
?>