<?php
include_once $CONFIG['engine_path'].'include/json.php';
$json = new Services_JSON();

$page = App::$Request->Post['page']->Int(1, Request::UNSIGNED_NUM);

$filter = [
    'flags' => [
        'is_visible' => 1,
        'objects' => true,
    ],

    'field' => ['ord'],
    'dir'   => ['asc'],
    'limit' => 184467440737095,
    'offset'=> $this->_config['rowsonpage'],
    'calc'  => false,
    'dbg' => 0,
];


$list = $this->rewardmgr->GetOpinions($filter);

$params = [
    'list' => $list,
];

echo $json->encode([
    'status' => 'ok',
    'action' => 'all_reviews',
    'last_page' => true,
    'list' => STPL::Fetch('modules/reward/list', $params),
]);

exit;
