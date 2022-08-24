<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$currentweather	= App::$Request->Post['currentweather']->Int(0, Request::UNSIGNED_NUM);
$showweather	= App::$Request->Post['showweather']->Int(0, Request::UNSIGNED_NUM);
$city			= App::$Request->Post['city']->Int(0, Request::UNSIGNED_NUM);

LibFactory::GetStatic('source');
$_c = Source::getData('db.location',array('type'=>'city','id'=>$city));
if ( !is_array($_c) || !sizeof($_c) )
	$city = 0;

$OBJECTS['user']->Profile['widgets']['announce']['weather']['CurrentWeather']	= $currentweather;
$OBJECTS['user']->Profile['widgets']['announce']['weather']['ShowWeather']		= $showweather;
$OBJECTS['user']->Profile['widgets']['announce']['weather']['City']				= $city;

$OBJECTS['log']->Log(
		301,
		0,
		array()
		);
Response::Redirect('/' . $this->_env['section'] . '/msg.announce_weather.html');
?>
