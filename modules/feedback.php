<?
static $error_code = 1;
define('ERR_M_FEEDBACK_MASK', 0x00240000);

define('ERR_M_FEEDBACK_UNKNOWN_ERROR', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_UNKNOWN_ERROR]
	= 'Незвестная ошибка';
define('ERR_M_FEEDBACK_INCORRECT_ANTIROBOT', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_INCORRECT_ANTIROBOT]
	= 'Неверный код защиты от роботов.';
define('ERR_M_FEEDBACK_INCORRECT_TARGET', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_INCORRECT_TARGET]
	= 'Неверно указана тема.';
define('ERR_M_FEEDBACK_INCORRECT_TEXT', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_INCORRECT_TEXT]
	= 'Напишите текст сообщения.';
define('ERR_M_FEEDBACK_TEXT_NOT_CENSORED', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_TEXT_NOT_CENSORED]
	= 'При отправке сообщения возникли технические проблемы. Пожалуйста, повторите отправку позже.';
define('ERR_M_FEEDBACK_NOT_SENT', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_NOT_SENT]
	= 'При отправке сообщения возникли технические проблемы. Пожалуйста, повторите отправку позже.';
define('ERR_M_FEEDBACK_WRONG_M', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_WRONG_M]
	= 'E-mail получателя неверный.';
define('ERR_M_FEEDBACK_WRONG_FILESIZE', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_WRONG_FILESIZE]
	= 'Прикрепляемый к сообщению файл слишком большой. Максимальный размер файла - 1Мб.';
define('ERR_M_FEEDBACK_ERRORS', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_ERRORS]
	= 'Выделенный вами текст должен быть не менее 10 и не более 500 знаков.';
define('ERR_M_FEEDBACK_WRONG_REFERER', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_WRONG_REFERER]
	= 'Обращение с внешенего источника';
define('ERR_M_FEEDBACK_WRONG_EMAIL_FROM', ERR_M_FEEDBACK_MASK | $error_code++);
UserError::$Errors[ERR_M_FEEDBACK_WRONG_EMAIL_FROM]
	= 'E-mail указан неверно.';

class Mod_Feedback extends AModule
{
	protected $_db;
	protected $_params;
	protected $_result = array();
	protected $_err;
	protected $_ar = null;

	public function __construct()
	{
		parent::__construct('feedback');
	}
	
	function Init()
	{
		global $CONFIG;
	}
	
	function Action($params)
	{
		$this->_ActionModRewrite($params);
		$this->_ActionPost();
	}

	protected function _ActionModRewrite(&$params)
	{
		// разбиваем строку с параметрами и анализируем

		if($params == 'sent.html')
			$this->_page = 'sent';
		elseif($params == 'mailto_sent.html')
			$this->_page = 'mailto_sent';
		elseif($params == 'mailto.php')
			$this->_page = 'mailto';
		elseif($params == 'error.html')
			$this->_page = 'error';
		else
			$this->_page = 'default';
		
	}
	
	
	protected function _ActionPost()
	{
		if($_POST['action'] == 'send')
		{
			if($this->_P_Send())
			{
				header('Location: /'.$this->_env['section'].'/sent.html');
				exit();
			}
		}
		else if($_POST['action'] == 'mailto')
		{
			if($this->_P_MailTo_Send())
			{
				if($_POST['method']=='show')
					header('Location: /'.$this->_env['section'].'/mailto_sent.html?m='.urlencode($_POST['m']));
				else
					header('Location: /'.$this->_env['section'].'/mailto_sent.html');
				exit();
			}
		}
		else if($_POST['action'] == 'error')		
		{
			if($this->_P_Error() === true)
			{
				header('Location: /'.$this->_env['section'].'/sent.html');
				exit();
			}
		}	
		
	}

	protected function _ActionGet()
	{
		
		switch($this->_page)
		{
			case 'mailto_sent':
				$page = $this->_G_MailTo_Sent();
				break;
			case 'sent':
				$page = $this->_G_Sent();
				break;
			case 'mailto':
				$page = $this->_G_MailTo();
				break;
			case 'error':
				$page = $this->_G_Error();
				break;
			default:
				$page = $this->_G_Default();
		}
		return $page;
	}

	
	protected function GetCustomBlock($block, $template, $lifetime, $params)
	{
		global $CONFIG, $OBJECTS;
		
		if( $block == "block_link" )
		{			
			if( !$OBJECTS['smarty']->Template_Exists($template) )
				$template = $this->_config['templates']['block_link'];
			if( !$OBJECTS['smarty']->Template_Exists($template) )
				return "";			
				
			return $this->RenderBlock(
				$template,
				$params,
				array($this, '_Get_Block_Link'),
				(isset($params['cache'])?$params['cache']:true),
				$lifetime
			);
		}
		return null;
	}
	

	/*
	* =======================================
	*  GET functions
	* =======================================
	*/


	private function _G_Default()
	{
		global $OBJECTS, $CONFIG;

		$page = array();

		$page['form']["target_arr"] = $this->_config['target'];
		$page['form']["target"] = intval($_POST['action']?$_POST['target']:($_GET['target']?$_GET['target']:-1));
		$page['form']["text"] = Data::HTMLOutTArea($_POST['action']?$_POST['text']:"");
		$page['form']["conts"] = Data::HTMLOut($_POST['action']?$_POST['conts']:"");
		$page['form']["referer"] = Data::HTMLOut($_POST['action']?$_POST['referer']:$_SERVER['HTTP_REFERER']);
		$page['form']["from"] = Data::HTMLOut($_POST['action']?$_POST['from']:$_GET['from']);

		$captcha = LibFactory::GetInstance('captcha');
		$page['form']["captcha_path"] = $captcha->get_path();
		
		return $page;
	}


	private function _G_MailTo()
	{
		global $OBJECTS, $CONFIG;

		$page = array();

		$page['form']["method"] = Data::HTMLOutTArea($_POST['action']?$_POST['method']:"send");
		$page['form']["text"] = Data::HTMLOutTArea($_POST['action']?$_POST['text']:"");
		$page['form']["theme"] = Data::HTMLOutTArea($_POST['action']?$_POST['theme']:"");
		$page['form']["conts"] = Data::HTMLOut($_POST['action']?$_POST['conts']:"");
		$page['form']["referer"] = Data::HTMLOut($_POST['action']?$_POST['referer']:$_SERVER['HTTP_REFERER']);
		$page['form']["from"] = Data::HTMLOut($_POST['action']?$_POST['from']:$_GET['from']);
		$page['form']["m"] = Data::HTMLOut($_POST['action']?$_POST['m']:$_GET['m']);
		$page['form']["u"] = Data::HTMLOut($_POST['action']?$_POST['u']:$_GET['u']);

		$captcha = LibFactory::GetInstance('captcha');
		$page['form']["captcha_path"] = $captcha->get_path();
		# Устанавливаем заголовки
		#=================
		$OBJECTS["title"]->Title = $this->_env["site"]["title"][$this->_env['section']];

		return $page;
	}


	private function _G_Sent()
	{
		global $OBJECTS, $CONFIG;

		$page = array();
		
		# Устанавливаем заголовки
		#=================
		$OBJECTS["title"]->Title = $this->_env["site"]["title"][$this->_env['section']];

		return $page;
	}

	private function _G_MailTo_Sent()
	{
		global $OBJECTS, $CONFIG;
		
		$page = array();
		if(($page['email'] = $this->decode_email($_GET['m'])) === false)
			$page['email'] == '';
		
		# Устанавливаем заголовки
		#=================
		$OBJECTS["title"]->Title = $this->_env["site"]["title"][$this->_env['section']];
		
		return $page;
	}
	
	private function _G_Error()
	{
		global $OBJECTS, $CONFIG;
		
		$OBJECTS["title"]->Title = $this->_env['site']['title'][$this->_env['section']];
		
		$captcha = LibFactory::GetInstance('captcha');
		$page['captcha_path'] = $captcha->get_path();
		
		$page['error_msg'] = App::$Request->Get['text']->Value(Request::OUT_HTML_AREA | Request::OUT_HTML_CLEAN);
		$page['error_msg'] =  preg_replace( '#%u([0-9A-F]{4})#se','iconv("UTF-16BE","Windows-1251",pack("H4","$1"))', $page['error_msg'] );//urldecode($page['error_msg']);
		
		$page['comment'] = "";
		
		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$page['comment'] = App::$Request->Post['comment_error']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);		
		}
		
		if ($OBJECTS['user']->IsAuth())
			$page['email_from'] = $OBJECTS['user']->Email;
		else
			$page['email_from'] = '';
			
		$len = strlen($page['error_msg']);
		if ($len < 10 || $len > 500)
			UserError::AddErrorIndexed('error', ERR_M_FEEDBACK_ERRORS);
		
		$page['referer'] = App::$Request->Get['referer']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);		
		$page['referer'] = urldecode($page['referer']);
		
		$referer_info = parse_url($page['referer']);
		$sectionid = STreeMgr::GetSiteIDByHost($referer_info['host']);
		
		if ($sectionid == null)
			UserError::AddErrorIndexed('error', ERR_M_FEEDBACK_WRONG_REFERER);
		
		return $page;
	}
	
	/**
	* Отправляет сообшение
	* 
	* @return bool
	*  true - если удачно
	*  false - если произощла ошибка
	*/
	private function _P_Send()
	{
		global $OBJECTS, $CONFIG;

		// проверяем на ощибки		
		$captcha = LibFactory::GetInstance('captcha');	
		if (!$captcha->is_valid()) 
			UserError::AddErrorIndexed('antirobot', ERR_M_FEEDBACK_INCORRECT_ANTIROBOT);

		if ( !isset($this->_config['target'][$_POST['target']]) )
			UserError::AddErrorIndexed('target', ERR_M_FEEDBACK_INCORRECT_TARGET);

		$_POST['text'] = trim($_POST['text']);
		if ( $_POST['text'] == '' )
			UserError::AddErrorIndexed('text', ERR_M_FEEDBACK_INCORRECT_TEXT);

		$censor = LibFactory::GetInstance('censor');
		if(!$censor->is_censored($_POST['conts'], $_POST['text']))
			UserError::AddErrorIndexed('text', ERR_M_FEEDBACK_TEXT_NOT_CENSORED);

		$conts = strip_tags($_POST['conts']);
		if (!Data::Is_Email($conts))
			UserError::AddErrorIndexed('conts', ERR_M_FEEDBACK_WRONG_M);

		if(UserError::IsError())
			return false;


		$section = "Не найдено";
		$n = null;
		if(Data::Is_Number($_POST['from']))
		{
			$n = STreeMgr::GetNodeByID($_POST['from']);
			if($n != null)
			{
				$section = $n->Parent->Name." -> ".$n->Name;
				$section.= " (".$n->Parent->Path."/".$n->Path."/)";
			}
		}
		$domain =& $this->_env['site']['domain'];
		$text = strip_tags($_POST['text']);
		
		$msg = "$subj\n
Текст пользователя:\n
--------------------------------------------------------------\n
$text\n
--------------------------------------------------------------\n
Обратная связь пришла с сайта: {$domain}\n
Нажали здесь: ".$section."\n
Контакты: ".$conts."\n\n";

		if ($this->_config['show_ip'])
		{
			$msg.= "Referer: ".Data::HTMLOut($_POST['referer'])."\n";
			$msg.= "ip: ".getenv("REMOTE_ADDR")."\n";
			$msg.= "ip-forwarded: ".getenv("HTTP_X_FORWARDED_FOR")."\n";
			$msg.= "UserId: ".$OBJECTS['user']->ID."\n";
			$msg.= "UserEmail: ".$OBJECTS['user']->Email."\n";
			$msg.= "UserOurEmail: ".$OBJECTS['user']->OurEmail."\n";
		}

		$brawser = 'неизвестный';
		if ($_SERVER['HTTP_USER_AGENT'] != '')
			$brawser = $_SERVER['HTTP_USER_AGENT'];
		$msg.= "\nБраузер пользователя: ".$brawser."\n";
		
		LibFactory::GetStatic('mailsender');
		$mail = new MailSender();
		$mail->AddAddress('to', $this->_config['target'][$_POST['target']]['email']);
		$mail->AddAddress('from', "feedback <no.reply@$domain>");
		$mail->AddHeader('Subject', "Обратная связь $domain\n");
		$mail->AddHeader('Return-Path', $conts);
		$mail->AddHeader('Reply-To', $conts);
		$mail->AddBody('text', $msg);
		
		if( !$mail->Send() )
		{
			UserError::AddErrorIndexed('email', ERR_M_FEEDBACK_NOT_SENT);
		}
		else
		{
			$sec_path = '';
			if($n !== null)
				$sec_path = $n->Path;
			$OBJECTS['log']->Log(93, 0, array(
				'domain' => $this->_env['site']['domain'],
				'section' => $sec_path,
				'email' => $this->_config['target'][$_POST['target']]['email'],
				'message' => nl2br($msg)
			), 0);
		}

		return true;
	}


	/**
	* Отправляет сообшение пользователю или показывает его email
	* 
	* @return bool
	*  true - если удачно
	*  false - если произощла ошибка
	*/
	private function _P_MailTo_Send()
	{
		global $OBJECTS, $CONFIG;

		// проверяем на ощибки
		$captcha = LibFactory::GetInstance('captcha');	
		if (!$captcha->is_valid()) 
			UserError::AddErrorIndexed('antirobot', ERR_M_FEEDBACK_INCORRECT_ANTIROBOT);

		if($_POST['method']=='send')
		{
			$_POST['theme'] = trim($_POST['theme']);
			if ( empty($_POST['theme']) )
				UserError::AddErrorIndexed('theme', ERR_M_FEEDBACK_INCORRECT_TARGET);
			
			$_POST['text'] = trim($_POST['text']);
			if ( $_POST['text'] == '' )
				UserError::AddErrorIndexed('text', ERR_M_FEEDBACK_INCORRECT_TEXT);
			
			$censor = LibFactory::GetInstance('censor');
			if(!$censor->is_censored($_POST['conts'], $_POST['text']))
				UserError::AddErrorIndexed('text', ERR_M_FEEDBACK_TEXT_NOT_CENSORED);
			
			if(($email = $this->decode_email($_POST['m'])) === false)
				UserError::AddErrorIndexed('m', ERR_M_FEEDBACK_WRONG_M);

			if ( $_FILES["file"]['tmp_name'] && $_FILES["file"]['tmp_name'] != 'none' && $_FILES["file"]['size']>1048576)
				UserError::AddErrorIndexed('file', ERR_M_FEEDBACK_WRONG_FILESIZE);
			
			$conts = strip_tags($_POST['conts']);
			if (!Data::Is_Email($conts))
				UserError::AddErrorIndexed('conts', ERR_M_FEEDBACK_WRONG_M);

			if(UserError::IsError())
				return false;
			
			$domain =& $this->_env['site']['domain'];
			$text = strip_tags($_POST['text']);
			$text .= "\nКонтактная информация:\n" . $conts;
			$url = $this->decode_text($_POST['u']);
			if ($url)
				$text .= "\n\nСсылка \"Написать письмо\" была нажата на странице:\nhttp://" . ($url) . ".";
			
			$brawser = 'неизвестный';
			if ($_SERVER['HTTP_USER_AGENT'] != '')
				$brawser = $_SERVER['HTTP_USER_AGENT'];
			$text.= "\nБраузер пользователя: ".$brawser."\n";
			
			$subj = strip_tags($_POST['theme']);
			
			LibFactory::GetStatic('mailsender', 'filemagic');
			$mail = new MailSender();
			$mail->AddAddress('to', $email);
			$mail->AddAddress('from', "feedback <no.reply@$domain>");
			$mail->AddHeader('Subject', $subj);
			$mail->AddHeader('Return-Path', $conts);
			$mail->AddHeader('Reply-To', $conts);
			$mail->AddBody('text', $text);
			
			//прикрепление файла, если есть - тело письма формируем
			if ( $_FILES['file']['tmp_name'] && $_FILES["file"]['tmp_name'] != 'none' )
			{
				$mail->body_type = MailSender::BT_MIXED;
				$mail->AddAttachment($_FILES['file']['name'], $_FILES['file']['tmp_name']);
			}
			// конец прикрепление файла
			
			if( !$mail->Send() )
			{
				UserError::AddErrorIndexed('email', ERR_M_FEEDBACK_NOT_SENT);
			}
			else
			{
				$n = STreeMgr::GetNodeByID($_POST['from']);
				$sec_path = '';
				if($n !== null)
					$sec_path = $n->Path;
				
			}
		}
		else if($_POST['method']=='show')
		{
			if(($email = $this->decode_email($_POST['m'])) === false)
				UserError::AddErrorIndexed('m', ERR_M_FEEDBACK_WRONG_M);
			
			if(UserError::IsError())
				return false;
		}

		return true;
	}

	private function _P_Error()
	{
		global $OBJECTS, $CONFIG;
		$referer = App::$Request->Post['referer']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
		$msg = App::$Request->Post['error_msg']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
		$comment = App::$Request->Post['comment_error']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);		
		$email_from = App::$Request->Post['email_from']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
		
		$captcha = LibFactory::GetInstance('captcha');
		if (!$captcha->is_valid()) 
			UserError::AddErrorIndexed('antirobot', ERR_M_FEEDBACK_INCORRECT_ANTIROBOT);
		
		if (!Data::Is_Email($email_from))
			UserError::AddErrorIndexed('email_from', ERR_M_FEEDBACK_WRONG_EMAIL_FROM);
		
		$referer_info = parse_url($referer);
		$sectionid = STreeMgr::GetSiteIDByHost($referer_info['host']);
		if ($sectionid == 0)
		{
			UserError::AddErrorIndexed('error', ERR_M_FEEDBACK_WRONG_REFERER);
		}
		
		$len = strlen($msg);
		if ($len < 10 || $len > 500)
			UserError::AddErrorIndexed('error', ERR_M_FEEDBACK_ERRORS);
		
		if(UserError::IsError())
			return false;
			
		$node = STreeMgr::GetNodeByID($sectionid);
		
		$len_comment = strlen($comment);
		
		if ($len_comment > 1000)
			$comment = substr($comment, 0, 1000);

		$msg = "\tСообщение об ошибке\n\n
Ссылка на материал: ".$referer."
Заголовок раздела: ".$node->Name."
Выделенный текст:
-------------------------------
".$msg."
-------------------------------
";
		if ($len_comment > 0)
		{
			$msg.= "
Комментарий пользователя:\n".
$comment."
";
		}
		
		$referer_info = parse_url($referer);
						
		LibFactory::GetStatic('mailsender');
		$mail = new MailSender();
		if (!is_array($this->_config['error_email']))
			$this->_config['error_email'] = (array)$this->_config['error_email'];
		foreach($this->_config['error_email'] as $email)
		{
			$mail->AddAddress('to', $email);
		}
		$mail->AddAddress('from', "feedback <no.reply@".$this->_env['site']['domain'].">");
		$mail->AddHeader('Subject', "Сообщение об ошибке ".$referer_info['host']."\n");		
		$mail->AddBody('text', $msg);
				
		if( !$mail->Send() )
		{
			UserError::AddErrorIndexed('email', ERR_M_FEEDBACK_NOT_SENT);			
			return false;
		}
		
		return true;
	}

	private function decode_email($n)
	{
		LibFactory::GetStatic('cryptography');
		$s = Cryptography::xsx_decode(base64_decode($n));
		if(!Data::Is_Email($s))
			return false;
		
		return $s;
	}

	private function decode_text($n)
	{
		LibFactory::GetStatic('cryptography');
		$s = Cryptography::xsx_decode(base64_decode($n));
		
		return $s;
	}

	protected function &_Get_Block_Link($params)
	{
		$list = (array) $params;

		return $list;
	}

}
