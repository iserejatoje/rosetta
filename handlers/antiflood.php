<?

/**
 * Хендлер для работы с библиотекой antiflood
 * @package Handlers
 */
class Handler_antiflood extends IHandler
{
	private $islast = false;
	private $isinit = '';

	public function __construct()
	{
	}

	public function Init($params)
	{
		LibFactory::GetStatic('antiflood');
		if(isset($params['params']['init']) && $params['params']['init'] == true) // может не быть
			$this->isinit = true;
		else
			$this->isinit = false;
	}

	public function IsLast()
	{
		return $this->islast;
	}

	public function Run()
	{
		global $OBJECTS;
		if($OBJECTS['user']->ID != 2 && $OBJECTS['user']->ID != 8)
			return;

		$af = AntiFlood::getInstance();
		if($this->isinit === true)
		{
			$af->ApplyRules(); // применятся только глобальные правила
		}

		if($this->isinit === false && $af->GetGlobalHandle() === true && $af->GetStatus() != AntiFlood::ST_NORMAL)
		{
			$this->islast = true;
			$this->SendStatus($af);
		}
	}

	public function SendStatus($af)
	{
		global $CONFIG, $OBJECTS;

		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		if(strpos($host, 'dvp.') === 0)
			$host = substr($host, 4);

		$CONFIG['env']['site']	= ModuleFactory::GetConfigById('site', STreeMgr::GetSiteIDByHost($host));
		$CONFIG['env']['site']['tree_id'] = STreeMgr::GetSiteIDByHost($host);
		
		$sitenode = STreeMgr::GetNodeByID($CONFIG['env']['site']['tree_id']);
		
		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['regid']	= Data::Is_Number($sitenode->Regions)?$sitenode->Regions:0;
		unset($host);

		include_once $CONFIG['engine_path']."include/smarty_v2.php";

		$OBJECTS['smarty'] = new CSmarty();

		$OBJECTS['smarty']->caching = 0;
		$OBJECTS['smarty']->force_compile = true; // для отладки

		$OBJECTS['smarty']->assign_by_ref('CURRENT_ENV', $CONFIG['env']);
		$OBJECTS['smarty']->assign_by_ref('USER', $OBJECTS['user']);
		
		$af->SendStatus();
    }

	public function Dispose()
	{
	}
}