<?
class BL_system_site
{
	private $treesitesource		= null;
	private $pathsource			= null;
	private $treecache			= null;
	private $maxiterate			= 20;
	private $baseparent			= 0;
	private $db					= null;

	function __construct()
	{
		$this->db = DBFactory::GetInstance('webbazar');
	}

	function Init($params)
	{
	}

	function ParsePath($node)
	{
		if(is_string($node))
		{
			$action = 'default';

			$node = str_replace('//', '%2F', $node);		// спасибо апачу (при использовании %2F в урле выдает 404)

			$t = explode('/', $node);

			$id = 0;
			while(count($t) > 0)
			{
				$e = urldecode(array_shift($t));
				if(strlen($e) == 0)
					continue;

				if(strpos($e, '.') === 0)
					break;

				$tid = STreeMgr::GetSectionIDForParent($id, $e);
				if(empty($tid))
					break;

				$id = $tid;
			}

			if(strpos($e, '.') === 0)
				$action = substr($e, 1);

			$path = implode('/', $t);

			return array(
				'section' => $id,
				'action' => $action,
				'path' => $path);
		}
		return null;
	}

	function GetNodeIDByPath($node)
	{
		$a = $this->ParsePath($node);
		return $a['section'];
	}

	function GetNodePathByID($id)
	{
		LibFactory::GetStatic('sections');

		if(is_numeric($id))
		{
			$path = '';

			for($i = 0; $i < $this->maxiterate; $i++)
			{
				$node = STreeMgr::GetNodeByID($id);
				if($node === null)
					return null;
				if(strlen($node->Path) > 0)
					$p = $node->Path;
				if(strpos($p, 'http://') === 0)
					$p = substr($p, 7);
				if(strlen($p) > 0)
					$path = urlencode($p).'/'.$path;
				$id = $node->ParentID;
				if($id == $this->baseparent)
					break;
			}
			$path = str_replace('%2F', '//', $path);		// спасибо апачу (при использовании %2F в урле выдает 404)
			return $path;
		}
		return null;
	}

	public function GetModules()
	{
		global $CONFIG;
		$ds = array();
		$ds[] = '';
		$it = new DirectoryIterator($CONFIG['engine_path'].'/modules');
		for($it->rewind(); $it->valid(); $it->next())
		{
			if($it->isFile())
			{
				$fn = $it->getFilename();
				$fn = substr($fn, 0, strrpos($fn, '.'));
				$ds[] = $fn;
			}
		}
		sort($ds);
		return $ds;
	}

	public function GetTypes()
	{
		return array(
			0 => 'не указан',
			1 => 'сайт',
			2 => 'модуль',
			//3 => '',
			4 => 'модуль (только админка)',
			5 => 'пространство разделов',
		);
	}

	public function GetEncodings()
	{
		$e = array(
			'',
			'windows-1251',
			'utf-8'
		);
		sort($e);
		return $e;
	}

	public function GetNode($id)
	{
		$node = STreeMgr::GetNodeByID($id);
		if($node !== null)
			return $node->ToArray();
		else
			return null;
	}

	public function GetNewNode()
	{
		return array(
			'name' => 'new_element',
			'path' => 'new_element',
			'external_encoding' => 'windows-1251'
		);
	}

	public function ReorderSection($section, $dir, $shift = 1)
	{
		if(!is_numeric($section) || !is_numeric($shift) || ($dir != 1 && $dir != -1))
			return false;

		// берем ord и parent
		$sql = "SELECT ord,parent FROM tree WHERE id=".$section;
		$res = $this->db->query($sql);
		$row = $res->fetch_assoc();
		if(!$row)
			return false;

		$parent = $row['parent'];
		$ord = $row['ord'];

		// максимум и минимум
		$sql = "SELECT min(ord),max(ord) FROM tree WHERE parent=".$parent;
		$res = $this->db->query($sql);
		$row = $res->fetch_row();
		if(!$row)
			return false;

		$min = $row[0];
		$max = $row[1];

		if($dir == 1)
		{
			if($ord + $shift > $max)
				$shift = $max - $ord;
			$sql = "UPDATE tree SET ord=ord-1 WHERE parent=".$parent." AND ord>".$ord." AND ord<=".($ord+$shift);
			$this->db->query($sql);
		}
		else
		{
			if($ord - $shift < $min)
				$shift = $ord - $min;
			$sql = "UPDATE tree SET ord=ord+1 WHERE parent=".$parent." AND ord<".$ord." AND ord>=".($ord-$shift);
			$this->db->query($sql);
		}
		$sql = "UPDATE tree SET ord=ord+(".($dir * $shift).") WHERE id=".$section;
		$this->db->query($sql);

		STreeSection::ClearCache();
		sleep(1);

		return true;
	}

	public function StoreNode($node)
	{
		global $OBJECTS;
		$sqlp = array();
		if(isset($node['name']))
			$sqlp[] = " `name`='".addslashes($node['name'])."'";
		if(isset($node['path']))
			$sqlp[] = " `path`='".addslashes($node['path'])."'";
		if(isset($node['params']))
			$sqlp[] = " `params`='".addslashes($node['params'])."'";
		if(isset($node['module']))
			$sqlp[] = " `module`='".addslashes($node['module'])."'";

		if(isset($node['regions']))
		{
			if(is_numeric($node['regions']) || empty($node['regions']))
				$sqlp[] = " `regions`='".$node['regions']."'";
			else
				return false;
		}

		if(isset($node['type']))
		{
			if(is_numeric($node['type']))
				$sqlp[] = " `type`=".$node['type'];
			else
				return false;
		}

		if(isset($node['visible']))
		{
			if(is_bool($node['visible']) || is_numeric($node['visible']))
				$sqlp[] = " `visible`=".($node['visible']?1:0);
			else
				return false;
		}

		if(isset($node['deleted']))
		{
			if(is_bool($node['deleted']) || is_numeric($node['deleted']))
				$sqlp[] = " `deleted`=".($node['deleted']?1:0);
			else
				return false;
		}

		if(isset($node['restricted']))
		{
			if(is_bool($node['restricted']) || is_numeric($node['restricted']))
				$sqlp[] = " `restricted`=".($node['restricted']?1:0);
			else
				return false;
		}

		if(isset($node['istitle']))
		{
			if(is_bool($node['istitle']) || is_numeric($node['istitle']))
				$sqlp[] = " `istitle`=".($node['istitle']?1:0);
			else
				return false;
		}

		if(isset($node['ssl']))
		{
			if(is_bool($node['ssl']) || is_numeric($node['ssl']))
				$sqlp[] = " `ssl`=".($node['ssl']?1:0);
			else
				return false;
		}

		if(isset($node['external_encoding']))
			$sqlp[] = " `external_encoding`='".addslashes($node['external_encoding'])."'";

		if(isset($node['header_title']))
			$sqlp[] = " `header_title`='".addslashes($node['header_title'])."'";
		if(isset($node['header_title_action']))
			$sqlp[] = " `header_title_action`=".intval($node['header_title_action']);
		if(isset($node['header_keywords']))
			$sqlp[] = " `header_keywords`='".addslashes($node['header_keywords'])."'";
		if(isset($node['header_keywords_action']))
			$sqlp[] = " `header_keywords_action`=".intval($node['header_keywords_action']);
		if(isset($node['header_description']))
			$sqlp[] = " `header_description`='".addslashes($node['header_description'])."'";
		if(isset($node['header_description_action']))
			$sqlp[] = " `header_description_action`=".intval($node['header_description_action']);

		if(count($sqlp) == 0)
			return true;

		if(!empty($node['id']))
		{
			$res = $this->db->query("SELECT * FROM tree WHERE id=".$node['id']);
			if($row = $res->fetch_row())
				$isnew = 0;
			else
				$isnew = 1;
		}
		else
			$isnew = 1;

		if(!$isnew)
		{
			if(isset($node['parent']))
				$parent = $node['parent']; // на будущее
			else
			{
				$res = DBFactory::GetInstance('site')->query("SELECT parent FROM tree WHERE id=".$node['id']);
				if($row = $res->fetch_assoc())
					$parent = $row['parent'];
				else
					$parent = 0;
			}
			$sql = "UPDATE tree SET ";
			$sql.= implode(',', $sqlp);
			$sql.= " WHERE id=".$node['id'];

		}
		//elseif(!empty($node['parent']))
		elseif($node['parent'] >= 0)
		{
			$parent = $node['parent'];
			$ord = 1;
			$sql = "SELECT max(ord)+1 FROM tree WHERE `parent`=".$node['parent'].' GROUP BY parent';
			$res = $this->db->query($sql);

			if($row = $res->fetch_row())
				$ord = $row[0];
			$sqlp[] = " `parent`=".$node['parent'];
			$sqlp[] = " `ord`=".$ord;
            $sqlp[] = " `t_id`= 0";  // CHANGES HERE
			$sql = "INSERT INTO tree SET ";
			$sql.= implode(',', $sqlp);

		}
		else
			return false;

		$this->db->query($sql);

		if($isnew)
		{
			$id = DBFactory::GetInstance('site')->insert_id;
		}
		STreeSection::ClearMCache('section', $node['id']);
		STreeSection::ClearMCache('parent', $parent);

		STreeSection::ClearCache();
		sleep(1);

		return true;
	}

	function GetTreeSiteSource()
	{
		if($this->treesitesource === null)
		{
			$this->treesitesource = new Source_system_site_TreeSiteSource($this);
		}
		return $this->treesitesource;
	}

	function GetPathSource()
	{
		if($this->pathsource === null)
		{
			$this->pathsource = new Source_system_site_PathSource($this);
		}
		return $this->pathsource;
	}
}

class Source_system_site_PathSource implements Source_ISourceCustom, Source_ISourceData, Source_ISourceIterator
{
	private $data			= null;
	private $baseparent		= 0;
	private $parent			= null;
	private $maxiterate		= 20;
	private $baseurl		= '';
	private $baseparams		= '';
	private $bl				= null;
	private $withlast		= false;

	public function __construct($bl)
	{
		$this->bl = $bl;
	}

	public function fill()
	{
		if(!isset($this->data))
		{
			$id = $this->parent;
			$this->data = array();

			// собираем с конфига

			$node = STreeMgr::GetNodeByID($id);
			for($i = 0; $i < $this->maxiterate; $i++)
			{
				$title = 'корень';
				if($node->Name)
					$title = $node->Name;
				if($i == 0 && $this->withlast !== true)
					$item = array(
						'title' => $title,
					);
				else
					$item = array(
						'title' => $title,
						'url' => $this->baseurl.($node!==null?$this->bl->GetNodePathByID($node->ID):'').$this->baseparams
					);

				array_unshift($this->data, $item);
				if($node === null || $node->ID == $this->baseparent)
					break;
				$node = $node->Parent;
			}
		}

		return $this->data;
	}

	public function current()
	{
		if(!isset($this->data))
			$this->fill();

		if(!isset($this->data))
			return null;

        return current($this->data);
	}

	public function key()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return key($this->data);
		return null;
	}

	public function next ()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return next($this->data) !== false;
		return null;
	}

	public function rewind ()
	{
		if(!isset($this->dat))
			$this->fill();

		if(isset($this->data))
			return reset($this->data);
		return null;
	}

	public function valid ()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return current($this->data) !== false;
		return null;
	}

	public function setparam($param, $value)
	{
		$param = strtolower($param);
		switch($param)
		{
		case 'parent':
			if(is_numeric($value))
				$this->parent = $value;
			break;
		case 'baseurl':
			if(is_string($value))
				$this->baseurl = $value;
			break;
		case 'baseparams':
			if(is_string($value))
				$this->baseparams = $value;
			break;
		case 'withlast':
			if(is_bool($value))
				$this->withlast = $value;
			break;
		}
	}
}

// источник для разделов
// не использует бд
class Source_system_site_TreeSiteSource implements Source_ISourceCountable, Source_ISourceCustom, Source_ISourceData,
	Source_ISourceFilterable, Source_ISourceIterator, Source_ISourceLimitable, Source_ISourceSortable
{
	private $db				= null;
	private $data			= null;
	private $parent			= 0;
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
		if($this->data === null)
			$this->fillcache();

		return $this->data;
	}

	public function count()
	{
		if($this->count === null)
			$this->fillcache();
		return $this->count;
	}

	private function fillcache()
	{
		$this->data = array();
		$this->count = 0;

		LibFactory::GetStatic('sections');
		$root = STreeMgr::GetNodeByID($this->parent);

		foreach($root->Children as $id => $item)
		{
			$i = $item->ToArray();

			//$i = $item;
			$this->count++;
			$i['id'] = $id;
			$i['fullpath'] = $this->baseurl.$this->bl->GetNodePathByID($id);
			$i['sitepath'] = null;

			$ninfo = STreeMgr::GetNodeByID($id);
			if( $ninfo && $sinfo->ParentID > 0 )
				$i['sitepath'] = ModuleFactory::GetLinkBySectionId($id);

			$this->data[$id] = $i;
		}
		uasort($this->data, array($this, 'usort'));
		if($this->limit !== null && $this->start !== null)
			$this->data = array_slice($this->data, $this->start, $this->limit, true);
	}

	private function resetcache()
	{
		$this->count = null;
		$this->data = null;
	}

	private function usort($a, $b)
	{
		if($this->field !== null && $this->order !== null)
		{
			if($a[$this->field] == $b[$this->field])
				return 0;
			if($this->order == 'ASC')
				return $a[$this->field] < $b[$this->field] ? -1 : 1;
			else
				return $a[$this->field] > $b[$this->field] ? -1 : 1;
		}
		return 0;
	}

	public function current()
	{
		if(!isset($this->data))
			$this->fill();

		if(!isset($this->data))
			return null;

        return current($this->data);
	}

	public function key()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return key($this->data);
		return null;
	}

	public function next ()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return next($this->data) !== false;
		return null;
	}

	public function rewind ()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return reset($this->data);
		return null;
	}

	public function valid ()
	{
		if(!isset($this->data))
			$this->fill();

		if(isset($this->data))
			return current($this->data) !== false;
		return null;
	}

	public function setsort($field, $order)
	{
		if(is_string($field) && is_string($order))
		{
			$this->resetcache();

			$this->field = $field;
			$this->order = $order;
		}
	}

	public function setlimit($start, $count)
	{
		if(is_numeric($start) && is_numeric($count))
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
		switch($param)
		{
		case 'parent':
			if(is_numeric($value))
			{
				$this->resetcache();
				$this->parent = $value;
			}
			break;
		case 'baseurl':
			if(is_string($value))
				$this->baseurl = $value;
			break;
		case 'baseparams':
			if(is_string($value))
				$this->baseparams = $value;
			break;
		}
	}
}

?>
