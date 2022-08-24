<?

$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

if($this->_lib_mail !== null)
{
	$mail_services			= $this->_lib_mail->GetMailServices();
	$mail_default_service	= $this->_lib_mail->GetDefaultMailService();
}

$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML_CLEAN | Request::OUT_HTML);

/**
 * =================================
 * ПРОВЕРЯЕМ СЕКРЕТНЫЙ КЛЮЧ
 * =================================
 */
$secret_key = App::$Request->Post['secret_key']->Value();
if ( $secret_key !== 'уфарулит' )
{
	UserError::AddErrorIndexed('secret_key', ERR_M_PASSPORT_INCORRECT_OFFLINE_REGISTER_SECRET_KEY);
	return false;
}

/**
 * =================================
 * ПРОВЕРЯЕМ EMAIL
 * =================================
 */

// регистрируем с существующим
$email = $POST['email'];
if(!is_string($email))
	$email = '';
           
if(empty($email))
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);

if (strlen($email) > $this->_config['limits']['max_len_email'])
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
elseif( App::$Request->Post['email']->Email(false) === false )
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
elseif(PUsersMgr::IsEMailExists($email))
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS);
	
if(UserError::IsError())
	return false;

if(App::$Request->Post['reg']->Int(0) == 1)
{
	$username_reg = $POST['username_reg'];	// проверка функцией валидности мыла
	$domain_reg = $POST['domain_reg'];		// проверка функцией валидности мыла
	$login_reg = $email_reg = $POST['username_reg'];
	if(!is_string($email_reg))
		$login_reg = $email_reg = '';
	
	if(sizeof($mail_services) > 1)
		$domain_reg = $POST['domain_reg'];
	else
		$domain_reg = $mail_default_service;
	if(!isset($mail_services[$domain_reg]))
	{
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
		return false;
	}
	
	if(empty($email_reg) || empty($domain_reg))
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);
	
	$email_reg.= '@'.$domain_reg;
	if (strlen($email_reg) > $this->_config['limits']['max_len_email'])
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
	elseif( !Data::Is_Email($email_reg) )
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
	elseif(PUsersMgr::IsEMailExists($email_reg) || ($this->_lib_mail !== null && $this->_lib_mail->IsEMailExists($email_reg)))
	{
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS);
		if($this->_lib_mail !== null)
			$this->_examples['email_reg'] = $this->_lib_mail->GenerateEmail($login_reg, $domain_reg);
	}
}

/**
 * =================================
 * ПРОВЕРЯЕМ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ
 * =================================
 */

$firstname		= $POST['firstname'];
$lastname		= $POST['lastname'];
$midname		= $POST['midname'];

$birthday_day	= App::$Request->Post['birthday_day']->Int(0, Request::UNSIGNED_NUM);
$birthday_month	= App::$Request->Post['birthday_month']->Int(0, Request::UNSIGNED_NUM);
$birthday_year	= App::$Request->Post['birthday_year']->Int(0, Request::UNSIGNED_NUM);
$gender			= App::$Request->Post['gender']->Enum(0, array(1,2));
$showhow		= App::$Request->Post['showhow']->Int(0, Request::UNSIGNED_NUM);

$city				= App::$Request->Post['city']->AlNum('');
$district			= App::$Request->Post['district']->AlNum('');
$street				= App::$Request->Post['street']->AlNum('');
$house				= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
$house_index		= App::$Request->Post['house_index']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);

if($gender == 0)
	UserError::AddErrorIndexed('gender', ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY);
if(strlen(trim($firstname)) == 0)
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EMPTY);
if(strlen($firstname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_LEN, $this->_config['limits']['max_len_name']);
if(strlen($lastname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('lastname', ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_LEN, $this->_config['limits']['max_len_name']);
if(strlen($midname) > $this->_config['limits']['max_len_name'])
	UserError::AddErrorIndexed('midname', ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_LEN, $this->_config['limits']['max_len_name']);
	
/*if(PUsersMgr::IsNameExists($firstname, $lastname, $midname))
{
	UserError::AddErrorIndexed('firstname', ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EXISTS);
	if(strlen(trim($lastname)) == 0 && strlen(trim($midname)) == 0)
	{
		$this->_examples['name'] = PUsersMgr::GenerateNames($firstname);
	}
}*/

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

if ( !empty($house) && !Data::Is_Number($house) )
	UserError::AddErrorIndexed('house', ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_NUM);
	
$house_index = strtoupper($house_index);
if ( !empty($house) && !empty($house_index) && !preg_match("@^[\xc0-\сdf]$@", $house_index) )
	UserError::AddErrorIndexed('house', ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_INDEX);

$birthday = sprintf('%04d-%02d-%02d', $birthday_year, $birthday_month, $birthday_day);
	

// если чего-то не так - то ругаемся.
if(UserError::IsError())
	return false;
	
/**
* =================================
 * СОЗДАЕМ ВРЕМЕННЫЙ ПАРОЛЬ
* =================================
 */

$password = Data::GetRandStr(8);
$code = Data::GetRandStr(32);

/**
 * =================================
 * РЕГИСТРИРУЕМ
 * =================================
 */

$user = array();

// email_reg будет пуст в случае email_type = new
if(isset($email_reg) && $this->_lib_mail !== null)
{
	$status = $this->_lib_mail->CreateEmail($email_reg, $password);
	if($status<0)
	{
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_REG_EMAIL_ERROR);
		error_log('Email register failed: '.$email_reg.'. Status: '.$status.' Error: '.$this->_lib_mail->errors[$status]);
		return false;
	}
	$user['OurEmail'] = $email_reg;
	$OBJECTS['log']->Log(
			259,
			0,
			array('EMail' => $email, 'OurEMail' => $email_reg, 'Status' => $status)
			);
}
		
$user['Email']		= $email;
$user['Password']	= $password;
$user['RegionID']	= $this->_env['regid'];
$user['DomainName']	= $this->_env['site']['domain'];

$userID = PUsersMgr::Add($user);
if( $userID === null )
{
	UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_REG_ADD_USER);
	error_log('PUsersMgr::Add() failed: '.$email);
	return false;
}

$OBJECTS['log']->Log(
		258,
		0,
		array('email' => $email)
		);

PGroupMgr::SetGroupsForUser($userID, 29, true);	

error_log("user was offline-registered OK");

// добавляем хэш регистрации
PUsersMgr::$db->call_scalar('AddOfflineRegisterStatus','isi', $userID, $code, (int) $this->_env['regid']);

// заполняем профиль
$usr = $OBJECTS['usersMgr']->GetUser($userID);
$usr->Profile['general']['FirstName']	= $firstname;
$usr->Profile['general']['LastName']	= $lastname;
$usr->Profile['general']['MidName']		= $midname;
$usr->Profile['general']['BirthDay']	= $birthday;
$usr->Profile['general']['Gender']		= $gender;
$usr->Profile['general']['ShowHow']		= $showhow;

$LocationCode = '';
foreach(array('street','city') as $v) {
	if ( !empty($$v) ) {
		$LocationCode = $$v;
		break;
	}
}

if ( empty($city) ) {
	$LocationCode = $district = $house = $house_index = '';
} else if ( empty($street) ) {
	$house = $house_index = '';
}

$usr->Profile['location']['current'] = $LocationCode;
$usr->Profile['location']['district'] = $district;
$usr->Profile['location']['house'] = $house;
$usr->Profile['location']['houseindex'] = $house_index;

$usr->Dispose();
	
// авторизируем и редиректим на mypage
$OBJECTS['user'] = $OBJECTS['usersMgr']->Login($email, $password);
Response::Redirect('/'.$this->_env['section'].'/mypage/interest.php');


?>
