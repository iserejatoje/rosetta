<?php

require_once dirname(__FILE__).'/../base/default.php';

class SMS_Sender_Provider_MarketSms extends SMS_Sender_Base_Default
{
	private $curl;
	
	/**
	 * Стек сообщений для отправки
	 * @var array 
	 */
	private $stack_messages;
	
	/**
	 * Сюда необходимо сделать POST-запрос для отправки sms
	 * @var string
	 */
	private static $SEND_URL = 'http://marketsms.ru/mm/send.php';
	
	/**
	 * Сюда необходимо сделать POST-запрос для получения баланса
	 * @var string
	 */
	private static $BALANCE_URL = 'http://marketsms.ru/mm/balance.php';
		
	/**
	 * Сюда необходимо сделать POST-запрос для получения статуса доставки
	 * @var string
	 */	
	private static $DELIVERY_URL = 'http://marketsms.ru/mm/delivery.php';
	
	private $password = 'vtufrfyfk';
	private $login = 'thebest'; 
	private $number_pattern = "@^(?:79[\d]{9}|(?:(380|375)[\d]{8}))$@";
		
	/**
	 * минимальная длина sms-ки	 
	 */
	const L_MIN_LEN_MESSAGE = 3;
	
	protected static $SMS_PROVIDER_LOG = 'sms_sender_marketsms_%04u%02u';
	private $_log_db = null;
	
	public static $status = array(
		-1 => 'статус не известен',
		0 => 'сообщение доставлено',
		1 => 'сообщение отправлено, данных о доставке нет',
		2 => 'сообщение еще не отправлено',
		3 => 'ошибка доставки сообщения',
		4 => 'ошибки доставки нет, но нет и отчета о доставке, превышен лимит ожидания отчета',
	);
	
	/** 
	 * Список неопределенных статусов 
	 * Если сообщение имеет такой статус, то необходимо будет повторно 
	 * проверить на наличие статуса, отличного от этого 
	 * @var array
	 * */
	private static $checking_status = array(1,2,4); 
	
	public function __construct()
	{
		
	}
	
	/**
	 * Получить объект curl
	 * 
	 *  @return curl
	 */
	protected function GetCurl()
	{
		if( $this->curl === null )
	    {
	        $this->curl = LibFactory::GetInstance('curl');
	        $this->curl->Init();
	        $this->curl->SetParams(array(
	            'type' => 'module',
	            'use_proxy' => false,
	            'agent' => 'Rugion Curl Wrapper',
	            ));
	    }
	    return $this->curl;	
	}
	
	/**
	 * Отправка SMS-сообщения
	 * Перед вызовом этого метода необходимо наполнить стек сообщений
	 * Чистит стек сообщений для следующей отправки
	 * 
	 * @param string sender - имя отправителя - если не указать, то "rugion"	 
	 * @exception RuntimeBTException
	 * @exception LogicBTException
	 */
	public function Send($sender = null)
	{
		if (count($this->stack_messages) == 0)
			throw new LogicBTException("Empty stack messages");
		
		if ($sender !== null)
		{
			$sender = strtolower($sender);
			$sender = preg_replace("/[^0-9a-z]+/", "", $sender);
		}
		else
			$sender = "rugion";
		
		$writer = new XMLWriter();

		$uid = time();
				
		//начинаем формировать xml
		$writer->openMemory();
		
		$writer->startDocument("1.0", "utf-8");
		
		$writer->startElement("request");
		$writer->writeAttribute("uid", $uid);
		$writer->writeAttribute("sender", $sender);
		
		foreach ($this->stack_messages as $item) 
		{
			if (!is_array($item['phones']) || count($item['phones']) == 0)
				continue;
			
			$writer->startElement("message");
			
			$writer->writeElement("text", iconv("WINDOWS-1251", "UTF-8", $item['message']));
			
			foreach ($item['phones'] as $phone)
			{
				$writer->startElement("abonent");
				$writer->writeAttribute("phone", $phone);
				$writer->endElement();
			}
			
			$writer->endElement();
		}
		
		$writer->startElement("security");
		
		$writer->startElement("login");
		$writer->writeAttribute("value", $this->login);
		$writer->endElement();
		$writer->startElement("sign");
		$writer->writeAttribute("value", md5($uid.$this->password));
		$writer->endElement();
		
		$writer->endElement(); //закрываем security						
		$writer->endElement(); //закрываем request		
		$writer->endDocument();	//закрываем документ	

		
		$xml = $writer->outputMemory();
		
		//Закончили формировать, начинаем слать запрос				
		$params = array(
			'url' => self::$SEND_URL,
			'query' => $xml,
		);		
		$response = $this->GetCurl()->query($params);
		/*$response = '<?xml version="1.0" encoding="utf-8" ?><response uid="'.$uid.'"><information code="0">ok</information></response>';*/
		$result = $this->parseResponse($response);
		
		//Логируем результаты
		foreach($this->stack_messages as $item)
		{
			foreach ($item['phones'] as $phone)				
				$this->log($sender, $item['message'], $phone, $uid, $result['code'], $result['message']);				
			
		}
		//Чистим стек сообщений
		$this->Flush();
		
		if ($result['code'] == -1)
			throw new RuntimeBTException("Wrong http-response");		
						
		if ($result['code'] > 0)
			throw new RuntimeBTException("Error send message. Response \"".$result['message']."\". Error code: ".$result['code'] );
	}
		
	/**
	 * Добавить сообщение для отправки.
	 * Можно указывать несколько номеров телефонов для отправки
	 * 
	 * @param string message Сообщение для отправки
	 * @param array phones Массив номеров телефонов	 
	 * @exception InvalidArgumentBTException
	 */
	public function PushMessage($message, $phones)
	{
		$message = trim(strip_tags($message));
		
		if (strlen($message) <= L_MIN_LEN_MESSAGE)
			throw new InvalidArgumentBTException("Message too short");
		
		if (!is_array($phones))
			throw new InvalidArgumentBTException("Second parameter should be an array");
		
		foreach($phones as $phone)
			if (preg_match($this->number_pattern, $phone, $matches) == 0)
				throw new InvalidArgumentBTException("Phone incorrect");
		
		$this->stack_messages[]= array(
			'message' => $message,
			'phones' => $phones,
		);
	}
	
	/**
	 * Чистит стек сообщений
	 * 
	 * @return bool
	 */
	public function Flush()
	{	
		$this->stack_messages = array();
		return true;
	}
	
	/**
	 * Получить баланс в системе
	 * 
	 * @return float баланс
	 * @exception RuntimeBTException
	 */
	public function GetBalance()
	{
		$writer = new XMLWriter();

		$uid = time();
		
		//начинаем формировать xml
		$writer->openMemory();
		
		$writer->startDocument("1.0", "utf-8");
		
		$writer->startElement("request");
		$writer->writeAttribute("uid", $uid);
		
		$writer->startElement("security");
		$writer->startElement("login");
		$writer->writeAttribute("value", $this->login);
		$writer->endElement();
		$writer->startElement("sign");
		$writer->writeAttribute("value", md5($uid.$this->password));
		$writer->endElement();
		
		$writer->endElement(); //Закрываем security
		
		$writer->endElement(); //Закрываем request
		$writer->endDocument();
			
		$xml = $writer->outputMemory();
			
		//Закончили формировать, начинаем слать запрос				
		$params = array(
			'url' => self::$BALANCE_URL,
			'query' => $xml,
		);		
		$response = $this->GetCurl()->query($params);
		
		$result = $this->parseResponse($response);
		if ($result['code'] == -1)
			throw new RuntimeBTException("Wrong http-response");
					
		if ($result['code'] > 0)
			throw new RuntimeBTException("Error get balance. Response \"".$result['message']."\". Error code: ".$result['code']);
		
		if ($result['code'] == 0)
			return floatval(trim($result['message']));
		
	}
	
	/**
	 * Получиает статусы доставки сообщений
	 * Проставляет в таблице основного лога статус
	 * Если Статус говорит о том, что все ок, то убивает из временной таблицы запись
	 * 
	 * @return bool
	 */
	public function SetStatusDelivery()
	{
		$uids = array();
		$phones = array();
		$tables = array();
		$sql = "SELECT * FROM sms_sender_delivery_marketsms";
		$res = $this->log_db->query($sql);
		while($row = $res->fetch_assoc())
		{
			$uids[$row['Uid']] = $row['Uid'];
			$phones[$row['Phone']][] = $row['Uuid'];
			$tables[$row['Uuid']] = array(
				'table' => $row['Table'],
				'check_count' => $row['CheckCount'],
			);
		}
		
		if (count($uids) == 0)
			return false;
		
		foreach($uids as $uid)
		{			
			$statuses = $this->getStatusesByUid($uid);
						
			if (!is_array($statuses) || count($statuses) == 0)
				continue;
			
			foreach($statuses as $phone => $status)
			{
				if (!isset($phones[$phone]))
					continue;
					
				$uuids = $phones[$phone];
				foreach($uuids as $uuid)
					$this->processLogEvent($uuid, $status, $tables[$uuid]['table'], $tables[$uuid]['check_count']);
				
			}
		}
	}
	
	/**
	 * Возвращает статусы доставки сообщений
	 *
	 * @return array ключ - статус, значение - сообщение об ошибке
	 */
	public function GetErrors()
	{
		return self::$status;
	}
	
	/**
	 * Получить статусы доставки для определённого uid
	 *
	 * @param int uid идентификатор необработанного события из временной таблицы
	 * @return array ключ "номер телефона", значение "статус"
	 */
	private function getStatusesByUid($uid)
	{
		$writer = new XMLWriter();
				
		//начинаем формировать xml
		$writer->openMemory();
		
		$writer->startDocument("1.0", "utf-8");
		
		$writer->startElement("request");
		$writer->writeAttribute("uid", $uid);
		
		$writer->startElement("security");
		$writer->startElement("login");
		$writer->writeAttribute("value", $this->login);
		$writer->endElement();
		$writer->startElement("sign");
		$writer->writeAttribute("value", md5($uid.$this->password));
		$writer->endElement();
		
		$writer->endElement(); //Закрываем security
		
		$writer->endElement(); //Закрываем request
		$writer->endDocument();
			
		$xml = $writer->outputMemory();
		
		//Закончили формировать, начинаем слать запрос				
		$params = array(
			'url' => self::$DELIVERY_URL,			
			'query' => $xml,
		);		
		$response = $this->GetCurl()->query($params);
				
		if ($response == "")
			return false;

		$result = array();			
		$reader = new SimpleXMLElement($response);		
		foreach ($reader->message->children() as $k => $v)
		{			
			$attrs = $v->attributes();
			
			//В $attrs['phone'] по умолчанию лежит объект атрибута
			//Конкатенацией приводим к строке
			$phone = $attrs['phone']."";			
			$result[$phone] = intval($v->status);
		}
		
		return $result;
	}
	
	/**
	 * Устанавливает статусы для событий в логах
	 * Если статус говорит о том, что все ок и дальше обрабатываться
	 * сообщение не будет, то удаляет из временной таблицы
	 * 
	 * @param string uuid идентификатор события в логах
	 * @param int status выставляемый статус
	 * @param string table имя таблицы куда выставлять статус
	 * @param int check_count сколько уже раз делали проверку статуса
	 * @return bool
	 */
	private function processLogEvent($uuid, $status, $table, $check_count)
	{
		$sql = "UPDATE ".$table." SET";
		$sql.= " `Status`=".$status;
		$sql.=" WHERE Uuid='".$uuid."'";		
		$this->_log_db->query($sql);
		
		//Если статус говорит о том, что все ок и дальше обрабатываться
		//сообщение не будет, то удаляет из временной таблицы.
		//Иначе инкрементируется счётчик проверок статуса. Если он больше 5, 
		//то далее не проверяем 
		if (in_array($status, self::$checking_status) && $check_count < 5)
		{
			$sql = "UPDATE sms_sender_delivery_marketsms SET";
			$sql.= " CheckCount = CheckCount + 1";
			$sql.=" WHERE Uuid='".$uuid."'";
			$this->_log_db->query($sql);
		}
		else
		{
			$sql = "DELETE FROM sms_sender_delivery_marketsms";
			$sql.=" WHERE Uuid='".$uuid."'";
			$this->_log_db->query($sql);
		}
	}
	
	/**
	 * Создаёт таблицу для логов, каждый месяц новая таблица
	 */
	private function log_init()
	{
		$this->_log_db = DBFactory::GetInstance('log');
		
		$sql = "CREATE TABLE IF NOT EXISTS `". $this->log_table ."`(";
		$sql.= " `Uuid` varchar(36) not null, ";		//уникальный идентификатор события в логе
		$sql.= " `Date` datetime, "; 					//Дата операции
		$sql.= " `Message` varchar(255) not null, ";	//Сообщение
		$sql.= " `Phone` varchar(11) not null, ";		//Номер телефона кому отправляли
		$sql.= " `Uid` varchar(36) not null, ";			//Идентификатор запроса в системе партнера (UUID)
		$sql.= " `Sender` varchar(100) not null, ";		//Имя отправителя
		$sql.= " `Code` int(4) not null, ";				//Код ошибки
		$sql.= " `ErrorMessage` varchar(255) not null, ";//Сообщение об ошибке в ответе провайдера
		$sql.= " `Status` tinyint(4) not null, ";		//Статус сообщения
		$sql.= " PRIMARY KEY (`Uuid`)";
		$sql.= ") ENGINE=MyISAM DEFAULT CHARSET=cp1251";
		
		$this->_log_db->query($sql);
	}
	
	/**
	 * Логирует одну транзакцию отправки sms
	 * На каждого абонента и на каждое сообщение по одной записи
	 * 
	 * @param string $sender имя отправителя
	 * @param string $message отпрвляемое сообщение
	 * @param string $phone номер телефона кому отправляли
	 * @param int $uid идентификатор запроса в системе партнераи (time())
	 * @param int $error_code код ошибки, который отдали в ответ на запрос
	 * @param string $error_message сообщение об ошибке или успехе операции
	 */
	private function log($sender, $message, $phone, $uid, $error_code = -1, $error_message = "")
	{		
		$uuid = uuid_create(UUID_TYPE_RANDOM); 
		
		$sql = "INSERT INTO ". $this->log_table ." SET";
		$sql.= " `Uuid` = '". $uuid."'";
		$sql.= ", `Date` = '".date('Y-m-d H:i:s')."'";
		$sql.= ", `Message` = '". addslashes($message) ."'";
		$sql.= ", `Phone` = '". addslashes($phone) ."'";
		$sql.= ", `Uid` = '". $uid."'";
		$sql.= ", `Sender` = '". addslashes($sender) ."'";
		$sql.= ", `Code` = ". $error_code;
		$sql.= ", `ErrorMessage` = '". addslashes($error_message) ."'";
		$sql.= ", `Status` = -1"; //Ставим -1, дальше программа, которая проверяет статусы, проставит сюда нужное значение 
		
		$this->log_db->query($sql);	

		if ($error_code != 0)
			return;
			
		//Добавляем запись, чтобы потом обновить статус в таблице с основными логами 
		$sql = "INSERT INTO sms_sender_delivery_marketsms SET";
		$sql.= " `Uuid` = '". $uuid."'";
		$sql.= ", `Table` = '".$this->log_table."'";
		$sql.= ", `Status` = -1";
		$sql.= ", `Phone` = '".addslashes($phone)."'";
		$sql.= ", `Uid` = '".$uid."'";
		$this->log_db->query($sql);	
	}
	
	
	/**
	 * Разбирает ответный xml
	 * 
	 * @param string response xml-ник, который отдали в ответ
	 * @return array такого вида: array('code'=>0,'message'=>'ok')
	 */
	private function parseResponse($response)
	{
		$result = array(
			'code' => -1,
			'message' => 'unknown error',
		);
		
		if ($response == "")
			return $result;
				
		$reader = new SimpleXMLElement($response);
		$elems = $reader->xpath('/response/information');
		
		// Ответ распарсили, и код ошибки 0 - все ок.
		 if (!is_array($elems) || count($elems) == 0)
		 	return $result;
	
		$attrs = $reader->information[0]->attributes();
		$result['code'] = $attrs[0];
		
		$values = $reader->information[0];		
		$result['message'] = iconv("UTF-8", "WINDOWS-1251", $values[0]);
		
		return $result;
	}
	
	
	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'log_db':
				if ( $this->_log_db === null )
					$this->log_init();
				
				return $this->_log_db;
			case 'log_table':
				return sprintf( self::$SMS_PROVIDER_LOG, date('Y'), date('m') );
			default:
				return null;
		}
	}
}