<?
	$sectionId = $this->_env['sectionid'];
	if($this->_config['root'])
		$sectionId = $this->_config['root'];

	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1,
			'SectionID' => $sectionId,
		),
		'field' => array(
			'Ord',
		),
		'dir' => array(
			'DESC',
		),
		'dbg' => 0,
		// 'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
		// 'limit' => self::$ROW_ON_PAGE,
		// 'calc'	=> true,
	);


	$shares = $this->shareMgr->GetShares($filter);

	return STPL::Fetch("modules/shares/default", array(
		'shares' => $shares,
	));
