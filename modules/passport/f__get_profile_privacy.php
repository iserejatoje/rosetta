<?
$form = array();
$form['form']['question_arr']			= $this->_config['questions'];
$question_text = '';

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'profile_privacy')
{
	$form['form']['answer']				= App::$Request->Post['answer']->Value(Request::OUT_HTML);
	$question_text 						= App::$Request->Post['question_text']->Value(Request::OUT_HTML);
	$question 							= App::$Request->Post['question']->Int(0, Request::UNSIGNED_NUM);
	
	$form['form']['showemail'] 			= App::$Request->Post['showemail']->Int(1, Request::UNSIGNED_NUM);
	$form['form']['showfriends'] 		= App::$Request->Post['showfriends']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['autologincross']		= App::$Request->Post['autologincross']->Int(0, Request::UNSIGNED_NUM);
	
	foreach($this->_config['questions'] as $k => $v)
		if($k == $question)
			$form['form']['question'] = $k;
}
else
{
	$form['form']['answer']				= $OBJECTS['user']->Answer;
	$question 							= $OBJECTS['user']->Question;
	$form['form']['showemail'] 			= $OBJECTS['user']->Profile['general']['ShowEmail'];
	$form['form']['showfriends'] 		= $OBJECTS['user']->Profile['general']['ShowFriends'];
	$form['form']['autologincross']		= $OBJECTS['user']->AutoLoginCross;
	
	if (in_array($question, $this->_config['questions'])) {
		foreach($this->_config['questions'] as $k => $v)
			if($v == $question)
				$form['form']['question'] = $k;
	} else
		$question_text = $question;
}
		
if(!isset($form['form']['question']))
{
	$form['form']['question'] = 100;
	$form['form']['question_text'] = $question_text;
}

if ( is_array($this->_config['login_cross_domains'][$this->_env['regid']]) && 
	 sizeof($this->_config['login_cross_domains'][$this->_env['regid']]) ) {
	
	sort($this->_config['login_cross_domains'][$this->_env['regid']]);
	$form['form']['login_cross_domains'] = $this->_config['login_cross_domains'][$this->_env['regid']];
}
return $form;

?>