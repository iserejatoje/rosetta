<?
class PPhonesPassportPlugin extends PABasePassportPlugin 
{	
	private $current_phone = null;
	
	public function __construct($user, $mgr) 
	{
		parent::__construct($user, $mgr, 'Phones');
	}
	
	/**
	 * Генерирует код. 
	 * Кеширует в редисе по user_id на 10 минут
	 *
	 * @param string $phone 11-ти значный номер телефона
	 * @return bool
	 */
	public function GenerateCode($phone)
	{		
		if ( $this->user->IsAuth() === false )
			return false;
		
		if ( !Data::Is_Phone($phone) )
			return false;
				
		$cacheid = "plugins_phones_code_".$this->user->ID;		
		$data = PUsersMgr::$redis->Get($cacheid);
		if ($data === null)
		{
			$data = array(
				'phone' => $phone,
				'code' => rand(1000000, 9999999),
			);
			
			PUsersMgr::$redis->Set($cacheid, serialize($data), 600);
		}
		else
		{
			$data = unserialize($data);
			
			//Если номер телефона изменился, то перегенерим код
			if ($data['phone'] != $phone)
				$data['code'] = rand(1000000, 9999999);
			$data['phone'] = $phone;
			PUsersMgr::$redis->Set($cacheid, serialize($data), 600);
		}
		return $data['code'];
	}
	
	/**
	 * Регистрировались ли на этот номер.
	 * Кеширует на сутки в редисе 
	 * 
	 * @param string $phone 11-ти значный номер телефона
	 * @return bool
	 */
	public function IsExists($phone)
	{
		$is_exist = true;
		
		LibFactory::GetStatic("data");
		
		if ( !Data::Is_Phone($phone) )
			return $is_exist;
		
		$cacheid = "plugins_phones_exists_".$phone;
		
		$data = PUsersMgr::$redis->Get($cacheid);
		if ($data !== null)
			return (bool) $data;
			
		$sql = "SELECT count(0) FROM ".PUsersMgr::$tables['phones'];
		$sql.= " WHERE Phone='".addslashes($phone)."'";
		
		$res = PUsersMgr::$db->query($sql);
		if ($res === false)
			return $is_exist;
		
		$row = $res->fetch_row();
		
		$is_exist = (int) (intval($row[0]) > 0);
		
		PUsersMgr::$redis->Set($cacheid, $is_exist, 86400);
		return (bool) $is_exist;
	}
	
	/**
	 * Проверка совпадения кодов из редиса и от пользователя
	 * 
	 * @param string $code 7-ми значный код, введённый пользоателем
	 * @return bool|string номер телефона если коды равны, иначе false
	 */
	public function CheckCode($code)
	{
		if ( $this->user->IsAuth() === false )
			return false;
			
		if (!preg_match("/^[\d]{7}$/i", $code))
			return false;
			
		$cacheid = "plugins_phones_code_".$this->user->ID;
				
		$data = PUsersMgr::$redis->Get($cacheid);
		if ($data === null)
			return false;
		$data = unserialize($data);
		
		if ($code != $data['code'])
			return false;
		
		//Уже подтверждён
		if ($this->IsExists($data['phone']) === true)
			return false;
				

		return $data['phone'];
	}
	
	/**
	 * Регистрирует номер телефона
	 * Вызывать только когда номер телефона валидный и код подтверждения проверен
	 * 
	 * @param string $phone 11-ти значный номер телефона
	 * @return bool
	 */
	public function Register($phone)
	{
		//Уже подтверждён
		if ($this->IsExists($phone) === true)
			return false;
		
		$current_phone = $this->GetPhone();
		if ($current_phone != "" && $current_phone == $phone)
			return false;
		
		$this->RegisterInCache($phone);
		
		$this->current_phone = $phone;
		
		EventMgr::Raise('passport/plugins/phones/register', array(
				'userid' => $this->user->ID,
				'phone' => $phone,
			));
		
		App::$Log->Log(893, $this->user->ID, array(
				'phone' => $phone,
				'old_phone' => $current_phone,
			));
		
		return true;
	}
	
	/**
	 * Обновление кеша зарегистрированного номера телефона 
	 * 
	 * @param string $phone 11-ти значный номер телефона
	 */
	protected function RegisterInCache($phone)
	{
		$current_phone = $this->GetPhone();
		if ($current_phone != "" && $current_phone != $phone)
		{
			PUsersMgr::$redis->Set("plugins_phones_exists_".$current_phone, 0, 86400);
		}
		
		PUsersMgr::$redis->Set("plugins_phones_exists_".$phone, 1, 86400);
		PUsersMgr::$redis->Set("plugins_phones_phone_".$this->user->ID, $phone, 86400);
		PUsersMgr::$redis->Del("plugins_phones_code_".$this->user->ID);
	}
	
	/**
	 * Вставка в базу подтверждённого номера телефона
	 * 
	 * @param string $phone 11-ти значный номер телефона
	 * @return bool
	 */
	public function RegisterInStorage($phone)
	{
		$sql = "REPLACE ".PUsersMgr::$tables['phones']." SET";
		$sql.= " UserID=".$this->user->ID;
		$sql.= ", Phone='".addslashes($phone)."'";		
		$res = PUsersMgr::$db->query($sql);		
		return $res !== false;
	}
	
	/**
	 * Получить подтверждённый номер телефона пользователя
	 *
	 * @param int $user_id идентификатор пользователя
	 * @return string номер телефона, иначе false
	 */
	public function GetPhone()
	{	
		if ($this->current_phone !== null)
			return $this->current_phone;
		
		$cacheid = "plugins_phones_phone_".$this->user->ID;		
		$data = PUsersMgr::$redis->Get($cacheid);
		if ($data === null)
		{	
			$data = "";
			
			$sql = "SELECT Phone FROM ".PUsersMgr::$tables['phones'];
			$sql.= " WHERE UserID=".$this->user->ID;
			
			$res = PUsersMgr::$db->query($sql);
			if ($res !== false)
			{
				$row = $res->fetch_assoc();		
				$data = isset($row['Phone']) ? $row['Phone'] : "";
			}
			
			PUsersMgr::$redis->Set($cacheid, $data, 0);
		}
		
		//Сохраняем в локальный кеш
		$this->current_phone = $data;
		return $data;
	}
	
	/**
	 * Удалить регистрацию телефона у текущего пользователя
	 *
	 * @return bool
	 */
	public function Remove()
	{		
		$phone = $this->GetPhone();
		if ($phone == "")
			return false;
		$this->current_phone = "";
		
		$this->RemoveInCache($phone);
		
		EventMgr::Raise('passport/plugins/phones/delete', array(
				'userid' => $this->user->ID,
				'phone' => $phone,
			));
		
		
		App::$Log->Log(894, $this->user->ID, array(
				'phone' => $phone,
			));
		
		return true;
	}
	
	/**
	 * Удаление из базы номера телефона
	 * 
	 * @return bool
	 */
	public function RemoveInStorage()
	{
		$sql = "DELETE FROM ".PUsersMgr::$tables['phones'];
		$sql.= " WHERE UserID=".$this->user->ID;		
		$res = PUsersMgr::$db->query($sql);
		return $res !== false;
	}
	
	/**
	 * Чистка кеша после удаления номера телефона
	 * 
	 * @param string $phone 11-ти значный номер телефона
	 */
	public function RemoveInCache($phone)
	{	
		PUsersMgr::$redis->Set("plugins_phones_exists_".$phone, 0, 86400);
		PUsersMgr::$redis->Set("plugins_phones_phone_".$this->user->ID, "", 86400);
	}
	
	/**
	 * Получить URL для активации номера телефона
	 * 
	 * @param string $url URL куда редиректить после успешной активации
	 * @return string
	 */
	public function UrlToActivatePhone($url = "")
	{
		$url = "/passport/confirm_mobile.php";
		if ($url != "")
			$url.= "?url=".urlencode($url);
		return $url;
	}
}	