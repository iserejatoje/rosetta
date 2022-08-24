<?php

LibFactory::GetStatic('application');
class AdminModule {

	static $TITLE = 'Переменные';

	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;
	private $_col_pp = 30;
	private $_col_plink = 30;
	private $FILTER;

	function __construct($config, $aconfig, $id) {

		$this->_id = &$id;
		$this->_config = &$config;
		$this->_aconfig = &$aconfig;

		$this->_db = DBFactory::GetInstance('site');

		LibFactory::GetStatic('vars');
		
		$this->FILTER = array(
			'name' => array('title' => 'Переменная', 'type' => 'string', 'field' => 'Name'),
			'descr' => array('title' => 'Описание', 'type' => 'string', 'field' => 'Descr'),
		);
		$this->_config = ApplicationMgr::GetConfig('vars', 'vars');
	}

	// обязательные функции
	function Action() {

		$this->_params['name'] = null;
		if ( !empty($_GET['name']) )
			$this->_params['name'] = $_GET['name'];
			
		$this->_params['page'] = null;
		if ( !empty($_GET['page']) )
			$this->_params['page'] = $_GET['page'];

		$this->_params['p'] = 1;
		if ( isset($_GET['p']) && $_GET['p'] > 0 )
			$this->_params['p'] = (int) $_GET['p'];

		$this->_params['field_order'] = 'name';
		if ( !empty($_GET['sort']) )
			$this->_params['field_order'] = $_GET['sort'];

		$this->_params['dir_order'] = 'asc';
		if ( !empty($_GET['dir']) && $_GET['dir'] == 'desc' )
			$this->_params['dir_order'] = $_GET['dir'];

		if($_REQUEST['__filter_action']=='filter')
		{
			if(isset($_REQUEST['section_part']))
			{
				$this->_page = $_REQUEST['section_part'];
			}
			//$_GET['action']='';
			$_POST['action']='';
			$_REQUEST['action']='';
		}	

		if($_REQUEST['__filter_action']=='clear_filter')
		{
			if(isset($_REQUEST['section_part']))
			{
				$this->_page = $_REQUEST['section_part'];
				Filter::Clear($this->_id.'_'.$this->_page);
			}
			//$_GET['action']='';
			$_POST['action']='';
			$_REQUEST['action']='';
		}

		$this->_Post_Action();
		$this->_Get_Action();
	}

	function GetPage() {
		global $DCONFIG;

		switch ($this->_page) {
			case 'create_var':
				$this->_title = "Добавить переменную";
				$this->CreateVar();
			break;
			case 'update_var':
				$this->_title = "Редактировать переменную";
				$this->UpdateVar();
			break;
			case 'list_regions':
				$this->_title = "Регионы";
				$this->GetListRegion();
			break;
			default:
				$this->_title = "Переменные";
				$this->GetList();
			break;
		}
		
		$html = $DCONFIG['tpl']->fetch('vars/'.$this->_page.'.tpl');
		return $html;
	}

	function GetTabs() {

		$tabs = array(
			'tabs' => array(
					array('name' => 'action', 'value' => 'list','text' => 'Переменные'),
					array('name' => 'action', 'value' => 'list_regions','text' => 'Регионы'),
			),
		'selected' => $this->_page);

		return $tabs;
	}

	function GetTitle() {

		return $this->_title;
	}

	// обработка запросов
	private function _Post_Action()
	{
		global $DCONFIG;

		switch ($_POST['action']) {
			case 'create_var':
				if ( $this->PostCreateVar() ) {
					header("location: ?{$DCONFIG['SECTION_ID_URL']}&action=list&sort={$this->_params['field_order']}&dir={$this->_params['dir_order']}&p={$this->_params['p']}");
					exit;
				}
				break;
			case 'update_var':
				if ( $this->PostUpdateVar() ) {
					header("location: ?{$DCONFIG['SECTION_ID_URL']}&action=tree_view&sort={$this->_params['field_order']}&dir={$this->_params['dir_order']}&p={$this->_params['p']}");
					exit;
				}
				break;
			case 'delete_var':
				Variables::Delete($_POST['names']);
				header("location: ?{$DCONFIG['SECTION_ID_URL']}&action=list&sort={$this->_params['field_order']}&dir={$this->_params['dir_order']}");
				exit;
			break;
		}
	}

	private function _Get_Action() {

		switch ($_GET['action']) {
			case 'create_var':
				$this->_page = $_GET['action'];
			break;
			case 'update_var':
				$this->_page = $_GET['action'];
			break;
			case 'list_regions':
				$this->_page = $_GET['action'];
			break;
			default:
				$this->_page = 'list';
			break;
		}
	}

	private function GetList() {
		global $DCONFIG;

		if(Filter::IsStored($this->_id.'_'.$this->_page) && !Filter::IsQuery())
			Filter::Load($this->_id.'_'.$this->_page);
		else
			Filter::Save($this->_id.'_'.$this->_page);

		$filte = array(
			'offset' => ($this->_params['p']-1)*$this->_col_pp,
			'limit' => $this->_col_pp,
			'field' => $this->_params['field_order'],
			'dir' => $this->_params['dir_order'],
			'name' => $_REQUEST['__filter']['name'],
			'descr' => $_REQUEST['__filter']['descr'],
		);
		$list = Variables::GetList($filte);
		$count = Variables::GetCount($filte);

		$pages = null;
		if (ceil($count/$this->_col_pp) > 1) {
			$url = "?{$DCONFIG['SECTION_ID_URL']}&action=list&sort={$this->_params['field_order']}&dir={$this->_params['dir_order']}".
				"&p=@p@";
			$pages = Data::GetNavigationPagesNumber($this->_col_pp, $this->_col_plink, 
						$count, $this->_params['p'], $url);
		}

		$DCONFIG['tpl']->assign('pages', $pages);
		$DCONFIG['tpl']->assign('page', $this->_params['p']);
		$DCONFIG['tpl']->assign('count', $count);
		$DCONFIG['tpl']->assign('list', $list);
		$DCONFIG['tpl']->assign('field', $this->_params['field_order']);
		$DCONFIG['tpl']->assign('dir', $this->_params['dir_order']);
		$DCONFIG['tpl']->assign('filter', Filter::GetHTML($this->FILTER, true, false));		
	}
	
	private function GetListRegion() {
		global $DCONFIG;

		if(Filter::IsStored($this->_id.'_'.$this->_page) && !Filter::IsQuery())
			Filter::Load($this->_id.'_'.$this->_page);
		else
			Filter::Save($this->_id.'_'.$this->_page);

		$filte = array(
			'offset' => ($this->_params['p']-1)*$this->_col_pp,
			'limit' => $this->_col_pp,
			'field' => $this->_params['field_order'],
			'dir' => $this->_params['dir_order'],
			'name' => $_REQUEST['__filter']['name'],
			'descr' => $_REQUEST['__filter']['descr'],
			'regid' => $_REQUEST['__filter']['regid'],
		);
		
		$list = Variables::GetListByRegion($filte);
		$count = Variables::GetCountByRegion($filte);

		$pages = null;
		if (ceil($count/$this->_col_pp) > 1) {
			$url = "?{$DCONFIG['SECTION_ID_URL']}&action=list_regions&sort={$this->_params['field_order']}&dir={$this->_params['dir_order']}".
				"&p=@p@";
			$pages = Data::GetNavigationPagesNumber($this->_col_pp, $this->_col_plink, 
						$count, $this->_params['p'], $url);
		}

		$DCONFIG['tpl']->assign('pages', $pages);
		$DCONFIG['tpl']->assign('p', $this->_params['p']);
		$DCONFIG['tpl']->assign('count', $count);
		$DCONFIG['tpl']->assign('list', $list);
		$DCONFIG['tpl']->assign('field', $this->_params['field_order']);
		$DCONFIG['tpl']->assign('dir', $this->_params['dir_order']);
		$DCONFIG['tpl']->assign('page', $this->_page);
		
		$this->FILTER['regid'] = array('title' => 'Регион', 'type' => 'number', 'field' => 'regid');
		$DCONFIG['tpl']->assign('filter', Filter::GetHTML($this->FILTER, true, false));		
	}


	private function CreateVar() {
		global $DCONFIG;

		$form = array();
		$form['regid'] = array();
		if(App::$Request->requestMethod === Request::M_POST) {
			$form['name'] = Variables::Convert(App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML));
			$form['descr'] = App::$Request->Post['descr']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
			$form['regid'] = App::$Request->Post['regid']->AsArray(array(), Request::INTEGER_NUM);
			$form['region_value'] = App::$Request->Post['region_value']->AsArray(array(), Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		}

		$regions = array();
		$_db = DBFactory::GetInstance('site');
		$sql = 'SELECT DISTINCT regions FROM tree WHERE regions > 0';
		$result = $_db->query($sql);

		while (false != ($row = $result->fetch_row())) {
			$regions[(int) $row[0]] = $form['region_value'][(int) $row[0]];
		}
		$regions[0] = $form['region_value'][0];
		ksort($regions);

		$DCONFIG['tpl']->assign('form', $form);
		$DCONFIG['tpl']->assign('regions', $regions);
		$DCONFIG['tpl']->assign('field', $this->_params['field_order']);
		$DCONFIG['tpl']->assign('dir', $this->_params['dir_order']);
		$DCONFIG['tpl']->assign('p', $this->_params['p']);
		$DCONFIG['tpl']->assign('page', $this->_params['page']);
	}

	private function UpdateVar() {
		global $DCONFIG, $OBJECTS;

		$form = array();
		$form['regid'] = array();
		if(App::$Request->requestMethod === Request::M_POST) {
			$form['name'] = Variables::Convert(App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML));
			$form['descr'] = App::$Request->Post['descr']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
			$form['regid'] = App::$Request->Post['regid']->AsArray(array(), Request::INTEGER_NUM);
			$form['region_value'] = App::$Request->Post['region_value']->AsArray(array(), Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		} else {
		
			$var = Variables::Get($this->_params['name']);
			if ( $var === null )
				$OBJECTS['uerror']->AddError(ERR_M_VARS_NOT_FOUND);
				
			if ( $OBJECTS['uerror']->IsError() ) {
				unset($form);
				return false;
			}
		
			$form['name'] = $var['Name'];
			$form['descr'] = $var['Descr'];
			
			$form['region_value'] = Variables::GetValuesByRegion($this->_params['name']);
			$form['regid'] = array_keys($form['region_value']);
		}

		$regions = array();
		$_db = DBFactory::GetInstance('site');
		$sql = 'SELECT DISTINCT regions FROM tree WHERE regions > 0';
		$result = $_db->query($sql);

		while (false != ($row = $result->fetch_row())) {
			$regions[(int) $row[0]] = $form['region_value'][(int) $row[0]];
		}
		$regions[0] = $form['region_value'][0];
		ksort($regions);

		$DCONFIG['tpl']->assign('form', $form);
		$DCONFIG['tpl']->assign('regions', $regions);
		$DCONFIG['tpl']->assign('field', $this->_params['field_order']);
		$DCONFIG['tpl']->assign('dir', $this->_params['dir_order']);
		$DCONFIG['tpl']->assign('p', $this->_params['p']);
		$DCONFIG['tpl']->assign('page', $this->_params['page']);
	}

	private function PostCreateVar() {
		global $OBJECTS;

		$name = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		$descr = App::$Request->Post['descr']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML_AREA);
		$regid = App::$Request->Post['regid']->AsArray(array(), Request::INTEGER_NUM);
		$region_value = App::$Request->Post['region_value']->AsArray(array(), Request::OUT_HTML_CLEAN | Request::OUT_HTML);
					
		if ( empty($name) )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EMPTY_NAME);
			
		if ( Variables::Exists($name) )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EXISTS_NAME);
			
		if ( !isset($region_value[0]) || trim($region_value[0]) === '' )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EMPTY_DEFAULT_VALUE);
		
		if ( $OBJECTS['uerror']->IsError() )
			return false;	

		$name = Variables::Convert($name);			
		if ( false == Variables::Save(array($name => $descr)))
			return false;

		$regid[] = 0;
		foreach( $regid as $reg )
			Variables::SaveValue($name, $region_value[$reg], $reg);	

		return true;
	}
	
	private function PostUpdateVar() {
		global $OBJECTS;
		
		$name = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		$descr = App::$Request->Post['descr']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML_AREA);
		$regid = App::$Request->Post['regid']->AsArray(array(), Request::INTEGER_NUM);
		$region_value = App::$Request->Post['region_value']->AsArray(array(), Request::OUT_HTML_CLEAN | Request::OUT_HTML);
					
		if ( empty($name) )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EMPTY_NAME);
			
		if ( Variables::Exists($name, $this->_params['name']) )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EXISTS_NAME);

		if ( !isset($region_value[0]) || trim($region_value[0]) === '' )
			$OBJECTS['uerror']->AddError(ERR_M_VARS_EMPTY_DEFAULT_VALUE);
		
		if ( $OBJECTS['uerror']->IsError() )
			return false;	

		
		$name = Variables::Convert($name);
		Variables::Delete($name);	
		if ( false == Variables::Save(array($name => $descr)))
			return false;

		$regid[] = 0;
		foreach( $regid as $reg )
			Variables::SaveValue($name, $region_value[$reg], $reg);	

		return true;
	}
}

?>