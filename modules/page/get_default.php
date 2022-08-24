<?

	if (!empty($this->_params['path']))	
		Response::Status(404, RS_EXIT | RS_SENDPAGE);

	$sectionId = $this->_env['sectionid'];
	if($this->_config['root'])
		$sectionId = $this->_config['root'];
	error_log("we are in page module");
		
	$page = $this->pagemgr->GetPageBySectionID($sectionId);
	if ($page === null)
		Response::Status(404, RS_EXIT | RS_SENDPAGE);
	
	if ($page->IsVisible === false)
		Response::Status(404, RS_EXIT | RS_SENDPAGE);
		
	if ($this->_env['sectionid']==11861) //страница /about
	{
		App::$Title->Add('link', array('rel' => 'canonical', 'href' => 'http://takemix.ru/'));
	}
	
	$params = array(
		'page' => $page,
	);
	
	return STPL::Fetch('modules/page/default', $params);