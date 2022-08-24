<?
    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => 1,
        ],
        'field' => ['Ord'],
        'dir' => ['ASC'],
        'calc' => false,
        'dbg' => 0,
    ];

    LibFactory::GetMStatic('clients', 'clientmgr');

    return ClientMgr::GetInstance()->GetClients($filter);