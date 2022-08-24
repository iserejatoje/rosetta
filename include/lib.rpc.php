<?php

/**
 * Удаленный вызов процедур
 *
 * @author Farid
 * @version 1.0
 * @created 03-дек-2010 12:36:46
 */
class RPC
{
	const TRANSPORT_TABLE = '_rpc_transport';	// имя таблицы-транпорта
	const TRANSPORT_LIMIT = 10000;				// максимальное количество обрабатываемых вызовов
	
	/**
	 * Добавляет вызовы обработчиков
	 * 
	 * @param array $handler    Вызываемый обработчик
	 * @param object $db    Объект глобальной базы данных, используемой для транспорта
	 * @param bool $init    Выполнить проверку-инициализацию транспорта для данной БД
	 * @exception RuntimeMyException
	 */
	public static function Call($handler, $db, $init = false)
	{
		if ( $init === true )
			self::_init_transport($db);
		
		$uuid = uuid_create(UUID_TYPE_TIME);
		
		$sql = "INSERT INTO `_rpc_transport` SET ";
		$sql.= " `CallID` = '". addslashes( $uuid ) ."', ";
		$sql.= " `Handler` = '". addslashes( serialize($handler) ) ."'";
		
		if ( $db->query($sql) === false )
			throw new RuntimeMyException("RPC transport error");
	}
	
	
	/**
	 * Вызывает обработку вызовов для заданной БД и добавляет отметку о результате в вызов. 
	 * Если все регионы обработаны - удаляет вызов.
	 *
	 * @param object $db    Объект глобальной базы данных, используемой для транспорта
	 * @exception RuntimeMyException
	 */
	public static function Process($db)
	{
		$sql = "SELECT * FROM `_rpc_transport`";
		$res = $db->query($sql);
		if ( $res === false )
			throw new RuntimeMyException("RPC transport error");
		
		$processed = array();
		while ( $row = $res->fetch_assoc() )
		{
			try
			{
				$h = @unserialize($row['Handler']);
				if ( $h === false )
					continue;
				
				EventMgr::GetHandler($h)->Run((array) $h['params']);
			}
			catch ( MyException $e )
			{
				continue;
			}
			
			$processed[] = $row['CallID'];
		}
		
		// удаляем вызовы со слейва порциями по 100 шт.
		while ( count($processed) )
		{
			$_ = array_splice($processed, 0, 100);
			$sql = "DELETE FROM `_rpc_transport`";
			$sql.= " WHERE `CallID` IN ('". implode("','", $_) ."')";
			$db->query($sql);
		}
	}
	
	
	/**
	 * Проверяет состояние транспорта для заданной БД и удаляет с мастера обработанные вызовы
	 * 
	 * @param object $db    Объект глобальной базы данных, используемой для транспорта
	 * @exception RuntimeMyException
	 */
	public static function Check($db)
	{
		$_db = DBFactory::GetInstance($db->GetDBName());
		
		// просматриваем все слейвы на предмет необработанных вызовов
		$unprocessed = array();
		$slaves = dns_get_record($db->GetDBName .'.r.mysql'. DC_SUFFIX);		
		if ( !is_array($slaves) || count($slaves) == 0 )
			throw new RuntimeMyException("DNS ERROR: Can't get slave host list");
		
		foreach ( $slaves as $slave )
		{
			$_db->SetHost($slave['host']);
			$res = $_db->query("SELECT `CallID` FROM `_rpc_transport`");
			while ( list($CallID) = $res->fetch_row() )
				$unprocessed[$CallID] = $CallID;
		}
		
		// берем список вызовов с мастера
		$calls = array();
		$master = dns_get_record($db->GetDBName .'.r2.mysql'. DC_SUFFIX);
		if ( !is_array($master) || count($master) == 0 )
			throw new RuntimeMyException("DNS ERROR: Can't get master host");
		
		$_db->SetHost($master['host']);
		$sql = "SELECT `CallID` FROM `_rpc_transport`";
		while ( list($CallID) = $res->fetch_row() )
			$calls[$CallID] = $CallID;

		// вычислем список обработанных вызовов, как разность всех вызовов с мастера и всех вызовов слейвов
		$processed = array_diff($unprocessed, $calls);
		
		unset($unprocessed, $calls);
		
		// удаляем вызовы с мастера  порциями по 100 шт.
		while ( count($processed) )
		{
			$_ = array_splice($processed, 0, 100);
			$sql = "DELETE FROM `_rpc_transport`";
			$sql.= " WHERE `CallID` IN ('". implode("','", $_) ."')";
			$_db->query($sql);
		}
		
		// если превышен предел транспорта - роняем ошибку, но работать продолжаем
		// это дает возможность остановить репликацию вызовов и попытаться что-то разгрести
		if ( count($calls) > self::TRANSPORT_LIMIT )
			throw new RuntimeMyException("Warning! RPC transport reaches transport limit");
	}
	
	
	/**
	 * Проверяет состояние всех транспортов
	 */
	public function CheckAll()
	{
		$dbs = self::GetTransports();
		foreach ( $dbs as $db_name )
		{
			$db = DBFactory::GetInstance($db_name);
			try
			{
				self::Check($db);
			}
			catch ( MyException $e )
			{
				continue;
			}
		}
	}
	
	
	/**
	 * Получение списка транспортов
	 * 
	 * @exception RuntimeMyException
	 */
	public function GetTransports()
	{
		$dbs = dns_get_record('global.db.txt'. INTERNAL_SUFFIX, DNS_TXT);
		if ( !is_array($dbs_global) || count($dbs_global) == 0 || !isset($dbs_global['txt']) )
			throw new RuntimeMyException("DNS ERROR: Can't get global database list");
		
		$dbs = explode(' ', $dbs['txt']);
		if ( count($dbs) == 0 )
			return array();
		
		$dbs_global = array();
		foreach ( $dbs as $db_name )
		{ 
			$res = DBFactory::GetInstance($db_name)->query("SHOW TABLES LIKE `_rpc_transport`");
			if ( $res->num_rows > 0 )
				$dbs_global[] = $db_name;
		}

		return $dbs_global;
	}
	
	
	/**
	 * Инициализация транспорта
	 * Проверяет наличие и создает транспортную табличку в базе.
	 * База должна быть глобальной
	 *
	 * @param object $db    Объект глобальной базы данных, используемой для транспорта
	 * @exception RuntimeMyException
	 */
	private static function _init_transport($db)
	{
		$sql = "CREATE TABLE IF NOT EXISTS `". self::TRANSPORT_TABLE ."` (";
		$sql.= " `CallID` varchar(50),";
		$sql.= " `Handler` TEXT,";
		$sql.= " PRIMARY KEY (`CallID`)";
		$sql.= ") ENGINE=InnoDB DEFAULT CHARSET=cp125";
		if ( $db->query($sql) === false )
			throw new RuntimeMyException("Can't create RPC transport table");
	}

}

?>
