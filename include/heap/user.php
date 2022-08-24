<?

/**
 * Очередь пользователя
 * @author farid
 * @created 23-ноя-2010 11:37:53
 */
class HeapQueue_user extends HeapQueue
{
	public $UserID;								// Идентификатор очереди
	public static $Table = 'queue_users';		// Таблица очереди

	/**
	 * Получение заголовка очереди
	 *
	 * @return string
	 */
	function Title()
	{
		LibFactory::GetStatic('gpassport');
		$user = PUsersMgr::getInstance()->GetUser($this->UserID);
		if ( $user === null )
			throw new RuntimeMyException("Users queue owner not found");
		
		return "Пользователи:". $user->NickName;
	}

}
?>