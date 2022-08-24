<?php

require_once ($CONFIG['engine_path'].'include/tree/nstreenode.php');
require_once ($CONFIG['engine_path'].'include/tree/nstreenodeiterator.php');

static $nstree_error_code = 0;
define('ERR_M_NSTREE_MASK', 0x00014000);

define('ERR_M_NSTREE_UNKNOWN_TABLE', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_UNKNOWN_TABLE]
	= 'Неизвестная таблица.';

define('ERR_M_NSTREE_UNKNOWN_FIELD_NAME', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_UNKNOWN_FIELD_NAME]
	= 'Неизвестное поле.';

define('ERR_M_NSTREE_TREE_NOT_FOUND', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_TREE_NOT_FOUND]
	= 'Дерево не найдено.';

define('ERR_M_NSTREE_ERROR_CLEARS', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_ERROR_CLEARS]
	= 'Очистка не удалясь.';

define('ERR_M_NSTREE_EMPTY_TREEID', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_EMPTY_TREEID]
	= 'Идетификатор не задан.';

define('ERR_M_NSTREE_UNKNOWN_ERROR', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_UNKNOWN_ERROR]
	= 'Ошибка при выполнении запроса.';

define('ERR_M_NSTREE_TREE_EXISTS', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_TREE_EXISTS]
	= 'Указан используемый идетификатор.';

define('ERR_M_NSTREE_ERROR_CREATE_NODE', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_ERROR_CREATE_NODE]
	= 'Ошибка при создании.';

define('ERR_M_NSTREE_INVALID_NODE_POSITION', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_INVALID_NODE_POSITION]
	= 'Позиция узла указана не верно.';

define('ERR_M_NSTREE_ERROR_ALLOCATE_SPACE', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_ERROR_ALLOCATE_SPACE]
	= 'Ошибка при выделении места под узел.';

define('ERR_M_NSTREE_ERROR_NAMEID_EXISTS', ERR_M_NSTREE_MASK | $nstree_error_code++);
$ERROR[ERR_M_NSTREE_ERROR_NAMEID_EXISTS]
	= 'Имя ссылки уже используется.';

class NSTreeMgr implements IDisposable {

	private $_db;
    private $_table;
    private $_id;

    private $_cache;
	private $_iscache;

	private $_nodeid	= 'nodeid';
	private $_left		= 'left';
    private $_right		= 'right';
    private $_level		= 'level';
    private $_treeid	= 'treeid';
	private $_siteid	= 'siteid';
	private $_regionid	= 'regionid';
    private $_parent	= 'parent';
    private $_uniqueid	= 'uniqueid';
	private $_icon	= 'icon';
	private $_views	= 'views';

	private $_childscount	= 'childscount';
	private $_nameid		= 'nameid';

	private $_fields		= array('nodeid', 'left','right','level','parent','treeid','siteid','regionid','childscount', 'nameid', 'icon');

	private $_Nodes = array();

	const BEFORE 	= 1;
    const AFTER 	= 2;
    const AT_BEGIN 	= 3;
    const AT_END 	= 4;

    function __construct($db, $tables, $fieldNames = array(), $caching = false) {

		if(empty($tables))
			throw new BTException('Unknown table', ERR_M_NSTREE_UNKNOWN_TABLE);

		LibFactory::GetStatic('textutil');

		$this->_db = $db;

		if (!is_array($tables))
			$this->_table['tree'] = $tables;
		else
			$this->_table = $tables;

		if(is_array($fieldNames) && sizeof($fieldNames)) {
			$fieldNames = array_change_key_case($fieldNames, CASE_LOWER);
            foreach($fieldNames as $k => $v) {

				if (!in_array($k, $this->_fields))
					throw new BTException('Unknown "'.$k.'" field name', ERR_M_NSTREE_UNKNOWN_FIELD_NAME);

                $this->{"_$k"} = strtolower($v);
			}
		}

		if ($caching === true) {
			$this->_iscache = true;
		} else
			$this->_iscache = false;

		LibFactory::GetStatic('cache');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'nstree');
    }

	public function getCache() {
		return $this->_cache;
	}

	public function IsCache() {
		return $this->_iscache;
	}

	public function setTreeId($treeId, $return_root = true) {
		if (!is_numeric($treeId))
			return false;

		$treeId = intval($treeId);

		$info = false;
		$cacheid = 'tree_'.$treeId;
		
		$sql = 'SELECT '.$this->_nodeid.','.$this->_treeid.' FROM '.$this->_table['tree'];
		$sql.= ' WHERE '.$this->_treeid.'='.$treeId.' AND '.$this->_level.' = 0';

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			throw new MyException('Tree not found', ERR_M_NSTREE_TREE_NOT_FOUND);

		$info = $res->fetch_row();			

		list($root, $this->_id) = $info;

		if ($return_root === true)
			return $this->getNode($root);

		return true;
	}

	public function getNodeByUniqueID($id) {
		if (!is_numeric($id))
			return null;

		$sql = 'SELECT `'.$this->_nodeid.'` FROM '.$this->_table['ref'];
		$sql.= ' WHERE `'.$this->_uniqueid.'` = '.$id;

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		$row = $res->fetch_row();
		return $this->getNode($row[0]);
	}

	public function getNode($nodeId) {
		if (!is_numeric($nodeId))
			return null;

		$nodeId = intval($nodeId);
		if (isset($this->_Nodes[$nodeId]))
			return $this->_Nodes[$nodeId];

		$node = false;
		
		$sql = 'SELECT * FROM '.$this->_table['tree'];
		$sql.= ' WHERE `'.$this->_nodeid.'`=\''.$nodeId.'\'';

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		$node = $res->fetch_assoc();
		
		$this->_Nodes[$nodeId] = new NSTreeNode($node, $this);
		return $this->_Nodes[$nodeId];
    }

	public function Clear() {

        if (!$this->_db->query('TRUNCATE '.$this->_table['tree']) || !$this->_db->query('DELETE FROM '.$this->_table['tree']))
			throw new BTException('Error clears', ERR_M_NSTREE_ERROR_CLEARS);
    }

	public function getTreeList() {
		$sql = 'SELECT `'.$this->_nodeid.'` FROM '.$this->_table['tree'];
		$sql.= ' WHERE `'.$this->_level.'` = 0';

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		$list = array();
		while(false != ($row = $res->fetch_row())) {
			$list[] = $row[0];
		}

		return new PNSTreeNodeIterator($list, $this);
	}

	public function createTree(array $data = array()) {
		if (!is_array($data) || !sizeof($data))
			$data = array();
		else
			$data = array_change_key_case($data, CASE_LOWER);

		$data[$this->_left] = 1;
		$data[$this->_right] = 2;
		$data[$this->_level] = 0;

		if (empty($data[$this->_treeid]))
			throw new BTException('Empty tree id', ERR_M_NSTREE_EMPTY_TREEID);

		$sql = 'SELECT * FROM '.$this->_table['tree'];
		$sql.= ' WHERE `'.$this->_treeid.'` = '.$data[$this->_treeid];

		if (false == ($res = $this->_db->query($sql)))
			throw new BTException('Query error', ERR_M_NSTREE_UNKNOWN_ERROR);

		if ($res->num_rows)
			throw new BTException('Tree "'.$data[$this->_treeid].'" is exists', ERR_M_NSTREE_TREE_EXISTS);

       return $this->Insert($data);
	}

	public function Insert(array $data = array()) {

		foreach($data as $k => $v)
			$data[$k] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_table['tree'].' SET '.implode(', ', $data);
        if(!$this->_db->query($sql))
			throw new BTException('Error create node', ERR_M_NSTREE_ERROR_CREATE_NODE);

		return $this->_db->insert_id;
	}

	public function allocChild($p, $pos)
    {
		if (!is_a($p, 'NSTreeNode'))
			$p = $this->getNode($p);

        if ($pos == NSTreeMgr::AT_BEGIN) {
            $v = $p[$this->_left];
            $left = $p[$this->_left] + 1;
            $right = $p[$this->_left] + 2;
        }
        elseif ($pos == NSTreeMgr::AT_END) {
            $v = $p[$this->_right];
            $left = $p[$this->_right];
            $right = $p[$this->_right] + 1;
        }
        else {
            throw new BTException('Invalid node position \''.$pos.'\'', ERR_M_NSTREE_INVALID_NODE_POSITION);
        }

        $sql = "
            UPDATE {$this->_table['tree']}
            SET
                `{$this->_left}`  =
                    CASE
                        WHEN `{$this->_left}` > {$v} THEN `{$this->_left}` + 2
                        ELSE `{$this->_left}`
                    END,
                `{$this->_right}` =
                    CASE
                        WHEN `{$this->_right}` >= {$v} THEN `{$this->_right}` + 2
                        ELSE `{$this->_right}`
                    END
                WHERE
					`{$this->_treeid}` = {$this->_id} AND `{$this->_right}` >= {$v}
        ";

		if(!$this->_db->query($sql))
			throw new BTException('Error allocate space', ERR_M_NSTREE_ERROR_ALLOCATE_SPACE);

        $columns = array(
            $this->_left 	=> $left,
            $this->_right	=> $right,
            $this->_level	=> $p[$this->_level] + 1,
            $this->_treeid	=> $p[$this->_treeid],
            $this->_parent	=> $p[$this->_nodeid]
        );

		return $this->Insert($columns);
    }

	function allocSibling($n, $pos)
    {
        if (!is_a($n,'NSTreeNode'))
			$n = $this->getNode($n);

        if ($pos == NSTreeMgr::BEFORE) {
            $v = $n[$this->_left];
            $left = $n[$this->_left];
            $right = $n[$this->_left] + 1;
        }
        elseif ($pos == NSTreeMgr::AFTER) {
            $v = $n[$this->_right];
            $left = $n[$this->_right] + 1;
            $right = $n[$this->_right] + 2;
        }
        else {
            throw new BTException('Invalid node position \''.$pos.'\'', ERR_M_NSTREE_INVALID_NODE_POSITION);
        }

        $sql = "
 			UPDATE {$this->_table['tree']}
		    SET
		    	`{$this->_left}` =
		    		CASE
		    		WHEN `{$this->_left}` >= {$v} THEN
		    			`{$this->_left}` + 2
		    		ELSE
		    			`{$this->_left}`
		    		END,
		    	`{$this->_right}` =
		    		CASE
	    			WHEN `{$this->_right}` >= {$v} THEN
	    				`{$this->_right}` + 2
	    			ELSE
	    				`{$this->_right}`
		    		END
		    WHERE
		    	`{$this->_treeid}` = {$this->_id} AND `{$this->_right}` > {$v}
		";

        if(!$this->_db->query($sql))
			throw new BTException('Error allocate space', ERR_M_NSTREE_ERROR_ALLOCATE_SPACE);

        $columns = array(
            $this->_left	=> $left,
            $this->_right	=> $right,
            $this->_level	=> $n[$this->_level],
			$this->_treeid	=> $n[$this->_treeid],
			$this->_parent	=> $n[$this->_parent]
        );

        return $this->insert($columns);
	}

	public function __get($name) {
		$name = strtolower($name);

		switch($name) {
			case 'db':
				return $this->_db;
			case 'table':
				return $this->_table;
			case 'id':
				return $this->_id;
			case 'childscount':
				return $this->_childscount;
			case 'nodeid':
				return $this->_nodeid;
			case 'left':
				return $this->_left;
			case 'right':
				return $this->_right;
			case 'level':
				return $this->_level;
			case 'parent':
				return $this->_parent;
			case 'treeid':
				return $this->_treeid;
			case 'nameid':
				return $this->_nameid;
			case 'icon':
				return $this->_icon;
			case 'views':
				return $this->_views;
			case 'fields':
				return $this->_fields;
		}

		return null;
	}

	public function Dispose()
	{
		if(!empty($this->_Nodes)) {
			foreach($this->_Nodes as $node) {
				if ($node->isChanged() === false)
					continue ;

				$node->Save();
			}
		}

		$this->_Nodes = null;
		$this->_Nodes = array();
	}
}