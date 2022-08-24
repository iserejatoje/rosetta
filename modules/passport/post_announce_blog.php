<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$blogfavorites =  App::$Request->Post['blogfavorites']->Int(0, Request::UNSIGNED_NUM);

$OBJECTS['user']->Profile['widgets']['announce']['blog']['Favorites']	= $blogfavorites;
$OBJECTS['log']->Log(
		297,
		0,
		array()
		);
Response::Redirect('/' . $this->_env['section'] . '/msg.announce_blog.html');
?>
