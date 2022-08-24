<?

LibFactory::GetStatic('xml2');

class BL_system_env
{
	static private $cfg = array(
		'db'			=> 'webbazar',
		'cache'			=> array(
			'use'			=> true,
			'timeout'		=> 86400,
		),
		'tables'		=> array(
			'env'			=> 'app_env',
			'backup'		=> 'app_env_backup',
			)
		);
	
	static private $cache = null;	
	
	private $db = null;
	private $stack = array();
	private $frames = array();	
	
	public function __construct()
	{
		LibFactory::GetStatic('cache');
		$this->db = DBFactory::GetInstance(self::$cfg['db']);
		if(self::$cache === null && self::$cfg['cache']['use'])
		{
			self::$cache = new Cache();
			self::$cache->Init('memcache', 'app_env');			
		}
	}
	
	function Init($params)
	{
	}
	
	// экспорт и иморт не равноценные операции, экспорт возвращает объедененные окружения со стека
	// импорт сохраняет по руту массив в базу
	// экспорт окружения в массив
	public function BuildArray()
	{
		if(count($this->stack) > 0)
		{
			$env = array();
			foreach($this->stack as $s)
				$env = Data::array_merge_recursive_changed($env, $s);
			return $env;
		}
		return array();
	}
	
	// импорт окружения, сохраняет в бд
	public function ImportArray($sectionid, $env)
	{
		$this->SaveEnv($sectionid, $env);
	}
	
	// загрузка окружения
	public function LoadEnv($sectionid, $revision = 0)
	{
		if(!is_numeric($sectionid))
			return null;
			
		if($revision == 0 && self::$cache !== null)
		{
			$arr = self::$cache->Get('env_'.$sectionid);
			if($arr !== false)
				return $arr;
		}
			
		$revision = intval($revision);
			
		$env = array();
		
		if($revision == 0)
			$sql = "SELECT * FROM ".self::$cfg['tables']['env'];
		else
			$sql = "SELECT * FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		if($revision != 0)
			$sql.= " AND Revision=".$revision;
		
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
		{
			if($row['Value'] === 'true')
				$row['Value'] = true;
			elseif($row['Value'] === 'false')
				$row['Value'] = false;
				
			/*if(is_numeric($row['Value']))
			{
				if(strpos($row['Value'], '.') !== false || strpos($row['Value'], 'e') !== false)
					$row['Value'] = floatval($row['Value']);
				else
					$row['Value'] = intval($row['Value']);
			}*/
			if($row['Name'] == 'cache_mode')
				$row['Value'] = intval($row['Value']);
				
			$env[$row['Name']] = $row['Value'];
		}
			
		LibFactory::GetStatic('uarray');
		$arr = UArray::FromLinear($env);
		
		if($revision == 0 && self::$cache !== null)
		{
			self::$cache->Set('env_'.$sectionid, $arr, self::$cfg['cache']['timeout']);
		}
		
		return $arr;
	}

	// загрузка тайтлов для окружения
	// 2do: от этого надо избавиться - дает не хилую нагрузку на memcache - это старый подход к окружению
	public function LoadTitles($sectionid)
	{
		if(!is_numeric($sectionid))
			return null;

		if(self::$cache !== null)
		{
			$titles = self::$cache->Get('env_t_'.$sectionid);
			if($titles !== false && is_array($titles))
				return $titles;
		}
		
		$titles = array();
		
		$node = STreeMgr::GetNodeByID($sectionid);
		if( $node === null )
			return null;
		
		// добавим тайтлы
		if($node->TypeInt == 1)
		{
			foreach($node->Children as $v)
			{
				$titles[$v->Path] = $v->Name;
			}
		}
		
		if(self::$cache !== null)
		{
			self::$cache->Set('env_t_'.$sectionid, $titles, 600);
		}
		return $titles;
	}
	
	// сохранение окружения
	public function SaveEnv($sectionid, $env, $backup = true)
	{
		global $OBJECTS;
		if(!is_numeric($sectionid) && !is_array($env))
			return false;
			
		if($backup === true)
			$this->Backup($sectionid);
			
		LibFactory::GetStatic('uarray');
		$env = UArray::ToLinear($env);
		
		$sql = "DELETE FROM ".self::$cfg['tables']['env'];
		$sql.= " WHERE SectionID=".$sectionid;
		$this->db->query($sql);
		
		foreach($env as $k => $v)
		{
			if(is_bool($v))
				$v = $v ? 'true' : 'false';
			$sql = "INSERT INTO ".self::$cfg['tables']['env'];
			$sql.= " SET";
			$sql.= " SectionID=".$sectionid.",";
			$sql.= " Name='".addslashes($k)."',";
			$sql.= " Value='".addslashes($v)."',";
			$sql.= " IsVisible=1";
			
			$this->db->query($sql);
		}
		
		if(self::$cache !== null)
		{
			self::$cache->Remove('env_'.$sectionid);
		}
			
		return true;
	}
	
	public function ExportToXML($sectionid, $revision = 0)
	{
		LibFactory::GetStatic('xml2');
		
		$env = self::LoadEnv($sectionid, $revision);
		if($env === null)
			return null;
		
		$doc = XML2::ToXML($env, false, 'env');
		if($doc === null)
			return null;
		$doc->documentElement->setAttribute('id', $sectionid);
		if($revision != 0)
			$doc->documentElement->setAttribute('revision', $revision);
		$root = $doc->createElement('root');
		
		$node = $doc->replaceChild($root, $doc->documentElement);
		$root->appendChild($node);
		
		return $doc->saveXML();
	}
	
	// вернет массив конфигов для разделов
	public function ImportFromXMLToArray($xml)
	{
		$sh = self::GetParseHelper();
		
		if(XML2::FromXML($xml, array('env' => $sh)) === false)
			return null;
		
		return $sh->GetItems();
	}
	
	public function ImportFromXML($sectionid, $xml, $backup = true)
	{
		global $OBJECTS;
		$env = self::ImportFromXMLToArray($xml);
		if(is_array($env[$sectionid]) && count($env[$sectionid]) > 0)		
		{
			self::SaveEnv($sectionid, $env[$sectionid], $backup);
		}
		else
			return false;
		return true;
	}
	
	public function GetParseHelper()
	{
		return new EnvXMLParserProvider();
	}
	
	// создание резервной копии
	public function Backup($sectionid)
	{
		global $OBJECTS;
		if(!is_numeric($sectionid))
			return null;
			
		$rev = 0;
		$sql = "SELECT max(Revision) FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		$sql.= " GROUP BY SectionID";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$rev = $row[0];
			
		$rev++;
		
		$sql = "SELECT count(*) FROM ".self::$cfg['tables']['env'];
		$sql.= " WHERE SectionID=".$sectionid;
		$res = $this->db->query($sql);
		$cnt = 0;
		if($row = $res->fetch_row())
			$cnt = $row[0];
		if($cnt == 0)
			return null;
			
		$sql = "INSERT INTO ".self::$cfg['tables']['backup'];
		$sql.= " (SectionID, Name, Value, IsVisible, Date, Revision)";
		$sql.= " SELECT SectionID, Name, Value, IsVisible, NOW(), ".$rev." FROM ".self::$cfg['tables']['env'];
		$sql.= " WHERE SectionID=".$sectionid;
		$this->db->query($sql);
		
		return $rev;
	}
	
	// востановление резервной копии, если ревизия не указана, будет востановлена последняя
	public function Restore($sectionid, $revision = 0)
	{
		global $OBJECTS;
		if(!is_numeric($sectionid))
			return false;
			
		$rev = 0;
		$sql = "SELECT max(Revision) FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		if($revision > 0)
			$sql.= " AND Revision=".$revision;
		$sql.= " GROUP BY SectionID";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$rev = $row[0];
		else
			return false;		// нет резервной копии
			
		// удалим старые данные для раздела
		$sql = "DELETE FROM ".self::$cfg['tables']['env'];
		$sql.= " WHERE SectionID=".$sectionid;
		$this->db->query($sql);
			
		// востановим ревизию
		$sql = "INSERT INTO ".self::$cfg['tables']['env'];
		$sql.= " (SectionID, Name, Value, IsVisible)";
		$sql.= " SELECT SectionID, Name, Value, IsVisible FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		$sql.= " AND Revision=".$rev;
		$this->db->query($sql);
		
		if(self::$cache != null)
		{
			self::$cache->Remove('env_'.$sectionid);
		}
		
		return $rev;
	}
	
	// если не указать ревизию, удалит все
	public function RemoveBackup($sectionid, $revision = 0)
	{
		global $OBJECTS;
		if(!is_numeric($sectionid))
			return false;
			
		$revision = intval($revision);
			
		$sql = "DELETE FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		if($revision > 0)
			$sql.= " AND Revision=".$revision;
		$this->db->query($sql);
				
		return true;
	}
	
	public function ClearMCache($id)
	{
		if(self::$cache != null)
		{
			self::$cache->Remove('env_'.$id);
		}
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
		$sql = "SELECT SectionID,count(DISTINCT Revision) FROM ".self::$cfg['tables']['backup'];
		$sql.= " GROUP BY SectionID";
		$res = $this->db->query($sql);
		while($row = $res->fetch_row())
		{
			if($row[1] > 20)
			{
				// если больше 20, берем 20й или возрастом больше 1 дня
				$sql = "SELECT SectionID, Revision, TIMESTAMPDIFF(HOUR, Date,NOW()) as Diff FROM ".self::$cfg['tables']['backup'];
				$sql.= " WHERE SectionID=".$row[0];
				$sql.= " GROUP BY SectionID, Revision";
				$sql.= " ORDER BY Revision DESC";
				$res2 = $this->db->query($sql);
				// если есть, удаляем все что старше его
				$cnt = 1;
				while($row2 = $res2->fetch_assoc())
				{
					if($row2['Diff'] >= 24 && $cnt > 20)
					{
						$sql = "DELETE FROM ".self::$cfg['tables']['backup'];
						$sql.= " WHERE SectionID=".$row2['SectionID'];
						$sql.= " AND Revision<=".$row2['Revision'];
						$this->db->query($sql);
						break;
					}
					$cnt++;
				}
			}
		}
		
	}
	
	// получить список ревизий
	public function GetBackupRevisions($sectionid)
	{
		if(!is_numeric($sectionid))
			return null;
			
		$revs = array();
			
		$sql = "SELECT Revision, Date FROM ".self::$cfg['tables']['backup'];
		$sql.= " WHERE SectionID=".$sectionid;
		$sql.= " GROUP BY Revision";
		$sql.= " ORDER BY Date DESC";
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$revs[] = array('sectionid' => $sectionid, 'revision' => $row['Revision'], 'date' => $row['Date']);
			
		return $revs;
	}
	
	// загрузка окружения для раздела
	// кэширует в memcache
	public function GetEnvForSection($sectionid, $recursive = true)
	{
		$sid = $sectionid.'_'.($recursive?'rt':'rf');
		
		if(!is_numeric($sectionid) || $sectionid == 0)
			return array();
		
		$env = null;
		$envs = array();
		
		$node = STreeMgr::GetNodeByID($sectionid);
		
		while($node->ID != 0)
		{
			$env = self::LoadEnv($node->ID);
			
			// добавим тайтлы
			// 2do: уюрать этот функционал. не использовать массив тайтлов в окружени.
			if($node->TypeInt == 1)
				$env['title'] = self::LoadTitles($node->ID);
			
			if($env !== null)
				array_unshift($envs, $env);
				//$envs[] = $env;
			
			if($recursive === true)
				$node = $node->Parent;
			else
				break;
		}
		
		$env = array();
		
		// от младшего к старшему
		//$envs = array_reverse($envs);
		if(count($envs) > 0)
		{
			$env = array();
			foreach($envs as $s)
				$env = Data::array_merge_recursive_changed($env, $s);
		}

		return $env;
	}
	
	// управоление окружением, редактирование элементов
	public function Store($index, $value)
	{
	}
	
	public function Remove($index)
	{
	}
	
	public function Get($index)
	{
		
	}

	// работа со стеком
	// стэк используется только для окружения
	// закинуть окружение на стек
	public function Push($env)
	{
		array_push($this->stack, $env);
	}
	
	// взять со стека окружение
	public function Pop()
	{
		return array_pop($this->stack);
	}
	
	// кадры стека. позволяют очистить стек от группы значений добавленных с помощью push
	// создать кадр стека
	public function CreateFrame()
	{
		array_push($this->frames, count($this->stack));
	}
	
	// удалить кадр стека
	public function RemoveFrame()
	{
		if(count($this->frames) > 0)
		{
			$this->stack = array_slice($this->stack, 0, array_pop($this->frames));
		}
	}
}

// закидывает в массив все section
class EnvXMLParserProvider implements IXMLParserProvider
{
	protected $items = array();
	public function Parse($doc, $node)
	{
		$id = $node->getAttribute('id');

		$env = self::ParseNode($doc, $node);
		
		$this->items[$id] = $env;
		return null;
	}
	
	// возвращает массив
	protected function ParseNode($doc, $node)
	{
		if(!$node->hasChildNodes())
			return null;
			
		$data = array();
		for($i=0; $i < $node->childNodes->length; $i++)
		{
			$n = $node->childNodes->item($i);
			
			if($n->nodeType != XML_ELEMENT_NODE && $n->nodeName != 'item')
				continue;
				
			if(!$n->hasChildNodes() || $n->firstChild->nodeType != XML_ELEMENT_NODE)
				$data[$n->attributes->getNamedItem('name')->nodeValue] = iconv('UTF-8', 'WINDOWS-1251', $n->nodeValue);
			else
				$data[$n->attributes->getNamedItem('name')->nodeValue] = self::ParseNode($doc, $n);
		}
		
		return $data;
	}
	
	public function GetItems()
	{
		return $this->items;
	}
}
