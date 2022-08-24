<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/reward/worker.php');
require_once ($CONFIG['engine_path'].'include/reward/reward.php');
require_once ($CONFIG['engine_path'].'include/reward/opinion.php');

spl_autoload_register(function ($class_name)
{
    if (file_exists(ENGINE_PATH.'include/reward/'.$class_name . '.php'))
    {
        include_once(ENGINE_PATH.'include/reward/'.mb_strtolower($class_name).'.php');
        return true;
    }
    return false;

});

class RewardMgr
{
    private $_workers = [];
    private $_rewards = [];
    private $_opinions = [];

    private $_cache     = null;

    public $_db         = null;
    public $_tables = [
        'workers' => 'workers',
        'rewards' => 'rewards',
        'opinions' => 'opinions',
    ];

    public function __construct()
    {
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('images');

        $this->_db = DBFactory::GetInstance($this->dbname);
        if($this->_db == false) {
            throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);
        }

        $this->_cache = $this->getCache();
    }

    public function getCache()
    {
        LibFactory::GetStatic('cache');

        $cache = new Cache();
        $cache->Init('memcache', 'rewardmgr');

        return $cache;
    }

    static function &getInstance ($caching = true)
    {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }

    // --- --- WORKER --- ---
    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Worker. В случае ошибки вернет null
     */
    private function _workerObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Worker($info);
        if (isset($info['id'])) {
            $this->_workers[$info['id'] ] = $obj;
        }

        return $obj;
    }

    public function GetWorkers($filter)
    {
        if(isset($filter['field'])) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if(!in_array($v, ['id', 'name', 'is_visible', 'ord'])) {
                    unset($filter['field'][$k], $filter['dir'][$k]);
                }
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if($v != 'ASC' && $v != 'DESC') {
                    $filter['dir'][$k] = 'ASC';
                }
            }
        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = ['name'];
            $filter['dir'] = ['ASC'];
        }

        if(isset($filter['flags']['is_visible']) && $filter['flags']['is_visible'] != -1 ) {
            $filter['flags']['is_visible'] = (int) $filter['flags']['is_visible'];
        } elseif (!isset($filter['flags']['is_visible'])) {
            $filter['flags']['is_visible'] = -1;
        }

        if(!isset($filter['offset']) || !is_numeric($filter['offset'])) {
            $filter['offset'] = 0;
        }

        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit'])) {
            $filter['limit'] = 0;
        }

        if ($filter['calc'] === true) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['workers'].'.* ';
        } else {
            $sql = 'SELECT '.$this->_tables['workers'].'.* ';
        }

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $sql.= ', COUNT(*) as GroupingCount ';
        }

        $sql .= ' FROM '.$this->_tables['workers'];

        $where = [];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = [];
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k])) {
                    $like[] = ' '.$this->_tables['workers'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                } else {
                    $like[] = ' '.$this->_tables['workers'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
                }
            }

            if($filter['filter']['cond']) {
                $where[] = implode(' AND ', $like);
            } else {
                $where[] = '('.implode(' OR ', $like).')';
            }
        }

        if(sizeof($where)) {
            $sql .= ' WHERE '.implode(' AND ', $where);
        }

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = [];
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['workers'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if(isset($filter['having']) && $filter['having']) {
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];
        }

        $sql.= ' ORDER by ';

        $sqlo = [];
        foreach($filter['field'] as $k => $v) {
            $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];
        }

        $sql .= implode(', ', $sqlo);

        if($filter['limit']) {
            $sql .= ' LIMIT ';

            if($filter['offset']) {
                $sql .= $filter['offset'].', ';
            }

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1) {
            echo ":".$sql;
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows ) {
            return false;
        }

        if ( $filter['calc'] === true ) {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = [];
        $ids = [];
        while($row = $res->fetch_assoc()) {
            $id = $row['id'];

            if($filter['flags']['objects'] === true) {
                if(isset($this->_workers[$id])) {
                    $row = $this->_workers[$id];
                } else {
                    $row = $this->_workerObject($row);
                }
            }

            $result[$id] = $row;
        }

        if($filter['calc'] === true) {
            return [$result, $count];
        }

        return $result;
    }

    /**
    * @return Объект Worker. В случае ошибки вернет null
    */
    public function GetWorker($id)
    {
        $id = intval($id);
        if($id <= 0) {
            return null;
        }

        if(isset($this->_workers[$id])) {
            return $this->_workers[$id];
        }

        $info = false;

        $cacheid = 'worker_'.$id;

        if($this->_cache !== null) {
            $info = $this->_cache->get($cacheid);
        }

        if($_GET['nocache']>12) {
            $info = false;
        }

        if($info === false) {
            $sql = 'SELECT * FROM '.$this->_tables['workers'].' WHERE id = '.$id;

            if(false === ($res = $this->_db->query($sql))) {
                return null;
            }

            if(!$res->num_rows) {
                return null;
            }

            $info = $res->fetch_assoc();

            if ($this->_cache !== null) {
                $this->_cache->set($cacheid, $info, 3600 * 24);
            }
        }

        $obj = $this->_workerObject($info);
        return $obj;
    }

    /**
    * @return id of added worker or false
    */
    public function AddWorker(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['id']);
        if(!sizeof($info)) {
            return false;
        }

        $fields = [];
        foreach($info as $k => $v) {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'INSERT INTO '.$this->_tables['workers'].' SET ' . implode(', ', $fields);

        if(false !== $this->_db->query($sql)) {
            return $this->_db->insert_id;
        }

        return false;
    }

    /**
    * @return id of update worker or false
    */
    public function UpdateWorker(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if(!sizeof($info) || !Data::Is_Number($info['id'])) {
            return false;
        }

        $fields = [];
        foreach($info as $k => $v) {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'UPDATE '.$this->_tables['workers'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE id = '.$info['id'];

        if($this->_db->query($sql) !== false) {
            $cache = $this->getCache();
            $cache->Remove('worker_'.$info['id']);

            unset($this->_workers[$info['id']]);
            return $info['id'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveWorker($id)
    {
        if(!Data::Is_Number($id) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['workers'].' WHERE id = '.$id;
        if(false !== $this->_db->query($sql))  {
            $cache = $this->getCache();
            $cache->Remove('worker_'.$id);

            unset($this->_workers[$id]);
            return true;
        }

        return false;
    }

    // --- --- END WORKER --- ---

    // --- --- REWARD --- ---
    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Reward. В случае ошибки вернет null
     */
    private function _rewardObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Reward($info);
        if(isset($info['id'])) {
            $this->_rewards[$info['id'] ] = $obj;
        }

        return $obj;
    }

    public function GetRewards($filter)
    {
        if(isset($filter['field'])) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if(!in_array($v, ['id', 'title', 'is_visible', 'ord'])) {
                    unset($filter['field'][$k], $filter['dir'][$k]);
                }
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }
        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = ['title'];
            $filter['dir'] = ['ASC'];
        }

        if(isset($filter['flags']['is_visible']) && $filter['flags']['is_visible'] != -1) {
            $filter['flags']['is_visible'] = (int) $filter['flags']['is_visible'];
        } elseif (!isset($filter['flags']['is_visible'])) {
            $filter['flags']['is_visible'] = -1;
        }

        if(isset($filter['flags']['worker_id']) && $filter['flags']['worker_id'] != -1) {
            $filter['flags']['worker_id'] = (int) $filter['flags']['worker_id'];
        } elseif (!isset($filter['flags']['worker_id'])) {
            $filter['flags']['worker_id'] = -1;
        }

        if(!isset($filter['offset']) || !is_numeric($filter['offset'])) {
            $filter['offset'] = 0;
        }

        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit'])) {
            $filter['limit'] = 0;
        }


        if($filter['calc'] === true) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['rewards'].'.* ';
        } else {
            $sql = 'SELECT '.$this->_tables['rewards'].'.* ';
        }

        if(isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $sql.= ', COUNT(*) as GroupingCount ';
        }

        $sql .= ' FROM '.$this->_tables['rewards'];

        $where = [];

        if($filter['flags']['is_visible'] != -1) {
            $where[] = ' '.$this->_tables['rewards'].'.is_visible = '.$filter['flags']['is_visible'];
        }

        if($filter['flags']['worker_id'] != -1) {
            $where[] = ' '.$this->_tables['rewards'].'.worker_id = '.$filter['flags']['worker_id'];
        }

        if(isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = [];
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['rewards'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['rewards'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond']) {
                $where[] = implode(' AND ', $like);
            } else {
                $where[] = '('.implode(' OR ', $like).')';
            }
        }

        if(sizeof($where)) {
            $sql .= ' WHERE '.implode(' AND ', $where);
        }

        if(isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = [];
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['rewards'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if(isset($filter['having']) && $filter['having']) {
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];
        }

        $sql.= ' ORDER by ';

        $sqlo = [];
        foreach($filter['field'] as $k => $v ) {
            $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];
        }

        $sql .= implode(', ', $sqlo);

        if($filter['limit']) {
            $sql .= ' LIMIT ';

            if($filter['offset']) {
                $sql .= $filter['offset'].', ';
            }

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1) {
            echo ":".$sql;
        }

        $res = $this->_db->query($sql);
        if(!$res || !$res->num_rows) {
            return false;
        }

        if($filter['calc'] === true) {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = [];
        $ids = [];
        while($row = $res->fetch_assoc()) {
            $id = $row['id'];

            if($filter['flags']['objects'] === true) {
                if(isset($this->_rewards[$id]) ) {
                    $row = $this->_rewards[$id];
                } else {
                    $row = $this->_rewardObject($row);
                }
            }
            $result[$id] = $row;
        }

        if($filter['calc'] === true) {
            return [$result, $count];
        }

        return $result;
    }

    /**
    * @param $id int 
    * @return Объект Reward. В случае ошибки вернет null
    */
    public function GetReward($id)
    {
        $id = intval($id);
        if($id <= 0) {
            return null;
        }

        // if ( isset($this->_rewards[$id]) )
        //     return $this->_rewards[$id];

        $info = false;

        $cacheid = 'reward_'.$id;

        // if ($this->_cache !== null) {
        //     $info = $this->_cache->get($cacheid);
        // }

        if($_GET['nocache'] > 12) {
            $info = false;
        }

        if ($info === false) {
            $sql = 'SELECT * FROM '.$this->_tables['rewards'].' WHERE id = '.$id;

            if( false === ($res = $this->_db->query($sql))) {
                return null;
            }

            if(!$res->num_rows) {
                return null;
            }


            $info = $res->fetch_assoc();

            // if ($this->_cache !== null) {
            //     $this->_cache->set($cacheid, $info, 3600 * 24);
            // }
        }

        $obj = $this->_rewardObject($info);
        return $obj;
    }

    /**
    * @return id of added reward or false
    */
    public function AddReward(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['id']);
        if(!sizeof($info)) {
            return false;
        }

        $fields = [];
        foreach($info as $k => $v) {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'INSERT INTO '.$this->_tables['rewards'].' SET ' . implode(', ', $fields);

        if(false !== $this->_db->query($sql)) {
            return $this->_db->insert_id;
        }

        return false;
    }

    /**
    * @return id of update reward or false
    */
    public function UpdateReward(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if(!sizeof($info) || !Data::Is_Number($info['id'])) {
            return false;
        }

        if($info['worker_id'] === 0) {
            unset($info['worker_id']);
        }

        $fields = [];
        foreach($info as $k => $v) {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'UPDATE '.$this->_tables['rewards'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE id = '.$info['id'];

        if($this->_db->query($sql) !== false) {
            $cache = $this->getCache();
            $cache->Remove('reward_'.$info['id']);

            unset($this->_rewards[$info['id']]);
            return $info['id'];
        }

        return false;
    }

    /**
    * @return id of update reward visibility or false
    */
    public function UpdateRewardVisibility($visibility, $rewardId)
    {
        $sql = 'UPDATE '.$this->_tables['rewards'].' SET is_visible=' . $visibility;
        $sql .= ' WHERE id = '.$rewardId;

        if($this->_db->query($sql) !== false) {
            return $visibility;
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveReward($id)
    {
        if(!Data::Is_Number($id)) {
            return false;
        }

        $sql = 'DELETE FROM '.$this->_tables['rewards'].' WHERE id = '.$id;
        if(false !== $this->_db->query($sql)) {
            $cache = $this->getCache();
            $cache->Remove('reward_'.$id);

            unset($this->_rewards[$id]);
            return true;
        }

        return false;
    }

    // --- --- END REWARD --- ---

    // --- --- OPINION --- ---
    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Opinion. В случае ошибки вернет null
     */
    private function _opinionObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Opinion($info);
        if (isset($info['id'])) {
            $this->_opinions[$info['id'] ] = $obj;
        }

        return $obj;
    }

    public function GetOpinions($filter)
    {
        if(isset($filter['field'])) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if(!in_array($v, ['id', 'name', 'position', 'text', 'is_visible', 'ord'])) {
                    unset($filter['field'][$k], $filter['dir'][$k]);
                }
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if($v != 'ASC' && $v != 'DESC') {
                    $filter['dir'][$k] = 'ASC';
                }
            }
        }

        if(!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = ['name'];
            $filter['dir'] = ['ASC'];
        }

        if(isset($filter['flags']['is_visible']) && $filter['flags']['is_visible'] != -1)  {
            $filter['flags']['is_visible'] = (int) $filter['flags']['is_visible'];
        } elseif (!isset($filter['flags']['is_visible'])) {
            $filter['flags']['is_visible'] = -1;
        }

        if(!isset($filter['offset']) || !is_numeric($filter['offset'])) {
            $filter['offset'] = 0;
        }

        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit'])) {
            $filter['limit'] = 0;
        }


        if($filter['calc'] === true) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['opinions'].'.* ';
        } else {
            $sql = 'SELECT '.$this->_tables['opinions'].'.* ';
        }

        if(isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $sql.= ', COUNT(*) as GroupingCount ';
        }

        $sql .= ' FROM '.$this->_tables['opinions'];

        $where = [];

        if($filter['flags']['is_visible'] != -1) {
            $where[] = ' '.$this->_tables['opinions'].'.is_visible = '.$filter['flags']['is_visible'];
        }

        if(isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = [];

            foreach($filter['filter']['fields'] as $k => $v) {
                if(!isset($filter['filter']['values'][$k])) {
                    $like[] = ' '.$this->_tables['opinions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                }
                else
                    $like[] = ' '.$this->_tables['opinions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if($filter['filter']['cond']) {
                $where[] = implode(' AND ', $like);
            } else {
                $where[] = '('.implode(' OR ', $like).')';
            }
        }

        if ( sizeof($where) ) {
            $sql .= ' WHERE '.implode(' AND ', $where);
        }

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = [];
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['opinions'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if(isset($filter['having']) && $filter['having']) {
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];
        }

        $sql.= ' ORDER by ';

        $sqlo = [];
        foreach( $filter['field'] as $k => $v ) {
            $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];
        }

        $sql .= implode(', ', $sqlo);

        if($filter['limit']) {
            $sql .= ' LIMIT ';

            if($filter['offset']) {
                $sql .= $filter['offset'].', ';
            }

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1) {
            echo ":".$sql;
        }

        $res = $this->_db->query($sql);
        if(!$res || !$res->num_rows) {
            return false;
        }

        if ( $filter['calc'] === true ) {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = [];
        $ids = [];
        while ($row = $res->fetch_assoc()) {
            $id = $row['id'];

            if ($filter['flags']['objects'] === true) {
                if(isset($this->_opinions[$id]) ) {
                    $row = $this->_opinions[$id];
                } else {
                    $row = $this->_opinionObject($row);
                }
            }

            $result[$id] = $row;
        }

        if($filter['calc'] === true) {
            return [$result, $count];
        }

        return $result;
    }

    /**
    * @param $id int 
    * @return Объект Opinion. В случае ошибки вернет null
    */
    public function GetOpinion($id)
    {
        $id = intval($id);
        if($id <= 0) {
            return null;
        }

        if(isset($this->_opinions[$id])) {
            return $this->_opinions[$id];
        }

        $info = false;

        $cacheid = 'opinion_'.$id;

        if($this->_cache !== null) {
            $info = $this->_cache->get($cacheid);
        }

        if($_GET['nocache']>12) {
            $info = false;
        }

        if($info === false) {
            $sql = 'SELECT * FROM '.$this->_tables['opinions'].' WHERE id = '.$id;

            if(false === ($res = $this->_db->query($sql))) {
                return null;
            }

            if(!$res->num_rows ) {
                return null;
            }

            $info = $res->fetch_assoc();

            if($this->_cache !== null) {
                $this->_cache->set($cacheid, $info, 3600 * 24);
            }
        }

        $obj = $this->_opinionObject($info);
        return $obj;
    }

    /**
    * @return id of added opinion or false
    */
    public function AddOpinion(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['id']);
        if(!sizeof($info)) {
            return false;
        }

        $fields = [];
        foreach($info as $k => $v) {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'INSERT INTO '.$this->_tables['opinions'].' SET ' . implode(', ', $fields);

        if(false !== $this->_db->query($sql)) {
            return $this->_db->insert_id;
        }

        return false;
    }

    /**
    * @return id of update opinion or false
    */
    public function UpdateOpinion(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if(!sizeof($info) || !Data::Is_Number($info['id'])) {
            return false;
        }

        $fields = [];
        foreach($info as $k => $v)  {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'UPDATE '.$this->_tables['opinions'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE id = '.$info['id'];

        if($this->_db->query($sql) !== false) {
            $cache = $this->getCache();
            $cache->Remove('opinion_'.$info['id']);

            unset($this->_opinions[$info['id']]);
            return $info['id'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveOpinion($id)
    {
        if(!Data::Is_Number($id)) {
            return false;
        }

        $sql = 'DELETE FROM '.$this->_tables['opinions'].' WHERE id = '.$id;
        if(false !== $this->_db->query($sql)) {
            $cache = $this->getCache();
            $cache->Remove('opinion_'.$id);

            unset($this->_opinions[$id]);
            return true;
        }

        return false;
    }

    // --- --- END OPINION --- ---

    public function GetWorkerForReward($worker_id)
    {
        return $this->GetWorker($worker_id);
    }

    public function IsWorkerHasRewards($workerId)
    {
        $rewards = $this->GetRewardsForWorker($workerId);
        if(is_array($rewards) && count($rewards) > 0)  {
            return true;
        }

        return false;
    }

    // public function GetRewardsForWorker($workerId)
    // {
    //     $sql = "SELECT * FROM ". $this->_tables['rewards'];
    //     $sql .= " WHERE worker_id = '".$workerId."'";

    //     if(false === ($res = $this->_db->query($sql))) {
    //         return false;
    //     }

    //     if(!$res->num_rows) {
    //         return false;
    //     }

    //     return true;
    // }

    public function getRewardsForWorker($workerId)
    {
        $filter = [
            'flags' => [
                'objects' => true,
                'worker_id' => $workerId
            ],
            'field' => ['ord'],
            'dir' => ['asc'],
            'dbg' => 0,
        ];

        $rewards = $this->GetRewards($filter);

        return $rewards;
    }
}