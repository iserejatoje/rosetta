<?php

//2do: тестить

/**
 * Управление пользователям
 * @version 1.0
 * @created 27-июл-2007 9:16:39
 */

class PUsersMgr implements IDisposable
{
	static protected $_instance = null;

	private $config = array(
		'db' => array(
			'name' => 'webbazar',
		),
		'session' => array(
			'code_length'	=> 32,
			'code_safe' 	=> false,
			'remember_time'	=> 3600, // один год
			'lifetime'		=> 3600,
			'updateperiod'	=> 900,
		),
		'caching' => true,

	);

	static $tables = array(
		'users' => 'users',
		'forgot_codes' => 'forgot_codes',
		'groups_ref' => 'groups_ref',
		'email_activation' => 'user_email_activation',
		'object_changements' => 'object_changements',

		'desire' => 'desire',
		'friends' => 'friends',
		'friends_messages' => 'friends_messages',

		'messages' => 'messages',
		'messages_files' => 'messages_files',
		'messages_black_list' => 'messages_black_list',
		'messages_contacts' => 'messages_contacts',

		'profile' => 'profile',
		'profile_auto' => 'profile_auto',
		'profile_auto_counter' => 'profile_auto_counter',
		'profile_auto_cars' => 'profile_auto_cars',
		'profile_auto_cars_counter' => 'profile_auto_cars_counter',
		'profile_static_ref' => 'profile_static_ref',
		'profile_general' => 'profile_general',
		'profile_notice' => 'profile_notice',
		'profile_location' => 'profile_location',
		'profile_job' => 'profile_job',

		'profile_widgets_announce_weather' => 'profile_widgets_announce_weather',
		'profile_widgets_announce_im' => 'profile_widgets_announce_im',
		'profile_widgets_announce_friends' => 'profile_widgets_announce_friends',
		'profile_widgets_announce_blog' => 'profile_widgets_announce_blog',

		'profile_module_im' => 'profile_module_im',
		'profile_module_mail' => 'profile_module_mail',

		'profile_themes_blogs' => 'profile_themes_blogs',
		'profile_theme_talk' => 'profile_theme_talk',

		'log_time_sent' => 'log_time_sent',

		'users_visitors' => 'users_visitors',
		'user_favorites' => 'user_favorites',

		'groups' => 'groups',
		'groups_ref' => 'groups_ref',
		'group_roles_ref' => 'group_roles_ref',
		'roles_ref' => 'roles_ref',
		'roles' => 'roles',
		'roles_tree' => 'roles_tree',
		'roles_tree_ref' => 'roles_tree_ref',

		'community_messages' => 'community_messages',

		'log_notification_mail' => 'log_notification_mail',
		'log_notification_user' => 'log_notification_user',
	);

	static $db						= null;
	static $cacher					= null;
	static $redis					= null;
	static $redis_data				= null;
	public $profileProviderMgr		= null;
	public $sessionTimeLife			= 2400;
	private $users = array();
	private $_deskDomain = null;
	private $_mobileDomain = null;

	// все чистятся по пользователю, кроме сессий
	const CH_ROLESFORGROUP			= 0x001;		// rolesforgroup
	const CH_ROLESFORUSER			= 0x002;		// rolesforuser
	const CH_ROLESMODULES			= 0x004;		// rolesmodules
	const CH_ROLESGROUPS			= 0x008;		// rolesgroups
	const CH_USER					= 0x010;		// user
	const CH_USERMC					= 0x020;		// user_mc
	const CH_SLASTUPDATE			= 0x040;		// slastupdate
	const CH_SESSION				= 0x080;		// session по куке
	const CH_USERSESSION			= 0x100;		// session чистка всех сессий пользователя
	const CH_PROFILEGENERAL			= 0x200;		// профиль general

	const CH_ALL					= 0x3FF;		// все данные, при блокировке, удалении
	const CH_ROLES					= 0x00F;		// роли, при изменение ролей

	public function __construct()
	{
		self::$_instance = $this;

		if ($this->config['caching'] === true && self::$cacher === null) {
			LibFactory::GetStatic('cache');
			self::$cacher = new Cache();
			self::$cacher->Init('memcache', 'e_passport');
		}

		/*if ($this->config['caching'] === true && self::$redis === null) {
			self::$redis = LibFactory::GetInstance('redis');
			self::$redis->Init('sessions');
		}

		if ($this->config['caching'] === true && self::$redis_data === null) {
			self::$redis_data = LibFactory::GetInstance('redis');
			self::$redis_data->Init('sessions');
		}*/

		// коннектимся к базе
		PUsersMgr::$db = DBFactory::GetInstance($this->config['db']['name']);
		if(PUsersMgr::$db == false)
			throw new Exception('Can\'t connect to passport database');

		//set _domain
		if(0 === strpos($_SERVER['SERVER_NAME'], 'm.'))
		{
			$this->_deskDomain = substr($_SERVER['SERVER_NAME'], 2);
			$this->_mobileDomain = $_SERVER['SERVER_NAME'];
		}
		else
		{
			$this->_deskDomain = $_SERVER['SERVER_NAME'];
			$this->_mobileDomain = 'm.'.$_SERVER['SERVER_NAME'];
		}
	}

	public static function getInstance()
	{
		if( self::$_instance === null )
			self::$_instance = new self;

		return self::$_instance;
	}

	public function Dispose()
	{
		// удаление всех провайдеров профилей
		foreach($this->users as $user)
			if(is_a($user->Profile, 'PProfileMgr'))
				$user->Profile->Dispose();
	}

	public function Flush()
	{
		foreach($this->users as $user)
			$user->Dispose();
		unset($this->users);
		$this->users = array();
	}

	/**
	 * Добавить пользователя в базу
	 * @param array информация о пользователе
	 * @return идентификатор пользователя
	 */
	static public function Add(array $user)
	{
		$salt = PUtil::GenerateRandomString(16);
		if(!isset($user['Blocked']))
			$user['Blocked'] = 0;

		foreach($user as $k => $v)
			$user[$k] = addslashes($v);

		$sql = "SELECT * FROM ".self::$tables['users'];
		$sql.= " WHERE `Email` = '".strtolower($user['Email'])."'";
		if (false == ($res = self::$db->query($sql)))
			return null;

		if ($res->num_rows > 0)
			return null;

		$sql = "INSERT INTO ".self::$tables['users']." SET ";
		$sql.= " `Email` = '".strtolower($user['Email'])."'";
		$sql.= " ,`OurEmail` = '".strtolower($user['OurEmail'])."'";
		$sql.= " ,`Password` = '".self::PasswordHash($user['Password'],addslashes($salt))."'";
		$sql.= " ,`Salt` = '".addslashes($salt)."'";
		$sql.= " ,`Registered` = NOW()";
		$sql.= " ,`Question` = '".$user['Question']."'";
		$sql.= " ,`Answer` = '".$user['Answer']."'";
		$sql.= " ,`Blocked` = '".$user['Blocked']."'";
		$sql.= " ,`RegionID` = '".$user['RegionID']."'";
		$sql.= " ,`DomainName` = '".$user['DomainName']."'";
		$sql.= " ,`LatinName` = 'newuser".$user['Email']."' ";

		if (false == ($res = self::$db->query($sql)))
			return null;

		return self::$db->insert_id;
	}

	/**
	 * Удаление пользователя
	 * @param int    user_id идентификатор пользователя
	 */
	static public function Remove($user_id)
	{
		if (!is_numeric($user_id) || $user_id <= 0)
			return false;

		$sql = "DELETE FROM ".self::$tables['users'];
		$sql.= " WHERE `UserID` = ".(int) $user_id;

		if (false == ($res = self::$db->query($sql)))
			return false;

		self::ClearUserSessions($user_id);
		PUsersMgr::ClearCache(PUsersMgr::CH_ALL, array('userid' => $user_id));

		return true;
	}

	/**
	 * Обновить информацию о пользователе
	 * @param array информация о пользователе
	 */
	public function Update(array $user)
	{
		$uinfo = self::GetUserInfoArrayByEmail($user['Email']);
		if ($uinfo === null)
			return false;

		foreach(array('OurEmail', 'Question', 'Answer', 'Blocked',
			'IsDel', 'AutoLoginCross', 'RegionID') as $v) {

			if (isset($user[$v]))
				continue ;

			$user[$v] = $uinfo[$v];
		}

		foreach($user as $k => $v)
			$user[$k] = addslashes($v);

		$sql = "UPDATE ".self::$tables['users']. " SET ";
		$sql.= " `OurEmail` = '".$user['OurEmail']."'";
		$sql.= " ,`Question` = '".$user['Question']."'";
		$sql.= " ,`Answer` = '".$user['Answer']."'";
		$sql.= " ,`Blocked` = '".$user['Blocked']."'";
		$sql.= " ,`IsDel` = '".$user['IsDel']."'";
		$sql.= " ,`AutoLoginCross` = '".$user['AutoLoginCross']."'";
		$sql.= " ,`RegionID` = '".$user['RegionID']."'";

		$salt = '';
		if (strlen($user['Password']) != 0) {
			$salt = PUtil::GenerateRandomString(16);

			$sql.= " ,`Password` = '".self::PasswordHash($user['Password'],addslashes($salt))."'";
			$sql.= " ,`Salt` = '".addslashes($salt)."'";
		}

		$sql.= " WHERE `Email` = '".$user['Email']."'";
		if (false == self::$db->query($sql))
			return false;

		self::ClearCache(PUsersMgr::CH_USER|PUsersMgr::CH_USERSESSION, array('userid' => $uinfo['UserID']));
		if ($salt != '')
			self::ClearUserSessions($uinfo['UserID']); // здесь мы не знаем сессию, поэтому сносим все

		self::PutToModerate($uinfo['UserID']);
	}

	/**
	 * Обновить информацию о пользователе
	 * @param array информация о пользователе
	 */
	public function UpdateByID(array $user)
	{
		$uinfo = self::GetUserInfoArray($user['ID']);
		if ($uinfo === null)
			return false;

		foreach(array('Email', 'OurEmail', 'Question', 'Answer',
			'Blocked', 'IsDel', 'AutoLoginCross', 'RegionID') as $v) {

			if (isset($user[$v]))
				continue ;

			$user[$v] = $uinfo[$v];
		}

		foreach($user as $k => $v)
			$user[$k] = addslashes($v);

		if ($user['ID'] == 1) {

			if (strlen($user['Password']) != 0) {
				//self::SetPassword($uinfo['Email'], $user['Password']);

				$uinfo = self::GetUserInfoArray($user['ID']);
			}

			$uinfo['Email'] = strtolower($user['Email']);
			$uinfo['OurEmail'] = strtolower($user['OurEmail']);
			$uinfo['Question'] = $user['Question'];
			$uinfo['Answer'] = $user['Answer'];
			$uinfo['Blocked'] = $user['Blocked'];
			$uinfo['IsDel'] = $user['IsDel'];
			$uinfo['Blocked'] = $user['Blocked'];
			$uinfo['AutoLoginCross'] = $user['AutoLoginCross'];
			$uinfo['RegionID'] = $user['RegionID'];

			if (self::$cacher !== null) {
				self::$cacher->Set('user_'.$user['ID'], $uinfo);
				self::$cacher->Set('user_by_email_'.$uinfo['Email'], $user['ID']);
			}

			// вызов события о том что были изменения в данных пользователя

			return true;
		}

		$sql = "UPDATE ".self::$tables['users']. " SET ";
		$sql.= " `Email` = '".$user['Email']."'";
		$sql.= " ,`OurEmail` = '".$user['OurEmail']."'";
		$sql.= " ,`Question` = '".$user['Question']."'";
		$sql.= " ,`Answer` = '".$user['Answer']."'";
		$sql.= " ,`Blocked` = '".$user['Blocked']."'";
		$sql.= " ,`IsDel` = '".$user['IsDel']."'";
		$sql.= " ,`AutoLoginCross` = '".$user['AutoLoginCross']."'";
		$sql.= " ,`RegionID` = '".$user['RegionID']."'";

		$salt = '';
		if (strlen($user['Password']) != 0) {
			$salt = PUtil::GenerateRandomString(16);

			$sql.= " ,`Password` = '".self::PasswordHash($user['Password'],addslashes($salt))."'";
			$sql.= " ,`Salt` = '".addslashes($salt)."'";
		}

		$sql.= " WHERE `UserID` = '".$uinfo['UserID']."'";
		if (false == self::$db->query($sql))
			return false;

		self::ClearCache(PUsersMgr::CH_USER|PUsersMgr::CH_USERSESSION, array('userid' => $uinfo['UserID']));
		if ($salt != '')
			self::ClearUserSessions($uinfo['UserID']); // здесь мы не знаем сессию, поэтому сносим все

		self::PutToModerate($uinfo['UserID']);
	}

	/**
	 * Обновить информацию о пользователе
	 * @param array информация о пользователе
	 */
	public function StorageUpdateByID(array $user)
	{
		if (!is_numeric($user['UserID']) || $user['UserID'] <= 0)
			return false;

		$fields = array();
		foreach($user as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "UPDATE ".self::$tables['users']. " SET ";
		$sql.= implode(', ', $fields);
		$sql.= " WHERE `UserID` = '".$user['UserID']."'";

		if (false == self::$db->query($sql))
			return false;
	}

	/**
	 * Установить пароль пользователя
	 * @param string почтовый ящик
	 * @param string новый пароль
	 */
	static public function SetPassword($email, $password, $sessioncode = null)
	{
		$uinfo = self::GetUserInfoArrayByEmail($email);
		if ($uinfo === null)
			return false;

		$salt = PUtil::GenerateRandomString(16);

		$sql = "UPDATE ".self::$tables['users']." SET ";
		$sql.= " `Password` = '".self::PasswordHash($password,$salt)."'";
        $sql.= " ,`Salt` = '".addslashes($salt)."'";
        $sql.= " WHERE `Email` = '".addslashes($email)."'";

		if (false == (self::$db->query($sql)))
			return false;

		self::ClearUserSessions($uinfo['UserID'], $sessioncode);
	}

	/**
	 * Установить код востановления пароля
	 * @param int UserID - идентификатор пользователя
	 * @param string Code - код востановления пароля
	 */
	static public function SetForgotCode($uid, $code)
	{
		if (!is_numeric($uid) || $uid <= 0)
			return false;

		$sql = "DELETE FROM ".self::$tables['forgot_codes'];
		$sql.= " WHERE `Valid` < NOW()";
		self::$db->query($sql);

		$sql = "INSERT INTO ".self::$tables['forgot_codes']." SET ";
		$sql.= " `UserID` = ".(int) $uid;
		$sql.= " ,`Code` = '".addslashes($code)."'";
		$sql.= " ,`Valid` = DATE_ADD(NOW(), INTERVAL 1 DAY) ";
		self::$db->query($sql);
	}

	/**
	 * Проверить код востановления пароля
	 * @param string Code - код востановления пароля
	 * @return int UserID - идентификатор пользователя
	 */
	static public function CheckForgotCode($code) {

		$sql = "DELETE FROM ".self::$tables['forgot_codes'];
		$sql.= " WHERE `Valid` < NOW()";
		self::$db->query($sql);

		$sql = "SELECT `UserID` FROM ".self::$tables['forgot_codes']." WHERE ";
		$sql.= " `Code` = '".addslashes($code)."' AND `Valid` >= NOW() ";
		$sql.= " ORDER by `Valid` DESC LIMIT 1 ";

		$res = self::$db->query($sql);
		if (!$res || !$res->num_rows)
			return false;

		list($uid) = $res->fetch_row();
		return $uid;
	}

	/**
	 * Проверка зарегистрированности почтового ящика, проверяет по 2-м полям
	 * @param string почтовый ящик
	 * @param string исключить почтовый ящик
	 * @param int исключить пользователя
	 * @return bool зарегистрирован?
	 */
	public function IsEMailExists($email, $emailexclude = '', $userexclude = 0)
	{
		$email = trim($email);
		$emailexclude = trim($emailexclude);

		$cnt1 = $cnt2 = 0;
		if ($email != $emailexclude) {

			$sql = "SELECT * FROM ".self::$tables['users'];
			$sql.= " WHERE `Email` = '".addslashes($email)."'";

			if ($userexclude > 0)
				$sql.= " AND UserID != ".(int) $userexclude;

			$res = PUsersMgr::$db->query($sql);
			if ($res && $res->num_rows)
				return true;
		}

		if (!empty($emailexclude)) {
			$sql = "SELECT * FROM ".self::$tables['users'];
			$sql.= " WHERE `OurEmail` = '".addslashes($email)."'";
			$sql.= " AND `Email` != '".addslashes($emailexclude)."'";
		} else {
			$sql = "SELECT * FROM ".self::$tables['users'];
			$sql.= " WHERE `OurEmail` = '".addslashes($email)."'";
		}

		if ($userexclude > 0)
			$sql.= " AND UserID != ".(int) $userexclude;

    	$res = PUsersMgr::$db->query($sql);
		if ($res && $res->num_rows)
			return true;

		return false;
	}

	/**
	 * Проверка зарегистрированности имени, фамилии, отчества
	 * @param string отображаемре имя
	 * @return bool зарегистрирован?
	 */
	public function IsNameExists($firstname, $lastname, $midname, $userexclude = 0)
	{
		$name = PUtil::NickName2Latin($firstname.'|'.$lastname.'|'.$midname);

		$sql = "SELECT * FROM ".self::$tables['users'];
		$sql.= " WHERE `LatinName` = '".addslashes($name)."'";

		if ($userexclude > 0)
			$sql.= " AND UserID != ".(int) $userexclude;

		$res = PUsersMgr::$db->query($sql);
		if ($res && $res->num_rows)
			return true;

		return false;
	}

	/**
	 * Проверка логина/пароля пользователя
	 * @param string почтовый ящик
	 * @param string пароль
	 * @param bool существует?
	 */
	static function CheckPassword($email, $password, $regionid = 0, $domain = '')
	{
		return self::_checkPassword($email, $password, $regionid, $domain) > 0;
	}

	private static function _checkPassword($email, $password, $regionid = 0, $domain = '')
	{
		$sql = "SELECT u.UserID, u.Blocked, u.IsDel, u.Password, u.Salt, IFNULL(ua.UserID, -1) as Status ";
		$sql.= " FROM ".self::$tables['users']." AS u ";
		$sql.= " LEFT JOIN ".self::$tables['email_activation']." AS ua ON ua.UserID = u.UserID AND ua.Action = 1 ";
		$sql.= " WHERE u.Email = '".addslashes($email)."' OR u.OurEmail = '".addslashes($email)."' ";

		$res = PUsersMgr::$db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		$user = $res->fetch_assoc();
		if ($user['Status'] != -1)
			return -1;

		//if ($user['Blocked'] != 0)
		//	return -2;

		if ($user['IsDel'] != 0)
			return -3;

		if ($user['UserID'] <= 0 || $user['Password'] != self::PasswordHash($password, $user['Salt']))
			return 0;

		if ($regionid > 0 && $domain != '') {
			$sql = "SELECT GroupID FROM ".self::$tables['groups_ref'];
			$sql.= " WHERE GroupID = 354 AND UserID = ".$user['UserID'];

			$res = PUsersMgr::$db->query($sql);
			if ($res && $res->num_rows) {
				$sql = "UPDATE ".self::$tables['users']." SET ";
				$sql.= " RegionID = ".(int) $regionid;
				$sql.= " ,DomainName = '".addslashes($domain)."'";
				$sql.= " WHERE UserID = ".$user['UserID'];

				PUsersMgr::$db->query($sql);
			}
		}

		return $user['UserID'];
	}

	/**
	 * Изменить статус блокировки пользователя
	 * @param int идентификатор
	 * @param bool статус
	 */
	static function Block($user_id, $block)
	{
		$block = ($block ? 1 : 0);

		$sql = "UPDATE ".self::$tables['users']." SET ";
    	$sql.= " Blocked = ".$block;
        $sql.= " WHERE UserID = ".(int) $user_id;
		PUsersMgr::$db->query($sql);

		// добавим пользователя в группу заблокированных
		PGroupMgr::SetGroupsForUser($user_id, 415, $block);
		self::ClearUserSessions($user_id);
		self::ClearCache(PUsersMgr::CH_ALL, array('userid' => $user_id));

		return true;
	}

	/**
	 * Изменить статус удален пользователя или нет
	 * @param int идентификатор
	 * @param bool статус
	 * @param string причина
	 */
	static function Delete($user_id, $delete, $reason = '')
	{
		global $OBJECTS;

		$user = self::getInstance()->GetUser($user_id);
		if( $user === null )
			return false;

		$delete = ($delete ? 1 : 0);
		if( $user->OurEmail != '' )
		{
			LibFactory::GetStatic('mail_service');
			if( lib_mail_service::BlockEmail($user->OurEmail, $delete) === false )
				return false;
		}

		$sql = "UPDATE ".self::$tables['users']." SET ";
    	$sql.= " IsDel = ".$delete;
        $sql.= " WHERE UserID = ".(int) $user_id;
		PUsersMgr::$db->query($sql);

		self::ClearUserSessions($user_id);
		self::ClearCache(PUsersMgr::CH_ALL, array('userid' => $user_id));

		if( $delete )
			$OBJECTS['log']->Log(377, $user_id, array('Reason' => $reason));
		else
			$OBJECTS['log']->Log(378, $user_id, array('Reason' => $reason));

		return true;
	}

	/**
	 * Удалить сессии пользователя
	 * @param int идентификатор пользователя
	 */
	static function ClearUserSessions($user_id, $ignore_session_code = null)
	{
		return true;
		self::ClearCache(PUsersMgr::CH_ALL, array('userid' => $user_id));
		if (self::$cacher === null)
			return ;

		$sessions = self::$cacher->Get('sids_'.$user_id);
		if (!is_array($sessions))
			return ;

		foreach($sessions as $k => $session_code) {
			if ($session_code == $ignore_session_code)
				continue ;

			self::$cacher->Remove('s_'.$session_code);

			unset($sessions[$k]);
		}

		self::$cacher->Remove('sids_'.$user_id);
	}

	/**
	 * Авторизация и аутентификация пользоватля
	 *
	 * @param string login		 почтовый ящик пользователя
	 * @param string password    пароль
	 * @param bool remember      запомнить на год
	 * @return User пользователь, если не аутифицирован возвращает пустой объект
	 */
	function Login($email = null, $password = null, $remember = false, $regionid = 0, $domain = '')
	{
		global $OBJECTS;
		$user = null;

		$session_code = $this->CreateSession();
		if($email !== null && $password !== null)
		{
			try
			{

				$user = $this->Authorization($session_code, $email, $password, $remember, $regionid, $domain);
			}
			catch (Exception $e)
			{
				if($e->getCode() === ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED)
					$OBJECTS['uerror']->AddErrorIndexed('password', ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED);
				elseif($e->getCode() === ERR_L_PASSPORT_INCORRECT_PASSWORD)
					$OBJECTS['uerror']->AddErrorIndexed('password', ERR_L_PASSPORT_INCORRECT_PASSWORD, App::$Request->Get['url']->Url());
				elseif($e->getCode() === ERR_L_PASSPORT_USER_DELETED)
					$OBJECTS['uerror']->AddErrorIndexed('password', ERR_L_PASSPORT_USER_DELETED);
				else
					$OBJECTS['uerror']->AddErrorIndexed('password', $e->getCode());
			}
		}

		if($user === null)
			$user = $this->AuthorizationFromSession($session_code);

		if($user === null)
		{
			$user = $this->GuestUser($session_code, true);
		}
		else {
			//$this->UpdateVisitedTime($user);
		}
		/*
		if( $user !== null && $user->IsAuth() )
		{
			setcookie("isauth", 1, time() + 3600, '/', $this->_deskDomain);
			setcookie("isauth", 1, time() + 3600, '/', $this->_mobileDomain);
		}
		else
		{
			setcookie("isauth", 0, time() + 3600, '/', $this->_deskDomain);
			setcookie("isauth", 0, time() + 3600, '/', $this->_mobileDomain);
		}
		*/
		return $user;
	}

	/**
	 * Обновление времени последнего посещения
	 * @param PUser пользователь
	 */
	protected function UpdateVisitedTime($user)
	{
		if($user->ID === 0)
			return;

		$lastupdate = false;
		if(self::$cacher !== false)
			$lastupdate = self::$cacher->Get('slastupdate_'.$user->ID);

		if($lastupdate === false || time() - $lastupdate > $this->config['session']['updateperiod'])
		{
			$sql = "UPDATE ".self::$tables['users']." SET ";
	    	$sql.= " Visited = NOW() ";
	        $sql.= " WHERE UserID = ".(int) $user->ID;
			self::$db->query($sql);

			self::ClearCache(PUsersMgr::CH_USER, array('userid' => $user->ID));
			if(self::$cacher !== false)
				self::$cacher->Set('slastupdate_'.$user->ID, time(), $this->config['session']['updateperiod']);
		}
	}

	/**
	 * Выход пользователя c текущего компьютера
	 */
	function Logout()
	{
		if(!empty($_COOKIE['pscode']))
		{
			if (self::$cacher !== false) {
				self::$cacher->Remove('s_'.App::$User->SessionCode);

				$sids = self::$cacher->Get('sids_'.App::$User->ID);
				foreach($sids as $k => $v)
					if ($v == App::$User->SessionCode)
					{
						unset($sids[$k]);
					}
				self::$cacher->Set('sids_'.App::$User->ID, $sids);
			}
		}
	}
	public function LogoutAll($usersObjects)
	{
		foreach ($usersObjects as $user) {
			SendSessionCode($user,false);
		}
	}
	/**
	 * Функция хэширования пароля
	 * @param string пароль
	 * @param string соль (32 случайных символа 0-9, a-z, A-Z)
	 * @return string хэш пароля
	 */
	public static function PasswordHash($password, $salt)
	{
		if(strlen($password) == 0)
			return '';

		return md5(md5($password).$salt);
	}

	/**
	 * Авторизация пользователя, создание сессии пользователя
	 *
	 * @param string код сессии
	 * @param string почтовый ящик пользователя
	 * @param string пароль
	 * @param bool запомнить на год
	 * @return User пользователь, если не аутифицирован возвращает гостевого пользователя
	 * @exception 1				пользователь не найден
	 * @exception 2				не верный пароль
	 */
	function Authorization($session_code, $email, $password, $remember = false, $regionid = 0, $domain = '')
	{

		// функция не кэширует данные, довольно редко вызывается
		if(trim($email) == '')
			return null;

		$id = self::_checkPassword($email, $password, $regionid, $domain);
		if($id !== null)
		{
			if($id == 0)
				throw new LogicMyException('ERR_L_PASSPORT_INCORRECT_PASSWORD', ERR_L_PASSPORT_INCORRECT_PASSWORD);
			if($id == -1)
				throw new LogicMyException('ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED', ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED);
			if($id == -2)
				throw new LogicMyException('ERR_L_PASSPORT_USER_IS_BLOCKED', ERR_L_PASSPORT_USER_IS_BLOCKED);
			if($id == -3)
				throw new LogicMyException('ERR_L_PASSPORT_USER_DELETED', ERR_L_PASSPORT_USER_DELETED);
				
			$con4 = mysqli_connect("localhost",'ipkhratd_tech', 'mTpoofdA', 'ipkhratd_tech');
			$query = "UPDATE logoutall SET email = 1 WHERE email = '".$email."'";
			$getLogout = mysqli_query($con4, $query);
			$result = mysqli_fetch_array($getLogout);
			$user = $this->GetUserInfo($id, $session_code, true);

			$user->SessionCode = $session_code;
			$this->SendSessionCode($user, false);
			$this->SetSessionUser($session_code, $id, false);
			return $user;
		}
		return null;
	}

	private $cookie_sent = false;
	private function SendSessionCode($user, $remember)
	{
		if($this->cookie_sent === true)
			return;

		if($remember === false)
		{
			setcookie("pscode", $user->SessionCode, null, '/', $this->_deskDomain);
			setcookie("pscode", $user->SessionCode, null, '/', $this->_mobileDomain);
		}
		else
		{
			setcookie("pscode", $user->SessionCode, time() + $this->config['session']['remember_time'], '/', $this->_deskDomain);
			setcookie("pscode", $user->SessionCode, time() + $this->config['session']['remember_time'], '/', $this->_mobileDomain);
		}
		$this->cookie_sent = true;
	}

	public function SetSessionUser($session_code, $user_id, $remember = false)
	{
		$timelife = $this->config['session']['lifetime'];
		if($remember === true)
			$timelife = $this->config['session']['remember_time'];

		if($user_id > 0) {

			if (self::$cacher !== null) {
				$data = self::$cacher->Get('s_'.$session_code);
				self::$cacher->Set('s_'.$session_code, $user_id.'|'.$timelife, $timelife);
				if (false !== $data) {

					list($cuser_id, ) = explode('|', $data);
					$sids = self::$cacher->Get('sids_'.$cuser_id);
					foreach($sids as $k => $v)
						if ($v == $session_code)
						{
							unset($sids[$k]);
						}
					self::$cacher->Set('sids_'.$user_id, $sids);
				}
				$sids = self::$cacher->Get('sids_'.$user_id);
				$sids[] =  $session_code;
				self::$cacher->Set('sids_'.$user_id, $sids);
			}
		}

	}

	private function CreateSession()
	{
		if(isset($_GET['SID']))
		{
			$session_code = $_GET['SID'];
		}
		else
			$session_code = $_COOKIE['pscode'];

		if(strlen($session_code) != $this->config['session']['code_length'] || !preg_match('@^[A-Za-z0-9]+$@', $session_code))
		{
			unset($session_code);
		}

		if(empty($session_code) || !is_string($session_code))
		{
			if($this->config['session']['code_safe'] == true)
				$session_code = $this->GenerateSafeSessionCode();
			else
				$session_code = $this->GenerateSessionCode();
		}
		return $session_code;
	}

	/**
	 * Получить гостевого пользователя
	 */
	private function GuestUser($code, $with_roles = false)
	{
		$user = $this->GetUserInfo(0, $code, $with_roles);

		if(empty($_COOKIE['pscode'])) // для гостя тоже надо куку
			$this->SendSessionCode($user, $remember);

		return $user;
	}

	/**
	 * Проверка валидности сессии
	 *
	 * @param string session_code идентификатор сессии
	 * @param bool remember запомнить пользователя
	 * @return bool
	 */
	public function SetSession($session_code, $remember)
	{
		if(empty($session_code))
			return false;

		if(self::$cacher !== null && null !== ($data = self::$cacher->Get('s_'.$session_code))) {
			list($user_id, $timelife) = explode('|', $data);
		} else
			$user_id = 0;

		if($user_id > 0)
		{
			if($remember === false) {
				setcookie("pscode", $session_code, null, '/', $this->_deskDomain);
				setcookie("pscode", $session_code, null, '/', $this->_mobileDomain);

				if ($timelife <= 0)
					$timelife = $this->config['session']['lifetime'] / 2;

			} else {
				setcookie("pscode", $session_code, time() + $this->config['session']['remember_time'], '/', $this->_deskDomain);
				setcookie("pscode", $session_code, time() + $this->config['session']['remember_time'], '/', $this->_mobileDomain);
				$timelife = $this->config['session']['remember_time'];
			}

			if (self::$cacher !== null)
				self::$cacher->Set('s_'.$session_code, $user_id.'|'.$timelife, $timelife);

			$this->cookie_sent = true;
			return true;
		}
	}

	function AuthorizationByID($id, $session_code = null)
	{
		$user = $this->GetUserInfo($id, $session_code);
		if($user === null)
			return null;

		$user->SessionCode = $session_code;
		return $user;
	}

	/**
	 * Проверка пользователя по сессии
	 * @param string session_id идентификатор сессии
	 * @exception 3				пользователь заблокирован
	 */
	function AuthorizationFromSession($session_code)
	{
		// кэшируем сессии
		if(empty($session_code))
			return null;

		if(self::$cacher !== null && false !== ($data = self::$cacher->Get('s_'.$session_code))) {
			list($user_id, $timelife) = explode('|', $data);
		} else
			$user_id = 0;

		if($user_id > 0)
		{
			$user = $this->GetUserInfo($user_id, $session_code, true);
			if($user === null)
				return null;

			$user->SessionCode = $session_code;

			if ($timelife <= 0)
				$timelife = $this->config['session']['lifetime'];
			$timelife = intval($timelife);
			self::$cacher->Set('s_'.$session_code, $user_id.'|'.$timelife, $timelife);

			return $user;
		}

		return null;
	}

	/**
	 * Очистка кэша сессий
	 * @param int идентификатор пользователя
	 */
	static private function ClearSessionCache($user_id)
	{

	}

	public function ClearCache($cache, $params = array())
	{
		if(!self::$cacher)
			return;
		if(($cache & self::CH_ROLESFORGROUP) && is_numeric($params['groupid']))
		{
			self::$cacher->Remove('rolesforgroup_'.$params['groupid']);
		}
		if(($cache & self::CH_ROLESFORUSER || $cache & self::CH_ROLES) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('rolesforuser_'.$params['userid']);
		}
		if(($cache & self::CH_ROLESMODULES || $cache & self::CH_ROLES) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('rolesmodules_'.$params['userid']);
		}
		if(($cache & self::CH_ROLESGROUPS) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('rolesgroups_'.$params['userid']);
		}
		if(($cache & self::CH_USER) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('user_'.$params['userid']);
		}
		if(($cache & self::CH_USERMC) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('user_mc_'.$params['userid']);
		}
		if(($cache & self::CH_SLASTUPDATE) && is_numeric($params['userid']))
		{
			self::$cacher->Remove('slastupdate_'.$params['userid']);
		}
		if(($cache & self::CH_SESSION) && $params['session'])
		{
		}

		// исключение, нет нормального механизма чистить кэш профилей
		if(($cache & self::CH_PROFILEGENERAL) && is_numeric($params['userid']))
		{
			//if($_GET['debug']) echo 'up_general_'.$params['userid']."<br />";
			self::$cacher->Remove('up_general_'.$params['userid']);
		}

		// чистит все сессии нафик и в базе тоже
		if(($cache & self::CH_USERSESSION) && is_numeric($params['userid']))
		{

		}

	}

	// 2do: используется из p_general при сохранении... так неправильно. этот метод должен быть приватным!!!
	static public function ClearUserCache($user_id)
	{
		if(self::$cacher !== null)
			self::$cacher->Remove('user_'.$user_id);
	}

	private function GenerateSafeSessionCode()
	{
		return false;

	}

	private function GenerateSessionCode()
	{
		return PUtil::GenerateRandomString($this->config['session']['code_length']);
	}

	/**
	 * Получить информацию о пользователе по его идентификатору
	 * @param int user_id идентификатор пользователя
	 * @return User пользователь
	 */
	function GetUser($user_id, $with_roles = false, $with_profile = true)
	{
		return $this->GetUserInfo($user_id, null, $with_roles, $with_profile);
	}

	/**
	 * Получить данные о пользователе по EMail
	 * @param string почовый ящик
	 */
	function GetUserByEmail($email, $with_profile = true)
	{
		$user = self::GetUserInfoArrayByEmail($email);
		if($user !== null)
			return $this->GetUserInfo($user['UserID'], null, false, $with_profile);
		else
			return null;
	}

	private function GetUserInfo($user_id, $session_code = '', $with_roles = false, $with_profile = true)
	{
		if (!is_numeric($user_id) || $user_id < 0)
			return null;

		if(isset($this->users[$user_id]))
		{
			if ($with_roles === true && $this->users[$user_id]->Roles === null)
				$this->users[$user_id]->Roles = new PRolesMgr($this->users[$user_id], $this);

			if ($with_profile === true && $this->users[$user_id]->Profile === null)
				$this->users[$user_id]->Profile = new PProfileMgr($this->users[$user_id]);;

			return $this->users[$user_id];
		}


		if (self::$cacher !== null)
		{
			$user_info = self::$cacher->Get('user_'.$user_id);
		}
		else
			$user_info = false;

		if($user_info === false)
		{

			$sql = "SELECT * FROM ".self::$tables['users'];
			$sql.= " WHERE `UserID` = ".(int) $user_id;
			$res = PUsersMgr::$db->query($sql);

			if (!$res || !$res->num_rows)
				return null;

			$user_info = $res->fetch_assoc();
			if(self::$cacher !== null && $user_info !== null)
			{
				if( $user_id === 0 )
					self::$cacher->Set('user_'.$user_id, $user_info, 86400);
				else
					self::$cacher->Set('user_'.$user_id, $user_info, $this->config['session']['lifetime'] / 2);
			}
		}


		if($user_info !== null)
		{
			$this->users[$user_id] = new PUser();
			$this->users[$user_id]->SetUsersMgr($this);
			$this->users[$user_id]->ID 				= $user_id;
			$this->users[$user_id]->Email 			= strtolower($user_info['Email']);
			$this->users[$user_id]->OurEmail 		= strtolower($user_info['OurEmail']);
			$this->users[$user_id]->Visited 		= $user_info['Visited'];
			$this->users[$user_id]->Registered 		= $user_info['Registered'];
			$this->users[$user_id]->Question 		= $user_info['Question'];
			$this->users[$user_id]->Answer 			= $user_info['Answer'];
			$this->users[$user_id]->Blocked 		= $user_info['Blocked'];
			$this->users[$user_id]->IsDel 			= $user_info['IsDel'];
			$this->users[$user_id]->AutoLoginCross 	= $user_info['AutoLoginCross'];
			$this->users[$user_id]->RegionID 		= $user_info['RegionID'];
			$this->users[$user_id]->DomainName 		= $user_info['DomainName'];
			$this->users[$user_id]->Rating 			= $user_info['Rating'];
			$this->users[$user_id]->LatinName 		= $user_info['LatinName'];
			$this->users[$user_id]->SessionCode 	= $session_code;

			if($session_code != null)
				$this->users[$user_id]->Session = new PSessionMgr($this->users[$user_id], $this);

			// работа с профилем
			if($with_profile === true)
				$this->users[$user_id]->Profile = new PProfileMgr($this->users[$user_id]);

			// работа с ролями
			if($with_roles === true)
				$this->users[$user_id]->Roles = new PRolesMgr($this->users[$user_id], $this);

			// плагины
			$this->users[$user_id]->Plugins = new PPlugins($this->users[$user_id], $this);
		}
		else
			return null;

		return $this->users[$user_id];
	}

	/**
	 * Получить объект ролей для пользователя
	 * @param int идентификатор пользователя
	 * @param int идентификатор раздела
	 * @return Roles
	 */
	public function GetRolesForUser($id, $sectionid)
	{
		$user = new PUser();
		$user->ID = $id;
		$user->SectionID = $sectionid;
		return new PRolesMgr($user, $this);
	}

	/**
	 * Идентификатор пользователя по почтовому ящику
	 * @param string почтовый ящик
	 * @return int идентификатор
	 */
	static function GetUserInfoArrayByEmail($email)
	{
		if (empty($email))
			return null;

		$email = strtolower($email);
		if (($user_id = self::$cacher->Get('user_by_email_'.$email)) !== null)
			return self::GetUserInfoArray($user_id);


		$sql = "SELECT * FROM ".self::$tables['users'];
		$sql.= " WHERE `Email` = '".addslashes($email)."' OR `OurEmail` = '".addslashes($email)."' ";
		$res = PUsersMgr::$db->query($sql);

		if (!$res || !$res->num_rows)
			return null;

		$user_info = $res->fetch_assoc();
		if($user_info === null)
			return null;

		//До тех пор, пока в базе имя поля с большой буквой 'M'
		/*if (isset($user_info['EMail']))
			$user_info['Email'] = $user_info['EMail'];
		if (isset($user_info['OurEMail']))
			$user_info['OurEmail'] = $user_info['OurEMail'];*/

		$user['UserID']			= $user_info['UserID'];
		$user['Email']			= strtolower($user_info['Email']);
		//$user['EMail']			= strtolower($user_info['Email']);
		$user['OurEmail']		= strtolower($user_info['OurEmail']);
		//$user['OurEMail']		= strtolower($user_info['OurEmail']);
		$user['Visited']		= $user_info['Visited'];
		$user['Registered'] 	= $user_info['Registered'];
		$user['Question']		= $user_info['Question'];
		$user['Answer']			= $user_info['Answer'];
		$user['Blocked']		= $user_info['Blocked'];
		$user['IsDel']			= $user_info['IsDel'];
		$user['AutoLoginCross']	= $user_info['AutoLoginCross'];
		$user['RegionID'] 		= $user_info['RegionID'];
		$user['DomainName'] 	= $user_info['DomainName'];
		$user['Rating'] 		= $user_info['Rating'];
		$user['LatinName'] 		= $user_info['LatinName'];

		return $user;
	}

	/**
	 * Получить информацию о пользователе в массиве
	 * @param int идентификатор пользователя
	 * @return array информация о пользователе
	 */
	public static function GetUserInfoArray($user_id)
	{
		$sql = "SELECT * FROM ".self::$tables['users'];
		$sql.= " WHERE `UserID` = ".(int) $user_id;
		$res = PUsersMgr::$db->query($sql);

		if (!$res || !$res->num_rows)
			return null;

		$user_info = $res->fetch_assoc();
		if($user_info === null)
			return null;

		$user = array();
		$user['UserID']			= $user_id;
		$user['Email']			= strtolower($user_info['Email']);
		$user['OurEmail']		= strtolower($user_info['OurEmail']);
		$user['Visited']		= $user_info['Visited'];
		$user['Registered'] 	= $user_info['Registered'];
		$user['Question']		= $user_info['Question'];
		$user['Answer']			= $user_info['Answer'];
		$user['Blocked']		= $user_info['Blocked'];
		$user['IsDel']			= $user_info['IsDel'];
		$user['AutoLoginCross']	= $user_info['AutoLoginCross'];
		$user['RegionID'] 		= $user_info['RegionID'];
		$user['DomainName'] 	= $user_info['DomainName'];
		$user['Rating'] 		= $user_info['Rating'];
		$user['LatinName'] 		= $user_info['LatinName'];

		return $user;
	}

	/**
	 * получить кол-во пользователей по условию
	 * @param array фильтра
	 * @return int кол-во пользователей
	 */
	function GetUsersCount($filter)
	{
		$users = array();
		if(!isset($filter['id']) || !is_numeric($filter['id']))
			$filter['id'] = -1;

		if($filter['id'] == -1)
			$byuser = 0;
		else
			$byuser = 1;

		if(!isset($filter['group']))
			$filter['group'] = 0;

		if(!isset($filter['visited']))
			$filter['visited'] = 0;

		if(!isset($filter['isbirthdaytoday']))
			$filter['isbirthdaytoday'] = -1;

		// по умолчанию не берем удаленных (0-неудаленные;1-удаленные;-1-без разницы)
		if(!isset($filter['isdel']))
			$filter['isdel'] = 0;

		if(!isset($filter['regid']) || !is_numeric($filter['regid']))
			$filter['regid'] = 0;

		if ($filter['group'] == 0) {
			$sql = "SELECT count(*) as cnt FROM ".self::$tables['users']." as u ";
			$sql.= " WHERE true ";
		} else {
			$sql = "SELECT count(*) as cnt FROM ".self::$tables['groups_ref']." as gr ";
			$sql.= " LEFT JOIN ".self::$tables['users']." AS u ON u.UserID = gr.UserID ";
			$sql.= " WHERE gr.GroupID = ".$filter['group'];
		}

		if ($filter['isdel'] != -1)
			$sql.= " AND u.IsDel = ".(int) $filter['isdel'];

		if ($byuser)
			$sql.= " AND u.UserID = ".(int) $filter['id'];

		if ($filter['regid'] > 0)
			$sql.= " AND u.RegionID = ".(int) $filter['regid'];

		if (strlen($filter['email']) > 0)
			$sql.= " AND u.Email LIKE '".addslashes($filter['email'])."'";

		if (strlen($filter['ouremail']) > 0)
			$sql.= " AND u.OurEmail LIKE '".addslashes($filter['ouremail'])."'";

		if (strlen($filter['nickname']) > 0)
			$sql.= " AND u.NickName LIKE '".addslashes($filter['nickname'])."'";

		if ($filter['visited'] > 0)
			$sql.= " AND u.`Visited` >= DATE_SUB(NOW(), INTERVAL ".(int) $filter['visited']." MINUTE)";

		if ($filter['isbirthdaytoday'] != -1)
			$sql.= " AND u.`IsBirthDayToday` = ".(int) $filter['isbirthdaytoday'];

		if (strlen($filter['registeredfrom']) && strlen($filter['registeredto']))
			$sql.= " AND u.`Registered` BETWEEN '".addslashes($filter['registeredfrom'])."' AND '".addslashes($filter['registeredto'])."' ";

		$res = PUsersMgr::$db->query($sql);
		if (!$res || !$res->num_rows)
			return 0;

		list($count) = $res->fetch_row();
		return $count;
	}

	/**
	 * Получить список пользователей
	 *
	 * @param array фильтр
	 * @return array массив пользователей (id)
	 */
	function GetUsers($filter)
	{
		$users = array();
		if(!isset($filter['id']) || !is_numeric($filter['id']))
			$filter['id'] = -1;

		if($filter['id'] == -1)
			$byuser = 0;
		else
			$byuser = 1;

		if(!isset($filter['group']))
			$filter['group'] = 0;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if(!isset($filter['regid']) || !is_numeric($filter['regid']))
			$filter['regid'] = 0;

		if(!isset($filter['visited']))
			$filter['visited'] = 0;

		if(!isset($filter['isbirthdaytoday']))
			$filter['isbirthdaytoday'] = -1;

		// по умолчанию не берем удаленных (0-неудаленные;1-удаленные;-1-без разницы)
		if(!isset($filter['isdel']))
			$filter['isdel'] = 0;

		if($filter['field'] != 'UserID' && $filter['field'] != 'Email' && $filter['field'] != 'Registered'
				&& $filter['field'] != 'Visited' && $filter['field'] != 'Question' && $filter['field'] != 'Answer'
				&& $filter['field'] != 'Blocked' && $filter['field'] != 'OurEmail' && $filter['field'] != 'NickName'
				&& $filter['field'] != 'Rating'  && $filter['field']  != 'IsDel'   && $filter['field'] != 'RAND'
				&& $filter['field'] != 'RegionID' )
			$filter['field'] = 'Email';

		if( $filter['field'] == 'RAND' )
		{
			$filter['field'] = 'RAND()';
			$filter['dir'] = '';
		}
		else
		{
			$filter['dir'] = strtoupper($filter['dir']);
			if($filter['dir'] != 'ASC' && $filter['dir'] != 'DESC')
				$filter['dir'] = 'ASC';
		}

		if ($filter['group'] == 0) {
			$sql = "SELECT u.UserID FROM ".self::$tables['users']." as u ";
			$sql.= " WHERE true ";
		} else {
			$sql = "SELECT u.UserID FROM ".self::$tables['groups_ref']." as gr ";
			$sql.= " LEFT JOIN ".self::$tables['users']." AS u ON u.UserID = gr.UserID ";
			$sql.= " WHERE gr.GroupID = ".$filter['group'];
		}

		if ($filter['isdel'] != -1)
			$sql.= " AND u.IsDel = ".(int) $filter['isdel'];

		if ($byuser)
			$sql.= " AND u.UserID = ".(int) $filter['id'];

		if ($filter['regid'] > 0)
			$sql.= " AND u.RegionID = ".(int) $filter['regid'];

		if (strlen($filter['email']) > 0)
			$sql.= " AND u.Email LIKE '".addslashes($filter['email'])."'";

		if (strlen($filter['ouremail']) > 0)
			$sql.= " AND u.OurEmail LIKE '".addslashes($filter['ouremail'])."'";

		if (strlen($filter['nickname']) > 0)
			$sql.= " AND u.NickName LIKE '".addslashes($filter['nickname'])."'";

		if ($filter['visited'] > 0)
			$sql.= " AND u.`Visited` >= DATE_SUB(NOW(), INTERVAL ".(int) $filter['visited']." MINUTE)";

		if ($filter['isbirthdaytoday'] != -1)
			$sql.= " AND u.`IsBirthDayToday` = ".(int) $filter['isbirthdaytoday'];

		if (strlen($filter['registeredfrom']) && strlen($filter['registeredto']))
			$sql.= " AND u.`Registered` BETWEEN '".addslashes($filter['registeredfrom'])."' AND '".addslashes($filter['registeredto'])."' ";

		if ($filter['dir'])
			$sql.= " ORDER BY ".$filter['field']." ".$filter['dir'];
		else
			$sql.= " ORDER BY ".$filter['field'];

		if ($filter['limit']) {
			if ($filter['offset'])
				$sql.= " LIMIT ".$filter['offset'].", ".$filter['limit'];
			else
				$sql.= " LIMIT ".$filter['limit'];
		}

		$res = PUsersMgr::$db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		while(false != ($row = $res->fetch_row())) {
			$users[] = array('id' => $row[0]);
		}

		return $users;
	}

	/**
	 * Получить список пользователей
	 * @param array фильтр
	 * @return array массив пользователей (id)
	 */
	function GetRandUsers($filter)
	{
		$users = array();

		if(!isset($filter['regid']) || !is_numeric($filter['regid']))
			$filter['regid'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		// по умолчанию не берем удаленных (0-неудаленные;1-удаленные;-1-без разницы)
		if(!isset($filter['isdel']))
			$filter['isdel'] = 0;

		$sql = "SELECT UserID FROM ".self::$tables['users'];
		$sql.= " WHERE RegionID = ".$filter['regid'];

		if ($filter['isdel'] != -1)
			$sql.= " AND `IsDel` = ".(int) $filter['isdel'];

		$sql.= " ORDER BY RAND() ";

		if ($filter['limit'])
			$sql.= " LIMIT ".$filter['limit'];

		$res = PUsersMgr::$db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		while(false != ($row = $res->fetch_row())) {
			$users[] = array('id' => $row[0]);
		}

		return $users;
	}

	public static function GenerateNames($name) {

		if (empty($name))
			return array();

		$name = preg_replace(array("@[^\w]+@", "@\_+@"), array("", ""),
			strtolower($name));

		$examples = $new = array();

		list($host,) = explode('.',$_SERVER['HTTP_HOST'],2);
		$host = ucfirst($host);

		$new[] = ucfirst($name).date('Y');
		$new[] = substr($host,0,1).ucfirst($name);
		$new[] = ucfirst($name).$host;

		$new = array_unique($new);

		foreach($new as $n) {
			if (!PUsersMgr::IsNameExists($n, '', ''))
				$examples[] = array('username'=>$n);
		}

		return $examples;
	}

	/*
	* Активация пользователя
	*/
	function AddActivationCode($user_id, $email, $action)
	{
		if ($user_id !== null)
		{
			$sql = "SELECT * FROM ".self::$tables['email_activation'];
			$sql.= " WHERE `UserID` = ".(int) $user_id;
			$sql.= " LIMIT 1 ";
			if (false == ($res = PUsersMgr::$db->query($sql)) || $res->num_rows)
				return null;

			LibFactory::GetStatic('data');
			do
			{
				$code = Data::GetRandStr();

				$sql = "SELECT * FROM ".self::$tables['email_activation'];
				$sql.= " WHERE `Code` = '".addslashes($code)."'";
				$sql.= " LIMIT 1 ";

				if (false == ($res = PUsersMgr::$db->query($sql)))
					return null;

				if ($res->num_rows)
					continue ;

				$sql = "INSERT INTO ".self::$tables['email_activation'];
                $sql.= " SET `UserID` = ".(int) $user_id;
				$sql.= " ,`Email` = '".addslashes($email)."'";
				$sql.= " ,`Code` = '".addslashes($code)."'";
				$sql.= " ,`Action` = ".(int) $action;
				$sql.= " ,`Date` = NOW() ";

				if (false == ($res = PUsersMgr::$db->query($sql)))
					return null;

				break ;
			}
			while (true);

			return $code;
		}
		return null;
	}

	function Activate($code)
	{
		$sql = "SELECT UserID, Email FROM ".self::$tables['email_activation'];
		$sql.= " WHERE Code = '".addslashes($code)."'";

		$res = PUsersMgr::$db->query($sql);
		if (!$res || !$res->num_rows)
			return 0;

		list($UserID, $Email) = $res->fetch_row();

		$sql = "UPDATE ".self::$tables['users']." SET Email = '".addslashes($Email)."'";
		$sql.= " WHERE UserID = ".$UserID;
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".self::$tables['email_activation'];
		$sql.= " WHERE Code = '".addslashes($code)."'";
		PUsersMgr::$db->query($sql);

		PUsersMgr::ClearCache(PUsersMgr::CH_USER, array('userid' => $UserID));
		return $UserID;
	}

	function CheckActivation($UserID, $action)
	{
		$sql = "SELECT Email FROM ".self::$tables['email_activation'];
		$sql.= " WHERE UserID = ".(int) $UserID;
		$sql.= " AND Action = ".(int) $action;

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		list($email) = $res->fetch_row();
		return $email;
	}
	function ActivationCodeRemember($UserID, $action)
	{
		$sql = "SELECT Code FROM ".self::$tables['email_activation'];
		$sql.= " WHERE UserID = ".(int) $UserID;
		$sql.= " AND Action = ".(int) $action;

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		list($code) = $res->fetch_row();
		return $code;
	}
	function ClearOldActivationCode()
	{
		$sql = "DELETE u, a FROM ".self::$tables['users']." as u ";
		$sql.= " ".self::$tables['email_activation']." as a ";
		$sql.= " WHERE u.`UserID` = a.`UserID`";
		$sql.= " AND a.`Action` = 1";
		$sql.= " AND a.`Date` <= DATE_SUB(NOW(), INTERVAL 2 DAY)";
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".self::$tables['email_activation'];
		$sql.= " WHERE `Action` = 2";
		$sql.= " AND `Date` <= DATE_SUB(NOW(), INTERVAL 2 DAY)";
		PUsersMgr::$db->query($sql);
	}

	/**
	 * Редирект на страницу авторизации
	 */
	function RedirectToLogin()
	{
		header('Location: /account/login.php?url='.urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	/**
	 * Возвращает урл для логина
	 */
	function UrlToLogin()
	{
		return 'Location: /account/login.php?url='.urlencode($_SERVER['REQUEST_URI']);
	}

	/**
	 * Помещает объект пользователя в очередь на модерацию
	 * @param  int  user_id идентификатор пользователя
	 **/
	public static function PutToModerate($user_id)
	{
		if ( $user_id <= 0 )
			return null;

		$sql = "REPLACE INTO ".self::$tables['object_changements'];
		$sql.= " SET `ObjectType` = 1 ";
		$sql.= " ,`ObjectID` = ".(int) $user_id;
		$sql.= " ,`DateDelayed` = NOW()";
		$sql.= " ,`Date` = NOW()";
		$sql.= " ,`ToModerate` = 1";

		return PUsersMgr::$db->query($sql);
	}

	/**
	 * Получение списка полей, не прошедших модерацию
	 * @param int user_id идентификатор пользователя
	 * @return array
	**/
	public static function GetBadFieldsForUser($user_id)
	{
		if ( $user_id <= 0 )
			return false;

		$sql = "SELECT * FROM ".self::$tables['object_changements'];
		$sql.= " WHERE `ObjectType` = 1 ";
		$sql.= " AND `ObjectID` = ".(int) $user_id;

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		$result = $res->fetch_assoc();
		if ( is_array($result) && isset( $result['BadFields'] ) )
			$result = explode(',',$result['BadFields']);
		else
			$result = array();

		return $result;
	}

	/**
	 * Проверка валидности строки (ФИО) a-zA-zА-Я0-9-_
	 * @param string строка
	 * @param bool валидный?
	 */
	static function IsStringValid($string)
	{
		if( !preg_match("@[^A-Za-zА-Яа-ячёЁ\d_\- ]@", $string) )
			return true;

		return false;
	}
}
?>
