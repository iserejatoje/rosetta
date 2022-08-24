<?
$form = array();

$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

if($this->_lib_mail !== null)
{
	$form['mail_services']			= $this->_lib_mail->GetMailServices();
	$form['mail_default_service']	= $this->_lib_mail->GetDefaultMailService();
}

$form['secret_key'] = App::$Request->Post['secret_key']->Value();
  	    
if( App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'register_offline')
{
	$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML);
	
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_INCORRECT_SETTINGS_RETYPE_PASSWORD);
	$form['email_examples']		= $this->_examples['email'];
	$form['email_examples_reg']	= $this->_examples['email_reg'];
	$form['name_examples']		= $this->_examples['name'];
	$form['email_type']			= App::$Request->Post['email_type']->Alpha('');
	$form['email']				= App::$Request->Post['email']->Value(Request::OUT_HTML);
	$form['answer']				= $POST['answer'];
	
	if( !empty($POST['domain']))
		$form['domain']			= $POST['domain'];
	else
		$form['domain']			= $form['mail_default_service'];
		
	$form['username']			= $POST['username'];
	$form['reg']				= App::$Request->Post['reg']->Int(0, Request::UNSIGNED_NUM);
	if( !empty($POST['domain_reg']) )
		$form['domain_reg']		= $POST['domain_reg'];
	else
		$form['domain_reg']		= $form['mail_default_service'];
	$form['username_reg']		= $POST['username_reg'];

	$form['confirm']			= isset(App::$Request->Post['confirm']);
	
	$form['firstname']			= $POST['firstname'];
	$form['lastname']			= $POST['lastname'];
	$form['midname']			= $POST['midname'];
	$form['birthday_year']		= App::$Request->Post['birthday_year']->Int(0, Request::UNSIGNED_NUM);
	$form['birthday_month']		= App::$Request->Post['birthday_month']->Int(0, Request::UNSIGNED_NUM);
	$form['birthday_day']		= App::$Request->Post['birthday_day']->Int(0, Request::UNSIGNED_NUM);
	
	$form['gender']				= App::$Request->Post['gender']->Int(0, Request::UNSIGNED_NUM);
	
	$form['city']				= App::$Request->Post['city']->AlNum('');
	$form['district']			= App::$Request->Post['district']->AlNum('');
	$form['street']				= App::$Request->Post['street']->AlNum('');
	$form['house']				= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['house_index']		= App::$Request->Post['house_index']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	
	$form['showhow']			= App::$Request->Post['showhow']->Int(0, Request::UNSIGNED_NUM);
	$form['url'] 				= App::$Request->Post['url']->Url();
}
else
{
	$form['city']				= $this->_env['site']['city_code'];
	$form['email_type']			= 'old';
	$form['url'] 				= App::$Request->Get['url']->Url();
}

	LibFactory::GetStatic('arrays');
	$form['years_arr']		= range(date('Y') , 1900);
	$form['months_arr']		= Arrays::$Month['subjective'];
	$form['days_arr']		= range(1, 31);

	LibFactory::GetStatic('location_v3');

	$loc_pc = Location_V3::ParseCode($this->_env['site']['city_code']);

	// [B] Список городов (только избранные)
	$form['city_arr'] = Location_V3::GetPlaces($loc_pc['continentcode'], $loc_pc['countrycode'], $loc_pc['region'], null, -1, 0, 8, 1);
	foreach( $form['city_arr'] as $k => $v) {
		$form['city_arr'][$v['Code']] = array(
			'Name' => $v['Name'],
			'Code' => $v['Code'],
		);
		
		unset($form['city_arr'][$k]);
	}
	
	if ( !isset($form['city_arr'][ $form['city'] ]) ) {
		$objects = Location_V3::GetObjectByCode($form['city']);
		if ( is_array($objects) && sizeof($objects) )
			$form['city_arr'][$objects[0]['Code']] = array(
				'Name' => $objects[0]['Name'],
				'Code' => $objects[0]['Code'],
			);
	}
	
	// [E] Список городов
	
	// [B] Список районов города
	
	$loc_pc = Location_V3::ParseCode($form['city']);
	$form['district_arr'] = Location_v3::GetAreas($loc_pc['continentcode'], $loc_pc['countrucode'], $loc_pc['region'], $loc_pc['regioncode'], $loc_pc['citycode'], $loc_pc['placecode']);
	foreach( $form['district_arr'] as &$v) {	
		$v = array(
			'Name' => $v['Name'],
			'Code' => $v['Code'],
		);
	}

	// [E] Список районов города
	
	// [B] Список улиц города (лимитировано (улиц может быть очень много))

	$form['street_count'] = Location_v3::GetStreetsCount($loc_pc['continentcode'], $loc_pc['countrycode'], $loc_pc['region'], $loc_pc['regioncode'], $loc_pc['citycode'], $loc_pc['placecode']);
	Location_V3::SetLimit(200);
	if ($form['street_count'] <= 200 )
		$form['street_arr'] = Location_v3::GetStreets($loc_pc['continentcode'], $loc_pc['countrycode'], $loc_pc['region'], $loc_pc['regioncode'], $loc_pc['citycode'], $loc_pc['placecode']);
	else
		$form['street_arr'] = array();

	$exists = false;
	foreach( $form['street_arr'] as &$v) {
		if ( !$exists && $form['street'] === $v['Code'])
			$exists = true;
	
		$v = array(
			'Name' => $v['FullName'],
			'Code' => $v['Code'],
		);
	}
	
		// Если в список не попала улица выбранная пользователем - добавить
	if ( !$exists ) {
		$objects = Location_V3::GetObjectByCode($form['street']);
		if ( is_array($objects) && sizeof($objects) )
			$form['street_arr'][] = array(
				'Name' => $objects[0]['FullName'],
				'Code' => $objects[0]['Code'],
			);
	}

	Location_V3::SetLimit();
	// [E] Список улиц города
	
return array(
		'form' => $form,
		);
?>