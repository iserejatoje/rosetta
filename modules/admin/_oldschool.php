<?
/**
 * Модуль Svoi_V2.
 *
 * @date		$Date: 2008/08/07 10:08:00 $
 */
class Mod_Admin__OldSchool extends AMultiFileModule_Magic
{
	protected $_page = 'default';
	private $params;
	
	public function __construct()
	{
		parent::__construct('admin/_oldschool');
	}
	
	public function Init($params = null)
	{
		global $CONFIG, $OBJECTS;
		
		$this->params = $params;
	}

	public function AppInit($params)
	{
	}
	
	public function Action($params)
	{
	}
	
	public function _ActionGet()
	{
		global $OBJECTS, $CONFIG, $DCONFIG, $SCONFIG, $MCONFIG;
		
		// работа с модулями админки
		//2do: добавить работу с пользователями
		$DCONFIG['SESSION_LIFETIME'] = ini_get('session.gc_maxlifetime');

		ini_set('memory_limit', 32 * 1024 * 1024);
		
		if(isset($_REQUEST['section_id']))
			$id = intval($_REQUEST['section_id']);
		else
			$id = $this->params['section'];

		// подключаем необходимые файлы
		LibFactory::GetStatic('namespace');

		Response::NoCache();

		$db = DBFactory::GetInstance('site');

		include_once $CONFIG['engine_path']."include/adm/smarty.php";
		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		LibFactory::GetStatic('data');
		LibFactory::GetStatic('tree');
		include_once $CONFIG['engine_path']."include/adm/misc.php";
		include_once $CONFIG['engine_path']."include/adm/filter.php";		

		session_start();
		
		if($id == 0)
		{
			echo "1 Будет главная страница админки, дублирование меню в расширенной форме, а также возможно статистики и другие возможности, такие как создать новую запись в разделе и т.д. и т.п.";
			exit(1);
		}
		
		$DCONFIG['tpl'] = new CSmartyAdm();
		$DCONFIG['tpl']->force_compile=true;
		$DCONFIG['tpl']->register_function('html_editdate', 'smarty_date');
		
		$node = STreeMgr::GetNodeByID($id);
		
		$DCONFIG['SECTION_PATH'] = $node->Path;
		
		$DCONFIG['tpl_site'] = new CSmarty();
		$DCONFIG['tpl_site']->caching = true;
		
		$DCONFIG['REGION'] = intval($node->Regions);
		
		if($node->TypeInt != 0)
		{
			// подключим файл конфигурации админки сайта
			
			// подключим файл конфигурации раздела
			$SCONFIG[$node->Path] = ModuleFactory::GetConfigById('section', $id);
			
			// подключим файл конфигурации модуля администрирования
			$aconfig = array();
			if(file_exists($CONFIG['engine_path'].'adm/modules/'.$node->Module.'/config.php'))
			{
				include_once $CONFIG['engine_path'].'adm/modules/'.$node->Module.'/config.php';
				$aconfig = $ACONFIG[$node->Module];
				$aconfig['params'] = $paramstr;
			}
		}
		else
		{
			$_REQUEST['maction'] = null;
		}
		
		$_REQUEST['maction'] = null;
		
		// в противном случае используем модуль администрирования для данного модуля
		if($_REQUEST['maction'] == null)
		{
			// подключим модуль администрирования
			if(strlen($node->Path) == 0 || !file_exists($CONFIG['engine_path'].'adm/modules/'.$node->Module.'/index.php'))
			{
				echo 'Ддя раздела: '.$node->Path.'<br>';
				echo 'Тютю: '.$CONFIG['engine_path'].'adm/modules/'.$node->Module.'/index.php<br>';
				echo "Будет главная страница админки, дублирование меню в расширенной форме, а также возможно статистики и другие возможности, такие как создать новую запись в разделе и т.д. и т.п.";
				echo '<pre>';
				exit(1);
			}
			
			include_once $CONFIG['engine_path'].'adm/modules/'.$node->Module.'/index.php';
			
			$DCONFIG['SECTION_ID_URL'] = "section_id=$id";
			$DCONFIG['SECTION_ID_FORM'] = "<input type=\"hidden\" name=\"section_id\" value=\"$id\">";
			
			$module = new AdminModule($SCONFIG[$node->Path], $aconfig, $id);
			$DCONFIG['SECITON_TITLE'] = AdminModule::$TITLE;
		}
		
		$DCONFIG['SECTION_ID'] = $id;
		
		
		$module->Action(); // здесь разделение функция для разграничение прав на уровне движка, реализация будет позже
		
		$DCONFIG['tpl']->assign('UERROR', $OBJECTS['uerror']);
		$DCONFIG['tpl']->assign('SESSION_LIFETIME', $DCONFIG['SESSION_LIFETIME']);
		$DCONFIG['tpl']->assign('SECTION_NAME', $name);
		if($node->Parent->TypeInt == 1)
		{		
			$DCONFIG['tpl']->assign('SITE_URL', $node->Parent->Path);
			$DCONFIG['tpl']->assign('SITE_NAME', $node->Parent->Name);
		}
		$DCONFIG['tpl']->assign('SECTION_PATH', $node->Path);
		$DCONFIG['tpl']->assign('SECTION_ID', $node->ID);
		$DCONFIG['tpl']->assign('SECTION_ID_URL', $DCONFIG['SECTION_ID_URL']);
		$DCONFIG['tpl']->assign('SECTION_ID_FORM', $DCONFIG['SECTION_ID_FORM']);
		$DCONFIG['tpl']->assign('MODULE_NAME', $DCONFIG['SECITON_TITLE']);
		$DCONFIG['tpl']->assign('TABS', $module->GetTabs());
		$DCONFIG['tpl']->assign('PAGE', $module->GetPage());
		$DCONFIG['tpl']->assign('TITLE', $module->GetTitle());

		LibFactory::GetStatic('filestore');
		$tiny_mce_plugins = array();
		if ( $SCONFIG[$node->Path]['images_cont_dir'] ) {
			$DCONFIG['tpl']->assign('tiny_mce_imagemanager_rootpath', FileStore::GetRealPath($SCONFIG[$node->Path]['images_cont_dir']));
			$tiny_mce_plugins[] = 'imagemanager';
		}elseif ( $aconfig['images_cont_dir'] ) {
			$DCONFIG['tpl']->assign('tiny_mce_imagemanager_rootpath', FileStore::GetRealPath($aconfig['images_cont_dir']));
			$tiny_mce_plugins[] = 'imagemanager';
		}

		if ( $SCONFIG[$node->Path]['files_dir'] ) {
			$DCONFIG['tpl']->assign('tiny_mce_filemanager_rootpath', FileStore::GetRealPath($SCONFIG[$node->Path]['files_dir']));
			$tiny_mce_plugins[] = 'filemanager';
		}elseif ( $aconfig['files_dir'] ) {
			$DCONFIG['tpl']->assign('tiny_mce_filemanager_rootpath', FileStore::GetRealPath($aconfig['files_dir']));
			$tiny_mce_plugins[] = 'filemanager';
		}
			
		$config = ModuleFactory::GetConfigById('site', STreeMgr::GetNodeByID($id)->ParentID);
		if ( !empty($config['design']) )
			$DCONFIG['tpl']->assign('tiny_mce_content_css', "/resources/styles/design/{$config['design']}/common/styles.css");
		
		App::$Title->AddStyle('/resources/styles/design/200001_admin/common/styles.css');
		
		$DCONFIG['tpl']->assign('tiny_mce_plugins', implode(',', $tiny_mce_plugins));		
		return $DCONFIG['tpl']->fetch('main.tpl');
	}
	
	public function &GetPropertyByRef($name)
	{
		return null;
	}
}

?>