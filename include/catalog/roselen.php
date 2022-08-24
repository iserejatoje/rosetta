<?
/*
    Ýëåìåíò èç ñîñòàâà
*/
class RoseLen
{
    private $_fields = array(
        'lenid'      => 'int',
        'productid'  => 'int',
        'memberid'   => 'int',
        'len'        => 'int',
        'cost'       => 'int',
        'ord'        => 'int',
        'isvisible'  => 'bool',
        'isdefault'  => 'bool',
    );

    private $cache;
    private $_values = array();

    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['lenid']) && Data::Is_Number($info['lenid']) )
            $this->_values["lenid"] = $info['lenid'];
        else
            $this->_values["lenid"] = 0;

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

        if ($this->_values['lenid'] === 0)
        {
            return $this->_values['lenid'] = CatalogMgr::getInstance()->AddLen($this->_values);
        }
        else
        {
            return  CatalogMgr::getInstance()->UpdateLen($this->_values);
        }
    }

    public function Remove()
    {
        if ($this->_values['lenid'] === 0)
            return false;

        return CatalogMgr::getInstance()->RemoveLen($this->_values['lenid']);
    }

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['lenid'];

        if($name == 'member') {
            $member = CatalogMgr::getInstance()->GetMember($this->_values['memberid']);
            return $member;
        }

        if(isset($this->_values[$name]))
        {
            switch ($this->_fields[$name])
            {

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