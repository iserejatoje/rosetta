<?

class Container
{
	const AJAX		= 1;
	const GET		= 2;
	const POST		= 4;
	const WAIT		= 8;	// показывать, что идет загрузка, применим только для асинхронных методов
	const JS		= 16;
	const SHOWED	= 32;
	const HTML		= 64;
	const SSI		= 128;

	const OK	= 1;
	const ERROR = 2;
	const USER	= 1000;

	// необходимо поддержка пользовательских статусов
	static private $statusStr = array(
		self::OK	=> 'ok',
		self::ERROR => 'error',
		self::USER	=> 'user_custom',
		);

	static private $_cache = null;

	static $counter = 100;
	/**
	 * Вывод контейнера для блока, либо содержимого блока
	 * @param string виджет
	 * @param string состояние виджета
	 * @param mixed дополнительные параметры
	 * @param int флаги
	 * @param string тело виджета
	 * @return string код контейнера или блок
	 */
	static public function GetWidgetInstance($widget, $state = null, $params = array(), $flags = self::AJAX, $body = null)
	{
		global $CONFIG, $OBJECTS;

		include_once $CONFIG['engine_path'].'include/json.php';
		$json = new Services_JSON();

		if($state === null) // все указано в пути, режем по последнему /
		{
			$pos = strrpos($widget, '/');
			$state = substr($widget, $pos+1);
			$widget = substr($widget, 0, $pos);
		}

		if (is_array($params['env']) && sizeof($params['env'])) {
			$params['env'] = array_flip($params['env']);
			foreach($params['env'] as $k=>$v) {

				switch($k)
				{
				case 'userid':
					$params['env'][$k] = (int) App::$User->ID;
					break;
				case 'siteid':
					$params['env'][$k] = (int) App::$CurrentEnv['site']['tree_id'];
					break;
				case 'sectionid':
					$params['env'][$k] = (int) App::$CurrentEnv['sectionid'];
					break;
				case 'regid':
					$params['env'][$k] = (int) App::$CurrentEnv['regid'];
					break;
				}
			}
			unset($v);

			if (isset($params['cacheid']))
				$params['cacheid'] = md5($params['cacheid'].'|'.implode('|', $params['env']));
		}

		if($flags & self::AJAX)
		{
			$name = self::$counter++;
			// необходимо подключить jQuery

			$OBJECTS['title']->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');

			if(!isset($params['isinit']))
				$params['isinit'] = true;

			$widgeto = WidgetFactory::GetInstance($widget, $state, $params, $name);
			if($widgeto !== null)
			{
				$widgeth = $widgeto->GetJSHandlers();

				$params = $widgeto->params;

				$tic = serialize(array_keys($params));
				LibFactory::GetStatic('cryptography');
				$tic = base64_encode(Cryptography::xsx_encode($tic));

				if(count($params) > 0)
					$params = $json->encode($params);
				else
					$params = '{}';

				$js = '<div id="container_'.$name.'"'.($body!==null?' style="display:none;"':'').'>'.($body!==null?$body:'').'</div>';
				return $js;
			}
			else
				return '';
		}
		elseif($flags & self::HTML)
		{
			$name = self::$counter++;
			// необходимо подключить jQuery

			// $OBJECTS['title']->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');

			if (!isset($params['env']['userid']))
				$params['env']['userid'] = (int) App::$User->ID;

			$widgeto = WidgetFactory::GetInstance($widget, $state, $params, $name, true);

			if($widgeto !== null)
			{
				$st = WidgetFactory::GetState();
				WidgetFactory::SetWidgetState();
				$widgeto->SetOutputMode(IWidget::OUTPUT_SYNC);
				$widgeth = $widgeto->GetJSHandlers();

				$params = $widgeto->params;

				$tic = serialize(array_keys($params));
				LibFactory::GetStatic('cryptography');
				$tic = base64_encode(Cryptography::xsx_encode($tic));

				if(count($params) > 0)
					$params = $json->encode($params);
				else
					$params = '{}';

				$body = $widgeto->Run();

				// $js = '<div id="container_'.$name.'"'.($body===null?' style="display:none;"':'').'>'.($body!==null?$body:'').'</div>';
				$js = ($body===null?' style="display:none;"':'').($body!==null?$body:'');

				WidgetFactory::SetState($st);
				return $js;
			}
			else
				return '';
		}
		elseif($flags & self::SSI)
		{
			$name = self::$counter++;

			if (empty($params['cacheid']) ) {

				error_log("Empty widget cacheid [$widget/$state]");
				return '';
			}

			// необходимо подключить jQuery
			$OBJECTS['title']->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');


			$tic = serialize(array_keys($params));
			LibFactory::GetStatic('cryptography');
			$tic = base64_encode(Cryptography::xsx_encode($tic));

			$params['tic'] = $tic;
			$params['widgetContainerId'] = 1;
			$body = '<!--# include virtual="/service/widget/'.$widget.'/'.$state.'.php?'.http_build_query($params).'" -->';

			if(count($params) > 0)
				$params = $json->encode($params);
			else
				$params = '{}';

			$js = '<div id="container_'.$name.'"'.($body===null?' style="display:none;"':'').'>'.($body!==null?$body:'').'</div>';
			$js.= '<script type="text/javascript" language="javascript">';
			$js.= "if (widgetAPI) {\n";
			$js.= "widget".$name." = widgetAPI.createWidget(".$name.", '".$widget."', '".$state."', ".$params.",true,true,'".$tic."');\n";
			/*
			Надо как-то архитектуру SSI исправить, чтобы это работало.
			foreach($widgeth as $n => $h)
			{
				$js.= "widget".$name.".".$n." = ".$h.";\n";
			}*/
			$js.= "}\n";
			$js.= '</script>';

			return $js;
		}
	}

	/**
	 * Вывод контейнера для блока, либо содержимого блока
	 * @param string урл откуда тянуть блок
	 * @param int флаги
	 * @return string код контейнера или блок
	 */
	static public function GetInstanceByUrl($url, $flags)
	{
		global $OBJECTS, $CONFIG;
		if($flags & self::AJAX) // содержимое блока получаем через AJAX
		{
			$name = self::$counter++;
			// необходимо подключить jQuery
			$OBJECTS['title']->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');
			$js = '<script type="text/javascript" language="javascript">';
			$js.= '$.ajax({';
			$js.= "url: '".$url."',";
			$js.= "dataType: 'json',";
			$js.= "data: {block_type_c:'json', rand:".rand(0,999999)."},";
			$js.= "success: function(data){if(data.status=='ok'){\$('#conteiner_".$name."').html(data.data);$('#conteiner_".$name."').css('display','');}},";
			if($flags & self::POST)
				$js.= "type: 'POST'";
			else
				$js.= "type: 'GET'";
			$js.= '});';
			$js.= '</script>';
			$js.= '<div id="conteiner_'.$name.'" style="display:none;"></div>';
			return $js;
		}
		elseif($flags & self::JS) // содержимое блока получаем через JS
		{
			$name = self::$counter++;
			// необходимо подключить jQuery
			$OBJECTS['title']->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');
			$url.= strpos($url, '?') === false ? "?" : "&";
			$url.= 'block_type_c=js&';
			$url.= 'container=conteiner_'.$name.'&';
			$js = '<div id="conteiner_'.$name.'" style="display:none;"></div>';
			$js.= '<script type="text/javascript" language="javascript" src="'.$url.'"></script>';
			return $js;
		}
	}

	/**
	 * Кодирование блока в необходимый формат
	 * @param mixed данные
	 * @param int статус
	 * @return блок
	 */
	static public function EncodeBlock($data, $status)
	{
		if($_REQUEST['block_type_c'] == 'json')
		{
			include_once ENGINE_PATH.'include/json.php';
			$json = new Services_JSON();
			return $json->encode(array('status' => self::$statusStr[$status], 'data' => $data));
		}
		elseif($_REQUEST['block_type_c'] == 'js')
		{
			$cont = $_REQUEST['container'];
			$fname = $cont."_".rand(0,999);
			include_once ENGINE_PATH.'include/json.php';
			$json = new Services_JSON();
			return  "function ".$fname."(){\n var data = ".$json->encode(array('status' => self::$statusStr[$status], 'data' => $data)).";\n"
					."if(data.status=='ok'){\n"
					."\$('#".$cont."').html(data.data);\n"
					."\$('#".$cont."').css('display','');\n"
					."}\n};\n"
					.$fname."();\n";
		}
		else
			return $data;
	}

	/**
	 * Вывод в поток либо возврат блока
	 * @param mixed данные
	 * @param int статус
	 * @return блок
	 */
	static public function SendBlock($data, $status)
	{
		if($_REQUEST['block_type_c'] == 'json')
		{
			echo self::EncodeBlock($data, $status);
			exit();
		}
		if($_REQUEST['block_type_c'] == 'js')
		{
			echo self::EncodeBlock($data, $status);
			exit();
		}
		else
			return self::EncodeBlock($data, $status);
	}
}

?>