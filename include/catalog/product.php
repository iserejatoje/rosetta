<?php

LibFactory::GetStatic('arrays');

class Product
{
    protected $_fields = array(
        'productid'       => 'int',
        'typeid'          => 'int',
        'article'         => 'string',
        'name'            => 'string',
        'ord'             => 'int',
        'isadditional'    => 'bool',
        'decortype'       => 'int',
        'shortdesc'       => 'string',
        'text'            => 'string',
        'compositiontext' => 'string',
        'theme'           => 'int',
        'price'           => 'float',

        'length'          => 'int',
        'count'           => 'int',

        'seotitle'        => 'string',
        'seodescription'  => 'string',
        'seokeywords'     => 'string',

        'photosmall'      => 'photo',
        'photocart'       => 'photo',
        'photocartsmall'  => 'photo',
        'photoadd'        => 'photo',
        'photoslider'     => 'photo',
        'parentid' => 'int',
    );

    protected $_values = array();

    protected $_cacheAreaRefs = null;
    protected $_cachePhotos = null;
    protected $_cacheCollection = null;
    protected $_cachePrice = null;
    protected $_cacheLens = null;

    protected $resize_params = array(
        'photosmall' => null,
        'photocart' => null,
        'photocartsmall' => null,
        'photoslider' => null,

        'photoadd' => array(
            'resize' => array(
                'tr' => 3,
                'w'  => 142,
                'h'  => 122
            ),
        ),
    );

    protected $_images_dir = '/common_fs/i/common_products/';
    protected $_images_url = '/resources/fs/i/common_products/';

    protected $file_size = 2097152; //2M


    function __construct(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

        if ( isset($info['productid']) && Data::Is_Number($info['productid']) )
            $this->_values["productid"] = $info['productid'];
        else
            $this->_values["productid"] = 0;

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

    public function GetDefaultType($catalogid)
    {
        $default_type = null;

        $catalogid = App::$City->CatalogId > 0 ? App::$City->CatalogId : $catalogid;

        $types = $this->GetTypes($catalogid);

        foreach($types as $type) {
            $refs = $type->GetTypeAreaRefs($catalogid);

            if($refs['IsDefault'] == 1)
            {
                $default_type = $type;
                break;
            }
        }

        if($default_type === null) {
            $default_type = $types[0];
        }

        return $default_type;
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['productid'];

        if ($name == 'price')
        {
            return $this->GetPrice();
        }

        if ($name == 'photos')
        {
            return $this->GetPhotos();
        }

        if($name == 'default_type') {
            $default_type = null;
            $types = $this->types;

            foreach($types as $type) {
                $refs = $type->GetTypeAreaRefs(App::$City->CatalogId);

                if($refs['IsDefault'] == 1)
                {
                    $default_type = $type;
                    break;
                }
            }

            if($default_type === null) {
                $default_type = $types[0];
            }

            return $default_type;
        }

        if($name == 'category')
        {
            return CatalogMgr::GetInstance()->GetCategory($this->TypeID);
        }

        // if ($name == 'elements')
        // {
        //  return $this->GetElements();
        // }

        if ($name == 'types')
        {
            return $this->GetTypes();
        }

        if ($name == 'compositions')
        {
            return $this->GetElements();
        }

        if ($name == 'arearefs')
        {
            return $this->GetAreaRefs();
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
            $inputName, $this->_images_dir, rand(1000, 9999).$this->_values['productid'].'_'.mb_strtolower($name),
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
        if ($this->_values['productid'] === 0)
        {
            return  $this->_values["productid"] = CatalogMgr::getInstance()->AddProduct($this->_values);
        }
        else
        {
            $this->_cacheAreaRefs = null;
            $this->_cacheTypes = null;
            $this->_cachePhotos = null;
            return CatalogMgr::getInstance()->UpdateProduct($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['productid'] === 0)
            return false;

        //remove refs
        CatalogMgr::getInstance()->RemoveProductRefs($this->_values['productid']);
        $this->_cacheAreaRefs = null;
        $this->_cacheTypes = null;
        $this->_cachePhotos = null;
        $this->_cacheLens = null;

        //remove gallery
        $filter = array(
            'flags' => array(
                'ProductID' => $this->_values['productid'],
                'IsVisible' => -1,
                'objects' => true,
            ),
        );

        $photos = CatalogMgr::getInstance()->GetProductPhotos($filter);
        foreach ($photos as $photo) {
            $photo->Remove();
        }

        //remove photos
        foreach ($this->_fields as $name => $type)
        {
            if ($type == 'photo')
            {
                $this->__set($name, null);
            }
        }

        return CatalogMgr::getInstance()->RemoveProduct($this->_values['productid']);
    }

    /**
    * @return bool
    */
    public function UpdateAreaRef(array $info)
    {
        $info['ProductID'] = $this->_values['productid'];
        return CatalogMgr::getInstance()->UpdateAreaRef($info);
    }

    public function GetAreaRefs($sectionid)
    {
        if ($this->_cacheAreaRefs !== null)
            return $this->_cacheAreaRefs;

        $filter = array(
            'ids' => array($this->_values['productid']),
            'CatalogID' => $sectionid,
        );

        $AreaRefs = CatalogMgr::getInstance()->GetAreaRefsByIds($filter);
        $this->_cacheAreaRefs = $AreaRefs[$this->_values['productid']];
        return $this->_cacheAreaRefs;
    }

    public function loadAreaRefs($data)
    {
        $this->_cacheAreaRefs = $data;
    }

    public function loadProductPhotos($data)
    {
        $this->_cachePhotos = $data;
    }

    // public function loadElements($data)
    // {
    //  $this->_cacheElements = $data;
    // }

    public function loadTypes($data)
    {
        $this->_cacheTypes = $data;
    }

    public function AddFilterParam($FilterID, $ParamID)
    {
        $ParamID = intval($ParamID);
        if($ParamID <= 0 )
            return false;

        $FilterID = intval($FilterID);
        if($FilterID <= 0 )
            return false;

        $sql = "INSERT IGNORE INTO ".CatalogMgr::getInstance()->_tables['product_filters'] ." SET ProductID=".$this->_values['productid'];
        $sql .= ", ParamID=".$ParamID. ", FilterID=".$FilterID;
        CatalogMgr::getInstance()->_db->query($sql);
    }

    public function GetFilterParam()
    {
        $sql = "SELECT ProductID, FilterID, ParamID FROM ".CatalogMgr::getInstance()->_tables['product_filters']. " WHERE ProductID=".$this->_values['productid'];
        $res = CatalogMgr::getInstance()->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[$row["FilterID"]][$row["ParamID"]] = $row["ParamID"];
        }

        return $result;
    }

    public function GetFilterProductParams($nameid)
    {
        $sql  = "SELECT ".CatalogMgr::getInstance()->_tables['filter_params'].".* FROM ".CatalogMgr::getInstance()->_tables['filter_params'];
        $sql .= " INNER JOIN ".CatalogMgr::getInstance()->_tables['filters']." ON ".CatalogMgr::getInstance()->_tables['filter_params'].".FilterID = ".CatalogMgr::getInstance()->_tables['filter_params'].".FilterID AND ".CatalogMgr::getInstance()->_tables['filters'].".NameID = '".addslashes($nameid)."'";
        $sql .= " INNER JOIN ".CatalogMgr::getInstance()->_tables['product_filters']." ON ".CatalogMgr::getInstance()->_tables['product_filters'].".ParamID = ".CatalogMgr::getInstance()->_tables['filter_params'].".ParamID AND ".CatalogMgr::getInstance()->_tables['product_filters'].".ProductID = ".$this->_values['productid'];

        $res = CatalogMgr::getInstance()->_db->query($sql);
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
        $sql = "DELETE FROM ".CatalogMgr::getInstance()->_tables['product_filters']." WHERE ProductID=".$this->_values['productid'];
        CatalogMgr::getInstance()->_db->query($sql);
    }

    public function GetPhotos()
    {
        if ($this->_cachePhotos !== null)
            return $this->_cachePhotos;

        $filter = array(
            'ids' => array($this->_values['productid']),
        );

        $result = CatalogMgr::getInstance()->GetProductPhotosByIds($filter);
        $this->_cachePhotos = $result[$this->_values['productid']];
        return $this->_cachePhotos;
    }

    // public function GetTypes($CatalogID = 0)
    // {
    //     if ($this->_cacheTypes !== null)
    //         return $this->_cacheTypes;

    //     // if ($CatalogID == 0)
    //     //  return null;

    //     $filter = array(
    //         'CatalogID' => $CatalogID,
    //         'ids' => array($this->_values['productid']),
    //     );

    //     $result = CatalogMgr::getInstance()->GetTypesByIds($filter);

    //     $this->_cacheTypes = $result[$this->_values['productid']];
    //     return $this->_cacheTypes;
    // }

    public function GetTypes($CatalogID = 0, $IsVisible = true)
    {
        // if ($this->_cacheTypes !== null)
        //     return $this->_cacheTypes;

        $filter = array(
            'CatalogID' => $CatalogID,
            'ids' => array($this->ID),
        );

        $result = CatalogMgr::getInstance()->GetTypesByIds($filter, $IsVisible);

        $this->_cacheTypes = $result[$this->id];

        // return $this->_cacheTypes;
        return $result[$this->id];
    }

    public function DropDefaultType($sectionid) {

        $sectionid = intval($sectionid);

        if ($sectionid <= 0)
            return false;

        $allTypes = true;
        $types = $this->GetTypes();

        $ids = array();
        foreach($types as $type) {
            $ids[] = $type->ID;
        }

        $sql = "UPDATE ".CatalogMgr::getInstance()->_tables['typeRefs'];
        $sql .= " SET IsDefault=0";
        $sql .= " WHERE TypeID IN (".implode(",", $ids).")";
        $sql .= " AND SectionID=".$sectionid;

        return CatalogMgr::getInstance()->_db->query($sql);
    }

    public function GetElements()
    {
        if ($this->_cacheElements !== null)
            return $this->_cacheElements;

        $filter = array(
            'ids' => array($this->_values['productid']),
        );
        $result = CatalogMgr::getInstance()->GetElementsByIds($filter);

        $this->_cacheElements = $result[$this->_values['productid']];
        return $this->_cacheElements;
    }

    public function GetElementByID($ElementID)
    {
        $ElementID = intval($ElementID);
        if($ElementID <= 0 )
            return false;

        $sql  = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['elements']." as e ";
        $sql .= "INNER JOIN ".CatalogMgr::getInstance()->_tables['compositions'] ." as c";
        $sql .= " ON e.ElementID = c.MemberID";
        $sql .= " WHERE ProductID=".$this->_values['productid'];
        $sql .= " AND c.MemberID=".$ElementID;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        $result = array();
        if ( !$res || !$res->num_rows )
            return false;

        $data = $res->fetch_assoc();

        return $data;
    }

    public function RemoveElements()
    {
        $sql = "DELETE FROM ".CatalogMgr::getInstance()->_tables['elements']." WHERE ProductID=".$this->_values['productid'];
        CatalogMgr::getInstance()->_db->query($sql);
    }

    public function AddElement($ElementID, $Count, $Visible=1)
    {
        $ElementID = intval($ElementID);
        if($ElementID <= 0)
            return false;

        $Count = intval($Count);
        if($Count < 0 )
            $Count = 0;

        $sql  = "INSERT INTO ".CatalogMgr::getInstance()->_tables['elements'];
        $sql .= " SET ProductID=".$this->_values['productid'];
        $sql .= ", ElementID=".$ElementID;
        $sql .= ", Count=".$Count;
        $sql .= ", IsVisible=".$Visible;

        CatalogMgr::getInstance()->_db->query($sql);
    }

    // private function _in_cart()
    // {
    //     $sql = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['cart'];
    //     $sql .= " WHERE ProductID = ".$this->_values['productid'];
    //     $sql .= " AND CartCode = '" .CatalogMgr::getInstance()->CartCode."'";
    //     $sql .= " AND CatalogID = " .App::$City->CatalogId;

    //     $res = CatalogMgr::getInstance()->_db->query($sql);
    //     if (!$res || !$res->num_rows)
    //         return false;

    //     return true;
    // }

    private function _in_cart($typeid)
    {
        $typeid = intval($typeid);
        if($typeid <= 0)
            return false;

        $sql = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['cart'];
        $sql .= " WHERE ProductID = ".$this->_values['productid'];
        $sql .= " AND CartCode = '" .CatalogMgr::getInstance()->CartCode."'";
        $sql .= " AND CatalogID = " .App::$City->CatalogId;
        $sql .= " AND TypeID = " .$typeid;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        if (!$res || !$res->num_rows)
            return false;

        return true;
    }

    public function AddToCart(array $options)
    {
        $count     = intval($options['count']);
        $typeid    = intval($options['typeid']);
        $kind      = intval($options['kind']);
        $decor     = intval($options['decor']);

        $count = $count > 0 ? $count : 1;

        if(count($options['additions']) > 0)
            $additions = serialize($options['additions']);
        else
            $additions = '';

        if(count($options['params']) > 0)
            $params = serialize($options['params']);
        else
            $params = '';

        $catalogid = App::$City->CatalogId;

        $currenttime = time();
        $key = base64_encode($this->id."_".$typeid."_".$currenttime);

        $sql  = "INSERT INTO ".CatalogMgr::GetInstance()->_tables['cart']." SET";
        $sql .= " CartCode = '".CatalogMgr::getInstance()->CartCode."'";
        $sql .= ", CatalogID = ". $catalogid;
        $sql .= ", ProductID = ". $this->ID;
        $sql .= ", Count = ".$count;
        $sql .= ", Updated = NOW()";
        $sql .= ", Created = NOW()";
        $sql .= ", TypeID = ".$typeid;
        $sql .= ", Kind =".$kind;
        $sql .= ", Additions='".addslashes($additions)."'";
        $sql .= ", Params='".addslashes($params)."'";
        $sql .= ", CurrentTime='".$currenttime."'";

        CatalogMgr::GetInstance()->_db->query($sql);

        return $key;
    }


    // public function AddToCart($count)
    // {
    //     $count = intval($count);
    //     if ($count <= 0)
    //         return false;

    //     CatalogMgr::getInstance()->GenerateCart();
    //     if($this->_in_cart())
    //     {
    //         $sql  = "UPDATE ".CatalogMgr::getInstance()->_tables['cart'];
    //         $sql .= " SET Count = Count + " .$count;
    //         $sql .= ", Updated = NOW()";
    //         $sql .= " WHERE ProductID = ".$this->_values['productid'];
    //         $sql .= " AND CatalogID = " .App::$City->CatalogId;
    //         $sql .= " AND CartCode = '".CatalogMgr::getInstance()->CartCode."'";
    //     }
    //     else
    //     {
    //         $sql = "INSERT IGNORE INTO ".CatalogMgr::getInstance()->_tables['cart']." SET";
    //         $sql.= " CartCode = '".CatalogMgr::getInstance()->CartCode."'";
    //         $sql.= ", ProductID = ".$this->_values['productid'];
    //         $sql.= ", CatalogID = ".App::$City->CatalogId;
    //         $sql.= ", Count = ".$count;
    //         $sql.= ", Created = NOW()";
    //         $sql.= ", Updated = NOW()";
    //     }

    //     CatalogMgr::getInstance()->_db->query($sql);
    //     return true;
    // }

    public function GetPrice()
    {
        if ($this->_cachePrice !== null)
            return $this->_cachePrice;

        $composition = $this->GetElements();

        $price = 0;
        foreach ($composition as $item) {
            $price += $item['Count'] * $item['Price'];
        }

        $this->_cachePrice = $price;
        return $this->_cachePrice;
    }

    public function getDiscountPercent($catalogId)
    {
        $refs = $this->GetAreaRefs($catalogId);
        if(!$refs['ExcludeDiscount']) {
            return 0;
        }

        if($refs['Discount']) {
            return $refs['Discount'];
        }

        return 0;
        // $bl = BLFactory::GetInstance('system/config');
        // $config = $bl->LoadConfig('module_engine', 'catalog');

        // return (int) $config['discount_value'];
    }

    public function getDiscountValue($catalogId)
    {
        $duscountValue = $this->getDiscountPercent($catalogId);

        return 1 - $duscountValue / 100;
    }

    // public function getDiscountPrice($catalogId)
    // {
    //     $discount = $this->getDiscount($catalogId);
    //     $refs = $this->GetAreaRefs($catalogId);
    //     print_r($this->getPrice()); exit;
    // }

     public function IsPriceCached($catalogid, $typeid)
    {
        $sql  = "SELECT * FROM ".CatalogMgr::GetInstance()->_tables['cache_prices'];
        $sql .= " WHERE TypeID = ".$typeid;
        $sql .= " AND CatalogID = ".$catalogid;
        $sql .= " AND ProductID = ".$this->id;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        if (!$res || !$res->num_rows)
            return false;

        return true;
    }

    public function CachePrice($catalogid = 0)
    {
        $category = $this->category;

        // если папка - не нужно трогать цены
        if($category->Kind == CatalogMgr::CK_FOLDER) {
            return true;
        }

        if($category->Kind == CatalogMgr::CK_ROSE)
        {
            LibFactory::GetStatic('bl');
            $bl = BLFactory::GetInstance('system/config');
            $config = $bl->LoadConfig('module_engine', 'catalog');

            $lengths = $this->GetLens();
            if(!$lengths) {
                return true;
            }

            $min = $max = [];
            foreach($lengths as $length) {
                $min[] = $this->GetPrice($length->len, $config['rose_params']['min'], $catalogid);
                $max[] = $this->GetPrice($length->len, CatalogMgr::ROSE_MAX, $catalogid);
            }

            $price_min = min($min);
            $price_max = max($max);
        }
        elseif($category->Kind == CatalogMgr::CK_BOUQUET || $category->Kind == CatalogMgr::CK_FIXED)
        {
            $types = $this->GetTypes($catalogid, $onlyVisible = true);


            $arrPrices = [];
            foreach($types as $type) {
                $arrPrices[] = $type->GetPrice($catalogid);
            }

            $price_max = max($arrPrices);
            $price_min = min($arrPrices);
        } elseif($category->kind == CatalogMgr::CK_MONO) {
            $types = $this->GetTypes($catalogid, $onlyVisible = true);
            if(!isset($types[0])) {
                return true;
            }

            LibFactory::GetStatic('bl');
            $bl = BLFactory::GetInstance('system/config');
            $config = $bl->LoadConfig('module_engine', 'catalog');
            $type = $types[0];
            $price_min = $type->GetPrice($catalogid, $config['mono_params']['min'] ?: 1);
            $price_max = $type->GetPrice($catalogid, CatalogMgr::MONO_MAX);
        } else {
            $price_max = $price_min = $this->GetPrice();
        }

        if(!$price_min) $price_min = 0;
        if(!$price_max) $price_max = 0;

        $catalogMgr = CatalogMgr::getInstance();

        // проверка, установлена ли скидка на товар.
        $areaRefs = $this->GetAreaRefs($catalogid);
        if($catalogMgr->hasDiscount($areaRefs)) {
            $discount = $catalogMgr->getDiscount();
            $price_min *= $discount;
            $price_max *= $discount;
        }

        $category = $this->category;

        if($this->IsPriceCached($catalogid, $category->id)) {
            $sql  = "UPDATE ".CatalogMgr::GetInstance()->_tables['cache_prices']. " SET ";
            $sql .= " MinPrice = ".$price_min;
            $sql .= ", MaxPrice = ".$price_max;
            $sql .= " WHERE CatalogID = ".$catalogid;
            $sql .= " AND TypeID = ".$category->id;
            $sql .= " AND ProductID = ".$this->id;
        } else {
            $sql  = "INSERT INTO ".CatalogMgr::GetInstance()->_tables['cache_prices']." SET ";
            $sql .= " ProductID = ". $this->id;
            $sql .= ", TypeID = ".$category->id;
            $sql .= ", CatalogID = ".$catalogid;
            $sql .= ", MinPrice = ".$price_min;
            $sql .= ", MaxPrice = ".$price_max;
        }

        $catalogMgr->_db->query($sql);

        // если товар из папки, обновить диапазон цен папки
        if($this->ParentId) {
            $catalogMgr->updateParentCachePrice($this->ParentId, $catalogid);
        }

        return true;
    }

    public function getPriceRange($catalogId = 0)
    {
        $catalogMgr = CatalogMgr::getInstance();
        return $catalogMgr->getPriceRange($this->id, $catalogId);
    }

    public function GetVisibility($catalogid)
    {
        $category = $this->category;
        $area_refs = $this->GetAreaRefs($catalogid);

        if($area_refs['IsVisible'] == 0)
            return false;

        if($area_refs['IsAvailable'] == 0)
            return false;

        if($category->Kind == CatalogMgr::CK_BOUQUET || $category->Kind == CatalogMgr::CK_MONO || $category->Kind == CatalogMgr::CK_FIXED || $category->Kind == CatalogMgr::CK_WEDDING) {
            $only_visible = true;
            $types = $this->GetTypes($catalogid, $only_visible);
            if(is_null($types))
                return false;

            $price = $this->default_type->GetPrice($catalogid);
        } elseif($category->Kind == CatalogMgr::CK_ROSE) {
            $lens = $this->GetLens();
            if($lens == false)
                return false;

            $price = $this->GetPrice($this->length, $this->count, $catalogid);
        } elseif($category->Kind == CatalogMgr::CK_FOLDER) {
            $price = $this->getPriceRange($catalogid)['MinPrice'];
        } elseif($category->Kind == CatalogMgr::CK_ARTIFICIAL) {
            $price = $this->GetPrice($catalogId);
            if($price > 0) {
                return true;
            }
        }

        if($price < 500)
            return false;

        return true;
    }
}