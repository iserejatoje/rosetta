<?
	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1
		),
		'field' => array('Ord'),
		'dir' => array('ASC'),
	);

	$blocks = $this->deliverymgr->GetBlocks($filter);

	return STPL::Fetch('modules/delivery/default', array(
		'blocks' => $blocks,
	));