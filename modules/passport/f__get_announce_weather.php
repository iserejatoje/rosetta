<?
$form = array();
$form['form'] = array();

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'announce_weather')
{
	$form['form']['currentweather']	= App::$Request->Post['currentweather']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['showweather']	= App::$Request->Post['showweather']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['city']			= App::$Request->Post['city']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$form['form']['currentweather']	= $OBJECTS['user']->Profile['widgets']['announce']['weather']['CurrentWeather'];
	$form['form']['showweather']	= $OBJECTS['user']->Profile['widgets']['announce']['weather']['ShowWeather'];
	if ($OBJECTS['user']->Profile['widgets']['announce']['weather']['City'])
		$form['form']['city']  		= $OBJECTS['user']->Profile['widgets']['announce']['weather']['City'];
	else
		$form['form']['city'] 		= $this->_config['default_city'];
}

LibFactory::GetStatic('source');
$form['form']['city_arr'] = array();

$sql = 'SELECT city FROM weather_new_cur';
$result = DBFactory::GetInstance('rugion')->query('SELECT city FROM weather_new_cur');

while ( false != ($row = $result->fetch_row()) )
	 $form['form']['city_arr'][] = $row[0];

$form['form']['city_arr'] = Source::getData('db.location',array('type'=>'city','id'=>$form['form']['city_arr']));
asort($form['form']['city_arr']);
return $form;
?>