<?
    $service = $this->servicemgr->GetServiceByPath($this->_params['path']);
    if($service == null)
        Response::Status(404, RS_SENDPAGE | RS_EXIT);


    // $sectionid = App::$Env['sectionid'];

    // // if($page === null || $page->isvisible == 0)

    // $filter = [
    //     'flags' => [
    //         'objects' => true,
    //         'IsVisible' => 1,
    //         'Url' => $,
    //     ],
    //     'field' => ['Ord'],
    //     'dir' => ['ASC'],
    //     'calc' => true,
    //     'dbg' => 0,
    // ];

    // list($groups, $count) = $this->osgallerymgr->GetGroups($filter);

    // $uri = str_replace("/", "", $_SERVER['REQUEST_URI']);
    // $uri = preg_replace('/^(.+?)(\?.*?)?(#.*)?$/', '$1$3', $uri);


    App::$Title->Title = $service->SeoTitle;
    App::$Title->Description = strip_tags(UString::ChangeQuotes($service->SeoDescription));
    App::$Title->Keywords = strip_tags(UString::ChangeQuotes($service->SeoKeywords)); 


    $filter = [
        'service_ids' => [
            $service->ServiceID,
        ],

        'field' => ['ord'],
        'dir' => ['ASC'],
    ];

    $filters = $this->servicemgr->GetFilters($filter);


    foreach ($filters as $filter) {
        $attrs = [
            'field' => ['ord'],
            'dir'   => ['ASC'],
            'dbg' => 0,
        ];
        $params = $filter->GetParams($attrs);
        $cfilter[$filter->NameID]['visible'] = array_slice($params, 0, 3);
        $cfilter[$filter->NameID]['hidden'] = array_slice($params, 3, count($params) - 3);
        $cfilter[$filter->NameID]['name'] = $filter->Name;
    }





    return STPL::Fetch('modules/service/default', [
        'service'   => $service,
        'list'      => $service->visible_groups,
        'filter'    => $cfilter,
        'last_page' => true,
    ]);