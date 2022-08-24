<?

LibFactory::GetStatic('xml');
LibFactory::GetStatic('xml2');

// на полный перебор дерева уходит побольше памяти чем просто массив
// на момент тестирования 13метров против 8метров при использовании массива

// дает заметный бонус при обычной работе, затраты порядка 100 кило

// бизнеслогикой не делаю, так как требуется работа, которую бизнеслогика не даст.

// выстраивается единое дерево
class STreeSection implements ArrayAccess
{
	private static $usemcache = true;
	private static $mcache = null;
	private static $mtimeout = 586400;
	private static $initialized = false;
	// всякие кэши
	private static $cache = array(
		'bydomain' => array(), 				// кэш по домену, здесь только индексы
		'byparent' => array(), 				// кэш по родителю, здесь только индексы
		'bysection' => array(),				// полная информация по разделу
		'byparentpath' => array(),			// кэш по родителю и пути, идентификаторы разделов
		);
		
	private static $ocache = array(
		'section' => array(),				// объекты по разделам
		);
		
	public static $cfg = array(
		'tables' => array(
			'tree' 		=> 'tree',
			'headers' 	=> 'headers',
		),
	);
		
	private static $types = array(
		0 => 'folder',
		1 => 'site',
		2 => 'section',
		4 => 'gsection', // костыль, админки без раздела, заводятся руками в бд
		5 => 'namespace',
	);
	
	const TFolder = 0;
	const TSite = 1;
	const TSection = 2;
	const TGSection = 4;
	const TNamespace = 5;

	private $blocks 				= null;
	private $nodes 					= null;
	private $parentObject 			= null;
	/**
	 * только для чтения
	 */
	 
	protected $id						= null;
	protected $parentID					= null;	
	protected $name						= null;	
	protected $path						= null;
	protected $module					= null;
	protected $type						= null;
	protected $typeID					= null;
	protected $regions					= null;
	protected $isVisible				= null;
	protected $isDeleted				= null;
	protected $params					= null;
	protected $isRestricted				= null;
	protected $isTitle					= null;
	protected $isSSL					= null;
	protected $externalEncoding			= null;
	protected $order					= null;	
	protected $headerTitle				= null;
	protected $headerTitleAction		= null;
	protected $headerKeywords			= null;
	protected $headerKeywordsAction		= null;
	protected $headerDescription		= null;
	protected $headerDescriptionAction	= null;
	
	// статических конструкторов нет, будет так
	public static function Init()
	{
		if(self::$initialized === false)
		{
			if(self::$mcache === null)
			{
				LibFactory::GetStatic('cache');
				self::$mcache = new Cache();
				if(self::$usemcache === true)
					self::$mcache->Init('memcache', 'app_sections');
				else
					self::$mcache->Init('dummy', 'app_sections');
			}
			self::$initialized = true;
		}
	}

	// защищенный, создается объект статическими функциями
	// при попытке создать объект для id который есть в кэше кинит UnexpectedValueException
	protected function __construct($params = null)
	{
		if($params !== null)
		{
			if(isset(self::$ocache['section'][$id]))
				throw new UnexpectedValueException();
			
			$this->id						= intval($params['id']);
			$this->parentID					= intval($params['parent']);
			$this->name						= $params['name'];
			$this->path						= $params['path'];
			$this->module					= $params['module'];
			$this->type						= intval($params['type']);
			$this->typeID					= intval($params['t_id']);
			$this->regions					= $params['regions'];
			$this->isVisible				= $params['visible']==1?true:false;
			$this->isDeleted				= $params['deleted']==1?true:false;
			$this->params					= unserialize($params['params']);
			$this->isRestricted				= $params['restricted']==1?true:false;
			$this->isTitle					= $params['istitle']==1?true:false;
			$this->isSSL					= $params['ssl']==1?true:false;
			$this->externalEncoding			= $params['external_encoding'];
			$this->order					= intval($params['ord']);
			$this->headerTitle				= $params['header_title'];
			$this->headerTitleAction		= $params['header_title_action'];
			$this->headerKeywords			= $params['header_keywords'];
			$this->headerKeywordsAction		= $params['header_keywords_action'];
			$this->headerDescription		= $params['header_description'];
			$this->headerDescriptionAction	= $params['header_description_action'];
		}
	}
	
	public static function GetTypeByString($type)
	{
		$type = array_search($type, self::$types);
		if($type === false)
			return null;
		return $type;
	}
	
	/**
	 * создает новый раздел, пустой объект
	 */
	public static function Create($type)
	{
		if(is_string($type))
		{
			$type = array_search($type, self::$types);
			if($type === false)
				return null;
		}
		switch($type)
		{
		case 0:
			return new STreeFolder();
		case 1:
			return new STreeSite();
		case 2:
		case 4:
			return new STreeSection();
		case 5:
			return new STreeNamespace();
		}
		return null;
	}
	
	public static function CreateByID($id)
	{
		if(!is_numeric($id))
			return null;
		
		if(isset(self::$ocache['section'][$id]))
		{
			if(self::$ocache['section'][$id] === false) // не существует раздела
				return null;
			return self::$ocache['section'][$id];
		}
		if(!isset(self::$cache['bysection'][$id]))
		{
			if($id == 0)
			{
				self::$cache['bysection'][0] = array(
					'id'							=> 0,
					'parent'						=> null,
					'name'							=> '',
					'path'							=> '',
					'module'						=> '',
					'type'							=> 0,
					't_id'							=> 0,
					'regions'						=> '',
					'visible'						=> true,
					'deleted'						=> false,
					'params'						=> '',
					'restricted'					=> false,
					'istitle'						=> false,
					'ssl'							=> false,
					'external_encoding'				=> 'windows-1251',
					'ord'							=> 0,
					'header_title'					=> '',
					'header_title_action'			=> 0,
					'header_keywords'				=> '',
					'header_keywords_action'		=> '',
					'header_descripntion'			=> '',
					'header_descripntion_action'	=> '',
				);
			}
			else
			{
				self::$cache['bysection'][$id] = self::$mcache->Get('bys_'.$id);
				if(self::$cache['bysection'][$id] === false)
				{
					$db = DBFactory::GetInstance('webbazar');
					
					$sql = "SELECT * FROM ".STreeSection::$cfg['tables']['tree']." WHERE id=".$id;
					$res = $db->query($sql);
					if($row = $res->fetch_assoc())
					{
						self::$cache['bysection'][$id] = $row;
						self::$mcache->Set('bys_'.$id, self::$cache['bysection'][$id], self::$mtimeout);
					}
					else
					{
						self::$ocache['section'][$id] = false;
						return null;
					}
				}
			}
		}
		
		switch(self::$cache['bysection'][$id]['type'])
		{
		case 0:
			self::$ocache['section'][$id] = new STreeFolder(self::$cache['bysection'][$id]);
			break;
		case 1:
			self::$ocache['section'][$id] = new STreeSite(self::$cache['bysection'][$id]);
			break;
		case 2:
		case 4:
			self::$ocache['section'][$id] = new STreeSection(self::$cache['bysection'][$id]);
			break;
		case 5:
			self::$ocache['section'][$id] = new STreeNamespace(self::$cache['bysection'][$id]);
			break;
		}
		
		// чистим кэш данных, они нам уже не нужны
		unset(self::$cache['bysection'][$id]);
		
		return self::$ocache['section'][$id];
	}
	
	public static function CreateByLink($url)
	{
		$db = DBFactory::GetInstance('webbazar');
		
		$id = 0;
		if(strlen($url) > 0)
		{
			// определить по урлу
			
			
			return self::CreateByID($id);
		}
		else
			return null;
	}
	
	public static function CreateIterator($params)
	{
		// по родителю
		if(isset($params['parent']) && is_numeric($params['parent']))
		{
			if(!isset(self::$cache['byparent'][ $params['parent'] ]))
			{
				self::$cache['byparent'][ $params['parent'] ] = self::$mcache->Get('byp_'.$params['parent']);
				if(self::$cache['byparent'][ $params['parent'] ] === false)
				{
					self::$cache['byparent'][ $params['parent'] ] = array();
					$sql = "SELECT * FROM ".STreeSection::$cfg['tables']['tree']." WHERE parent=".$params['parent'];
					$res = DBFactory::GetInstance('webbazar')->query($sql);
					while($row = $res->fetch_assoc())
					{
						self::$cache['byparent'][ $params['parent'] ][] = $row['id'];
						if(!isset(self::$cache['bysection'][ $row['id'] ]))
							self::$cache['bysection'][ $row['id'] ] = $row;
					}
					self::$mcache->Set('byp_'.$params['parent'], self::$cache['byparent'][ $params['parent'] ], self::$mtimeout);
				}
			}
			return new STreeIterator(self::$cache['byparent'][ $params['parent'] ]);
		}
		return null;
	}
	public static function HasChildren($params)
	{
		// по родителю
		if(isset($params['parent']) && is_numeric($params['parent']))
		{
			if(!isset(self::$cache['byparent'][ $params['parent'] ]))
			{
				self::$cache['byparent'][ $params['parent'] ] = self::$mcache->Get('byp_'.$params['parent']);
				if(self::$cache['byparent'][ $params['parent'] ] === false)
				{
					self::$cache['byparent'][ $params['parent'] ] = array();
					$sql = "SELECT * FROM ".STreeSection::$cfg['tables']['tree']." WHERE parent=".$params['parent'];
					$res = DBFactory::GetInstance('webbazar')->query($sql);
					while($row = $res->fetch_assoc())
					{
						self::$cache['byparent'][ $params['parent'] ][] = $row['id'];
						if(!isset(self::$cache['bysection'][ $row['id'] ]))
							self::$cache['bysection'][ $row['id'] ] = $row;
					}
					self::$mcache->Set('byp_'.$params['parent'], self::$cache['byparent'][ $params['parent'] ], self::$mtimeout);
				}
			}
			// есть в кэше
			return count(self::$cache['byparent'][ $params['parent'] ]) > 0;;
		}
		
		// ошибка
		return false;
	}
	
	public static function RemoveByID($id, $strict = false)
	{
		global $OBJECTS;
		$n = STreeMgr::GetNodeByID($id);
		if($n !== null)
		{
			if($strict === true)
			{
				$sql = "DELETE FROM ".STreeSection::$cfg['tables']['tree'];
				$sql.= " WHERE id=".$id;
			}
			else
			{
				$sql = "UPDATE ".STreeSection::$cfg['tables']['tree'];
				$sql.= " SET deleted=1";
				$sql.= " WHERE id=".$id;
			}
			DBFactory::GetInstance('webbazar')->query($sql);
			unset(self::$cache['bysection'][$id]);
			unset(self::$cache['byparent'][$n->ParentID]);
			self::$mcache->Remove('bys_'.$id);
			self::$mcache->Remove('byp_'.$n->ParentID);
			
		}
	}

	public function Remove($strict = false)
	{
		global $OBJECTS;
		if($this->id !== null && $this->id != 0)
			self::RemoveByID($this->id, $strict);
	}
	
	public function Store()
	{
		global $OBJECTS;
		if($this->id == 0)
			return;
			
		// подтянем старого родителя, чтобы узнать факт изменения
		$oparent = null; // останется null для нового раздела
		$sql = "SELECT parent FROM ".STreeSection::$cfg['tables']['tree'];
		$sql.= " WHERE id=".$this->id;
		$res = DBFactory::GetInstance('webbazar')->query($sql);
		if($row = $res->fetch_assoc())
			$oparent = $row['parent'];
			
		$ps = array();
		$ps[] = "parent='".$this->parentID."'";
		$ps[] = "name='".addslashes($this->name)."'";
		$ps[] = "path='".addslashes($this->path)."'";
		$ps[] = "module='".addslashes($this->module)."'";
		$ps[] = "type='".$this->type."'";
		$ps[] = "t_id='".$this->typeID."'";
		$ps[] = "regions='".addslashes($this->regions)."'";
		$ps[] = "visible='".($this->isVisible?1:0)."'";
		$ps[] = "deleted='".($this->isDeleted?1:0)."'";
		$ps[] = "`ssl`='".($this->isSSL?1:0)."'";
		$ps[] = "istitle='".($this->isTitle?1:0)."'";
		$ps[] = "restricted='".($this->isRestricted?1:0)."'";
		if(!empty($this->params))
			$ps[] = "params='".serialize($this->params)."'";
		$ps[] = "external_encoding='".$this->externalEncoding."'";
		$ps[] = "ord='".$this->order."'";
		$ps[] = "header_title='".addslashes($this->headerTitle)."'";
		$ps[] = "header_title_action=".$this->headerTitleAction;
		$ps[] = "header_keywords='".addslashes($this->headerKeywords)."'";
		$ps[] = "header_keywords_action=".$this->headerKeywordsAction;
		$ps[] = "header_description='".addslashes($this->headerDescription)."'";
		$ps[] = "header_description_action=".$this->headerDescriptionAction;
		
		if($this->id === null)
		{
			$ps[] = "id='".$this->id."'";
			
			$sql = "INSERT INTO ".STreeSection::$cfg['tables']['tree']." SET ";
			$sql.= implode(',', $ps);
			$action = 431;
		}
		else
		{
			$sql = "UPDATE ".STreeSection::$cfg['tables']['tree']." SET ";
			$sql.= implode(',', $ps);
			$sql.= " WHERE id='".$this->id."'";
			$action = 433;
		}
		
		DBFactory::GetInstance('webbazar')->query($sql);
		
		if( $this->id === null )
		{
			$this->id = DBFactory::GetInstance('webbazar')->insert_id;
		}
		
		unset(self::$cache['bysection'][$this->id]);
		self::$mcache->Remove('bys_'.$this->id);
		// чистим по старому и новому родителю, если меняли родителя
		if($oparent != $this->parentID)
		{
			unset(self::$cache['byparent'][$this->parentID]);
			self::$mcache->Remove('byp_'.$this->parentID);
			if($oparent !== null) // на случай если было перемещение, чистим и для старого парента
			{
				unset(self::$cache['byparent'][$oparent]);
				self::$mcache->Remove('byp_'.$oparent);
			}
		}
		
	}
	
	static public function ClearMCache($type, $id)
	{
		switch($type)
		{
		case 'section':
			self::$mcache->Remove('bys_'.$id);
			break;
		case 'parent':
			self::$mcache->Remove('byp_'.$id);
			self::$mcache->Remove('bypp_'.$id);
			break;
		}
	}
	
	// использовать в случае обработки больших объемов данных
	static public function ClearCache()
	{
		unset(self::$cache['bydomain']);
		unset(self::$cache['byparent']);
		unset(self::$cache['bysection']);
		unset(self::$cache['byparentpath']);
		unset(self::$ocache['section']);
		
		self::$cache['bydomain'] = array();
		self::$cache['byparent'] = array();
		self::$cache['bysection'] = array();
		self::$cache['byparentpath'] = array();
		self::$ocache['section'] = array();
	}
	
	// воспомогательная функция для парсинга пути, кэширует блоками по паренту, сейчас их 173
	static public function GetSectionIDForParent($parent, $path)
	{
		if(!is_numeric($parent) || strlen($path) == 0)
			return null;
			
		if(!isset(self::$cache['byparentpath'][$parent]))
		{
			self::$cache['byparentpath'][$parent] = self::$mcache->Get('bypp_'.$parent);
			if(self::$cache['byparentpath'][ $parent ] === false)
			{
				$sql = "SELECT id, path FROM ".STreeSection::$cfg['tables']['tree']." WHERE parent=".$parent;
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{
					if(strpos($row['path'], 'http://') === 0)
						$row['path'] = substr($row['path'], 7);
					self::$cache['byparentpath'][$parent][$row['path']] = $row['id'];
				}
				self::$mcache->Set('bypp_'.$parent, self::$cache['byparentpath'][$parent], self::$mtimeout);
			}
		}
		
		return self::$cache['byparentpath'][$parent][$path];
	}
	
	public function __get($index)
	{
		switch($index)
		{
		// кастомные свойства
		case 'Parent':
			if($this->id == 0)
				return null;
			if($this->parentObject === null && $this->parentID > 0)
				$this->parentObject = self::CreateByID($this->parentID);
			return $this->parentObject;
		case 'Config':
			return null;
		case 'Link':
			return null;
		case 'LocalLink':
			return null;
		case 'HasChildren':
			if($this->id === null)
				return false;
			else
				return self::HasChildren(array('parent' => $this->id));
		case 'Children': // итератор
			if($this->id === null)
				return false;
			else
				return self::CreateIterator(array('parent' => $this->id));
		// свойства объекта
		case 'ID':
			return $this->id;
		case 'ParentID':
			return $this->parentID;
		case 'Name':
			return $this->name;
		case 'Path':
			return $this->path;
		case 'Module':
			return $this->module;
		case 'Type':
			return self::$types[$this->type];
		case 'TypeInt':
			return $this->type;
		case 'TypeID':
			return $this->typeID;
		case 'Regions':
			return $this->regions;
		case 'IsVisible':
			return $this->isVisible;
		case 'IsDeleted':
			return $this->isDeleted;
		case 'Params':
			return $this->params;
		case 'IsRestricted':
			return $this->isRestricted;
		case 'IsTitle':
			return $this->isTitle;
		case 'IsSSL':
			return $this->ssl;
		case 'ExternalEncoding':
			return $this->externalEncoding;
		case 'Order':
			return $this->order;
		case 'HeaderTitle':
			return $this->headerTitle;
		case 'HeaderTitleAction':
			return $this->headerTitleAction;
		case 'HeaderKeywords':
			return $this->headerKeywords;
		case 'HeaderKeywordsAction':
			return $this->headerKeywordsAction;
		case 'HeaderDescription':
			return $this->headerDescription;
		case 'HeaderDescriptionAction':
			return $this->headerDescriptionAction;
		default:
			return null;
		}
	}
	
	public function __set($index, $value)
	{
		switch($index)
		{
		case 'ParentID':
			if($this->parentID != $value)
			{
				$this->parentID = $value;
				$this->parentObject = null;
			}
			break;
		case 'Name':
			$this->name = $value;
			break;
		case 'Path':
			$this->path = $value;
			break;
		case 'Module':
			$this->module = $value;
			break;
		case 'Type':
			$key = array_search(self::$types, $value);
			if($key !== false)
				$this->type = $key;
			break;
		case 'TypeInt':
			$this->type = $value;
			break;
		case 'TypeID':
			$this->typeID = $value;
			break;
		case 'Regions':
			$this->regions = $value;
			break;
		case 'IsVisible':
			$this->isVisible = $value;
			break;
		case 'IsDeleted':
			$this->isDeleted = $value;
			break;
		case 'Params':
			$this->params = $value;
			break;
		case 'IsRestricted':
			$this->isRestricted = $value;
			break;
		case 'IsTitle':
			$this->isTitle = $value;
			break;
		case 'IsSSL':
			$this->ssl = $value;
			break;
		case 'ExternalEncoding':
			$this->externalEncoding = $value;
			break;
		case 'Order':
			$this->order = $value;
			break;
		case 'HeaderTitle':
			$this->headerTitle = $value;
			break;
		case 'HeaderTitleAction':
			$this->headerTitleAction = $value;
			break;
		case 'HeaderKeywords':
			$this->headerKeywords = $value;
			break;
		case 'HeaderKeywordsAction':
			$this->headerKeywordsAction = $value;
			break;
		case 'HeaderDescription':
			$this->headerDescription = $value;
			break;
		case 'HeaderDescriptionAction':
			$this->headerDescriptionAction = $value;
			break;
		}
	}
	
	public function ToArray()
	{
		return array(
			'id' => $this->id,
			'parent' => $this->parentID,
			'name' => $this->name,
			'path' => $this->path,
			'module' => $this->module,
			'type' => $this->type,
			't_id' => $this->typeID,
			'regions' => $this->regions,
			'visible' => $this->isVisible?1:0,
			'deleted' => $this->isDeleted?1:0,
			'params' => $this->params,
			'restricted' => $this->isRestricted?1:0,
			'istitle' => $this->isTitle?1:0,
			'ssl' => $this->isSSL?1:0,
			'external_encoding' => $this->externalEncoding,
			'ord' => $this->order,
			'header_title' => $this->headerTitle,
			'header_title_action' => $this->headerTitleAction,
			'header_keywords' => $this->headerKeywords,
			'header_keywords_action' => $this->headerKeywordsAction,
			'header_description' => $this->headerDescription,
			'header_description_action' => $this->headerDescriptionAction,
		);			
	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		switch($offset)
		{
		case 'id':
		case 'parent':
		case 'name':
		case 'path':
		case 'module':
		case 'type':
		case 't_id':
		case 'regions':
		case 'visible':
		case 'deleted':
		case 'params':
		case 'restricted':
		case 'istitle':
		case 'ssl':
		case 'external_encoding':
		case 'ord':
		case 'header_title':
		case 'header_action':
		case 'header_keywords':
		case 'header_keywords_action':
		case 'header_description':
		case 'header_description_action':
			return true;
		default:
			return false;
		}
	}
	
	public function offsetGet($offset)
	{
		switch($offset)
		{
		case 'id':
			return $this->id;
		case 'parent':
			return $this->parentID;
		case 'name':
			return $this->name;
		case 'path':
			return $this->path;
		case 'module':
			return $this->module;
		case 'type':
			return $this->type;
		case 't_id':
			return $this->typeID;
		case 'regions':
			return $this->regions;
		case 'visible':
			return $this->isVisible?1:0;
		case 'deleted':
			return $this->isDeleted?1:0;
		case 'params':
			return $this->params;
		case 'restricted':
			return $this->isRestricted?1:0;
		case 'istitle':
			return $this->isTitle?1:0;
		case 'ssl':
			return $this->ssl?1:0;
		case 'external_encoding':
			return $this->externalEncoding;
		case 'ord':
			return $this->order;
		case 'header_title':
			return $this->headerTitle;
		case 'header_title_action':
			return $this->headerTitleAction;
		case 'header_keywords':
			return $this->headerKeywords;
		case 'header_keywords_action':
			return $this->headerKeywordsAction;
		case 'header_description':
			return $this->headerDescription;
		case 'header_description_action':
			return $this->headerDescriptionAction;
		default:
			return null;
		}
	}
	
	// не реализованы, изменение объекта невозможно
	public function offsetSet($offset, $value)
	{
	} 
	
	public function offsetUnset($offset)
	{
	}
}

STreeSection::Init();
LibFactory::GetMStatic('patterns', 'querydataiterator');

class STreeCustomIterator extends Patterns_QueryDataIterator
{
	private $params;
	public function __construct($params = array())
	{
		$this->params = $params;
		parent::__construct();
	}
	
	public function getdata()
	{
		$where = array();
		
		$sql = "SELECT id FROM ".STreeSection::$cfg['tables']['tree'];
		
		if(isset($this->params['parent']))
			$where[] = 'parent='.intval($this->params['parent']);
		if(isset($this->params['name']))
			$where[] = "name='".addslashes($this->params['name'])."'";
		if(isset($this->params['path']))
			$where[] = "path='".addslashes($this->params['path'])."'";
		if(isset($this->params['module']))
		{
			if ( is_array($this->params['module']) )
				$where[] = "module in ('". implode('\',\'', $this->params['module']) ."')";
			else
				$where[] = "module='". addslashes($this->params['module']) ."'";
		}
		if(isset($this->params['type']))
		{
			if(!is_numeric($this->params['type']))
				$where[] = 'type='.STreeSection::GetTypeByString($this->params['type']);
			else
				$where[] = 'type='.intval($this->params['type']);
		}
		if(isset($this->params['regions']))
			$where[] = 'regions='.intval($this->params['regions']);
		if(isset($this->params['visible']))
			$where[] = 'visible='.($this->params['visible']?1:0);
		if(isset($this->params['deleted']))
			$where[] = 'deleted='.($this->params['deleted']?1:0);
		if(isset($this->params['params']))
			$where[] = "params='".addslashes($this->params['params'])."'";
		if(isset($this->params['restricted']))
			$where[] = 'restricted='.($this->params['restricted']?1:0);
		if(isset($this->params['istitle']))
			$where[] = 'istitle='.($this->params['istitle']?1:0);
		if(isset($this->params['ssl']))
			$where[] = 'ssl='.($this->params['ssl']?1:0);
		if(isset($this->params['external_encoding']))
			$where[] = "external_encoding='".addslashes($this->params['external_encoding'])."'";
		if(isset($this->params['ord']))
			$where[] = 'ord='.intval($this->params['ord']);
		if(isset($this->params['header_title']))
			$where[] = "header_title='".addslashes($this->params['header_title'])."'";
		if(isset($this->params['header_title_action']))
			$where[] = "header_title_action=".intval($this->params['header_title_action']);
		if(isset($this->params['header_keywords']))
			$where[] = "header_keywords='".addslashes($this->params['header_keywords'])."'";
		if(isset($this->params['header_keywords_action']))
			$where[] = "header_keywords_action=".intval($this->params['header_keywords_action']);
		if(isset($this->params['header_description']))
			$where[] = "header_description='".addslashes($this->params['header_description'])."'";
		if(isset($this->params['header_description_action']))
			$where[] = "header_description_action=".intval($this->params['header_description_action']);
			
		$orderby = 'name';
		$orderdir = 'asc';
		
		if(isset($this->params['order']))
			$orderby = $this->params['order'];
			
		if(isset($this->params['dir']))
			$orderdir = $this->params['dir'];

		if(isset($this->params['sql']))			// сделано из чтобы не реализовывать всякие хитрые условия
			$sql.= " WHERE ".$this->params['sql'];
		elseif(count($where) > 0)
			$sql.= " WHERE ".implode(' AND ', $where);
			
		$sql.= " ORDER BY ".$orderby." ".$orderdir;

		$res = DBFactory::GetInstance('webbazar')->query($sql);
		while($row = $res->fetch_assoc())
		{
			$this->data[$row['id']] = $row['id'];
		}
	}
	
	public function getobject($data)
	{
		return STreeSection::CreateByID($data);
	}
}

class STreeIterator implements RecursiveIterator
{
	private $index = null;
	public function __construct($index)
	{
		$this->index = $index;
	}
	
	public function hasChildren()
	{	
		return STreeSection::CreateByID(current($this->index))->HasChildren;
    }

    public function getChildren()
	{	
		return STreeSection::CreateIterator(array('parent' => current($this->index)));
    }
	
	public function current ()
	{
		if($this->index !== null)
		{
			return STreeSection::CreateByID(current($this->index));
		}
		return null;	
	}
	
	public function key () 
	{
		if($this->index !== null)
			return current($this->index);
		return null;	
	}
	
	public function next () 
	{
		if($this->index !== null)
			return next($this->index) !== false;
		return null;	
	}
	
	public function rewind () 
	{
		if($this->index !== null)
			return reset($this->index);
		return null;
	}
	
	public function valid () 
	{
		if($this->index !== null)
			return current($this->index) !== false;
		return false;
	}
}

class STreeFolder extends STreeSection
{
}

class STreeSite extends STreeSection
{
}

class STreeNamespace extends STreeSection
{
}

class STreeMgr
{
	protected static $usemcache = true;
	protected static $mcache = null;
	protected static $mtimeout = 300;
	protected static $initialized = false;
	protected static $cache = array();
	
	public static function Init()
	{
		if(self::$initialized === false)
		{
			if(self::$mcache === null)
			{
				LibFactory::GetStatic('cache');
				self::$mcache = new Cache();
				if(self::$usemcache === true)
					self::$mcache->Init('memcache', 'app_smgr');
				else
					self::$mcache->Init('dummy', 'app_smgr');
			}
			self::$initialized = true;
		}
	}
	
	static protected function Token($url, $delimiter = '/')
	{
		$pos = strpos($url, $delimiter);
		if($pos === false)
			return array($url, '');

		return array(substr($url, 0, $pos), substr($url, $pos + 1));
	}
	
	static function GetNamespaceBySectionID($id, $params = array())
	{
		if(isset(self::$cache['namespaceobjs'][$id]))
			return self::$cache['namespaceobjs'][$id];

		$nid = self::GetNamespaceIDBySectionID($id);		
		if($nid === null)
			return null;
		
		$ns = NamespaceMgr::GetInstance()->GetNamespace(self::GetNodeByID($nid)->Module, $params);
		if($ns !== null)
			self::$cache['namespaceobjs'][$id] = $ns;

		return $ns;
	}

	static function GetNamespaceIDBySectionID($id)
	{
		$sid = $id;
		if(isset(self::$cache['namespaces'][$sid]))
			return self::$cache['namespaces'][$sid];
			
		$el = self::GetNodeByID($id);		
		while($el != NULL)
		{
			if ($el->TypeInt == 5)
			{	
				self::$cache['namespaces'][$sid] = $el->ID;
				return self::$cache['namespaces'][$sid];
			}
			$el = $el->Parent;
		}
		return null;
	}

	static function GetSectionIDByLink($url)
	{
		$info = self::GetSectionInfoByLink($url);
		return $info['sectionid'];
	}
	
	static public function GetNamespaceIDByLink($url)
	{
		if(strpos($url, 'http://') === 0)
		{
			if(preg_match('@^http:\/\/[\w\._\-\@]+\/([\w\/\.\-_\@]+)@', $url, $matches))
			{
				$path = $matches[1];

				return self::GetNamespaceIDByPath($path);
			}
		}
		else
			return self::GetNamespaceIDByPath($url);
	}
	
	static function GetNamespaceIDByPath($path)
	{
		// смотрим namespace сначала
		list($token, $url) = self::Token($path);
		return self::GetNamespaceIDByTreePath($path);
	}
	
	static function GetSectionInfoByLink($url)
	{
		if(strpos($url, 'http://') === 0)
		{
			if(preg_match('@^http:\/\/([\w\._\-\@]+)\/([\w\/\.\-_\@]+)@', $url, $matches))
			{
				$host = $matches[1];
				$path = $matches[2];

				$info = self::GetSectionInfoByPath(self::GetSiteIDByHost($host), $path);
			}
			else
			{				
				return array('ns' => null, 'nsid' => 0, 'nsname' => '', 'nsparams' => array(), 'sectionid' => 0, 'params' => array());
			}
		}
		else
		{
			$host = $_SERVER['HTTP_HOST'];
			if(strpos($host, 'www.') === 0)
				$host = substr($host, 4);
			if(strpos($host, 'dvp.') === 0)
				$host = substr($host, 4);

			if(strpos($url, '/') == 0)
				$url = substr($url, 1);

			$info = self::GetSectionInfoByPath(self::GetSiteIDByHost($host), $url);
		}
		return $info;
	}
	
	static public function GetSectionInfoByPath($site, $path)
	{
		$sectionid = 0;

		// отрежем ведущий слеш
		if(strpos($path, '/') === 0)
			$path = substr($path, 1);

		// смотрим namespace сначала
		list($token, $url) = self::Token($path);

		$sn = self::GetNamespaceIDByTreePath($token);
		if($sn === null)
		{
			$nsname = 'site';
			$url = $path;
			$sn = self::GetNamespaceIDByTreePath($nsname);
		}
		else
		{
			$node = self::GetNodeByID($sn);
			
			$nsname = $node->Module;
			
			if ($node->ID == 11868 || $node->ID == 11869 )
			{
				$nsname = "subsection";
				echo 1;	
				$url = $path;
			}
		}
		$ns = NamespaceMgr::GetInstance()->GetNamespace($nsname);
		if($ns !== null)
		{
			$nid = $sn;
			list($sectionid, $nparams, $params) = $ns->ParseLink($site, $path);
			
			$n = self::GetNodeByID($sectionid);
			if($n->IsDeleted === true)
			{
				$ns = null;
				$nid = 0;
				$url = '';
				$sectionid = 0;
				$nparams = array();
			}
		}
		else
		{
			$nid = 0;
			$url = '';
			$sectionid = 0;
			$nparams = array();
		}

		return array('ns' => $ns, 'nsid' => $nid, 'nsname' => $nsname, 'nsparams' => $nparams, 'sectionid' => $sectionid, 'params' => $params);
	}
	
	static function GetSectionIDByPath($site, $path)
	{
		$info = self::GetSectionInfoByPath($site, $path);
		return $info['sectionid'];
	}
	
	static function GetLinkBySectionId($sectionid = 0, $params = array(), $withdomain = true)
	{
		$link = false;
		$ns = self::GetNamespaceBySectionID($sectionid, $params);
		
		if($ns !== null)
			$link = $ns->GetLink($sectionid, $params, $withdomain);

		if($link === false)
		{
			Data::e_backtrace("Can't find link by sectiond; sectionid='".$sectionid."'");
			return false;
		}

		return $link;
	}
	
	static public function GetSiteTitleIDByRegion($region)
	{
		if(!isset(self::$cache['site_title']))
		{
			self::$cache['site_title'] = self::$mcache->Get('site_title');
			if(self::$cache['site_title'] === false)
			{
				self::$cache['site_title'] = array();
				$sql = "SELECT id,regions FROM ".STreeSection::$cfg['tables']['tree']." WHERE ord=1 AND type=1";
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{
					self::$cache['site_title'][intval($row['regions'])] = $row['id'];
				}
				self::$mcache->Set('site_title', self::$cache['site_title'], self::$mtimeout);
			}
		}
		if(!isset(self::$cache['site_title'][$region]))
		{
			//Data::e_backtrace("Can't find site title by region; region='".$region."'");
			return null;
		}
		else
			return self::$cache['site_title'][$region];
	}
	
	static public function GetNamespaceIDByTreePath($path)
	{
		if(!isset(self::$cache['namespace_path']))
		{
			self::$cache['namespace_path'] = self::$mcache->Get('namespace_path');
			if(self::$cache['namespace_path'] === false)
			{
				self::$cache = array();
				$sql = "SELECT id,path FROM ".STreeSection::$cfg['tables']['tree']." WHERE type=5";
				
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{
					self::$cache['namespace_path'][$row['path']] = $row['id'];
				}
				self::$mcache->Set('namespace_path', self::$cache['namespace_path'], self::$mtimeout);
			}
		}
		if(!isset(self::$cache['namespace_path'][$path]))
			return null;
		else
			return self::$cache['namespace_path'][$path];
	}
	
	static public function GetSiteIDByHost($host)
	{
		$ckey = 'host_siteid';
			
		if(!isset(self::$cache[$ckey]))
		{
			self::$cache[$ckey] = self::$mcache->Get($ckey);
			if(self::$cache[$ckey] === false)
			{
				self::$cache[$ckey] = array();
				$sql = "SELECT id,path FROM ".STreeSection::$cfg['tables']['tree']." WHERE type=1";
				
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{				
					if(strpos($row['path'], 'http://') === 0)
						$row['path'] = substr($row['path'], 7);
					
					self::$cache[$ckey][$row['path']] = $row['id'];					
				}
				self::$mcache->Set($ckey, self::$cache[$ckey], self::$mtimeout);
			}
		}
		
		if(!isset(self::$cache[$ckey][$host]))
		{
			return null;
		}
		else
			return self::$cache[$ckey][$host];
	}
	
	static public function GetSectionIDByTreePath($siteid, $path)
	{
		if(!is_numeric($siteid))
			return null;
			
		$ckey = 'siteid_path';
			
		if(!isset(self::$cache[$ckey][$siteid]))
		{
			self::$cache[$ckey][$siteid] = self::$mcache->Get($ckey.$siteid);
			if(self::$cache[$ckey][$siteid] === false)
			{
				self::$cache[$ckey][$siteid] = array();
				$sql = "SELECT id,path FROM ".STreeSection::$cfg['tables']['tree']." WHERE parent=".$siteid;
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{
					self::$cache[$ckey][$siteid][$row['path']] = $row['id'];
				}
				self::$mcache->Set($ckey.$siteid, self::$cache[$ckey][$siteid], self::$mtimeout);
			}
		}
		if(isset(self::$cache[$ckey][$siteid][$path]))
			return self::$cache[$ckey][$siteid][$path];
		else
			return null;
	}
	
	static public function GetSiteInfo($siteid)
	{
	// Не работает!
	// Попытался использовать 27.10.2010
	// http://redmine.www.d.rugion.ru/issues/3971
/*
		if(!is_numeric($siteid))
			return null;
		if(!isset(self::$cache['sites']))
		{
			self::$cache['sites'] = self::$mcache->Get('sites');
			if(self::$cache['sites'] === false)
			{
				self::$cache['sites'] = array();
				$sql = "SELECT * FROM site";
				$res = DBFactory::GetInstance('webbazar')->query($sql);
				while($row = $res->fetch_assoc())
				{
					self::$cache['sites'][$row['id']] = $row;
				}
				self::$mcache->Set('sites', self::$cache['sites'], self::$mtimeout);
			}
		}
		if(isset(self::$cache['sites'][$siteid]))
			return self::$cache['sites'][$siteid];
		else
			return null;
*/			
	}

	static public function Iterator($params = array())
	{
		return new STreeCustomIterator($params);
	}
	
	static public function GetNodeByID($id)
	{
		return STreeSection::CreateByID($id);
	}

	static public function GetNodeByLink($url)
	{
		return STreeSection::CreateByLink($url);
	}
	
	static public function ClearCache()
	{
		STreeSection::ClearCache();
		STreeSite::ClearCache();
		unset(self::$cache);
	}
	
	static public function GetSectionIDForParent($parent, $path)
	{
		return STreeSection::GetSectionIDForParent($parent, $path);
	}
}

STreeMgr::Init();

// реализация враппера, для работы в виде массива
// по [] выдает элемент STreeSection, свойства отдает уже сам STreeSection
// изменения в базе не сохраняются
// в случае foreach по данному объекту, будет подтянуто все дерево, реализуется рекурсивным итератором
class STreeArray implements ArrayAccess, Iterator
{
	public function __construct()
	{
		$this->iterator = new RecursiveIteratorIterator(STreeSection::CreateByID(0)->Children, RecursiveIteratorIterator::SELF_FIRST);
	}
	
	// Iterator
	private $iterator = null;
	public function current ()
	{
		return $this->iterator->current();	
	}
	
	public function key () 
	{
		return $this->iterator->key();	
	}
	
	public function next () 
	{
		$res = $this->iterator->next();
		return $res;
	}
	
	public function rewind () 
	{
		return $this->iterator->rewind();
	}
	
	public function valid () 
	{
		return $this->iterator->valid();
	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		return STreeSection::CreateByID($offset) !== null;
	}
	
	public function offsetGet($offset)
	{
		return STreeSection::CreateByID($offset);
	}
	
	// не реализованы, изменение объекта невозможно
	public function offsetSet($offset, $value)
	{
	} 
	
	public function offsetUnset($offset)
	{
	}
}

// реализуем массивчики, не материться, все цивильно
// $CONFIG["site_title"]			region => id
// $CONFIG["site_namespace"]		path => id
// $CONFIG["sectionid"]				siteid/path => id
// $CONFIG["sectionid_v2"]			siteid_v2/path => id
// $CONFIG['siteid']				host => siteid
// $CONFIG['siteid_v2']				host => siteid_v2
LibFactory::GetMStatic('patterns', 'multiarray');

class MultiArrayCachable extends MultiArray
{
	protected static $usemcache = true;
	protected static $mcache = null;
	protected static $mtimeout = 300;
	protected static $initialized = false;
	
	public static function Init()
	{
		if(self::$initialized === false)
		{
			if(self::$mcache === null)
			{
				LibFactory::GetStatic('cache');
				self::$mcache = new Cache();
				if(self::$usemcache === true)
					self::$mcache->Init('memcache', 'app_sarrays');
				else
					self::$mcache->Init('dummy', 'app_sarrays');
			}
			self::$initialized = true;
		}
	}
}

MultiArrayCachable::Init();

class SSiteTitle extends MultiArrayCachable
{
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
	
	public function maGet($offset)
	{
		return STreeMgr::GetSiteTitleIDByRegion($offset[0]);
	}
}

class SSiteNamespace extends MultiArrayCachable
{
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
	
	public function maGet($offset)
	{
		return STreeMgr::GetNamespaceIDByTreePath($offset[0]);
	}
}

class SSiteIDv2 extends MultiArrayCachable
{
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
	
	public function maGet($offset)
	{
		return STreeMgr::GetSiteIDByHost($offset[0]);
	}
}

class SSectionIDv2 extends MultiArrayCachable
{
	public function __construct($layers = 2, $path = array())
	{
		parent::__construct($layers, $path);
	}
	
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
		
	public function maGet($offset)
	{
		return STreeMgr::GetSectionIDByTreePath($offset[0], $offset[1]);
	}
}

class SDB extends MultiArrayCachable
{
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
		
	public function maGet($offset)
	{
		return DBFactory::GetInfo($offset[0]);
	}
}

class SSites extends MultiArrayCachable
{
	public function maExists($offset)
	{
		return $this->maGet($offset)!==null;
	}
		
	public function maGet($offset)
	{
		return STreeMgr::GetSiteInfo($offset[0]);
	}
}