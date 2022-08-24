<?
/*
    Ýëåìåíò èç ñîñòàâà
*/
class Type
{
    private $_fields = array(
        'productid'         => 'int',
        'typeid'            => 'int',
        'ord'               => 'int',
        'name'              => 'string',
        'isvisible'         => 'bool',
        'isdefault'         => 'bool',
    );

    private $_values = array();

    private $_cacheTypeAreaRefs = null;
    private $_cacheElements = null;
    private $_cachePrice = null;

    private $params;
    private $cache;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['typeid']) && Data::Is_Number($info['typeid']) )
            $this->_values["typeid"] = $info['typeid'];
        else
            $this->_values["typeid"] = 0;

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
        if ($this->_values['typeid'] === 0) {
            return $this->_values['typeid'] = CatalogMgr::getInstance()->AddType($this->_values);
        } else {
            $this->_cacheTypeAreaRefs = null;
            $this->_cacheElements = null;
            $this->_cachePrice = null;
            return  CatalogMgr::getInstance()->UpdateType($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['typeid'] === 0)
            return false;

        //remove refs
        CatalogMgr::getInstance()->RemoveTypeRefs($this->_values['typeid']);
        CatalogMgr::getInstance()->RemoveTypeElementsRefs($this->_values['typeid']);
        $this->_cacheTypeAreaRefs = null;
        $this->_cacheElements = null;
        $this->_cachePrice = null;

        return CatalogMgr::getInstance()->RemoveType($this->_values['typeid']);
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['typeid'];

        if ($name == 'price')
        {
            return $this->GetPrice();
        }

        // if ($name == 'elements')
        // {
        //  return $this->GetElements();
        // }

        if($name == 'compositions') {
            return $this->GetElements(App::$City->CatalogId);
        }

        if($name == 'str_compositions') {
            $arr = [];
            $elements = $this->GetElements(App::$City->CatalogId);
            foreach($elements as $element) {
                $arr[] = strtolower($element['Name']);
            }
            return implode(", ", $arr);
        }

        if ($name == 'params')
        {
            return $this->GetParams();
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
    * @return bool
    */
    public function UpdateTypeAreaRef(array $info)
    {
        $info['TypeID'] = $this->_values['typeid'];
        return CatalogMgr::getInstance()->UpdateTypeAreaRef($info);
    }

    public function GetTypeAreaRefs($sectionid)
    {
        // if ($this->_cacheTypeAreaRefs !== null)
        //     return $this->_cacheTypeAreaRefs;

        $filter = array(
            'ids' => array($this->_values['typeid']),
            'CatalogID' => $sectionid,
        );

        $TypeAreaRefs = CatalogMgr::getInstance()->GetTypeAreaRefsByIds($filter);

        $this->_cacheTypeAreaRefs = $TypeAreaRefs[$this->_values['typeid']];
        return $this->_cacheTypeAreaRefs;
    }

    public function loadTypeAreaRefs($data)
    {
        $this->_cacheTypeAreaRefs = $data;
    }

    public function loadElements($data)
    {
        $this->_cacheElements = $data;
    }

    public function GetElements($sectionID, $only_visible = 1)
    {
        // if ($this->_cacheElements !== null)
        //     return $this->_cacheElements;

        $filter = array(
            'CatalogID' => $sectionID,
            'ids' => array($this->_values['typeid']),
            'IsVisible' => $only_visible,
        );

        $result = CatalogMgr::getInstance()->GetElementsByIds($filter);
        return $result[$this->_values['typeid']];

        $this->_cacheElements = $result[$this->_values['typeid']];
        return $this->_cacheElements;
    }

    /*public function GetElementByID($ElementID)
    {
        $ElementID = intval($ElementID);
        if($ElementID <= 0 )
            return false;

        $sql  = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['elements']." as e ";
        $sql .= "INNER JOIN ".CatalogMgr::getInstance()->_tables['compositions'] ." as c";
        $sql .= " ON e.ElementID = c.MemberID";
        $sql .= " WHERE TypeID=".$this->_values['typeid'];
        $sql .= " AND c.MemberID=".$ElementID;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        $result = array();
        if ( !$res || !$res->num_rows )
            return false;

        $data = $res->fetch_assoc();

        return $data;
    }*/

    public function RemoveElements($SectionID)
    {
        $SectionID = intval($SectionID);
        if ($SectionID <= 0)
            return false;

        $sql = "DELETE FROM ".CatalogMgr::getInstance()->_tables['elements']." WHERE TypeID=".$this->_values['typeid']." AND SectionID=".$SectionID;
        CatalogMgr::getInstance()->_db->query($sql);

        CatalogMgr::getInstance()->logElementsDeleting($sql);

    }







    public function AddElement($ElementID, $Count, $SectionID, $Editable=0, $Visible=1)
    {
        $ElementID = intval($ElementID);
        if($ElementID <= 0)
            return false;

        $SectionID = intval($SectionID);
        if($SectionID <= 0)
            return false;

        $Editable = intval($Editable);

        $Count = floatval($Count);
        if($Count < 0 )
            $Count = 0;

        $sql  = "INSERT INTO ".CatalogMgr::getInstance()->_tables['elements'];
        $sql .= " SET TypeID=".$this->_values['typeid'];
        $sql .= ", ProductID=".$this->_values['productid'];
        $sql .= ", ElementID=".$ElementID;
        $sql .= ", SectionID=".$SectionID;
        $sql .= ", Count='".$Count."'";
        $sql .= ", IsVisible=".$Visible;
        $sql .= ", IsEditable=".$Editable;


        CatalogMgr::getInstance()->_db->query($sql);
    }

    private function _in_cart()
    {
        $sql = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['cart'];
        $sql .= " WHERE TypeID = ".$this->_values['typeid'];
        $sql .= " AND CartCode = '" .CatalogMgr::getInstance()->CartCode."'";
        $sql .= " AND CatalogID = " .App::$City->CatalogId;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        if (!$res || !$res->num_rows)
            return false;

        return true;
    }

    public function AddToCart($count)
    {
        $count = intval($count);
        if ($count <= 0)
            return false;

        if($this->_in_cart())
        {
            $sql  = "UPDATE ".CatalogMgr::getInstance()->_tables['cart'];
            $sql .= " SET Count = Count + " .$count;
            $sql .= ", Updated = NOW()";
            $sql .= " WHERE TypeID = ".$this->_values['typeid'];
            $sql .= " AND CatalogID = " .App::$City->CatalogId;
            $sql .= " AND CartCode = '".CatalogMgr::getInstance()->CartCode."'";
        }
        else
        {
            $sql = "INSERT IGNORE INTO ".CatalogMgr::getInstance()->_tables['cart']." SET";
            $sql.= " CartCode = '".CatalogMgr::getInstance()->CartCode."'";
            $sql.= ", TypeID = ".$this->_values['typeid'];
            $sql.= ", CatalogID = ".App::$City->CatalogId;
            $sql.= ", ProductID = ".$this->_values['productid'];
            $sql.= ", Count = ".$count;
            $sql.= ", Created = NOW()";
            $sql.= ", Updated = NOW()";
        }

        CatalogMgr::getInstance()->_db->query($sql);
        return true;
    }

    public function GetPrice($catalogid = -1, $count = 0)
    {
        $catalogid = intval(App::$City->CatalogId) > 0 ? App::$City->CatalogId : $catalogid ;

        $composition = $this->GetElements($catalogid);
        $price = 0;
        foreach ($composition as $item) {
            $member = CatalogMgr::getInstance()->GetMember($item['ElementID']);
            $areaRefs = $member->GetAreaRefs($catalogid);

            if($item['IsEditable'] == 1) {
                $cnt = intval($count) > 0 ? $count : $item['Count'];
            } else {
                $cnt = $item['Count'];
            }

            $price += $cnt * $areaRefs['Price'];
        }

        return $price;
    }

    function __destruct()
    {

    }
}