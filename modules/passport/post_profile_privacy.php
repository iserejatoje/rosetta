<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$answer = App::$Request->Post['answer']->Value(Request::OUT_HTML_CLEAN);
if(!is_string($answer))
	$answer = '';
	
$question = App::$Request->Post['question']->Int(0, Request::UNSIGNED_NUM);
$question_text = App::$Request->Post['question_text']->Value(Request::OUT_HTML_CLEAN);
if(!is_string($question_text))
	$question_text = '';
	
$showfriends		= App::$Request->Post['showfriends']->Int(1, Request::UNSIGNED_NUM);
$showemail			= App::$Request->Post['showemail']->Int(0, Request::UNSIGNED_NUM);
$autologincross		= App::$Request->Post['autologincross']->Int(0, Request::UNSIGNED_NUM);

if($question === 0 || ($question === 100 && empty($question_text)) || ($question > 0 && $question != 100 && !isset($this->_config['questions'][$question])))
	UserError::AddErrorIndexed('question', ERR_M_PASSPORT_EMPTY_QUESTION);
else if($question !== 0 && $question !== 100)
	$question_text = $this->_config['questions'][$question];
	
if(empty($answer))
	UserError::AddErrorIndexed('answer', ERR_M_PASSPORT_EMPTY_ANSWER);
	
if(!PUsersMgr::CheckPassword($OBJECTS['user']->Email, App::$Request->Post['password']))
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_INCORRECT_SETTINGS_PASSWORD);
	
if(UserError::IsError())
	return false;

$user = array(
		'ID' => $OBJECTS['user']->ID,
		'Email' => $OBJECTS['user']->Email, 
		'OurEmail' => $OBJECTS['user']->OurEmail, 
		'NickName' => $OBJECTS['user']->NickName,
		'Question' => $question_text, 
		'Answer' => $answer,
		'Blocked' => $OBJECTS['user']->Blocked,
		'AutoLoginCross' => $autologincross);
				
$OBJECTS['usersMgr']->UpdateByID($user);

$OBJECTS['user']->Profile['general']['ShowEmail'] = $showemail;
$OBJECTS['user']->Profile['general']['ShowFriends'] = $showfriends;

$OBJECTS['log']->Log(
		263,
		0,
		array()
		);

Response::Redirect('/' . $this->_env['section'] . '/msg.profile_privacy.html');
?>