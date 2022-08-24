<?
    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
            'HasPickup' => 1,
        ],
        'field' => ['ord'],
        'dir' => ['ASC'],
        'calc' => false,
        'dbg' => 0,
    ];

    LibFactory::GetMStatic('cities', 'citiesmgr');

    return CitiesMgr::GetInstance()->GetStores($filter);