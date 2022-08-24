<?php

class lib_Firms {
	private $_db = null;
	private $last_firm = null;
	private $_tree = null;
	private $_recordsById = array();
	private $_tables = array();
	private $_root = null;

	public function Init($sectionid,$v) {
	
		$config = ModuleFactory::GetConfigById('section', $sectionid, $v);
	
		if (!empty($config['db']) && !empty($config['tables']['data'])) {
			$this->_tables = $config['tables'];
			$this->_db = DBFactory::GetInstance($config['db']);
		} else {
			throw new Exception('Empty db name or table data');
		}
		$this->_root = $config['rootdir'];

		return $this;
	}
	
	public function getListByNode($root,$regid = null,$withroot = false,$is_root = true, $start = null, $limit = null) {
		LibFactory::GetStatic('tree');
					
		$index = $root.'_'.$withroot; //.'_'.$regid;
		
		if ($root && !isset($this->_recordsById[$index])) {
			
			$tree = $this->_getTreeData(0);
			$this->_recordsById[$index] = array();	

			list($tree,$desc) = $tree->FindById($root,true,true);

			$_nodes = $tree->GetTreePlainData();
			if ($withroot || sizeof($nodes)) {
				$nodes = array();
				foreach($_nodes as $node) {
					$nodes[$node['id']] = $node;
				}
			
				$sql = 'SELECT td.`id`, td.`name`, te.`parent` FROM '. $this->_tables['data'].' as td '.
				' LEFT JOIN '.$this->_tables['enttree'].' as te ON td.`id` = te.`eid` '.
				' LEFT JOIN '.$this->_tables['tree'].' as tt ON tt.`id` = te.`parent` '.

				' WHERE (te.`parent` = '.$root.' '.
				(sizeof($nodes) ? 'OR te.`parent` IN('.implode(',',array_keys($nodes)).')' : '').') AND '.
				' td.`visible`=1 '. //(($regid) ? ' AND td.`regid`='.$regid : '').
				( ($start !== null && $limit !== null) ? ' LIMIT '.$start.','.$limit : '' );		
		
				$res = $this->_db->query($sql);
				if ($res->num_rows) {
				
					if ($is_root) {
						$path = $desc[sizeof($desc)-1]['name'];
					} else {
						list(,$path) = explode('/',$desc[sizeof($desc)-1]['path'],2);
					}

					$node = $desc[sizeof($desc)-1]['id'];
					
					while (false != ($row = $res->fetch_assoc())) {
						if (isset($nodes[$row['parent']])) {
							$this->_recordsById[$index][$row['id']] = array('name' => $row['name'], 'path' => $path.'/'.$nodes[$row['parent']]['name']);
						} elseif ($row['parent'] == $node) {
							$this->_recordsById[$index][$row['id']] = array('name' => $row['name'], 'path' => $path);
						}
					}
				}
			}
		} elseif (!$root) return array();
		return $this->_recordsById[$index];
	}
	
	public function getCountByNode($root,$regid = null,$withroot = false) {
		LibFactory::GetStatic('tree');
						
		if ($root) {
			
			$tree = $this->_getTreeData(0);
			
			list($tree,$desc) = $tree->FindById($root,true,true);
			$_nodes = $tree->GetTreePlainData();
			if ($withroot || sizeof($nodes)) {
				$nodes = array();
				foreach($_nodes as $node) {
					$nodes[$node['id']] = $node;
				}
			
				$sql = 'SELECT COUNT(td.`id`) FROM '. $this->_tables['data'].' as td '.
				' LEFT JOIN '.$this->_tables['enttree'].' as te ON td.`id` = te.`eid` '.
				' LEFT JOIN '.$this->_tables['tree'].' as tt ON tt.`id` = te.`parent` '.

				' WHERE (te.`parent` = '.$root.' '.
				(sizeof($nodes) ? 'OR te.`parent` IN('.implode(',',array_keys($nodes)).')' : '').') AND '.
				' td.`visible`=1 '; //.(($regid) ? ' AND td.`regid`='.$regid : '');
		
				list($count) = $this->_db->query($sql)->fetch_row();
				return $count;
			}
		}
		return 0;
	}
	
	public function firmsCount($q = '')
	{	 	
		$sql = 'SELECT COUNT(`id`) FROM '.$this->_tables['data'].((!$q) ? '' : ' WHERE `name` like \'%'. addslashes($q) . '%\'');		
		$res = $this->_db->query($sql);
		$res = $res->fetch_row();
		return $res[0];
	}

	public function getByName($query, array $fields = array(), $start = 0, $limit = 20)
	{		
		if (trim($query) != '')
		{
			$fields = (sizeof($fields)) ? implode(',',$fields) : ' d.* ';
			
			$sql = "SELECT `id`,". $fields;
			$sql.= " FROM ". $this->_tables['data'] ." d";
			$sql.= " WHERE `name` like '%". addslashes($query) . "%'";
			$sql.= " ORDER by `name`";
			$sql.= " LIMIT ". $start .",". $limit;
			
			$result = $this->_db->query($sql);
			
			if ($result && $result->num_rows)
			{
				while ( $r = $result->fetch_assoc() )
					$d[$r['id']] = $r;
				return $d;
			}
		}
		return array();
	}

	public function getByNameWithRoot($query, array $fields = array(), $start = 0, $limit = 20)
	{		
		if ( trim($query) == '' )
			return array();
		
		$tree = $this->_getTreeData($this->_root);
		$treeplain = $tree->GetTreePlainData();
		
		if ( is_array($treeplain) && sizeof($treeplain) )
		{
			$nodes = $treeplain;
			array_walk($nodes,create_function('&$v,$k','$v = $v[\'id\'];'));
			
			$fields = (sizeof($fields)) ? implode(',',$fields) : ' d.* ';
			
			$sql = "SELECT SQL_CALC_FOUND_ROWS d.`id`,". $fields;
			$sql.= " FROM ". $this->_tables['data'] ." d";
			$sql.= " INNER JOIN ". $this->_tables['enttree'] ." te ON te.eid = d.id ";
			$sql.= " INNER JOIN ". $this->_tables['tree'] ." t ON t.id = te.parent ";
			$sql.= " WHERE d.`name` like '%". addslashes($query) . "%'";
			$sql.= " AND d.`visible` = 1";
			$sql.= " AND t.id IN (". implode(',',$nodes) .")";
			$sql.= " ORDER by d.`name`";
			$sql.= " LIMIT ". $start .",". $limit;
			
			$result = $this->_db->query($sql);
			
			list($count) = $this->_db->query("SELECT FOUND_ROWS()")->fetch_row();
			
			if ($result && $result->num_rows)
			{
				while ( $r = $result->fetch_assoc() )
					$d[$r['id']] = $r;
				return array($count,$d);
			}
		}
		
		return array();
	}

	public function get($id, array $fields = array()) {

		$id = (int) $id;
		if ($id > 0) {
			$fields = (sizeof($fields)) ? implode(',',$fields) : ' d.* ';

			if ($this->last_firm === null || $this->last_firm['id'] != $id) {
				$this->last_firm = $this->_getFirm($id,$fields);
			}
			return $this->last_firm;
		}
		return false;
	}

	public function getList($ids, array $fields = array()) {		
	
		if (is_array($ids) && sizeof($ids)) {
			$fields = (sizeof($fields)) ? implode(',',$fields) : ' d.* ';
			return $this->_getFirmList(implode(',',$ids),$fields);
		}
		return false;
	}

	private function _getFirm($id, $fields) {
		$sql = 'SELECT '.$fields.' FROM '.$this->_tables['data'].' d WHERE `id` = '. $id;

		$result = $this->_db->query($sql);
		if ($result && $result->num_rows) {
			return $result->fetch_assoc();
		}
		return false;
	}

	private function _getFirmList($id, $fields) {
		$sql = 'SELECT DISTINCT `id`,'.$fields.' FROM '.$this->_tables['data'].' d WHERE `id` in('. $id .')';

		$result = $this->_db->query($sql);
		if ($result && $result->num_rows) {
			$d = array();
			while (false != ($r = $result->fetch_assoc())) {
				$d[$r['id']] = $r;
			}
			return $d;
		}
		return false;
	}

	private function _getTreeData($root,$group = '') {

		if ($this->_tree === null) {

			if ($group != '') {
				$sql = "SELECT id
				FROM {$this->_tables['group']}
				WHERE modname='{$this->_params['group']}'";
				$res = $this->_db->query($sql);
				if ($row = $res->fetch_row())
				$sql = "SELECT tt.id, tt.parent, tt.shorttitle, tt.title, tt.name, tt.pcnt
				FROM {$this->_tables['tree']} as tt, {$this->_tables['ref']} as rf
				WHERE tt.id=rf.st_id AND rf.group_id={$row[0]} AND tt.visible=1
				ORDER BY tt.ord,tt.title";
			} else {
				$sql = "SELECT tt.id, tt.parent, tt.shorttitle, tt.title, tt.name
				FROM {$this->_tables['tree']} as tt
				WHERE tt.visible=1
				ORDER BY tt.ord,tt.title";
			}


			$res = $this->_db->query($sql);
			while($row = $res->fetch_row())
				$data[$row[0]] = array(
					'parent' => $row[1],
					'data' => array(
						'parent' => $row[1],
						'name' => $row[3],
						'shorttitle'=> $row[2],
						'cnt' => $row[5]),
					'name' => $row[4]
				);

			$this->_tree = new Tree();
			$this->_tree->BuildTree($data,$root);

		}
		return $this->_tree;
	}
}

?>