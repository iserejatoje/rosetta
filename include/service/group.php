<?php

LibFactory::GetStatic('arrays');

class Group
{
    private $_fields = array(
        'groupid'   => 'int',
        'serviceid' => 'int',
        'updated'   => 'int',
        'created'   => 'int',
        'ord'       => 'int',
        'sectionid' => 'int',
        'isvisible' => 'bool',
        'thumb'     => 'photo',
        'name'      => 'string',
        'text'      => 'string',
    );

    private $_values = array();

    private $resize_params = array(
        'thumb' => null,
    );

    private $_images_dir = '/common_fs/i/common_service_group/';
    private $_images_url = '/resources/fs/i/common_service_group/';

    private $file_size = 2097152; //2M


    function __construct(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

        if ( isset($info['groupid']) && Data::Is_Number($info['groupid']) )
            $this->_values["groupid"] = $info['groupid'];
        else
            $this->_values["groupid"] = 0;

        foreach ($this->_fields as $key => $type)
        {
            switch ($type)
            {
                case 'int':
                    $this->_values[$key] = intval($info[$key]);
                    break;

                case 'string':
                    $this->_values[$key] = stripslashes($info[$key]);
                    break;

                case 'float':
                    $this->_values[$key] = Data::NormalizeFloat($info[$key]);
                    break;

                case 'bool':
                    $this->_values[$key] = $info[$key] ? true : false;
                    break;

                default:
                    $this->_values[$key] = $info[$key];
                    break;
            }
        }
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['groupid'];

        if ($name == 'photos') {
            $filter = [
                'flags' => [
                    'objects' => true,
                    'IsVisible' => 1,
                    'GroupID' => $this->_values['groupid'],
                ],
                'field' => ['Ord'],
                'dir' => ['ASC'],
                'calc' => false,
                'dbg' => 0,
            ];

            $photos = ServiceMgr::GetInstance()->GetPhotos($filter);
            return $photos;
        }

        if(isset($this->_values[$name]))
        {
            switch ($this->_fields[$name])
            {
                case 'photo':
                    if (!$this->_values[$name])
                        return null;

                    try
                    {
                        $img_obj = FileStore::ObjectFromString($this->_values[$name]);
                        $img_obj['file'] = FileStore::GetPath($img_obj['file']);
                        $preparedImage = Images::PrepareImageFromObject($img_obj,
                            $this->_images_dir, $this->_images_url);
                        unset($img_obj);
                        if (empty($preparedImage))
                            return null;
                    }
                    catch ( MyException $e )
                    {
                        echo $fail; exit;
                        return null;
                    }

                    return array(
                        'f' => $preparedImage['url'],
                        'w' => $preparedImage['w'],
                        'h' => $preparedImage['h'],
                    );
                    break;

                default:
                    return $this->_values[$name];
            }
        }

        return null;
    }

    public function __set($name, $value)
    {
        $name = strtolower($name);

        if (isset($this->_fields[$name]))
        {
            switch ($this->_fields[$name])
            {
                case 'int':
                    $this->_values[$name] = (int)$value;
                    break;

                case 'float':
                    $this->_values[$name] = Data::NormalizeFloat($value);
                    break;

                case 'string':
                    $this->_values[$name] = stripslashes($value);
                    break;

                case 'bool':
                    $this->_values[$name] = (int)$value;
                    break;

                case 'photo':
                    if ($value === null)
                    {
                        if (!empty($this->_values[$name]))
                            $this->_deletePhoto($name);

                        $this->_values[$name] = '';
                        return $value;
                    }
                    try
                    {
                        if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
                        {
                            $file = $this->_images_dir.FileStore::GetPath($img_obj['file']);
                            if (FileStore::IsFile($file)) {
                                $this->__set($name, null);
                                return $this->_values[$name] = FileStore::ObjectToString($img_obj);
                            }
                        }
                    }
                    catch(MyException $e) { }
                    break;

                default:
                    $this->_values[$name] = $value;
                    break;
            }
        }
    }

    /**
    * @param $name = name of table cell in low register
    *
    */
    private function _deletePhoto($name)
    {
        if (!isset($this->_fields[$name]))
            return false;
        try
        {
            if( ($file_obj = FileStore::ObjectFromString($this->_values[$name])) !== false )
            {
                $del_file = $this->_images_dir.FileStore::GetPath_NEW($file_obj['file']);
                if (FileStore::IsFile($del_file))
                    return FileStore::Delete_NEW($del_file);
            }
        }
        catch(MyException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    /**
    * @param $inputName - name of form input from admin template
    * @param $name - the name of table column for photos
    *
    */
    public function Upload($inputName, $name)
    {
        $name = strtolower($name);

        if (empty($_FILES[$inputName]['name']))
            return false;

        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('filemagic');

        $pname = FileStore::Upload_NEW(
            $inputName, $this->_images_dir, rand(1000, 9999).$this->_values['groupid'].'_'.mb_strtolower($name),
            FileMagic::MT_WIMAGE, $this->file_size,
            $this->resize_params[$name]
        );

        $pname = FileStore::GetPath_NEW($pname);
        $photoNew = Images::PrepareImageToObject($pname, $this->_images_dir);
        $pname = FileStore::ObjectToString($photoNew);

        $this->__set($name , $pname);
        return true;
    }

    public function Update()
    {
        if ($this->_values['groupid'] === 0)
        {
            return  $this->_values["groupid"] = ServiceMgr::getInstance()->AddGroup($this->_values);
        }
        else
        {
            return ServiceMgr::getInstance()->UpdateGroup($this->_values);
        }
    }

//  Удаление
    public function Remove()
    {
        if ($this->_values['groupid'] === 0)
            return false;

        //remove photos
        foreach ($this->_fields as $name => $type)
        {
            if ($type == 'photo')
            {
                $this->__set($name, null);
            }
        }

        return ServiceMgr::getInstance()->RemoveGroup($this->_values['groupid']);
    }

    // /**
    //  * Сформировать объект по массиву данных
    //  *
    //  * @param array $info - массив полей со значениями
    //  * @return Объект Photo. В случае ошибки вернет null
    //  */
    // private function _photoObject(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     $obj = new Photo($info);
    //     if (isset($info['photoid']))
    //         $this->_photos[ $info['photoid'] ] = $obj;

    //     return $obj;
    // }


    // /**
    // * @return Объект Photo. В случае ошибки вернет null
    // */
    // public function GetPhoto($id)
    // {
    //     $id = intval($id);
    //     if ($id <= 0)
    //         return null;

    //     if ( isset($this->_photos[$id]) )
    //         return $this->_photos[$id];

    //     $info = false;

    //     $cacheid = 'photo_'.$id;

    //     if ($this->_cache !== null)
    //         $info = $this->_cache->get($cacheid);

    //     if ($_GET['nocache']>12)
    //         $info = false;

    //     if ($info === false)
    //     {
    //         $sql = 'SELECT * FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;

    //         if ( false === ($res = $this->_db->query($sql)))
    //             return null;

    //         if (!$res->num_rows )
    //             return null;

    //         $info = $res->fetch_assoc();

    //         if ($this->_cache !== null)
    //             $this->_cache->set($cacheid, $info, 3600 * 24);
    //     }

    //     $obj = $this->_photoObject($info);
    //     return $obj;
    // }

    // /**
    // * @return id of added item or false
    // */
    // public function AddPhoto(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     unset($info['photoid']);

    //     if ( !sizeof($info) )
    //         return false;

    //     $fields = array();
    //     foreach( $info as $k => $v)
    //         $fields[] = "`$k` = '".addslashes($v)."'";

    //     $sql = 'INSERT INTO '.$this->_tables['photos'].' SET Created=NOW, Updated=NOW(), ' . implode(', ', $fields);

    //     if ( false !== $this->_db->query($sql) )
    //         return $this->_db->insert_id;

    //     return false;
    // }

    // /**
    // * @return id of updated item or false
    // */
    // public function UpdatePhoto(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     if ( !sizeof($info) || !Data::Is_Number($info['photoid']) )
    //         return false;

    //     $info['updated'] = time();

    //     $fields = array();
    //     foreach( $info as $k => $v)
    //     {
    //         $fields[] = "`$k` = '".addslashes($v)."'";
    //     }
    //     $sql = 'UPDATE '.$this->_tables['photos'].' SET ' . implode(', ', $fields);
    //     $sql .= ' WHERE PhotoID = '.$info['photoid'];

    //     if($this->_db->query($sql) !== false)
    //     {
    //         $cache = $this->getCache();
    //         $cache->Remove('photo_'.$info['photoid']);

    //         unset($this->_photos[$info['photoid']]);
    //         return $info['photoid'];
    //     }

    //     return false;
    // }

    // /**
    // * @return bool
    // */
    // public function RemovePhoto($id)
    // {
    //     if ( !Data::Is_Number($id) )
    //         return false;

    //     $photo = $this->GetPhoto($id);
    //     if($photo == null)
    //         return false;

    //     $sql = 'DELETE FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
    //     if ( false !== $this->_db->query($sql) )
    //     {
    //         $cache = $this->getCache();
    //         $cache->Remove('photo_'.$id);

    //         unset($this->_photos[$id]);
    //         return true;
    //     }

    //     return false;
    // }

    // public function GetPhotos($filter)
    // {
    //     global $OBJECTS;
    //     if ( isset($filter['field']) ) {
    //         $filter['field'] = (array) $filter['field'];
    //         $filter['dir'] = (array) $filter['dir'];

    //         foreach($filter['field'] as $k => $v) {
    //             if ( !in_array($v, array('Created', 'Updated', 'Ord')) )
    //                 unset($filter['field'][$k], $filter['dir'][$k]);
    //         }

    //         foreach($filter['dir'] as $k => $v) {
    //             $v = strtoupper($v);
    //             if ( $v != 'ASC' && $v != 'DESC' )
    //                 $filter['dir'][$k] = 'ASC';
    //         }

    //     }

    //     if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
    //         $filter['field'] = array('Ord');
    //         $filter['dir'] = array('ASC');
    //     }

    //     // Видимые
    //     if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
    //         $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
    //     elseif (!isset($filter['flags']['IsVisible']))
    //         $filter['flags']['IsVisible'] = -1;

    //     if ( isset($filter['flags']['GroupID']) && $filter['flags']['GroupID'] != -1 )
    //         $filter['flags']['GroupID'] = (int) $filter['flags']['GroupID'];
    //     elseif (!isset($filter['flags']['GroupID']))
    //         $filter['flags']['GroupID'] = -1;

    //     if(!isset($filter['offset']) || !is_numeric($filter['offset']))
    //         $filter['offset'] = 0;
    //     if($filter['offset'] < 0) $filter['offset'] = 0;

    //     if(!isset($filter['limit']) || !is_numeric($filter['limit']))
    //         $filter['limit'] = 0;

    //     if ($filter['calc'] === true)
    //         $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['photos'].'.* ';
    //     else
    //         $sql = 'SELECT '.$this->_tables['photos'].'.* ';

    //     if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
    //         $sql.= ', COUNT(*) as GroupingCount ';

    //     $sql.= ' FROM '.$this->_tables['photos'].' ';

    //     $where = array();


    //     if ( !empty($filter['flags']['NameStart']) )
    //         $where[] = ' '.$this->_tables['photos'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
    //     else if ( !empty($filter['flags']['NameContains']) )
    //         $where[] = ' '.$this->_tables['photos'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

    //     if ( $filter['flags']['IsVisible'] != -1 )
    //         $where[] = ' '.$this->_tables['photos'].'.IsVisible = '.$filter['flags']['IsVisible'];

    //     if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
    //         $like = array();
    //         foreach($filter['filter']['fields'] as $k => $v) {
    //             if (!isset($filter['filter']['values'][$k]))
    //                 $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
    //             else
    //                 $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
    //         }

    //         if ($filter['filter']['cond'])
    //             $where[] = implode(' AND ', $like);
    //         else
    //             $where[] = '('.implode(' OR ', $like).')';
    //     }

    //     if ( sizeof($where) )
    //         $sql .= ' WHERE '.implode(' AND ', $where);

    //     if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
    //         $group = array();
    //         foreach($filter['group']['fields'] as $v) {
    //             $group[] = ' '.$this->_tables['groups'].'.`'.$v.'`';
    //         }

    //         $sql .= ' GROUP by '.implode(', ', $group);
    //     }

    //     if (isset($filter['having']) && $filter['having'])
    //         $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

    //     $sql.= ' ORDER by ';

    //         $sqlo = array();
    //         foreach( $filter['field'] as $k => $v )
    //             $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

    //         $sql .= implode(', ', $sqlo);

    //     if ( $filter['limit'] ) {
    //         $sql .= ' LIMIT ';
    //         if ( $filter['offset'] )
    //             $sql .= $filter['offset'].', ';

    //         $sql .= $filter['limit'];
    //     }

    //     if($filter['dbg'] == 1)
    //     {
    //         echo $sql;
    //     }

    //     $res = $this->_db->query($sql);
    //     if ( !$res || !$res->num_rows )
    //         return false;

    //     if ( $filter['calc'] === true )
    //     {
    //         $sql = "SELECT FOUND_ROWS()";
    //         list($count) = $this->_db->query($sql)->fetch_row();
    //     }

    //     $result = array();
    //     while ($row = $res->fetch_assoc())
    //     {
    //         if ($filter['flags']['objects'] === true)
    //         {
    //             $id = $row['PhotoID'];
    //             if ( isset($this->_photos[$id]) )
    //                 $row = $this->_photos[$id];
    //             else
    //                 $row = $this->_photoObject($row);
    //         }
    //         $result[] = $row;
    //     }

    //     if ( $filter['calc'] === true )
    //         return array($result, $count);

    //     return $result;
    // }

    public function AddFilterParam($FilterID, $ParamID)
    {
        $ParamID = intval($ParamID);
        if($ParamID <= 0 )
            return false;

        $FilterID = intval($FilterID);
        if($FilterID <= 0 )
            return false;

        $sql  = "INSERT IGNORE INTO ".ServiceMgr::getInstance()->_tables['group_filters'] ." SET ";
        $sql .= " GroupID=".$this->_values['groupid'];
        $sql .= ", ParamID=".$ParamID;
        $sql .= ", FilterID=".$FilterID;

        ServiceMgr::getInstance()->_db->query($sql);
    }

    public function GetFilterParam()
    {
        $sql  = "SELECT GroupID, FilterID, ParamID FROM ".ServiceMgr::getInstance()->_tables['group_filters'];
        $sql .= " WHERE GroupID=".$this->_values['groupid'];
        $res = ServiceMgr::getInstance()->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[$row["FilterID"]][$row["ParamID"]] = $row["ParamID"];
        }

        return $result;
    }

    public function GetFilterGroupParams($nameid)
    {
        $sql  = "SELECT ".ServiceMgr::getInstance()->_tables['filter_params'].".* FROM ".ServiceMgr::getInstance()->_tables['filter_params'];
        $sql .= " INNER JOIN ".ServiceMgr::getInstance()->_tables['filters']." ON ".ServiceMgr::getInstance()->_tables['filter_params'].".FilterID = ".ServiceMgr::getInstance()->_tables['filter_params'].".FilterID AND ".ServiceMgr::getInstance()->_tables['filters'].".NameID = '".addslashes($nameid)."'";
        $sql .= " INNER JOIN ".ServiceMgr::getInstance()->_tables['group_filters']." ON ".ServiceMgr::getInstance()->_tables['group_filters'].".ParamID = ".ServiceMgr::getInstance()->_tables['filter_params'].".ParamID AND ".ServiceMgr::getInstance()->_tables['group_filters'].".GroupID = ".$this->_values['groupid'];

        $res = ServiceMgr::getInstance()->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row;
        }

        return $result;
    }

    public function RemoveFilterParam()
    {
        $sql = "DELETE FROM ".ServiceMgr::getInstance()->_tables['group_filters']." WHERE GroupID=".$this->_values['groupid'];
        ServiceMgr::getInstance()->_db->query($sql);
    }

}