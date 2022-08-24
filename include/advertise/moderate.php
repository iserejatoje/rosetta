<?
/**
	Реализует механизм публичной модерации объявлений
	@author: Хусаинов Фарид
	@date: 10:34 10.02.2010
*/

class Moderate
{
	const MOD_STATUS_OK 		= 0;
	const MOD_STATUS_CAPTCHA 	= 1;
	const MOD_STATUS_COUNT 		= 2;
	const MOD_STATUS_REASON 	= 3;
	
	/**
		Получение количества предупреждений на объявление
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@result int - кол-во предупреждений
	*/
	public static function GetWarningCount($obj, $AdvID)
	{
		global $OBJECTS;
		
		$sql = "SELECT count(*) FROM `". $obj->sheme['tables']['prefix'] ."_warnings`";
		$sql.= " WHERE `UserID` = ". ( $OBJECTS['user']->IsAuth() ? $OBJECTS['user']->ID : 0 );
		$sql.= " AND `Path` = '". addslashes($obj->path) ."'";
		$sql.= " AND `AdvID` = ". $AdvID;
		$res = $obj->db->query($sql);
		if ( $res === false )
			return false;
		
		list($count) = $res->fetch_row();
		
		return $count;
	}
	
	
	/**
		Получение предупреждений на объявление
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@result int - кол-во предупреждений
	*/
	public static function GetAllWarnings($obj, $AdvID, $Active = false)
	{
		global $OBJECTS;
		
		if ( !is_numeric($AdvID) || intval($AdvID) <= 0 )
			return false;
		
		$sql = "SELECT * FROM `". $obj->sheme['tables']['prefix'] ."_warnings`";
		$sql.= " WHERE `Path` = '". addslashes($obj->path) ."'";
		$sql.= " AND `AdvID` = ". $AdvID;
		if ( $Active === true )
			$sql.= " AND `Active` = 1";
		$res = $obj->db->query($sql);
		
		if ( $res === false )
			return false;
		
		$list = array();
		while ( $row = $res->fetch_assoc() )
			$list[] = $row;
		
		return $list;
	}
	
	
	/**
		Проверяет, проходило ли объявление повторную модерацию
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@result bool
	*/
	public static function IsRemoderate($obj, $AdvID)
	{
		$adv = $obj->GetAdv($AdvID);
		return $adv['Remoderate'] ? true : false;
	}
	
	
	/**
		Добавляет предупреждение к объявлению
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@param int $Reason - код причины
		@param string $Comment - комментарий пользователя
	*/
	public static function AddWarning($obj, $AdvID, $Reason, $Comment = '')
	{
		global $OBJECTS;
		
		$sql = "INSERT INTO `". $obj->sheme['tables']['prefix'] ."_warnings` SET ";
		$sql.= " `Path` = '". addslashes($obj->path) ."',";	
		$sql.= " `AdvID` = ". $AdvID .",";	
		$sql.= " `Comment` = '". addslashes($Comment) ."',";
		$sql.= " `UserID` = '". ($OBJECTS['user']->IsAuth() ? $OBJECTS['user']->ID : 0) ."', ";
		$sql.= " `Reason` = ". $Reason .", ";
		$sql.= " `Date` = NOW(),";
		$sql.= " `Active` = 0";
		
		$obj->db->query($sql);
	}
	
	
	/**
		Получение количества различных пользователей, отправивших предупреждение на заданное объявление
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@result int - кол-во пользователей
	*/
	public static function GetDiffUsersCountByAdv($obj, $AdvID)
	{
		$sql = "SELECT count(*) as cnt FROM ";
		$sql.= "(SELECT DISTINCT `UserID` FROM `". $obj->sheme['tables']['prefix'] ."_warnings`";
		$sql.= " WHERE `Path` = '". addslashes($obj->path) ."'";
		$sql.= " AND `AdvID` = ". $AdvID;
		$sql.= " ) a";
		$res = $obj->db->query($sql);
		
		if ( $res === false )
			return false;
		
		list($cnt) = $res->fetch_row();
		
		return $cnt;
	}
	
	
	/**
		Устанавливает статус модерации объявления
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@param int $IsNew - статус
	*/
	public static function SetModerated($obj, $AdvID, $IsNew = 2)
	{
		// установить IsNew у объявления
		$sql = "UPDATE `". $obj->sheme['tables']['prefix'] . $obj->sheme['tables']['master']  ."` SET";
		$sql.= " `IsNew` = ". $IsNew;
		$sql.= " WHERE `AdvID` = ". $AdvID;
		$obj->db->query($sql);
		
		// активируем предупреждение
		$sql = "UPDATE `". $obj->sheme['tables']['prefix'] ."_warnings` SET";
		$sql.= " `Active` = 1";			
		$sql.= " WHERE `Path` = '". addslashes($obj->path) ."'";
		$sql.= " AND `AdvID` = ". $AdvID;
		$obj->db->query($sql);
	}
	
	
	/**
		Обрабатывает запрос пользователя на добавление предупреждения
		@param object $obj - схема данных
		@param int $AdvID - идентификатор объявления
		@param int $Reason - идентификатор причины жалобы
		@param string $Comment - примечание пользователя
		@param bool $Commercial - является ли владелец объявления коммерческим клиентом (объявление отправится на постмодерацию)
		@param int $count_user_incorrect - кол-во жалоб, которое может отправить пользователь на одно объявление
		@param int $count_different_incorrect - кол-во разных польтзовыателей, отправивших жалобу, необходимое для отправки объявления на пред/пост-модерацию
		@result array - результат действия
	*/
	public static function ProcessRequest($obj, $AdvID, $Reason, $Comment = '', $Commercial = false, $count_user_incorrect = 2, $count_different_incorrect = 2 )
	{
		global $OBJECTS;
		
		if ( !$OBJECTS['user']->IsAuth() )
		{	
			$captcha = LibFactory::GetInstance('captcha');
			if ( !$captcha->is_valid(App::$Request->Post['captcha_code']->Value()) )
			{
				return array(
							'status' => self::MOD_STATUS_CAPTCHA, 
							'error' => "Неверно указан код защиты от роботов!",
						);
			}
		}
		else
			$count_user_incorrect = 1;
		
		if ( $Reason === false )
		{
			return array(
						'status' => self::MOD_STATUS_REASON, 
						'error' => 'Извините, Ваше замечание не принято. Скорее всего не указана причина',
					);
		}
		
		// если объявление уже проходило повторную модерацию, то не добавляем в базу данные о некорректности объявления
		if ( self::IsRemoderate($obj, $AdvID) )
		{
			return array(
						'status' => self::MOD_STATUS_COUNT, 
						'error' => 'Извините, Ваше замечение не принято. Это объявление уже перепроверено модератором.',
					);
		}
		
		// проверка сколько один пользователь может объявлять некорректными одно объявление (в том числе неавторизованные)
		$count = self::GetWarningCount($obj, $AdvID);
		if ( $count === false || $count >= $count_user_incorrect) 
		{
			LibFactory::GetStatic('ustring');
			return array(
					'status' => self::MOD_STATUS_COUNT, 
					'error' => 'Извините, Ваше замечение не принято. Возможно оставлять '. $count_user_incorrect.' '.UString::word4number($count_user_incorrect,'замечание', 'замечания', 'замечаний'). ' на одно объявление.',
				);
		}
		
		self::AddWarning($obj, $AdvID, $Reason, $Comment);
		
		// если более чем это число раз РАЗНЫЕ пользователи посчитали объявление некорректным,
		// то скрываем объявление и отсылаем на (пред/пост)модерацию
		if ( self::GetDiffUsersCountByAdv($obj, $AdvID) >= $count_different_incorrect) 
		{
			// 1 - постмодерация
			// 2 - предмодерация
			self::SetModerated($obj, $AdvID, ($Commercial ? '1' : '2'));
		}
		
		return array(
					'status' => self::MOD_STATUS_OK, 
					'success' => 'Ваше замечание успешно отправлено. Благодарим Вас за использование нашего сервиса.',
				);
	}
	
	
	/**
		Добавляет действие модератора
		@param object $obj - схема данных
		@param int $AdvID - id объявления
		@param int $IsNew - статус
	*/
	public static function AddModeratorAction($obj, $AdvID, $ModeratorAction)
	{
		$sql = "UPDATE `". $obj->sheme['tables']['prefix'] ."_warnings` SET";
		$sql.= " `Active` = 0, ";
		$sql.= " `ModeratorAction` = ". intval($ModeratorAction);			
		$sql.= " WHERE `Path` = '". addslashes($obj->path) ."'";
		$sql.= " AND `AdvID` = ". $AdvID;
		$obj->db->query($sql);
	}
}

?>
