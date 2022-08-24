<?php

class NSTreeNode implements ArrayAccess {

	private $_mgr;
	private $_changed = false;
	private $_cache;

	private $_id;
	private $_left;
	private $_right;
	private $_level;
	private $_treeid;
	private $_parent;
	private $_childscount;
	private $_icon;
	private $_views;
	
	private $icon_size = array('max_width' => 80, 'max_height' => 80);
	private $icon_file_size = 102400; //100K
	private $icons_dir = '/common_fs/i/nodes/';
	private $icons_url = '/resources/fs/i/nodes/';

	private $_data;

	function __construct(array $data, NSTreeMgr $mgr) {
		$data = array_change_key_case($data, CASE_LOWER);

		$this->_mgr = $mgr;

		$this->_id		= $data[$this->_mgr->nodeid];
		$this->_left	= $data[$this->_mgr->left];
		$this->_right	= $data[$this->_mgr->right];
		$this->_level	= $data[$this->_mgr->level];
		$this->_treeid	= $data[$this->_mgr->treeid];
		$this->_parent	= $data[$this->_mgr->_parent];
		$this->_childscount	= $data[$this->_mgr->childscount];
		$this->_icon	= $data[$this->_mgr->icon];
		$this->_views	= $data[$this->_mgr->views];
		
		$this->_data = array_diff_key($data, array(
			$this->_mgr->nodeid => '', $this->_mgr->left => '', $this->_mgr->right => '',
			$this->_mgr->level => '', $this->_mgr->parent => '', $this->_mgr->treeid => '', $this->_mgr->childscount => ''));

		$this->_cache = $mgr->getCache();
	}

	public function getMgr() {
		return $this->_mgr;
	}

	public function Set(array $data) {
		$data = array_change_key_case($data, CASE_LOWER);
		foreach($data as $k => $v) {
			if (!array_key_exists($k, $this->_data))
				continue ;

			if ($this->_mgr->nameid !== null && $k == $this->_mgr->nameid) {
				if (!empty($v)) {
					$name_id = TextUtil::Translit(trim($v));
					$name_id = preg_replace("/[^a-z0-9_]/i", "_", $name_id);

					$v = $name_id;
				} else
					$v = Data::GetRandStr(16);

				$v = strtolower($v);
				if (!$this->isRoot() && $this->nameIdExists($v) === true)
					throw new BTException('NameID is exists', ERR_M_NSTREE_ERROR_NAMEID_EXISTS);
			}

			$this->_changed = true;
			$this->_data[$k] = $v;
		}

		if ($this->_cache !== null) {
			$this->_cache->Remove('node_'.$this->_id);
		}

		return $this;
	}

	// Сохранить ветку
	public function Save() {

		if (!$this->_id)
			return false;

        $sql_set = '';
        foreach($this->_data as $k=>$v)
			$sql_set .= ',`'.$k.'` = \''.addslashes($v).'\'';

		$sql = 'UPDATE '.$this->_mgr->table['tree'].' SET '.substr($sql_set,1);
		$sql.= ' WHERE `'.$this->_mgr->nodeid.'`=\''.$this->_id.'\'';

		$result = $this->_mgr->db->query($sql);
		$this->_changed = !$result;

		if ($this->_cache !== null) {
			$this->_cache->Remove('node_'.(int) $this->_id);
		}

		return $result;
    }

	public function Delete() {

		$this->_mgr->db->query('START TRANSACTION');
		try {
			if ($this->isLeaf()) {
			
				$this->DeleteIcon();

				$sql = 'DELETE FROM '.$this->_mgr->table['tree'].' WHERE `'.$this->_mgr->treeid.'`='.$this->_mgr->id.' AND '.$this->_mgr->nodeid.'=\''.$this->_id.'\'';
				if (!$this->_mgr->db->query($sql))
					throw new BTException('Can\'t delete node');

				$sql = 'UPDATE '.$this->_mgr->table['tree'].' SET ';
				$sql.= '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->_left.' AND '.$this->_right.',`'.$this->_mgr->left.'`-1,`'.$this->_mgr->left.'`),';
				$sql.= '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'` BETWEEN '.$this->_left.' AND '.$this->_right.',`'.$this->_mgr->right.'`-1,`'.$this->_mgr->right.'`),';
				$sql.= '`'.$this->_mgr->level.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->_left.' AND '.$this->_right.',`'.$this->_mgr->level.'`-1,`'.$this->_mgr->level.'`),';
				$sql.= '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'`>'.$this->_right.',`'.$this->_mgr->left.'`-2,`'.$this->_mgr->left.'`),';
				$sql.= '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'`>'.$this->_right.',`'.$this->_mgr->right.'`-2,`'.$this->_mgr->right.'`) ';
				$sql.= 'WHERE `'.$this->_mgr->treeid.'`='.$this->_mgr->id.' AND `'.$this->_mgr->right.'`>'.$this->_left;

				if (!$this->_mgr->db->query($sql))
					throw new BTException('Error clearing blank spaces in a tree');
			} else {

				$sql = 'DELETE FROM '.$this->_mgr->table['tree'].' WHERE `'.$this->_mgr->treeid.'`='.$this->_mgr->id.' AND `'.$this->_mgr->left.'` BETWEEN '.$this->_left.' AND '.$this->_right;
				if (!$this->_mgr->db->query($sql))
					throw new BTException('Can\'t delete nodes');

				$deltaId = ($this->_right - $this->_left)+1;
				$sql = 'UPDATE '.$this->_mgr->table['tree'].' SET ';
				$sql.= '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'`>'.$this->_left.',`'.$this->_mgr->left.'`-'.$deltaId.',`'.$this->_mgr->left.'`),';
				$sql.= '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'`>'.$this->_left.',`'.$this->_mgr->right.'`-'.$deltaId.',`'.$this->_mgr->right.'`) ';
				$sql.= 'WHERE `'.$this->_mgr->treeid.'`='.$this->_mgr->id.' AND `'.$this->_mgr->right.'`>'.$this->_right;

				if (!$this->_mgr->db->query($sql))
					throw new BTException('Error clearing blank spaces in a tree');
			}

			if ($this->Parent)
				$this->Parent->updateChildsCount();

			if ($this->_cache !== null)
				$this->_cache->Remove('node_'.$this->_id);

			$this->_mgr->db->query('COMMIT');
		} catch (Exception $e) {

			$this->_mgr->db->query('ROLLBACK');
			throw new BTException($e->getMessage());
		}
		return true;
	}

	public function insertSibling($data, $pos = NSTreeMgr::BEFORE)
    {
		if ($this->isRoot())
			throw new BTException('Can\'t add sibbling node in to root');

		$this->_mgr->db->query('START TRANSACTION');
		try {
			$node = $this->_mgr->allocSibling($this, $pos);
			$node = $this->_mgr->getNode($node)->Set($data);
			$node->Save();

			$this->Parent->updateChildsCount();
			$this->_mgr->db->query('COMMIT');
		} catch (Exception $e) {

			$this->_mgr->db->query('ROLLBACK');
			throw new BTException($e->getMessage());
		}

		return true;
    }

	public function appendChild($data, $pos = NSTreeMgr::AT_BEGIN) {

		$this->_mgr->db->query('START TRANSACTION');
		try {
			$node = $this->_mgr->allocChild($this, $pos);
			$data = array_change_key_case($data, CASE_LOWER);
			$node = $this->_mgr->getNode($node)->Set($data);
			$node->Save();

			$this->updateChildsCount();
			$this->_mgr->db->query('COMMIT');
		} catch (Exception $e) {

			$this->_mgr->db->query('ROLLBACK');
			throw new BTException($e->getMessage());
		}

		return $node;
	}

	public function changeTree($treeId) {
		if (!is_numeric($treeId))
			return false;

		$treeId = (int) $treeId;

		$sql = 'SELECT * FROM '.$this->_mgr->table['tree'];
		$sql.= ' WHERE '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$treeId.' LIMIT 1';

		if (false == ($res = $this->_mgr->db->query($sql)))
			throw new BTException('Query error', ERR_M_NSTREE_UNKNOWN_ERROR);

		if ($res->num_rows)
			throw new BTException('Tree "'.$treeId.'" is exists', ERR_M_NSTREE_TREE_EXISTS);

		$node = STreeMgr::GetNodeByID($treeId);
		if ($node === null)
			throw new BTException('Section "'.$treeId.'" not found', ERR_M_NSTREE_UNKNOWN_ERROR);
			
		if ($node->TypeInt != 2)
			throw new BTException('Section "'.$treeId.'" is not module', ERR_M_NSTREE_UNKNOWN_ERROR);
			
		$sql = 'UPDATE '.$this->_mgr->table['tree'].' SET ';
		$sql.= ' '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$treeId;
		$sql.= ' '.$this->_mgr->table['tree'].'.`'.$this->_mgr->siteid.'`='.$node->ParentID;
		$sql.= ' '.$this->_mgr->table['tree'].'.`'.$this->_mgr->regionid.'`='.$node->Regions;
		$sql.= ' WHERE '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->id;

		if ($this->_cache !== null) {
			$sql = 'SELECT NodeID FROM '.$this->_mgr->table['tree'];
			$sql.= ' WHERE '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->id;
			$res = $this->_mgr->db->query($sql);

			if (false == ($res = $this->_mgr->db->query($sql)))
				throw new BTException('Query error', ERR_M_NSTREE_UNKNOWN_ERROR);

			while (false != ($row = $res->fetch_row())) {
				$this->_cache->Remove('node_'.$row[0]);
			}
		}

		return $this->_mgr->db->query($sql);
	}

	public function moveToTree($newParentId) {

		if (!$this->_id)
			return false;

		$this->_mgr->db->query('START TRANSACTION');

		$parentMgr = new NSTreeMgr($this->_mgr->db, $this->_mgr->table, $this->_mgr->_fields);

		$refs = array();
		$result = $this->_moveToTree($newParentId, $parentMgr, $refs);
		if ($result === false) {
			$this->_mgr->db->query('ROLLBACK');
			return false;
		}

		$this->Delete();

		foreach($refs as $old => $new) {
			$sql = 'UPDATE '.$this->_mgr->table['tree'].' SET ';
			$sql.= ' `NodeID` = '.$old;
			$sql.= ' WHERE NodeID = '.$new;

			$this->_mgr->db->query($sql);
		}

		$this->_mgr->db->query('COMMIT');
		reset($refs);

		$nodeid = key($refs);
		if ($this->_cache !== null) {
			$this->_cache->Remove('node_'.$nodeid);

			$node = $parentMgr->getNode($nodeid);
			
			$childs = $node->getChildNodesID(1, 0);
			if (is_array($childs) && sizeof($childs)) {
				foreach($childs as $id) {
					$this->_cache->Remove('node_'.$id);
				}
			}
		}
		
		return $parentMgr->getNode($nodeid);
	}

	private function _moveToTree($newParentId, $parentMgr, &$refs, $level = 0) {
		if (!$this->_id)
			return false;

		if (null === ($newParent = $parentMgr->getNode($newParentId)))
			return false;

		//if ($newParent->treeid == $this->treeid)
			//return false;

		$parentMgr->setTreeId($newParent->treeid, false);

		$NameID = $this->NameID;
		if (!$level && ($childs = $newParent->getChildNodes()) !== null) {
			foreach($childs as $node) {
				if ($node->id == $newParent->id || $node->{$this->_mgr->nameid} !== $NameID)
					continue ;

				$NameID = str_replace(' ', '_', microtime());
				break;
			}
		}

		$data = array(
			'Title'			=> $this->Title,
			'NameID'		=> $NameID,
			'isVisible'		=> $this->isVisible,
			'isAnnounce'	=> $this->isAnnounce,
			'isYandexMap'	=> $this->isYandexMap,
			'ItemsCount'	=> $this->ItemsCount,
			'inState'		=> $this->inState,
		);

		$childs = $this->getChildNodes(1, 1);
		$node = $newParent->appendChild($data);

		$refs[$this->_id] = $node->ID;
		if (!$childs->count())
			return $node;

		foreach($childs as $child) {
			if (false === $child->_moveToTree($node->ID, $parentMgr, $refs, $level+1))
				return false;
		}

		return $node;
	}
	
	public function UploadIcon()
	{		
		global $OBJECTS;
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		LibFactory::GetStatic('images');
		
		if (empty($_FILES['Icon']['name']))
			return "";
		
		$this->DeleteIcon();
		
		try
		{
			$pname = FileStore::Upload_NEW(
				'Icon', $this->icons_dir, rand(1000, 9999).'_'.$this->ID,
				FileMagic::MT_WIMAGE, $this->icon_file_size,
				array(
					'resize' => array(
						'tr' => 0,
						'w'  => $this->icon_size['max_width'],
						'h'  => $this->icon_size['max_height'],
					),
				)
			);
		
			$pname = FileStore::GetPath_NEW($pname);
			$thumbNew = Images::PrepareImageToObject($pname, $this->icons_dir);
			$pname = FileStore::ObjectToString($thumbNew);
			
			return $pname;
		}
		catch(Exception $e)
		{
			return "";
		}
	}
	
	public function DeleteIcon()
	{
		try 
		{
			if( ($img_obj = FileStore::ObjectFromString($this->_icon)) !== false )
			{
				$del_file = $this->icons_dir.FileStore::GetPath_NEW($img_obj['file']);
				if (FileStore::IsFile($del_file))
					return FileStore::Delete_NEW($del_file);
			}
		}
		
		catch(MyException $e) { }		
	}

	public function moveAll($newParentId) {
		if (!$this->_id)
			return false;

		if (null === ($newParent = $this->_mgr->getNode($newParentId)))
			return false;

      //if(!(list($this->left, $this->right, $this->level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
      //if(!(list($newParent->left, $newParent->right, $newParent->level) = $this->getNodeInfo($newParentId))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
      //if($ID == $newParentId || $this->left == $newParent->left || ($newParent->left >= $this->left && $newParent->left <= $this->right)) return false;

      // whether it is being moved upwards along the path
      if ($newParent->left < $this->left && $newParent->right > $this->right && $newParent->level < $this->level - 1 ) {
         $sql = 'UPDATE '.$this->_mgr->table['tree'].' SET '
            . '`'.$this->_mgr->level.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->level.'`'.sprintf('%+d', -($this->level-1)+$newParent->level).', `'.$this->_mgr->level.'`), '
            . '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'` BETWEEN '.($this->right+1).' AND '.($newParent->right-1).', `'.$this->_mgr->right.'`-'.($this->right-$this->left+1).', '
                           .'IF(`'.$this->_mgr->left.'` BETWEEN '.($this->left).' AND '.($this->right).', `'.$this->_mgr->right.'`+'.((($newParent->right-$this->right-$this->level+$newParent->level)/2)*2 + $this->level - $newParent->level - 1).', `'.$this->_mgr->right.'`)),  '
            . '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.($this->right+1).' AND '.($newParent->right-1).', `'.$this->_mgr->left.'`-'.($this->right-$this->left+1).', '
                           .'IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.($this->right).', `'.$this->_mgr->left.'`+'.((($newParent->right-$this->right-$this->level+$newParent->level)/2)*2 + $this->level - $newParent->level - 1).', `'.$this->_mgr->left. '`)) '
            . 'WHERE `'.$this->_mgr->left.'` BETWEEN '.($newParent->left+1).' AND '.($newParent->right-1)
         ;
      } elseif($newParent->left < $this->left) {
         $sql = 'UPDATE '.$this->_mgr->table['tree'].' SET '
            . '`'.$this->_mgr->level.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->level.'`'.sprintf('%+d', -($this->level-1)+$newParent->level).', `'.$this->_mgr->level.'`), '
            . '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$newParent->right.' AND '.($this->left-1).', `'.$this->_mgr->left.'`+'.($this->right-$this->left+1).', '
               . 'IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->left.'`-'.($this->left-$newParent->right).', '.$this->_mgr->left.') '
            . '), '
            . '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'` BETWEEN '.$newParent->right.' AND '.$this->left.', `'.$this->_mgr->right.'`+'.($this->right-$this->left+1).', '
               . 'IF(`'.$this->_mgr->right.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->right.'`-'.($this->left-$newParent->right).', `'.$this->_mgr->right.'`) '
            . ') '
            . 'WHERE `'.$this->_mgr->left.'` BETWEEN '.$newParent->left.' AND '.$this->right
            // !!! added this line (Maxim Matyukhin)
            .' OR `'.$this->_mgr->right.'` BETWEEN '.$newParent->left.' AND '.$this->right
         ;
      } else {
         $sql = 'UPDATE '.$this->_mgr->table['tree'].' SET '
            . '`'.$this->_mgr->level.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->level.'`'.sprintf('%+d', -($this->level-1)+$newParent->level).', `'.$this->_mgr->level.'`), '
            . '`'.$this->_mgr->left.'`=IF(`'.$this->_mgr->left.'` BETWEEN '.$this->right.' AND '.$newParent->right.', `'.$this->_mgr->left.'`-'.($this->right-$this->left+1).', '
               . 'IF(`'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->left.'`+'.($newParent->right-1-$this->right).', `'.$this->_mgr->left.'`)'
            . '), '
            . '`'.$this->_mgr->right.'`=IF(`'.$this->_mgr->right.'` BETWEEN '.($this->right+1).' AND '.($newParent->right-1).', `'.$this->_mgr->right.'`-'.($this->right-$this->left+1).', '
               . 'IF(`'.$this->_mgr->right.'` BETWEEN '.$this->left.' AND '.$this->right.', `'.$this->_mgr->right.'`+'.($newParent->right-1-$this->right).', `'.$this->_mgr->right.'`) '
            . ') '
            . 'WHERE `'.$this->_mgr->left.'` BETWEEN '.$this->left.' AND '.$newParent->right
            // !!! added this line (Maxim Matyukhin)
            . ' OR `'.$this->_mgr->right.'` BETWEEN '.$this->left.' AND '.$newParent->right
         ;
      }
	  print_r(array(
		'$this->left' => $this->left,
		'$this->right' => $this->right,
		'$this->level' => $this->level
	  ));

	   print_r(array(
		'$newParent->left' => $newParent->left,
		'$newParent->right' => $newParent->right,
		'$newParent->level' => $newParent->level
	  ));
	  echo $sql;
      //return $this->_mgr->db->query($sql);
   }

	public function getChildByName($NameID, $Level = 1, $isVisible = null)
    {
		if ($start < 0)
			throw new BTException('Start level can not be less than zero');

		$childs = $this->getChildNodes($Level, 1, $isVisible, $NameID);

		if ($childs !== null)
		foreach($childs as $c)
			return $c;

		return null;
    }

	public function &getChildNodesLeaf($start = 1, $end = 1, $isVisible = null)
	{
		return $this->getChildNodes($start, $end, $isVisible, null, true);
	}

	public function &getChildNodesLeafID($start = 1, $end = 1, $isVisible = null)
	{
		return $this->getChildNodesID($start, $end, $isVisible, null, true);
	}

	public function &getChildNodesID($start = 1, $end = 1, $isVisible = null, $NameID = null, $onlyLeaf = false)
    {
		if ($start < 0)
			throw new BTException('Start level can not be less than zero');
			
		$sql = "SELECT ".$this->_mgr->table["tree"].".".$this->_mgr->nodeid." FROM ".$this->_mgr->table["tree"]." ";
		$sql.= " STRAIGHT_JOIN ".$this->_mgr->table["tree"]." _".$this->_mgr->table["tree"]." ON (_".$this->_mgr->table["tree"].".`".$this->_mgr->treeid."` = ".$this->_mgr->table["tree"].".`".$this->_mgr->treeid."`) ";
		$sql.= " WHERE ".$this->_mgr->table["tree"].".`".$this->_mgr->treeid."`=".$this->_mgr->id;			
		$sql.= " AND _".$this->_mgr->table["tree"].".".$this->_mgr->nodeid."='".$this->_id."'";
		$sql.= " AND ".$this->_mgr->table["tree"].".".$this->_mgr->left." BETWEEN _".$this->_mgr->table["tree"].".".$this->_mgr->left." AND _".$this->_mgr->table["tree"].".".$this->_mgr->right;

		if (!$end)
			$sql.= " AND ".$this->_mgr->table["tree"].".".$this->_mgr->level." >= _".$this->_mgr->table["tree"].".".$this->_mgr->level."+".(int)$start;
		elseif ($end <= $start)
			$sql.= " AND ".$this->_mgr->table["tree"].".".$this->_mgr->level." = _".$this->_mgr->table["tree"].".".$this->_mgr->level."+".(int)$start;
		else {
			$sql.= " AND ".$this->_mgr->table["tree"].".".$this->_mgr->level." BETWEEN _".$this->_mgr->table["tree"].".".$this->_mgr->level."+".(int)$start;
			$sql.= " AND _".$this->_mgr->table["tree"].".".$this->_mgr->level."+".(int)$end;
		}

		if ($onlyLeaf === true)
			$sql.= " AND (".$this->_mgr->table["tree"].".".$this->_mgr->right." - ".$this->_mgr->table["tree"].".".$this->_mgr->left.") <= 1";

		if ($NameID !== null)
			$sql.= " AND ".$this->_mgr->table["tree"].".NameID = '".$NameID."'";

		if ($isVisible !== null)
			$sql.= " AND ".$this->_mgr->table["tree"].".isVisible = ".($isVisible ? 1 : 0);

		$sql.= " ORDER by ".$this->_mgr->table["tree"].".`Order` ASC, ".$this->_mgr->table["tree"].".Title ASC";
		
		if (false === ($res = $this->_mgr->db->query($sql)))
			throw new BTException('Error get child nodes');

		$list = array();
		while(false != ($row = $res->fetch_row())) {
			$list[] = $row[0];
		}
		
		return $list;
    }

	public function getChildNodes($start = 1, $end = 1, $isVisible = null, $NameID = null, $onlyLeaf = false) {

		$list = $this->getChildNodesID($start, $end, $isVisible, $NameID, $onlyLeaf);
		return new PNSTreeNodeIterator($list, $this->_mgr);
	}

	public function getChildNodesCount($start = 1, $end = 1, $isVisible = null)
    {
		if ($start < 0)
			throw new BTException('Start level can not be less than zero');

		$sql = 'SELECT COUNT(*) FROM '.$this->_mgr->table['tree'].' _'.$this->_mgr->table['tree'].', '.$this->_mgr->table['tree'].' WHERE ';
		$sql.= ' '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->id;
		$sql.= ' AND _'.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`';
		$sql.= ' AND _'.$this->_mgr->table['tree'].'.'.$this->_mgr->nodeid.'=\''.$this->_id.'\'';
		$sql.= ' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->left.' BETWEEN _'.$this->_mgr->table['tree'].'.'.$this->_mgr->left.' AND _'.$this->_mgr->table['tree'].'.'.$this->_mgr->right;

		if (!$end)
			$sql.= ' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->level.' >= _'.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'+'.(int)$start;
		elseif ($end <= $start)
			$sql.= ' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->level.' = _'.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'+'.(int)$start;
		else {
			$sql.= ' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->level.' BETWEEN _'.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'+'.(int)$start;
			$sql.= ' AND _'.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'+'.(int)$end;
		}
		if ($isVisible !== null)
			$sql.= ' AND '.$this->_mgr->table['tree'].'.isVisible = '.($isVisible ? 1 : 0);

		$res = $this->_mgr->db->query($sql);
		if (!$res || !$res->num_rows)
			throw new BTException('Error get child nodes count');

		list($count) = $res->fetch_row();
		return $count;
    }

	public function updateChildsCount() {
		$this->_data[$this->_mgr->childscount] = $this->getChildNodesCount(1, 0, true);
		$this->Save();

		if ($this->Parent)
			$this->Parent->updateChildsCount();
	}

	public function nameIdExists($nameid) {
		if (($childs = $this->Parent->getChildNodes()) === null)
			return false;

		if (sizeof($childs) == 1)
			return false;

		foreach($childs as $node) {
			if ($node->id != $this->id && $node->{$this->_mgr->nameid} === $nameid)
				return true;
		}

		return false;
	}

	public function getPath($showRoot = false, $array = false) {
	
		$cacheid = 'path_'.$this->_id;
	
		$list = false;
		if ($this->_mgr->IsCache())
			$list = $this->_cache->get($cacheid);
	
		if ($list === false) {
			$sql = "SELECT ".$this->_mgr->table["tree"].".".$this->_mgr->nodeid." FROM ".$this->_mgr->table["tree"]." _".$this->_mgr->table["tree"].", ".$this->_mgr->table["tree"]." WHERE ";
			$sql.= " ".$this->_mgr->table["tree"].".".$this->_mgr->treeid."=".$this->_mgr->id;
			$sql.= " AND _".$this->_mgr->table["tree"].".".$this->_mgr->treeid."=".$this->_mgr->table["tree"].".`".$this->_mgr->treeid."`";
			$sql.= " AND _".$this->_mgr->table["tree"].".".$this->_mgr->nodeid."='".$this->_id."'";
			$sql.= " AND _".$this->_mgr->table["tree"].".".$this->_mgr->left." BETWEEN ".$this->_mgr->table["tree"].".".$this->_mgr->left." AND ".$this->_mgr->table["tree"].".".$this->_mgr->right;
			$sql.= " ORDER BY ".$this->_mgr->table["tree"].".".$this->_mgr->left;

			$res = $this->_mgr->db->query($sql);
			if (!$res || !$res->num_rows)
				return null;

			$list = array();
			while(false != ($row = $res->fetch_row())) {
				$list[] = $row[0];
			}
						
			if ($this->_mgr->IsCache())
				$this->_cache->set($cacheid, $list, 3600);
		}

		if (!$showRoot && sizeof($list))
			array_shift($list);
		
		if ($array === false)
			return new PNSTreeNodeIterator($list, $this->_mgr);

		return $list;
    }

	public function getParent() {
        //if($level < 1)
			//throw new Exception('Level can not be less than one');

		$list = false;
		$cacheid = 'parent_'.$this->_id;
		if ($this->_mgr->IsCache())
			$list = $this->_cache->get($cacheid);
		
		if ($list === false) {
				
			$sql = 'SELECT '.$this->_mgr->table['tree'].'.'.$this->_mgr->nodeid.' FROM '.$this->_mgr->table['tree'].' _'.$this->_mgr->table['tree'].', '.$this->_mgr->table['tree'].' WHERE ';
			$sql.= ' '.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->id;
			$sql.= ' AND _'.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`='.$this->_mgr->table['tree'].'.`'.$this->_mgr->treeid.'`';
			$sql.= ' AND _'.$this->_mgr->table['tree'].'.'.$this->_mgr->nodeid.'=\''.$this->_id.'\'';
			$sql.= ' AND _'.$this->_mgr->table['tree'].'.'.$this->_mgr->left.' BETWEEN '.$this->_mgr->table['tree'].'.'.$this->_mgr->left.' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->right;
			$sql.= ' AND '.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'=_'.$this->_mgr->table['tree'].'.'.$this->_mgr->level.'-1';

			$res = $this->_mgr->db->query($sql);
			if (!$res || !$res->num_rows)
				return null;

			$list = array();
			while(false != ($row = $res->fetch_row())) {
				$list[] = $row[0];
			}
			
			if ($this->_mgr->IsCache())
				$this->_cache->set($cacheid, $list, 3600);
		}

		return $list;
    }

	public function isRoot()
    {
        return (0 == $this->_level);
    }

    public function isLeaf()
    {
        return !$this->hasChildren();
    }

    public function hasChildren()
    {
        return $this->_right - $this->_left > 1;
    }

	// ArrayAccess
	public function offsetExists($offset) {
		if($this->_data === null)
			return false;

		return isset($this->_data[$offset]);
	}

	public function offsetGet($offset) {

		return $this->__get($offset);
	}

	public function offsetSet($offset, $value)
	{
		$offset = strtolower($offset);
		if (!isset($this->_data[$offset]))
			return null;

		$this->_changed = true;
		return $this->_data[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		throw new BTException('Unset fields is not allowed');
	}

	public function isChanged() {
		return $this->_changed;
	}

	function __get($name) {
		$name = strtolower($name);

		switch($name) {
			case 'id':
				return $this->_id;
			case 'left':
				return $this->_left;
			case 'right':
				return $this->_right;
			case 'level':
				return $this->_level;
			case 'views':
				return $this->_views;
			case 'treeid':
				return $this->_treeid;
			case 'childscount':
				return $this->_childscount;
			case 'parent':
				if ($this->isRoot() || ($parent = $this->getParent()) === null)
					return null;

				return $this->_mgr->getNode($parent[0]);
			break;
			case 'icon':
				if (!$this->_icon)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($this->_icon);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj, 
						$this->icons_dir, $this->icons_url);
					unset($img_obj);
					if (empty($preparedImage))
						return null;
				}
				catch ( MyException $e )
				{
					return null;
				}
				
				return array(
					'f' => $preparedImage['url'],
					'w' => $preparedImage['w'],
					'h' => $preparedImage['h'],
				);
			break;
			default:
				if (isset($this->_data[$name]))
					return $this->_data[$name];
		}

		return null;
	}
}