<?

class lib_mail_service
{
	private $SectionId = 0;
	private $_config = null;		// конфиг раздела
	private $_db;
	
	public $errors = array(
		-1 => 'Email is incorrect',
		-2 => 'CreateEmail: Email exists',
		-3 => 'CreateEmail: Password is empty',
		-4 => 'CreateEmail: Incorrect domain',
		-5 => 'CreateEmail: Can not insert row in database',
		-101 => 'URL not found',
		-102 => 'Incorrect answer',
		);
	
	public $col_pp = array(
		'10' => '10',
		'20' => '20',
		'30' => '30',
		'40' => '40',
		'50' => '50',
		'100' => '100',
		);
	public $so_arr = array(
		'a' => 'по возрастанию',
		'd' => 'по убыванию',
		);
	public $message_sf_arr = array(
		'date' => 'даты',
		'size' => 'размера',
		'subject' => 'темы',
		'from' => 'отправителя',
		'to' => 'адресата',
		);
	public $address_sf_arr = array(
		'nick' => 'ника',
		'name' => 'ФИО',
		'email' => 'email`a',
		'phone' => 'телефона',
		);
	
	public $default_profile = array(
		'MessageColPP' => 20,
		'AddressColPP' => 20,
		'MessageSortOrd' => 'd',
		'MessageSortField' => 'date',
		'AddressSortOrd' => 'a',
		'AddressSortField' => 'nick',
		'LogoutClearTrash' => 1,
		'SaveInSent' => 1,
		'ReplyTo' => '',
		);
	
	function __construct()
	{
	}
	
	/**
	 * Инициализация
	 * @param int идентификатор раздела сайта
	 */
	public function Init($sectionid)
	{
		LibFactory::GetStatic('data');
		if(!Data::Is_Number($sectionid))
		{
			Data::e_backtrace("SectionID '".$sectionid."' passed to ".__CLASS__." is incorrect.");
			return false;
		}
		
		$this->SectionId = $sectionid;
		
		$this->_config = ModuleFactory::GetConfigById('section', $this->SectionId);
		$this->_db = DBFactory::GetInstance($this->_config['db']);
		
		return true;
	}
	
	/**
	 * Проверить наличие E-mail
	 * 
	 * @param string $email email
	 * @return boolean true - есть, false - нет
	 */
	public function IsEMailExists($email)
	{
		$result = false;
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return $result;
		
		$arr = explode("@", $email);
		if(sizeof($arr)!=2)
			return $result;
		
		$name = $arr[0];
		$domain = $arr[1];

		LibFactory::GetStatic('domain');
		// проверка запрещенных имен
		$result = Domain::CheckForbidden($name, '');
		if($result === true)
			return $result;

		$sql = "SELECT username FROM ".$this->_config['tables']['mail_accounts'];
		$sql.= " WHERE username='".addslashes($email)."'";
		$res = $this->_db->query($sql);
		if($row = $res->fetch_assoc())
			$result = true;

		return $result;
	}
	
	/**
	 * Обновить пароль пользователя
	 * 
	 * @param string $email email
	 * @param string $password не шифрованый пароль
	 * @return boolean true - есть, false - нет
	 */
	public function UpdatePassword($email, $password)
	{
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return false;
		
		$sql = "UPDATE ".$this->_config['tables']['mail_accounts']. " SET";
		$sql.= " password='".addslashes($password)."'";
		$sql.= " WHERE username='".addslashes($email)."'";
		if($this->_db->query($sql))
			return true;
		else
			return false;
	}
	
	/**
	 * Создать почтовый ящик
	 * 
	 * @param string $email email
	 * @param string $password не шифрованый пароль
	 * @return int 0 - все хорошо, < 0 - ошибка (смотри в $this->errors)
	 */
	public function CreateEmail($email, $password)
	{
		global $OBJECTS;
		
		$url = ModuleFactory::GetLinkBySectionId($this->SectionId);
		if($url === false)
			return -101;
		
		$result = '';
		$email = strtolower($email);
		$url.= "__create_mail.php?email=".urlencode($email)."&password=".urlencode($password);
		if( $fp = @fopen($url, "rb"))
		{
			while (!feof($fp)) {
				$result .= fread($fp, 8192);
			}
			fclose($fp);
		}
		else
			return -102;
		
		if(!Data::Is_SignedNumber($result))
			return -102;

		return $result;
	}
		
	/**
	 * Создание структуры maildir
	 * 
	 * @param string $email email
	 * @return int
	 */
	public function CreateMailDir($email)
	{
		global $OBJECTS;
		
		$url = ModuleFactory::GetLinkBySectionId($this->SectionId);
		if($url === false)
			return -101;
		
		$result = '';
		$email = strtolower($email);
		$url.= "__create_maildir.php?email=".urlencode($email);
		if( $fp = @fopen($url, "rb"))
		{
			while (!feof($fp)) {
				$result .= fread($fp, 8192);
			}
			fclose($fp);
		}
		else
			return -102;
		
		if(!Data::Is_SignedNumber($result))
			return -102;

		return $result;
	}
		
	/**
	 * Создать почтовый ящик
	 * 
	 * @param string $email email
	 * @param string $password не шифрованый пароль
	 * @return int 0 - все хорошо, < 0 - ошибка (смотри в $this->errors)
	 */
	public function CreateEmail_Service($email, $password)
	{
		global $OBJECTS;
		
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return -1;
		
		$arr = explode("@", $email);
		if(sizeof($arr)!=2)
			return -1;
		
		$name = $arr[0];
		$domain = $arr[1];
		
		/*
		// проверка запрещенных имен
		$result = Domain::IsDomainExists($name, null, null, null, true);
		error_log('$result = '.$result);
		if ($result !== false)
			return -2;
		*/
		// проверка возможности создания ящике в этом домене
		if(!array_key_exists($domain, $this->_config['mail_services']))
			return -4;
		
		// проверка свободности email
		if( $this->IsEMailExists($email) )
			return -2;
		
		// проверка пароля
		$password = trim($password);
		if( $password == '' )
			return -3;
		
		/**
		 * ВСЕ ОК. можно создавать почту.
		 */
		$mailbox = $this->_config['mail_services'][$domain]['server_path']."/mailboxes/".$name."/";
		
		//error_log('REG: $mailbox: '.$mailbox);
		//error_log('REG: $user_dir: '.$user_dir);
		//error_log('REG: $pref_dir: '.$pref_dir);
		
		// Регистрируем почтовый ящик.
		// 1. Вставляем запись в БД
		//	error_log('REG: ------------ 1 BD');
		$sql  = "INSERT INTO ".$this->_config["tables"]["mail_accounts"]." SET";
		$sql .= " username='".addslashes($email)."',";
		$sql .= " password='".addslashes($password)."',";
		$sql .= " name='',";
		$sql .= " maildir='".addslashes($mailbox)."',";
		$sql .= " quota='-1',";
		$sql .= " domain='".addslashes($domain)."',";
		$sql .= " created=NOW(),";
		$sql .= " modified=NOW(),";
		$sql .= " active=1,";
		$sql .= " last_login=NOW(),";
		$sql .= " converted=1,";
		$sql .= " id_q='',";
		$sql .= " a_q='',";
		$sql .= " my_q=''";
		if(!$this->_db->query($sql))
			return -5;
		
		// 2. Создаем структуру директорий и файлов на сервере
		$this->__createMailDir($domain, $name);
		
		// 4. Вносим изменения в профиль
		//	error_log('REG: ------------ 4 PROFILE');
		$profile = $OBJECTS['user']->Profile['modules']['mail'];
		if(is_array($this->default_profile))
		{
			foreach($this->default_profile as $_k => $_v)
				$profile[$_k] = $_v;
		}
		$profile['MessageColPP'] = $this->_config['messages_col_pp'];
		$profile['AddressColPP'] = $this->_config['address_col_pp'];
		$profile['Signature'] = "\n\n--\n Отослано через  ".$domain."\n";
		
		// 5. Send First Mail
		//	error_log('REG: ------------ 5 Send First Mail');
		if( isset($OBJECTS['smarty']) && is_object($OBJECTS['smarty']) && $OBJECTS['smarty']->is_template($this->_config['templates']['first_mail']) )
		{
			$charsets = LibFactory::GetInstance('charsets');
			$charsets->charset = $this->_config['browser_charset'];
			
			$cacheid = $this->_config['default_mail_service'];
			if(!$OBJECTS['smarty']->is_cached($this->_config['templates']['first_mail'], $cacheid))
			{
				$result = array(
						'domain' => $this->_config['default_mail_service'],
						'section' => $this->_env['section'],
						);
				$OBJECTS['smarty']->assign_by_ref('res', $result);
			}
			$OBJECTS['smarty']->cache_lifetime = 1000000;
			$text = $OBJECTS['smarty']->fetch($this->_config['templates']['first_mail'], $cacheid);
			
			if($text)
			{
				//-------- Делаем заголовок для письма
				$head = "";
				$head.= "From: ".$charsets->EncodeMimeString("Администрация ".$this->_config['default_mail_service'])." <info@".$this->_config['default_mail_service'].">\n";
				$head.= "Date: ".date("r")."\n";
				$head.= "Content-Type: text/html; charset=".$this->_config['browser_charset']."\n"."Content-Transfer-Encoding: base64\n";
				$head.= "MIME-Version: 1.0\n";
				$subj = $charsets->EncodeMimeString("Добро пожаловать на ". $this->_config['default_mail_service'] ."!");
				$full_body = chunk_split(base64_encode($text));
				
				@mail($email, $subj, $full_body, $head);
			}
		}
		
		// 6. Log this event
		//	error_log('REG: ------------ 6 Log this event');
		$OBJECTS['log']->Log(
				252,
				0,
				array('email' => $email)
				);
		
		return 0;
	}
	
	/**
	 * Создание структуры maildir
	 * 
	 * @param string $email email
	 * @return int
	 */
	public function CreateMailDir_Service($email)
	{
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return -1;
		
		$arr = explode("@", $email);
		if(sizeof($arr)!=2)
			return -1;
		
		$name = $arr[0];
		$domain = $arr[1];
		
		// проверка возможности создания ящике в этом домене
		if(!array_key_exists($domain, $this->_config['mail_services']))
			return -4;
		
		$this->__createMailDir($domain, $name);
		return 0;
	}
	
	/**
	 * Создание структуры maildir
	 * 
	 * @param string $domain domain
	 * @param string $name name
	 */
	protected function __createMailDir($domain, $name)
	{
		$mailbox = $this->_config['mail_services'][$domain]['server_path'] . "/mailboxes/" . $name . "/";
		$user_dir = $this->_config['server_path'] . $mailbox;
		$pref_dir = $this->_config['server_path'] . $this->_config['mail_services'][$domain]['server_path'] . "/prefz/" . $name . "/";
		//	error_log('REG: ------------ 2 MKDIRS');
		$folders = array(
				'Drafts',
				'Sent',
				'Trash',
				'Spam',
				'',
				);
		mkdir(substr($user_dir, 0, strlen($user_dir)-1), 0777);
		mkdir(substr($pref_dir, 0, strlen($pref_dir)-1), 0777);
		foreach($folders as $v)
		{
			if($v == '')
				$folder = '';
			else
				$folder = "." . $v . "/";
			if($v != '')
				mkdir($user_dir.substr($folder, 0, strlen($folder)-1), 0777);
			mkdir($user_dir.$folder."cur", 0777);
			mkdir($user_dir.$folder."new", 0777);
			mkdir($user_dir.$folder."tmp", 0777);
			if($v == '')
				mkdir($user_dir.$folder."compose", 0777);
			$fh = fopen($user_dir.$folder."maildirfolder", 'w');
			fclose($fh);
		}
		mkdir($pref_dir . "cache", 0777);
		
		// 3. Создаем фильтры
		//	error_log('REG: ------------ 3 FILTERS');
		$filterfile = $user_dir."mailfilter";
		$fh = fopen($filterfile, 'w');
		//fwrite($fh, "if ( \$SIZE < 131072 )\n");
		//fwrite($fh, "{\n");
		//fwrite($fh, "  exception {\n");
		//fwrite($fh, "    xfilter \"/usr/bin/spamc\"\n");
		//fwrite($fh, "  }\n");
		//fwrite($fh, "}\n");
		//fwrite($fh, "\n");
		//fwrite($fh, "if (/^X-Spam-Level: \*\*\*\*\*\*\*\*/:h)\n");
		//fwrite($fh, "{\n");
		//fwrite($fh, "  exception {\n");
		//fwrite($fh, "    to \"\$HOME/\$DEFAULT/.Spam/\"\n");
		//fwrite($fh, "  }\n");
		//fwrite($fh, "}\n");
		//fwrite($fh, "else\n");
		//fwrite($fh, "{\n");
		fwrite($fh, "exception {\n");
		fwrite($fh, "	to \"\$HOME/\$DEFAULT\"\n");
		fwrite($fh, "}\n");
		//fwrite($fh, "}\n");
		fclose($fh);
		
		$fh = fopen($pref_dir."FILTERS", 'w');
		fclose($fh);
		$fh = fopen($pref_dir."SPAMFILTERS", 'w');
		fclose($fh);
		return true;
	}
	
	/**
	 * Генерация email
	 * 
	 * @param string $login первая чать $email
	 * @param string $domain вторая чать $email
	 * @param string $nickname nickname
	 * @param string $fname Имя
	 * @param string $lname Фамилия
	 * @return array array( array('username' => 'scorcher13123', 'domain' => '74.ru'), ... )
	 */
	public function GenerateEmail($login, $domain, $nickname = null, $fname = null, $lname = null)
	{
		LibFactory::GetStatic('textutil');
		LibFactory::GetStatic('domain');
		$patterns = array("@[^\w]+@", "@\_+@");
		$replacements = array("", "");
		$limit = 6;
		$login = strtolower($login);
		if(!empty($nickname))
			$nickname = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($nickname)));
		if(!empty($fname))
			$fname = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($fname)));
		if(!empty($lname))
			$lname = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($lname)));
		$domain = strtolower($domain);
		$examples = array();
		$variant = array();
		//error_log('$fname: '.$fname.'  $lname: '.$lname.'  $lname2: '.strtolower($fname2).'  $lname3: '.$this->_translit_rus_lat(strtolower($fname2)));
		//error_log('$domain: '.$domain);
		if(is_array($this->_config['mail_services']))
		{
			foreach($this->_config['mail_services'] as $k=>$v)
				if($v['name'] != $domain)
					$variant[] = array('type' => 1, 'domain' => $v['name']);
			
			if(!empty($nickname) && $login != $nickname)					
				foreach($this->_config['mail_services'] as $k=>$v)
					if($v['name'] != $domain)
						$variant[] = array('type' => 1, 'domain' => $v['name']);
		}
		if(!empty($fname))
		{
			$variant[] = array('type' => 3, 'domain' => $domain);
			$variant[] = array('type' => 4, 'domain' => $domain);
		}
		if(!empty($lname))
		{
			$variant[] = array('type' => 5, 'domain' => $domain);
			$variant[] = array('type' => 10, 'domain' => $domain);
		}
		if(!empty($fname) && !empty($lname))
		{
			$variant[] = array('type' => 6, 'domain' => $domain);
			$variant[] = array('type' => 7, 'domain' => $domain);
		}
		if(!empty($nickname))
		{
			$variant[] = array('type' => 9, 'domain' => $domain);
		}
		$variant[] = array('type' => 8, 'domain' => $domain);
		
		foreach($variant as $v)
		{
			switch($v['type'])
			{
				case 1:
					$new = $login;
					break;
				case 2:
					$new = $nickname;
					break;
				case 3:
					$new = $lname.$fname;
					break;
				case 4:
					$new = $fname.date('Y');
					break;
				case 5:
					$new = $lname.date('Y');
					break;
				case 6:
					$new = substr($fname, 0, 1).$lname;
					break;
				case 7:
					$new = substr($lname, 0, 1).$fname;
					break;
				case 8:
					$new = $login.date('Y');
					break;
				case 9:
					$new = $nickname.date('Y');
					break;
				case 10:
					$new = $fname.$lname;
					break;
			}
			$domain1 = $v['domain'];
			//error_log('tried '.$v['type'].': '.$new.'@'.$domain1);
			if(  ($login != $new || $domain1 != $domain)
					&& substr($new, 0, 1) != '.'
					&& substr($new, -1, 1) != '.'
					&& !in_array(array('username' => $new, 'domain' => $domain1), $examples)
				)
			{
				//$forbidden = $this->_get_forbidden_name($domain1);
				//error_log(var_export($forbidden, true));
				//if(!in_array($new, $forbidden))
				
				$result = Domain::CheckForbidden($new, '');
				if ($result === false)
					if($this->IsEMailExists($new."@".$domain1) !== true)
						$examples[] = array('username' => $new, 'domain' => $domain1);
			}
			if(count($examples)>=$limit)
				break;
		}
		return $examples;
	}
	
	/**
	 * Возвращает запрещенные имена для домена
	 * 
	 * @param string $domain Домен
	 * @return array
	 */
	/*protected function _get_forbidden_name($domain = null)
	{
		if($domain === null)
			$domain = $this->_config["default_mail_service"];
		$sql = "SELECT n.name FROM ".$this->_config["tables"]["forbidden_name"]." AS n";
		$sql.= " LEFT JOIN ".$this->_config["tables"]["forbidden_name_ref"]." AS r ON n.id=r.st_id";
		$sql.= " WHERE r.domain = '".addslashes($domain)."' OR IFNULL(r.domain, true)=true";
		$res = $this->_db->query($sql);
		$names = array();
		while ($row = $res->fetch_assoc())
		$names[] = $row['name'];
		return $names;
	}*/
	
	/**
	 * Возврашает доступные домены
	 * 
	 * @return array
	 */
	public function GetMailServices()
	{
		if(!is_array($this->_config['mail_services']))
			return array();
		
		$arr = array();
		foreach($this->_config['mail_services'] as $k=>$v)
			$arr[$k] = array(
					'name' => $v['name'],
					'url' => $v['url'],
					);
		return $arr;
	}
	
	/**
	 * Возврашает домен по-умолчанию
	 * 
	 * @return string
	 */
	public function GetDefaultMailService()
	{
		if(isset($this->_config['default_mail_service']))
			return $this->_config['default_mail_service'];
		else
			return null;
	}
	
	/**
	 * Блокировка почтового ящика
	 * 
	 * @param string email
	 * @param bool block - block or unblock
	 * @return bool
	 */
	static public function BlockEmail($email, $block = true)
	{
		global $OBJECTS;
		
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return false;
		
		$db = DBFactory::GetInstance('freemail');
		
		$sql = "UPDATE mailbox SET";
		$sql.= " active='".($block?'0':'1')."'";
		$sql.= " WHERE username='".addslashes($email)."'";
		if ($db->query($sql))
		{
			if( $block )
				$OBJECTS['log']->Log(362, 0, array('email' => $email));
			else
				$OBJECTS['log']->Log(493, 0, array('email' => $email));
			return true;
		}
		else
			return false;
	}
	
}

?>