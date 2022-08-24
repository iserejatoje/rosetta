<?
/**
 * Хендлер для работы с модулями
 * @package Handlers
 */

class Handler_widget extends IHandler
{
	private $widget;

	public function Init($params)
	{
		global $OBJECTS, $CONFIG;

		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		include_once $CONFIG['engine_path']."include/lib.stpl.php";
		include_once $CONFIG['engine_path']."include/misc.php";
		include_once $CONFIG['engine_path']."include/json.php";

		Response::NoCache();

		LibFactory::GetStatic('data');

		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		
		$CONFIG['env']['site']	= ModuleFactory::GetConfigById('site', STreeMgr::GetSiteIDByHost($host));
		$CONFIG['env']['site']['tree_id'] = STreeMgr::GetSiteIDByHost($host);
		// тут установлен design
		STPL::SetTheme($CONFIG['env']['site']['design']);

		$sitenode = STreeMgr::GetNodeByID($CONFIG['env']['site']['tree_id']);

		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['regid']	= Data::Is_Number($sitenode->Regions)?$sitenode->Regions:0;
		$CONFIG['env']['referer'] = parse_url(App::$Request->Server['HTTP_REFERER']->Value());
		if(strpos($CONFIG['env']['referer']['host'], 'www.') === 0)
			$CONFIG['env']['referer']['host'] = substr($CONFIG['env']['referer']['host'], 4);
		if(strpos($CONFIG['env']['referer']['host'], 'dvp.') === 0)
			$CONFIG['env']['referer']['host'] = substr($CONFIG['env']['referer']['host'], 4);
		// TEMPORARY
		if(in_array($CONFIG['env']['regid'], $CONFIG['env']['svoi_regions']))
			$CONFIG['env']['svoi'] = true;

		// создаем необходимые объекты
		$OBJECTS['json'] = new Services_JSON();
		$OBJECTS['json']->charset = 'WINDOWS-1251';

		$OBJECTS['smarty'] = new CSmarty(false);
		$OBJECTS['smarty']->assign('MAIN_DOMAIN', MAIN_DOMAIN);
		// установим пути
		$OBJECTS['smarty']->template_dir	= ENGINE_PATH."/templates/smarty/";
		$OBJECTS['smarty']->compile_dir		= SMARTY_COMPILE_DIR;
		$OBJECTS['smarty']->cache_dir		= SMARTY_CACHE_DIR;
		if(!is_dir($OBJECTS['smarty']->compile_dir. '_widgets/'))
			mkdir($OBJECTS['smarty']->compile_dir. '_widgets/', 0777, true);
		if(!is_dir($OBJECTS['smarty']->cache_dir. '_widgets/'))
			mkdir($OBJECTS['smarty']->cache_dir. '_widgets/', 0777, true);

		// не кэшируем виджеты
		$OBJECTS['smarty']->caching = 0;
		$OBJECTS['smarty']->force_compile = true;

		// отдаем окружение в смарти (по ссылке!!!)
		$OBJECTS['smarty']->assign_by_ref('GLOBAL_ENV', App::$Global);
		$OBJECTS['smarty']->assign_by_ref('CURRENT_ENV', $CONFIG['env']);
		// отдаем необходимые объекты в смарти (по ссылке!!!)
		$OBJECTS['smarty']->assign_by_ref('USER', $OBJECTS['user']);

		// обрежем первые символы
		$wname = substr(HandlerFactory::$env['uri'], strlen($params['uri']));
		if(preg_match('@([\w\/_\-\.]+)\/([\w_\-\.]+).php@', $wname, $matches))
		{
			$cid = App::$Request->Request['widgetContainerId']->Int(0, Request::UNSIGNED_NUM);
			if($cid == 0)
				return true; // блок отработал, но не пришел идентификатор виджета на странице

			$isinit = (App::$Request->Request['widgetContainerInit']->Value() == 'true');

			LibFactory::GetStatic('cryptography');
			$tic = App::$Request->Request['tic']->Value();
			$tic = Cryptography::xsx_decode(base64_decode($tic));
			$tic = unserialize($tic);

			$params = array();
			
			if(is_array($tic))
				foreach($tic as $f)
				{
					if(isset(App::$Request->Request[$f]))
						$params[$f] = App::$Request->Request[$f]->Value();
				}

			if (!isset($params['method']))
				$params['method'] = 'async';
			$params['isinit'] = false;
			
			$this->widget = WidgetFactory::GetInstance($matches[1], $matches[2], $params, $cid, $isinit);
			if($this->widget === null)
				return false;

			if ($params['method'] === 'ssi')
				$this->widget->SetOutputMode(IWidget::OUTPUT_SSI);
				
			return true;
		}
		else
			return false;

		return true;
	}

	public function IsLast()
	{
		return true;
	}

	public function getParams() {
		if(!is_object($this->widget))
			return null;
			
		return $this->widget->params;
	}
	
	public function getParam($key) {
		if(!is_object($this->widget))
			return null;
			
		if (!isset($this->widget->params[$key]))
			return null;
			
		return $this->widget->params[$key];
	}
	
	public function Run()
	{
		if(!is_object($this->widget))
			return false;
		
		if ($this->widget->params['method'] !== 'ssi')
			echo $this->widget->Run();
		else
		{
			LibFactory::GetStatic('cache');

			$_cache = new Cache();
			$_cache->Init('memcache', 'fe_widgets');
	
			$lifetime = $this->widget->params['lifetime'];
			if ($this->widget->params['lifetime'] <= 0)
				$lifetime = 600;
					
			$data = $this->widget->Run();
			
			// переопределяем время жизни кеша
			if( isset($data['metadata']['lifetime']) )
				$lifetime = $data['metadata']['lifetime'];
			
			$_cache->set($this->widget->params['cacheid'], $data['content'], $lifetime, 0);
			echo $data['content'];
			unset($_cache);
		}

		return true;
	}

	public function Dispose()
	{
		return true;
	}
}
?>
