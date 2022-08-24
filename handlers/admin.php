<?
/**
 * Хендлер для работы с модулями админки
 * @package Handlers
 */
class Handler_admin extends IHandler
{
	private $blocks 		= array();
	private $objects 		= array();
	private $controls 		= array();
	private $sourcepath 	= null;
	private $bl				= null;
	private $pathinfo		= null;
	private $params			= array();
	private $title			= '';
	private $module			= null;

	public function Init($params)
	{
		global $OBJECTS, $CONFIG, $ERROR;



		ini_set('memory_limit', 128 * 1024 * 1024);
		// ini_set('memory_limit', 0);

		if(!$OBJECTS['user']->IsAuth() || !$OBJECTS['user']->IsInRole('e_adm_execute_cp'))
			Response::Status(403, RS_SENDPAGE | RS_EXIT);

		if(!$OBJECTS['user']->IsAuth() || !$OBJECTS['user']->IsInRole('e_adm_sections_view'))
			Response::Status(403, RS_SENDPAGE | RS_EXIT);

		$this->params = $params;

		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		include_once $CONFIG['engine_path']."include/lib.stpl.php";
		include_once $CONFIG['engine_path']."include/misc.php";
		include_once $CONFIG['engine_path']."include/title.php";
		include_once $CONFIG['engine_path']."handlers/admin/errors.php";

		LibFactory::GetStatic('bl');
		LibFactory::GetStatic('control');
		LibFactory::GetStatic('data');

		return true;
	}

	public function Run()
	{
		global $OBJECTS, $CONFIG;
		// создаем окружение
		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		if(strpos($host, 'dvp.') === 0)
			$host = substr($host, 4);

		$pos = strpos($_SERVER['REQUEST_URI'], '?');
		if($pos === false)
			$url = $_SERVER['REQUEST_URI'];
		else
			$url = substr($_SERVER['REQUEST_URI'], 0, $pos);

		$CONFIG['env']['url'] = $url;
		$CONFIG['env']['uri'] = $_SERVER['REQUEST_URI'];

		// берем урл раздела
		// /service/admin длинна 15
		$url = substr($url, strlen($this->params['uri'])-1);
		$this->bl = BLFactory::GetInstance('system/site');
		$this->pathinfo = $this->bl->ParsePath($url);

		$OBJECTS['title'] = new Title();
		$CONFIG['env']['site']['domain'] = $host;

		App::SetTitleObject($OBJECTS['title']);
		App::SetUserErrorObject($OBJECTS['uerror']);
		App::SetUserObject($OBJECTS['user']);

		App::$Title->Add('meta', array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));

		App::$Title->AddStyle('/resources/styles/design/200908_admin/common/style.css');
		App::$Title->AddStyle('/resources/styles/design/200908_admin/common/config_list.css');

		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.js');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery.multi-ddm.js');

		unset(App::$Request->Get['params']);

		$this->AdminForm();

		$this->LoadForm();
		// запускаем обработчик
		// POST
		$this->ActionPost();
		// GET
		echo $this->AdminFormRender($this->ActionGet());

		return true;
	}

	private function GetParentPath()
	{
		$parent = STreeMgr::GetNodeByID($this->pathinfo['section'])->ParentID;
		return $this->params['uri'].$this->bl->GetNodePathByID($parent).$this->controls['treepath']->GetStateUrl(true, true);
	}

	private function GetCurrentPath($action = null)
	{
		if($action !== null)
			return $this->params['uri'].$this->bl->GetNodePathByID($this->pathinfo['section']).'.'.$action.'/'.$this->controls['treepath']->GetStateUrl(true, true);
		else
			return $this->params['uri'].$this->bl->GetNodePathByID($this->pathinfo['section']).$this->controls['treepath']->GetStateUrl(true, true);
	}

	private function AdminForm()
	{
		global $OBJECTS;
		// здесь и всегда доступно, показываем для состояний отличных от default скрытым,
		// можно развернуть и перейти в другой раздел в любой момент
		// list и path необходимы для навигации, через них реализуется сохранение параметров навигации
		$source = $this->bl->GetTreeSiteSource();
		$sourcepath = $this->bl->GetPathSource();

		$source->setparam('baseurl', $this->params['uri']);
		$source->setparam('parent', $this->pathinfo['section']);

		$sourcepath->setparam('parent', $this->pathinfo['section']);

		$this->controls['treepath'] = ControlFactory::GetInstance('extend/path', null, array('id' => 'treepath'));

		if($this->pathinfo['action'] == 'default')
		{
			$OBJECTS['user']->SectionID = 0;
			//if( $this->pathinfo['section'] > 0)
			//if(1)
			if($OBJECTS['user']->IsInRole('e_adm_execute_section') || $this->pathinfo['section'] > 0)
			{
				$this->SetTitle('Разделы сайта');

				$this->controls['treeform'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'treeform'));
				$this->controls['treeform']->SetTemplate('controls/extend/form/blank');

				$action = ControlFactory::GetInstance('standart/hidden', null, array('id' => 'action'));
				$this->controls['treeform']->AddItem('', $action);

				$treelist = ControlFactory::GetInstance('list/list', null, array('id' => 'treelist', 'source' => $source));

				$treelist->SetCustomParam('can_section_view', true);
				$treelist->SetCustomParam('can_env_view', true);
				$treelist->SetCustomParam('can_config_view', true);
				$treelist->SetCustomParam('can_block_view', true);

				$treelist->SetRowTemplate('admin/controls/list/treerow');
				$treelist->GetPager()->SetItemsPerPage(50);
				$treelist->SetDefaultSort(1,0);
				$treelist->SetSelectMode('multi');
				//$treelist->GetStateUrl(false);

				$treelist->AddColumn('ID', 'id');
				$treelist->AddColumn('Имя', 'name');
				$treelist->AddColumn('Подразделы', 'subsection');
				$treelist->AddColumn('Путь', 'path');
				$treelist->AddColumn('Модуль', 'module');
				$treelist->AddColumn('Видимость', 'visible', array('width' => '30'));
				$treelist->AddColumn('Порядок','ord', array('width' => '60'));
				$treelist->AddColumn('Действия', '', array('width' => '30', 'sortable' => false));

				$this->controls['treeform']->AddItem('', $treelist);

				$sourcepath->setparam('baseurl', $this->params['uri']);
				$sourcepath->setparam('baseparams', $treelist->GetHeader()->GetStateUrl());

				$this->controls['treemenu'] = ControlFactory::GetInstance('extend/menu', null, array('id' => 'treemenu'));

				$item = $this->controls['treemenu']->AddItem('Раздел');

				$item->AddItem('Создать новый', $this->params['uri'].$this->bl->GetNodePathByID($this->pathinfo['section']).'.new');

				$item->AddItem('Удалить', 'javascript:;', "$('#action_hidden').val('delete'); $('#treeform_form').get(0).submit();");
				$item->AddItem('Переместить', 'javascript:;', "$('#action_hidden').val('move'); $('#treeform_form').get(0).submit();");


				/*$item = $this->controls['treemenu']->AddItem('Импорт/Экспорт', 'javascript:;');
				$subitem = $item->AddItem('Окружение');
				$subitem->AddItem('Импортировать');
				$subitem->AddItem('Экспортировать');
				$subitem = $item->AddItem('Конфиги');
				$subitem->AddItem('Импортировать');
				$subitem->AddItem('Экспортировать');
				$subitem = $item->AddItem('Блоки');
				$subitem->AddItem('Импортировать');
				$subitem->AddItem('Экспортировать');*/
			}
			else
			{
				ini_set('memory_limit', '64M');
				$objects = $OBJECTS['user']->Roles->GetObjectsForRole("e_adm_execute_section");
				$this->controls['treeform'] = ControlFactory::GetInstance('extend/form', null, array('id' => 'treeform'));
				$this->controls['treeform']->SetTemplate('controls/extend/form/blank');
				$treelist = ControlFactory::GetInstance('list/list', null, array('id' => 'treelist'));
				$treelist->SetRowTemplate('admin/controls/list/treerow');
				$treelist->AddColumn('Имя', 'name');
				$treelist->GetPager()->SetItemsPerPage(50);

				$items = array();
				foreach($objects as $obj)
				{
					$node = STreeMgr::GetNodeByID($obj);
					if($node !== null)
					{
						$item = array();
						$item['name'] = '';
						$item['fullpath'] = $this->params['uri'].$this->bl->GetNodePathByID($obj).'.module/';

						while($node != null)
						{
							$item['name'] = $node->Name.' / '.$item['name'];
							$node = $node->Parent;
						}
						$items[$obj] = $item;
					}
				}
				uasort($items, array($this, 'comparer'));

				foreach($items as $id => $val)
				{
					$treelist->AddItem($id, $val);
				}

				$this->controls['treeform']->AddItem('', $treelist);
			}
		}
		else
		{
			$url = $this->controls['treepath']->GetStateUrl(true, true);
			$sourcepath->setparam('baseurl', $this->params['uri']);
			$sourcepath->setparam('baseparams', $url);
			//$sourcepath->setparam('withlast', true);
		}
		$this->controls['treepath']->SetSource($sourcepath);
	}

	public function comparer($a, $b)
	{
		if ($a['name'] == $b['name']) {
			return 0;
		}
		return ($a['name'] < $b['name']) ? -1 : 1;
	}

	private function AdminFormRender($html)
	{
		if(isset($this->controls['treepath'])) $this->controls['treepath']->Render();
		//if(isset($this->controls['treelist'])) $this->controls['treelist']->Render();
		if(isset($this->controls['treeform'])) $this->controls['treeform']->Render();
		if(isset($this->controls['treemenu'])) $this->controls['treemenu']->Render();

		return STPL::Fetch('handlers/admin/main', array(
			'path' => $this->controls['treepath'],
			'list' => $this->controls['treeform'],
			'menu' => $this->controls['treemenu'],
			'title' => $this->title,
			'html' => $html,
		));
	}

	private function LoadForm()
	{
		global $OBJECTS, $CONFIG;
		$action = $this->pathinfo['action'];
		if($action == 'new') $action = 'edit';
		$path = $CONFIG['engine_path'].'handlers/admin/form_'.$action.'.php';
		if(is_file($path))
			return include $path;
	}

	private function ActionPost()
	{
		global $OBJECTS, $CONFIG;
		if(App::$Request->requestMethod == Request::M_POST)
		{
			$action = $this->pathinfo['action'];
			if($action == 'default')
			{
				// не задана команда, значит с дерева разделов, подменим стандартный обработчик
				$action = App::$Request->Post['action_hidden']->Value();
				switch($action)
				{
				case 'delete':
				case 'move':
					$action = 'form_'.$action;
					break;
				default:
					$action = null; // действия нет
					break;
				}
			}
			if($action !== null)
			{
				if($action == 'new') $action = 'edit';
				$path = $CONFIG['engine_path'].'handlers/admin/post_'.$action.'.php';
				if(is_file($path))
					return include $path;
			}
		}
	}

	private function ActionGet()
	{
		global $OBJECTS, $CONFIG;
		$action = $this->pathinfo['action'];
		if($action == 'new') $action = 'edit';
		$path = $CONFIG['engine_path'].'handlers/admin/get_'.$action.'.php';
		if(is_file($path))
			return include $path;
	}

	private function SetTitle($title)
	{
		if(is_string($title))
			$this->title = $title;
	}

	private function GetTitle()
	{
		return $this->title;
	}

	public function Dispose()
	{
		return true;
	}

	private function &GetValue(&$value, $ths = '')
	{
		return $value;
    }
}
