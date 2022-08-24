<?

/**
 * Фабрика классов модулей
 * @package WSE
 */

class ModuleFactory
{
	private static $module_action = null;
	private static $objs = array();
	private static $aobjs = array();
	private static $config = array();
	private static $aconfig = array();

	static function SetModuleAction()
	{
		global $CONFIG, $OBJECTS, $ERROR;

		if(self::$module_action === null)
		{
			if( self::IsSectionAllow($CONFIG['env']['sectionid']) !== true )
				Response::Status(403, RS_SENDPAGE | RS_EXIT);

			if($CONFIG['env']['ns']['ns'] !== null)
				$CONFIG['env']['ns']['ns']->SetTitle($CONFIG['env']['ns']['nsparams']);
			self::$module_action = ModuleFactory::GetInstance($CONFIG['env']['sectionid'], $CONFIG['env']['ns']['nsparams']);
		}
	}

	static function GetModuleAction()
	{
		global $CONFIG, $ERROR;

		return self::$module_action;
	}

	static function GetAdminInstance($sectionID, $params = array())
	{
		global $CONFIG, $ERROR;

		if(!isset(self::$aobjs[$sectionID]))
		{
			$section = STreeMgr::GetNodeByID($sectionID);

			$env['sectionid'] = $sectionID;
			$env['namespaceid'] = self::GetNamespaceIDBySectionID($sectionID);
			$env['regid']	= $section->Regions;

			$file = $CONFIG['engine_path']."modules/admin/".$section->Module.".php";
			if(is_file($file))
			{
				include_once($file);
				$cname = 'Mod_Admin_'.$section->Module;
				$module_config = self::GetAdminConfigById('section', $sectionID);
			}
			else
			{
				//Data::e_backtrace("Can't load admin module: '".$file."'; module='".$section['module']."'; sectionID='".$sectionID."'");
				//exit;
				$file = $CONFIG['engine_path']."modules/admin/_oldschool.php";
				include_once($file);
				$params['module'] = $section->Module;
				$cname = 'Mod_Admin__OldSchool';
				$module_config = array();
			}

			self::$aobjs[$sectionID] = new $cname();
			self::$aobjs[$sectionID]->Env = $env;
			self::$objs[$sectionID]->Config = $module_config;

			self::$aobjs[$sectionID]->Init($params);
		}
		return self::$aobjs[$sectionID];
	}

	static function GetAdminConfigById($type, $sectionID)
	{
		global $CONFIG, $ERROR;

		if(!isset(self::$aconfig[$type][$sectionID]))
		{
			if($type == 'section')
			{
				$section = STreeMgr::GetNodeByID($sectionID);
				$file = $CONFIG['engine_path']."configure/modules/admin/".$section->Module.".php";
				if(is_file($file))
					self::$aconfig[$type][$sectionID] = include $file;
				else
				{
					Data::e_backtrace("Can't load admin config: '".$file."'; module='".$section->Module."'; sectionID='".$sectionID."'");
					exit;
				}
			}
		}
		return self::$aconfig[$type][$sectionID];
	}

	static function GetInstance($sectionID, $params = array())
	{
		global $CONFIG, $ERROR, $OBJECTS;

		if(!isset(self::$objs[$sectionID]))
		{
			$section = STreeMgr::GetNodeByID($sectionID);

			$env['section'] = ModuleFactory::GetLinkBySectionId($sectionID, $params, false);
			$env['sectionid'] = $sectionID;
			$env['namespaceid'] = self::GetNamespaceIDBySectionID($sectionID);

			$namespace = STreeMgr::GetNodeByID($env['namespaceid']);
			if($namespace === null)
			{
				Data::e_backtrace("Can't load namespace handler for section: ".$sectionID);
				return null;
			}

			$env['namespace'] = self::GetNamespaceBySectionId($env['namespaceid'], $params);

			$node_ns = STreeMgr::GetNodeById($env['namespaceid']);
			if ($node_ns->Module == 'global' || $node_ns->Module == 'user')
				$env['regid']	= $CONFIG['env']['regid'];
			else
				$env['regid']	= $section->Regions;

			$env['site']	= self::GetConfigById('site', $section['parent']);

			$module_config = self::GetConfigById('section', $sectionID);

			if($module_config['basemodule'] != '')
			{
				$file = $CONFIG['engine_path']."modules/".$module_config['basemodule'].".php";
				if(is_file($file))
					include_once($file);
				else
				{
					Data::e_backtrace("Can't load basemodule: '".$file."'; basemodule='".$module_config['basemodule']."'; sectionID='".$sectionID."'");
					exit;
				}
			}
			$file = $CONFIG['engine_path']."modules/".$module_config['module'].".php";
			if(is_file($file))
				include_once($file);
			else
			{
				Data::e_backtrace("Can't load module: '".$file."'; module='".$module_config['module']."'; sectionID='".$sectionID."'");
				exit;
			}

			if ($section->HeaderTitle != "")
				$OBJECTS["title"]->AppendBefore($section->HeaderTitle);
			
			if ($section->HeaderKeywords != "")
				$OBJECTS["title"]->AppendBefore($section->HeaderKeywords, Title::$TO_KEYWORDS);
			if ($section->HeaderDescription != "")
				$OBJECTS["title"]->AppendBefore($section->HeaderDescription, Title::$TO_DESCRIPTION);
			LibFactory::GetStatic('decorator_space');

			$cname = 'Mod_'.$module_config['module'];
			self::$objs[$sectionID] = new $cname();

			if(isset($module_config['space']))
			{
				self::$objs[$sectionID] = new DecoratorSpace(self::$objs[$sectionID], $module_config['space'], $params);
			}

			self::$objs[$sectionID]->Env = $env;
			self::$objs[$sectionID]->Config = $module_config;

			self::$objs[$sectionID]->Init($params);
		}
		return self::$objs[$sectionID];
	}

	static function ClearConfigCache($type = null)
	{
		if($type == 'section')
		{
			self::$config['section'] = array();
			return true;
		}
		if($type == 'module_site')
		{
			self::$config['module_site'] = array();
			return true;
		}
		if($type == 'module_engine')
		{
			self::$config['module_engine'] = array();
			return true;
		}

		self::$config = array();
		return true;
	}

	static function LoadConfig($type = "", $params, $v1 = false)
	{
		global $CONFIG, $ERROR;

		if($type == "section" && $params['section'] != 0)
		{
			$section = STreeMgr::GetNodeByID($params['section']);
			$name = urlencode($section->Path);
			$file = $section->Parent->OldSitePath."/configure/sections/".$name.".php";
			if(is_file($file))
				self::$config['section'][$params['section']] = ConfigFactory::GetConfig($file);
			else
				Data::e_backtrace("Can't load config: '".$file."'; sectionID='".$params['section']."'");
		}
		else if($type == "module_site" && $params['site'] != 0 && $params['module'] != "")
		{
			$file = STreeMgr::GetNodeByID($params['site'])->OldSitePath."/configure/modules/".$params['module'].".php";
			if(is_file($file))
				self::$config['module_site'][$params['module']][$params['site']] = ConfigFactory::GetConfig($file);
			else
				Data::e_backtrace("Can't load config: '".$file."'; siteID='".$params['site']."'; Module='".$params['module']."'");
		}
		else if($type == "module_engine" && $params['module'] != "")
		{
			$file = $CONFIG['engine_path']."configure/modules/".$params['module'].".php";
			if(is_file($file))
				self::$config['module_engine'][$params['module']] = ConfigFactory::GetConfig($file);
			else
				Data::e_backtrace("Can't load config: '".$file."'; Module='".$params['module']."'");
		}
		elseif($type == "site" && $params['site'] != 0 && STreeMgr::GetNodeByID($params['site'])->Type == 1)
		{
			LibFactory::GetStatic('bl');
			$bl = BLFactory::GetInstance('system/env');
			self::$config['site'][$params['site']] = $bl->GetEnvForSection($params['site']);

			if(empty(self::$config['site'][$params['site']]) && $v1===true)
			{
				self::$config['site'][$params['site']]['company'] =& $CONFIG['smarty']['company'];
				self::$config['site'][$params['site']]['rambler_id'] =& $CONFIG['smarty']['rambler_id'] ? $CONFIG['smarty']['rambler_id'] : $CONFIG['smarty']['rambid'];
				self::$config['site'][$params['site']]['title'] =& $CONFIG['smarty']['title'];
				self::$config['site'][$params['site']]['cache_mode'] =& $CONFIG['cache_mode'];
				self::$config['site'][$params['site']]['timeoffset'] =& $CONFIG['timeoffset'];
			}

			// добавим title еще
			$site = STreeMgr::GetNodeByID($params['site']);
			foreach($site->Children as $k => $v)
			{
				self::$config['site'][$params['site']]['title'][$v['path']] = $v->Name;
			}
		}
	}

	// old style. deprecated.
	// остается тут
	static function GetConfig($type = "", $site = "", $section = "")
	{
		global $CONFIG;

		if($type == 'site')
		{
			return self::GetConfigById($type, $site);
		}
		else if($type == 'section')
		{
			if( ($id = self::GetSectionId($site, $section) ) === false )
			{
				Data::e_backtrace("Section not found: (old)siteID='".$site."';section='".$section."'");
				return array();
			}
			return self::GetConfigById($type, $id);
		}
		else
			return array();
	}

	static function GetConfigById($type = "", $id = 0)
	{
		global $CONFIG;

		$node = STreeMgr::GetNodeByID($id);
		if($node === null)
		{
			Data::e_backtrace("Section not found; sectionID='".$id."'");
			return array();
		}

		LibFactory::GetStatic('bl');
		if ( $type === 'site' )
		{
			$bl = BLFactory::GetInstance('system/env');
			$env = Data::array_merge_recursive_changed(
				$bl->GetEnvForSection($id),
				array('tree_id' => $id)
			);

			// для работы с тайтлами, надо убирать в модулях такую работу, а брать с дерева
			//$site = STreeMgr::GetNodeByID($id);
			//foreach($site->Children as $k => $v)
			//{
			//	$env['title'][$v->Path] = $v->Name;
			//}

			return $env;
		}
		else
		{
			$bl = BLFactory::GetInstance('system/config');
			return $bl->GetConfigForSection($id);
		}
		return array();
	}

	static function GetSectionId($site = 0, $section = "")
	{
		global $CONFIG;

		$sid = STreeMgr::GetSectionIDByTreePath($site, $section, true);
		if( $sid !== null )
			return $sid;
		else
		{
			Data::e_backtrace("Can't find sectionid; (old)siteID='".$site."'; section='".$section."'");
			return false;
		}
	}

	static public function Token($url, $delimiter = '/')
	{
		$pos = strpos($url, $delimiter);
		if($pos === false)
			return array($url, '');

		return array(substr($url, 0, $pos), substr($url, $pos + 1));
	}

	static function GetNamespaceIDByLink($url)
	{
		return STreeMgr::GetNamespaceIDByLink($url);
	}

	static function GetNamespaceIDByPath($path)
	{
		return STreeMgr::GetNamespaceIDByPath($path);
	}

	static function GetNamespaceBySectionID($id, $params = array())
	{
		return STreeMgr::GetNamespaceBySectionID($id, $params);
	}

	static function GetNamespaceIDBySectionID($id)
	{
		return STreeMgr::GetNamespaceIDBySectionID($id);
	}

	static function GetSectionIDByLink($url)
	{
		return STreeMgr::GetSectionIDByLink($url);
	}

	static function GetSectionInfoByLink($url)
	{
		return STreeMgr::GetSectionInfoByLink($url);
	}

	static function GetSectionIDByPath($site, $path)
	{
		return STreeMgr::GetSectionIDByPath($site, $path);
	}

	static function GetSectionInfoByPath($site, $path)
	{
		return STreeMgr::GetSectionInfoByPath($site, $path);
	}

	static function GetLinkBySectionId($sectionid = 0, $params = array(), $withdomain = true)
	{	
		return STreeMgr::GetLinkBySectionId($sectionid, $params, $withdomain);
	}

	static function GetBlock($type, $sectionid, $name, $template = null, $lifetime = 0, $params = array())
	{
		global $CONFIG, $OBJECTS;

		$__block = "";
		if(!isset($params))
			$params = array();
		if(!isset($params['cache']))
			$params['cache'] = false;
		if($params['cache'])
			$params['cache'] = true;
		else
			$params['cache'] = false;

		$oldsectionid = $OBJECTS['user']->SectionID;
		switch($type)
		{
			case 'this':
				
				if( self::IsSectionAllow(self::$module_action->Env['sectionid']) !== true ){
					$__block = "";
				}
				else
				{
					
					$OBJECTS['user']->SectionID = self::$module_action->Env['sectionid'];					
					$__block = self::$module_action->GetBlock($name, $template, $lifetime, $params);
				}
				break;
			case 'block':
				if( self::IsSectionAllow($sectionid) !== true ){
					$__block = "";
				}
				else
				{
					$OBJECTS['user']->SectionID = $sectionid;
					$OBJECTS['log']->SetSectionID($sectionid);
					$m = ModuleFactory::GetInstance($sectionid, $params);
					if($m === null)
						$__block = '';
					else
					{
						$__block = $m->GetBlock($name, $template, $lifetime, $params);
					}
				}
				break;
			case 'engine_block':
				
				$__block = Blocks::GetBlock($name, $template, $lifetime, $params);
				break;
			case 'widget':
				
				if($params['method'] == 'ssi') {
					LibFactory::GetStatic('container');
					$__block = Container::GetWidgetInstance($name, null, $params, Container::SSI);
				}
				elseif($v['params']['method'] != 'sync')
				{
					LibFactory::GetStatic('container');
					$__block = Container::GetWidgetInstance($name, null, $params);
				}
				else
				{
					LibFactory::GetStatic('container');
					$__block = Container::GetWidgetInstance($name, null, $params, Container::HTML);
				}
				break;
		}

		$OBJECTS['user']->SectionID = $oldsectionid;

		
		return $__block;
	}

	/**
	 * Разрешено ли смотреть раздел
	 */
	static public function IsSectionAllow($sectionid)
	{
		global $OBJECTS, $CONFIG;

		$node = STreeMgr::GetNodeByID($sectionid);
		if( $node === null || $node->IsRestricted == false)
			return true;

		$oldsectionid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $sectionid;
		$OBJECTS['log']->SetSectionID($sectionid);
		$val = false;
		if(	$OBJECTS['user']->IsInRole('e_execute_section') === true )
			$val = true;
		$OBJECTS['user']->SectionID = $oldsectionid;
		$OBJECTS['log']->SetSectionID($oldsectionid);

		return $val;
	}
}



// базовый класс модуля
abstract class AModule
{
	private $_name;
	protected $_page = '';
	protected $_env;		    // окружение
	protected $_config;			// конфигурация раздела
	protected $_module_caching = false;
	protected $_linked = false;

	// 2do: убрать и проверки тоже
	protected $_remove_env = true;

	public function __construct($name = '')
	{
		$this->_name = $name;
	}

	// инициализация
	abstract function Init();

	// обработка действий
	abstract function Action($params);

	/**
	 * Метод генерирует блоки модуля
	 * Порядок:
	 * 1. устанавливаем переменные окружения
	 * 2. генерируем блок
	 * 2.1. main блок генерится здесь
	 * 2.2. остальные блоки генерирются методом GetCustomBlock
	 * 3. убираем переменные окружения
	 *
	 * 2do: сделать его final
	 */
	public function GetBlock($block, $template, $lifetime, $params)
	{
		global $OBJECTS, $CONFIG;

		$result = null;
		//$OBJECTS['user']->SectionID = $this->_section;

		if(is_object($OBJECTS['smarty']))
		{
			$OBJECTS['smarty']->assign_by_ref('ENV', $this->_env);
			$OBJECTS['smarty']->assign_by_ref('CONFIG', $this->_config);
		}
		App::SetEnv($this->_env);
		App::SetModuleConfig($this->_config);

		if( $block=="main" )
		{
			if(is_array($this->_config['scripts']))
				$OBJECTS['title']->AddScripts($this->_config['scripts']);
			if(is_array($this->_config['styles']))
				$OBJECTS['title']->AddStyles($this->_config['styles']);
			$OBJECTS['smarty']->assign_by_ref('TEMPLATE', $this->_config['templates']);
			if(
				(isset($params['module_caching']) && $params['module_caching'] === true)
			||  (isset($this->_module_caching) && $this->_module_caching === true)
			)
			{
				$result = $this->_ActionGet();
			}
			else
			{
				if(!isset($template) || $template == "")
					$template = $this->_config['templates']['ssections'][$this->_page];
				$result = $this->RenderBlock(
					$template,
					array(),
					array($this, '_ActionGet'),
					null,
					null,
					null,
					'page'
				);
			}
		}
		else
		{
			$result = $this->GetCustomBlock($block, $template, $lifetime, $params);
		}

		//2do: доразабраться, почему не App::RemoveModuleConfig(); удаляет исходную переменную (Issue 1655)
		if( $this->_remove_env  )
		{
			if(is_object($OBJECTS['smarty']))
			{
				$OBJECTS['smarty']->clear_assign(array('ENV', 'CONFIG'));
			}
			App::RemoveEnv();
			App::RemoveModuleConfig();
		}

		return $result === null ? "" : $result;
	}

	/**
	 * Метод генерирует кастомные блоки модуля
	 * Этот метод можно переопределить в конкретном модуле
	 */
	protected function GetCustomBlock($block, $template, $lifetime, $params)
	{
		global $CONFIG, $OBJECTS;

		return null;
	}

	/**
	 * Рендеринг блока
	 * @param string шаблон
	 * @param array параметры
	 * @param array callback функция для получения данных
	 * @param bool кэшировать или нет
	 * @param int время жизни кэша
	 * @param string идентификатор кэша
	 * @return string html код блока
	 */
	protected function RenderBlock($template, $params, $callback, $iscache = false, $lifetime = 60, $cacheid = null, $res_var = 'res')
	{
		global $OBJECTS, $CONFIG;
		if($callback !== null)
			if(is_callable($callback, false, $cname) === false)
			{
				Data::e_backtrace('Method '.$cname.' not found');
				return '';
			}
/*
		надо это вернуть, но для этого надо сначала добавить метод в Action, который будет обрабатывать состояния без шаблонов
		if($OBJECTS['smarty']->is_template($template)===false)
		{
			Data::e_backtrace("Template not found: ".$template);
			return "";
		}
*/
		if($iscache === true)
		{
			if(!$OBJECTS['smarty']->is_cached($template, $cacheid))
			{
				$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func($callback, (array)$params));
			}
			$OBJECTS['smarty']->cache_lifetime = $lifetime;
			return $OBJECTS['smarty']->fetch($template, $cacheid);
		}
		else
		{
			$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func($callback, (array)$params));
			$OBJECTS['smarty']->caching = 0;
			$html = $OBJECTS['smarty']->fetch($template);
			$OBJECTS['smarty']->caching = $CONFIG['env']['site']['cache_mode'];
			return $html;
		}
		return "";
	}

	public function __get($name)
	{
		switch($name)
		{
			case 'Env':
				return $this->_env;
			case 'Config':
				return $this->_config;
			case 'Name':
				return $this->_name;
		}
	}

	public function __set($name, $value)
	{
		switch($name)
		{
			case 'Env':
				$this->_env = $value;
				break;
			case 'Config':
				$this->_config = $value;
				break;
		}
	}


	public function __isset($name)
	{
		switch($name)
		{
			case 'Env':
				return isset($this->_env);
			case 'Config':
				return isset($this->_config);
			case 'Name':
				return isset($this->_name);
		}
	}


	public function __unset($name)
	{
		switch($name)
		{
			case 'Env':
				unset($this->_env);
				break;
			case 'Config':
				unset($this->_config);
				break;
		}
	}

}

// базовый класс многофайлового модуля
abstract class AMultiFileModule_Magic
{
	private $_name;
	protected $_env;		    // окружение
	protected $_config;			// конфигурация раздела
	protected $_page;
	protected $_params = array();
	protected $_module_caching = false;
	protected $_linked = false;

	// 2do: убрать и проверки тоже
	protected $_remove_env = true;

	public function __construct($name = '')
	{
		$this->_name = $name;
	}

	// инициализация
	abstract function Init();

	// обработка действий
	public function Action($params)
	{
		global $OBJECTS;

		if ( is_object($OBJECTS['smarty']) ) {
			$OBJECTS['smarty']->assign_by_ref('TEMPLATE', $this->_config['templates']);
			$OBJECTS['smarty']->assign_by_ref('ENV', $this->_env);
			$OBJECTS['smarty']->assign_by_ref('CONFIG', $this->_config);
		}
		
		App::SetEnv($this->_env);
		App::SetModuleConfig($this->_config);

		if($this->_linked === false)
			$this->_ActionModRewrite($params);
		$result = $this->_ActionPost();

		if( $this->_remove_env  )
		{
			if ( is_object($OBJECTS['smarty']) ) {
				// 2do: перенести информацию о шаблоне в окружение раздела (с возможностью наследования от сайта)
				//$OBJECTS['smarty']->assign_by_ref('TEMPLATE', $this->_config['templates']); - убирать нельзя, т.к. этим пользуется движок когда рендерит главный шаблон
				$OBJECTS['smarty']->assign_by_ref('ENV', $this->_env);
				$OBJECTS['smarty']->assign_by_ref('CONFIG', $this->_config);
			}
			App::RemoveEnv($this->_env);
			App::RemoveModuleConfig($this->_config);
		}

		return $result;
	}

	// разборка строки запроса и установка состояния
	protected function _ActionModRewrite(&$params)
	{
		// разбиваем строку с параметрами и анализируем
		if(is_array($this->_config['files']['get']))
		{
			foreach($this->_config['files']['get'] as $k=>$v)
			{
				if(isset($v['string']))
				{
					if($v['string'] == $params)
					{
						$this->_page = $k;
						break;
					}
				}
				else if (isset($v['regexp']))
				{
					if(preg_match($v['regexp'], $params, $matches))
					{
						$this->_page = $k;
						if(count($v['matches']) > 0)
							foreach($v['matches'] as $mk=>$mv)
								$this->_params[$mv] = $matches[$mk];
						break;
					}
				}
			}
		}

		$this->_env['section_page'] = $this->_page;

		if($this->_page == "")
			exit();
	}

	// обработка запросов POST
	protected function _ActionPost()
	{
		global $OBJECTS, $CONFIG;

		if(!isset($this->_config['files']['post'][$_POST['action']]))
			return false;

		if( is_file($CONFIG['engine_path']."modules/".$this->_config['files']['post'][$_POST['action']]['file']) )
			$file = $CONFIG['engine_path']."modules/".$this->_config['files']['post'][$_POST['action']]['file'];
		else if ( is_file($CONFIG['engine_path']."modules/".$this->_name."/post_".$_POST['action'].".php") )
			$file = $CONFIG['engine_path']."modules/".$this->_name."/post_".$_POST['action'].".php";
		else
		{
			Data::e_backtrace("Method POST:".$_POST['action']." not found in class ".__CLASS__);
			return false;
		}
		include($file);
		return true;
	}

	// обработка запросов GET
	protected function _ActionGet()
	{
		global $OBJECTS, $CONFIG;

		if( is_file($CONFIG['engine_path']."modules/".$this->_config['files']['get'][$this->_page]['file']) )
			$file = $CONFIG['engine_path']."modules/".$this->_config['files']['get'][$this->_page]['file'];
		else if ( is_file($CONFIG['engine_path']."modules/".$this->_name."/get_".$this->_page.".php") )
			$file = $CONFIG['engine_path']."modules/".$this->_name."/get_".$this->_page.".php";
		else
		{
			Data::e_backtrace("Method GET:".$this->_page." not found in class ".__CLASS__." Module: ".$this->_name);
			header("HTTP/1.0 404 Not Found");
			exit();
		}
		return include($file);
	}

	/**
	 * Метод генерирует блоки модуля
	 * Порядок:
	 * 1. устанавливаем переменные окружения
	 * 2. генерируем блок
	 * 2.1. main блок генерится здесь
	 * 2.2. остальные блоки генерирются методом GetCustomBlock
	 * 3. убираем переменные окружения
	 *
	 * 2do: сделать его final
	 */
	public function GetBlock($block, $template, $lifetime, $params)
	{
		global $CONFIG, $OBJECTS;

		$result = null;

		if(is_object($OBJECTS['smarty']))
		{
			$OBJECTS['smarty']->assign_by_ref('ENV', $this->_env);
			$OBJECTS['smarty']->assign_by_ref('CONFIG', $this->_config);
		}
		App::SetEnv($this->_env);
		App::SetModuleConfig($this->_config);

		if( $block=="main" )
		{
			if(is_array($this->_config['scripts']))
				$OBJECTS['title']->AddScripts($this->_config['scripts']);

			if(is_array($this->_config['styles']))
				$OBJECTS['title']->AddStyles($this->_config['styles']);
			$OBJECTS['smarty']->assign_by_ref('TEMPLATE', $this->_config['templates']);

			if(
				(isset($params['module_caching']) && $params['module_caching'] === true)
			||  (isset($this->_module_caching) && $this->_module_caching === true)
			)
			{
				$result = $this->_ActionGet();
			}
			else
			{
				if(!isset($template) || $template == "")
				{
					$template = $this->_config['templates']['ssections'][$this->_page];
				}
				$result = $this->RenderBlock(
					$template,
					array(),
					array($this, '_ActionGet'),
					null,
					null,
					null,
					'page'
				);
			}
		}
		else
		{
			$result = $this->GetCustomBlock($block, $template, $lifetime, $params);
		}

		//2do: доразабраться, почему не App::RemoveModuleConfig(); удаляет исходную переменную (Issue 1655)
		if( $this->_remove_env  )
		{
			if(is_object($OBJECTS['smarty']))
			{
				$OBJECTS['smarty']->clear_assign(array('ENV', 'CONFIG'));
			}
			App::RemoveEnv();
			App::RemoveModuleConfig();
		}

		return $result === null ? "" : $result;
	}

	/**
	 * Метод генерирует кастомные блоки модуля
	 * Этот метод можно переопределить в конкретном модуле
	 */
	protected function GetCustomBlock($block, $template, $lifetime, $params)
	{
		global $CONFIG, $OBJECTS;

		$result = null;

		if( is_file($CONFIG['engine_path']."modules/".$this->_config['files']['block'][$block]['file']) )
		{
			$file = $CONFIG['engine_path']."modules/".$this->_config['files']['block'][$block]['file'];
		}
		else if ( is_file($CONFIG['engine_path']."modules/".$this->_name."/block_".$block.".php") )
		{
			$file = $CONFIG['engine_path']."modules/".$this->_name."/block_".$block.".php";
		}
		else
		{
			Data::e_backtrace("Block ".$block." not found in class ".__CLASS__);
			$result = "";
		}
		if( $result === null )
			$result = include($file);

		return $result;
	}

	/**
	 * Рендеринг блока
	 * @param string шаблон
	 * @param array параметры
	 * @param array callback функция для получения данных
	 * @param bool кэшировать или нет
	 * @param int время жизни кэша
	 * @param string идентификатор кэша
	 * @return string html код блока
	 */
	protected function RenderBlock($template, $params, $callback, $iscache = false, $lifetime = 60, $cacheid = null, $res_var = 'res')
	{
		global $OBJECTS, $CONFIG;
		if($callback !== null)
			if(is_callable($callback, false, $cname) === false)
			{
				Data::e_backtrace('Method '.$cname.' not found');
				return '';
			}
/*
		надо это вернуть, но для этого надо сначала добавить метод в Action, который будет обрабатывать состояния без шаблонов
		if($OBJECTS['smarty']->is_template($template)===false)
		{
			Data::e_backtrace("Template not found: ".$template);
			return "";
		}
*/
		
		if($iscache === true)
		{
			if(!$OBJECTS['smarty']->is_cached($template, $cacheid))
				$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func_array($callback, (array)$params));
			$OBJECTS['smarty']->cache_lifetime = $lifetime;
			return $OBJECTS['smarty']->fetch($template, $cacheid);
		}
		else
		{
			$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func_array($callback, (array)$params));
			$OBJECTS['smarty']->caching = 0;
			$html = $OBJECTS['smarty']->fetch($template);
			$OBJECTS['smarty']->caching = $CONFIG['env']['site']['cache_mode'];
			return $html;
		}
		return "";
	}

	// внутренний редирект, сейчас реально использовать только из обработчика поста
	public function SetState($state)
	{
		$this->_page = $state;
	}

	public function &__get($name)
	{
		switch($name)
		{
			case 'Env':
				return $this->_env;
			case 'Config':
				return $this->_config;
			case 'Name':
				return $this->_name;
		}
	}

	public function __set($name, $value)
	{
		switch($name)
		{
			case 'Env':		
					
				$this->_env = $value;
				break;
			case 'Config':
				$this->_config = $value;
				break;
		}
	}

	public function __isset($name)
	{
		switch($name)
		{
			case 'Env':
				return isset($this->_env);
			case 'Config':
				return isset($this->_config);
			case 'Name':
				return isset($this->_name);
		}
	}

	public function __unset($name)
	{
		switch($name)
		{
			case 'Env':
				unset($this->_env);
				break;
			case 'Config':
				unset($this->_config);
				break;
		}
	}

	public function __call($name, $params)
	{
		global $CONFIG, $OBJECTS;
		$name = strtolower($name);
		if( is_file($CONFIG['engine_path']."modules/".$this->_config['files']['functions'][$name]['file']) )
			$file = $CONFIG['engine_path']."modules/".$this->_config['files']['functions'][$name]['file'];
		else if ( is_file($CONFIG['engine_path']."modules/".$this->_name."/f_".$name.".php") )
			$file = $CONFIG['engine_path']."modules/".$this->_name."/f_".$name.".php";
		else
		{
			Data::e_backtrace("Method ".$name." not found in class ".__CLASS__);
			return null;
		}
		return include($file);
	}

}

