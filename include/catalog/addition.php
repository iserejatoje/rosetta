<?php
/*
    Ýëåìåíò èç ñîñòàâà
*/
class Addition
{
    private $_fields = array(
        'additionid'  => 'int',
        'article'     => 'string',
        'name'        => 'string',
        'description' => 'string',
        'isvisible'   => 'bool',
        'incard'      => 'bool',
        'ord'         => 'int',
        'type'        => 'int',
        'price'       => 'int',
        'photobig'    => 'photo',
        'photosmall'  => 'photo',
        'photocart'   => 'photo',
        'photocartsmall'  => 'photo',
        'theme'       => 'int',
    );

    private $refprice;

    private $resize_params = array(
        'photosmall' => null,
        'photobig' => null,
        'photocartsmall' => null,
    );

    private $_images_dir = '/common_fs/i/common_additions/';
    private $_images_url = '/resources/fs/i/common_additions/';

    private $_values = array();

    private $params;
    private $cache;

    protected $_cacheAreaRefs = null;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if (isset($info['additionid']) && Data::Is_Number($info['additionid']) )
            $this->_values["additionid"] = $info['additionid'];
        else
            $this->_values["additionid"] = 0;

        foreach ($this->_fields as $key => $type) {
            switch ($type) {
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
            $inputName, $this->_images_dir, rand(1000, 9999).$this->_values['additionid'].'_'.mb_strtolower($name),
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
        if ($this->_values['additionid'] === 0) {
            return $this->_values['additionid'] = CatalogMgr::getInstance()->AddAddition($this->_values);
        } else {
            return  CatalogMgr::getInstance()->UpdateAddition($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['additionid'] === 0) {
            return false;
        }

        //remove photos
        foreach ($this->_fields as $name => $type) {
            if ($type == 'photo') {
                $this->__set($name, null);
            }
        }

        return CatalogMgr::getInstance()->RemoveAddition($this->_values['additionid']);
    }

    /**
    * @return bool
    */
    public function UpdateAreaRef(array $info)
    {
        $info['AdditionID'] = $this->_values['additionid'];
        return CatalogMgr::getInstance()->UpdateAdditionAreaRef($info);
    }

    public function GetAreaRefs($sectionid)
    {
        if ($this->_cacheAreaRefs !== null)
            return $this->_cacheAreaRefs;

        $filter = array(
            'ids' => array($this->_values['additionid']),
            'CatalogID' => $sectionid,
        );

        $AreaRefs = CatalogMgr::getInstance()->GetAdditionAreaRefsByIds($filter);
        $this->_cacheAreaRefs = $AreaRefs[$this->_values['additionid']];
        return $this->_cacheAreaRefs;
    }

    public function loadAreaRefs($data)
    {
        $this->_cacheAreaRefs = $data;
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

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['additionid'];

        if($name == 'refprice') {
            $ref = $this->GetAreaRefs(App::$City->CatalogId);

            return $ref['Price'];
        }

        if(isset($this->_values[$name])) {
            switch ($this->_fields[$name]) {
                case 'photo':
                    if (!$this->_values[$name])
                        return null;

                    try {
                        $img_obj = FileStore::ObjectFromString($this->_values[$name]);
                        $img_obj['file'] = FileStore::GetPath($img_obj['file']);
                        $preparedImage = Images::PrepareImageFromObject($img_obj,
                            $this->_images_dir, $this->_images_url);
                        unset($img_obj);
                        if (empty($preparedImage))
                            return null;
                    } catch ( MyException $e ) {
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

        if (isset($this->_fields[$name])) {
            switch ($this->_fields[$name]) {
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
                    if ($value === null) {
                        if (!empty($this->_values[$name]))
                            $this->_deletePhoto($name);

                        $this->_values[$name] = '';
                        return $value;
                    } try {
                        if( ($img_obj = FileStore::ObjectFromString($value)) !== false ) {
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