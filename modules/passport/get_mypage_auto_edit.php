<?

$page = array();

if ( !$OBJECTS['user']->IsAuth() )
	PUsersMgr::RedirectToLogin();

if ( App::$Request->requestMethod === Request::M_POST )
{
	$page['id']					= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
	$page['action']	 			= App::$Request->Post['action']->Value('');
	$page['car']['MarkaID'] 	= App::$Request->Post['MarkaID']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['ModelID'] 	= App::$Request->Post['ModelID']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['ModelName'] 	= App::$Request->Post['ModelName']->Value('');
	$page['car']['Capacity'] 	= App::$Request->Post['Capacity']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['Year'] 		= App::$Request->Post['Year']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['Volume'] 		= App::$Request->Post['Volume']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['WheelType'] 	= App::$Request->Post['WheelType']->Int(0, Request::UNSIGNED_NUM);
	$page['car']['Capacity'] 	= App::$Request->Post['Capacity']->Int(0, Request::UNSIGNED_NUM);
} else {
	if ( $this->_page == 'mypage_auto_edit' )
	{
		$OBJECTS['title']->AppendBefore("Редактирование автомобиля");
		$page['id'] 	= $this->_params['id'];
		$page['action']	= 'mypage_auto_edit';
		$page['car'] 	= &$OBJECTS['user']->Profile['auto']['cars'][$page['id']];
	} else {
		$OBJECTS['title']->AppendBefore("Добавление автомобиля");
		$page['action']	= 'mypage_auto_add';	
	}
}


LibFactory::GetStatic('source');

$page['years'] = array();
for ( $y=0; $y<30; $y++)
	$page['years'][] = date('Y')-$y;

/*$page['tree'] = Source::GetData('db:autotree', array( 'type' => 0 ));

if ( $page['car']['MarkaID'] > 0 && !isset($page['tree'][$page['car']['MarkaID']]) )
	$page['models']	= Source::GetData('db:autotree', array( 'type' => 2, 'parent' => $page['car']['MarkaID'] ));

foreach ( $page['tree'] as &$parent )
{
	$child_list = Source::GetData('db:autotree', array( 'type' => 1, 'parent' => $parent['id'] ));
	if ( sizeof($child_list) )
	{
		$parent['has_children'] = true;
		$parent['marka'] = $child_list;		
	}
}*/



/**
	это мы переделываем на новый сорс
*/
$page['tree'] = array();
LibFactory::GetMStatic('advertise','advmgr');
try
{
	$obj = AdvMgr::GetSheme("auto");
}catch(Exception $e){}
foreach ( $this->_config['automarka_rubrics'] as $k => $name )
{
	$page['tree'][-$k] = array(
			'name' => $name,
			'parent' => 0,
			'data' => array('name' => $name, 'type' => 0),
		);
	
	$data_ = $obj->GetBrandsByRubricID($k);
	if ( count($data_) )
	{
		foreach ( $data_ as $row )
		{
			if ( $row['parent'] == 0 )
				$row['parent'] = -$k;
			$row['data'] = array('name' => $row['name'], 'type' => $row['type']);
		}
		$page['tree'][-$k]['has_children'] = true;
		$page['tree'][-$k]['marka'] = $data_;
	}
	unset($data_);
}

if ( $page['car']['MarkaID'] > 0 && !isset($page['tree'][$page['car']['MarkaID']]) )
	$page['models']	= Source::GetData('db:auto', array( 'type' => 2, 'parent' => $page['car']['MarkaID'] ));



// заполним данные о фотке
if ($page['car']['SmallPhoto'] != '')
{
	LibFactory::GetStatic('filestore');
	LibFactory::GetStatic('images');

	try {
		$page['car']['small_photo'] = Images::PrepareImage_NEW(FileStore::GetPath_NEW($page['car']['SmallPhoto']),
			$this->_config['auto_photo']['small']['path'], $this->_config['auto_photo']['small']['url']);
	} catch(MyException $e) {}
}


return $page;

?>