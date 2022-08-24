<?
	$sectionId = $this->_env['sectionid'];

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
			'Created',
		),
		// 'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
		// 'limit' => self::$ROW_ON_PAGE,
		// 'calc'	=> true,
	);

	$list = $this->_vacancymgr->GetVacancies($filter);
	// foreach($list as $item)
	// {
	// 	foreach(explode(",", $item->Position) as $position)
	// 		echo trim($position)."<br>";
	// 	echo "<br>";
	// 	echo $item->Text;
	// 	echo "<hr>";
	// }
	// exit;


	return STPL::Fetch("modules/vacancy/default", array(
		'list' => $list,
	));