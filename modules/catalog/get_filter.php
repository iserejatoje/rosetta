<?
	$seats			= App::$Request->Get['seats']->Int(-1, Request::UNSIGNED_NUM);
	$motor			= App::$Request->Get['motor']->Int(-1, Request::UNSIGNED_NUM);
	$manufacturer	= App::$Request->Get['manufacturer']->Value(Request::OUT_HTML_CLEAN);
	$isnew			= App::$Request->Get['isnew']->Enum(null, array(0,1));
	$ishit			= App::$Request->Get['ishit']->Enum(null, array(0,1));

	$get_params = "";

	if($seats=='-1')
	{
		$seats = null;
	}
	else
	{
		$get_params .= "&seats=".$seats;
	}
		
	if($motor == '-1')
	{
		$motor = null;
	}
		
	else
	{
		$get_params .= "&motor=".$motor;
	}
		
	if(empty($manufacturer)  || $manufacturer == '-1')
	{
		$manufacturer = null;
	}
	else
	{
		$get_params .= "&manufacturer=".$manufacturer;
	}
		
	if(empty($isnew))
	{
		$isnew = null;
	}
	else
	{
		$get_params .= "&isnew=".$isnew;
	}
		
	if(empty($ishit))
	{
		$ishit = null;
	}
	else
	{
		$get_params .= "&ishit=".$ishit;
	}
		
	$filter = array(
		'seats' 		=> $seats,
		'motor' 		=> $motor,
		'manufacturer'	=> $manufacturer,
		'isnew'			=> $isnew,
		'ishit'			=> $ishit

	);
	if( $isnew == '1' && is_null($ishit))
		$section_name = 'Новинки';
	else if( $ishit == '1' && is_null($isnew) )
		$section_name = 'Хиты';
	else
		$section_name = 'Товары по фильтру';


	$Page = App::$Request->Get['p']->Int(1, Request::UNSIGNED_NUM);
	$limit = intval($this->_config['rowsonpage']);
	$offset = ($Page - 1) * $limit;
	$total_count = $this->catalogMgr->GetProductsCountByFilter($filter);
	if($limit>0)
		$pages = ceil($total_count/$limit);
	else
		$pages = 0;

	$products = $this->catalogMgr->GetProductsByFilter($filter, $limit, $offset);

	$magic_word = UString::word4number($total_count, "единица", "единицы", "единиц");
	$total_count .=" ".$magic_word;


	return STPL::Fetch('modules/catalog_el/products_list', array(
															'products' => $products,
															'section_name' 	=> $section_name,
															'header_note'	=> '',
															'count' 		=> $total_count,
															'page'			=> $Page,
															'pages'			=> $pages,
															'get_params'	=> $get_params
															));

