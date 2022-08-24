<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/service/group.php');
require_once ($CONFIG['engine_path'].'include/service/sphoto.php');
require_once ($CONFIG['engine_path'].'include/service/sfilter.php');
require_once ($CONFIG['engine_path'].'include/service/service.php');

class ServiceMgr
{
    private $_groups   = array();
    private $_photos   = array();
    private $_services = array();
    private $_filters  = array();
    private $_cache    = null;


    public $_db         = null;
    public $_tables     = array(
        'services'         => 'service',
        'groups'        => 'service_groups',
        'photos'        => 'service_photos',
        'filters'       => 'service_filters',
        'filter_params' => 'service_filter_params',
        'group_filters' => 'service_filter_refs',
    );

    public static $errors = [
        'offer' => [
            'invalidDate'    => 'Дата введена неверно',
            'noConfirmation' => 'Необходимо ознакомиться с информацией',
            'customerName'   => 'Укажите ваше имя',
            // 'customerPhone'  => 'Не указан номер телефона',
            'customerPhone'  => 'Неверный формат номера телефона',
            'customerEmail'  => 'Неверный e-mail пользователя',
            'Text'           => 'Не заполнен текст',
        ],
    ];

    public static $THEMES = [
        1 => ['class' => 'purple', 'name' => 'фиолетовая'],
        2 => ['class' => 'purple-dark', 'name' => 'темно-фиолетовая'],
        3 => ['class' => 'green-muted', 'name' => 'приглушенно-зелелная'],
        4 => ['class' => 'grey', 'name' => 'серая'],
        5 => ['class' => 'orange', 'name' => 'оранжевая'],
        6 => ['class' => 'red', 'name' => 'красная'],
    ];

    public function __construct()
    {
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('images');

        $this->_db = DBFactory::GetInstance($this->dbname);
        if($this->_db == false)
            throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);

        $this->_cache = $this->getCache();
    }

    public function getCache()
    {
        LibFactory::GetStatic('cache');

        $cache = new Cache();
        $cache->Init('memcache', 'servicemgr');

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

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Group. В случае ошибки вернет null
     */
    private function _groupObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Group($info);
        if (isset($info['groupid']))
            $this->_groups[ $info['groupid'] ] = $obj;

        return $obj;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Service. В случае ошибки вернет null
     */
    private function _serviceObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Service($info);
        if (isset($info['serviceid']))
            $this->_service[ $info['serviceid'] ] = $obj;

        return $obj;
    }


    /**
    * @return Объект Group. В случае ошибки вернет null
    */
    public function GetGroup($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_groups[$id]) )
            return $this->_groups[$id];

        $info = false;

        $cacheid = 'group_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['groups'].' WHERE GroupID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_groupObject($info);
        return $obj;
    }

    /**
    * @return id of added item or false
    */
    public function AddGroup(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['groupid']);
        unset($info['created']);
        unset($info['updated']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['groups'].' SET Created=NOW(), Updated=NOW(), ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated item or false
    */
    public function UpdateGroup(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['groupid']) )
            return false;

        unset($info['updated']);
        unset($info['created']);

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['groups'].' SET Updated=NOW(), ' . implode(', ', $fields);
        $sql .= ' WHERE GroupID = '.$info['groupid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('group_'.$info['groupid']);

            unset($this->_groups[$info['groupid']]);
            return $info['groupid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveGroup($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $group = $this->GetGroup($id);
        if($group == null)
            return false;

        $filter = [
            'flags' => [
                'objects' => true,
                'GroupID' => $group->id,
            ],
        ];

        $photos = $this->GetPhotos($filter);
        if(count($photos) > 0) {
            foreach($photos as $photo)
                $photo->Remove();
        }


        $sql = 'DELETE FROM '.$this->_tables['groups'].' WHERE GroupID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('group_'.$id);

            unset($this->_groups[$id]);
            return true;
        }

        return false;
    }

    public function GetGroups($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'Updated', 'ord', 'name', 'isvisible', 'groupid')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('groupid');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['SectionID']) && $filter['flags']['SectionID'] != -1 )
            $filter['flags']['SectionID'] = (int) $filter['flags']['SectionID'];
        elseif (!isset($filter['flags']['SectionID']))
            $filter['flags']['SectionID'] = -1;

        if ( isset($filter['flags']['ServiceID']) && $filter['flags']['ServiceID'] != -1 )
            $filter['flags']['ServiceID'] = (int) $filter['flags']['ServiceID'];
        elseif (!isset($filter['flags']['ServiceID']))
            $filter['flags']['ServiceID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT DISTINCT SQL_CALC_FOUND_ROWS '.$this->_tables['groups'].'.* ';
        else
            $sql = 'SELECT DISTINCT '.$this->_tables['groups'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['groups'].' ';

        if(isset($filter['flags']['params']) && is_array($filter['flags']['params']) && count($filter['flags']['params']) > 0 )
        {
            foreach($filter['flags']['params'] as $key => $value) {
                $sql .= ' INNER JOIN '. $this->_tables['group_filters'] .' AS f'.$key.' ON f'.$key.'.GroupID = '.$this->_tables['groups'].'.GroupID';
                $sql .= ' AND f'.$key.'.ParamID IN ('.implode(", ", $value).')';
            }
           // $sql .= ' INNER JOIN '. $this->_tables['group_filters'] .' ON '.$this->_tables['group_filters'].'.GroupID = '.$this->_tables['groups'].'.GroupID';
            //$sql .= ' AND '.$this->_tables['group_filters'].'.ParamID IN ('.implode(", ", $filter['flags']['params']).')';
        }

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['groups'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['groups'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['groups'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['ServiceID'] != -1 )
            $where[] = ' '.$this->_tables['groups'].'.ServiceID = '.$filter['flags']['ServiceID'];

        if ( $filter['flags']['SectionID'] != -1 )
            $where[] = ' '.$this->_tables['groups'].'.SectionID = '.$filter['flags']['SectionID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['groups'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['groups'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['groups'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= ' HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
        {
            echo $sql;
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['GroupID'];
                if ( isset($this->_groups[$id]) )
                    $row = $this->_groups[$id];
                else
                    $row = $this->_groupObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    //  ======================================
    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Photo. В случае ошибки вернет null
     */
    private function _photoObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new SPhoto($info);
        if (isset($info['photoid']))
            $this->_photos[ $info['photoid'] ] = $obj;

        return $obj;
    }


    /**
    * @return Объект Photo. В случае ошибки вернет null
    */
    public function GetPhoto($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_photos[$id]) )
            return $this->_photos[$id];

        $info = false;

        $cacheid = 'photo_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_photoObject($info);
        return $obj;
    }

    /**
    * @return id of added item or false
    */
    public function AddPhoto(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['photoid']);
        unset($info['created']);
        unset($info['updated']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['photos'].' SET Created=NOW(), Updated=NOW(), ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated item or false
    */
    public function UpdatePhoto(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['photoid']) )
            return false;

        unset($info['created']);
        unset($info['updated']);

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['photos'].' SET Updated=NOW(), ' . implode(', ', $fields);
        $sql .= ' WHERE PhotoID = '.$info['photoid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('photo_'.$info['photoid']);

            unset($this->_photos[$info['photoid']]);
            return $info['photoid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemovePhoto($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $photo = $this->GetPhoto($id);
        if($photo == null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('photo_'.$id);

            unset($this->_photos[$id]);
            return true;
        }

        return false;
    }

    public function GetPhotos($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'Updated', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Ord');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['GroupID']) && $filter['flags']['GroupID'] != -1 )
            $filter['flags']['GroupID'] = (int) $filter['flags']['GroupID'];
        elseif (!isset($filter['flags']['GroupID']))
            $filter['flags']['GroupID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['photos'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['photos'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['photos'].' ';

        $where = array();

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['photos'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['photos'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['photos'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['GroupID'] != -1 )
            $where[] = ' '.$this->_tables['photos'].'.GroupID = '.$filter['flags']['GroupID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['photos'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
        {
            echo $sql;
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['PhotoID'];
                if ( isset($this->_photos[$id]) )
                    $row = $this->_photos[$id];
                else
                    $row = $this->_photoObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** Filters *******/
    /*
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект SFilter. В случае ошибки вернет null
     */
    private function _filterObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $filter = new SFilter($info);
        if (isset($info['filterid']))
            $this->_filters[ $info['filterid'] ] = $filter;

        return $filter;
    }

    public function AddFilter(array $info)
    {
        unset($info['filterid']);
        if ( !sizeof($info) )
            return false;



        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['filters'].' SET '. implode(', ', $fields);


        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveFilter($id)
    {
        if ( !Data::Is_Number($id) )
            return false;


        if ($this->_filters[$id])
            $filter = $this->_filters[$id];
        else
            $filter = $this->GetFilter($id);

        if ($filter !== null)
        {
            $params = $filter->GetParams();
            if (is_array($params) && count($params) > 0)
            {
                foreach($params as $k => $v)
                    $filter->RemoveParam($k);
            }
        }

        $sql = 'DELETE FROM '.$this->_tables['filters'].' WHERE filterid = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('service_filter_'.$id);

            unset($this->_filters[$id]);
            return true;
        }

        return false;
    }

    public function UpdateFilter(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['filterid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".$v."'";

        $sql = 'UPDATE '.$this->_tables['filters']. ' SET '. implode(', ', $fields);
        $sql .= ' WHERE FilterID = '.$info['filterid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('service_filter_'.$info['filterid']);

            return true;
        }

        return false;
    }

    public function GetFilter($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_filters[$id]))
            return $this->_filters[$id];

        $info = false;

        $cacheid = 'service_filter_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['filters'].' WHERE FilterID = '.$id;
            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_filterObject($info);
    }

    public function GetFilterByName($filter_name, $isavailable = null)
    {
        if(!$filter_name)
            return null;

        $sql = "SELECT * FROM ".$this->_tables['filters']." WHERE NameID = '".$filter_name."'";
        // if($isavailable !== null)
        //     $sql .= " AND IsAvailable = " .intval($isavailable);

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();
        return $this->_filterObject($info);
    }

    public function GetFilters($filter)
    {
        global $OBJECTS;


        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if(isset($filter['service_ids']) && is_array($filter['service_ids'])) {
            $services = implode(', ', $filter['service_ids']);
        }

        $sql = "SELECT * FROM ".$this->_tables['filters'];
        if(!is_null($services)) 
            $sql .= " WHERE ".$this->_tables['filters'].'.ServiceID IN('.$services.')';
        

        if(!empty($filter['field'])) {
            $sql .= " ORDER BY ";
            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);
        }
        



        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;


        $result = array();
        while ($row = $res->fetch_assoc())
        {

            if ( isset($this->_filters[$row['filterid']]) )
                $row = $this->_filters[$row['filterid']];
            else
                $row = $this->_filterObject($row);

            $result[] = $row;
        }

        return $result;
    }

    /******** End filters ********/

    /**
    * @return Объект Service. В случае ошибки вернет null
    */
    public function GetService($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_services[$id]) )
            return $this->_services[$id];

        $info = false;

        $cacheid = 'service_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['services'].' WHERE ServiceID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_serviceObject($info);
        return $obj;
    }

    public function GetServiceByPath($path)
    {
        if(mb_strlen($path) == 0)
            return null;

        $sql  = "SELECT * FROM ".$this->_tables['services'];
        $sql .= " WHERE Url='".addslashes($path)."'";

        if ( false === ($res = $this->_db->query($sql)))
                return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();
        return $this->GetService($info['ServiceID']);
    }

    /**
    * @return id of added item or false
    */
    public function AddService(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['serviceid']);
        unset($info['created']);
        unset($info['updated']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['services'].' SET Created=NOW(), Updated=NOW(), ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated item or false
    */
    public function UpdateService(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['serviceid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['services'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE ServiceID = '.$info['serviceid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('service_'.$info['serviceid']);

            unset($this->_services[$info['serviceid']]);
            return $info['serviceid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveService($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $service = $this->GetService($id);
        if($service == null)
            return false;

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => -1,
                'ServiceID' => $id,
            ],
        ];

        $groups = $this->GetGroups($filter);
        foreach($groups as $group) {
            $group->Remove();
        }

        $sql = 'DELETE FROM '.$this->_tables['services'].' WHERE ServiceID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('service_'.$id);

            unset($this->_services[$id]);
            return true;
        }

        return false;
    }

    public function GetServices($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('title', 'isvisible')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Title');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['SectionID']) && $filter['flags']['SectionID'] != -1 )
            $filter['flags']['SectionID'] = (int) $filter['flags']['SectionID'];
        elseif (!isset($filter['flags']['SectionID']))
            $filter['flags']['SectionID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['services'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['services'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['services'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['services'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['services'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['services'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['SectionID'] != -1 )
            $where[] = ' '.$this->_tables['services'].'.SectionID = '.$filter['flags']['SectionID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['services'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['services'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['services'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
        {
            echo $sql;
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['ServiceID'];
                if ( isset($this->_services[$id]) )
                    $row = $this->_services[$id];
                else
                    $row = $this->_serviceObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    //------------------Таблица alert-----------------------------

    public static $MESSAGE = [
        ORDER               => 'Оплачен новый заказ!',
        WEDDING             => 'Новая заявка на свадебный букет!',
        SERVICE             => 'Новая заявка на услугу ',
        CORPORATE_CUSTOMERS => 'Новая заявка со страницы Корпоративным клиентам!',
        REVIEW              => 'Оставлен новый отзыв!',
        FAQ                 => 'Задан новый вопрос!', 
        CALLBACK            => 'Новый заказ на обратный звонок!',
        FEEDBACK            => 'Новое письмо обратной связи!',
        ARTIFICIAL          => 'Заказ искусственных цветов!',
    ];


    public static $COLOR = [
        ORDER               => '#4f2370',
        WEDDING             => '#343434',
        SERVICE             => '#97a744',
        CORPORATE_CUSTOMERS => '#3372BD',
        REVIEW              => '#e73a62',
        FAQ                 => '#0fc0c6', 
        CALLBACK            => '#e73a62',
        FEEDBACK            => '#e73a62',
        ARTIFICIAL          => '#206119',
    ];

    public function getAlerts() {
        $sql = 'SELECT * FROM alert WHERE IsNew = 1 ORDER BY Created ASC';
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows ) {
           return ['is_exist' => 0,];
        } else {
            while ($row = $res->fetch_assoc())
            {
                $result[] = $row;
            }
            return ['is_exist' => 1, 'alerts' => $result];
        }
        exit;
    }


    public function getAlert($params) {
        $sql = 'SELECT * FROM alert WHERE Name=\''.$params['Name'].'\' AND SectionID = '.$params['SectionID'];
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows ) {
           return false;
        } else {
            while ($row = $res->fetch_assoc())
            {
                $result[] = $row;
            }
            return $result;
        }
        exit;
    }

    public function addAlert($params) {
        if($params['SectionID'] < 1)
            return false;

        if($this->getAlert($params))
            $sql = 'UPDATE alert SET IsNew = 1, Created = TIMESTAMP(NOW()), Color = \''.$params['Color'].'\' WHERE Name=\''.$params['Name'].'\' AND SectionID = '.$params['SectionID'];
        else 
            $sql = 'INSERT INTO alert (Name, SectionID, Color) VALUES (\''.$params['Name'].'\', '.$params['SectionID'].', \''.$params['Color'].'\')';
        $this->_db->query($sql);
    }



    public function toggleIsNew($id) {
        $sql = 'UPDATE alert SET IsNew = 0 WHERE AlertID = '.intval($id);
        if($this->_db->query($sql))
            return true;
        else
            return false;
    }

    //-----------------------------------------------------------

}