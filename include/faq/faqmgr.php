<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/faq/question.php');

class FaqMgr
{
    private $_questions = array();
    private $_cache  = null;


    public $_db         = null;
    public $_tables     = array(
        'faq' => 'faq',
    );

    public static $errors = [
        'form_request' => [
            'invalidDate'   => 'Дата введена неверно',
            'questionText'  => 'Не заполнен текст вопроса',
            'customerName'  => 'Укажите ваше имя',
            'customerPhone' => 'Не указан номер телефона',
            'customerPhone' => 'Неверный формат номера телефона',
            'customerEmail' => 'Неверный e-mail пользователя',
        ],
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
        $cache->Init('memcache', 'faqmgr');

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
    private function _questionObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Question($info);
        if (isset($info['questionid']))
            $this->_questions[ $info['questionid'] ] = $obj;

        return $obj;
    }


    /**
    * @return Объект Question. В случае ошибки вернет null
    */
    public function GetQuestion($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_questions[$id]) )
            return $this->_questions[$id];

        $info = false;

        $cacheid = 'question_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['faq'].' WHERE QuestionID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_questionObject($info);
        return $obj;
    }

    /**
    * @return id of added question or false
    */
    public function AddQuestion(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['questionid']);
        $info['created'] = time();
        $info['lastupdated'] = time();
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['faq'].' SET ' . implode(', ', $fields);
        if(MODE === 'dev')
        {
            error_log('Add question sql: '.$sql."\n");
        }

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated question or false
    */
    public function UpdateQuestion(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['questionid']) )
            return false;

        $info['lastupdated'] = time();

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['faq'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE QuestionID = '.$info['questionid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('question_'.$info['questionid']);

            unset($this->_questions[$info['questionid']]);
            return $info['questionid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveQuestion($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $question = $this->GetQuestion($id);
        if($question == null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['faq'].' WHERE QuestionID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('question_'.$id);

            unset($this->_questions[$id]);
            return true;
        }

        return false;
    }

    public function GetQuestions($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'LastUpdated', 'ord', 'question', 'isvisible', 'isanswered')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Question');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['faq'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['faq'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['faq'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['faq'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['faq'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['faq'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['IsAnswered'] != -1 )
            $where[] = ' '.$this->_tables['faq'].'.IsAnswered = '.$filter['flags']['IsAnswered'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['faq'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['faq'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['faq'].'.`'.$v.'`';
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
                $id = $row['QuestionID'];
                if ( isset($this->_questions[$id]) )
                    $row = $this->_questions[$id];
                else
                    $row = $this->_questionObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

}