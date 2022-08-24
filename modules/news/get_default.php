<?
    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'Year' => date('Y', time()),
        ],
        'field' => ['published'],
        'dir' => ['DESC'],
        'calc' => true,
        'dbg' => 0,
    ];

    $years = $this->newsmgr->GetYears(true);

    list($news, $count) = $this->newsmgr->GetNewsList($filter);

    if($count < 5) {
        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'YearLess' => date('Y', time()),
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

   

    return STPL::Fetch('modules/news/default', [
        'news' => $news,
        'years' => $years,
        'count' => $count + $add_count,
    ]);