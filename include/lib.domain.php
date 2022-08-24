<?php
class Domain {

	const DT_FORBIDDEN			= 1;
	const DT_DNS				= 2;
	const DT_USER				= 3;
	
	const FT_FORBIDDEN			= 1;
	const FT_DNS				= 2;
	const FT_USER				= 4;
		
	const REGEXP_NAME			= '[a-z\d\-]+';

	static private $_config = array(
		'db' 		=> 'site',
		'tables' 	=> array(
						'domains' => 'Domains',
					),
	);

	static private $redis = null;

	public static function Init()
	{
		self::$redis = LibFactory::GetInstance('redis');
		self::$redis->Init('domain');
	}

	/**
	 * Проверка существования домена
	 *
	 * @param string $name имя
	 * @param string $domain домен второго уровня
	 * @return bool
	 */
	public static function IsDomainExists($name, $domain)
	{
		$cacheid = 'doamin_exist_'.$name.'_'.$domain;
		$data = self::$redis->Get($cacheid);
		if ($data === null)
		{
			$data = 0;

			$sql = "SELECT COUNT(*) FROM `".self::$_config['tables']['domains']."` WHERE";
			$sql.= " `Domain` = '".addslashes($domain)."'";
			$sql.= " AND `Name` = '".addslashes($name)."'";
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			$row = $res->fetch_row();
			if ($row[0] > 0)
				$data = 1;

			self::$redis->Set($cacheid, $data, 86400);
		}
		return (bool) $data;
	}

	/**
	 * Проверка на наличие у объекта домена
	 *
	 * @param int $object_id идентификатор объекта
	 * @param int $type допустимые типы в либе
	 * @return bool
	 */
	public static function CheckObjectDomains($object_id, $type)
	{
		$object_id = intval($object_id);
		$type = intval($type);
		if ($object_id <= 0 || $type <= 0)
			return false;

		$types = array();

		if( $type & self::FT_FORBIDDEN )
			array_push($types, self::DT_FORBIDDEN);
		if( $type & self::FT_DNS )
			array_push($types, self::DT_DNS);
		if( $type & self::FT_USER )
			array_push($types, self::DT_USER);

		if (count($types) == 0)
			return false;

		$cacheid = 'object_domains_'.$object_id.'_'.$type;
		$data = self::$redis->Get($cacheid);
		if ($data === null)
		{
			$data = 0;

			$sql = "SELECT COUNT(*) FROM `".self::$_config['tables']['domains']."` WHERE";
			$sql.= " `Type` IN (".implode(',', $types).")";
			$sql.= " AND `ObjectID` = '".addslashes($object_id)."'";

			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			$row = $res->fetch_row();
			if ($row[0] > 0)
				$data = 1;

			self::$redis->Set($cacheid, $data, 86400);
		}
		return (bool) $data;
	}

	/**
	 * Проверка на то, что такой-то домен запрещено регистрировать
	 * Он помечен как Foridden и имеет тип 1
	 *
	 * @param string $name
	 * @param string $domain
	 * @return bool
	 */
	public static function CheckForbidden($name, $domain)
	{
		$cacheid = 'doamin_forbidden_'.$name.'_'.$domain;
		$data = self::$redis->Get($cacheid);
		if ($data === null)
		{
			$data = 0;

			$db = DBFactory::GetInstance(self::$_config['db']);

			$sql = "SELECT COUNT(*) FROM `".self::$_config['tables']['domains']."` WHERE";
			$sql.= " `Type` IN (1,2)";
			$sql.= " AND `Domain` = '".addslashes($domain)."'";
			$sql.= " AND `Name` = '".addslashes($name)."'";
			$res = $db->query($sql);
			$row = $res->fetch_row();
			if ($row[0] > 0)
				$data = 1;

			$sql = "SELECT COUNT(*) FROM `".self::$_config['tables']['domains']."` WHERE";
			$sql.= " `Type` IN (1,2)";
			$sql.= " AND `Domain` = ''";
			$sql.= " AND `Name` = '".addslashes($name)."'";
			$res = $db->query($sql);
			$row = $res->fetch_row();

			//
			$data = intval($data || $row[0] > 0);

			self::$redis->Set($cacheid, $data, 86400);
		}
		return (bool) $data;
	}
		
	/**
	 * Создание домена третьего уровня
	 * 
	 * @param string имя домена третьего уровня
	 * @param int тип объекта 1 - Запретные имена, 2 - Реальны домен третьего уровня, 3 - Пользователь,  4 - Сообщество
	 * @param int id объекта
	 * @param string титульный домен
	 * @return bool
	 */	
	public static function Create($name, $type, $object_id, $domain)
	{
		if (empty($name) || strlen($name) < 3)
			return false;
		
		if (self::IsDomainExists($name, $domain) === true)
			return false;
		
		$sql = "INSERT INTO `".self::$_config['tables']['domains']."` SET ";
		$sql.= " `Type` = '".$type."'";
		$sql.= ", `Domain` = '".$domain."'";
		$sql.= ", `Name` = '".addslashes($name)."'";
		$sql.= ", `ObjectID` = '".$object_id."'";

		$db = DBFactory::GetInstance(self::$_config['db']);
		$db->query($sql);

		self::$redis->Set('name_domain_'.$name.'_'.$domain, 1, 86400);

		$cache_data = array(
			'ID' => $db->insert_id,
			'Type' => $type,
			'Domain' => $domain,
			'Name' => $name,
			'ObjectID' => $object_id,
		);
		self::$redis->Set('type_object_'.$type.'_'.$object_id, serialize($cache_data), 86400);
		return true;
		
	}
	
	/**
	 * Удаление домена третьего уровня
	 * 
	 * @param int тип объекта 1 - Запретные имена, 2 - Реальны домен третьего уровня, 3 - Пользователь,  4 - Сообщество
	 * @param int id объекта
	 * @return bool
	 */	
	public static function Remove($type, $object_id)
	{
		$data = self::GetInfo($type, $object_id);
		if ($data === false)
			return false;

		self::$redis->Del('type_object_'.$type.'_'.$object_id);
		self::$redis->Del('doamin_exist_'.$data['Name'].'_'.$data['Domain']);
		self::$redis->Del('object_domains_'.$object_id.'_'.$type);
		self::$redis->Del('doamin_forbidden_'.$data['Name'].'_'.$data['Domain']);
		self::$redis->Del('resolve_'.$data['Name'].'_'.$data['Domain']);
		
		$sql = "DELETE FROM `".self::$_config['tables']['domains']."` WHERE ";
		$sql.= " `ObjectID` = '".$object_id."'";
		$sql.= " AND `Type` = '".$type."'";
		
		return DBFactory::GetInstance(self::$_config['db'])->query($sql);
	}
	
	/**
	 * Измение домена третьего уровня
	 * 
	 * @param string имя домена третьего уровня
	 * @param int тип объекта 1 - Запретные имена, 2 - Реальны домен третьего уровня, 3 - Пользователь,  4 - Сообщество
	 * @param int id объекта
	 * @param string титульный домен
	 * @return bool
	 */	
	public static function Update($name, $type, $object_id, $domain)
	{
		$data = self::GetInfo($type, $object_id);

		if ($data === false)
			return false;

		self::$redis->Del('type_object_'.$data['Type'].'_'.$data['ObjectID']);
		self::$redis->Del('doamin_exist_'.$data['Name'].'_'.$data['Domain']);
		self::$redis->Del('object_domains_'.$data['ObjectID'].'_'.$data['Type']);
		self::$redis->Del('doamin_forbidden_'.$data['Name'].'_'.$data['Domain']);
		self::$redis->Del('resolve_'.$data['Name'].'_'.$data['Domain']);

		$data['Type'] = $type;
		$data['Name'] = $name;
		$data['Domain'] = $domain;
		$data['ObjectID'] = $object_id;
		
		$sql = "UPDATE `".self::$_config['tables']['domains']."` SET";
		$sql.= " `Name` = '".addslashes($name)."'";
		$sql.= ", `Domain` = '".addslashes($domain)."'";
		$sql.= " WHERE `Type` = ".$type." AND `ObjectID` = '".$object_id."'";
				
		$db = DBFactory::GetInstance(self::$_config['db']);
		$db->query($sql);

		return true;
	}
	
	/**
	 * Получить информацию о домене объекта
	 * 
	 * @param int тип объекта 1 - Запретные имена, 2 - Реальны домен третьего уровня, 3 - Пользователь,  4 - Сообщество
	 * @param int id объекта
	 * @return array()
	 */
	public static function GetInfo($type, $object_id)
	{
		$cache_data = self::$redis->Get('type_object_'.$type.'_'.$object_id);

		if ($cache_data === null)
		{
			$cache_data = '';
			$sql = "SELECT * FROM `".self::$_config['tables']['domains']."`";
			$sql.= " WHERE `Type` = '".$type."'";
			$sql.= " AND `ObjectID` = '".$object_id."'";

			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			if($row = $res->fetch_assoc())
				$cache_data = serialize($row);
			
			self::$redis->Set('type_object_'.$type.'_'.$object_id, $cache_data, 86400);
		}
		$row = unserialize($cache_data);
		if ($row == '')
			return false;

		return $row;
	}
	
	/**
	 * Генерация Имени
	 * 
	 * @param string имя домена третьего уровня
	 * @param int тип объекта 1 - Запретные имена, 2 - Реальны домен третьего уровня, 3 - Пользователь,  4 - Сообщество
	 * @param int id объекта
	 * @param string титульный домен
	 * @param string регион
	 * @param string имя пользователя
	 * @param string фамилия пользователя
	 * @return array array( array('scorcher13123',...) )
	 */
	public static function GenerateName($name, $type, $object_id, $domain, $region, $ufirstname = null, $ulastname = null, $new = false)
	{
		$examples = array();
		$variant = array();
		LibFactory::GetStatic('textutil');
		$patterns = array("@[^\w]+@", "@\_+@");
		$replacements = array("", "");
		$limit = 6;
		
		$name_old = $name;
		$name = strtolower($name);
		$name = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($name)));
		$region = strtolower($region);
		if ($name != $name_old)
			$variant[] = $name;

		$variant[] = $name.$region;
		$variant[] = $name.date('Y');
		
		if(!empty($ulastname))
		{
			$ulastname = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($ulastname)));
			$variant[] = $ulastname;
			$variant[] = $ulastname.$region;
			$variant[] = $ulastname.date('Y');
		}
		if(!empty($ufirstname))
		{
			$ufirstname = preg_replace($patterns, $replacements, strtolower(TextUtil::Translit($ufirstname)));
			$variant[] = $ufirstname;
			$variant[] = $ufirstname.$region;
			$variant[] = $ufirstname.date('Y');
		}	
		
		foreach($variant as $v)
		{
			if( self::IsNameValid($v) === false )
				continue;			
			if( self::IsDomainExists($v, $domain) !== false )
				continue;
			if( self::CheckForbidden($v, '') !== false )
				continue;

			
			$examples[] = $v;
		}
		return $examples;
	}
	
	/**
	 * Редирект на нужный URL
	 * 
	 * @param string входящий УРЛ
	 * @return string УРЛ для редиректа или false если нет
	 */
	public static function Resolve($string)
	{
		if( preg_match('@^('.self::REGEXP_NAME.')\.([a-z\d\-]+\.[a-z]+)$@', $string, $rg) )
		{
			$domain = $rg[2];
			$name = $rg[1];
		}
		else
			return false;

		$redirect_url = self::$redis->Get('resolve_'.$domain.'_'.$name);
		if ($redirect_url === null)
		{
			$redirect_url = '';
			$sql = "SELECT * FROM `".self::$_config['tables']['domains']."`";
			$sql.= " WHERE `Name` = '".$name."' AND `Domain` = '".$domain."'";
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);

			if( $row = $res->fetch_assoc() )
			{
				if ($row['Type'] == 3)
					$redirect_url = 'http://'.$row['Domain'].'/passport/info.php?id='.$row['ObjectID'];
			}

			self::$redis->Set('resolve_'.$domain.'_'.$name, $redirect_url, 86400);
		}

		if ($redirect_url == '')
			return false;
		return $redirect_url;
	}
	
	/**
	 * Проверяет на корректность имя
	 * 
	 * @param string имя
	 * @return bool
	 */
	public static function IsNameValid($name)
	{
		if( preg_match('@^'.self::REGEXP_NAME.'$@', $name) )
			return true;
		else
			return false;
	}

	/**
	 * Получить количесво доменова
	 * @param array $filter
	 * @return int count
	 */
	public static function GetDomainsCount($filter = array())
	{
		if (!isset($filter['ID']) || !is_numeric($filter['ID']))
			$filter['ID'] = -1;

		if (empty($filter['Name']))
			$filter['Name'] = -1;

		if (empty($filter['Domain']))
			$filter['Domain'] = -1;

		if (isset($filter['Type']))
		{
			$filter['Type'] = intval($filter['Type']);
			
			if( !in_array($filter['Type'], array(self::FT_FORBIDDEN,  self::FT_DNS, self::FT_USER)) || $filter['Type'] == 0)
				$filter['Type'] = -1;
		}
		else
			$filter['Type'] = -1;

		if (!isset($filter['ObjectID']) || !is_numeric($filter['ObjectID']))
			$filter['ObjectID'] = -1;

		$where = array();
		if (is_array($filter) && count($filter) > 0)
		{
			foreach($filter as $k => $v)
				if ($v !== -1)
					$where[] = "`".$k."` = '".addslashes($v)."'";
		}

		$sql = "SELECT COUNT(0) FROM ".self::$_config['tables']['domains'];
		if (count($where) > 0)
			$sql.= " WHERE ".implode(' AND ', $where);

		$db = DBFactory::GetInstance(self::$_config['db']);
		$res = $db->query($sql);
		if( ($row = $res->fetch_row()) !== false )
			return $row[0];
		return 0;
	}

	/**
	 * Получить количесво доменова
	 * @param array $filter
	 * @return int count
	 */
	public static function GetDomains($filter = array())
	{

		if (!isset($filter['ID']))
			$filter['ID'] = -1;
		elseif(is_array($filter['ID']))
		{
			foreach($filter['ID'] as $k => $v)
			{
				$v = intval($v);
				if ($v <= 0)
					unset($filter['ID'][$k]);
			}
		}
		else
		{
			$filter['ID'] = intval($filter['ID']);
			if ($filter['ID'] <= 0)
				$filter['ID'] = -1;
		}

		if (empty($filter['Name']))
			$filter['Name'] = -1;

		if (empty($filter['Domain']))
			$filter['Domain'] = -1;

		if (isset($filter['Type']))
		{
			$filter['Type'] = intval($filter['Type']);

			if( !in_array($filter['Type'], array(self::FT_FORBIDDEN,  self::FT_DNS, self::FT_USER)) || $filter['Type'] == 0)
				$filter['Type'] = -1;
		}
		else
			$filter['Type'] = -1;

		if (!isset($filter['ObjectID']) || !is_numeric($filter['ObjectID']))
			$filter['ObjectID'] = -1;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		$where = array();
		if (is_array($filter) && count($filter) > 0)
		{
			foreach($filter as $k => $v)
			{
				if ($k == 'limit' || $k == 'offset')
					continue;
				if ($v !== -1 && !is_array($v))
					$where[] = "`".$k."` = '".addslashes($v)."'";
				elseif ($v !== -1 && is_array($v) && count($v) > 0)
					$where[] = "`".$k."` IN (".implode(',', $v).")";
			}
		}

		$sql = "SELECT * FROM ".self::$_config['tables']['domains'];
		if (count($where) > 0)
			$sql.= " WHERE ".implode(' AND ', $where);

		if ($filter['limit'])
		{
			$sql .= " LIMIT ";
			if ($filter['offset'])
				$sql .= $filter['offset'] . ", ";

			$sql .= $filter['limit'];
		}
		trace::log($sql);
		$result = array();

		$db = DBFactory::GetInstance(self::$_config['db']);
		$res = $db->query($sql);
		while($row = $res->fetch_assoc())
		{
			$result[] = $row;
		}

		return $result;
	}
	
	/**
	 * Получить домен по ID
	 * @param int $id
	 * @return array - информация о домене, иначе null
	 */
	public static function GetDomain($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		$db = DBFactory::GetInstance(self::$_config['db']);

		$sql = "SELECT * FROM ".self::$_config['tables']['domains'];
		$sql.= " WHERE `ID` = ".$id;
		
		if (($res = $db->query($sql)) === false)
			return null;

		return $res->fetch_assoc();
	}

	/**
	 * Обновить информацию о домене по первичному ключу
	 * @param int $id
	 * @param array  - обязательные ключи 'Name', 'Domain', 'Type'. Если домен пользовательский, то необходим ObjectID
	 * @return bool
	 */
	public static function UpdateDomainById($id, $data)
	{
		$id = intval($id);
		if ($id <= 0)
			return false;

		if (!isset($data['Name']) || !isset($data['Domain']) || !isset($data['Type']))
			return false;

		//Если домен пользователя, то обязательно нужен его id-шник, иначе нет привязки к пользователю
		if ($data['Type'] == self::DT_USER && !isset($data['ObjectID']))
			return false;

		$info = self::GetDomain($id);
		self::$redis->Del('type_object_'.$info['Type'].'_'.$info['ObjectID']);
		self::$redis->Del('doamin_exist_'.$info['Name'].'_'.$info['Domain']);
		self::$redis->Del('object_domains_'.$info['ObjectID'].'_'.$info['Type']);
		self::$redis->Del('doamin_forbidden_'.$info['Name'].'_'.$info['Domain']);
		self::$redis->Del('resolve_'.$info['Name'].'_'.$info['Domain']);

		$fields = array('Name', 'Domain', 'Type', 'ObjectID');

		$sql_params = array();
		foreach($data as $k => $v)
		{
			if (!in_array($k, $fields))
				continue;
			
			$sql_params[] =  "`".$k."` = '".addslashes($v)."'";
		}

		$db = DBFactory::GetInstance(self::$_config['db']);

		$sql = "UPDATE ".self::$_config['tables']['domains'];
		$sql.= " SET ".implode(', ', $sql_params);
		$sql.= " WHERE `ID` = ".$id;
		$db->query($sql);

		return true;
	}

	/**
	 * Получить следующий по порядку ObjectID для доменов типа 1 и 2
	 * @return int
	 */
	public static function GetNewObjectID()
	{
		$db = DBFactory::GetInstance(self::$_config['db']);
		$sql = "SELECT MAX(ObjectID) FROM ".self::$_config['tables']['domains']." WHERE Type IN (1,2)";
		if (($res = $db->query($sql)) === false)
			return null;

		$row = $res->fetch_row();
		return $row[0] + 1;
	}

	/**
	 * Получить список уникальных доменов 2-ого (используется в админке)
	 * @global <type> $CONFIG
	 * @return string
	 */
	public static function GetUniqueDomainsList()
	{
		$db = DBFactory::GetInstance(self::$_config['db']);
		$list = array();

		$sql = "SELECT DISTINCT Domain FROM ".self::$_config['tables']['domains'];
		$res = $db->query($sql);
		while ($row = $res->fetch_row())
			$list[$row[0]] = $row[0];

		$it = STreeMgr::Iterator(array(
			'type' => 1,
			'visible' => 1,
			'deleted' => 0
		));
		foreach ($it as $sectionid => $node)
		{
			if ($node->Name == '')
				continue;
			$list[$node->Name] = $node->Name;
		}

		$list[''] = '-- Выбрать домен --';
		asort($list);
		return $list;
	}
}

Domain::Init();
?>