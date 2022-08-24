<?
    $sectionid = App::$Env['sectionid'];
    $page = $this->osgallerymgr->GetPageBySection($sectionid);

    // if($page === null || $page->isvisible == 0)

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'SectionID' => $sectionid,
        ],
        'field' => ['Ord'],
        'dir' => ['ASC'],
        'calc' => true,
        'dbg' => 0,
    ];

    list($groups, $count) = $this->osgallerymgr->GetGroups($filter);

    $uri = str_replace("/", "", $_SERVER['REQUEST_URI']);
    $uri = preg_replace('/^(.+?)(\?.*?)?(#.*)?$/', '$1$3', $uri);

    $filter_style = OSGalleryMgr::GetInstance()->GetFilterByName('style');
    if($filter_style !== null) {
        $params = $filter_style->GetParams($arrFilter);
        $cfilter['style']['visible'] = array_slice($params, 0, 2);
        $cfilter['style']['hidden'] = array_slice($params, 2, count($filter_style->params) - 2);
    }

    $filter_season = OSGalleryMgr::GetInstance()->GetFilterByName('season');
    if($filter_season !== null) {
        $params = $filter_season->GetParams($arrFilter);
        $cfilter['season']['visible'] = array_slice($params, 0, 3);
        $cfilter['season']['hidden'] = array_slice($params, 3, count($params) - 3);
    }

    $filter_color = OSGalleryMgr::GetInstance()->GetFilterByName('color');
    if($filter_color !== null) {
        $params = $filter_color->GetParams($arrFilter);
        $cfilter['color']['visible'] = array_slice($params, 0, 3);
        $cfilter['color']['hidden'] = array_slice($params, 3, count($params) - 3);
    }

    return STPL::Fetch('modules/osgallery/default', [
        'page'   => $page,
        'uri'    => $uri,
        'list'   => $groups,
        'filter' => $cfilter,
        'last_page' => true,
    ]);