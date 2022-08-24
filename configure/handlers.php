<?

return array(
		'http' => array(
			array('name' => 'captcha', 'uri' => '@^/site/captcha(/([^\?/]+)?)/?@', 'matches' => array(2 => 'key'), 'last' => true),
			array('name' => 'source', 'uri' => '/site/source/'),
			array('name' => 'editors', 'uri' => '@^/site/editors/@', 'matches' => array(), 'last' => true),
			array('name' => 'widget', 'uri' => '/site/widget/'),
			array('name' => 'eshop', 'uri' => '@^/eshop/product/(\d+)/$@', 'matches' => array(1 => 'ProductID'), 'last' => true),			
			array('type' => 'chain', 'objects' => array( // в эту цепочку добавлять хендлеры, для которых необходима отработка девелстат
					// админка
					array('name' => 'admin', 'uri' => '/admin/', 'domain' => $OBJECTS['sites'], 'last' => true),					
					array('name' => 'antiflood', 'object' => 'antiflood', 'params' => array('init' => true)),					
					array('name' => 'modules', 'last' => true),
					
					)),
			array('name' => 'antiflood', 'object' => 'antiflood'),			
		),
	);
?>
