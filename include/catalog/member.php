<?
/*
    Ýëåìåíò èç ñîñòàâà
*/
class Member
{
    private $_fields = array(
        'memberid'          => 'int',
        'article'           => 'string',
        'name'              => 'string',
        'price'             => 'float',
        // 'isvisible'          => 'bool',
        'catalogid'         => 'int',
    );

    private $_values = array();

    private $params;
    private $cache;

    protected $_cacheAreaRefs = null;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['memberid']) && Data::Is_Number($info['memberid']) )
            $this->_values["memberid"] = $info['memberid'];
        else
            $this->_values["memberid"] = 0;

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
        if ($this->_values['memberid'] === 0)
        {
            return $this->_values['memberid'] = CatalogMgr::getInstance()->AddMember($this->_values);
        }
        else
        {
            return  CatalogMgr::getInstance()->UpdateMember($this->_values);
        }
    }

    /**
    * @return bool
    */
    public function UpdateAreaRef(array $info)
    {
        $info['MemberID'] = $this->_values['memberid'];
        return CatalogMgr::getInstance()->UpdateMemberAreaRef($info);
    }

    public function GetAreaRefs($sectionid)
    {
        // if ($this->_cacheAreaRefs !== null)
        //     return $this->_cacheAreaRefs;

        $filter = array(
            'ids' => array($this->_values['memberid']),
            'CatalogID' => $sectionid,
        );

        // print_r($filter); exit;

        $AreaRefs = CatalogMgr::getInstance()->GetMemberAreaRefsByIds($filter);


        $this->_cacheAreaRefs = $AreaRefs[$this->_values['memberid']];
        return $this->_cacheAreaRefs;
    }


    public function isVisibleElement($SectionID = -1) {
        return CatalogMgr::getInstance()->isVisibleElement($this->_values['memberid'], $SectionID);
    }

    public function loadAreaRefs($data)
    {
        $this->_cacheAreaRefs = $data;
    }

    public function Remove()
    {
        if ($this->_values['memberid'] === 0)
            return false;

        return CatalogMgr::getInstance()->RemoveMember($this->_values['memberid']);
    }

    public function GetPrice($catalogid)
    {
        $catalogid = intval(App::$City->CatalogId) > 0 ? App::$City->CatalogId : $catalogid;
        $areaRefs = $this->GetAreaRefs($catalogid);

        return $areaRefs['Price'];
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['memberid'];

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

    public function GetProducts()
    {
        $sql  = "SELECT * FROM ".CatalogMgr::getInstance()->_tables['elements'];
        $sql .= " WHERE ElementID = ". $this->ID;

        $res = CatalogMgr::getInstance()->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        $ids = [];
        while ($row = $res->fetch_assoc()) {
            $ids[] = $row['ProductID'];
        }

        $filter = [
            'flags' => [
                'objects' => true,
                // 'IsVisible' => 1,
                'filtered' => $ids,
            ],
            'dbg' => 0,
        ];

        $products = CatalogMgr::GetInstance()->GetProducts($filter);

        return $products;

    }

    function __destruct()
    {

    }
}