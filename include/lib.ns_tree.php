<?
class NSTree {

	private $db;	// CDatabase class to plug to
    private $table;	// Table with Nested Sets implemented
    private $id;	// Name of the ID-auto_increment-field in the table.

    // These 3 variables are names of fields which are needed to implement
    // Nested Sets. All 3 fields should exist in your table!
    // However, you may want to change their names here to avoid name collisions.
    private $_left	= 'left';
    private $_right	= 'right';
    private $_level	= 'level';

    var $qryParams = '';
    var $qryFields = '';
    var $qryTables = '';
    var $qryWhere = '';
    var $qryGroupBy = '';
    var $qryHaving = '';
    var $qryOrderBy = '';
    var $qryLimit = '';
    var $sqlNeedReset = true;
    var $sql;    // Last SQL query

//************************************************************************
// Constructor
// $DB : CDatabase class instance to link to
// $tableName : table in database where to implement nested sets
// $itemId : name of the field which will uniquely identify every record
// $fieldNames : optional configuration array to set field names. Example:
//                 array(
//                    'left' => 'cat_left',
//                    'right' => 'cat_right',
//                    'level' => 'cat_level'
//                 )
    function __construct(&$DB, $tableName, $itemId, $fieldNames=array()) {

		if(empty($tableName))
			throw new Exception(__CLASS__ . ' error: Unknown table');

		if(empty($itemId))
			throw new Exception(__CLASS__ . ' error: Unknown ID column');

		$this->db = $DB;
        $this->table = $tableName;
        $this->id = $itemId;

		if(is_array($fieldNames) && sizeof($fieldNames))
            foreach($fieldNames as $k => $v)
                $this->$k = $v;
    }

	// Возвращает информацию по запрошеной ветке
	public function getNode($ID) {
		$this->sql = 'SELECT * FROM '.$this->table;
		$this->sql.= ' WHERE '.$this->id.'=\''.$ID.'\'';

		$res = $this->db->query($this->sql);
		if (!$res || !$res->num_rows)
			return null;

		return $res->fetch_assoc();
    }

	// Очищает таблицу и создает корневую ветку
    public function clearTree($data = array()) {

        if (!$this->db->query('TRUNCATE '.$this->table) || !$this->db->query('DELETE FROM '.$this->table))
			throw new Exception(__CLASS__ . ' error: '.$this->db->error());

        if (!is_array($data) || sizeof($data))
			$data = array();
		
		$data[$this->_left] = 1;
		$data[$this->_right] = 2;
		$data[$this->_level] = 0;
		
		$fld_names = implode(',', array_keys($data)).',';
		$fld_values = '\''.implode('\',\'', $data).'\',';

        $this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
        if(!$this->db->query($this->sql)) 
			throw new Exception(__CLASS__ . ' error: '.$this->db->error());

        return $this->db->insert_id();
    }

//************************************************************************
// Updates a record
// $ID : element ID
// $data : array with data to update: array(<field_name> => <fields_value>)
    function update($ID, $data) {
        $sql_set = '';
        foreach($data as $k=>$v) $sql_set .= ','.$k.'=\''.addslashes($v).'\'';
        return $this->db->query('UPDATE '.$this->table.' SET '.substr($sql_set,1).' WHERE '.$this->id.'=\''.$ID.'\'');
    }

//************************************************************************
// Inserts a record into the table with nested sets
// $ID : an ID of the parent element
// $data : array with data to be inserted: array(<field_name> => <field_value>)
// Returns : true on success, or false on error
    function insert($ID, $data) {
        if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // preparing data to be inserted
        if(sizeof($data)) {
            $fld_names = implode(',', array_keys($data)).',';
            $fld_values = '\''.implode('\',\'', array_values($data)).'\',';
        }
        $fld_names .= $this->_left.','.$this->_right.','.$this->_level;
        $fld_values .= ($rightId).','.($rightId+1).','.($level+1);

        // creating a place for the record being inserted
        if($ID) {
            $this->sql = 'UPDATE '.$this->table.' SET '
                . $this->_left.'=IF('.$this->_left.'>'.$rightId.','.$this->_left.'+2,'.$this->_left.'),'
                . $this->_right.'=IF('.$this->_right.'>='.$rightId.','.$this->_right.'+2,'.$this->_right.')'
                . 'WHERE '.$this->_right.'>='.$rightId;
            if(!($this->db->query($this->sql))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
        }

        // inserting new record
        $this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
        if(!($this->db->query($this->sql))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        return $this->db->insert_id();
    }

//************************************************************************
// Inserts a record into the table with nested sets
// $ID : ID of the element after which (i.e. at the same level) the new element
//         is to be inserted
// $data : array with data to be inserted: array(<field_name> => <field_value>)
// Returns : true on success, or false on error
    function insertNear($ID, $data) {
        if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID)))
            trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // preparing data to be inserted
        if(sizeof($data)) {
            $fld_names = implode(',', array_keys($data)).',';
            $fld_values = '\''.implode('\',\'', array_values($data)).'\',';
        }
        $fld_names .= $this->_left.','.$this->_right.','.$this->_level;
        $fld_values .= ($rightId+1).','.($rightId+2).','.($level);

        // creating a place for the record being inserted
        if($ID) {
            $this->sql = 'UPDATE '.$this->table.' SET '
            .$this->_left.'=IF('.$this->_left.'>'.$rightId.','.$this->_left.'+2,'.$this->_left.'),'
            .$this->_right.'=IF('.$this->_right.'>'.$rightId.','.$this->_right.'+2,'.$this->_right.')'
                               . 'WHERE '.$this->_right.'>'.$rightId;
            if(!($this->db->query($this->sql))) trigger_error("phpDbTree error:".$this->db->error(), E_USER_ERROR);
        }

        // inserting new record
        $this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
        if(!($this->db->query($this->sql))) trigger_error("phpDbTree error:".$this->db->error(), E_USER_ERROR);

        return $this->db->insert_id();
    }


//************************************************************************
// Assigns a node with all its children to another parent
// $ID : node ID
// $newParentID : ID of new parent node
// Returns : false on error
   function moveAll($ID, $newParentId) {
      if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
      if(!(list($leftIdP, $rightIdP, $levelP) = $this->getNodeInfo($newParentId))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
      if($ID == $newParentId || $leftId == $leftIdP || ($leftIdP >= $leftId && $leftIdP <= $rightId)) return false;

      // whether it is being moved upwards along the path
      if ($leftIdP < $leftId && $rightIdP > $rightId && $levelP < $level - 1 ) {
         $this->sql = 'UPDATE '.$this->table.' SET '
            . $this->_level.'=IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_level.sprintf('%+d', -($level-1)+$levelP).', '.$this->_level.'), '
            . $this->_right.'=IF('.$this->_right.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).', '.$this->_right.'-'.($rightId-$leftId+1).', '
                           .'IF('.$this->_left.' BETWEEN '.($leftId).' AND '.($rightId).', '.$this->_right.'+'.((($rightIdP-$rightId-$level+$levelP)/2)*2 + $level - $levelP - 1).', '.$this->_right.')),  '
            . $this->_left.'=IF('.$this->_left.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).', '.$this->_left.'-'.($rightId-$leftId+1).', '
                           .'IF('.$this->_left.' BETWEEN '.$leftId.' AND '.($rightId).', '.$this->_left.'+'.((($rightIdP-$rightId-$level+$levelP)/2)*2 + $level - $levelP - 1).', '.$this->_left. ')) '
            . 'WHERE '.$this->_left.' BETWEEN '.($leftIdP+1).' AND '.($rightIdP-1)
         ;
      } elseif($leftIdP < $leftId) {
         $this->sql = 'UPDATE '.$this->table.' SET '
            . $this->_level.'=IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_level.sprintf('%+d', -($level-1)+$levelP).', '.$this->_level.'), '
            . $this->_left.'=IF('.$this->_left.' BETWEEN '.$rightIdP.' AND '.($leftId-1).', '.$this->_left.'+'.($rightId-$leftId+1).', '
               . 'IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_left.'-'.($leftId-$rightIdP).', '.$this->_left.') '
            . '), '
            . $this->_right.'=IF('.$this->_right.' BETWEEN '.$rightIdP.' AND '.$leftId.', '.$this->_right.'+'.($rightId-$leftId+1).', '
               . 'IF('.$this->_right.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_right.'-'.($leftId-$rightIdP).', '.$this->_right.') '
            . ') '
            . 'WHERE '.$this->_left.' BETWEEN '.$leftIdP.' AND '.$rightId
            // !!! added this line (Maxim Matyukhin)
            .' OR '.$this->_right.' BETWEEN '.$leftIdP.' AND '.$rightId
         ;
      } else {
         $this->sql = 'UPDATE '.$this->table.' SET '
            . $this->_level.'=IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_level.sprintf('%+d', -($level-1)+$levelP).', '.$this->_level.'), '
            . $this->_left.'=IF('.$this->_left.' BETWEEN '.$rightId.' AND '.$rightIdP.', '.$this->_left.'-'.($rightId-$leftId+1).', '
               . 'IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_left.'+'.($rightIdP-1-$rightId).', '.$this->_left.')'
            . '), '
            . $this->_right.'=IF('.$this->_right.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).', '.$this->_right.'-'.($rightId-$leftId+1).', '
               . 'IF('.$this->_right.' BETWEEN '.$leftId.' AND '.$rightId.', '.$this->_right.'+'.($rightIdP-1-$rightId).', '.$this->_right.') '
            . ') '
            . 'WHERE '.$this->_left.' BETWEEN '.$leftId.' AND '.$rightIdP
            // !!! added this line (Maxim Matyukhin)
            . ' OR '.$this->_right.' BETWEEN '.$leftId.' AND '.$rightIdP
         ;
      }
      return $this->db->query($this->sql) or trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
   }

//************************************************************************
// Deletes a record wihtout deleting its children
// $ID : an ID of the element to be deleted
// Returns : true on success, or false on error
    function delete($ID) {
        if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // Deleting record
        $this->sql = 'DELETE FROM '.$this->table.' WHERE '.$this->id.'=\''.$ID.'\'';
        if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // Clearing blank spaces in a tree
        $this->sql = 'UPDATE '.$this->table.' SET '
            . $this->_left.'=IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->_left.'-1,'.$this->_left.'),'
            . $this->_right.'=IF('.$this->_right.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->_right.'-1,'.$this->_right.'),'
            . $this->_level.'=IF('.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->_level.'-1,'.$this->_level.'),'
            . $this->_left.'=IF('.$this->_left.'>'.$rightId.','.$this->_left.'-2,'.$this->_left.'),'
            . $this->_right.'=IF('.$this->_right.'>'.$rightId.','.$this->_right.'-2,'.$this->_right.') '
            . 'WHERE '.$this->_right.'>'.$leftId
        ;
        if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        return true;
    }

//************************************************************************
// Deletes a record with all its children
// $ID : an ID of the element to be deleted
// Returns : true on success, or false on error
    function deleteAll($ID) {
        if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // Deleteing record(s)
        $this->sql = 'DELETE FROM '.$this->table.' WHERE '.$this->_left.' BETWEEN '.$leftId.' AND '.$rightId;
        if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // Clearing blank spaces in a tree
        $deltaId = ($rightId - $leftId)+1;
        $this->sql = 'UPDATE '.$this->table.' SET '
            . $this->_left.'=IF('.$this->_left.'>'.$leftId.','.$this->_left.'-'.$deltaId.','.$this->_left.'),'
            . $this->_right.'=IF('.$this->_right.'>'.$leftId.','.$this->_right.'-'.$deltaId.','.$this->_right.') '
            . 'WHERE '.$this->_right.'>'.$rightId
        ;
        if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        return true;
    }

//************************************************************************
// Enumerates children of an element
// $ID : an ID of an element which children to be enumerated
// $start_level : relative level from which start to enumerate children
// $end_level : the last relative level at which enumerate children
//   1. If $end_level isn't given, only children of
//      $start_level levels are enumerated
//   2. Level values should always be greater than zero.
//      Level 1 means direct children of the element
// Returns : a result id for using with other DB functions
    function enumChildrenAll($ID) { return $this->enumChildren($ID, 1, 0); }
    function enumChildren($ID, $start_level=1, $end_level=1) {
        if($start_level < 0) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        // We could use sprintf() here, but it'd be too slow
        $whereSql1 = ' AND '.$this->table.'.'.$this->_level;
        $whereSql2 = '_'.$this->table.'.'.$this->_level.'+';

        if(!$end_level) $whereSql = $whereSql1.'>='.$whereSql2.(int)$start_level;
        else {
            $whereSql = ($end_level <= $start_level)
                ? $whereSql1.'='.$whereSql2.(int)$start_level
                : ' AND '.$this->table.'.'.$this->_level.' BETWEEN _'.$this->table.'.'.$this->_level.'+'.(int)$start_level
                    .' AND _'.$this->table.'.'.$this->_level.'+'.(int)$end_level;
        }

        $this->sql = $this->sqlComposeSelect(array(
            '', // Params
            '', // Fields
            $this->table.' _'.$this->table.', '.$this->table, // Tables
            '_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
                .' AND '.$this->table.'.'.$this->_left.' BETWEEN _'.$this->table.'.'.$this->_left.' AND _'.$this->table.'.'.$this->_right
                .$whereSql
        ));

        return $this->db->query($this->sql);
    }

//************************************************************************
// Enumerates the PATH from an element to its top level parent
// $ID : an ID of an element
// $showRoot : whether to show root node in a path
// Returns : a result id for using with other DB functions
    function enumPath($ID, $showRoot=false) {
        $this->sql = $this->sqlComposeSelect(array(
            '', // Params
            '', // Fields
            $this->table.' _'.$this->table.', '.$this->table, // Tables
            '_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
                .' AND _'.$this->table.'.'.$this->_left.' BETWEEN '.$this->table.'.'.$this->_left.' AND '.$this->table.'.'.$this->_right
                .(($showRoot) ? '' : ' AND '.$this->table.'.'.$this->_level.'>0'), // Where
            '', // GroupBy
            '', // Having
            $this->table.'.'.$this->_left // OrderBy
        ));

        return $this->db->query($this->sql);
    }

//************************************************************************
// Returns query result to fetch data of the element's parent
// $ID : an ID of an element which parent to be retrieved
// $level : Relative level of parent
// Returns : a result id for using with other DB functions
    function getParent($ID, $level=1) {
        if($level < 1) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

        $this->sql = $this->sqlComposeSelect(array(
            '', // Params
            '', // Fields
            $this->table.' _'.$this->table.', '.$this->table, // Tables
            '_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
                .' AND _'.$this->table.'.'.$this->_left.' BETWEEN '.$this->table.'.'.$this->_left.' AND '.$this->table.'.'.$this->_right
                .' AND '.$this->table.'.'.$this->_level.'=_'.$this->table.'.'.$this->_level.'-'.(int)$level // Where
        ));

        return $this->db->query($this->sql);
    }

//************************************************************************
    function sqlReset() {
        $this->qryParams = ''; $this->qryFields = ''; $this->qryTables = '';
        $this->qryWhere = ''; $this->qryGroupBy = ''; $this->qryHaving = '';
        $this->qryOrderBy = ''; $this->qryLimit = '';
        return true;
    }

//************************************************************************
    function sqlSetReset($resetMode) { $this->sqlNeedReset = ($resetMode) ? true : false; }

//************************************************************************
    function sqlParams($param='') { return (empty($param)) ? $this->qryParams : $this->qryParams = $param; }
    function sqlFields($param='') { return (empty($param)) ? $this->qryFields : $this->qryFields = $param; }
    function sqlSelect($param='') { return $this->sqlFields($param); }
    function sqlTables($param='') { return (empty($param)) ? $this->qryTables : $this->qryTables = $param; }
    function sqlFrom($param='') { return $this->sqlTables($param); }
    function sqlWhere($param='') { return (empty($param)) ? $this->qryWhere : $this->qryWhere = $param; }
    function sqlGroupBy($param='') { return (empty($param)) ? $this->qryGroupBy : $this->qryGroupBy = $param; }
    function sqlHaving($param='') { return (empty($param)) ? $this->qryHaving : $this->qryHaving = $param; }
    function sqlOrderBy($param='') { return (empty($param)) ? $this->qryOrderBy : $this->qryOrderBy = $param; }
    function sqlLimit($param='') { return (empty($param)) ? $this->qryLimit : $this->qryLimit = $param; }

//************************************************************************
    function sqlComposeSelect($arSql) {
        $joinTypes = array('join'=>1, 'cross'=>1, 'inner'=>1, 'straight'=>1, 'left'=>1, 'natural'=>1, 'right'=>1);

        $this->sql = 'SELECT '.$arSql[0].' ';
        if(!empty($this->qryParams)) $this->sql .= $this->sqlParams.' ';

        if(empty($arSql[1]) && empty($this->qryFields)) $this->sql .= $this->table.'.'.$this->id;
        else {
            if(!empty($arSql[1])) $this->sql .= $arSql[1];
            if(!empty($this->qryFields)) $this->sql .= ((empty($arSql[1])) ? '' : ',') . $this->qryFields;
        }
        $this->sql .= ' FROM ';
        $isJoin = ($tblAr=explode(' ',trim($this->qryTables))) && ($joinTypes[strtolower($tblAr[0])]);
        if(empty($arSql[2]) && empty($this->qryTables)) $this->sql .= $this->table;
        else {
            if(!empty($arSql[2])) $this->sql .= $arSql[2];
            if(!empty($this->qryTables)) {
                if(!empty($arSql[2])) $this->sql .= (($isJoin)?' ':',');
                elseif($isJoin) $this->sql .= $this->table.' ';
                $this->sql .= $this->qryTables;
            }
        }
        if((!empty($arSql[3])) || (!empty($this->qryWhere))) {
            $this->sql .= ' WHERE ' . $arSql[3] . ' ';
            if(!empty($this->qryWhere)) $this->sql .= (empty($arSql[3])) ? $this->qryWhere : 'AND('.$this->qryWhere.')';
        }
        if((!empty($arSql[4])) || (!empty($this->qryGroupBy))) {
            $this->sql .= ' GROUP BY ' . $arSql[4] . ' ';
            if(!empty($this->qryGroupBy)) $this->sql .= (empty($arSql[4])) ? $this->qryGroupBy : ','.$this->qryGroupBy;
        }
        if((!empty($arSql[5])) || (!empty($this->qryHaving))) {
            $this->sql .= ' HAVING ' . $arSql[5] . ' ';
            if(!empty($this->qryHaving)) $this->sql .= (empty($arSql[5])) ? $this->qryHaving : 'AND('.$this->qryHaving.')';
        }
        if((!empty($arSql[6])) || (!empty($this->qryOrderBy))) {
            $this->sql .= ' ORDER BY ' . $arSql[6] . ' ';
            if(!empty($this->qryOrderBy)) $this->sql .= (empty($arSql[6])) ? $this->qryOrderBy : ','.$this->qryOrderBy;
        }
        if(!empty($arSql[7])) $this->sql .= ' LIMIT '.$arSql[7];
        elseif(!empty($this->qryLimit)) $this->sql .= ' LIMIT '.$this->qryLimit;

        if($this->sqlNeedReset) $this->sqlReset();

        return $this->sql;
    }
//************************************************************************
}
?>