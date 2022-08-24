<?php

$page = 1;

$rewards_filter = [
	'flags' => [
		'objects' => true,
		'is_visible' => 1,
	],
	'field' => 'ord',
	'dir' => 'ASC', 
	// 'offset'=> ($page - 1) * $this->_config['rowsonpage'],
 //    'limit' => $this->_config['rowsonpage'],
    // 'calc'  => true,
    'dbg' => 0,
];

$rewards = $this->rewardmgr->GetRewards($rewards_filter);

$maxOpinions = 4;
$opinions_filter = [
	'flags' => [
		'objects' => true,
		'is_visible' => 1,
	],
	'field' => 'ord',
	'dir' => 'ASC', 
    'limit' => $maxOpinions,
    'calc'  => true,
    'dbg' => 0,
];

list($opinions, $count) = $this->rewardmgr->GetOpinions($opinions_filter);

$hasMore = false;
if($count > $maxOpinions) {
	$hasMore = true;
}

return STPL::Fetch('modules/reward/default', [
	'rewards' => $rewards,
	'opinions' => $opinions,
	'hasMore' => $hasMore
]);