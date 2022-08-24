<?php

/**
 * Информация о пользователе, работа с ролями
 * @version 1.0
 * @updated 27-июл-2007 9:17:00
 */
class PUser implements IDisposable
{
	public $ID			= 0;			// Идентификатор
	public $Email		= '';			// Почтовый ящик (логин)
	//public $NickName	= '';			// Отображаемое
	public $Password	= '';			// Только для записи, используется только для изменения пароля.
	public $OurEmail	= '';			// Почтовый ящик (наш, если указан, то работа будет с ним)

	// Группы в которых состоит пользователь, нужны только для информации и изменения
	// набора групп пользователя.
	public $Groups		= array();
	public $Profile		= null;			// Профиль пользователя
	public $Session		= null;			// Сессия пользователя (даже для гостя)
	public $Plugins		= null;			// Плагины пользователя
	public $Visited		= '';			// дата последнего посещения
	public $Registered	= '';			// Дата регистрации, даты посещение хранятся в лог файле
	public $Roles		= null;			// Роли пользователя
	public $SessionCode	= '';			// Имя текущей сессии пользователя.
	public $SectionID	= 0;			// Текущий раздел (используется при работе с ролями и профилями)
	public $ModuleName	= '';			// Используется при работе с провайдерами ролей и профилей
	public $Question	= '';			// Секретный вопрос
	public $Answer		= '';			// Ответ на вопрос
	public $Blocked		= 0;			// заблокирован
	public $IsDel		= 0;			// удален
	public $RegionID	= 0;			// регион последнего входа пользователя
	public $DomainName	= '';			// домен последнего входа
	public $Rating		= '';			// рейтинг пользователя по заполненности инфы
	public $LatinName	= '';			// комбинация фамилии имени и отчества

	private $UsersMgr	= null;

	const SESSION_VIEW_SIMPLE = 1;
	const SESSION_VIEW_GET = 2;


	function __construct()
	{
	}

	function Dispose()
	{
		if($this->Profile !== null)
			$this->Profile->Dispose();
		if($this->Roles !== null)
			$this->Roles->Dispose();
		if($this->Session !== null)
			$this->Session->Dispose();
		//if($this->Plugins !== null)
		//	$this->Plugins->Dispose();
	}
	public function AllDestroy() {

  }
	public function Logout()
	{
		if($this->UsersMgr !== null)
			$this->UsersMgr->Logout();
	}
	public function LogoutAll($usersObjects)
	{
		foreach($usersObjects as $userObject) {
			if($userObject->UsersMgr !== null)
			   $userObject->UsersMgr->LogoutAll($userObject);
		}

	}
	public function Update()
	{
		if($this->ID != 0)
		{
			$user = array(
					'ID' => $this->ID,
					'Email' => $this->Email,
					'OurEmail' => $this->OurEmail,
					//'NickName' => $this->NickName,
					//'NickNameLatin' => PUtil::NickName2Latin($this->NickName),
					'Question' => $this->Question,
					'Answer' => $this->Answer,
					'IsDel' => $this->IsDel,
					'Blocked' => $this->Blocked);

			if(!empty($this->Password))
				$user['Password'] = $this->Password;

			PUsersMgr::UpdateByID($user);
		}
	}

	function SetUsersMgr($mgr)
	{
		$this->UsersMgr = $mgr;
	}

	function GetUsersMgr()
	{
		return $this->UsersMgr;
	}

	/**
	 * проверка авторизованности пользователя
	 */
	function IsAuth()
	{

		$con = mysqli_connect("localhost",'ipkhratd_tech', 'mTpoofdA', 'ipkhratd_tech');
		$query = "SELECT email FROM logoutall WHERE email = '".$this->Email."'";
		$getLogout = mysqli_query($con, $query);
		$result = mysqli_fetch_array($getLogout);
		$relog = true;
		if($result) {
			$relog = false;
		}

		if(!empty($this->SessionCode) && $this->ID > 0)
			return $relog;
		else
			return false;
	}

	/**
	 * гость?
	 */
	function IsGuest()
	{
		if($this->ID === 0)
			return true;
		else
			return false;
	}

	/**
	 *
	 * @param roleName    имя роли для проверки
	 */
	function IsInRole($roleName, $addKey = null)
	{
		if($this->Roles !== null)
			return $this->Roles->IsInRole($roleName, $addKey);
		return false;
	}

	/**
	 *
	 * @param groupName    проверка принадлежности группе
	 */
	function IsInGroup($groupName)
	{
		return in_array($groupName, $this->Groups);
	}

	/**
	 * возвращает код сессии в разном виде в зависимости от $view
	 * @param view    вид отдачи
	 */
	function GetSessionCode($view = self::SESSION_VIEW_SIMPLE)
	{
		if($view === self::SESSION_VIEW_GET)
			return 'SID='.$this->SessionCode;
		else
			return $this->SessionCode;
	}

	function __get($name)
	{
		if(strtolower($name) === 'nickname')
		{
			if($this->Profile !== null)
				return $this->Profile['general']['ShowName'];
		}
		elseif(strtolower($name) === 'usersmgr')
		{
			return $this->UsersMgr;
		}
	}
}
?>
