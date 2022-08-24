<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $params     = App::$Request->Post['params']->AsArray([]);

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
        ],
        'field' => ['Ord'],
        'dir' => ['ASC'],
        'calc' => true,
        'dbg' => 0,
    ];

    if(count($params) > 0)
        $filter['flags']['params'] = $params;

    list($groups, $count) = $this->osgallerymgr->GetGroups($filter);
    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'templated_pages',
        'list' => STPL::Fetch('modules/osgallery/list', ['list' => $groups]),
        'count' => $count,
    ));
    exit;


