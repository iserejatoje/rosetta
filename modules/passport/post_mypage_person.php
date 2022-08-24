<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$firstname		= trim(App::$Request->Post['firstname']->Value(Request::OUT_HTML_CLEAN));// | Request::OUT_HTML
$lastname		= trim(App::$Request->Post['lastname']->Value(Request::OUT_HTML_CLEAN));// | Request::OUT_HTML
$midname		= trim(App::$Request->Post['midname']->Value(Request::OUT_HTML_CLEAN));// | Request::OUT_HTML
$birthday_day	= App::$Request->Post['birthday_day']->Int(0, Request::UNSIGNED_NUM);
$birthday_month	= App::$Request->Post['birthday_month']->Int(0, Request::UNSIGNED_NUM);
$birthday_year	= App::$Request->Post['birthday_year']->Int(0, Request::UNSIGNED_NUM);

$gender			= App::$Request->Post['gender']->Enum(0, array(1,2));
$postcode		= App::$Request->Post['postcode']->Value(Request::OUT_HTML_CLEAN);
$area			= App::$Request->Post['area']->Value(Request::OUT_HTML_CLEAN);
$district		= App::$Request->Post['district']->Value(Request::OUT_HTML_CLEAN);
$city			= App::$Request->Post['city']->Value(Request::OUT_HTML_CLEAN);
$street			= App::$Request->Post['street']->Value(Request::OUT_HTML_CLEAN);
$apartment		= App::$Request->Post['apartment']->Value(Request::OUT_HTML_CLEAN);
$house			= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN);
$phone			= App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
$floor			= App::$Request->Post['floor']->Int(0, Request::UNSIGNED_NUM);
$persons		= App::$Request->Post['persons']->Int(0, Request::UNSIGNED_NUM);

	
if($gender == 0)
	UserError::AddErrorIndexed('gender', ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY);
	
/*if(strlen($apartment) == 0)
	UserError::AddErrorIndexed('apartment', ERR_M_PASSPORT_APARTMENT_EMPTY);
	*/
if(strlen($house) == 0)
	UserError::AddErrorIndexed('house', ERR_M_PASSPORT_HOUSE_EMPTY);
	
if(!Data::Is_Phone($phone))
	UserError::AddErrorIndexed('phone', ERR_M_PASSPORT_PHONE_INCORRECT);


if($gender == 0)
	UserError::AddErrorIndexed('gender', ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY);

if ( isset(App::$Request->Post['height']) && ($height < $this->_config['height'][0] || $height > $this->_config['height'][1]) )
	UserError::AddErrorIndexed('height', ERR_M_PASSPORT_INCORRECT_SETTINGS_HEIGHT, $this->_config['height'][0], $this->_config['height'][1]);

if ( isset(App::$Request->Post['weight']) && ($weight < $this->_config['weight'][0] || $height > $this->_config['weight'][1]) )
	UserError::AddErrorIndexed('weight', ERR_M_PASSPORT_INCORRECT_SETTINGS_WEIGHT, $this->_config['weight'][0], $this->_config['weight'][1]);
	
if(strlen($firstname) == 0)
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EMPTY);
if(strlen($lastname) == 0)
	UserError::AddErrorIndexed('lastname', ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_EMPTY);
if(strlen($firstname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_LEN, $this->_config['limits']['max_len_name']);
if(strlen($lastname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('lastname', ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_LEN, $this->_config['limits']['max_len_name']);
if(strlen($midname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('midname', ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_LEN, $this->_config['limits']['max_len_name']);


if($birthday_day > 31)
	$birthday_day = 0;
if($birthday_month > 12)
	$birthday_month = 0;
if($birthday_year != 0)
{
	if($birthday_year < 1900)
		$birthday_year = 1900;
	elseif($birthday_year > date('Y'))
		$birthday_year = date('Y');
}


$birthday = sprintf('%04d-%02d-%02d', $birthday_year, $birthday_month, $birthday_day);
	
if(UserError::IsError())
	return false;

$house = $house ? trim("{$house}-{$house_index}", '-') : '';

// Логирование изменений профиля
$ChangedFields = array();
if ( $this->_config['log_profile_changes'] === true )
{
	if ( $OBJECTS['user']->Profile['general']['FirstName'] != $firstname )
		$ChangedFields['FirstName'] = $firstname;
	if ( $OBJECTS['user']->Profile['general']['LastName'] != $lastname )
		$ChangedFields['LastName'] = $lastname;
	if ( $OBJECTS['user']->Profile['general']['MidName'] != $midname )
		$ChangedFields['MidName'] = $midname;
	//if ( $OBJECTS['user']->Profile['general']['CityText'] != $city_text )
		//$ChangedFields['CityText'] = $city_text;
	if ( $OBJECTS['user']->Profile['general']['About'] != $about )
		$ChangedFields['About'] = $about;
	if ( $OBJECTS['user']->Profile['general']['WorkPlace'] != $workplace )
		$ChangedFields['WorkPlace'] = $workplace;
	if ( $OBJECTS['user']->Profile['general']['Position'] != $position )
		$ChangedFields['Position'] = $position;
}
	
$OBJECTS['user']->Profile['general']['FirstName']	= $firstname;
$OBJECTS['user']->Profile['general']['LastName']	= $lastname;
$OBJECTS['user']->Profile['general']['MidName']		= $midname;
$OBJECTS['user']->Profile['general']['BirthDay']	= $birthday;
$OBJECTS['user']->Profile['general']['Gender']		= $gender;

$OBJECTS['user']->Profile['general']['Street']		= $street;
$OBJECTS['user']->Profile['general']['Apartment']	= $apartment;
$OBJECTS['user']->Profile['general']['House']		= $house;
$OBJECTS['user']->Profile['general']['Phone']		= $phone;
$OBJECTS['user']->Profile['general']['Floor']		= $floor;
$OBJECTS['user']->Profile['general']['Persons']		= $persons;

$OBJECTS['user']->Profile['general']['ShowHow'] = 1;

Response::Redirect('/' . $this->_env['section'] . '/msg.mypage_person.html');

?>