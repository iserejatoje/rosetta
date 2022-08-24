<?
	$productID = trim($this->_params['id'], "/");

	$product = $this->catalogMgr->GetVisibleProduct($productID);
	if(!is_object($product))
	{
		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}

	if(mb_strlen($product->SeoTitle) > 0)
		App::$Title->AppendBefore($product->SeoTitle);
	else
		App::$Title->AppendBefore($product->Name);

	App::$Title->Description = strip_tags(UString::ChangeQuotes($product->SeoDescription));
	App::$Title->Keywords = strip_tags(UString::ChangeQuotes($product->SeoKeywords));



	$refer = $_SERVER['HTTP_REFERER'];

	$regexp ='@^http://'.MAIN_DOMAIN.'/'.App::$CurrentEnv["section"].'/([^/]+)/?$@';
	$matches = array();

	if(preg_match($regexp, $refer,$matches)) 
	{
		$catalogLink = $matches[1];
		$catalog = $this->catalogMgr->GetProductCatalogByReferer($product->ID, $catalogLink);
	}
	else
	{
		$catalog = $this->catalogMgr->GetProductCatalogByReferer($product->ID);
	}

	$this->_cataloglink = $catalog->Link;

	if(!is_object($catalog))
	{
		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}


	$mainProperty = $product->mainproperty;
	$tabProperties = $product->tabproperties;

	$actionTime = 0;
	if ($product->IsAction) {
		$actionTime = $product->ActionExpire - time();

		if ($actionTime <= 0 && $product->IsActionLoop) {
			$expiredActionTime = abs($actionTime) % $product->ActionDuration;
			$currentActionTime = $product->ActionDuration - $expiredActionTime;
			$product->ActionExpire = time() + $currentActionTime;
			$product->Update();
			$actionTime = $currentActionTime;
		}
	}

	return STPL::Fetch('modules/catalog_el/product_card', array(
															'product' => $product,
															'actionTime' => $actionTime,
															'mainProperty' => $mainProperty,
															'tabProperties' => $tabProperties,
															'catName'		=> $catalog->Name,
															'catNote'		=> $catalog->Note,
															'catLink'		=> $catalog->Link
															));