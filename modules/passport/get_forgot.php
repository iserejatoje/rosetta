<?

if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Восстановить пароль');

/*unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step']);
unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_email']);
unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_link']);*/
		
if(!isset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step']))
	$OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step'] = "step1";

$form = array();

$step = $OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step'];

if($step == 'step1')
{
	if ( isset(App::$Request->Post['email']) )
		$form['email'] = App::$Request->Post['email']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	else
		$form['email'] = '';

	if (isset(App::$Request->Get['code'])) {
		$code = substr(App::$Request->Get['code']->Value(),0,8);
		$form['code'] = $code;
	}
}
else if($step == 'step2')
{
	$captcha = LibFactory::GetInstance('captcha');
	$form['captcha_path'] = $captcha->get_path();	
	$form['forgot_link'] = $OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_link'];

}
else if($step == 'step3')
{
}

return array(
	'form' => $form,
	'step' => $step,
);

?>