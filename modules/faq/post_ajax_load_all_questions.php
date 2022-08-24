<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'IsAnswered' => -1,
        ],
       //'offset'=> ($page - 1) * $this->_config['rowsonpage'],
       'offset'=> $this->_config['rowsonpage'],
       //'limit' => $this->_config['rowsonpage'],
       'limit' => 99999999999,
       'field' => 'ord',
       'dir' => 'ASC', 
       'calc'  => true,
    ];

    list($questions, $count) = $this->faqmgr->GetQuestions($filter);

    $last_page = true;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'all_questions',
        'last_page' => $last_page,
        'list' => STPL::Fetch('modules/faq/list', ['questions' => $questions, 'last_page' => $last_page]),
    ));

    exit;
