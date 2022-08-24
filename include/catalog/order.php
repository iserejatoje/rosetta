<?

class Order
{
    private $_fields = array(
        'orderid'          => 'int',
        'userid'           => 'int',
        'catalogid'        => 'int',
        'storeid'          => 'int',
        'storeaddress'     => 'string',
        'deliveryaddress'  => 'string',
        'cartcode'         => 'string',
        'deliverytype'     => 'int',
        'deliverydate'     => 'int',
        'districtid'       => 'int',
        'deliverytime'     => 'string',
        'recipientname'    => 'string',
        'recipientphone'   => 'string',
        'customername'     => 'string',
        'customerphone'    => 'string',
        'customeremail'    => 'string',
        'paymenttype'      => 'int',
        'paymentacid'      => 'int',
        'paymentsystem'    => 'int',
        'cardid'           => 'int',
        'cardtext'         => 'string',
        'cardname'         => 'string',
        'cardprice'        => 'int',
        'totalprice'       => 'float',
        'comment'          => 'string',
        'status'           => 'int',
        'paymentstatus'    => 'int',
        'correctioncall'   => 'int',
        'notflowernotify'  => 'bool',
        // 'paymentdate'   => 'string',
        'created'          => 'int',
        'updated'          => 'int',
        'deliveryprice'    => 'int',
        'discountcard'     => 'string',
        'deliveryarea'     => 'string',
        'isarchive'        => 'bool',
        'wantdiscountcard' => 'bool',
        'sended'           => 'bool',
    );

    private $_values = array();
    private $_cacheRefs = null;

    private $params;
    private $cache;

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['orderid']) && Data::Is_Number($info['orderid']) )
            $this->_values["orderid"] = $info['orderid'];
        else
            $this->_values["orderid"] = 0;

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
                    $this->_values[$key] =  $info[$key] ? true : false;
                    // $this->_values[$key] = (bool) $info[$key];
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
        if ($this->_values['orderid'] === 0) {
            $this->_values['created'] = time();
            $this->_values['updated'] = time();
            // error_log('CREATE NEW ORDER');

            return $this->_values['orderid'] = CatalogMgr::getInstance()->AddOrder($this->_values);
        } else {
            $this->_values['updated'] = time();
            // error_log('UPDATE EXISTING ORDER ' . $this->_values['orderid']);
            return  CatalogMgr::getInstance()->UpdateOrder($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['orderid'] === 0)
            return false;

        return CatalogMgr::getInstance()->RemoveOrder($this->_values['orderid']);
    }

    public function addCustomRef($items)
    {
        return CatalogMgr::getInstance()->AddCustomOrderRefs($this->_values['orderid'], $items);
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id') {
            return $this->_values['orderid'];
        }

        if ($name == 'refs')
        {
            return $this->GetOrderRefs();
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

    public function loadOrderRefs($data)
    {
        $this->_cacheRefs = $data;
    }

    public function GetOrderRefs()
    {
        if ($this->_cacheRefs !== null)
            return $this->_cacheRefs;

        $filter = array(
            'ids' => array($this->_values['orderid']),
            'CatalogID' => $this->_values['catalogid'],
        );

        $result = CatalogMgr::getInstance()->GetOrderRefsByIds($filter);

        $this->_cacheRefs = $result[$this->_values['orderid']];
        return $this->_cacheRefs;
    }

    function __destruct()
    {

    }
}