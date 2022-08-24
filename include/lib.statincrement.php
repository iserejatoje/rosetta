<?
	define('LIB_LOGINCREMENT_FILE_PATH', LOG_PATH.'stat/statincrement.log');
	define('LIB_LOGINCREMENT_DIR_PATH', LOG_PATH.'stat/data/');
	class StatIncrement
	{
		static private $_queue;
		
		function Log2Queue($db, $table, $field_name, $field_id_name, $ids) {
			if (self::$_queue === null) {
				LibFactory::GetStatic('queue');

				self::$_queue = new Queue();
				self::$_queue->Init('redisq', 'statincrement');
			}
			
			if (!is_array($ids))
				$ids = array($ids);
			
			$data = array(
				$db, $table, $field_name, $field_id_name, $ids
			);
			self::$_queue->Push('Log2Queue', $data, 0, 3600);
		}
		
		function Log($db, $table, $field_name, $field_id_name, $ids)
		{
			if(!is_array($ids))
				$ids = array($ids);
			
			if(count($ids) == 0)
				return false;
			
				$db = DBFactory::GetInstance($db);
			
			foreach($ids as $id)
			{			
				$sql = " UPDATE ".$table." SET ";
				$sql.= $field_name."=".$field_name."+1";
				$sql.= " WHERE ".$field_id_name."=".$id;
				
				$db->query($sql);
			}			
			return true;	
		}
	}

?>
