<?
    $page = 1;
	$filter = [
		'flags' => [
			'objects' => true,
			'IsVisible' => 1,
			'IsAnswered' => -1,
		],
		'field' => 'ord',
		'dir' => 'ASC', 
		'offset'=> ($page - 1) * $this->_config['rowsonpage'],
        'limit' => $this->_config['rowsonpage'],
        'calc'  => true,
        'dbg' => 0,
	];

	list($questions, $count) = $this->faqmgr->GetQuestions($filter);


    $last_page = false;
    if($count <= intval($this->_config['rowsonpage']))
        $last_page = true;

	return STPL::Fetch('modules/faq/default', ['questions' => $questions, 'last_page' => $last_page]);