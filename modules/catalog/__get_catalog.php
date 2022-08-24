<?

	$path = trim($this->_params['path'], "/");

	$catalog = $this->catalogMgr->GetCatalogByLinkName($path);

	if(!is_object($catalog))
	{
		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}

	$Page = App::$Request->Get['p']->Int(1, Request::UNSIGNED_NUM);

	$limit = intval($this->_config['rowsonpage']);
	$offset = ($Page - 1) * $limit;
	$total_count = $this->catalogMgr->GetCatalogProductsCount($catalog->ID, 1);

	if($limit>0)
		$pages = ceil($total_count/$limit);
	else
		$pages = 0;

	if(mb_strlen($catalog->SeoTitle) > 0)
		App::$Title->AppendBefore($catalog->SeoTitle);
	else
		App::$Title->AppendBefore($catalog->Name);

	App::$Title->Description = strip_tags(UString::ChangeQuotes($catalog->SeoDescription));
	App::$Title->Keywords = strip_tags(UString::ChangeQuotes($catalog->SeoKeywords));

	$products = $this->catalogMgr->GetCatalogProducts($catalog->ID, 1, $limit, $offset);

	$magic_word = UString::word4number($total_count, "единица", "единицы", "единиц");
	$total_count .=" ".$magic_word;

	return STPL::Fetch('modules/catalog_el/products_list', array(
															'products' => $products,
															'section_name' 	=> $catalog->Name,
															'header_note'	=> $catalog->Note,
															'count' 		=> $total_count,
															'page'			=> $Page,
															'pages'			=> $pages
														));