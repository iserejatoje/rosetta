<?

class EFilter
{

    private $_fields = array(
        'filterid'          => 'int',
        'name'              => 'string',
        'nameid'            => 'string',
        'weight'            => 'int',
    );

    private $_values = array();

    private $params;
    private $cache;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['filterid']) && Data::Is_Number($info['filterid']) )
            $this->_values["filterid"] = $info['filterid'];
        else
            $this->_values["filterid"] = 0;

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

        $this->cache = CatalogMgr::getInstance()->GetCache();
    }

    public function Update()
    {
        if ($this->_values['filterid'] === 0)
        {
            return $this->_values['filterid'] = CatalogMgr::getInstance()->AddFilter($this->_values);
        }
        else
        {
            return  CatalogMgr::getInstance()->UpdateFilter($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['filterid'] === 0)
            return false;

        foreach ($this->_fields as $name => $type)
        {
            if ($type == 'photo')
            {
                $this->__set($name, null);
            }
        }

        return CatalogMgr::getInstance()->RemoveFilter($this->_values['filterid']);
    }

    public function GetParams($filter)
    {
        // if (is_array($this->params))
        //  return $this->params;

        // $cacheid = 'ctl_filter_params_'.$this->_values['filterid'];

        // if ($this->cache !== null)
        //  $this->params = $this->cache->get($cacheid);

        $this->params = false;

        if ($this->params === false)
        {
            $this->params = array();
            $sql = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['filter_params']." WHERE";
            $sql .= " FilterID = ".$this->_values['filterid'];

            // ============================
            if(is_array($filter) && count($filter) > 0)
            {
                if(isset($filter['flags']['isavailable']) && $filter['flags']['isavailable'] != -1)
                    $sql .= " AND IsAvailable = ".$filter['flags']['isavailable'];


                if(isset($filter['field']) && $filter['dir'] && count($filter['field']) == count($filter['dir']))
                {
                    $sql .= " ORDER BY";
                    $sqlo = array();
                    foreach( $filter['field'] as $k => $v )
                    {
                        $sqlo[] = ' '.CatalogMgr::getInstance()->_tables['filter_params'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
                    }

                    $sql .= implode(', ', $sqlo);
                }
            }
            // ============================

            if($filter['dbg'] == 1)
                echo ":".$sql;

            $res = CatalogMgr::getInstance()->_db->query($sql);
            while($row = $res->fetch_assoc())
            {
                $this->params[$row['ParamID']] = $row;
            }

            $this->cache->set($cacheid, $this->params, 3600);
        }

        return $this->params;
    }

    // public function AddParam($name, $value, $isavailable = 1)
    public function AddParam($name, $options)
    {
        if ($name == "")
            return false;

        $sql = "INSERT INTO ".CatalogMgr::getInstance()->_tables['filter_params']." SET";
        $sql .= " FilterID=".$this->_values['filterid'];
        $sql .= ", Name='".addslashes($name)."'";
        $sql .= ", IsAvailable='".intval($options['isavailable'])."'";
        $sql .= ", Value='".addslashes($options['value'])."'";
        $sql .= ", Ord='".addslashes($options['ord'])."'";

        CatalogMgr::getInstance()->_db->query($sql);

        $id = CatalogMgr::getInstance()->_db->insert_id;

        $this->params[$id] = array(
            'Name' => $name,
            'Value' => $value,
        );

        $this->cache->Remove('ctl_filter_params_'.$this->_values['filterid']);

        return $id;
    }

    // public function UpdateParam($id, $name, $value, $isavailable = 1)
    public function UpdateParam($id, $name, $options)
    {
        if ($name == "" || !Data::Is_Number($id))
            return false;

        $sql = "UPDATE ".CatalogMgr::getInstance()->_tables['filter_params']." SET";
        $sql .= " Name='".addslashes($name)."'";
        $sql .= ", Value='".addslashes($options['value'])."'";
        $sql .= ", IsAvailable='".intval($options['isavailable'])."'";
        $sql .= ", Ord='".intval($options['ord'])."'";
        $sql .= " WHERE ParamID=".$id;

        CatalogMgr::getInstance()->_db->query($sql);

        $this->cache->Remove('ctl_filter_params_'.$this->_values['filterid']);

        $this->params[$id] = array(
            'Name' => $name,
            'Value' => $value,
        );

        $this->cache->Remove('ctl_filter_params_'.$this->_values['filterid']);

        return true;
    }

    public function RemoveParam($id)
    {
        if (!Data::Is_Number($id))
            return false;

        $sql = "DELETE FROM ".CatalogMgr::getInstance()->_tables['filter_params'];
        $sql .= " WHERE ParamID=".$id;

        CatalogMgr::getInstance()->_db->query($sql);

        unset($this->params[$id]);
        $this->cache->Remove('ctl_filter_params_'.$this->_values['filterid']);

        return true;
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['filterid'];

        if ($name == 'params')
        {
            return $this->GetParams(1);
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

    function __destruct()
    {

    }
}