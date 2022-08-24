<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/osgallery/osgroup.php');
require_once ($CONFIG['engine_path'].'include/osgallery/osphoto.php');
require_once ($CONFIG['engine_path'].'include/osgallery/osfilter.php');
require_once ($CONFIG['engine_path'].'include/osgallery/ospage.php');

class OSGalleryMgr
{
    private $_groups  = array();
    private $_photos  = array();
    private $_pages  = array();
    private $_filters = array();
    private $_cache  = null;


    public $_db         = null;
    public $_tables     = array(
        'groups'        => 'os_gallery_groups',
        'photos'        => 'os_gallery_photos',
        'pages'         => 'os_gallery_page',
        'filters'       => 'os_gallery_filters',
        'filter_params' => 'os_gallery_filter_params',
        'group_filters' => 'os_gallery_filter_refs',
    );

    public static $errors = [
        'offer' => [
            'invalidDate'    => 'Дата введена неверно',
            'noConfirmation' => 'Необходимо ознакомиться с информацией',
            'customerName'   => 'Укажите ваше имя',
            // 'customerPhone'  => 'Не указан номер телефона',
            'customerPhone'  => 'Неверный формат номера телефона',
            'customerEmail'  => 'Неверный e-mail пользователя',
            'customerContact' => 'Необходимо заполнить поле',
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
        $cache->Init('memcache', 'osgallerymgr');

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

        $obj = new OSGroup($info);
        if (isset($info['groupid']))
            $this->_groups[ $info['groupid'] ] = $obj;

        return $obj;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Page. В случае ошибки вернет null
     */
    private function _pageObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new OSPage($info);
        if (isset($info['pageid']))
            $this->_page[ $info['pageid'] ] = $obj;

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
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['groups'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['groups'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['groups'].' ';

        if(isset($filter['flags']['params']) && is_array($filter['flags']['params']) && count($filter['flags']['params']) > 0 )
        {
            $sql .= ' INNER JOIN '. $this->_tables['group_filters'] .' ON '.$this->_tables['group_filters'].'.GroupID = '.$this->_tables['groups'].'.GroupID';
            $sql .= ' AND '.$this->_tables['group_filters'].'.ParamID IN ('.implode(", ", $filter['flags']['params']).')';
        }

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['groups'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['groups'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['groups'].'.IsVisible = '.$filter['flags']['IsVisible'];

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

        $obj = new OSPhoto($info);
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
     * @return Объект OSFilter. В случае ошибки вернет null
     */
    private function _filterObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $filter = new OSFilter($info);
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
            $cache->Remove('os_gallery_filter_'.$id);

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
            $cache->Remove('os_gallery_filter_'.$info['filterid']);

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

        $cacheid = 'os_gallery_filter_'.$id;

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


        $sql = "SELECT * FROM ".$this->_tables['filters'];

        // if(isset($filter['flags']['ServiceID'] && is_int($filter['flags']['ServiceID'])) {
        //     $sql .= ' WHERE ServiceID = '.$filter['flags']['ServiceID'];
        // }

        $sql .= " ORDER BY Name";


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
    * @return Объект Page. В случае ошибки вернет null
    */
    public function GetPage($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_pages[$id]) )
            return $this->_pages[$id];

        $info = false;

        $cacheid = 'page_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['pages'].' WHERE PageID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_pageObject($info);
        return $obj;
    }

    /**
    * @return Объект Page. В случае ошибки вернет null
    */
    public function GetPageBySection($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_pages[$id]) )
            return $this->_pages[$id];

        $info = false;

        $cacheid = 'page_section_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['pages'].' WHERE SectionID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_pageObject($info);
        return $obj;
    }

    /**
    * @return id of added item or false
    */
    public function AddPage(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['pageid']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['pages'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated item or false
    */
    public function UpdatePage(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['pageid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['pages'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE PageID = '.$info['pageid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('page_'.$info['pageid']);
            $cache->Remove('page_section_'.$info['sectionid']);

            unset($this->_pages[$info['pageid']]);
            return $info['pageid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemovePage($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $page = $this->GetPage($id);
        if($page == null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['groups'].' WHERE PageID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('page_'.$id);
            $cache->Remove('page_section_'.$page->sectionid);

            unset($this->_pages[$id]);
            return true;
        }

        return false;
    }

    public function GetPages($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Title')) )
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
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['pages'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['pages'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['pages'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['pages'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['pages'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['pages'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['SectionID'] != -1 )
            $where[] = ' '.$this->_tables['pages'].'.SectionID = '.$filter['flags']['SectionID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['pages'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['pages'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['pages'].'.`'.$v.'`';
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
                $id = $row['PageID'];
                if ( isset($this->_pages[$id]) )
                    $row = $this->_pages[$id];
                else
                    $row = $this->_groupObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

}