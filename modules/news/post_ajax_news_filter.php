<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $year = App::$Request->Post['news_year']->Int(0, Request::UNSIGNED_NUM);

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'Year' => $year,
        ],
        'field' => ['published'],
        'dir' => ['DESC'],
        'calc' => true,
        'dbg' => 0,
    ];

    $years = $this->newsmgr->GetYears(true);

    list($news, $count) = $this->newsmgr->GetNewsList($filter);

    if(($year == date('Y', time())) && $count < 5) {
        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'YearLess' => $year,
            ],
            'field' => ['published'],
            'dir' => ['DESC'],
            'limit' => 20,
            'calc' => true,
            'dbg' => 0,
        ];
        
        list($news_add, $add_count) = $this->newsmgr->GetNewsList($filter);


        !empty($news) && !empty($news_add) ? 
            $news = array_merge($news, $news_add)  :  $news = $news ?: $news_add;

    }


    echo $json->encode(array(
        'status' => 'ok',
        'list' => STPL::Fetch('modules/news/list', [
            'news' => $news,
        ]),
    ));
    exit;