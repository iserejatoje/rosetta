<?

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

// 2do: убрать это, когда корректно будет работать AntiFlood
if( empty($_SERVER['HTTP_USER_AGENT']) )
{
	echo $json->encode(array(
		'status' => 'error',
		'data' => 'Ваше сообщение не отправлено. Обратитесь к администрации сайта.',
	));
	
	exit;
}

if(!$OBJECTS['user']->IsAuth())
{
	if(App::$Request->Post['action']->Value() == 'im_ajax_new') {
		echo $json->encode(array(
			'status' => 'error',
			'data' => 'Для отправки сообщений вы должны быть авторизованы.',
		));
		
		exit;
	} else
		$this->redirect_not_authorized();
}

$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; // AJAX или обычный POST

if(App::$Request->Post['action']->Value() == 'im_ajax_new' && $xhr)
{
	App::$Request->Post['nicknameto']	= iconv('UTF-8', 'WINDOWS-1251', App::$Request->Post['nicknameto']->Value());
	App::$Request->Post['text']			= iconv('UTF-8', 'WINDOWS-1251', App::$Request->Post['text']->Value());
	App::$Request->Post['ititle']		= iconv('UTF-8', 'WINDOWS-1251', App::$Request->Post['ititle']->Value());
	App::$Request->Post['iurl']			= iconv('UTF-8', 'WINDOWS-1251', App::$Request->Post['iurl']->Value());
}

if (!UserError::IsError())
{
	$to = App::$Request->Post['to']->Int(0, Request::UNSIGNED_NUM);
	$nicknameto = App::$Request->Post['nicknameto']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$title = App::$Request->Post['title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$text = App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);

	$type =  App::$Request->Post['itype']->Int(0, Request::UNSIGNED_NUM);
	$ititle = App::$Request->Post['ititle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$iurl =  App::$Request->Post['iurl']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);

	if($to == 0 && empty($nicknameto))
		UserError::AddErrorIndexed('nicknameto',
				ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_EMPTY);
	elseif($to != 0)
	{
		$uto = $OBJECTS['usersMgr']->GetUser($to, false, false);
		if($uto->ID == 0)
		{
			UserError::AddErrorIndexed('nicknameto',
					ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS);
			App::$Request->Post['to'] = 0;
		}
	}
	elseif(!empty($nicknameto))
	{
		$ui = PUsersMgr::GetUserInfoArrayByNickName($nicknameto);
		if($ui === null)
			UserError::AddErrorIndexed('nicknameto',
					ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS);
		else
			$to = $ui['UserID'];
	}

	if(empty($text))
		UserError::AddErrorIndexed('text',
				ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_EMPTY);
	elseif(strlen($text) > $this->_config['limits']['max_len_message_text'])
		UserError::AddErrorIndexed('text',
				ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_TOLONG, $this->_config['limits']['max_len_message_text']);

	if($to == $OBJECTS['user']->ID)
		UserError::AddErrorIndexed('nicknameto',
				ERR_M_PASSPORT_INCORRECT_MESSAGE_SEND_TO_SELF);

	if(!$xhr) // только в этом случае мог придти файл
	{
		LibFactory::GetStatic('filemagic');
		if(!FileMagic::IsValidType($_FILES['file']['tmp_name']))
			UserError::AddErrorIndexed('file', ERR_M_PASSPORT_INCORRECT_FILE_TYPE);
	}
}

if (UserError::IsError())
{
	if(App::$Request->Post['action']->Value() == 'im_ajax_new')
	{
		echo $json->encode(array(
			'status' => 'error',
			'data' => UserError::GetErrorsTextWithoutAnchor("\n")
		));
		
		exit;
	}
	else
		return false;
}
else
{
	LibFactory::GetStatic('antiflood2');
	//Либо 3 сообщения в минуту, либо 30 ссобщений в час
	if ($OBJECTS['user']->ID != 1 && (!AntiFlood2::Score('passport:im_new', AntiFlood2::K_USER, 60, 3)
		|| !AntiFlood2::Score('passport:im_new', AntiFlood2::K_USER, 3600, 30)) ) {
	   echo $json->encode(array(
			'status' => 'error',
			'data' => 'Вы отправляете сообщения слишком часто. Попробуйте спустя некоторое время.',
		));
		
		exit;
	}

	$files = null;
	if(!$xhr) // только в этом случае мог придти файл
		$files = $_FILES['file'];
	$OBJECTS['user']->Plugins->Messages->SendMessage($to, $text, $type, $ititle, $iurl, $files);
}

if(App::$Request->Post['action']->Value() == 'im_ajax_new')
{
	echo $json->encode(array('status' => 'added'));
	exit;
}
else
	Response::Redirect('/' . $this->_env['section'] . '/msg.im_new_sent.html');
?>