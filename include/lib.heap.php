<?

/**
 * Менеджер объектов хипа и очередей
 * @author farid
 * @created 23-ноя-2010 11:37:53
 */
class Heap
{
	const DB_NAME = 'r0_heap';
	
	public static $db = null;
	
	/**
	 * Получение объекта очереди сервиса
	 * 
	 * @param string QueueID    Идентификатор очереди
	 * @return HeapQueue
	 * @exception RuntimeMyException
	 */
	public static function Queue($QueueID)
	{
		list($cn) = explode(':', $QueueID);
		if ( empty($cn) )
			throw new RuntimeMyException("Invalid QueueID");			
		
		$fn = ENGINE_PATH .'include/heap/'. strtolower( str_replace('/', '_', $cn) ) .'php';
		if ( is_file($fn) )
		{
			require_once($fn);
			$cn = "HeapQueue_". $cn;
		}
		else
			$cn = "HeapQueue";
		
		if ( !class_exists($cn) )
			throw new RuntimeMyException("Class '". $cn ."' not found");
		
		return new $cn($QueueID);
	}

	/**
	 * Получение объекта персональной очереди пользователя
	 * 
	 * @param int UserID    Идентификатор пользователя
	 * @return HeapQueue
	 * @exception RuntimeMyException
	 */
	public static function UsersQueue($UserID = 0)
	{
		global $OBJECTS;
		if ( $UserID == 0 )
			$UserID = $OBJECTS['user']->ID;
		if ( empty($UserID) )
			throw new RuntimeMyException("Can't get user's queue due to unknown UserID");
		
		$queue = self::Queue('user:'. $UserID);
		$queue->UserID = $UserID;
		return $queue;
	}

	/**
	 * Создает новый объект хипа
	 * 
	 * @param array actions    Действия над объектом
	 * @param array data    Данные объекта очереди
	 * @param string view    Представление объекта очереди
	 * @return HeapObject
	 */
	public static function CreateObject($actions, $data, $view)
	{
		$object = array(
			'ObjectID' 		=> uuid_create(UUID_TYPE_TIME),
			'DateCreate' 	=> time(),
			'Actions' 		=> $actions,
			'Data'			=> $data,
			'View'			=> $view,
		);
		
		return new HeapObject($object);
	}

	/**
	 * Возвращает список очередей
	 *
	 * @param bool include_users Включить в список пользовательские очереди
	 * @return array
	 * @exception RuntimeMyException
	 * @todo: Это надо переложить в Redis после готовности RPC
	 */
	public static function QueueList($include_users = false)
	{
		$sql = "SELECT * FROM `queue_list`";
		if ( $include_users !== true )
			$sql.= " WHERE `QueueID` NOT LIKE 'user:%'";		
		$res = self::$db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("Can't get heap queue list");
		
		$list = array();
		while ( $row = $res->fetch_assoc() )
			$list[$row['QueueID']] = array( 'Title' => $row['Title'], 'Table' => $row['Table'] );
		
		return $list;
	}
	
	/**
	 * Запускает транзакцию
	 * 
	 * @exception RuntimeMyException 
	 */
	public static function StartTransaction()
	{
		if ( self::$db->query("START TRANSACTION") === false )
			throw new RuntimeMyException("Can't start transaction");
	}
	
	/**
	 * Сохраняет текущую транзакцию
	 * 
	 * @exception RuntimeMyException 
	 */
	public static function Commit()
	{
		if ( self::$db->query("COMMIT") === false )
			throw new RuntimeMyException("Can't commit transaction");
	}
	
	/**
	 * Отменяет текущую транзакцию
	 */
	public static function Rollback()
	{
		self::$db->query("ROLLBACK");
	}
	
	public static function Init()
	{
		if ( self::$db === null )
			self::$db = DBFactory::GetInstance(self::DB_NAME);
	}
}

/**
 * Базовый класс объекта очереди
 * @author farid
 * @created 23-ноя-2010 11:37:53
 */
class HeapObject
{
	private $ObjectID;			// Идентификатор объекта
	private $QueueID = null;	// Идентификатор очереди объекта
	private $DateCreate;		// Время создания объекта
	private $DatePush;			// Дата помещения объекта в очередь
	
	public $Actions = array();	// Список действий, которые могут быть произведены над объектом
	public $Data = array();		// Данные объекта
	public $View = '';			// Представление объекта в очереди
	
	/**
	 * Конструктор класса.
	 * 
	 * @param object    Параметры объекта
	 */
	public function __construct($object = array())
	{
		$this->ObjectID = $object['ObjectID'];
		$this->QueueID = $object['QueueID'];
		$this->DateCreate = $object['DateCreate'];
		$this->DatePush = $object['DatePush'];
		if ( is_array($object['Data']) )
			$this->Data = $object['Data'];
		if ( is_array($object['Actions']) )
			$this->Actions = $object['Actions'];
		$this->View = $object['View'];
	}

	/**
	 * Сохранение объекта в базу в заданную очередь или текущую очередь объекта.
	 * 
	 * @param string QueueID    Имя очереди, в которую сохранить объект.
	 * @exception RuntimeMyException
	 */
	public function Store($QueueID = '')
	{
		if ( empty($QueueID) )
		{
			if ( empty($this->QueueID) )
				throw new RuntimeMyException("Undefined QueueID to store object");
		}
		else
		{
			$this->QueueID = $QueueID;
			$this->DatePush = time();
		}

		$table = Heap::Queue($this->QueueID)->Table;
		if ( empty($table) )
			throw new RuntimeMyException("Undefined Table to store object");
		
		$sql = "REPLACE INTO `". $table ."` SET ";
		$sql.= " `ObjectID` = '". addslashes($this->ObjectID) ."', ";
		$sql.= " `QueueID` = '". addslashes($this->QueueID) ."', ";
		$sql.= " `Actions` = '". serialize( (array) $this->Actions ) ."', ";
		$sql.= " `Data` = '". serialize( (array) $this->Data ) ."', ";
		$sql.= " `View` = '". addslashes($this->View) ."', ";
		$sql.= " `DateCreate` = '". date('Y-m-d H:i', $this->DateCreate) ."', ";
		$sql.= " `DatePush` = '". date('Y-m-d H:i', $this->DatePush) ."'";
		
		Heap::$db->query($sql);
	}

	/**
	 * Запускает действие над объектом, генерируя соответствующее событие
	 * 
	 * @param string action    Имя действия (генерируемого события)
	 * @exception RuntimeMyException
	 */
	public function Action(string $action)
	{
		if ( !isset($this->Actions[$action]) )
			throw new RuntimeMyException("Undefined action '". $action ."'");
		
		EventMgr::Raise($action, $this->Data);
	}
	
	/**
	 * Возвращает объект в виде массива. Даты приводятся к строкам.
	 */
	public function AsArray()
	{
		return array(
			'ObjectID' => $this->ObjectID,
			'QueueID' => $this->QueueID,
			'DateCreate' => date('Y-m-d H;i', $this->DateCreate),
			'DatePush' => date('Y-m-d H;i', $this->DatePush),
			'Data' => $this->Data,
			'Actions' => $this->Actions,
			'View' => $this->View,
		);
	}
}


/**
 * Базовый класс очереди
 * @author farid
 * @created 23-ноя-2010 11:37:53
 */
class HeapQueue
{
	protected $QueueID = '';				// Идентификатор очереди
	
	public $Table = 'queue';				// Имя таблицы для очереди
	
	/**
	 * Конструктор класса
	 *
	 * @param int QueueID   Идентификатор очереди
	 */
	public function __construct($QueueID)
	{
		$this->QueueID = $QueueID;
	}
		
	/**
	 * Помещает объект в очередь
	 * 
	 * @param HeapObject object    Объект очереди
	 * @exception RuntimeMyException 
	 */
	public function Push($object)
	{
		$object->Store($this->QueueID);
		
		$sql = "SELECT * FROM `queue_list`";
		$sql.= " WHERE `QueueID` = '". $this->QueueID ."'";
		$res = Heap::$db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("Can't get objects list");
		 
		if ( $res->num_rows == 0 )
		{
			$sql = "INSERT INTO `queue_list` SET ";
			$sql.= " `QueueID` = '". addslashes($this->QueueID) ."', ";
			$sql.= " `Title` = '". addslashes($this->Title()) ."', ";
			$sql.= " `Table` = '". addslashes($this->Table) ."'";
			Heap::$db->query($sql);
		}
	}

	/**
	 * Извлекает объект из начала очереди очереди или заданный объект
	 * 
	 * @param int ObjectID    Идентификатор извлекаемого объекта
	 * @return HeapObject
	 * @exception RuntimeMyException 
	 */
	public function Pop($ObjectID = null)
	{
		$sql = "SELECT * FROM `". $this->Table ."`";
		$sql.= " WHERE `QueueID` = '". addslashes($this->QueueID) ."'";
		if ( $ObjectID !== null )
			$sql.= " AND `ObjectID` = '". addslashes($ObjectID) ."'";
		$sql.= " ORDER BY `DatePush` ASC";
		$sql.= " LIMIT 1";
		$res = Heap::$db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("Can't get objects list");
		
		if ( $res->num_rows == 0 )
		{
			// нет объектов - удалить из списка очередь
			$sql = "DELETE FROM `queue_list`";
			$sql.= " WHERE `QueueID` = '". addslashes($this->QueueID) ."'";
			Heap::$db->query($sql);
			return null;
		}
		
		$object = $res->fetch_assoc();
		
		if ( $ObjectID === null )
			$ObjectID = $object['ObjectID'];
		
		$sql = "DELETE FROM `". $this->Table ."`";
		$sql.= " WHERE `ObjectID` = '". addslashes($ObjectID) ."'";
		Heap::$db->query($sql);
		
		$object['Data'] = unserialize($object['Data']);
		$object['Actions'] = unserialize($object['Actions']);
		
		return new HeapObject($object);
	}

	/**
	 * Возвращает массив объектов очереди без извлечения их из нее
	 * 
	 * @param int offset    Номер начального элемента
	 * @param int limit    Количество получаемых объектов
	 * @exception RuntimeMyException 
	 * @return array
	 */
	public function Range($limit, $offset = 0)
	{
		$sql = "SELECT * FROM `". $this->Table ."`";
		$sql.= " WHERE `QueueID` = '". addslashes($this->QueueID) ."'";
		$sql.= " ORDER BY `DatePush` ASC";
		$sql.= " LIMIT ". intval($offset) .", ". intval($limit);
		
		$res = Heap::$db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("Can't get objects list");
		
		$list = array();
		while ( $row = $res->fetch_assoc() )
		{
			$row['Data'] = unserialize($row['Data']);
			$row['Actions'] = unserialize($row['Actions']);
			$list[] =&  new HeapObject($row);
		}
		
		return $list;
	}

	/**
	 * Возвращает количество объектов в очереди
	 *
	 * @return int
	 */
	public function Length()
	{
		$sql = "SELECT COUNT(*) FROM `". $this->Table ."`";
		$sql.= " WHERE `QueueID` = '". addslashes($this->QueueID) ."'";
		
		$res = Heap::$db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("Can't get objects list");
		
		list($length) = $res->fetch_row();
		
		return $length;
	}

	/**
	 * Получение заголовка очереди
	 *
	 * @return string
	 */
	public function Title()
	{
		// Заголовок генерим из идентификатора очереди, исходя из того, что он сформирован по принципу <сервис>:<регион>
		// Но можно переопределить этот метод
		$words = array(
			'realty' 	=> 'Недвижимость',
			'car' 		=> 'Автообъявления',
			'board' 	=> 'Барахолка',
			'job' 		=> 'Работа',
			'vacancy'	=> 'Вакансия',
			'resume'	=> 'Резюме',
		);
		
		$title = $this->QueueID;
		
		foreach ( $words as $w => $t )
			$title = str_replace($w, $t, $title);
		
		return str_replace(":", " - ", $title);
	}

}

Heap::Init();

?>