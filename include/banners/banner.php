<?php

class Banner
{
    private $_mgr;
    private $cachePlace;

    public $ID;
    public $PlaceID;
    public $Type;
    public $Url;
    public $BannerText;
    public $IsVisible;
    public $Width;
    public $Height;
    public $Ord;

    private $File;
    private $encode_urls;

    private $_images_dir = '/common_fs/i/images/';
    private $_images_url = '/resources/fs/i/images/';

    private $thumb_size = array('max_width' => 1027, 'max_height' => 768);
    private $thumb_file_size = 4194304; //700K

    private $cache;

    function __construct(array $info, $encode = false)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['bannerid']) && Data::Is_Number($info['bannerid']) ) {
            $this->ID = $info['bannerid'];
        }

        $this->PlaceID    = intval($info['placeid']);
        $this->Type       = intval($info['type']);
        $this->Width      = intval($info['width']);
        $this->Ord        = intval($info['ord']);
        $this->Height     = intval($info['height']);
        $this->Url        = stripslashes($info['url']);
        $this->BannerText = stripslashes($info['bannertext']);
        $this->IsVisible  = $info['isvisible'] ? true : false;
        $this->File       = $info['file'];

        $this->cache = BannerMgr::GetInstance()->GetCache();
        $this->encode_urls = $encode === true;
    }

    /**
     * сохранить информацию в базе
     * использует метод плагина и метод EShopMgr
     */

    public function Update()
    {
        $info = array(
            'PlaceID'    => (int) $this->PlaceID,
            'Type'       => (int) $this->Type,
            'Width'      => (int) $this->Width,
            'Ord'        => (int) $this->Ord,
            'Height'     => (int) $this->Height,
            'Url'        => stripslashes($this->Url),
            'BannerText' => stripslashes($this->BannerText),
            'IsVisible'  => (int) $this->IsVisible,
            'File'       => $this->File,
        );

        if ( $this->ID !== null ) {
            $info['BannerID'] = $this->ID;

            if ( false !== BannerMgr::getInstance()->Update($info)) {
                $this->cache->Remove('banner_url_'.$this->ID);
                $this->cache->Remove('banner_click_url_'.$this->ID);
                return true;
            }
        } else if ( false !== ($new_id = BannerMgr::getInstance()->Add($info))) {
            $this->ID = $new_id;

            return $new_id;
        }

        return false;
    }



    private function _deleteFile()
    {
        try {
            if( ($img_obj = FileStore::ObjectFromString($this->File)) !== false ) {
                $del_file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);

                if (FileStore::IsFile($del_file)) {
                    return FileStore::Delete_NEW($del_file);
                }
            }
        }

        catch(MyException $e) { }

        return false;
    }

    public function UploadFile()
    {
        global $OBJECTS;
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('filemagic');

        if (empty($_FILES['File']['name'])) {
            return "";
        }

        $pname = FileStore::Upload_NEW(
            'File', $this->_images_dir, rand(1000, 9999).$this->ID.'_b',
            null, $this->thumb_file_size
        );

        $pname = FileStore::GetPath_NEW($pname);

        if ($this->Type == BannerMgr::T_IMAGE) {
            $thumbNew = Images::PrepareImageToObject($pname, $this->_images_dir);
            $pname = FileStore::ObjectToString($thumbNew);
        } elseif($this->Type == BannerMgr::T_FLASH) {
            $thumbNew = FileStore::PrepareFileToObject($pname, $this->_images_dir);
            $pname = FileStore::ObjectToString($thumbNew);
        }

        $this->__set('File', $pname);
        return $result;
    }

    public function Remove()
    {
        if ( $this->ID === null) {
            return false;
        }

        $this->_deleteFile();
        // $this->ClearAcls();

        $this->cache->Remove('banner_url_'.$this->ID);
        $this->cache->Remove('banner_click_url_'.$this->ID);

        BannerMgr::getInstance()->Remove($this->ID);
    }

    public function prepareUrl()
    {
        if ($this->encode_urls === false) {
            return $this->Url;
        }

        $cacheid = "banner_click_url_".$this->ID;

        if ($this->cache !== null) {
            $encode_url = $this->cache->get($cacheid);
        }

        LibFactory::GetStatic('basex64');

        $data = array(
            'u' => $this->Url,
            'b' => $this->ID,
            't' => 'counter',
            'r' => Data::GetRandStr(10),
        );

        $encode_url = Basex64::encode(serialize($data));
        $encode_url = Basex64::encode($encode_url);
        //$len = floor(mb_strlen($encode_url) / 2);
        //$pos = rand($len - 15, $len + 15);
        //$encode_url = mb_substr($encode_url, 0, $pos)."/".mb_substr($encode_url, $pos, $len);
        $encode_url = "http://gilmon.ru/".BannerMgr::GetRandPartUrl()."/".$encode_url."/";

        $this->cache->set($cacheid, $encode_url, 3600);

        return $encode_url;
    }

    private function preparePathFile($info)
    {
        //if ($this->encode_urls === false)
            return $info['url'];
        $cacheid = "banner_url_".$this->ID;
        //if ($this->cache !== null)
        //  $encode_url = $this->cache->get($cacheid);

        LibFactory::GetStatic('basex64');
        $data = array(
            'u' => $info['url'],
            't' => 'content',
            's' => $info['size'],
            'm' => $info['mime'],
            'r' => Data::GetRandStr(4),
        );

        $encode_url = Basex64::encode(serialize($data));
        $encode_url = Basex64::encode($encode_url);

        $len = mb_strlen($encode_url);
        $floor_len = floor($len / 2);
        $pos = rand($floor_len - 15, $floor_len + 15);

        $encode_url = mb_substr($encode_url, 0, $pos)."/".mb_substr($encode_url, $pos, $len);
        $encode_url = "/".BannerMgr::GetRandPartUrl()."/".$encode_url."/";

        $this->cache->set($cacheid, $encode_url, 3600);
        return $encode_url;
    }

    public function __set($name, $value)
    {
        LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

        $name = strtolower($name);
        switch($name) {
            case 'file':
                if ($value === null) {
                    if ($this->File) {
                        $this->_deleteFile();
                    }

                    $this->File = '';

                    return $value;
                }

                try {
                    if(($img_obj = FileStore::ObjectFromString($value)) !== false ) {
                        $file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);

                        if(FileStore::IsFile($file)) {
                            $this->__set($name, null);
                            return $this->File = FileStore::ObjectToString($img_obj);
                        }
                    }
                }
                catch(MyException $e) { }
            break;
        }

        return null;
    }

    public function __get($name)
    {
        $name = strtolower($name);
        switch($name) {
            case 'file':
                if (!$this->Type)
                    return null;

                LibFactory::GetStatic('images');
                LibFactory::GetStatic('filestore');

                if ($this->Type == BannerMgr::T_IMAGE || $this->Type == BannerMgr::T_IMAGE_WITH_BTN) {
                    try {
                        $img_obj = FileStore::ObjectFromString($this->File);
                        $img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
                        $preparedImage = Images::PrepareImageFromObject($img_obj,
                            $this->_images_dir, $this->_images_url);
                        unset($img_obj);

                        if (empty($preparedImage)) {
                            return null;
                        }

                    } catch ( MyException $e ) {
                        return null;
                    }

                    $url = $this->preparePathFile($preparedImage);

                    return array(
                        'f' => $url,
                        'w' => $preparedImage['w'],
                        'h' => $preparedImage['h'],
                    );
                } elseif($this->Type == BannerMgr::T_FLASH) {
                    try {
                        LibFactory::GetStatic('filemagic');
                        $img_obj = FileStore::ObjectFromString($this->File);
                        $img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
                        $preparedImage = FileStore::PrepareFileFromObject($img_obj,
                            $this->_images_dir, $this->_images_url);

                        unset($img_obj);

                        if (empty($preparedImage)) {
                            return null;
                        }

                    } catch(MyException $e) {
                        return null;
                    }

                    $url = $this->preparePathFile($preparedImage);

                    return array(
                        'f' => $url,
                    );
                }

            break;

            case 'place':
                if ($this->cachePlace !== null) {
                    return $this->cachePlace;
                }

                $this->cachePlace = BannerMgr::GetInstance()->GetPlace($this->PlaceID);
                return $this->cachePlace;
                break;

            case 'encodeurl':
                return $this->prepareUrl();
            break;

        }

        return null;

    }

    function __destruct()
    {
    }

}



