<?
/**
* здесь можно добавить проверку на то по HTTPS пользователь пришел или по HTTP
* и если по HTTP, то редиректить на HTTPS
*
*/
$form = array();

if( App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'register')
{
	$POST = App::$Request->Post->AsArray(null, Request::VALUE | Request::OUT_HTML);
	
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_INCORRECT_SETTINGS_RETYPE_PASSWORD);
	$form['email_examples']		= $this->_examples['email'];
	$form['email_examples_reg']	= $this->_examples['email_reg'];
	$form['name_examples']		= $this->_examples['name'];
	$form['email_type']			= App::$Request->Post['email_type']->Alpha('');
	$form['email']				= App::$Request->Post['email']->Value(Request::OUT_HTML);
	$form['question']			= App::$Request->Post['question']->Int(0, Request::UNSIGNED_NUM);
	$form['question_text']		= $POST['question_text'];
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
	
	$form['current']			= App::$Request->Post['Current']->AlNum('');

	if ( $form['current'] ) {
		$loc_pc = Location::ParseCode($form['current']);
		if (Location::ObjectLevel($loc_pc) <= Location::OL_REGIONS) {
			$form['current'] = $this->_env['site']['city_code'];
		}
	}

	
	$form['showhow']			= App::$Request->Post['showhow']->Int(0, Request::UNSIGNED_NUM);
	$form['url'] 				= App::$Request->Post['url']->Url();
	$form['postcode']		= App::$Request->Post['postcode']->Value(Request::OUT_HTML_CLEAN);
	$form['area']		= App::$Request->Post['area']->Value(Request::OUT_HTML_CLEAN);
	$form['district']	= App::$Request->Post['district']->Value(Request::OUT_HTML_CLEAN);
	$form['city']			= App::$Request->Post['city']->Value(Request::OUT_HTML_CLEAN);
	$form['street']			= App::$Request->Post['street']->Value(Request::OUT_HTML_CLEAN);
	$form['apartment']		= App::$Request->Post['apartment']->Int(0, Request::UNSIGNED_NUM);
	$form['house']			= App::$Request->Post['house']->Value(Request::OUT_HTML_CLEAN); 
	$form['phone']			= App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);	
}
else
{
	$form['current']				= $this->_env['site']['city_code'];
	$form['email_type']			= 'old';
	$form['url'] 				= App::$Request->Get['url']->Url();
}
	
	if( STreeMgr::GetNodeByID($this->_env['site']['tree_id'])->IsSSL )
		$form['ssl_url'] = 'https://'.$this->_env['site']['domain'].'/'.$this->_env['section'].'/'.$this->_config['files']['get']['register']['string'];

	LibFactory::GetStatic('arrays');
	$form['years_arr']		= range(date('Y') , 1900);
	$form['months_arr']		= Arrays::$Month['subjective'];
	$form['days_arr']		= range(1, 31);
	
$form['question_arr']			= $this->_config['questions'];

$captcha = LibFactory::GetInstance('captcha');

return array(
		'form' => $form,
		'captcha_path' => $captcha->get_path(),
		);
?>