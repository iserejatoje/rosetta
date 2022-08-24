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

    $clients = $this->clientmgr->GetClients($filter);

    return STPL::Fetch('modules/clients/default', [
        'list' => $clients,
    ]);