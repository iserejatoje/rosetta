<?

/**
 * Работа с пользователями
 * работа ведется напрямую через cookie, чтобы не заморачиваться с сессиями
 * проверка ведется по уникальному 32 символьному ключу и ip адресов компьютера и прокси сервера
 */

class User
{
	static $ERROR = array(
		1 => 'Пользователь и(или) пароль не верны',
		'Пользователь с данным почтовым ящиком не зарегистрирован',
		'Пароль не может быть выслан по техническим причинам'
		);
	private $_byLogin = true;
	private $_fieldLogin = '';
	private $_fields = "";
	private $_db;
	private $_table;
	private $_user = null;
	private $_remember = false;
	private $_auth = false;
	private $_errindex;

	/**
	 * конструктор и по совместительству логин и проверка по куке
	 * @param string login логин
	 * @param string password пароль
	 * @param object db объект базы данных
	 * @param object table таблица пользователей
	 * @param boolean bylogin (true - авторизация по логину, false - по email)
	 * @param string fields дополнительные поля
	 */
	function __construct($login, $password, $db, $table, $bylogin = true, $fields = "", $remember = false)
	{
		$this->_db = $db;
		$this->_table = $table;
		$this->_remember = $remember;
		$this->_byLogin = $bylogin;
		if($this->_byLogin === true)
			$this->_fieldLogin = 'login';
		else
			$this->_fieldLogin = 'email';
		$this->_fields = $fields;
		if(!empty($login) && !empty($password))
			$this->Authorize($login, $password);
		else
			$this->Check();
	}

	// авторизация
	function Authorize($login, $password)
	{
		list($login, $password) = Data::Escape(array($login, $password));

		$sql = "SELECT id, email, question".(!empty($this->_fields)?','.$this->_fields:'')."
				FROM {$this->_table}
				WHERE {$this->_fieldLogin}='$login' AND password='$password' AND activation='' AND blocked=0";

		$res = $this->_db->query($sql);
		if($row = $res->fetch_assoc())
		{
			$this->_auth = true;
			$this->_user = $row;
			$this->_user['login'] = $login;
			$scode = Data::GetRandStr();
			$ip = getenv("REMOTE_ADDR");
			$ip_fw = getenv("HTTP_X_FORWARDED_FOR");
			$sql = "UPDATE {$this->_table}
					SET session='$scode',
						date_last=NOW(),
						ip='$ip',
						ip_fw='$ip_fw'
					WHERE id={$this->_user['id']}";

			$this->_db->query($sql);
			if($this->_remember==true)
				setcookie('AUTHID', $scode, time()+31536000); // запоминаем на год
			else
				setcookie('AUTHID', $scode);
			return true;
		}
		else
			return false;
	}

	// проверка по куке авторизованности
	function Check()
	{
		if(isset($_COOKIE['AUTHID']))
		{
			$ip = getenv("REMOTE_ADDR");
			$ip_fw = getenv("HTTP_X_FORWARDED_FOR");
			$sql = "SELECT id, {$this->_fieldLogin}, email, question".(!empty($this->_fields)?','.$this->_fields:'')."
					FROM {$this->_table}
					WHERE session='{$_COOKIE['AUTHID']}' AND activation='' AND blocked=0"; // AND ip='$ip' AND ip_fw='$ip_fw'";
			$res = $this->_db->query($sql);
			if($row = $res->fetch_assoc())
			{
				$this->_auth = true;
				$this->_user = $row;
				$sql = "UPDATE {$this->_table}
						SET date_last=NOW()
						WHERE id={$this->_user['id']}";
				$this->_db->query($sql);
				return true;
			}
		}
		return false;
	}

	// выход
	function Logout()
	{
		if (!empty($this->_user['id'])) {
			$sql = "UPDATE {$this->_table}
				SET session=''
				WHERE id={$this->_user['id']}";
			$this->_db->query($sql);
			$this->_auth = false;
			$this->_user['login'] = '';
			$this->_user=null;
		}
	}
	function LogoutAll()
	{
		if (!empty($this->_user['id'])) {
			$sql = "UPDATE {$this->_table}
				SET session=''
				WHERE id>0;
			$this->_db->query($sql);
			$this->_auth = false;
			$this->_user['login'] = '';
			$this->_user=null;
		}
	}
	// авторизирован?
	function IsAuth()
	{
		return $this->_auth;
	}

	// добавить нового
	function Add($login, $password, $email='')
	{
		list($login, $password, $email) = Data::Escape(array($login, $password, $email));
		$sql = "SELECT {$this->_fieldLogin}
				FROM {$this->_table}
				WHERE {$this->_fieldLogin}='$login'";
		$res = $this->_db->query($sql);
		if($res->num_rows>0)
			return false;
		$ip = getenv("REMOTE_ADDR");
		$ip_fw = getenv("HTTP_X_FORWARDED_FOR");
		$sql = "INSERT INTO {$this->_table}
				({$this->_fieldLogin}, password,".($this->_byLogin===true?"email,":"")."date_reg, ip, ip_fw)
				VALUES
				('$login', '$password',".($this->_byLogin===true?"'$email',":"")."NOW(), '$ip', '$ip_fw')";
		$this->_db->query($sql);
		return true;
	}

	// обновить данные пользователя
	function UpdatePassword($password, $cpassword = null, $id = null)
	{
		if($id === null)
		{
			if($this->IsAuth())
				$id = $this->_user['id'];
			else
				return false;
		}
		if($cpassword != null)
			$pw = " AND password='$cpassword'";
		$sql = "UPDATE {$this->_table}
				SET password='$password'
				WHERE id=$id$pw";
		$this->_db->query($sql);
		return true;
	}

	function UpdateEmail($email, $cpassword = null, $id = null)
	{
		if($id === null)
		{
			if($this->IsAuth())
				$id = $this->_user['id'];
			else
				return false;
		}
		if($cpassword != null)
			$pw = " AND password='$cpassword'";
		$sql = "UPDATE {$this->_table}
				SET email='$email'
				WHERE id=$id$pw";
		$this->_db->query($sql);
		return true;
	}

	// удалить
	function Remove()
	{
	}

	// заблокировать
	function Block()
	{
	}

	// отпарвка запроса активации
	function SendActivation()
	{
	}

	// активация
	function Activate()
	{
	}

	// отправка востановления пароля
	function SendRemind($email, $domain, $section)
	{
		$sql = "SELECT email, password".($this->_byLogin===true?", login":"")." FROM {$this->_table} WHERE email='$email'";
		$res = $this->_db->query($sql);
		if ($row = $res->fetch_row())
		{
			$subj = "Напоминание пароля. $section $domain\n";
			$header = "From: $section <remind@$domain>\nContent-Type: text/html ; charset=windows-1251;\n";
			$msg = "Здравствуйте.<br><br>
			На сайте $domain в разделе $section был указан Ваш ящик в форме востановления пароля.<br>
			Данные для авторизации:<br><br>";
			if($this->_byLogin === true)
				$msg.= "Имя: ".$row[2]."<br>";
			$msg.= "E-mail: ".$row[0]."<br>
			Пароль: ".$row[1]."<br><br>
			С уважением,<br>
			Служба поддержки $section $domain<br><br>";
			if(mail($email, $subj, $msg, $header)===false)
			{
				$this->_errindex = 3;
				return false;
			}
			return true;
		}
		$this->_errindex = 2;
		return false;
	}

	// проверка правильности
	function IsRemember()
	{
	}

	function GetLastError()
	{
		return self::$ERROR[$this->_errindex];
	}

	function __set($name, $value)
	{
		switch($name)
		{
		case 'DB':
			$this->_db = $value;
			break;
		case 'Table':
			$this->_table = $value;
			break;
		case 'Remember':
			$this->_remember = $value;
			break;
		case 'Fields':
			$this->_fields = $value;
			break;
		}
	}

	function __get($name)
	{
		switch($name)
		{
		case 'DB':
			return $this->_db;
		case 'Table':
			return $this->_table;
		case 'Remember':
			return $this->_remember;
		case 'Fields':
			return $this->_fields;
		}
		$name = strtolower($name);
		if($this->_user == null)
			return false;
		else if(isset($this->_user[$name]))
			return $this->_user[$name];
		else return;
	}

	function __isset($name)
	{
		switch($name)
		{
		case 'DB':
			return !empty($this->_db);
		case 'Table':
			return !empty($this->_table);
		case 'Remember':
			return !empty($this->_remember);
		case 'Fields':
			return !empty($this->_fields);
		}
		$name = strtolower($name);
		if($this->_user == null)
			return false;
		else return isset($this->_user[$name]);
	}

	function __unset($name)
	{
		switch($name)
		{
		case 'DB':
			unset($this->_db);
			break;
		case 'Table':
			unset($this->_table);
			break;
		case 'Remember':
			unset($this->_remember);
			break;
		case 'Fields':
			unset($this->_fields);
			break;
		}
		$name = strtolower($name);
		if($this->_user == null)
			return;
		else unset($this->_user[$name]);
	}
}

?>
