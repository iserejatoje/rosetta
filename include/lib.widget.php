<?
class WidgetFactory
{
	static $counter = 1;
	/**
	 * создать обьект виджета
	 * @param string путь виджета (его имя)
	 * @param string состояние виджета (страница)
	 * @param int идентификатор виджета (используется только хенделером widget)
	 * @return IWidget виджет
	 */
	static function GetInstance($path, $state = null, $params = array(), $cid = 0, $isinit = false)
	{
		global $CONFIG, $OBJECTS;
		if($state === null) // все указано в пути, режем по последнему /
		{
			$pos = strrpos($path, '/');
			$state = substr($path, $pos+1);
			$path = substr($path, 0, $pos);
		}
		if(is_file($CONFIG['engine_path']."widgets/".$path.".php"))
		{
			include_once $CONFIG['engine_path']."widgets/".$path.".php";
			$class_name = 'Widget_'.str_replace('/','_',$path);

			if($cid > 0) // если пришел идентификатор, берем его
			{
				$obj = new $class_name($cid);
				// принудительно выставляем асинхронную отдачу контента
				$mode = IWidget::OUTPUT_ASYNC | IWidget::OUTPUT_JSON;
				if($isinit === true)
					$mode |= IWidget::OUTPUT_CONTAINER | IWidget::OUTPUT_INITDATA;
				$obj->SetOutputMode($mode);
			}
			else
				$obj = new $class_name(self::$counter++);

			LibFactory::GetStatic('decorator_space');
			$obj2 = new DecoratorSpace($obj, 'modules', array(
				'path' => $path,
				'name' => $state));
			$obj->SetDecorator($obj2);

			//$init = $obj2->Init($path, $state, $params);
			
			if($obj2->Init($path, $state, $params) === false)
				return null;
			return $obj2;
		}
		else
		{
			error_log("File '".$CONFIG['engine_path']."widgets/".$path.".php' not found.");
			Data::e_backtrace();
			exit;
		}
	}

	static public function GetState()
	{
		global $CONFIG, $OBJECTS;
		return array(
				'template_dir'	=> $OBJECTS['smarty']->template_dir,
				'compile_dir'	=> $OBJECTS['smarty']->compile_dir,
				'cache_dir'		=> $OBJECTS['smarty']->cache_dir,
				'caching'		=> $OBJECTS['smarty']->caching
				);
	}

	static public function SetWidgetState()
	{
		global $CONFIG, $OBJECTS;
		$OBJECTS['smarty']->caching			= 2;
	}

	static public function SetState($state)
	{
		global $CONFIG, $OBJECTS;
		$OBJECTS['smarty']->caching			= $state['caching'];
	}
}

abstract class IWidget implements IDisposable
{
	// действия про клике на заголовок
	const TITLE_CLOSE		= 1;	// свернуть
	const TITLE_CONFIGURE	= 2;	// настройки
	const TITLE_URL			= 3;	// перейти по урлу

	// режимы отдачи
	const OUTPUT_ASYNC		= 1;	// асинхронный режим, метод Run выводит в поток данные (default)
	const OUTPUT_SYNC		= 2;	// синхронный режим, метод Run возвращает данные
	const OUTPUT_SSI		= 4;	// SSI режим, метод Run возвращает данные + metadata
	// применяются только для OUTPUT_ASYNC
	const OUTPUT_JSON		= 8;	// отдача асинхронного контента в JSON формате (default)
	const OUTPUT_XML		= 16;	// отдача асинхронного контента в XML формате

	const OUTPUT_CONTAINER	= 32;	// отдавать с контейнером?
	const OUTPUT_INITDATA	= 64;	// отправить данные инициализации
	
	const TPL_PATH_PREFIX	= 'widgets/'; // префикс пути для шаблонов

	protected $state;				// состояние виджета
	protected $config = array();	// конфиг
	protected $path;				// url к виджету
	public $params = array();		// параметры
	protected $container;			// шаблон контейнера 2 уровня (заголовок)
	protected $title;				// заголовок
	protected $title_url;			// ссылка для заголовка
	protected $referer;				// страница с которой пришел запрос
	protected $outputMode;			// если установлен синхронный режим, метод Run будет возвращать код
	protected $id;					// идентификатор виджета на странице
	protected $rendered;			// отрендерено ли последнее состояние
	private $rawStates = array();	// состояния возвращающие данные в чистом виде
	protected $cancelOutput = false;// отмена вывода для текущего запроса
	private $decorator = null;		// объект декоратора DecoratorSpace
	protected $metadata = array();	// метаданные виджета (lifetime, tags, )

	public function __construct($id) // загружает свой конфиг
	{
		global $CONFIG, $OBJECTS;
		$this->id = $id;

		//$this->LoadConfig(имя);
		$this->LoadConfig('iwidget');
		$this->outputMode = self::OUTPUT_ASYNC | self::OUTPUT_JSON;
	}

	// функции инициализации
	final public function SetDecorator($decorator = null)
	{
		global $CONFIG, $OBJECTS;
		if($decorator !== null && is_a($decorator, 'DecoratorSpace'))
			$this->decorator = $decorator;
	}

	/**
	 * Инициализация виджета
	 * @param string/null состояние
	 */
	public function Init($path, $state = null, $params = array())
	{
		global $CONFIG, $OBJECTS;

		$this->path = $path;
		$this->params = $params;

		if($state !== null)
			$this->state = $state;
		else
			$this->state = 'default';

		$this->LoadConfig();

		if(isset($params['container']))
			$this->container = $params['container'];
		elseif(isset($this->config['templates']['overload']['container']))
			$this->container = $this->config['templates']['overload']['container'];
		elseif(!empty($CONFIG['env']['referer']['path']) && (strpos($CONFIG['env']['referer']['path'], '/passport') || strpos($CONFIG['env']['referer']['path'], '/user') === 0 || strpos($CONFIG['env']['referer']['path'], '/community') === 0))
			$this->container = $this->config['container']['template']['passport'];
		elseif(!empty($CONFIG['env']['section']) && (strpos($CONFIG['env']['section'], 'passport') === 0 || strpos($CONFIG['env']['section'], 'svoi') === 0 || strpos($CONFIG['env']['section'], 'user') === 0 || strpos($CONFIG['env']['section'], 'community') === 0))
			$this->container = $this->config['container']['template']['passport'];
		elseif(isset($this->config['container']['template'][$CONFIG['env']['referer']['host']]))
			$this->container = $this->config['container']['template'][$CONFIG['env']['referer']['host']];
		else
			$this->container = $this->config['container']['template']['default'];

	}

	/**
	 * Добавить JSON/XML состояние
	 * @param string состояние
	 */
	protected function AddRawState($state)
	{
		global $CONFIG, $OBJECTS;
		array_push($this->rawStates, $state);
	}

	/**
	 * Установка режима отдачи, сбрасывает противоположный флаг
	 * @param int режим отдачи данных
	 */
	public function SetOutputMode($mode, $reset = 0)
	{
		global $CONFIG, $OBJECTS;
		/*
		для особо осторожных
		$cnt = (($mode & self::OUTPUT_ASYNC) ? 1 : 0) +
		       (($mode & self::OUTPUT_SYNC) ? 1 : 0) +
			   (($mode & self::OUTPUT_SSI) ? 1 : 0);
		if ($cnt > 0) $mode = $mode & ~(self::OUTPUT_SYNC|self::OUTPUT_ASYNC|self::OUTPUT_SSI) | self::OUTPUT_SYNC;
		*/
		if(($mode & self::OUTPUT_ASYNC) || ($mode & self::OUTPUT_SYNC) || ($mode & self::OUTPUT_SSI))
			$this->outputMode = ($this->outputMode & ~(self::OUTPUT_SYNC|self::OUTPUT_ASYNC|self::OUTPUT_SSI)) | ($mode & (self::OUTPUT_SYNC|self::OUTPUT_ASYNC|self::OUTPUT_SSI));

		if(($mode & self::OUTPUT_JSON) || ($mode & self::OUTPUT_XML))
			$this->outputMode = ($this->outputMode & ~(self::OUTPUT_JSON|self::OUTPUT_XML)) | ($mode & (self::OUTPUT_JSON|self::OUTPUT_XML));

		if($mode & self::OUTPUT_CONTAINER)
			$this->outputMode |= self::OUTPUT_CONTAINER;
		elseif($reset & self::OUTPUT_CONTAINER)
			$this->outputMode &= ~self::OUTPUT_CONTAINER;

		if($mode & self::OUTPUT_INITDATA)
			$this->outputMode |= self::OUTPUT_INITDATA;
		elseif($reset & self::OUTPUT_INITDATA)
			$this->outputMode &= ~self::OUTPUT_INITDATA;
	}

	final public function IsRendered()
	{
		global $CONFIG, $OBJECTS;
		return $this->rendered;
	}

	// цикл работы
	final public function Run()
	{
		global $CONFIG, $OBJECTS;
		if(!$this->IsHandlerExists($this->state))
			$page = $this->OnNotFound();
		else
		{
			switch($this->state)
			{
				// описаны стандартные обработчики
				case 'configure': // шаблон конфигурации
					$page = $this->OnConfigure();
					break;
				case 'configureapply': // сохранение изменений
					App::$Request->Request['params']->Extract('Params');
					$page = $this->OnConfigureApply(App::$Request->Params);
					break;
				case 'togglevisible': // изменение отображения виджета
					$page = $this->OnToggleVisible(App::$Request->Request['widgetContainerShowed']->Value() == 'true');
					break;
				default:
					if( $this->IsShowed() || App::$Request->Request['widgetContainerShowed']->Value() == 'true')
					{
						$page = call_user_func(array($this, 'On'.$this->state));
						$this->rendered = true;
					}
					else
					{
						$page = '';
						$this->rendered = false;
					}
					break;
			}
		}

		if($page !== false)
			return $this->Send($page);
		else
			return '';
	}

	protected function Send($page)
	{
		global $CONFIG, $OBJECTS;
		if($this->outputMode & self::OUTPUT_SYNC)
		{
			return $this->SendRendered($page);
		}
		elseif($this->outputMode & self::OUTPUT_SSI)
		{
			return $this->SendSSI($page);
		}
		elseif($this->outputMode & self::OUTPUT_ASYNC)
		{
			//if(!is_array($page) && !$this->IsRawState($this->state))
			if($this->outputMode & self::OUTPUT_CONTAINER)
				$page = array('type' => 'html', 'content' => $this->SendRendered($page));
			elseif(!is_array($page) && !$this->IsRawState($this->state))
				$page = array('type' => 'html', 'content' => $page);
			if($this->outputMode & self::OUTPUT_INITDATA)
			{
				$page['showed'] = $this->IsShowed();
			}
			if($this->outputMode & self::OUTPUT_JSON)
				$this->SendJSON($page);
			elseif($this->outputMode & self::OUTPUT_XML)
				$this->SendXML($page);
		}
	}

	/**
	 * Отправка в формате JSON
	 * @param mixed данные
	 */
	protected function SendJSON($page)
	{
		global $CONFIG, $OBJECTS;
		echo $OBJECTS['json']->encode($page);
	}

	protected function SendXML($page)
	{
		global $CONFIG, $OBJECTS;
		//2do: не реальизовано, предположительный формат выдачи
		//array('one' => array(1,2,3), 'two');
		//<root>
		//  <one>
		//    <0>1</0>
		//    <1>2</1>
		//    <2>3</2>
		//  </one>
		//  <0>two</0>
		//</root>
	}

	protected function SendSSI($page)
	{
		global $CONFIG, $OBJECTS;
		
		$data = array();
		$data['content'] = $this->SendRendered($page);
		$data['metadata'] = $this->GetMetaData();
		
		return $data;
	}

	/**
	 * Рендеринг слоя заголовка
	 * @param string содержимое
	 */
	protected function SendRendered($page)
	{
		global $CONFIG, $OBJECTS;
		$OBJECTS['smarty']->assign('config', array_merge((array) $this->config, array(
						'is_closable' => $this->IsClosable(),
						'is_configurable' => $this->IsConfigurable(),
						'is_showed' => $this->IsShowed(),
						)));
		$OBJECTS['smarty']->assign('id', $this->id);
		$OBJECTS['smarty']->assign('title', $this->title);
		$OBJECTS['smarty']->assign('page', $page);

		$OBJECTS['smarty']->assign('widget', array(
					'init' => 'widget = widgetAPI.widgets['.$this->id.'];',
					'instance' => 'widgetAPI.widgets['.$this->id.']',
					));

		$caching = $OBJECTS['smarty']->caching;
		$OBJECTS['smarty']->caching = 0;

		$page = $OBJECTS['smarty']->fetch(IWidget::TPL_PATH_PREFIX.$this->container);
		$OBJECTS['smarty']->caching = $caching;
		$OBJECTS['smarty']->clear_assign(array('id', 'title', 'page', 'config'));
		return $page;
	}

	protected function IsCached()
	{
		global $CONFIG, $OBJECTS;
	}

	/**
	 * рендеринг шаблона
	 * @param string шаблон
	 * @param mixed данные
	 * @return string html код
	 */
	protected function Render($template, $params = array(), $callback = null, $iscache = false, $lifetime = 60, $cacheid = null, $res_var = 'res')
	{
		global $CONFIG, $OBJECTS;

		if($callback !== null)
			if(is_callable($callback, false, $cname) === false)
			{
				Data::e_backtrace('Method '.$cname.' not found');
				return '';
			}

		if($iscache === true)
		{
			if(!$OBJECTS['smarty']->is_cached($template, $cacheid))
			{
				$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func($callback, (array)$params));
				$OBJECTS['smarty']->assign('config', $this->config);
				$OBJECTS['smarty']->assign('id', $this->id);
				$OBJECTS['smarty']->assign('widget', array(
							'init' => 'widget = widgetAPI.widgets['.$this->id.'];',
							'instance' => 'widgetAPI.widgets['.$this->id.']',
							));
			}
			$OBJECTS['smarty']->cache_lifetime = $lifetime;
			$page = $OBJECTS['smarty']->fetch(IWidget::TPL_PATH_PREFIX.$template, $cacheid);
		}
		else
		{	
			$OBJECTS['smarty']->assign('config', $this->config);
			$OBJECTS['smarty']->assign('id', $this->id);
			$OBJECTS['smarty']->assign('widget', array(
						'init' => 'widget = widgetAPI.widgets['.$this->id.'];',
						'instance' => 'widgetAPI.widgets['.$this->id.']',
						));
			$OBJECTS['smarty']->assign($res_var, $callback===null?$params:call_user_func($callback, (array)$params));
			$caching = $OBJECTS['smarty']->caching;
			$OBJECTS['smarty']->caching = 0;
			
			$page = $OBJECTS['smarty']->fetch(IWidget::TPL_PATH_PREFIX.$template);
			$OBJECTS['smarty']->caching = $caching;
		}

		$OBJECTS['smarty']->clear_assign('res');
		return $page;
	}

	/**
	 * Рендеринг формы настроек, отдача AJAX
	 */
	protected function SendConfigure()
	{
		global $CONFIG, $OBJECTS;
		if($this->IsConfigurable())
		{
			$this->Send($this->OnConfigure());
		}
	}

	protected function GetStateUrl($state)
	{
		global $CONFIG, $OBJECTS;
		return "http://".
			$CONFIG['env']['referer']['host'].
			"/service/widget/".
			$this->path.'/'.
			$state.'.php';
	}

	/**
	 * сгенерировать команду для вызова состояния
	 * @param string состояние
	 * @param mixed параметры
	 */
	protected function GetStateJS($state, $params)
	{
		global $CONFIG, $OBJECTS;
		//widgetAPI.handle('state', {param:1});
		return "widgetAPI.handle('".$state."',".$OBJECTS['json']->encode($params).")";
	}

	final protected function ID()
	{
		return $this->id;
	}

	protected function IsRawState($state)
	{
		global $CONFIG, $OBJECTS;
		return in_array($state, $this->rawStates);
	}

	/**
	 * Есть ли обработчик состояния
	 * @return bool
	 */
	final protected function IsHandlerExists($name)
	{
		return is_callable(array($this, 'On'.$name));
	}

	/**
	 * установка урла к виджету
	 * @param string url к виджету
	 */
	protected function SetPath($name)
	{
		$this->path = $path;
	}

	/**
	 * Добавить доступный параметр для передачи от клиента
	 * @params string name имя параметра
	 */
	public function AddField($name)
	{
		if(!isset($this->params[$name]))
			$this->params[$name] = '';
	}

	static $_config_cache = array();
	/**
	 * загрузка конфига, дополняет загруженный, при совпадении ключей переписывает
	 * @param string конфиг
	 */
	protected function LoadConfig($name = null)
	{
		global $CONFIG, $OBJECTS;

		if($name === null)
			$name = $this->path;
		if($name === null)
			return;

		if(isset(self::$_config_cache[$name]))
		{
			$this->config = Data::array_merge_recursive_changed($this->config, self::$_config_cache[$name]);
			return;
		}

		if(is_file($CONFIG['engine_path'].'configure/widgets/'.$name.'.php'))
			self::$_config_cache[$name] = include_once $CONFIG['engine_path'].'configure/widgets/'.$name.'.php';
		else
			self::$_config_cache[$name] = array();

		$this->config = Data::array_merge_recursive_changed($this->config, self::$_config_cache[$name]);

		if($this->decorator !== null && isset($this->config['space']))
		{
			$this->decorator->SetRoleSpaceForThisDecorator($this->config['space']);
		}
	}

	/**
	 * возврат дополнительных обработчиков для JS
	 * @return array обработчики событий
	 */
	public function GetJSHandlers()
	{
		return array();
	}

	/**
	 * возврат метаданных
	 * @return array метаданные
	 */
	public function GetMetaData()
	{
		return $this->metadata;
	}

	/**
	 * возврат path/state
	 * @return string
	 */
	public function GetFullName()
	{
		return $this->path.'/'.$this->state;
	}

	// свойства виджета
	/**
	 * Сворачиваемый виджет?
	 * @return bool
	 */
	protected function IsClosable()
	{
		return false;
	}

	/**
	 * Настраиваемый виджет?
	 * @return bool
	 */
	protected function IsConfigurable()
	{
		return false;
	}

	/**
	 * видимость виджета
	 * @return bool видо?
	 */
	protected function IsShowed()
	{
		return true;
	}

	// обработчики состояний
	/**
	 * Состояние не найдено, думаю просто отдача пустого конента
	 */
	protected function OnNotFound()
	{
	}

	/**
	 * изменение отображаемости
	 * @param bool показывать?
	 */
	protected function OnToggleVisible($show) // для возможности сохранения, необходимо перегрузить
	{
		return false;
	}

	//public function OnСостояние()
	//{
	//}
	// обработчики не ставлю, чтобы иметь воожность вынести обработку в отдельный файл
	// необходимы обработчики OnClose, OnConfigure в случае установленных флагов

	// интерфейс IDisposable
	public function Dispose()
	{
	}
}
