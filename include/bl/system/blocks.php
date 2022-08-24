<?
class BL_system_blocks
{
	static private $cfg = array(
			'db'			=> 'webbazar',
			'cache'			=> array(
				'use'			=> false,
				'timeout'		=> 300,
			),
			'tables'		=> array(
				'blocks'		=> 'app_blocks',
				'params'		=> 'app_blocks_params',
				'conditions'	=> 'app_blocks_cond',
				'links'			=> 'app_blocks_link',

				'backup_blocks'			=> 'app_blocks_backup',
				'backup_params'			=> 'app_blocks_params_backup',
				'backup_conditions'		=> 'app_blocks_cond_backup',
				'backup_links'			=> 'app_blocks_link_backup',
			),
		);

	static private $cache = null;

	static public $Types = array(
		//'chain' => 'Цепочка',
		'this' => 'Текущий раздел',
		'block' => 'Блок',
		'widget' => 'Виджет',
	);

	private $maxiterate			= 20;
	private $blocksource 		= null;
	private $pathsource 		= null;
	private $db 				= null;

	public function __construct()
	{
		LibFactory::GetStatic('cache');
		$this->db = DBFactory::GetInstance(self::$cfg['db']);
		if( self::$cache === null && self::$cfg['cache']['use'])
		{
			self::$cache = new Cache();
			self::$cache->Init('memcache', 'app_blocks');
		}
	}

	function Init($params)
	{
	}

	// экспорт структуры блоков в xml
	public function ExportToXML($sectionid, $revision = 0)
	{
		global $OBJECTS;
		// экспортилка своя, структура сложная
		$blocks = $this->GetBlocksTree($sectionid);

		$doc = new DOMDocument('1.0', 'windows-1251');
		$doc->formatOutput = true;
		$root = $doc->appendChild($doc->createElement('root'));
		$node = $doc->createElement('blocks');
		$node->setAttribute('sectionid', $sectionid);
		$root->appendChild($node);

		$this->_exportToXML($blocks, $node, $doc);

		$res = $doc->saveXML();

		$OBJECTS['log']->Log(447, $sectionid, array());

		return $res;
	}

	private function _exportToXML($blocks, $root, $doc)
	{
		if(is_array($blocks))
		{
			foreach($blocks as $block)
			{
				$node = $doc->createElement('block');

				// установим аттрибуты, только те, что не по умолчанию
				if(!empty($block['BlockKey']))
					$node->setAttribute('key', $block['BlockKey']);
				if(!empty($block['BlockSectionID']))
					$node->setAttribute('blocksectionid', $block['BlockSectionID']);
				if(!empty($block['Type']))
					$node->setAttribute('type', $block['Type']);
				if(!empty($block['Name']))
					$node->setAttribute('name', $block['Name']);
				if(!empty($block['Template']))
					$node->setAttribute('template', $block['Template']);
				if(!empty($block['Cache']))
					$node->setAttribute('iscache', $block['Cache']?'true':'false');
				if(!empty($block['Lifetime']))
					$node->setAttribute('lifetime', $block['Lifetime']);
				if(!empty($block['IsRand']))
					$node->setAttribute('isrand', $block['IsRand']?'true':'false');
				if(!empty($block['Cnt']))
					$node->setAttribute('count', $block['Cnt']);
				if(!empty($block['IsLast']))
					$node->setAttribute('islast', $block['IsLast']?'true':'false');
				if(!empty($block['IsVisible']))
					$node->setAttribute('isvisible', $block['IsVisible']?'true':'false');

				// параметры
				if(is_array($block['params']) && count($block['params']) > 0)
				{
					$pnode = $doc->createElement('params');
					$node->appendChild($pnode);
					XML2::BuildXML($doc, $pnode, $block['params'], 'param');
				}

				// связи
				if(is_array($block['links']) && count($block['links']) > 0)
				{
					$lnode = $doc->createElement('links');
					$node->appendChild($lnode);
					foreach($block['links'] as $link)
					{
						$ln = $doc->createElement('link');
						$ln->setAttribute('opleft', $link['OpLeft']);
						$ln->setAttribute('opright', $link['OpRight']);
						$lnode->appendChild($ln);
					}
				}

				// условия
				if(is_array($block['conditions']) && count($block['conditions']) > 0)
				{
					$cnode = $doc->createElement('conditions');
					$node->appendChild($cnode);
					foreach($block['conditions'] as $condition)
					{
						$cn = $doc->createElement('condition');
						$cn->setAttribute('opleft', $condition['OpLeft']);
						$cn->setAttribute('opright', $condition['OpRight']);
						$cn->setAttribute('condition', $condition['Condition']);
						$cnode->appendChild($cn);
					}
				}

				if(is_array($block['children']) && count($block['children']) > 0)
				{
					$cnode = $doc->createElement('children');
					$node->appendChild($cnode);
					$this->_exportToXML($block['children'], $cnode, $doc);
				}

				$root->appendChild($node);
			}
		}
	}

	// импорт из xml
	public function ImportFromXML($xml, $backup = true)
	{
		global $OBJECTS;
		$data = $this->ImportFromXMLToArray($xml);
		if($data === null)
			return false;

		if($backup === true)
			$this->BackupSection($data['sectionid']);
		// удаляем всю структуру блоков раздела
		$this->DeleteBlocksForSection($data['sectionid'], false);

		// теперь надо все в бд закинуть с генерацией новых идентификаторов и установкой порядка сортировки
		$this->_importToDB($data['sectionid'], $data['items']);

		$OBJECTS['log']->Log(446, $data['sectionid'], array());

		return true;
	}

	private function _importToDB($sectionid, $data, $parentid = 0)
	{
		$ord = 1;
		foreach($data as $block)
		{
			$block['SectionID'] = $sectionid;
			$block['ParentID'] = $parentid;
			$block['Ord'] = $ord;
			$ord++;
			$id = $this->SaveBlock($block, false);
			if(is_array($block['children']) && count($block['children']) > 0)
				$this->_importToDB($sectionid, $block['children'], $id);
		}
	}

	// вернет массив
	public function ImportFromXMLToArray($xml)
	{
		$sh = $this->GetParseHelper();

		if(XML2::FromXML($xml, array('blocks' => $sh)) === false)
			return null;

		return $sh->GetItems();
	}

	public function GetParseHelper()
	{
		return new BlocksXMLParserProvider();
	}

	public function DeleteBlocksForSection($sectionid, $backup = true)
	{
		if($backup === true)
			$this->BackupSection($sectionid);

		$sql = "DELETE FROM app_blocks_cond as c USING app_blocks as b";
		$sql.= " WHERE b.SectionID=".$sectionid." AND c.BlockID=b.BlockID";
		$this->db->query($sql);

		$sql = "DELETE FROM app_blocks_link as c USING app_blocks as b";
		$sql.= " WHERE b.SectionID=".$sectionid." AND c.BlockID=b.BlockID";
		$this->db->query($sql);

		$sql = "DELETE FROM app_blocks_params as c USING app_blocks as b";
		$sql.= " WHERE b.SectionID=".$sectionid." AND c.BlockID=b.BlockID";
		$this->db->query($sql);

		$sql = "DELETE FROM app_blocks WHERE SectionID=".$sectionid;
		$this->db->query($sql);
	}

	// загрузка блока
	public function LoadBlock($blockid, $revision = 0)
	{
		if ( $revision == 0 && self::$cache != null )
		{
			$block = self::$cache->Get('block|'.$blockid);
			if ( $block !== false)
				return $block;
		}

		$block = array();

		if ( $revision == 0)
			$sql = "SELECT * FROM ". self::$cfg['tables']['blocks'];
		else
			$sql = "SELECT * FROM ". self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = '". $blockid ."'";
		if ( $revision != 0 )
			$sql.= " AND Revision = ".$revision;
		$sql.= " ORDER BY Ord";

		$res = $this->db->query($sql);
		if ( $res === false || $res->num_rows == 0)
			return null;

		$block = $res->fetch_assoc();

		// загрузка условий и связей
		$block['conditions'] = $this->GetConditions($blockid, $revision);
		$block['links'] = $this->GetLinks($blockid, $revision);
		$block['params'] = $this->GetParams($blockid, $revision);
		
		// загрузка id-шников детей
		$sql = "SELECT BlockID FROM ". self::$cfg['tables']['blocks'];
		$sql.= " WHERE ParentID = ". $block['BlockID'];
		$sql.= " ORDER BY Ord";

		$res = $this->db->query($sql);
		if ( $res !== false && $res->num_rows > 0 )
		{
			$block['children'] = array();
			while ( list($childid) = $res->fetch_row() )
				$block['children'][] = $childid;
		}

		if ( $revision == 0 && self::$cache != null )
			self::$cache->Set('block|'.$blockid, $block, self::$cfg['cache']['timeout']);

		return $block;
	}

	/**
		загрузка id блоков по sectionid
		список id блоков кэшируется
	*/
	public function GetBlocksBySectionId($sectionid, $root = false)
	{
		if ( !is_numeric($sectionid) )
			return null;

		$key = 'section';
		if($root === true)
			$key = 'sectionr';

		$block_ids = false;
		if ( self::$cache != null )
			$block_ids = self::$cache->Get($key.'|'. $sectionid);

		if ( $block_ids === false )
		{
			$sql = "SELECT `BlockID`, `ParentID`, `Ord` FROM ". self::$cfg['tables']['blocks'];
			$sql.= " WHERE `SectionID` = ". intval($sectionid);
			if ( $root === true )
				$sql.= " AND `ParentID` = 0";
			$sql.= " ORDER BY Ord";
			$res = $this->db->query($sql);

			if ( $res === false )
				return null;

			$block_ids = array();
			while ( list($blockid) = $res->fetch_row() )
				$block_ids[] = $blockid;

			if ( self::$cache != null )
				self::$cache->Set($key.'|'. $sectionid, $blocks, self::$cfg['cache']['timeout']);
		}

		return $block_ids;
	}

	/**
		Загружает блок и всех его потомков
	*/
	public function LoadBlockRecursive($blockid, $key='', $level = 0)
	{
		if ( !is_numeric($blockid) )
			return false;

		$block = $this->LoadBlock($blockid);
		$block['Level'] = $level;
		$block['RecursiveBlockKey'] = ($key ? $key.'/' : '') . $block['BlockKey'];
		$children = array();

		// загружаем детей
		if ( is_array($block['children']) )
		{
			foreach ( $block['children'] as $childid )
			{
				$child = $this->LoadBlockRecursive($childid, $block['RecursiveBlockKey'], $level + 1);
				$children[] = $child;
			}
		}

		$block['children'] = $children;

		return $block;
	}

	/**
		Получение полного дерева блоков для раздела
	*/
	public function GetBlocksTree($sectionid, $blockkey = '')
	{
		LibFactory::GetStatic('sections');

		// собираем блоки
		$blocks = array();
		$blockids = $this->GetBlocksBySectionId($sectionid, true);
		foreach ( $blockids as $blockid )
			$blocks[] = $this->LoadBlockRecursive($blockid, $blockkey);

		return $blocks;
	}

	public function GetParams($blockid, $revision)
	{
		$params = array();

		if ( $revision == 0)
			$sql = "SELECT * FROM ". self::$cfg['tables']['params'];
		else
			$sql = "SELECT * FROM ". self::$cfg['tables']['backup_params'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision != 0 )
			$sql.= " AND Revision = ".$revision;

		$res = $this->db->query($sql);
		if ( $res === false )
			return array();

		while ( $row = $res->fetch_assoc() )
		{
			if ( $row['Value'] === 'true' )
				$row['Value'] = true;
			elseif ( $row['Value'] === 'false' )
				$row['Value'] = false;

			$params[$row['Name']] = $row['Value'];
		}

		LibFactory::GetStatic('uarray');

		$params = UArray::FromLinear($params);

		return $params;
	}

	public function GetConditions($blockid, $revision)
	{
		$conditions = array();

		if ( $revision == 0)
			$sql = "SELECT `OpLeft`, `OpRight`, `Condition` FROM ". self::$cfg['tables']['conditions'];
		else
			$sql = "SELECT `OpLeft`, `OpRight`, `Condition` FROM ". self::$cfg['tables']['backup_conditions'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision != 0 )
			$sql.= " AND Revision = ".$revision;

		$res = $this->db->query($sql);
		if ( $res === false )
			return array();

		while ( $row = $res->fetch_assoc() )
			$conditions[] = $row;

		return $conditions;
	}

	public function GetLinks($blockid, $revision)
	{
		$links = array();

		if ( $revision == 0)
			$sql = "SELECT `OpLeft`, `OpRight` FROM ". self::$cfg['tables']['links'];
		else
			$sql = "SELECT `OpLeft`, `OpRight` FROM ". self::$cfg['tables']['backup_links'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision != 0 )
			$sql.= " AND Revision = ".$revision;

		$res = $this->db->query($sql);
		if ( $res === false )
			return array();

		while ( $row = $res->fetch_assoc() )
			$links[] = $row;

		return $links;
	}

	// создание блока
	public function GetNewBlock()
	{
		return array();
	}

	// по разделам, идентификаторы блоков при востановлении переназначаются
	public function BackupSection($sectionid)
	{
	}

	public function RestoreSection($sectionid, $revision)
	{
	}

	// сохранение блока
	public function SaveBlock($block, $backup = true)
	{
		global $OBJECTS;
		if ( $backup === true )
			$this->Backup($block['BlockID']);

		LibFactory::GetStatic('uarray');

		if ( $block['SectionID'] == 0 || strlen($block['BlockKey']) == 0 || strlen($block['Type']) == 0 )
			return null;

		$isnew = ($block['BlockID'] == 0);

		if ( $block['BlockID'] == 0 )
			$sql = "INSERT INTO ". self::$cfg['tables']['blocks'] ." SET ";
		else
			$sql = "UPDATE ". self::$cfg['tables']['blocks'] ." SET ";
		$sql.= " ParentID = ". $block['ParentID'] .", ";
		$sql.= " SectionID = ". $block['SectionID'] .", ";
		$sql.= " BlockKey = '". addslashes($block['BlockKey']) ."', ";
		$sql.= " Type = '". $block['Type'] ."', ";
		$sql.= " BlockSectionID = '". $block['BlockSectionID'] ."', ";
		$sql.= " Name = '". addslashes($block['Name']) ."', ";
		$sql.= " Template = '". addslashes($block['Template']) ."', ";
		$sql.= " Cache = ". intval($block['Cache']) .", ";
		$sql.= " Lifetime = ". intval($block['Lifetime']) .", ";
		$sql.= " IsRand = ". intval($block['IsRand']) .", ";
		$sql.= " Cnt = ". intval($block['Cnt']) .", ";
		$sql.= " IsLast = ". intval($block['IsLast']) .", ";
		$sql.= " IsVisible = ". (isset($block['IsVisible']) ? intval($block['IsVisible']) : '1');
		if ( isset($block['Ord']) )
			$sql.= ", Ord = ". $block['Ord'];
		if ( $block['BlockID'] > 0 )
			$sql.= " WHERE BlockID = ". $block['BlockID'];

		if ( ($res = $this->db->query($sql)) === false )
			return null;

		if ( $block['BlockID'] == 0 )
			$block['BlockID'] = $this->db->insert_id;

		// сохраняем параметры
		LibFactory::GetStatic('uarray');
		if ( is_array($block['params']) ) // на кой тут был count, чтобы удалить нельзя было?
		{
			if ($block['Type'] == 'widget') {

				$params = $block['params'];
				UArray::ksortRecursive($params);
				
				unset($params['cacheid']);
				$block['params']['cacheid'] = md5($block['Name'].'|'.serialize($params));
				if (is_array($block['params']['env'])) {

					foreach($block['params']['env'] as &$v)
						$v = strtolower($v);
				}
			}
		
			$params = UArray::ToLinear($block['params']);

			$sql = "DELETE FROM ". self::$cfg['tables']['params'];
			$sql.= " WHERE BlockID = ". $block['BlockID'];
			$this->db->query($sql);

			foreach ( $params as $k => $v )
			{
				if ( is_bool($v) )
					$v = $v ? 'true' : 'false';
				$sql = "INSERT INTO ".self::$cfg['tables']['params'] ." SET ";
				$sql.= " BlockID = '". $block['BlockID'] ."',";
				$sql.= " Name = '". addslashes($k) ."',";
				$sql.= " Value = '". addslashes($v) ."'";
				$this->db->query($sql);
			}
		}

		// сохраняем условия
		if ( is_array($block['conditions']) ) // на кой тут был count, чтобы удалить нельзя было?
		{
			$sql = "DELETE FROM ". self::$cfg['tables']['conditions'];
			$sql.= " WHERE BlockID = ". $block['BlockID'];

			$this->db->query($sql);

			foreach ( $block['conditions'] as $condition )
			{
				if ( is_bool($v) )
					$v = $v ? 'true' : 'false';
				$sql = "INSERT INTO ". self::$cfg['tables']['conditions'] ." SET ";
				$sql.= " `BlockID` = ". $block['BlockID'] .",";
				$sql.= " `OpLeft` = '". addslashes($condition['OpLeft']) ."',";
				$sql.= " `OpRight` = '". addslashes($condition['OpRight']) ."',";
				$sql.= " `Condition` = '". addslashes($condition['Condition']) ."'";
				$this->db->query($sql);
			}
		}

		// сохраняем связи
		if ( is_array($block['links']) ) // на кой тут был count, чтобы удалить нельзя было?
		{
			$sql = "DELETE FROM ". self::$cfg['tables']['links'];
			$sql.= " WHERE BlockID = ". $block['BlockID'];
			$this->db->query($sql);

			foreach ( $block['links'] as $link )
			{
				if ( is_bool($v) )
					$v = $v ? 'true' : 'false';
				$sql = "INSERT INTO ". self::$cfg['tables']['links'] ." SET ";
				$sql.= " `BlockID` = ". $block['BlockID'] .",";
				$sql.= " `OpLeft` = '". addslashes($link['OpLeft']) ."',";
				$sql.= " `OpRight` = '". addslashes($link['OpRight']) ."'";
				$this->db->query($sql);
			}
		}

		if($isnew == 0)
			$action = 443;
		else
			$action = 445;
		$OBJECTS['log']->Log($action, $block['BlockID'], array());

		if ( self::$cache != null && $block['BlockID'] > 0 )
		{
			self::$cache->Remove('block|'.$block['BlockID']);
		}

		return $block['BlockID'];
	}

	// изменение порядка следования блока
	public function ReorderBlock($blockid, $dir, $backup = true)
	{
		if ( $backup === true )
			$this->Backup($blockid);

		$block = $this->LoadBlock($blockid);

		$sql = "SELECT BlockID, Ord FROM ". self::$cfg['tables']['blocks'];
		$sql.= " WHERE SectionID = ". $block['SectionID'] ." AND ParentID = ". $block['ParentID'];
		$sql.= " ORDER BY Ord";
		$res = $this->db->query($sql);
		if ( $res === false )
			return false;

		$blocks = array();
		$n = 0;
		for ( $i=0; $i<$res->num_rows; $i++ )
		{
			$row = $res->fetch_assoc();
			$blocks[] = $row;
			if ( $row['BlockID'] == $blockid )
				$n = $i;
		}

		if ( $dir < 0 && $n > 0 )
		{
			$__b = $blocks[$n-1];
			$blocks[$n-1] = $blocks[$n];
			$blocks[$n] = $__b;

			$sql = "UPDATE ". self::$cfg['tables']['blocks'] ." SET";
			$sql.= " Ord = ". ($n-1);
			$sql.= " WHERE BlockID = ". $blocks[$n-1]['BlockID'];
			$this->db->query($sql);
		}
		if ( $dir > 0 && $n < $res->num_rows - 1 )
		{
			$__b = $blocks[$n+1];
			$blocks[$n+1] = $blocks[$n];
			$blocks[$n] = $__b;

			$sql = "UPDATE ". self::$cfg['tables']['blocks'] ." SET";
			$sql.= " Ord = ". ($n+1);
			$sql.= " WHERE BlockID = ". $blocks[$n+1]['BlockID'];
			$this->db->query($sql);
		}
		$sql = "UPDATE ". self::$cfg['tables']['blocks'] ." SET";
		$sql.= " Ord = ". $n;
		$sql.= " WHERE BlockID = ". $blocks[$n]['BlockID'];
		$this->db->query($sql);

		return true;
	}

	// создание резервной копии
	public function Backup($blockid)
	{
		global $OBJECTS;
		if ( !is_numeric($blockid) || $blockid == 0 )
			return null;

		$rev = 0;
		$sql = "SELECT max(Revision) FROM ". self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		$sql.= " GROUP BY BlockID";
		$res = $this->db->query($sql);
		if ( $res === false )
			return null;

		if ($row = $res->fetch_row() )
			$rev = $row[0];

		$rev++;

		$sql = "SELECT BlockID FROM ". self::$cfg['tables']['blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		$res = $this->db->query($sql);
		if ( $res === false || $res->num_rows == 0 )
			return null;

		$sql = "INSERT IGNORE INTO ". self::$cfg['tables']['backup_blocks'];
		$sql.= " (BlockID, ParentID, SectionID, BlockKey, Type, BlockSectionID, Name, Template, Cache, Lifetime, IsRand, Cnt, IsLast, IsVisible, Ord, Date, Revision)";
		$sql.= " SELECT BlockID, ParentID, SectionID, BlockKey, Type, BlockSectionID, Name, Template, Cache, Lifetime, IsRand, Cnt, IsLast, IsVisible, Ord, NOW(), ". $rev ." FROM ".self::$cfg['tables']['blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// скопировать параметры
		$sql = "INSERT IGNORE INTO ". self::$cfg['tables']['backup_params'];
		$sql.= " (BlockID, Name, Value, Date, Revision)";
		$sql.= " SELECT BlockID, Name, Value, NOW(), ". $rev ." FROM ".self::$cfg['tables']['params'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// скопировать условия
		$sql = "INSERT IGNORE INTO ". self::$cfg['tables']['backup_conditions'];
		$sql.= " (BlockID, OpLeft, OpRight, `Condition`, Date, Revision)";
		$sql.= " SELECT BlockID, OpLeft, OpRight, `Condition`,  NOW(), ". $rev ." FROM ".self::$cfg['tables']['conditions'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// скопировать связи
		$sql = "INSERT IGNORE INTO ". self::$cfg['tables']['backup_links'];
		$sql.= " (BlockID, OpLeft, OpRight, Date, Revision)";
		$sql.= " SELECT BlockID, OpLeft, OpRight, NOW(),". $rev ." FROM ".self::$cfg['tables']['links'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		$OBJECTS['log']->Log(451, $blockid, array('revision' => $rev));

		return $rev;
	}

	// востановление резервной копии, если ревизия не указана, будет востановлена последняя
	public function Restore($blockid, $revision = 0)
	{
		global $OBJECTS;
		if ( !is_numeric($blockid) )
			return null;

		$rev = 0;
		$sql = "SELECT max(Revision) FROM ".self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision > 0 )
			$sql.= " AND Revision = ". $revision;
		$sql.= " GROUP BY BlockID";
		$res = $this->db->query($sql);
		if ( $row = $res->fetch_row() )
			$rev = $row[0];
		else
			return null;		// нет резервной копии

		// удалим старые данные для блока
		$sql = "DELETE FROM ". self::$cfg['tables']['blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// удалим старые параметры
		$sql = "DELETE FROM ". self::$cfg['tables']['params'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// удалим старые условия
		$sql = "DELETE FROM ". self::$cfg['tables']['conditions'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// удалим старые связи
		$sql = "DELETE FROM ". self::$cfg['tables']['links'];
		$sql.= " WHERE BlockID = ". $blockid;
		$this->db->query($sql);

		// востановим ревизию
		$sql = "INSERT INTO ".self::$cfg['tables']['blocks'];
		$sql.= " (BlockID, ParentID, SectionID, BlockKey, Type, BlockSectionID, Name, Template, Cache, Lifetime, IsRand, Cnt, IsLast, IsVisible, Ord)";
		$sql.= " SELECT BlockID, ParentID, SectionID, BlockKey, Type, BlockSectionID, Name, Template, Cache, Lifetime, IsRand, Cnt, IsLast, IsVisible, Ord FROM ". self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		$sql.= " AND Revision = ". $rev;
		$this->db->query($sql);

		// восстановим параметры
		$sql = "INSERT INTO ".self::$cfg['tables']['params'];
		$sql.= " (BlockID, Name, Value )";
		$sql.= " SELECT BlockID, Name, Value FROM ". self::$cfg['tables']['backup_params'];
		$sql.= " WHERE BlockID = ". $blockid;
		$sql.= " AND Revision = ". $rev;
		$this->db->query($sql);

		// восстановим условия
		$sql = "INSERT INTO ".self::$cfg['tables']['conditions'];
		$sql.= " (BlockID, OpLeft, OpRight, `Condition`)";
		$sql.= " SELECT BlockID, OpLeft, OpRight, `Condition` FROM ". self::$cfg['tables']['backup_conditions'];
		$sql.= " WHERE BlockID = ". $blockid;
		$sql.= " AND Revision = ". $rev;
		$this->db->query($sql);

		// восстановим связи
		$sql = "INSERT INTO ".self::$cfg['tables']['links'];
		$sql.= " (BlockID, OpLeft, OpRight)";
		$sql.= " SELECT BlockID, OpLeft, OpRight FROM ". self::$cfg['tables']['backup_links'];
		$sql.= " WHERE BlockID = ". $blockid;
		$sql.= " AND Revision = ". $rev;
		$this->db->query($sql);

		$OBJECTS['log']->Log(450, $blockid, array('revision' => $rev));

		if( self::$cache != null )
		{
			self::$cache->Remove('block|'.$blockid);
		}

		return $rev;
	}

	// если не указать ревизию, удалит все
	public function RemoveBackup($blockid, $revision = 0)
	{
		global $OBJECTS;
		if ( !is_numeric(blockid) )
			return false;

		$revision = intval($revision);

		$sql = "DELETE FROM ". self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision > 0 )
			$sql.= " AND Revision = ". $revision;
		$this->db->query($sql);

		$sql = "DELETE FROM ". self::$cfg['tables']['backup_params'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision > 0 )
			$sql.= " AND Revision = ". $revision;
		$this->db->query($sql);

		$sql = "DELETE FROM ". self::$cfg['tables']['backup_conditions'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision > 0 )
			$sql.= " AND Revision = ". $revision;
		$this->db->query($sql);

		$sql = "DELETE FROM ". self::$cfg['tables']['backup_links'];
		$sql.= " WHERE BlockID = ". $blockid;
		if ( $revision > 0 )
			$sql.= " AND Revision = ". $revision;
		$this->db->query($sql);

		$OBJECTS['log']->Log(452, $blockid, array('revision' => $rev));

		return true;
	}

	// чистка старых ревизий
	// 2 условия
	// 1 возраст 1 месяц
	// 2 20 штук && возраст 1 день
	public function ClearOldBackups()
	{
		// возраст 1 месяц
		$sql = "SELECT * FROM ".self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE";
		$sql.= " Date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$this->db->query($sql);

		$sql = "SELECT * FROM ".self::$cfg['tables']['backup_params'];
		$sql.= " WHERE";
		$sql.= " Date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$this->db->query($sql);

		$sql = "SELECT * FROM ".self::$cfg['tables']['backup_conditions'];
		$sql.= " WHERE";
		$sql.= " Date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$this->db->query($sql);

		$sql = "SELECT * FROM ".self::$cfg['tables']['backup_links'];
		$sql.= " WHERE";
		$sql.= " Date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$this->db->query($sql);

		// 20 штук && возраст 1 день
		// берем кол-во
		$sql = "SELECT BlockID, count(DISTINCT Revision) FROM ".self::$cfg['tables']['backup_blocks'];
		$sql.= " GROUP BY BlockID";
		$res = $this->db->query($sql);
		while($row = $res->fetch_row())
		{
			if ( $row[1] > 20 )
			{
				// если больше 20, берем 20й или возрастом больше 1 дня
				$sql = "SELECT BlockID, Revision, TIMESTAMPDIFF(HOUR, Date,NOW()) as Diff FROM ".self::$cfg['tables']['backup_blocks'];
				$sql.= " WHERE BlockID = '". $row[0] ."'";
				$sql.= " GROUP BY BlockID, Revision";
				$sql.= " ORDER BY Revision DESC";
				$res2 = $this->db->query($sql);
				// если есть, удаляем все что старше его
				$cnt = 1;
				while ( $row2 = $res2->fetch_assoc() )
				{
					if ( $row2['Diff'] >= 24 && $cnt > 20 )
					{
						$sql = "DELETE FROM ". self::$cfg['tables']['backup_blocks'];
						$sql.= " WHERE BlockID = '". $row2['BlockID'] ."'";
						$sql.= " AND Revision <= ".$row2['Revision'];
						$this->db->query($sql);

						$sql = "DELETE FROM ". self::$cfg['tables']['backup_params'];
						$sql.= " WHERE BlockID = '". $row2['BlockID'] ."'";
						$sql.= " AND Revision <= ".$row2['Revision'];
						$this->db->query($sql);

						$sql = "DELETE FROM ". self::$cfg['tables']['backup_conditions'];
						$sql.= " WHERE BlockID = '". $row2['BlockID'] ."'";
						$sql.= " AND Revision <= ".$row2['Revision'];
						$this->db->query($sql);

						$sql = "DELETE FROM ". self::$cfg['tables']['backup_links'];
						$sql.= " WHERE BlockID = '". $row2['BlockID'] ."'";
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
	public function GetBackupRevisions($blockid)
	{
		if ( !is_numeric($blockid) || $blockid == 0 )
			return null;

		$revs = array();

		$sql = "SELECT Revision, Date FROM ". self::$cfg['tables']['backup_blocks'];
		$sql.= " WHERE BlockID = '". $blockid ."'";
		$sql.= " GROUP BY Revision";
		$sql.= " ORDER BY Date DESC";
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$revs[] = array('blockid' => $blockid, 'revision' => $row['Revision'], 'date' => $row['Date']);

		return $revs;
	}

	function GetBlockSource()
	{
		if($this->blocksource === null)
		{
			$this->blocksource = new Source_system_block_BlockSource($this);
		}
		return $this->blocksource;
	}

}


class Source_system_block_BlockSource implements Source_ISourceCountable, Source_ISourceCustom, Source_ISourceData,
	Source_ISourceFilterable, Source_ISourceIterator, Source_ISourceLimitable, Source_ISourceSortable
{
	private $db				= null;
	private $data			= null;
	private $sectionid		= 0;
	private $count 			= null;

	private $field			= null;
	private $order			= null;

	private $start			= null;
	private $limit			= null;

	private $baseurl		= '';
	private $baseparams		= '';

	private $bl				= null;

	public function __construct($bl)
	{
		$this->bl = $bl;
	}

	public function fill()
	{
		if ( $this->data === null )
			$this->fillcache();

		return $this->data;
	}

	public function count()
	{
		if ( $this->count === null )
			$this->fillcache();

		return $this->count;
	}

	private function fillcache()
	{
		$this->data = array();
		$this->count = 0;

		$blocks = array();

		if ( $this->sectionid > 0 )
		{
			$it = BlockFactory::GetIterator($this->sectionid, false);
			foreach ( $it as $block )
				$blocks[] = $block;
		}

		// и на кой тут этот костыль, глядеть LoadBlockRecursive переменная $level
		/*if ( is_array($blocks) && count($blocks) )
		{
			$level = 0;
			$parents = array();
			foreach ( $blocks as $block )
			{
				$this->count++;

				if ( $block['ParentID'] != $parents[0] )
				{
					if ( in_array($block['ParentID'],$parents) )
						$parents = array_slice($parents, array_search($block['ParentID'],$parents));
					else
						array_unshift($parents,$block['ParentID']);

					$level = count($parents) - 1;
				}
				$block['Level'] = $level;

				$this->data[$block['BlockID']] = $block;
			}
		}*/

		if ( $this->limit !== null && $this->start !== null )
			$this->data = array_slice($blocks, $this->start, $this->limit, true);
	}

	private function resetcache()
	{
		$this->count = null;
		$this->data = null;
	}

	public function current()
	{
		if ( !isset($this->data) )
			$this->fill();

		if ( !isset($this->data) )
			return null;

        return current($this->data);
	}

	public function key()
	{
		if ( !isset($this->data) )
			$this->fill();

		if ( isset($this->data) )
			return key($this->data);

		return null;
	}

	public function next ()
	{
		if ( !isset($this->data) )
			$this->fill();

		if ( isset($this->data) )
			return next($this->data) !== false;

		return null;
	}

	public function rewind ()
	{
		if ( !isset($this->data) )
			$this->fill();

		if ( isset($this->data) )
			return reset($this->data);

		return null;
	}

	public function valid ()
	{
		if ( !isset($this->data) )
			$this->fill();

		if ( isset($this->data) )
			return current($this->data) !== false;

		return null;
	}

	public function setsort($field, $order)
	{
		if ( is_string($field) && is_string($order) )
		{
			$this->resetcache();

			$this->field = $field;
			$this->order = $order;
		}
	}

	public function setlimit($start, $count)
	{
		if ( is_numeric($start) && is_numeric($count) )
		{
			$this->resetcache();

			$this->start = $start;
			$this->limit = $count;
		}
	}

	public function setfilter($field, $rule, $mask)
	{
	}

	public function setparam($param, $value)
	{
		$param = strtolower($param);
		switch ($param)
		{
			case 'sectionid':
				if ( is_numeric($value) )
				{
					$this->resetcache();
					$this->sectionid = $value;
				}
				break;
			case 'baseurl':
				if ( is_string($value) )
					$this->baseurl = $value;
				break;
			case 'baseparams':
				if ( is_string($value) )
					$this->baseparams = $value;
				break;
		}
	}
}


class BlockFactory
{
	private static $comparers = array();

	private static $bl = null;

	static function GetInstance($blockid, $parentkey = null)
	{
		if ( self::$bl === null )
			self::$bl = BLFactory::GetInstance('system/blocks');

		$block = self::$bl->LoadBlock($blockid);

		return new ProxyBlock($block, $parentkey);
	}

	static function GetIterator($sectionid, $blockkey = '')
	{
		if ( !is_numeric($sectionid) )
			return null;

		if ( self::$bl === null )
			self::$bl = BLFactory::GetInstance('system/blocks');

		$blocks = self::$bl->GetBlocksTree($sectionid, $blockkey);

		return new RecursiveIteratorIterator(
				new BlockRecursiveIterator($blocks), RecursiveIteratorIterator::SELF_FIRST
			);
	}

	static function GetRootBlocks($sectionid)
	{
		if ( !is_numeric($sectionid) )
			return null;

		if ( self::$bl === null )
			self::$bl = BLFactory::GetInstance('system/blocks');

		return self::$bl->GetBlocksBySectionId($sectionid, true);
	}
}



class BlockRecursiveIterator implements RecursiveIterator
{
	protected $chain = array();
	protected $last = false;
	protected $prev = null;

	public function __construct($chain)
	{
		$this->chain = $chain;
	}

	public function getChildren()
	{
		$el = current($this->chain);
		return new BlockRecursiveIterator($el['children']);
	}

	public function hasChildren()
	{
		$el = current($this->chain);
		return is_array($el['children']) && count($el['children']) > 0;
	}

	public function current()
	{
		if ( $this->last === true )
			return false;

		$el = current($this->chain);
		if ( $el === false )
			return false;

		return $el;
	}

	public function key()
	{
		if ( $this->last === true )
			return false;
		return key($this->chain);
	}

	public function next()
	{
		if ( $this->prev !== null )
			$this->last = true;

		if ( $this->last === true )
			return false;

		$this->prev = $el;
		next($this->chain);
	}

	public function rewind()
	{
		$this->last = false;
		$this->prev = null;
		reset($this->chain);
	}

	public function valid()
	{
		if ( $this->last === true )
			return false;
		$el = current($this->chain);
		return $el !== false;
	}
}


class ProxyBlock
{
	private $block = null;

	static $objects = array();

	function __construct($block, $parentkey = null)
	{
		$this->block = $block;
		if($parentkey === null)
			$this->block['RecursiveBlockKey'] = $block['BlockKey'];
		else
			$this->block['RecursiveBlockKey'] = $parentkey.'/'.$block['BlockKey'];
	}

	public function Action()
	{
		global $OBJECTS;

		if ( $this->block['Type'] == 'this' )
		{
			if ( App::$Global['engine_no_action'] !== true )
			{
				self::$objects[$this->block['RecursiveBlockKey']] = ModuleFactory::GetModuleAction();
				if ( self::$objects[$this->block['RecursiveBlockKey']] !== null )
					return self::$objects[$this->block['RecursiveBlockKey']]->Action(App::$CurrentEnv['params']);
			}
		}
		/*elseif ( $this->block['Type'] == 'block' )
		{
			// 2do: С этим ключом непонятка: $this->block['post']
			if ( $this->block['post'] && $this->block['BlockSectionId'] != 0 )
			{
				self::$objects[$this->block['BlockKey']] = ModuleFactory::GetInstance($id, $this->block['params']);
			}
		}*/

		return false;
	}


	public function GetBlock($params)
	{
		global $OBJECTS;

		$html = "";

		if ( isset($this->block['params']) )
			$params = array_merge($this->block['params'], $params);

		$oldsectionid = App::$User->SectionID;

		switch ( $this->block['Type'] )
		{
			case 'this':
				$module_action = ModuleFactory::GetModuleAction();
				if ( ModuleFactory::IsSectionAllow($module_action->Env['sectionid']) !== true )
				{
					$html = "";
				}
				else
				{
					$OBJECTS['user']->SectionID = $module_action->Env['sectionid'];
					$OBJECTS['log']->SetSectionID($module_action->Env['sectionid']);
					$html = $module_action->GetBlock($this->block['Name'], $this->block['Template'], $this->block['Lifetime'], $params);
				}
				break;
			case 'block':
				if( !is_numeric($this->block['BlockSectionID']) || $this->block['BlockSectionID'] <= 0)
				{
					// детей может и не быть
					if ( isset($this->block['Template']) )
					{
						$html = STPL::Fetch($this->block['Template'], $params);
					}
					elseif(is_array($params['children']) && count($params['children']) > 0)
					{
						$html = implode(' ',$params['children']);
					}
					else
						$html = '';
				}
				elseif ( ModuleFactory::IsSectionAllow($this->block['BlockSectionID']) !== true )
				{
					$html = "";
				}
				else
				{
					App::$User->SectionID = $this->block['BlockSectionID'];
					$OBJECTS['log']->SetSectionID($this->block['BlockSectionID']);
					$m = ModuleFactory::GetInstance($this->block['BlockSectionID'], $params);
					if($m === null)
						$html = '';
					else
						$html = $m->GetBlock($this->block['Name'], $this->block['Template'], $this->block['Lifetime'], $params);
				}
				break;
			case 'widget':
				LibFactory::GetStatic('container');
				if($this->block['params']['method'] == 'ssi')
					$html = Container::GetWidgetInstance($this->block['Name'], null, $params, Container::SSI);
				else if($this->block['params']['method'] == 'sync')
					$html = Container::GetWidgetInstance($this->block['Name'], null, $params, Container::HTML);
				else
					$html = Container::GetWidgetInstance($this->block['Name'], null, $params);

				break;
		}

		App::$User->SectionID = $oldsectionid;
		$OBJECTS['log']->SetSectionID($oldsectionid);

		return $html;
	}

	public function Render()
	{
		LibFactory::GetMStatic('bl/system','providers');

		// проверка условий
		if ( count($this->block['conditions']) > 0 )
		{
			foreach ( $this->block['conditions'] as $condition )
			{
				list($name,$key) = explode(':', $condition['OpLeft'], 2);
				$OpLeft = BL_system_ProviderFactory::GetProvider($name)->GetValue($key);

				list($name,$key) = explode(':', $condition['OpRight'], 2);
				$OpRight = BL_system_ProviderFactory::GetProvider($name)->GetValue($key);

				if ( BL_system_ProviderFactory::GetCompareProvider($condition['Condition'])->Compare($OpLeft, $OpRight) === false )
					return "";
			}
		}

		$this->Action();

		// отработка связей
		if ( count($this->block['links']) > 0 )
		{
			foreach ( $this->block['links'] as $link )
			{
				list($name,$key) = explode(':', $link['OpRight'], 2);
				list($name2,$key2) = explode(':', $link['OpLeft'], 2);
				if($name2 == 'this')
				{
					$provider = BL_system_ProviderFactory::GetProvider($name);
					if($provider !== null)
						$this->block['params'][$key2] = $provider->GetValue($key);
				}
			}
		}

		// обработка детей
		if ( $this->block['IsRand'] )
			shuffle($this->block['children']);

		$children = array();
		if(isset($this->block['children']) && is_array($this->block['children']))
		{
			foreach ( $this->block['children'] as $blockid )
			{
				$child = BlockFactory::GetInstance($blockid, $this->block['RecursiveBlockKey']);

				$html = $child->Render();
				if ( strlen($html) > 0 )
					$children[$child->block['BlockKey']] = $html;
				if ( $child->block['IsLast'] )
					break;
			}
		}

		return $this->GetBlock( array('children' => $children) );
	}
}

// закидывает в массив все блоки, в древовидном виде
class BlocksXMLParserProvider implements IXMLParserProvider
{
	protected $items = array();
	protected $sectionid;
	public function Parse($doc, $node)
	{
		$this->sectionid = $node->getAttribute('sectionid');

		$blocks = $this->ParseNode($doc, $node);

		$this->items = $blocks;
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

			if($n->nodeType != XML_ELEMENT_NODE && $n->nodeName != 'block')
				continue;

			$block = array();
			// свойства
			$block['BlockKey']		= $this->GetAttributeValue($n, 'key', '');
			$block['BlockSectionID']= $this->GetAttributeValue($n, 'blocksectionid', 0);
			$block['Type']			= $this->GetAttributeValue($n, 'type', 0);
			$block['Name']			= $this->GetAttributeValue($n, 'name', '');
			$block['Template']		= $this->GetAttributeValue($n, 'template', '');
			$block['Cache']			= $this->GetAttributeValue($n, 'iscache', 'false')=='true'?1:0;
			$block['Lifetime']		= $this->GetAttributeValue($n, 'lifetime', 0);
			$block['IsRand']		= $this->GetAttributeValue($n, 'isrand', 'false')=='true'?1:0;
			$block['Cnt']			= $this->GetAttributeValue($n, 'count', 0);
			$block['IsLast']		= $this->GetAttributeValue($n, 'islast', 'false')=='true'?1:0;
			$block['IsVisible']		= $this->GetAttributeValue($n, 'isvisible', 'false')=='true'?1:0;

			if($n->hasChildNodes()) // с корявым libxml есть всегда, но возможно потом не будет
			{
				for($j=0; $j < $n->childNodes->length; $j++)
				{
					$sn = $n->childNodes->item($j);
					if($sn->nodeType != XML_ELEMENT_NODE)
						continue;

					// параметры
					if($sn->nodeName == 'params')
						$block['params'] = $this->ParseParams($doc, $sn);

					// связи
					elseif($sn->nodeName == 'links')
						$block['links'] = $this->ParseLinks($doc, $sn);

					// условия
					elseif($sn->nodeName == 'conditions')
						$block['conditions'] = $this->ParseConditions($doc, $sn);

					// дети
					elseif($sn->nodeName == 'children')
						$block['children'] = $this->ParseNode($doc, $sn);
				}

			}

			//if(!$n->hasChildNodes() || $n->firstChild->nodeType != XML_ELEMENT_NODE)
			//	$block[$n->attributes->getNamedItem('name')->nodeValue] = iconv('UTF-8', 'WINDOWS-1251', $n->nodeValue);
			//else
			//	$block[$n->attributes->getNamedItem('name')->nodeValue] = $this->ParseNode($doc, $n);

			$data[] = $block;
		}

		return $data;
	}

	protected function ParseParams($doc, $node)
	{
		if(!$node->hasChildNodes())
			return null;

		$data = array();
		for($i=0; $i < $node->childNodes->length; $i++)
		{
			$n = $node->childNodes->item($i);

			if($n->nodeType != XML_ELEMENT_NODE && $n->nodeName != 'param')
				continue;

			if(!$n->hasChildNodes() || $n->firstChild->nodeType != XML_ELEMENT_NODE)
				$data[$n->attributes->getNamedItem('name')->nodeValue] = iconv('UTF-8', 'WINDOWS-1251', $n->nodeValue);
			else
				$data[$n->attributes->getNamedItem('name')->nodeValue] = self::ParseNode($doc, $n);
		}

		return $data;
	}

	protected function ParseLinks($doc, $node)
	{
		if(!$node->hasChildNodes())
			return null;

		$data = array();
		for($i=0; $i < $node->childNodes->length; $i++)
		{
			$n = $node->childNodes->item($i);

			if($n->nodeType != XML_ELEMENT_NODE && $n->nodeName != 'link')
				continue;

			$link = array();
			if(!$n->hasChildNodes() || $n->firstChild->nodeType != XML_ELEMENT_NODE)
			{
				$link['OpLeft'] = $this->GetAttributeValue($n, 'opleft', '');
				$link['OpRight'] = $this->GetAttributeValue($n, 'opright', '');
				$data[] = $link;
			}
		}

		return $data;
	}

	protected function ParseConditions($doc, $node)
	{
		if(!$node->hasChildNodes())
			return null;

		$data = array();
		for($i=0; $i < $node->childNodes->length; $i++)
		{
			$n = $node->childNodes->item($i);

			if($n->nodeType != XML_ELEMENT_NODE && $n->nodeName != 'condition')
				continue;

			$link = array();
			if(!$n->hasChildNodes() || $n->firstChild->nodeType != XML_ELEMENT_NODE)
			{
				$link['OpLeft'] = $this->GetAttributeValue($n, 'opleft', '');
				$link['OpRight'] = $this->GetAttributeValue($n, 'opright', '');
				$link['Condition'] = $this->GetAttributeValue($n, 'condition', '');
				$data[] = $link;
			}
		}

		return $data;
	}

	protected function GetAttributeValue($node, $name, $default)
	{
		$v = $node->attributes->getNamedItem($name);
		if($v === null)
			return $default;
		else
			return $v->nodeValue;
	}

	public function GetItems()
	{
		return array('items' => $this->items, 'sectionid' => $this->sectionid);
	}
}

