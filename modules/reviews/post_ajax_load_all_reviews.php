<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $page = App::$Request->Post['page']->Int(1, Request::UNSIGNED_NUM);

    $filter = array(
        'flags' => array(
            'IsVisible' => 1,
            'objects' => true,
        ),

        'field' => array(
            'Created',
        ),
        'dir'   => array(
            'DESC',
        ),
        'limit' => 184467440737095,
        'offset'=> ($page - 1) * $this->_config['rowsonpage'],
        'calc'  => false,
        'dbg' => 0,
    );



    $list = $this->reviewmgr->GetReviews($filter);
    $params = array(
        'list' => $list,

    );

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'all_reviews',
        'last_page' => true,
        'list' => STPL::Fetch('modules/reviews/list', $params),
    ));

    exit;
