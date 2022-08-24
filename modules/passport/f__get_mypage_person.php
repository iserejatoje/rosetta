<?

$form = array();
$form['form'] = array();

if (isset($params[0]))
	$user = $OBJECTS['usersMgr']->GetUser($params[0]);
else
	$user = $OBJECTS['user'];

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'mypage_person')
{	
	$form['form']['firstname']			= App::$Request->Post['firstname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['lastname']			= App::$Request->Post['lastname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['midname']			= App::$Request->Post['midname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['birthday_year']		= App::$Request->Post['birthday_year']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['birthday_month']		= App::$Request->Post['birthday_month']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['birthday_day']		= App::$Request->Post['birthday_day']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['gender']				= App::$Request->Post['gender']->Int(0, Request::UNSIGNED_NUM);
	
	$form['form']['postcode']		= App::$Request->Post['postcode']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['area']		= App::$Request->Post['area']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['district']	= App::$Request->Post['district']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['city']			= App::$Request->Post['city']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['street']			= App::$Request->Post['street']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['apartment']		= App::$Request->Post['apartment']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['house']			= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN); 
	$form['form']['phone']			= App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
	$form['form']['floor']			= App::$Request->Post['floor']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['persons']		= App::$Request->Post['persons']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$birthday = $user->Profile['general']['BirthDay'];
	$year	= 0;
	$month	= 0;
	$day	= 0;
	if(preg_match('@^([\d]{4})-([\d]{2})-([\d]{2})$@', $birthday, $matches))
	{
		$year	= intval($matches[1]);
		$month	= intval($matches[2]);
		$day	= intval($matches[3]);
	}

	$form['form']['birthday_year']		= $year;
	$form['form']['birthday_month']		= $month;
	$form['form']['birthday_day']		= $day;

	if ( checkdate  ( $month  , $day  , $year  ) ) {
		$h = LibFactory::GetInstance('horoscope');
		$h->Init();
		$form['form']['zodiac']				= $h->GetZodiacByDate(strtotime($user->Profile['general']['BirthDay']));
	} else
		$form['form']['zodiac'] = false;

	$form['form']['nickname']			= $user->NickName;
	$form['form']['showname']			= $user->Profile['general']['ShowName'];
	$form['form']['firstname']			= $user->Profile['general']['FirstName'];
	$form['form']['lastname']			= $user->Profile['general']['LastName'];
	$form['form']['midname']			= $user->Profile['general']['MidName'];
	$form['form']['gender']				= $user->Profile['general']['Gender'];
	
	$form['form']['postcode']		= $user->Profile['general']['PostCode'];
	$form['form']['area']		= $user->Profile['general']['Area'];
	$form['form']['district']	= $user->Profile['general']['District'];
	$form['form']['city']			= $user->Profile['general']['City'];
	$form['form']['street']			= $user->Profile['general']['Street'];
	$form['form']['apartment']		= $user->Profile['general']['Apartment'];
	$form['form']['house']			= $user->Profile['general']['House'];
	$form['form']['phone']			= $user->Profile['general']['Phone'];
	$form['form']['floor']			= $user->Profile['general']['Floor'];
	$form['form']['persons']			= $user->Profile['general']['Persons'];

	
	if ( $user->Blocked != 1 )
	{   
		$form['form']['showvisited'] = $user->Profile['general']['showvisited'];
	}
	
}

$form['form']['allowchangeview'] = !$user->IsInRole('m_generation_member_'.$this->_env['regid'] );

if (!isset($params[0]))
{
	LibFactory::GetStatic('arrays');
	$form['form']['years_arr']		= range(date('Y') , 1900);
	$form['form']['months_arr']		= Arrays::$Month['subjective'];
	$form['form']['days_arr']		= range(1, 31);
}

$form['form']['children_arr'] = $this->_config['children'];
$form['form']['height_arr'] = $this->_config['height'];
$form['form']['weight_arr'] = $this->_config['weight'];

return $form;
?>