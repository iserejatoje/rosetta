<?php

$form = array();
$form['question_arr'] = $this->_config['questions'];

$valid = false;
if ( isset($_GET['code']) )
{
	$form['code'] = $_GET['code'];
	// проверяем код
	
	$res = PUsersMgr::$db->call_assoc('CheckOfflineRegistrationCode', 's', $_GET['code']);
	
	if ( $res['UserID'] > 0 )
	{
		if( App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'offline_activate')
		{
			$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML);
			
			UserError::AddErrorIndexed('password', ERR_M_PASSPORT_INCORRECT_SETTINGS_RETYPE_PASSWORD);
			$form['question']			= App::$Request->Post['question']->Int(0, Request::UNSIGNED_NUM);
			$form['question_text']		= $POST['question_text'];
			$form['answer']				= $POST['answer'];
		}
		$valid = true;
	} else {
		UserError::AddErrorIndexed('code', ERR_M_PASSPORT_INCORRECT_OFFLINE_ACTIVATION_CODE);
	}
}

return array(
	'form' => $form,
	'valid' => $valid
	);

//Response::Redirect('/'.$this->_env['section'].'/msg.activation_ok.html');

?>