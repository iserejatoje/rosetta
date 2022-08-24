<?php

LibFactory::GetStatic('arrays');

class News
{
    private $_fields = array(
        'newsid'    => 'int',
        'published' => 'date',
        // 'updated'   => 'date',
        // 'created'   => 'date',
        'ord'       => 'int',
        'isvisible' => 'bool',
        'title'     => 'string',
        'announce'  => 'string',
        'text'      => 'string',
        'photo'     => 'photo',
    );

    private $_values = array();

    private $resize_params = array(
        'photo' => null,
    );

    private $_images_dir = '/common_fs/i/common_news/';
    private $_images_url = '/resources/fs/i/common_news/';

    private $file_size = 2097152; //2M


    function __construct(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

        if ( isset($info['newsid']) && Data::Is_Number($info['newsid']) )
            $this->_values["newsid"] = $info['newsid'];
        else
            $this->_values["newsid"] = 0;

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

    public function __get($name)
    {
        $name = strtolower($name);

        if ($name == 'id')
            return $this->_values['newsid'];

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
                        echo $fail; exit;
                        return null;
                    }

                    return array(
                        'f' => $preparedImage['url'],
                        'w' => $preparedImage['w'],
                        'h' => $preparedImage['h'],
                    );
                    break;
                case 'date':
                    return strtotime($this->_values[$name]);

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

                case 'date':
                    $this->_values[$name] = date('Y-m-d', strtotime($value));
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
            $inputName, $this->_images_dir, rand(1000, 9999).$this->_values['newsid'].'_'.mb_strtolower($name),
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
        if ($this->_values['newsid'] === 0)
        {
            return  $this->_values["newsid"] = NewsMgr::getInstance()->AddNews($this->_values);
        }
        else
        {
            return NewsMgr::getInstance()->UpdateNews($this->_values);
        }
    }



//  Удаление продуктов
    public function Remove()
    {
        if ($this->_values['newsid'] === 0)
            return false;

        //remove photos
        foreach ($this->_fields as $name => $type)
        {
            if ($type == 'photo')
            {
                $this->__set($name, null);
            }
        }

        return NewsMgr::getInstance()->RemoveNews($this->_values['newsid']);
    }

}