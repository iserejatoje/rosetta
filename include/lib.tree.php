<?

class TreeNode
{
    private $_count;
	private $_nodes;
	private $_data;
	private $_name;
	private $_parent = null;
	private $_id;
	function __construct($data = null, $name = null, $parent = null, $count = 0)
	{
		$this->_nodes = array();
		if($data != null)
			$this->_data = $data;
		if($parent != null)
			$this->_parent = $parent;
		if($name != null)
			$this->_name = $name;
        if(!empty($count))
            $this->_count = $count;
        else
            $this->_count = 0;
	}
	
	function AddTree($tree)
	{
		return $this->_AddTree($tree, false);
	}
	
	function AddTreeAssoc($tree)
	{
		return $this->_AddTree($tree, true);
	}
	
	protected function _AddTree($tree, $assoc = false)
	{
		if(!is_a($tree, 'TreeNode'))
			return false;
		if(!isset($tree->_nodes))
			return false;
		if(!is_array($tree->_nodes))
			return false;
		if($assoc === true)
		{
			foreach($tree->_nodes as $id=>$node)
				$this->_nodes[$id] = $node; 
		}
		else
		{
			foreach($tree->_nodes as $node)
				$this->_nodes[] = $node; 
		}
		return true;
	}
	
	function Add($data = null, $name = null, $count = 0)
	{
		$id = array_push($this->_nodes, new TreeNode($data, $name, $this, $count))-1;
		$this->_nodes[$id]->_id = $id;	
		return $this->_nodes[$id];
	}
	
	function AddAssoc($id, $data = null, $name = null, $count = 0)
	{
		$this->_nodes[$id] = new TreeNode($data, $name, $this, $count);
		$this->_nodes[$id]->_id = $id;
		return $this->_nodes[$id];
	}
	
	function Remove($id)
	{
		unset($this->_nodes[$id]);
	}
	
	function FindById($id, $withdesc = false, $withname = false)
	{		
		// рекурсивный поиск
		$desc = array();
		$path = '';
		$ret = $this->_findRecursiveId($this, $id, $withdesc, $withname, $desc, $path);
		if($withdesc)
			return array($ret, $desc);
		else
			return $ret;
	}
	
	private function _findRecursiveId($obj, $id, $withdesc, $withname, &$desc, &$path_)
	{
		foreach($obj->_nodes as $key => $node)
		{
			if($key == $id)
			{
				if($withname === true)
					$path_4 = $node->_name;
				else
					$path_4 = $node->_id;
				if($withdesc === true)
				{
					array_unshift($desc, array(
						'id' => &$node->_id,
						'data' => &$node->_data,
						'name' => &$node->_name,
						'path' => $path_.(!empty($path_)?'/':'').$path_4
						));
				}
				return $node;
			}
			if(count($node->Nodes) > 0)
			{
				if($withdesc === true)
				{
					if($withname === true)
						$path_4 = $node->_name;
					else
						$path_4 = $node->_id;
					$path_3 = $path_.(!empty($path_)?'/':'').$path_4;
				}
				$f = $this->_findRecursiveId($node, $id, $withdesc, $withname, $desc, $path_3);
				if($f !== false)
				{
					if($withdesc === true)
					{
						array_unshift($desc, array(
							'id' => &$node->_id,
							'data' => &$node->_data,
							'name' => &$node->_name,
							'path' => $path_.(!empty($path_)?'/':'').$path_4
							));
					}
					$path_ = $path_3;
					return $f;
				}
			}
		}
		return false;
	}
	
	function FindByName($name)
	{
		// рекурсивный поиск
		return $this->_findRecursiveName($this, $name);
	}
	
	private function _findRecursiveName($obj, $name)
	{
		foreach($obj->_nodes as $node)
		{
			if($node->_name == $name)
				return $node;
			if(count($node->_nodes) > 0)
			{
				$f = $this->_findRecursiveName($node, $name);
				if($f !== false)
					return $f;
			}
		}
		return false;
	}
	
	function PathById($path, $withdesc = false)
	{
		if(is_array($path))
			$p =& $path;
		else
		{
			if(strlen($path)==0)
				$p = array();
			else
				$p = explode('/', $path);
		}
		if(count($p)==0)
		{
			if($withdesc === true)
				return array($this, array());
			return $this;
		}
		$node = $this;
		$desc = array();
		$path_ = '';
		foreach($p as $p_)
		{
			if(!isset($node->_nodes[$p_]))
			{
				if($withdesc === true)
					return array(false, array());
				return false;
			}
			if(!empty($path_))
				$path_.='/';
			$path_.= $node->_id;
			if($withdesc === true)
				$desc[] = array(
					'id' => &$node->_id,
					'data' => &$node->_data,
					'name' => &$node->_name,
					'path' => $path_
					);
			$node = &$node->_nodes[$p_];
		}
		if($withdesc === true)
			return array($node, $desc);
		return $node;
	}
	
	function GetByName($name)
	{
		foreach($this->_nodes as $node)
			if($node->_name === $name)
				return $node;
		return false;
	}
	
	function PathByName($path, $withdesc = false)
	{
		if(is_array($path))
			$p =& $path;
		else
		{
			if(strlen($path)==0)
				$p = array();
			else
				$p = explode('/', $path);
		}
		//error_log(print_r($p,true), 1, 'danilin@info74.ru');
		if(count($p)==0)
		{
			if($withdesc === true)
				return array($this, array());
			return $this;
		}
		$node = $this;
		$desc = array();
		$path_ = '';
		foreach($p as $p_)
		{
			$node = $node->GetByName($p_);
			if($node === false)
			{
				if($withdesc === true)
					return array(false, array());
				return false;
			}
			if(!empty($path_))
				$path_.='/';
			$path_.= $node->_name;
			if($withdesc === true)
				$desc[] = array(
					'id' => &$node->_id,
					'data' => &$node->_data,
					'name' => &$node->_name,
					'path' => $path_
					);
		}
		if($withdesc === true)
			return array($node, $desc);
		return $node;
	}
	
	// возвращаем данные в одномерном массиве
	// $changelevel (true - изменение уровня (для первого уровня не задаются изменения уровня), false - указание уровня вложенности)
	function GetTreePlainData($levels = null)
	{
		return $this->_getTreePlainData($this, $levels==null?null:$levels-1, '', 0);
	}
	
	// если $level != 0, путь будет не абсолютный
	private function _getTreePlainData($node, $levels, $path, $level = 0)
	{
		$td = array();
		$td2 = array();
		foreach($node->_nodes as $k => $n)
		{
			$p = $path;
			if(!empty($p))
				$p.= '/';
			$p.= $n->_name;
			$change = '';
			if($levels === null || $level < $levels)
			{
				$td2 = $this->_getTreePlainData($n, $levels, $p, $level + 1);
				if(count($td2) > 0)
				{
					$change = 'down';
					end($td2);
					$td2[key($td2)]['change'] = 'up';
				}
			}
			$td[] = array(
				'id' => $k,
				'data' => $n->_data,
				'name' => $n->_name,
				'level' => $level,
				'change' => $change,
				'count' => $n->_count,
				'parent' => $node->Id,
				'path' => $p,
				'haschildren' => count($n->_nodes)>0?true:false
				);
			if(count($td2) > 0)
				$td = array_merge($td, $td2);				
		}
		return $td;
	}
	
	function toArray()
	{
		$nodes = array();
		foreach($this->_nodes as $node)
			$nodes[] = $node->toArray();
		return array(
			'data' => $this->_data,
			'count' => $this->_count,
			'nodes' => $nodes,
			'id' => $this->_id,
			'name' => $this->_name,
			'parent' => $this->_parent?$this->_parent->_id:0);
	}

	function Dispose()
	{
		if(!empty($this->_nodes))
		{
			foreach($this->_nodes as $node)
			{
				$node->Dispose();
				unset($node);
			}
		}
		
		unset($this->_count);
		unset($this->_nodes);
		unset($this->_data);
		unset($this->_name);
		unset($this->_parent);
		unset($this->_id);
	}
	
	function __get($id)
	{
		switch($id)
		{
		case 'Data':
			return $this->_data;
        case 'Count':
			return $this->_count;
		case 'Nodes':
			return $this->_nodes;
		case 'Parent':
			return $this->_parent;
		case 'Id':
			return $this->_id;
		case 'Name':
			return $this->_name;
		}
	}
	
	function __set($id, $value)
	{
		switch($id)
		{
		case 'Count':
		          $this->_count = $value;
			break;
		case 'Name':
			$this->_name = $value;
			break;
		case 'Data':
			$this->_data = $value;
			break;
		}
	}
	
	function __isset($id)
	{
		switch($id)
		{
		case 'Count':
		case 'Nodes':
		case 'Data':
		case 'Id':
			return true;
		case 'Parent':
			return isset($this->_parent);
		case 'Name':
			return isset($this->_name);
		default:
			return false;
		}
	}
	
	function __unset($id)
	{
		switch($id)
		{
		case 'Count':
            unset($this->_count);
			break;
		case 'Data':
			unset($this->_data);
			break;
		case 'Name':
			unset($this->_name);
			break;
		}
	}
}

class Tree extends TreeNode
{
	function __construct($data = null)
	{
		parent::__construct();
		if($data != null)
			$this->BuildTree($data);
	}
	
	/**
	 * $data id => (parent, name, data)
	 */ 
	function BuildTree($data, $parent = 0)
	{
		// строим массив c parent => id
		if(!empty($data))
			foreach($data as $id => $d)
				$tree[$d['parent']][] = $id;
			
		$this->_buildTree($this, $data, $tree, $parent);
	}
	
	private function _buildTree(&$node, &$data, &$tree, $parent)
	{
	    $count = $node->Count;
		if(!empty($tree) && array_key_exists($parent, $tree))
			foreach($tree[$parent] as $c)
			{
				$n = $node->AddAssoc($c, $data[$c]['data'], $data[$c]['name'], $data[$c]['count']);
				$count = TreeUtil::Add($count, $this->_buildTree($n, $data, $tree, $c));
			}
        $node->Count = $count;
        return $count;
	}
}

class TreeUtil
{
    function Add($first, $second)
    {
        if(empty($first) && !empty($second))
            return $second;
        else if(!empty($first) && empty($second))
            return $first;
        if(!is_array($first))
            return $first+$second;
        else
        {
            foreach($first as $k => $v)
                $first[$k] += $second[$k];
            return $first;
        }
    }
}

?>