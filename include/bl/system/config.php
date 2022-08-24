<?
// при логировании изменения конфигов идентификатор раздела указывается только для конфигов раздела
class BL_system_config
{
	static private $cfg = array(
			'db'			=> 'webbazar',
			'use_files'		=> false,	// 2do: Это надо убрать после загрузки всех конфигов в базу
			'cache'			=> array(
				'use'			=> true,
				'timeout'		=> 86400,
			),
			'tables'		=> array(
				'config'		=> 'app_config',
				'backup'		=> 'app_config_backup',
				)
		);

	static private $cache = null;
	static private $config_cache = array();

	private $db = null;

	static public $type_info = array(
		'section' => array( 'title' => 'Раздел'),
		'module_engine' => array( 'title' => 'Модуль'),
		'module_site' => array( 'title' => 'Локальный модуля'),
		'design' => array( 'title' => 'Дизайн'),
		'module_design' => array( 'title' => 'Дизайн модуля'),
		'site_design' => array( 'title' => 'Локальный дизайна')
	);

	public function __construct()
	{
		LibFactory::GetStatic('cache');
		$this->db = DBFactory::GetInstance(self::$cfg['db']);
		if(self::$cache === null && self::$cfg['cache']['use'])
		{
			self::$cache = new Cache();
			self::$cache->Init('memcache', 'app_config');
		}
	}

	function Init($params)
	{
	}

	// импорт конфига, сохраняет в бд
	public function ImportArray($type, $id, $config)
	{
		$this->SaveConfig($type, $id, $config);
	}

	// загрузка конфига
	// кэширует в либе и memcache
	public function LoadConfig($type, $id, $revision = 0)
	{
		if ( empty($type) || empty($id) )
			return null;

		$revision = intval($revision);

		if ( $revision == 0 && is_array(self::$config_cache[$type][$id]) )
		{
			return self::$config_cache[$type][$id];
		}

		if ( $revision == 0 && self::$cache != null )
		{
			$config = self::$cache->Get($type.'|'.$id);
			if ( $config !== false )
				return $config;
		}

		$config = array();

		if ( $revision == 0 )
			$sql = "SELECT * FROM ". self::$cfg['tables']['config'];
		else
			$sql = "SELECT * FROM ". self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		if ( $revision != 0 )
			$sql.= " AND Revision = ".$revision;
		$sql.= " ORDER BY Ord";

		$res = $this->db->query($sql);
		if ( $res === false )
			return null;

		while ( $row = $res->fetch_assoc() )
		{
			if ( $row['Value'] === 'true' )
				$row['Value'] = true;
			elseif ( $row['Value'] === 'false' )
				$row['Value'] = false;

			if($row['Name'] == 'cache_mode')
				$row['Value'] = intval($row['Value']);

			$config[$row['Name']] = $row['Value'];
		}

		LibFactory::GetStatic('uarray');

		$config = UArray::FromLinear($config);

		if ( $revision == 0 )
		{
			self::$config_cache[$type][$id] = $config;

			if ( self::$cache != null )
			{
				self::$cache->Set($type.'|'.$id, $config, self::$cfg['cache']['timeout']);
			}
		}

		return $config;
	}

	// сохранение конфига
	public function SaveConfig($type, $id, $config, $backup = true)
	{
		global $OBJECTS;
		if ( empty($type) || empty($id) )
			return false;

		if ( $backup === true )
			$this->Backup($type, $id);

		LibFactory::GetStatic('uarray');
		
		if (is_array($config['blocks'])) 
		{
			foreach($config['blocks'] as &$blockPos) 
			{
				if (!is_array($blockPos))
					continue ;

				foreach($blockPos as &$block) {
					if ($block['type'] != 'widget' )
						continue ;
					
					$params = array();
					if (is_array($block['params']))
						$params = $block['params'];

					UArray::ksortRecursive($params);
					
					unset($params['cacheid']);
					//$block['params']['cacheid'] = md5($block['name'].'|'.serialize($params));
					if (!is_array($block['params']['env']))
						continue ;

					foreach($block['params']['env'] as &$v)
						$v = strtolower($v);
				}
			}
		}
		
		$config = UArray::ToLinear($config);

		$sql = "DELETE FROM ". self::$cfg['tables']['config'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$this->db->query($sql);

		foreach($config as $k => $v)
		{
			if ( is_bool($v) )
				$v = $v ? 'true' : 'false';
			$sql = "INSERT INTO ".self::$cfg['tables']['config'];
			$sql.= " SET";
			$sql.= " ID = '". $id ."',";
			$sql.= " Type = '". $type."',";
			$sql.= " Name = '". addslashes($k) ."',";
			$sql.= " Value = '". addslashes($v) ."',";
			$sql.= " IsVisible = 1";
			$this->db->query($sql);
		}

		$lid = 0;
		if($type == 2)
			$lid = $id;
		
		if ( is_array(self::$config_cache[$type][$id]) )
		{
			unset (self::$config_cache[$type][$id]);
		}

		if(self::$cache != null)
		{
			self::$cache->Remove($type.'|'.$id);
		}

		return true;
	}

	// создание резервной копии
	// на основе текущего конфига
	public function Backup($type, $id)
	{
		global $OBJECTS;
		if ( empty($type) || empty($id) )
			return null;

		$rev = 0;
		$sql = "SELECT max(Revision) FROM ". self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$sql.= " GROUP BY ID, Type";
		$res = $this->db->query($sql);
		if ( $res === false )
			return null;

		if ($row = $res->fetch_row() )
			$rev = $row[0];

		$rev++;

		$sql = "SELECT count(*) FROM ". self::$cfg['tables']['config'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$res = $this->db->query($sql);
		$cnt = 0;
		if($row = $res->fetch_row())
			$cnt = $row[0];
		if($cnt == 0)
			return null;

		$sql = "INSERT IGNORE INTO ". self::$cfg['tables']['backup'];
		$sql.= " (ID, Type, Name, Value, IsVisible, Date, Ord, Revision)";
		$sql.= " SELECT ID, Type, Name, Value, IsVisible, NOW(), Ord, ".$rev." FROM ".self::$cfg['tables']['config'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$sql.= " ORDER by Ord ";
		$this->db->query($sql);

		$lid = 0;
		if($type == 2)
			$lid = $id;
		
		return $rev;
	}

	// востановление резервной копии, если ревизия не указана, будет востановлена последняя
	public function Restore($type, $id, $revision = 0)
	{
		global $OBJECTS;
		if ( empty($type) || empty($id) )
			return null;

		$rev = 0;
		$sql = "SELECT max(Revision) FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		if($revision > 0)
			$sql.= " AND Revision=".$revision;
		$sql.= " GROUP BY ID, Type";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$rev = $row[0];
		else
			return null;		// нет резервной копии

		// удалим старые данные для раздела
		$sql = "DELETE FROM ".self::$cfg['tables']['config'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$this->db->query($sql);

		// востановим ревизию
		$sql = "INSERT INTO ".self::$cfg['tables']['config'];
		$sql.= " (ID, Type, Name, Value, IsVisible, Ord)";
		$sql.= " SELECT ID, Type, Name, Value, IsVisible, Ord FROM ". self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$sql.= " AND Revision=".$rev;
		$this->db->query($sql);

		$lid = 0;
		if($type == 2)
			$lid = $id;
	
		if ( is_array(self::$config_cache[$type][$id]) )
		{
			unset (self::$config_cache[$type][$id]);
		}

		if(self::$cache != null)
		{
			self::$cache->Remove($type.'|'.$id);
		}

		return $rev;
	}

	// если не указать ревизию, удалит все
	public function RemoveBackup($type, $id, $revision = 0)
	{
		global $OBJECTS;
		if ( empty($type) || empty($id) )
			return false;

		$revision = intval($revision);

		$sql = "DELETE FROM ". self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		if($revision > 0)
			$sql.= " AND Revision=".$revision;
		$this->db->query($sql);

		$lid = 0;
		if($type == 2)
			$lid = $id;
		
		return true;
	}

	// удалить конфиг
	public function RemoveConfig($type, $id)
	{
		global $OBJECTS;
		if ( empty($type) || empty($id) )
			return false;

		// бекапим
		$this->Backup($type, $id);

		$sql = "DELETE FROM ". self::$cfg['tables']['config'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$this->db->query($sql);

		$lid = 0;
		if($type == 2)
			$lid = $id;
	
		if ( is_array(self::$config_cache[$type][$id]) )
		{
			unset (self::$config_cache[$type][$id]);
		}

		if(self::$cache != null)
		{
			self::$cache->Remove($type.'|'.$id);
		}

		return true;
	}

	// чистка старых ревизий
	// 2 условия
	// 1 возраст 1 месяц
	// 2 20 штук && возраст 1 день
	public function ClearOldBackups()
	{
		// возраст 1 месяц
		$sql = "SELECT * FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE";
		$sql.= " Date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$this->db->query($sql);

		// 20 штук && возраст 1 день
		// берем кол-во
		$sql = "SELECT ID, Type, count(DISTINCT Revision) FROM ".self::$cfg['tables']['backup'];
		$sql.= " GROUP BY ID,Type";
		$res = $this->db->query($sql);
		while($row = $res->fetch_row())
		{
			if ( $row[2] > 20 )
			{
				// если больше 20, берем 20й или возрастом больше 1 дня
				$sql = "SELECT ID, Type, Revision, TIMESTAMPDIFF(HOUR, Date,NOW()) as Diff FROM ".self::$cfg['tables']['backup'];
				$sql.= " WHERE ID = '". $row[0] ."'";
				$sql.= " AND Type = '". $row[1] ."'";
				$sql.= " GROUP BY ID, Type, Revision";
				$sql.= " ORDER BY Revision DESC";
				$res2 = $this->db->query($sql);
				// если есть, удаляем все что старше его
				$cnt = 1;
				while($row2 = $res2->fetch_assoc())
				{
					if($row2['Diff'] >= 24 && $cnt > 20)
					{
						$sql = "DELETE FROM ". self::$cfg['tables']['backup'];
						$sql.= " WHERE ID = '". $row2['ID'] ."'";
						$sql.= " AND Type = '". $row2['Type'] ."'";
						$sql.= " AND Revision <= ".$row2['Revision'];
						$this->db->query($sql);
						break;
					}
					$cnt++;
				}
			}
		}

	}

	// получить список ревизий
	public function GetBackupRevisions($type, $id)
	{
		if ( empty($type) || empty($id) )
			return null;

		$revs = array();

		$sql = "SELECT Revision, Date FROM ". self::$cfg['tables']['backup'];
		$sql.= " WHERE ID = '". $id ."'";
		$sql.= " AND Type = '". $type ."'";
		$sql.= " GROUP BY Revision";
		$sql.= " ORDER BY Date DESC";
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$revs[] = array('id' => $id, 'type' => $type, 'revision' => $row['Revision'], 'date' => $row['Date']);

		return $revs;
	}


	// загрузка конфига для раздела
	public function GetConfigForSection($sectionid, $use_files = null)
	{
		global $CONFIG;

		if ( !is_numeric($sectionid) || $sectionid == 0 )
			return array();
		if ( $use_files === null )	// 2do: Это надо убрать после загрузки всех конфигов в базу
			$use_files = self::$cfg['use_files'];

		$namespace = ModuleFactory::GetNamespaceBySectionID($sectionid);
		if ( $namespace === null )
			return null;

		if ( $use_files === true )
			$configFiles = $namespace->GetConfigFileList($sectionid);	// 2do: Это надо убрать после загрузки всех конфигов в базу
		else
			$configList = $namespace->GetConfigList($sectionid);

		$configs = array();

		if ( count($configList) > 0 || count($configFiles) > 0 )
		{
			if ( $use_files === true )	// 2do: Это надо убрать после загрузки всех конфигов в базу
			{
				foreach ( $configFiles as $type => $s )
				{
					$config = ConfigFactory::GetConfig($s);
					if ( $config !== null )
					{
						$node = STreeMgr::GetNodeByID($sectionid);
						if($node !== null)
							$config['module'] = $node->Module;
						$configs[] = $config;
					}
				}
			}
			else
			{
				foreach ( $configList as $type => $s )
				{
					$config = self::LoadConfig($s['Type'], $s['ID']);
					if ( $config !== null )
					{
						$node = STreeMgr::GetNodeByID($sectionid);
						if($node !== null)
							$config['module'] = $node->Module;
						$configs[] = $config;
					}
				}
			}
		}

		$config = array();

		if ( count($configs) > 0 )
		{
			$config = array();
			foreach($configs as $s)
				$config = Data::array_merge_recursive_changed($config, $s);
		}

		$config = $namespace->UpdateConfig($config);

		return $config;
	}
}
