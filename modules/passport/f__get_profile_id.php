<?
$form = array();

$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

if($this->_lib_mail !== null)
{
	$form['form']['mail_services']			= $this->_lib_mail->GetMailServices();
	$form['form']['mail_default_service']	= $this->_lib_mail->GetDefaultMailService();
}

$form['form']['ouremail'] 			= $OBJECTS['user']->OurEmail;

$form['form']['activation'] = $OBJECTS['usersMgr']->CheckActivation($OBJECTS['user']->ID, 2);

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'profile_id')
{
	$form['form']['email'] 				= App::$Request->Post['email']->Value(Request::OUT_HTML);
	$form['form']['nickname'] 			= App::$Request->Post['nickname']->Value(Request::OUT_HTML);
	$form['form']['reg']				= App::$Request->Post['reg']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['username_reg']		= App::$Request->Post['username_reg']->Value(Request::OUT_HTML);
	$form['form']['domain_reg']			= App::$Request->Post['domain_reg']->Value(Request::OUT_HTML);
	$form['form']['email_examples_reg']	= $this->_examples['email_reg'];
	$form['form']['nickname_examples']	= $this->_examples['nickname'];
}
else
{
	$form['form']['email'] 				= $OBJECTS['user']->Email;
	$form['form']['nickname'] 			= $OBJECTS['user']->NickName;
}
if(!empty($OBJECTS['user']->OurEmail) && !empty($this->_config['mail']['sectionid']))
	$form['form']['ouremail_link'] = ModuleFactory::GetLinkBySectionId($this->_config['mail']['sectionid']);
	
return $form;
?>