<?
    $sectionid = App::$Env['sectionid'];
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

    list($list, $count) = $this->blockmgr->GetBlocks($filter);

    $uri = str_replace("/", "", $_SERVER['REQUEST_URI']);
    $template = preg_replace('/^(.+?)(\?.*?)?(#.*)?$/', '$1$3', $uri);

    $blocks = [];
    foreach($list as $block) {
        if($block->isvisible == 0)
            continue;

        $blocks[$block->nameid] = $block;
    }

    // temp crutch
    if($template =='about_new')
        $template = 'about';

    $template = str_replace("_new", "", $template);

    // ============================
    LibFactory::GetStatic('bl');
    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('section', $sectionid);

    $list = [];
    $method_name = '_get_'.$config['injection'];
    if($config['injection'])
        $list = $this->$method_name();

    // баннер
    LibFactory::GetMStatic('banners', 'bannermgr');
    // id баннерного места Корпоративные клиенты
    $place_id = 3;

    $banner = BannerMgr::getInstance()->GetBannersByPlaceID($place_id);
    if(is_array($banner) && count($banner) > 0) {
        $banner = $banner[0];
    }

    return STPL::Fetch('modules/blocks/'.$template, [
        'blocks' => $blocks,
        'list'   => $list,
        'banner' => $banner,
    ]);