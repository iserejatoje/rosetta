<?
/*
    Ýëåìåíò èç ñîñòàâà
*/
class Category
{
    private $_fields = array(
        'categoryid'     => 'int',
        'nameid'         => 'string',
        'title'          => 'string',
        'isvisible'      => 'bool',

        'kind'           => 'int',
        'ord'            => 'int',
        'icon'           => 'photo',
        'seotitle'       => 'string',
        'seokeywords'    => 'string',
        'seodescription' => 'string',
        'seotext'        => 'string',
    );

    private $resize_params = array(
        'icon' => null,
    );

    private $_images_dir = '/common_fs/i/common_products/';
    private $_images_url = '/resources/fs/i/common_products/';

    private $_values = array();

    private $params;
    private $cache;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['categoryid']) && Data::Is_Number($info['categoryid']) )
            $this->_values["categoryid"] = $info['categoryid'];
        else
            $this->_values["categoryid"] = 0;

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
            $inputName, $this->_images_dir, rand(1000, 9999).$this->_values['categoryid'].'_'.mb_strtolower($name),
            FileMagic::MT_WIMAGE, $this->file_size,
            $this->resize_params[$name]
        );

        $pname = FileStore::GetPath_NEW($pname);
        $photoNew = Images::PrepareImageToObject($pname, $this->_images_dir);
        $pname = FileStore::ObjectToString($photoNew);

        $this->__set($name , $pname);
        return true;
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

    public function Update()
    {
        if ($this->_values['categoryid'] === 0)
        {
            return $this->_values['categoryid'] = CatalogMgr::getInstance()->AddCategory($this->_values);
        }
        else
        {
            return  CatalogMgr::getInstance()->UpdateCategory($this->_values);
        }
    }

    public function GetRosePrices()
    {
        $cacheid = 'rose_len_'.$this->ID;
        $lens = $this->cache->get($cacheid);

        if($lens !== false && !is_null($lnes))
            return $lens;

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
                'CategoryID' => $this->ID,
                'CatalogID' => App::$City->CatalogId,
            ),
        );

        $lens = CatalogMgr::GetInstance()->GetLens($filter);
        if(count($lens) == 0 )
            return false;

        $list = array();
        foreach($lens as $item)
        {
            $list['wholesale'][$item->Len] = $item->Wholesale;
            $list['retail'][$item->Len] = $item->Retail;
        }


        $this->cache->set($cacheid, $list, 3600);

        return $list;
    }

    public function Remove()
    {
        if ($this->_values['categoryid'] === 0)
            return false;

        return CatalogMgr::getInstance()->RemoveCategory($this->_values['categoryid']);
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['categoryid'];

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