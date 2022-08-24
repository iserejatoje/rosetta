<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/news/news.php');

class NewsMgr
{
    private $_news = array();
    private $_cache  = null;


    public $_db         = null;
    public $_tables     = array(
        'news' => 'news',
    );

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
        $cache->Init('memcache', 'newsmgr');

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
     * @return Объект Product. В случае ошибки вернет null
     */
    private function _newsObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new News($info);
        if (isset($info['newsid']))
            $this->_news[ $info['newsid'] ] = $obj;

        return $obj;
    }


    /**
    * @return Объект News. В случае ошибки вернет null
    */
    public function GetNews($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_news[$id]) )
            return $this->_news[$id];

        $info = false;

        $cacheid = 'news_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['news'].' WHERE NewsID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_newsObject($info);
        return $obj;
    }

    /**
    * @return id of added news or false
    */
    public function AddNews(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['newsid']);

        unset($info['created']);
        unset($info['updated']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";
        $sql = 'INSERT INTO '.$this->_tables['news'].' SET Created=NOW(), Updated=NOW(), ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated news or false
    */
    public function UpdateNews(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['newsid']) )
            return false;

        unset($info['updated']);
        unset($info['created']);
        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['news'].' SET Updated=NOW(), ' . implode(', ', $fields);
        $sql .= ' WHERE NewsID = '.$info['newsid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('news_'.$info['newsid']);

            unset($this->_news[$info['newsid']]);
            return $info['newsid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveNews($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $news = $this->GetNews($id);
        if($news == null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['news'].' WHERE NewsID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('news_'.$id);

            unset($this->_news[$id]);
            return true;
        }

        return false;
    }

    public function GetNewsList($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'Updated', 'ord', 'published', 'title', 'isvisible')) )
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

        if ( isset($filter['flags']['Year']) && $filter['flags']['Year'] != -1 )
            $filter['flags']['Year'] = (int) $filter['flags']['Year'];
        elseif (!isset($filter['flags']['Year']))
            $filter['flags']['Year'] = -1;

        if ( isset($filter['flags']['YearLess']) && $filter['flags']['YearLess'] != -1 )
            $filter['flags']['YearLess'] = (int) $filter['flags']['YearLess'];
        elseif (!isset($filter['flags']['YearLess']))
            $filter['flags']['YearLess'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['news'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['news'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['news'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['news'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['news'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['news'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['Year'] != -1 )
            $where[] = ' YEAR('.$this->_tables['news'].'.Published) = '.$filter['flags']['Year'];

        if ( $filter['flags']['YearLess'] != -1 )
            $where[] = ' YEAR('.$this->_tables['news'].'.Published) < '.$filter['flags']['YearLess'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['news'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['news'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['news'].'.`'.$v.'`';
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
                $id = $row['NewsID'];
                if ( isset($this->_news[$id]) )
                    $row = $this->_news[$id];
                else
                    $row = $this->_newsObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function GetYears($withoutcurrent = false)
    {
        $sql  = "SELECT DISTINCT YEAR(Published) as Year FROM ".$this->_tables['news'];
        $sql .= " WHERE IsVisible = 1";
        $sql .= " ORDER BY Published DESC";

        if ( false === ($res = $this->_db->query($sql)))
            return [];

        if (!$res->num_rows )
            return [];

        $result = [];
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row['Year'];
        }

        if($withoutcurrent) {
            $key = array_search(date("Y", time()), $result);
            if(!is_null($key))
                unset($result[$key]);
        }

        return $result;
    }

}