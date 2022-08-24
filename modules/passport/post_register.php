<?
// ескейпит библиотека непосредственно перед работой с базой

if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

$captcha = LibFactory::GetInstance('captcha');

if(!$captcha->is_valid())
	UserError::AddErrorIndexed('captcha', ERR_M_PASSPORT_WRONG_CAPTCHA);

if(UserError::IsError())
	return false;

/*	
LibFactory::GetStatic('antiflood2');
if ( !AntiFlood2::Check('passport:register', AntiFlood2::K_IP) )
	Response::Status(423, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);
*/
$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML_CLEAN | Request::OUT_HTML);

/**
 * =================================
 * ПРОВЕРЯЕМ EMAIL
 * =================================
 */
$email = App::$Request->Post['email']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
if(empty($email))
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);

if (strlen($email) > $this->_config['limits']['max_len_email'])
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
elseif( !Data::Is_Email($email) )
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
elseif(PUsersMgr::IsEMailExists($email))
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS);	


/**
 * =================================
 * ПРОВЕРЯЕМ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ
 * =================================
 */
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
$apartment		= App::$Request->Post['apartment']->Int(0, Request::UNSIGNED_NUM);
$house			= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN);
$phone			= App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);

/*if(!preg_match("@\d{6}@", $postcode))
	UserError::AddErrorIndexed('postcode', ERR_M_PASSPORT_INCORRECT_POSTCODE);

if($gender == 0)
	UserError::AddErrorIndexed('gender', ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY);

if(strlen($city) == 0)
	UserError::AddErrorIndexed('city', ERR_M_PASSPORT_CITY_EMPTY);*/
	
if(strlen($street) == 0)
	UserError::AddErrorIndexed('street', ERR_M_PASSPORT_STREET_EMPTY);
	
if($apartment == 0)
	UserError::AddErrorIndexed('apartment', ERR_M_PASSPORT_APARTMENT_EMPTY);
	
if(strlen($house) == 0)
	UserError::AddErrorIndexed('house', ERR_M_PASSPORT_HOUSE_EMPTY);
	
if(!Data::Is_Phone($phone))
	UserError::AddErrorIndexed('phone', ERR_M_PASSPORT_PHONE_INCORRECT);
	
if(strlen($firstname) == 0)
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EMPTY);
if (strlen($lastname) == 0)
	UserError::AddErrorIndexed('lastname', ERR_M_PASSPORT_LASTNAME_IS_EMPTY);

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
	
/**
 * =================================
 * ПРОВЕРЯЕМ ПАРОЛИ
 * =================================
 */
$password = App::$Request->Post['password']->Value();	// любой, хэшируем
if(!is_string($password))
	$password = '';
$password2 = App::$Request->Post['password2']->Value();
if(!is_string($password2))
	$password2 = '';

if($password=='' || $password2=='')
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_EMPTY_PASSWORD);
else if(strcmp($password, $password2) != 0)
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_PASSWORD_NOT_EQUAL);

// если чего-то не так - то ругаемся.
if(UserError::IsError())
	return false;

/**
 * =================================
 * РЕГИСТРИРУЕМ
 * =================================
 */
$user = array();
$user['OurEmail'] = '';

// Для теста регистрации почты в асинке
$user['Email']		= $email;
$user['Password']	= $password;
$user['Question']	= $question_text;
$user['Answer']		= $answer;
$user['RegionID']	= $this->_env['regid'];
$user['DomainName']	= $this->_env['site']['domain'];

$userID = PUsersMgr::Add($user);
if( $userID === null )
{
	UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_REG_ADD_USER);
	return false;
}

PGroupMgr::SetGroupsForUser($userID, 29, true);

$usr = $OBJECTS['usersMgr']->GetUser($userID);
$usr->Profile['general']['FirstName']	= $firstname;
$usr->Profile['general']['LastName']	= $lastname;
$usr->Profile['general']['MidName']		= $midname;
$usr->Profile['general']['BirthDay']	= $birthday;
$usr->Profile['general']['Gender']		= $gender;
$usr->Profile['general']['PostCode']	= $postcode;
$usr->Profile['general']['Area']		= $area;
$usr->Profile['general']['District']	= $district;
$usr->Profile['general']['City']		= $city;
$usr->Profile['general']['Street']		= $street;
$usr->Profile['general']['Apartment']	= $apartment;
$usr->Profile['general']['House']		= $house;
$usr->Profile['general']['Phone']		= $phone;
$usr->Profile['general']['ShowHow']		= $showhow;

$usr->Dispose();
$code = $OBJECTS['usersMgr']->AddActivationCode($userID, $email, 1);
$subj = "Подтверждение регистрации на сайте ".$this->_env['site']['domain']."\n";
$header = "Content-Type: text/html ; charset=utf-8;\nMIME-Version: 1.0\nFrom: takemix.ru <remind@".$this->_env['site']['domain'].">\n";	
$msg = "Здравствуйте ".$firstname." ".$lastname.".<br><br>
Вы зарегистрировались на сайте ".$this->_env['site']['domain'].".<br>
Для подтверждения регистрации Вам необходимо пройти по следующей ссылке:<br>
<a href=\"" . App::$Protocol . $this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."\" target=\"_blank\">". App::$Protocol . $this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."</a>.<br><br>
Если у Вас не получается перейти по ссылке, то введите код активации на странице <a href=\"" . App::$Protocol  .$this->_env['site']['domain']."/".$this->_env['section']."/activation.php\" target=\"_blank\">" . App::$Protocol .$this->_env['site']['domain']."/".$this->_env['section']."/activation.php</a><br>
Код активации: <b>".$code."</b><br><br>
Если в течение 48 часов Вы не подтвердите регистрацию, то она будет отменена.<br><br>
С уважением,<br>
&nbsp;&nbsp;&nbsp;Служба поддержки ".$this->_env['site']['domain'];

mail($email, $subj, $msg, $header);

$redirectUrl = '/'.$this->_env['section'].'/msg.activation.html';

Response::Redirect($redirectUrl);