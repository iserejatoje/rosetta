<?

interface IAppCompareProvider
{
	public function Compare($value1, $value2);
}

interface IApplication
{
	public function AppInit($params);
	public function Run($params);
	public function Dispose();
}

interface IComponent
{
	public function &GetPropertyByRef($name);
	public function SetPropertyByRef($name, &$value);

	public function ActionModRewrite(&$params);
	public function ActionPost();
	public function ActionGet();
}

class ApplicationMgr
{
	static private $comparers = array();
	static function GetCompareProvider($name)
	{
		global $CONFIG;
		if(!isset(self::$comparers[$name]))
		{
			$cname = 'AppCompareProvider_'.$name;
			if(class_exists($cname))
			{
				self::$comparers[$name] = new $cname;
            }
			else
			{
				$name = $CONFIG['engine_path'].'include/application/cp.'.$name.'.php';
				if(is_file($name))
				{
					include_once $name;
					self::$comparers[$name] = new $cname;
				}
				else
					self::$comparers[$name] = new AppCompareProviderEmpty();
			}
		}
		return self::$comparers[$name];
    }

	private static $objs = array();
	static function GetInstance($name, $folder = null, $params = array())
	{
		global $CONFIG;
		if($folder === null)
		{
			$p = strrpos($name, '/');
			if($p === false)
				return null;

			$folder = substr($name, 0, $p);
			$name = substr($name, $p + 1);
        }

		if(!isset(self::$objs[$folder][$name]))
		{
			$env['regid']	= $CONFIG['env']['regid'];
			$env['site']	= $CONFIG['env']['site'];
			$env['section'] = $CONFIG['env']['section'];

			$config = self::GetConfig($name, $folder);

			if($config['basemodule'] != '')
			{
				$file = $CONFIG['engine_path']."modules/".$config['basemodule'].".php";
				if(is_file($file))
					include_once($file);
				else
				{
					Data::e_backtrace("Can't load baseapplication: '".$file."'; basemodule='".$config['basemodule']."'; name='".$name."'; folder='".$folder."'");
					exit;
				}
			}

			$file = $CONFIG['engine_path']."modules/".$config['module'].".php";
			if(is_file($file))
				include_once($file);
			else
			{
				Data::e_backtrace("Can't load application: '".$file."'; module='".$config['module']."'; name='".$name."'; folder='".$folder."'");
				exit;
			}

			$cname = 'Mod_'.$config['module'];
			if(isset($config['space']))
			{
				LibFactory::GetStatic('decorator_space');
				self::$objs[$folder][$name] = new DecoratorSpace(new $cname(), $config['space'], array(
					'path' => $folder,
					'name' => $name));
			}
			elseif(isset($config['sectionid']))
			{
				LibFactory::GetStatic('decorator_sid');
				self::$objs[$folder][$name] = new DecoratorSID(new $cname(), $config['sectionid']);
			}
			else
				self::$objs[$folder][$name] = new $cname();
			self::$objs[$folder][$name]->Folder = $folder;
			self::$objs[$folder][$name]->Name = $name;
			self::$objs[$folder][$name]->Env = $env;
			self::$objs[$folder][$name]->Config = $config;
			self::$objs[$folder][$name]->IsApplication = true;
			self::$objs[$folder][$name]->AppInit($params);
		}

		return self::$objs[$folder][$name];
    }

	static private $configs = array();
	static function GetConfig($name, $folder)
	{
		if(empty($name) || empty($folder))
			return array();

		if(!isset(self::$configs['app'][$folder.'/'.$name]))
			self::$configs['app'][$folder.'/'.$name] = self::LoadConfig('app', $name, $folder);

		return self::$configs['app'][$folder.'/'.$name];
    }

	private static function LoadConfig($type, $name, $folder)
	{
		global $CONFIG, $ERROR;
		$config = array();

		if($type == 'app')
		{
			$path = $CONFIG['engine_path'].'configure/applications/'.$folder.'/'.$name.'.php';

			if(is_file($path))
				$config = include $path;
			else
				$config = array();
        }

		if($type == 'base' || $type == 'app')
		{
			$path = $CONFIG['engine_path'].'configure/applications/'.$config['module'].'.php';
			if(is_file($path))
				$config_base = include $path;
			else
				$config_base = array();

			$config = Data::array_merge_recursive_changed($config_base, $config);
        }

		return $config;
    }
}

abstract class ApplicationBaseMagic extends AMultiFileModule_Magic implements IApplication, IComponent
{
	public $IsApplication = false;
	protected $RoleKey = ''; // ключ ролей, если нужно выдавать роли конкретнее для привязанных приложений, необходимо установить свойство
	public $Folder = '';
	
//	public $Name = '';
	
	//public function AppInit($params);
	public function AppInitAfterLinked($params = array()){}
	public function Run($params)
	{
		// обработка запроса
        $this->Action($params);
		// рендер страницы
		return $this->GetBlock('main', '', '', array());
    }

	public function Dispose(){}
	public function &GetPropertyByRef($name)
	{
		if($name == 'page')
			return $this->_page;
		elseif($name == 'rolekey')
			return $this->RoleKey;
		return null;
    }
	public function SetPropertyByRef($name, &$value){}

	public function ActionModRewrite(&$params)
	{
		$this->_ActionModRewrite($params);
		$this->PostModRewriteInit($this->_page);
    }

	public function ActionPost()
	{
		return $this->_ActionPost();
    }

	public function ActionGet()
	{
		return $this->_ActionGet();
    }

	public function Log($action, $commentid, $params = array())
	{
		global $OBJECTS, $CONFIG;

		$params = array_merge($params, array(
				'domain' => $CONFIG['env']['site']['domain'],
				'section' => $CONFIG['env']['section'],
			)
		);

		$oldid = $OBJECTS['log']->SetSectionID($this->_config['sectionid']);
		$OBJECTS['log']->Log(
			$action,
			$commentid,
			$params
			);
		$OBJECTS['log']->SetSectionID($oldid);
	}

}

class AppCompareProviderEmpty implements IAppCompareProvider
{
	public function Compare($value1, $value2)
	{
		return false;
    }
}

class AppCompareProvider_Equal
{
	public function Compare($value1, $value2)
	{
		return $value1 == $value2;
    }
}

class AppCompareProvider_NotEqual
{
	public function Compare($value1, $value2)
	{
		return $value1 != $value2;
    }
}

class AppCompareProvider_TypeEqual
{
	public function Compare($value1, $value2)
	{
		return $value1 === $value2;
    }
}

class AppCompareProvider_TypeNotEqual
{
	public function Compare($value1, $value2)
	{
		return $value1 !== $value2;
    }
}

class AppCompareProvider_Greater
{
	public function Compare($value1, $value2)
	{
		return $value1 > $value2;
    }
}

?>