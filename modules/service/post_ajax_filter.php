<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $params     = App::$Request->Post['params']->AsArray([]);
    $ServiceID  = App::$Request->Post['ServiceID']->Int(0, Request::UNSIGNED_NUM);

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'ServiceID' => $ServiceID,
        ],
        'field' => ['Ord'],
        'dir' => ['ASC'],
        'calc' => true,
        'dbg' => 0,
    ];

    if(count($params) > 0) {
        $filter['flags']['params'] = $params;
        $filter['group']['fields'] = ['GroupID'];
    }

    list($groups, $count) = ServiceMgr::getInstance()->GetGroups($filter);
    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'templated_pages',
        'list' => STPL::Fetch('modules/service/list', ['list' => $groups]),
        'count' => $count,
    ));
    exit;


