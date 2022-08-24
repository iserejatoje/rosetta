<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/banners/banner.php');
require_once ($CONFIG['engine_path'].'include/banners/place.php');

class BannerMgr
{
    const T_IMAGE = 1;
    const T_FLASH = 2;
    const T_TEXT = 3;
    const T_JAVASCRIPT = 4;
    const T_IMAGE_WITH_BTN = 5;

    public static $TYPES = array(
		self::T_IMAGE => 'Картинка',
//		self::T_FLASH => 'Flash',
        self::T_TEXT => 'Текст / встраиваемое видео',
//        self::T_JAVASCRIPT => 'JavaScript',
        self::T_IMAGE_WITH_BTN => 'Картинка с кнопкой play',
    );

    const T_ACL_URL = 1;
    const T_ACL_DATE = 2;
    const T_ACL_DATE_MASK = 3;
    public static $ACL_TYPES = array(
        self::T_ACL_URL => 'По адресу',
        //self::T_ACL_DATE => 'По промежутку дат',
        //self::T_ACL_DATE_MASK => 'По маске для даты',
    );

    const PERM_ACL_DENY = 0;
    const PERM_ACL_ALLOW = 1;
    public static $PERMS_ACL = array(
        self::PERM_ACL_ALLOW => 'Разрешить',
        self::PERM_ACL_DENY => 'Запретить',
    );
    /**
     * Кэш мест
     */
    private $_Banners = array();
    private $_Places = array();

    private static $_views_counter = array();


    public $_db			= null;
    public $_tables		= array(
        'places'		=> 'banner_place',
        'banners'		=> 'banners',
        'acls'			=> 'banners_acl',
    );

    private $_cache		= null;
    private $encode_urls		= null;

    private static $rand_urls = array ();

    public function __construct($caching = true, $encode_urls = false)
    {
        LibFactory::GetStatic('data');
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('images');

        $this->_db = DBFactory::GetInstance($this->dbname);
        if($this->_db == false)
            throw new RuntimeBTException('ERR_L_Share_CANT_CONNECT_TODB', ERR_L_Share_CANT_CONNECT_TODB);

        if ($caching === true) {
            $this->_cache = $this->getCache();
        }

        $this->encode_urls = $encode_urls === true;
    }


    /**
     * Получить объект memcache'а
     *
     * @return Cache
     */
    public function getCache() {

        LibFactory::GetStatic('cache');

        $cache = new Cache();
        $cache->Init('memcache', 'bannermgr');

        return $cache;
    }

    static function &getInstance ($caching = true) {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }

    /**
     * Получить акцию по идентификатору
     *
     * @param int $id - id'шник фирмы
     * @return Share В случае ошибки вернет null
     */
    public function GetBanner($id)
    {
        if ( !Data::Is_Number($id) )
            return null;

        if ( isset($this->_Banners[$id]) )
            return $this->_Banners[$id];

        $info = false;

        $cacheid = 'Banner_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $info = array();

            $sql = 'SELECT * FROM '.$this->_tables['banners'].' WHERE BannerID = '.$id;
            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        $Share = $this->_GetBanner($info);
        return $Share;
    }


    /**
     * По строке из базы получить объект Share
     *
     * @param array $info
     * @return Share
     */
    private function _GetBanner(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $banner = new Banner($info, $this->encode_urls);
        if (isset($info['BannerID']))
            $this->_Banners[ $info['BannerID'] ] = $banner;

        return $banner;
    }

    private function _GetPlace(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $place = new BannerPlace($info);
        if (isset($info['PlaceID']))
            $this->_Places[ $info['PlaceID'] ] = $place;

        return $place;
    }

    /**
     * добавить акцию
     *
     * @param info    информация о акции
     */
    public function Add(array $info)
    {
        unset($info['BannerID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['banners'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
     * удалить место
     *
     * @param id    идентификатор
     */
    public function Remove($id)
    {
        if ( !Data::Is_Number($id) )
            return false;


        $sql = 'DELETE FROM '.$this->_tables['banners'].' WHERE BannerID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Banner_'.$id);
            $cache->Remove("banners_by_place_".$this->_Banners[$id]['PlaceID']."_0");
            $cache->Remove("banners_by_place_".$this->_Banners[$id]['PlaceID']."_1");

            unset($this->_Banners[$id]);
            return true;
        }

        return false;
    }


    /**
     * обновить информацию о месте
     *
     * @param info    информация о месте
     */
    public function Update(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['BannerID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['banners'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE BannerID = '.$info['BannerID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Banner_'.$info['BannerID']);

            $cache->Remove("banners_by_place_".$info['PlaceID']."_0");
            $cache->Remove("banners_by_place_".$info['PlaceID']."_1");

            return true;
        }

        return false;
    }

    public function IncreaseClicks($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return;
        $sql = "UPDATE ".$this->_tables['banners']." SET";
        $sql.= " Clicks = Clicks + 1";
        $sql.= " WHERE BannerID = ".$id;

        $this->_db->query($sql);
    }

    public function IncreaseViews()
    {
        if (count(self::$_views_counter) == 0)
            return;

        foreach(self::$_views_counter as $id)
        {
            $sql = "UPDATE ".$this->_tables['banners']." SET";
            $sql.= " Views = Views + 1";
            $sql.= " WHERE BannerID = ".$id;

            $this->_db->query($sql);
        }
    }

    public function GetBannersByPlaceID($id, $is_visible = 1)
    {
        $is_visible = intval($is_visible == 1);

        $cacheid = "banners_by_place_".$id."_".$is_visible;

        if ($this->_cache !== null)
            $result = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $result = false;

        if ($result === false)
        {
            $sql = "SELECT b.* FROM ".$this->_tables['places']." p";
            $sql.= " INNER JOIN ".$this->_tables['banners']." b ON (p.PlaceID=b.PlaceID)";
            $sql.= " WHERE p.PlaceID=".$id;
            $sql.= " AND p.IsVisible=".$is_visible;

            $res = $this->_db->query($sql);

            $result = array();
            if ($res !== false && $res->num_rows > 0)
                while ($row = $res->fetch_assoc())
                {
                    if ($row['IsVisible'] == 0)
                        continue;
                    $result[] = $row;
                }

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $result, 3600);
        }

        if (!is_array($result) || count($result) == 0)
            return false;


        foreach($result as &$row)
        {
            if ( isset($this->_Banners[$row['BannerID']]) )
                $row = $this->_Banners[$row['BannerID']];
            else
                $row = $this->_GetBanner($row);
        }

        return $result;
    }

    public function GetBanners($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Name', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('BannerID');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;

        if ( isset($filter['flags']['PlaceID']) && $filter['flags']['PlaceID'] != -1 )
            $filter['flags']['PlaceID'] = (int) $filter['flags']['PlaceID'];
        elseif (!isset($filter['flags']['PlaceID']))
            $filter['flags']['PlaceID'] = -1;

        if ( isset($filter['flags']['Type']) && $filter['flags']['Type'] != -1 )
            $filter['flags']['Type'] = (int) $filter['flags']['Type'];
        elseif (!isset($filter['flags']['Type']))
            $filter['flags']['Type'] = -1;


        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['banners'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['banners'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['banners'].' ';

        $where = array();

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['banners'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['PlaceID'] != -1 )
            $where[] = ' '.$this->_tables['banners'].'.PlaceID = '.$filter['flags']['PlaceID'];

        if ( $filter['flags']['Type'] != -1 )
            $where[] = ' '.$this->_tables['banners'].'.Type = '.$filter['flags']['Type'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['banners'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['banners'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['shares'].'.`'.$v.'`';
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

        //if ($_GET['debug']>12)
        //echo $sql."\n";
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
                if ( isset($this->_Banners[$row['BannerID']]) )
                    $row = $this->_Banners[$row['BannerID']];
                else
                    $row = $this->_GetBanner($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function GetHTML($placeid, $bannerid = null, $id = "", $class = "")
    {
        if ($bannerid === null)
        {

            $prebanners = BannerMgr::GetInstance()->GetBannersByPlaceID($placeid);
            if ($prebanners === false)
                return "";

            $banners = array();
            foreach($prebanners as $b)
            {
                $acls = $b->GetAcls(1);
                if ($acls === false)
                {
                    $banners[] = $b;
                }
                else
                {
                    $acls[] = array(
                        'Type' => self::T_ACL_URL,
                        'Permission' => self::PERM_ACL_DENY,
                        'Rule' => "*",
                    );

                    $url = $_SERVER['REQUEST_URI'];

                    $time_str = date("d.m.Y H:i");//"01.03.2012 02:00";
                    $time = strtotime($time_str);
                    $time_pattern = date("d.m.Y H:i",$time);

                    foreach($acls as $k => $v)
                    {
                        if ($v['Type'] == self::T_ACL_URL)
                        {
                            $rule = str_replace("*", ".*?", $v['Rule']);
                            $rule_flag = intval(preg_match("@".$rule."@", $url)) > 0;

                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_ALLOW)
                            {
                                $banners[] = $b;
                                break;
                            }
                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_DENY)
                                break;
                        }
                        else if ($v['Type'] == self::T_ACL_DATE)
                        {
                            $rule = $v['Rule'];

                            list($from, $to) = explode(";", $v['Rule']);
                            $from = strtotime(str_replace(",", " ", $from));
                            $to = strtotime(str_replace(",", " ", $to));

                            $rule_flag = $time >= $from && $time <= $to;

                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_ALLOW)
                            {
                                $banners[] = $b;
                                break;
                            }
                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_DENY)
                                break;
                        }
                        else if ($v['Type'] == self::T_ACL_DATE_MASK)
                        {
                            $rule = str_replace(array(".","*"), array("\.",".*?"), $v['Rule']);

                            $rule_flag = intval(preg_match("@".$rule."@", $time_pattern)) > 0;

                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_ALLOW)
                            {
                                $banners[] = $b;
                                break;
                            }
                            if ($rule_flag === true && $v['Permission'] == self::PERM_ACL_DENY)
                                break;
                        }
                    }
                }
            }

            $place = BannerMgr::GetInstance()->GetPlace($placeid);

            $time_now = time();
            $weights = 0;
            foreach($banners as $b)
            {
                $weights += $b->Weight;
            }

            $weight = floor($time_now / $place->Interval) % $weights;

            $_weight = 0;
            foreach($banners as $k => $b)
            {
                $_weight += $b->Weight;
                if($weight < $_weight)
                {
                    $bannerpos = $k;
                    break;
                }
            }

            $banner = $banners[$bannerpos];
        }
        else
        {
            $banner = BannerMgr::GetInstance()->GetBanner($bannerid);
            if ($banner === false)
                return "";
        }

        if ($_GET['bp'] == 1)
        {
            return '<div style="width:'.($banner->Width-2).'px;height:'.($banner->Height-2).'px;display:inline-block;background-color:#ffffff;border:solid 1px #898989;text-align:center;"><div style="padding-top:'.($banner->Height/2 - 5).'px;">'.$placeid.' ('.$banner->Width."x".$banner->Height.')</div></div>';
        }

        if ($banner->Type == BannerMgr::T_IMAGE)
            $html = BannerMgr::getHtmlImage($banner, $id, $class);
        elseif ($banner->Type == BannerMgr::T_FLASH)
            $html = BannerMgr::getHtmlFlash($banner, $id, $class);
        elseif ($banner->Type == BannerMgr::T_TEXT)
            $html = BannerMgr::getHtmlText($banner);
        elseif ($banner->Type == BannerMgr::T_JAVASCRIPT)
            $html = BannerMgr::getHtmlJavascript($banner);

        if (!isset(self::$_views_counter[$banner->ID]))
            self::$_views_counter[$banner->ID] = 0;

        self::$_views_counter[$banner->ID]++;

        return $html;
    }

    private static function getHtmlImage($b, $id = "", $class = "")
    {
        $html = "";
        if ($b->Url != "")
            $html = '<a href="'.$b->EncodeUrl.'" target="_blank">';

        $sub = "";
        if ($id != "")
            $sub .= ' id="'.$id.'"';
        if ($class != "")
            $sub .= ' class="'.$class.'"';

        $width_text = "";
        if($b->Width > 0)
            $width_text = 'width="'.$b->Width.'" ';

        $height_text = "";
        if($b->Height > 0)
            $height_text = 'height="'.$b->Height.'" ';

        $html .= '<img src="'.$b->File['f'].'"'.$width_text.$height_text.'"'.$sub.'/>';


        if ($b->Url != "")
            $html .= '</a>';
        return $html;
    }

    private function getHtmlFlash($b, $id = "", $class = "")
    {
        $sub = "";
        if ($id != "")
            $sub .= ' id="'.$id.'"';
        if ($class != "")
            $sub .= ' class="'.$class.'"';

        $file = $b->File['f'];
        $html = '<object width="'.$b->Width.'" height="'.$b->Height.'"'.$sub.'>';
        $html.= '<param name="movie" value="'.$file.'"/>';
        $html.= '<param name="quality" value="high" />';
        $html.= '<param name="wmode" value="transparent">';
        $html.= '<param name="scale" value="exactfit">';
        $html.= '<embed src="'.$file.'" quality="high" type="application/x-shockwave-flash" scale="exactfit" wmode="transparent" menu="false" width="'.$b->Width.'" height="'.$b->Height.'"></embed>';
        $html.= '</object>';
        return $html;
    }

    private function getHtmlText($b)
    {
        $html = '<a href="'.$b->EncodeUrl.'" target="_blank" style="width:'.$b->Width.'px;height:'.$b->Height.'px;display:inline-block;">'.$b->BannerText.'</a>';

        return $html;
    }

    private function getHtmlJavascript($b)
    {
        if ($b->Url != "")
            $html = '<a href="'.$b->Url.'" style="width:'.$b->Width.'px;height:'.$b->Height.'px;display:inline-block;" target="_blank">'.$b->BannerText.'</a>';
        else
            $html = '<div style="width:'.$b->Width.'px;height:'.$b->Height.'px;display:inline-block;">'.$b->BannerText.'</div>';

        return $html;
    }

    public function AddPlace(array $info)
    {
        unset($info['PlaceID']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['places'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
     * удалить место
     *
     * @param id    идентификатор
     */
    public function RemovePlace($id)
    {
        if ( !Data::Is_Number($id) )
            return false;


        $sql = 'DELETE FROM '.$this->_tables['places'].' WHERE PlaceID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Place_'.$id);
            $cache->Remove("banners_by_place_".$id."_0");
            $cache->Remove("banners_by_place_".$id."_1");

            unset($this->_Places[$id]);
            return true;
        }

        return false;
    }


    /**
     * обновить информацию о месте
     *
     * @param info    информация о месте
     */
    public function UpdatePlace(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['PlaceID']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['places'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE PlaceID = '.$info['PlaceID'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Place_'.$info['BankID']);

            return true;
        }

        return false;
    }

    public function GetPlace($id)
    {
        if ( !Data::Is_Number($id) )
            return null;

        if ( isset($this->_Places[$id]) )
            return $this->_Places[$id];

        $info = false;

        $cacheid = 'Place_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $info = array();

            $sql = 'SELECT * FROM '.$this->_tables['places'].' WHERE PlaceID = '.$id;
            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        $Share = $this->_GetPlace($info);
        return $Share;
    }

    public function GetPlaces($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Name')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Name');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;


        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['places'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['places'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['places'].' ';

        $where = array();

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['places'].'.IsVisible = '.$filter['flags']['IsVisible'];



        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['banners'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['banners'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
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
                $group[] = ' '.$this->_tables['places'].'.`'.$v.'`';
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

        if ($_GET['debug']>12)
            echo $sql."\n";
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
                if ( isset($this->_Places[$row['PlaceID']]) )
                    $row = $this->_Places[$id];
                else
                    $row = $this->_GetPlace($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public static function GetRandPartUrl()
    {
        return self::$rand_urls[rand(0,999)];
    }

    public function Dispose()
    {
        if(!empty($this->_Banners))
            foreach($this->_Banners as $k => $v)
                $this->_Banners[$k] = null;

        $this->_Banners = null;
        $this->_Banners = array();
    }
}