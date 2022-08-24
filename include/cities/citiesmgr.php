<?php
require_once (ENGINE_PATH.'include/cities/city.php');
require_once (ENGINE_PATH.'include/cities/deliverycity.php');
require_once (ENGINE_PATH.'include/cities/district.php');
require_once (ENGINE_PATH.'include/cities/store.php');
require_once (ENGINE_PATH.'include/cities/photo.php');

class CitiesMgr
{

    const CITY_COOKIE = 'city';

    private $cities = array();
    private $_Delivery = array();
    private $_District = array();
    private $_Store = array();
    private $_photos = array();

    public $_db         = null;
    public $_tables     = array(
        'cities'    => 'cities',
        'stores'    => 'stores',
        'photos'    => 'store_photos',
        'delivery'  => 'delivery_cities',
        'districts' => 'delivery_districts',
    );

    const CT_WORKSHOP = 1;
    const CT_WHOLESALE = 2;
    public static $TYPES = [
        self::CT_WORKSHOP => ['name' => 'букетные мастерские', 'class' => 'bouquet-shop'],
        self::CT_WHOLESALE => ['name' => 'оптовый центр', 'class' => 'wholesale-center'],
    ];

    private $_cache     = null;

    public function __construct()
    {
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('images');

        $this->_db = DBFactory::GetInstance('gilmon');
        if($this->_db == false)
            throw new RuntimeBTException('ERR_L_CITIES_CANT_CONNECT_TODB', ERR_L_CITIES_CANT_CONNECT_TODB);

        $this->_cache = $this->getCache();
    }

    public function getCache()
    {
        LibFactory::GetStatic('cache');

        $cache = new Cache();
        $cache->Init('memcache', 'citiesmgr');

        return $cache;
    }

    static function &getInstance ()
    {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }

    private function _citiesObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $city = new City($info);
        if (isset($info['CityID']))
            $this->cities[ $info['CityID'] ] = $city;

        return $city;
    }

    public function AddCity(array $info)
    {
        unset($info['CityID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "INSERT INTO ".$this->_tables['cities']." SET Created = NOW(), LastUpdated = NOW(), ".implode(', ', $fields);
        echo $sql; exit;

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveCity($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = "DELETE FROM ".$this->_tables['cities']." WHERE CityID = ".$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('city_'.$id);

            unset($this->cities[$id]);
            return true;
        }

        return false;
    }

    public function UpdateCity(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['CityID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "UPDATE ".$this->_tables['cities']." SET LastUpdated = NOW(), ".implode(', ', $fields);
        $sql.= " WHERE CityID = ".$info['CityID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('city_'.$info['CityID']);

            return true;
        }

        return false;
    }

    public function GetCityInfo($name) {

        $sql = "SELECT * FROM ".$this->_tables['cities'];
        $sql .= " WHERE LOWER(NameID) = '".strtolower($name)."'";

        $res = $this->_db->query($sql);
        if ( false === $res || !$res->num_rows )
        {
            $sql = "SELECT * FROM ".$this->_tables['cities'];
            $sql .= " WHERE IsDefault = 1";

            if ( false === ($res = $this->_db->query($sql)))
                return false;
        }

        if (!$res->num_rows)
            return false;

        return $this->_citiesObject($res->fetch_assoc());
    }

    public function GetCity($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->cities[$id]) )
            return $this->cities[$id];

        $info = false;

        $cacheid = 'city_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = "SELECT * FROM ".$this->_tables['cities']." WHERE CityID = ".$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $city = $this->_citiesObject($info);
        return $city;
    }

    public function GetCities($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'LastUpdated', 'Ord', 'name', 'isvisible')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }
        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('name');
            $filter['dir'] = array('DESC');
        }

        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;

        if ( isset($filter['flags']['Name']) && $filter['flags']['Name'] != -1 )
            $filter['flags']['Name'] = $filter['flags']['Name'];

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
        else
            $sql = 'SELECT * ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['cities'].' ';

        $where = array();


        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['cities'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( isset($filter['flags']['Name']) && $filter['flags']['Name'])
            $where[] = ' '.$this->_tables['cities'].'.Name = "'.$filter['flags']['Name'].'"';

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['cities'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['cities'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['cities'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo $sql;

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
                if ( isset($this->cities[$row['CityID']]) )
                    $row = $this->cities[$row['CityID']];
                else
                    $row = $this->_citiesObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    // Shipments block
    // Район доставки
    public function GetDelivery($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_Delivery[$id]) )
            return $this->_Delivery[$id];

        $info = false;

        $cacheid = 'delivery_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = "SELECT * FROM ".$this->_tables['delivery']." WHERE DeliveryID = ".$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $delivery = $this->_deliveryObject($info);
        return $delivery;
    }

    private function _deliveryObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $delivery = new DeliveryCity($info);
        if (isset($info['DeliveryID']))
            $this->_Delivery[ $info['DeliveryID'] ] = $delivery;

        return $delivery;
    }

    public function UpdateDelivery(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['DeliveryID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "UPDATE ".$this->_tables['delivery']." SET LastUpdated = NOW(), ".implode(', ', $fields);
        $sql.= " WHERE DeliveryID = ".$info['DeliveryID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('delivery_'.$info['DeliveryID']);

            return true;
        }

        return false;
    }

    public function AddDelivery(array $info)
    {
        unset($info['DeliveryID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "INSERT INTO ".$this->_tables['delivery']." SET Created = NOW(), ".implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveDelivery($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = "DELETE FROM ".$this->_tables['delivery']." WHERE DeliveryID = ".$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('delivery_'.$id);

            unset($this->_Delivery[$id]);
            return true;
        }

        return false;
    }

    //
    public function GetDeliveries($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'LastUpdated', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Created');
            $filter['dir'] = array('ASC');
        }

        if ( isset($filter['flags']['IsAvailable']) && $filter['flags']['IsAvailable'] != -1 )
            $filter['flags']['IsAvailable'] = (int) $filter['flags']['IsAvailable'];
        elseif (!isset($filter['flags']['IsAvailable']))
            $filter['flags']['IsAvailable'] = 1;

        if ( isset($filter['flags']['CityID']) && $filter['flags']['CityID'] != -1 )
            $filter['flags']['CityID'] = (int) $filter['flags']['CityID'];
        elseif (!isset($filter['flags']['CityID']))
            $filter['flags']['CityID'] = 1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
        else
            $sql = 'SELECT * ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['delivery'].' ';

        $where = array();

        if ( $filter['flags']['IsAvailable'] != -1 )
            $where[] = ' '.$this->_tables['delivery'].'.IsAvailable = '.$filter['flags']['IsAvailable'];

        if ( $filter['flags']['CityID'] != -1 )
            $where[] = ' '.$this->_tables['delivery'].'.CityID = '.$filter['flags']['CityID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['delivery'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['delivery'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['delivery'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        // if($filter['dbg'])
        //     echo $sql;

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
                if ( isset($this->_Delivery[$row['DeliveryID']]) )
                    $row = $this->_Delivery[$row['DeliveryID']];
                else
                    $row = $this->_deliveryObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    // DELIVERY DISTRICTS
    public function GetDistrict($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_District[$id]) )
            return $this->_District[$id];

        $info = false;

        $cacheid = 'district_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = "SELECT * FROM ".$this->_tables['districts']." WHERE DistrictID = ".$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $district = $this->_districtObject($info);
        return $district;
    }

    private function _districtObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $district = new District($info);
        if (isset($info['DistrictID']))
            $this->_District[ $info['DistrictID'] ] = $district;

        return $district;
    }

    public function UpdateDistrict(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['DistrictID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "UPDATE ".$this->_tables['districts']." SET LastUpdated = NOW(), ".implode(', ', $fields);
        $sql.= " WHERE DistrictID = ".$info['DistrictID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('district_'.$info['DistrictID']);

            return true;
        }

        return false;
    }

    public function AddDistrict(array $info)
    {
        unset($info['DistrictID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "INSERT INTO ".$this->_tables['districts']." SET Created = NOW(), ".implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveDistrict($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = "DELETE FROM ".$this->_tables['districts']." WHERE DistrictID = ".$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('district_'.$id);

            unset($this->_District[$id]);
            return true;
        }

        return false;
    }

    public function GetDistricts($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'LastUpdated', 'Ord', 'ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Created');
            $filter['dir'] = array('ASC');
        }

        if ( isset($filter['flags']['IsAvailable']) && $filter['flags']['IsAvailable'] != -1 )
            $filter['flags']['IsAvailable'] = (int) $filter['flags']['IsAvailable'];
        elseif (!isset($filter['flags']['IsAvailable']))
            $filter['flags']['IsAvailable'] = -1;

        if ( isset($filter['flags']['DeliveryID']) && $filter['flags']['DeliveryID'] != -1 )
            $filter['flags']['DeliveryID'] = (int) $filter['flags']['DeliveryID'];
        elseif (!isset($filter['flags']['DeliveryID']))
            $filter['flags']['DeliveryID'] = -1;

        if ( isset($filter['flags']['CityID']) && $filter['flags']['CityID'] != -1 )
            $filter['flags']['CityID'] = (int) $filter['flags']['CityID'];
        elseif (!isset($filter['flags']['CityID']))
            $filter['flags']['CityID'] = -1;

        if ( isset($filter['flags']['IsDefault']) && $filter['flags']['IsDefault'] != -1 )
            $filter['flags']['IsDefault'] = (int) $filter['flags']['IsDefault'];
        elseif (!isset($filter['flags']['IsDefault']))
            $filter['flags']['IsDefault'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
        else
            $sql = 'SELECT * ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['districts'].' ';

        $where = array();

        if ( $filter['flags']['IsAvailable'] != -1 )
            $where[] = ' '.$this->_tables['districts'].'.IsAvailable = '.$filter['flags']['IsAvailable'];

        if ( $filter['flags']['IsDefault'] != -1 )
            $where[] = ' '.$this->_tables['districts'].'.IsDefault = '.$filter['flags']['IsDefault'];


        if ( $filter['flags']['DeliveryID'] != -1 )
            $where[] = ' '.$this->_tables['districts'].'.DeliveryID = '.$filter['flags']['DeliveryID'];

        if ( $filter['flags']['CityID'] != -1 )
            $where[] = ' '.$this->_tables['districts'].'.CityID = '.$filter['flags']['CityID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['districts'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['districts'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['districts'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        // if($filter['dbg'] == 1)
        //     echo $sql;

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
                if ( isset($this->_District[$row['DistrictID']]) )
                    $row = $this->_District[$row['DistrictID']];
                else
                    $row = $this->_districtObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    // STORE SECTION

    public function GetStore($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_Store[$id]) )
            return $this->_Store[$id];

        $info = false;

        $cacheid = 'store_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = "SELECT * FROM ".$this->_tables['stores']." WHERE StoreID = ".$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $store = $this->_storeObject($info);
        return $store;
    }

    private function _storeObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $store = new Store($info);
        if (isset($info['StoreID']))
            $this->_Store[ $info['StoreID'] ] = $store;

        return $store;
    }

    public function UpdateStore(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['StoreID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "UPDATE ".$this->_tables['stores']." SET LastUpdated = NOW(), ".implode(', ', $fields);
        $sql.= " WHERE StoreID = ".$info['StoreID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('store_'.$info['StoreID']);

            return true;
        }

        return false;
    }

    public function AddStore(array $info)
    {
        unset($info['StoreID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = "INSERT INTO ".$this->_tables['stores']." SET Created = NOW(), ".implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveStore($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = "DELETE FROM ".$this->_tables['stores']." WHERE StoreID = ".$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('store_'.$id);

            unset($this->_Store[$id]);
            return true;
        }

        return false;
    }

    public function GetStores($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'LastUpdated', 'Ord', 'ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Created');
            $filter['dir'] = array('ASC');
        }

        if ( isset($filter['flags']['IsAvailable']) && $filter['flags']['IsAvailable'] != -1 )
            $filter['flags']['IsAvailable'] = (int) $filter['flags']['IsAvailable'];
        elseif (!isset($filter['flags']['IsAvailable']))
            $filter['flags']['IsAvailable'] = 1;

        if ( isset($filter['flags']['DeliveryID']) && $filter['flags']['DeliveryID'] != -1 )
            $filter['flags']['DeliveryID'] = (int) $filter['flags']['DeliveryID'];
        elseif (!isset($filter['flags']['DeliveryID']))
            $filter['flags']['DeliveryID'] = -1;

        if ( isset($filter['flags']['CityID']) && $filter['flags']['CityID'] != -1 )
            $filter['flags']['CityID'] = (int) $filter['flags']['CityID'];
        elseif (!isset($filter['flags']['CityID']))
            $filter['flags']['CityID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
        else
            $sql = 'SELECT * ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['stores'].' ';

        $where = array();

        if ( $filter['flags']['IsAvailable'] != -1 )
            $where[] = ' '.$this->_tables['stores'].'.IsAvailable = '.$filter['flags']['IsAvailable'];

        if ( $filter['flags']['DeliveryID'] != -1 )
            $where[] = ' '.$this->_tables['stores'].'.DeliveryID = '.$filter['flags']['DeliveryID'];

        if ( $filter['flags']['CityID'] != -1 )
            $where[] = ' '.$this->_tables['stores'].'.CityID = '.$filter['flags']['CityID'];

        if( isset($filter['flags']['HasPickup']) && in_array(intval($filter['flags']['HasPickup']), [0,1]) )
            $where[] = ' '.$this->_tables['stores'].'.HasPickup = '.$filter['flags']['HasPickup'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['stores'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['stores'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['stores'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

         if($filter['dbg'])
             echo $sql;

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
                if ( isset($this->_Store[$row['StoreID']]) )
                    $row = $this->_Store[$row['StoreID']];
                else
                    $row = $this->_storeObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);
        return $result;
    }

    // photo section
        //  ======================================
    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Photo. В случае ошибки вернет null
     */
    private function _photoObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Photo($info);
        if (isset($info['photoid']))
            $this->_photos[ $info['photoid'] ] = $obj;

        return $obj;
    }


    /**
    * @return Объект Photo. В случае ошибки вернет null
    */
    public function GetPhoto($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_photos[$id]) )
            return $this->_photos[$id];

        $info = false;

        $cacheid = 'photo_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $obj = $this->_photoObject($info);
        return $obj;
    }

    /**
    * @return id of added item or false
    */
    public function AddPhoto(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['photoid']);
        unset($info['created']);
        unset($info['updated']);

        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['photos'].' SET Created=NOW(), Updated=NOW(), ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of updated item or false
    */
    public function UpdatePhoto(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['photoid']) )
            return false;

        unset($info['created']);
        unset($info['updated']);

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['photos'].' SET Updated=NOW(), ' . implode(', ', $fields);
        $sql .= ' WHERE PhotoID = '.$info['photoid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('photo_'.$info['photoid']);

            unset($this->_photos[$info['photoid']]);
            return $info['photoid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemovePhoto($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $photo = $this->GetPhoto($id);
        if($photo == null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('photo_'.$id);

            unset($this->_photos[$id]);
            return true;
        }

        return false;
    }

    public function GetPhotos($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Created', 'Updated', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Ord');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['StoreID']) && $filter['flags']['StoreID'] != -1 )
            $filter['flags']['StoreID'] = (int) $filter['flags']['StoreID'];
        elseif (!isset($filter['flags']['StoreID']))
            $filter['flags']['StoreID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['photos'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['photos'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['photos'].' ';

        $where = array();

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['photos'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['photos'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['photos'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['StoreID'] != -1 )
            $where[] = ' '.$this->_tables['photos'].'.StoreID = '.$filter['flags']['StoreID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['photos'].'.`'.$v.'`';
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

        // if($filter['dbg'] == 1)
        // {
        //     echo $sql;
        // }

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
                $id = $row['PhotoID'];
                if ( isset($this->_photos[$id]) )
                    $row = $this->_photos[$id];
                else
                    $row = $this->_photoObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function Dispose()
    {

    }

    public static function setCurrentCity($cityId)
    {
        setcookie(self::CITY_COOKIE, $cityId, 0, "/");
    }

    public static function getCurrentcity()
    {
        if(isset($_COOKIE[self::CITY_COOKIE])) {
            return $_COOKIE[self::CITY_COOKIE];
        }

        return null;
    }

    public function getCityByName($name)
    {
        $filter = [
            'flags' => [
                'Name' => $name,
                'IsVisible' => 1,
            ],
            'dbg' => 0,
        ];

        $cities = $this->getCities($filter);

        return count($cities) > 0 ? $cities[0] : null;
    }
}
