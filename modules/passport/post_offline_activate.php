<?

$UserID = false;
$code = App::$Request->Get['code']->Value();
if ( is_string($code) )
{
	$form['code'] = $code;
	// проверяем код
	$res = PUsersMgr::$db->call_assoc('CheckOfflineRegistrationCode', 's', $code);
	if ( $res['UserID'] > 0 )
	{
		$UserID = $res['UserID'];
	}
}
if ( $UserID === false )
{
	UserError::AddErrorIndexed('code', ERR_M_PASSPORT_INCORRECT_OFFLINE_ACTIVATION_CODE);
	return false;
}

$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML_CLEAN | Request::OUT_HTML);

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

/**
 * =================================
 * ПРОВЕРЯЕМ ВОПРОСЫ
 * =================================
 */

$question = App::$Request->Post['question']->Int(0, Request::UNSIGNED_NUM);
$question_text = $POST['question_text'];
if(!is_string($question_text))
	$question_text = '';
$answer = $POST['answer'];
if(!is_string($answer))
	$answer = '';

if($question === 0 || ($question === 100 && empty($question_text)) || ($question > 0 && $question !== 100 && !isset($this->_config['questions'][$question])))
	UserError::AddErrorIndexed('question', ERR_M_PASSPORT_EMPTY_QUESTION);
else if($question !== 0 && $question !== 100)
	$question_text = $this->_config['questions'][$question];

if(empty($answer))
	UserError::AddErrorIndexed('answer', ERR_M_PASSPORT_EMPTY_ANSWER);

// если чего-то не так - то ругаемся.
if(UserError::IsError())
	return false;

	
/**
 * =======================================
 * ОБНОВЛЯЕМ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ
 * =======================================
 */
 
$user = $OBJECTS['usersMgr']->GetUserInfoArray($UserID);
$user['Password']	= $password;
$user['Question']	= $question_text;
$user['Answer']		= $answer;
PUsersMgr::Update($user);

// логиним юзера
$OBJECTS['user'] = $OBJECTS['usersMgr']->Login($user['Email'], $password);

/**
 * =======================================
 * ОТПРАВЛЯЕМ ПРИВЕТСТВЕННОЕ ПИСЬМО
 * =======================================
 */
 
LibFactory::GetStatic('vars');
$firstname = trim($OBJECTS['user']->Profile['general']['FirstName']);
$lastname = trim($OBJECTS['user']->Profile['general']['LastName']);
$midname = trim($OBJECTS['user']->Profile['general']['MidName']);
						
$subj = "Вы успешно зарегистрировались в проекте «{svoi_title_subjective}»\n";
$header = "Content-Type: text/html ; charset=windows-1251;\nMIME-Version: 1.0\nFrom: noreply@".$CONFIG['env']['site']['domain'].">\n";
$msg = "Здравствуйте ".trim(trim($firstname." ".$midname)." ".$lastname)."<br><br>
Вы успешно зарегистрировались в проекте «{svoi_title_subjective}».<br><br>
Сделайте проект полезным для вас за три простых шага:<br><br>
1. Загрузите вашу фотографию.<br>
Чтобы ваши друзья могли узнать вас, достаточно загрузить фотографию: перейдите на свою страницу и нажмите на ссылку «Загрузить фото»
<a href=\"http://".$CONFIG['env']['site']['domain']."/passport/mypage/photo.php\">http://".$CONFIG['env']['site']['domain']."/passport/mypage/photo.php</a>
<br><br>
2. Заполните информацию о себе и своих интересах – это позволит вам найти единомышленников и создавать
сообщества по интересам. Чтобы заполнить информацию о себе, перейдите на свою страницу по ссылке - <a href=\"http://".$CONFIG['env']['site']['domain']."/a".$OBJECTS['user']->ID."\">http://".$CONFIG['env']['site']['domain']."/a".$OBJECTS['user']->ID."</a>
<br><br>
3. Начните общение в «{svoi_title_accusative}»!<br>
Отправляйте своим друзьям сообщения, размещайте фотографии, ведите дневник, заводите знакомства, создавайте сообщества по интересам. {all_region} – в ваших руках.
<br><br>
Используйте все возможности «{svoi_title_genitive}» в полном объеме! Полную версию руководства можно посмотреть по ссылке: <a href=\"http://".$CONFIG['env']['site']['domain']."{help_link}\">http://".$CONFIG['env']['site']['domain']."{help_link}</a>
<br><br>
Начните общение прямо сейчас!
<br/>
<br/>
С уважением,
<br/>
&nbsp;&nbsp;&nbsp;Служба поддержки {domain_title}";
						
list($subj, $msg) = Variables::Replace(array($subj, $msg), $CONFIG['env']['regid']);
mail($OBJECTS['user']->Email, $subj, $msg, $header);


PUsersMgr::$db->call_scalar('ActivateOfflineRegistredUser','i', $UserID);

Response::Redirect('/'.$this->_env['section'].'/msg.activation_ok.html');

?> 