<?
return array(
	'74_utel' => array(
		'title' => 'Utel',
		'pattern' => array(
			'735190xxxxx','7902xxxxxxx','231xxxx','233xxxx',
			'235xxxx','79048xxxxxx','790494xxxxx','790881xxxxx',
			'790882xxxxx','790883xxxxx','7950xxxxxxx','7951xxxxxxx'
		),
		'phoneregexp' => array(
			'pattern' => '@((?:735190|79048|790494|790881|790882|790883)[\d]{5}|(?:7902|7950|7951)[\d]{6}|(?:231|233|235)[\d]{4})@', 
			'params' => array(1 => 'number')
		),
		'from' => 'mailer@74.ru',
		'subjects' => '',
		'mail' => '{number}@suct.ru',
		'codetable' => 'windows-1251',
		'maxlen' => 160,
		'sender' => 'mail'
	),
	'74_megafon' => array(
		'title' => 'Мегафон',
		'pattern' => array('7922xxxxxxx'),
		'phoneregexp' => array(
			'pattern' => '@7922([\d]{7})@', 
			'params' => array(1 => 'number')
		),
		'from' => 'mailer@74.ru',
		'subjects' => '',
		'mail' => '{number}@sms.ugsm.ru',
		'codetable' => 'windows-1251',
		'maxlen' => 160,
		'sender' => 'mail'
	),
);
?>