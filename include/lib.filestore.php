<?php

// {{{ FileStore Errors
$error_code = 1;
define('ERR_L_FileStore_MASK', 0x00011000);

define('ERR_L_FileStore_FILE_UPLOAD_ERROR', ERR_L_FileStore_MASK | $error_code++);
UserError::$Errors[ERR_L_FileStore_FILE_UPLOAD_ERROR] = 'Во время загрузки файла произошла ошибка.';

define('ERR_L_FileStore_WRONG_FILETYPE', ERR_L_FileStore_MASK | $error_code++);
UserError::$Errors[ERR_L_FileStore_WRONG_FILETYPE] = 'Неверный тип файла.';


// эту ошибку и все что дальше, нужно удалить после перевода полностью на Новые методы
define('ERR_M_FS_WRONG_PATH', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_WRONG_PATH] = 'Неверный путь "%1$s".';

define('ERR_M_FS_INTERNAL_ERROR', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_INTERNAL_ERROR] = 'Внутренняя ошибка.';

define('ERR_M_FS_FILE_NOT_FOUND', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_NOT_FOUND] = 'Файл не найден "%1$s".';

define('ERR_M_FS_FILE_SIZE_TO_BIG', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_SIZE_TO_BIG] = 'Размер файла слишком велик.';

define('ERR_M_FS_FILE_CANT_COPY', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_CANT_COPY] = 'Не удалось скопировать "%1$s" в "%2$s".';

define('ERR_M_FS_FILE_CANT_MOVE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_CANT_MOVE] = 'Не удалось переместить "%1$s" в "%2$s".';

define('ERR_M_FS_FILE_CANT_CHMOD', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_CANT_CHMOD] = 'Не удалось установить права на "%1$s".';

define('ERR_M_FS_FILE_CANT_CREATE_TF', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_CANT_CREATE_TF] = 'Не удалось создать временный файл.';

define('ERR_M_FS_FILE_UPLOAD_ERROR', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_UPLOAD_ERROR] = 'Во время загрузки файла произошла ошибка.';

define('ERR_M_FS_WRONG_RESIZE_PARAMS', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_WRONG_RESIZE_PARAMS] = 'Не заданы параметры уменьшения.';

define('ERR_M_FS_WRONG_COORDS_PARAMS', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_WRONG_COORDS_PARAMS] = 'Не заданы координаты.';

define('ERR_M_FS_FILE_UPLOAD_TYPE_WRONG', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILE_UPLOAD_TYPE_WRONG] = 'Неверный тип загружаемого файла.';


define('ERR_M_FS_CANT_CREATE_DIR', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_CANT_CREATE_DIR] = 'Невозможно создать директорию директорию "%1$s".';

define('ERR_M_FS_COPY_DIR_TO_FILE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_COPY_DIR_TO_FILE] = 'Невозможно скопировать директорию "%1$s" в файл "%2$s".';

define('ERR_M_FS_CANT_COPY_DIR_WO_RECURSIVE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_CANT_COPY_DIR_WO_RECURSIVE] = 'Невозможно скопировать директорию "%1$s" без рекурсии.';

define('ERR_M_FS_CANT_DELETE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_CANT_DELETE] = 'Невозможно удалить "%1$s".';

define('ERR_M_FS_DESTINATION_PATH_EXISTS', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_DESTINATION_PATH_EXISTS] = 'Путь назначения "%1$s" уже существует.';

define('ERR_M_FS_DIRECTORY_NO_EMPTY', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_DIRECTORY_NO_EMPTY] = 'Директория "%1$s" не пуста.';

define('ERR_M_FS_FILENAME_INSECURE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILENAME_INSECURE] = 'Имя файла содержит запрещенные символы "%1$s".';

define('ERR_M_FS_FILENAME_TO_SMALL', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_FILENAME_TO_SMALL] = 'Имя файла слишком короткое, чтобы построить путь "%1$s".';

define('ERR_M_FS_UNKNOWN_FILETYPE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_UNKNOWN_FILETYPE] = 'Неизвестный тип файла "%1$s".';

define('ERR_M_FS_WRONG_FILETYPE', ERR_L_FileStore_MASK | $error_code++);
$ERROR[ERR_M_FS_WRONG_FILETYPE] = 'Неверный тип файла "%1$s".';
// }}}


class FileStore
{
	static private $dir_perm = 0775;
	static private $file_perm = 0664;
	static private $dir_deep = 2;
	static private $dir_len = 2;
	static private $errno = 0;
	static private $error = '';
	static private $prefix		= array(
		'name' => '/common_fs/',
		'path' => '/var/tmp/',
	);
	static private $is_log = false;
	static private $log_file = '/tmp/filestore.log';
	
	static public function Init()
	{
		self::$prefix['path'] = FS_PATH;	
	}

	
	/**
	 * Подготовка данных для файла из объекта файла
	 *
	 * @param string $file имя файла
	 * @param string $dir путь до файла
	 * @return array (file, size, mime)
	 */
	static public function PrepareFileToObject($file, $dir = "")
	{
		LibFactory::GetStatic('filemagic');
		
		$img = array();
		try
		{
			$hm = self::GetRealPath($dir.$file);
			if( !is_file($hm) )
				throw new RuntimeBTException('File "'.$hm.'" not found when prepare images called');
			
			$size = @filesize($hm);
			if( $size === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine size of file "'.$hm.'": '.$err['message']);
			}			
			
			$inf = FileMagic::GetFileInfo($file);
		}
		catch (BTException $e)
		{
			return $img;
		}
		
		return array(
				"file"  => basename($file),
				"size"  => $size,
				"mime"  => $inf['mime_type'],
				);
	}
	
	/**
	 * Подготовка данных для файла из объекта файла
	 *
	 * @param array $object объект файла (file, size, mime)
	 * @param string $dir путь до файла
	 * @param string $url url до файла
	 * @return array (path, url, size, mime)
	 */
	static public function PrepareFileFromObject($object, $dir = "", $url = "")
	{
		$dir = self::GetRealPath($dir);
		
		return array(
				"path"  => $dir.$object['file'],
				"url"   => $url.$object['file'],
				"size"  => $object['size'],
				"mime"  => $object['mime'],
				);
	}
	
	/**
	 * Возвращает объект преобразованный в строку
	 * 
	 * @param array $obj объект
	 * @return bool
	 */
	static public function ObjectToString($obj)
	{
		return http_build_query($obj);
	}	
	
	/**
	 * Возвращает объект созданный из строки
	 * 
	 * @param string $string строка
	 * @return bool
	 * @exception InvalidArgumentMyException
	 */
	static public function ObjectFromString($string)
	{
		parse_str($string, $img_obj);
		if( isset($img_obj['file']) )
			return $img_obj;
		else
			throw new InvalidArgumentMyException('Can not parse string "'.$string.'" to object.');
	}	
	
	/**
	 * Проверка наличия директории
	 * 
	 * @param string $dir путь до директории
	 * @return bool
	 */
	static public function IsDir($dir)
	{
		self::SetError();
		$dir = self::GetRealPath($dir);		
		return is_dir($dir);
	}	
	
	/**
	 * Проверка наличия файла
	 *
	 * @param string $file путь до файла
	 * @return bool
	 */
	static public function IsFile($file)
	{
		self::SetError();
		$file = self::GetRealPath($file);
		return is_file($file);
	}	
	
	/**
	 * Проверка наличия линка
	 * 
	 * @param string $file путь до линка
	 * @return bool
	 */
	static public function IsLink($file)
	{
		self::SetError();
		$file = self::GetRealPath($file);		
		return is_link($file);
	}	
	
	/**
	 * Проверка наличия пути
	 * 
	 * @param string $file путь
	 * @return bool
	 */
	static public function FileExists($file)
	{
		self::SetError();
		$file = self::GetRealPath($file);		
		return file_exists($file);
	}	
	
	/**
	 * Возвращает полный путь (реальный)
	 * 
	 * @param string - псевдо имя
	 * 
	 * @return string - путь до файла
	 */
    static public function GetRealPath($to)
	{		
		return preg_replace("@^".self::$prefix['name']."@", self::$prefix['path'], $to);
    }

	/**
	 * Разбивает путь на директорию и файл
	 *
	 * @param string $path полный путь до файла
	 * @return array folder и filename
	 *
	 */
	static function ExplodePath($path)
	{
		$dot = strrpos($path, '/');
		if($dot === false)
		{
			$folder = '';
			$fname = $path;
		}
		else
		{
			$folder = substr($path, 0, $dot+1);
			$fname = substr($path, $dot+1);
		}
		return array($folder, $fname);
	}

    /**
     * Проверка имени файла на безопасность для системы
     * 
     * @param string $filename - имя файла
     * @return bool 
     */
    static protected function _securityCheck($filename)
    {
        return preg_match('/[^a-z0-9\\/\\\\_.-]/i', $filename);
    }

    /**
     * Установить ошибку (код и текст)
     * 
     * @param integer $errno - код ошибки или null, чтобы сбросить
     */
    static protected function SetError($errno = 0)
    {
		global $ERROR;

    	if( $errno === 0 )
    	{
    		self::$errno = 0;
    		self::$error = '';
    	}
    	else
    	{
    		self::$errno = $errno;
			
			$args = func_get_args();
			array_shift($args);
    		self::$error = vsprintf($ERROR[$errno], $args);
			//2do: сделать здесь вывод метода, в котором произошла ошибка, а не текущий
			//LibFactory::GetStatic('data');
			//Data::e_backtrace(__METHOD__.':'.self::$error);
			Trace::BackTrace(__METHOD__.':'.self::$error);
		}
    }
    
    /**
     * Вернуть код ошибки
	 *
     * @return integer номер ошибки
     */
    static public function ErrNo()
    {
        return preg_replace('@^'.App::$Config['file_store']['name'].'@', App::$Config['file_store']['path'], $filename);
    }
	
    /**
     * Вернуть текст ошибки
     * 
     * @return string текст ошибки
     */
    static public function Error()
    {
    	return self::$error;
    }
	


	
	
	
	/**
	 * Копирование файла с созданием директорий в случае необходимости
	 * 
	 * @param string $from место источника
	 * @param string $to место назначения
	 * @param bool $replace заменять ли файл
	 * @param bool $recursive рекурсивно ли
	 * 
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception DomainBTException
	 * @exception RuntimeBTException
	 */
	static public function Copy_NEW($from, $to, $replace = false, $recursive = false)
	{
		$from = self::GetRealPath($from);
		$to = self::GetRealPath($to);

		if( !self::FileExists($from) )
			throw new InvalidArgumentBTException('Path "'.$from.'" not found.');

		$dir_to = dirname($to);
		self::CreateDir_NEW($dir_to);
		
		if( self::IsDir($from) )
		{
			if( $recursive === false )
				throw new DomainBTException('Can not copy directory "'.$from.'" without reqursive flag.');

			if( self::IsFile($to) )
				throw new DomainBTException('Can not copy directory "'.$from.'" to file "'.$to.'".');
			
			self::CreateDir_NEW($to);
			self::Chmod_NEW($to, fileperms($from));

			$dir = new DirectoryIterator($from);
			for($dir->rewind(); $dir->valid(); $dir->next())
			{	
				if($dir->isDot())
					continue;
				
				$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
				$it = $dir->getPathname();
				if( self::Copy_NEW($it, $to_path, $replace, $recursive) !== false)
					return false;
			}
			unset($dir);
		}
		else
		{
			if( self::FileExists($to) )
				if ( $replace === false ) {
					throw new DomainBTException('Destination path "'.$to.'" exists. Can not move without replace flag.');
            }

			if ( @copy($from, $to) !== true )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not copy "'.$from.'" to "'.$to.'". '.$err['message']);
			}
			
			self::Chmod_NEW($to, fileperms($from));
		}
		return true;
	}	
	
	/**
	 * Перемещение файла/директоирии
	 * 
	 * @param string $from место источника
	 * @param string $to место назначения
	 * @param bool $replace заменять ли назначение
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception DomainBTException
	 * @exception RuntimeBTException
	 */
	static public function Move_NEW($from, $to, $replace = false)
	{
		$from = self::GetRealPath($from);
		$to = self::GetRealPath($to);

		if( !self::FileExists($from) )
			throw new InvalidArgumentBTException('Path "'.$from.'" not found.');

		$dir_to = dirname($to);
		self::CreateDir_NEW($dir_to);

		if( self::FileExists($to) )
		{
			if ( $replace === false )
				throw new DomainBTException('Destination path "'.$to.'" exists. Can not move without replace flag.');
			
			self::Delete_NEW($to, true);
		}

		if ( @rename($from, $to) !== true )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not rename "'.$from.'" to "'.$to.'". '.$err['message']);
		}
		
		return true;
	}	
	
	/**
	 * Создать директорию
	 * 
	 * @param string - имя директории
	 * @param int - права на директирю
	 * 
	 * @return bool true - dir exists or created, false - otherwise
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 */
	static public function CreateDir_NEW($to, $dir_perm = null)
	{
		$to = self::GetRealPath($to);

		if($to == '')
			throw new InvalidArgumentBTException('Wrong path "'.$to.'" to create dir.');

		if($dir_perm === null)
			$dir_perm = self::$dir_perm;

		if ( self::FileExists($to) )
			return true;

		$um = umask(0777 ^ $dir_perm);

		// создает директорию рекурсивно
		if ( @mkdir($to, 0777, true) !== true )
		{
			umask($um);
			$err = error_get_last();
			throw new RuntimeBTException('Can not create dir "'.$to.'". '.$err['message']);
		}
		umask($um);
		
		return true;
	}
	
	/**
	 * Удалить файл/директорию
	 * 
	 * @param string - имя файла/директории
	 * @param bool - удалять рекурсивно
	 * 
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception DomainBTException
	 * @exception RuntimeBTException
	 */
	static public function Delete_NEW($to, $recursive = false)
	{
		$to = self::GetRealPath($to);
		
		if( !self::FileExists($to) )
			throw new InvalidArgumentBTException('Path "'.$to.'" not found.');
		
		if( self::IsDir($to) )
		{
			$dir = new DirectoryIterator($to);
			for($dir->rewind(); $dir->valid(); $dir->next())
			{
				if($dir->isDot())
					continue;
				
				if($recursive === true)
				{
					$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
					if ( self::IsDir($dir->getPathname()) )
					{
						if( self::Delete_NEW($to_path, $recursive) !== true )
							return false;
					}
					else
                        self::Delete_NEW($to_path);
				}
				else
					throw new DomainBTException('Directory "'.$to.'" not empty. Can not delete without reqursive flag.');
			}
			unset($dir);
						
			if( @rmdir($to) !== true )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not delete "'.$to.'". '.$err['message']);
			}
			
		}
		else
		{	
			if( @unlink($to) !== true )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not delete "'.$to.'". '.$err['message']);
			}			
        }
		return true;
	}
	
	
	/**
	 * Удалить несколько файлов/директорий
	 * 
	 * @param array - имена файлов/директорий
	 * @param bool - удалять рекурсивно
	 * 
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception DomainBTException
	 * @exception RuntimeBTException
	 */
	static public function MultipleDelete($to, $recursive = false)
	{
		if( !is_array($to) )
			throw new InvalidArgumentBTException('$to is not an array');
		
		foreach ( $to as $l )
			self::Delete_NEW($l, $recursive);
	}
	
	/**
	 * Изменить права на файл или директорию
	 * 
	 * @param string - имя файла/директории
	 * @param int - права на директирю
	 * @param bool - рекурсивно
	 * 
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 */
	static public function Chmod_NEW($to, $perm = null, $recursive = false)
	{
		$to = self::GetRealPath($to);
		
		if( !self::FileExists($to) )
			throw new InvalidArgumentBTException('Path "'.$to.'" not found.');

		if( self::IsDir($to) )
			$type = 1;
		else
			$type = 2;

		if($perm === null)
		{
			if($type == 1)
				$perm_c = self::$dir_perm;
			else if($type == 2)
				$perm_c = self::$file_perm;
		}
		else
			$perm_c = $perm;

		$um = umask(0777 ^ $perm_c);		
		if ( @chmod($to, $perm_c) !== true )
		{
			umask($um);
			$err = error_get_last();
			throw new RuntimeBTException('Can not chmod "'.$to.'". '.$err['message']);
		}
		umask($um);
		

		if( $type === 1 && $recursive === true )
		{
			$dir = new DirectoryIterator($to);
			for($dir->rewind(); $dir->valid(); $dir->next())
			{				
				if($dir->isDot())
					continue;

				$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
				if ( self::Chmod_NEW($to_path, $perm, $recursive) !== true )
					return false;
			}
			unset($dir);
		}
		return true;
	}
	
	/**
	 * Возвращает путь для файла от $basedir
	 * 
	 * @param string - имя файла
	 * @param int - глубина директирий
	 * @param int - длина названия каждой директории
	 * 
	 * @return string - путь до файла от базовой директории
	 * @exception InvalidArgumentBTException
	 */
	static public function GetPath_NEW($file_name, $dir_deep = null, $dir_len = null)
	{
		if($dir_deep === null)
			$dir_deep = self::$dir_deep;
		if($dir_len === null)
			$dir_len = self::$dir_len;
		
		// Если нет имени файла - то не работаем
		if(empty($file_name))
			throw new InvalidArgumentBTException('Wrong file name: "'.$file_name.'"');

        // Если имени файла не достаточно - то не работаем
		if(strlen($file_name) <= $dir_deep*$dir_len)
			throw new InvalidArgumentBTException('File name must not be less then "'.($dir_deep*$dir_len).'": "'.$file_name.'"');

        // Если в имени есть элементы пути - то не работаем
        if ( self::_securityCheck($file_name) )
			throw new InvalidArgumentBTException('File name contains insecure symbols: "'.$file_name.'"');

		// создаем иерархию
		$dirs = array();
		$dir_deep_now = 0;
		while($dir_deep_now < $dir_deep)
		{
			$dirs[] = substr($file_name, $dir_deep_now*$dir_len, $dir_len);
			$dir_deep_now++;
		}
		return implode(DIRECTORY_SEPARATOR,  $dirs) . DIRECTORY_SEPARATOR . $file_name;
	}
	
	/**
	 * Возвращает имя файла назначения с корректировкой расширения
	 *
	 * @param string $prefix Префикс, например ItemID чего либо
	 * @param string $file Исходный файл, чтобы узнать тип файла
	 * @param int $types допустимые типы
	 * @param string $test_name пользовательский вариант имени файла
	 * @return string имя файла или false если что-то не верно
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 * @exception InvalidArgumentMyException
	 */
	static public function CreateName_NEW($prefix, $file, $types = null, $test_name = null)
	{
		if ( empty($prefix) )
			throw new InvalidArgumentBTException('Wrong prefix "'.$prefix.'".');

		if ( self::_securityCheck($prefix) )
			throw new InvalidArgumentBTException('File name contains insecure symbols: "'.$prefix.'"');

		$mt = null;
		if ( !self::IsFile($file) )
			throw new InvalidArgumentBTException('File "'.$file.'" not found');

		LibFactory::GetStatic('filemagic');
		list($file_info, $mime_types) = FileMagic::GetFileInfoByType_NEW(self::GetRealPath($file), $types, $test_name);
		if ( !in_array($file_info['mime_type'], $mime_types) )
			throw new InvalidArgumentMyException('Wrong file type: "'.$file.'"', ERR_L_FileStore_WRONG_FILETYPE);

		return $prefix.'_'.time().'.'.$file_info['extension'];
	}
	
	/**
	 * Загрузить файл в хранилище
	 *
	 * @param string $file Имя ключа массива FILES
	 * @param string $dir директория назначения
	 * @param string $prefix префикс Файла назначения
	 * @param int $type Тип загружаемого добра
	 * @param int $max_size Максимальный размер
	 * @param array $params параметры загрузки файла
	 * @param string $index индекс элемента в массиве FILES
	 * @param int $dir_deep глубина директирий
	 * @param int $dir_len  длина названия каждой директории
	 * @return string имя файла
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 * @exception DomainBTException
	 * @exception InvalidArgumentMyException
	 */
	static public function Upload_NEW($file, $dir, $prefix, $type = null, $max_size = null, $params = array(), $index = null, $dir_deep = null, $dir_len = null)
	{
		
		if( !isset($_FILES[$file]) )
			throw new RuntimeBTException('File "'.$file.'" upload error.', ERR_L_FileStore_FILE_UPLOAD_ERROR);
		
		if($index !== null) {
			$src    = $_FILES[$file]['tmp_name'][$index];
			$usr    = $_FILES[$file]['name'][$index];
			$error  = $_FILES[$file]['error'][$index];
		} else {
			$src    = $_FILES[$file]['tmp_name'];
			$usr    = $_FILES[$file]['name'];
			$error  = $_FILES[$file]['error'];
		}
		
		if ( $error !== UPLOAD_ERR_OK )
			throw new RuntimeBTException('File "'.$file.'" upload error.', ERR_L_FileStore_FILE_UPLOAD_ERROR);
		
		if ( empty($src) )
			throw new RuntimeBTException('File path "'.$src.'" is empty.', ERR_L_FileStore_FILE_UPLOAD_ERROR);
		
		if ( !self::IsFile($src) )
			throw new RuntimeBTException('File "'.$src.'" not found.', ERR_L_FileStore_FILE_UPLOAD_ERROR);
		
		$dest_file = self::CreateName_NEW($prefix, $src, $type, $usr);
	
		// Создание пути для файла
		$an = self::GetPath_NEW($dest_file, $dir_deep, $dir_len);
	
		$dest = $dir.$an;
		
		self::Save_NEW($src, $dest, $max_size, $params);

		return $dest_file;
	}
	
	
	/**
	 * Загрузить файл в хранилище с созданием нескольких его копий для различных параметров
	 *
	 * @param string $file Имя ключа массива FILES
	 * @param string $dir директория назначения
	 * @param int $type Тип загружаемого добра
	 * @param int $max_size Максимальный размер
	 * @param array $params параметры загрузки файла
	 * @param string $url адрес, с которого отдаются картинки
	 * @param string $index индекс элемента в массиве FILES
	 * @param int $dir_deep глубина директирий
	 * @param int $dir_len  длина названия каждой директории
	 * @return array массив файлов
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 * @exception DomainBTException
	 * @exception InvalidArgumentMyException
	 */
	static public function MultipleUpload($file, $dir, $type = null, $max_size = null, $params = array(), $url = '', $index = null, $dir_deep = null, $dir_len = null)
	{
		if ( !is_array($params) || count($params) == 0 )
			throw new InvalidArgumentBTException('Upload params is not set.');
		
		$error = false;
		
		// загруженные файлы
		$files = array();
		
		foreach ( $params as $prefix => $_p )
		{
			try
			{
				$files[$prefix] = self::Upload_NEW($file, $dir.$prefix.'/', rand(1000000, 9999999), $type, $max_size, $params, $index, $dir_deep, $dir_len);
			}
			catch ( MyException $e )
			{
				foreach ( $files as &$l )
					$l = $dir.$prefix .'/'. self::GetPath_NEW($l);
				
				self::MultipleDelete($files);
				
				throw new RuntimeBTException('Can\'t delete uploaded files');
			}
		}
		
		return $files;
	}
	
	
	/**
	 * Загрузить файл в хранилище с созданием нескольких его копий для различных параметров
	 * Возвращает массив объектов преобразованных в строку, готовых для сохранения в базу
	 *
	 * @param string $file Имя ключа массива FILES
	 * @param string $dir директория назначения
	 * @param int $type Тип загружаемого добра
	 * @param int $max_size Максимальный размер
	 * @param array $params параметры загрузки файла
	 * @param string $url адрес, с которого отдаются картинки
	 * @param string $index индекс элемента в массиве FILES
	 * @param int $dir_deep глубина директирий
	 * @param int $dir_len  длина названия каждой директории
	 * @return array массив объектов, преобразованных в строку
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 * @exception DomainBTException
	 * @exception InvalidArgumentMyException
	 */
	static public function MultipleUploadObjects($file, $dir, $type = null, $max_size = null, $params = array(), $url = '', $index = null, $dir_deep = null, $dir_len = null)
	{
		$files = self::MultipleUpload($file, $dir, $type, $max_size, $params, $url, $index, $dir_deep, $dir_len);
		$objects = array();
		
		try
		{
			foreach ( $files as $prefix => $l )
			{
				$objects[] = self::ObjectToString( self::PrepareFileToObject(
						self::GetPath_NEW($l),
						$dir.$prefix
					));
			}
		}
		catch ( MyException $e )
		{
			foreach ( $files as &$l )
				$l = $dir.$prefix .'/'. self::GetPath_NEW($l);
			
			self::MultipleDelete($files);
			
			throw new RuntimeBTException('Can\'t prepare uploaded files');
		}
	}
	
	
	
	/**
	 * Заливка файла на сервер
	 * 
	 * @param string $src имя файла источника
	 * @param string $dest имя файла назначения
	 * @param int $max_size максимальный размер в байтах
	 * @param array $params параметры для ресайзинга и защиты
	 * @return bool
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 * @exception DomainBTException
	 */
	static public function Save_NEW($src, $dest, $max_size = null, $params = array())
	{
		$src = self::GetRealPath($src);
		
		$dest = self::GetRealPath($dest);
		
		if( !self::IsFile($src) )
			throw new InvalidArgumentBTException('File "'.$src.'" not found.');
		
		if($max_size != null)
		{	
			$size = @filesize($src);

			if( $size === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine size of file "'.$src.'". '.$err['message']);
			}
echo $max_size.'   '.$size.'    ';
			if($max_size < $size)
				throw new InvalidArgumentMyException('File size "'.$src.'" ('.$size.') more then max size ('.$max_size.')');

		}
		
		list($path, $name) = self::ExplodePath($dest);

        if ( self::_securityCheck($name) )
        	throw new InvalidArgumentBTException('File name contains insecure symbols: "'.$name.'"');

		$tmp_file = null;
		if( isset($params['resize']) || isset($params['security']) || isset($params['crop']) )
		{
			
			$new_src = $src;
			$tmp_file = tempnam(null, __CLASS__);
			if( $tmp_file === false )
				throw new RuntimeBTException('Can not create temp file');

			// вырезаем часть картинки
			if( isset($params['crop']) )
			{
				if( !isset($params['crop']['w']) || !isset($params['crop']['h']) )
					throw new InvalidArgumentBTException('Wrong size params to resize images');

				if( !isset($params['crop']['x']) || !isset($params['crop']['y']) )
					throw new InvalidArgumentBTException('Wrong coords params to resize images');

				LibFactory::GetStatic('images');
				$res = Images::PrepareResize_NEW($new_src,
					6, $params['crop']['w'], $params['crop']['h'], $params['crop']['x'], $params['crop']['y']);
				Images::Resize_NEW($new_src, $tmp_file, $res);
				$new_src = $tmp_file;
			}
			
			// делаем ресайз
			if( isset($params['resize']) )
			{
				if( !isset($params['resize']['w']) || !isset($params['resize']['h']) )
					throw new InvalidArgumentBTException('Wrong size params to resize images');
				LibFactory::GetStatic('images');
				$res = Images::PrepareResize_NEW($new_src,
					isset($params['resize']['tr'])?$params['resize']['tr']:null, $params['resize']['w'], $params['resize']['h']);
				
				// увеличиваем только если принудительное увеличение, в противном случае только уменьшаем
				if( ($res['small'] === true && isset($params['resize']['increase']) && $params['resize']['increase'] === true) || $res['small'] === false )
				{					
					Images::Resize_NEW($new_src, $tmp_file, $res);
					
					$new_src = $tmp_file;
				}
			}
			
			// делаем логотип поверх
			if( isset($params['security']) )
			{
				LibFactory::GetStatic('images');
				try{
					Images::PutSecurityImage_NEW($new_src, $tmp_file,
						isset($params['security']['file'])?$params['security']['file']:null,
						isset($params['security']['position'])?$params['security']['position']:null
					);
					$new_src = $tmp_file;
				}
				catch (BLImagesBTException $e)
				{
					if( $e->getCode() !== Images::ERR_Images_DEFAULT_SECURITY_IMAGE_NOT_FOUND 
					 && $e->getCode() !== Images::ERR_Images_DEFAULT_SECURITY_IMAGE_BIGGER_THEN_SOURCE )
						throw new RuntimeBTException($e->getMessage());
				}
			}
		}
		
		self::Copy_NEW($tmp_file===null ? $src : $new_src, $dest, true);
		if( $tmp_file !== null )
		{	
			if( @unlink($tmp_file) === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not delete file "'.$tmp_file.'". '.$err['message']);
			}
		}
		
		self::Chmod_NEW($dest);
		return true;
	}
    

	/**
	 * Копирование файла с созданием директорий в случае необходимости
	 * 
	 * @param string $from место источника
	 * @param string $to место назначения
	 * @param bool $replace заменять ли файл
	 * @param bool $recursive копировать рекурсивно
	 * @return bool
	 */
	static public function Copy($from, $to, $replace = false, $recursive = false)
	{
		self::SetError();
		
		$from = self::GetRealPath($from);
		$to = self::GetRealPath($to);

		if( !self::FileExists($from) )
		{
			self::SetError(ERR_M_FS_FILE_NOT_FOUND);
			return false;
		}

		$dir_to = dirname($to);
		if(!self::CreateDir($dir_to))
			return false;
		if( self::IsDir($from) )
		{
			if( $recursive === false )
			{
				self::SetError(ERR_M_FS_CANT_COPY_DIR_WO_RECURSIVE, $from);
				return false;
			}

			if( self::IsFile($to) )
			{
				self::SetError(ERR_M_FS_COPY_DIR_TO_FILE, $from, $to);
				return false;
			}
			if( !self::CreateDir($to) )
				return false;
			if( !self::Chmod($to, fileperms($from)) )
				return false;
			$dir = new DirectoryIterator($from);
			$status = true;
			for($dir->rewind(); $dir->valid(); $dir->next())
			{	
				if($dir->isDot())
					continue;
				
				$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
				$it = $dir->getPathname();
				if( self::Copy($it, $to_path, $replace, $recursive) !== true )
					return false;
			}
			unset($dir);
		}
		else
		{
			if( self::FileExists($to) )
				if ( $replace === false ) {
				{
					self::SetError(ERR_M_FS_DESTINATION_PATH_EXISTS, $to);
					return false;
				}
            }
            
			if ( copy($from, $to) !== true )
			{
				self::SetError(ERR_M_FS_FILE_CANT_COPY, $from, $to);
				return false;
			}
			if ( self::Chmod($to, fileperms($from)) !== true )
				return false;
		}
		
		return true;
	}	
	
	/**
	 * Перемещение файла/директоирии
	 * 
	 * @param string $from место источника
	 * @param string $to место назначения
	 * @param bool $replace заменять ли назначение
	 * @return bool
	 */
	static public function Move($from, $to, $replace = false)
	{
		self::SetError();

		$from = self::GetRealPath($from);
		$to = self::GetRealPath($to);

		if( !self::FileExists($from) )
		{
			self::SetError(ERR_M_FS_FILE_NOT_FOUND);
			return false;
		}

		$dir_to = dirname($to);
		if ( !self::CreateDir($dir_to) )
			return false;

		if( self::FileExists($to) )
		{
			if ( $replace === false )
			{
				self::SetError(ERR_M_FS_DESTINATION_PATH_EXISTS, $to);
				return false;
			}
			
			if( self::Delete($to, true) !== true )
				return false;
		}

		if ( rename($from, $to) !== true )
		{
			self::SetError(ERR_M_FS_FILE_CANT_MOVE, $from, $to);
			return false;
		}
		
		return true;
	}	
	
	/**
	 * Создать директорию
	 * 
	 * @param string - имя директории
	 * @param int - права на директирю
	 * 
	 * @return bool true - dir exists or created, false - otherwise
	 */
	static public function CreateDir($to, $dir_perm = null)
	{
		self::SetError();

		$to = self::GetRealPath($to);

		if($to == '')
			return false;

		if($dir_perm === null)
			$dir_perm = self::$dir_perm;

		if ( self::FileExists($to) )
			return true;

		$um = umask(0777 ^ $dir_perm);

		// создает директорию рекурсивно
		if ( mkdir($to, 0777, true) !== true )
		{
			umask($um);
			self::SetError(ERR_M_FS_CANT_CREATE_DIR, $to);
			return false;
		}
		umask($um);
		
		return true;
	}
	
	/**
	 * Удалить файл/директорию
	 * 
	 * @param string - имя файла/директории
	 * @param bool - удалять рекурсивно
	 * 
	 * @return bool
	 */
	static public function Delete($to, $recursive = false)
	{
		self::SetError();

		$to = self::GetRealPath($to);
		
		if( !self::FileExists($to) )
		{
			self::SetError(ERR_M_FS_FILE_NOT_FOUND);
			return false;
		}
		
		if( self::IsDir($to) )
		{
			$dir = new DirectoryIterator($to);
			for($dir->rewind(); $dir->valid(); $dir->next())
			{
				if($dir->isDot())
					continue;
				
				if($recursive === true)
				{
					$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
					if ( self::IsDir($dir->getPathname()) )
					{
						if( self::Delete($to_path, $recursive) !== true )
							return false;
					}
					else
                        self::Delete($to_path);
				}
				else
				{
					self::SetError(ERR_M_FS_DIRECTORY_NO_EMPTY, $to);
					return false;
				}
			}
			unset($dir);
		}
		else
		{
			if( unlink($to) !== true )
			{
				self::SetError(ERR_M_FS_CANT_DELETE, $to);
				return false;
			}
        }
		return true;
	}
	
	/**
	 * Изменить права на файл или директорию
	 * 
	 * @param string - имя файла/директории
	 * @param int - права на директирю
	 * @param bool - рекурсивно
	 * 
	 * @return bool
	 */
	static public function Chmod($to, $perm = null, $recursive = false)
	{
		self::SetError();

		$to = self::GetRealPath($to);
		
		if( !self::FileExists($to) )
		{
			self::SetError(ERR_M_FS_FILE_NOT_FOUND);
			return false;
		}
		

		if( self::IsDir($to) )
			$type = 1;
		else
			$type = 2;

		if($perm === null)
		{
			if($type == 1)
				$perm_c = self::$dir_perm;
			else if($type == 2)
				$perm_c = self::$file_perm;
		}
		else
			$perm_c = $perm;

		$um = umask(0777 ^ $perm_c);	
		if ( chmod($to, $perm_c) !== true )
		{
			umask($um);
			self::SetError(ERR_M_FS_FILE_CANT_CHMOD, $to);
			return false;
		}
		umask($um);

		if( $type === 1 && $recursive === true )
		{
			$dir = new DirectoryIterator($to);
			for($dir->rewind(); $dir->valid(); $dir->next())
			{	
				if($dir->isDot())
					continue;

				$to_path = $to.(substr($to, -1, 1)==DIRECTORY_SEPARATOR?"":DIRECTORY_SEPARATOR) .$dir->getFilename();
				if ( self::Chmod($to_path, $perm, $recursive) !== true )
					return false;
			}
			unset($dir);
		}

		return true;
	}

	/**
	 * Возвращает путь для файла от $basedir
	 * 
	 * @param string - имя файла
	 * @param int - глубина директирий
	 * @param int - длина названия каждой директории
	 * 
	 * @return string - путь до файла от базовой директории
	 */
	static public function GetPath($file_name, $dir_deep = null, $dir_len = null)
	{
		self::SetError();

		if($dir_deep === null)
			$dir_deep = self::$dir_deep;
		if($dir_len === null)
			$dir_len = self::$dir_len;
		
		// Если нет имени файла - то не работаем
		if(empty($file_name))
		{
			// временно закрываю.
			//self::SetError(ERR_M_FS_WRONG_PATH, $file_name);
			return '';
		}

        // Если имени файла не достаточно - то не работаем
		if(strlen($file_name) <= $dir_deep*$dir_len)
				{
			// временно закрываю.
			//self::SetError(ERR_M_FS_FILENAME_TO_SMALL, $file_name);
			return '';
		}

        // Если в имени есть элементы пути - то не работаем
        if ( self::_securityCheck($file_name) )
		{
			self::SetError(ERR_M_FS_FILENAME_INSECURE, $file_name);
        	return '';
        }

		// создаем иерархию
		$dirs = array();
		$dir_deep_now = 0;
		while($dir_deep_now < $dir_deep)
		{
			$dirs[] = substr($file_name, $dir_deep_now*$dir_len, $dir_len);
			$dir_deep_now++;
		}
		
		return implode(DIRECTORY_SEPARATOR,  $dirs) . DIRECTORY_SEPARATOR . $file_name;
	}

	/**
	 * Возвращает имя файла назначения с корректировкой расширения
	 *
	 * @param string $prefix Префикс, например ItemID чего либо
	 * @param string $file Исходный файл, чтобы узнать тип файла
	 * @param int $types допустимые типы
	 * @param string $test_name пользовательский вариант имени файла
	 * @return string имя файла или false если что-то не верно
	 *
	 */
    static public function CreateName($prefix, $file, $types = null, $test_name = null)
	{
		self::SetError();
		
		if ( empty($prefix) )
		{
			self::SetError(ERR_M_FS_WRONG_PATH, $prefix);
			return false;
		}

		if ( self::_securityCheck($prefix) )
		{
			self::SetError(ERR_M_FS_FILENAME_INSECURE, $prefix);
			return false;
		}

        $mt = null;
		if ( !self::IsFile($file) )
		{
			self::SetError(ERR_M_FS_FILE_NOT_FOUND, $file);
			return false;
		}

        LibFactory::GetStatic('filemagic');
		if ( null == ($mt = FileMagic::GetFileInfoByType($file, $types, $test_name)) )
		{
			self::SetError(ERR_M_FS_UNKNOWN_FILETYPE, $file);
			return false;
		}
		
		list($mt, $types) = $mt;
		if ( !in_array($mt['mime_type'], $types) )
		{
			self::SetError(ERR_M_FS_WRONG_FILETYPE, $file);
			return false;
		}
        
		return $prefix.'_'.time().'.'.$mt['extension'];
    }

	/**
	 * Загрузить файл в хранилище
	 *
	 * @param string $file Имя ключа массива FILES
	 * @param string $dir директория назначения
	 * @param string $prefix префикс Файла назначения
	 * @param int $type Тип загружаемого добра
	 * @param int $max_size Максимальный размер
	 * @param array $params параметры загрузки файла
	 * @param string $index индекс элемента в массиве FILES
	 * @param int $dir_deep глубина директирий
	 * @param int $dir_len  длина названия каждой директории
	 * @return int ошибка
	 *
	 */
    static public function Upload($file, $dir, $prefix, $type = null, $max_size = null, $params = array(), $index = null, $dir_deep = null, $dir_len = null)
	{
		self::SetError();
		
		$result = array(
			0,
			'',
		);
		
		if( !isset($_FILES[$file]) )
		{
			$result[0] = ERR_M_FS_FILE_UPLOAD_ERROR;
			return $result;
		}
		
		if($index !== null) {			
			$src    = $_FILES[$file]['tmp_name'][$index];
			$usr    = $_FILES[$file]['name'][$index];
			$error  = $_FILES[$file]['error'][$index];
        } else {
			$src    = $_FILES[$file]['tmp_name'];
			$usr    = $_FILES[$file]['name'];
            $error  = $_FILES[$file]['error'];
        }

        if ( $error !== UPLOAD_ERR_OK )
		{
			$result[0] = ERR_M_FS_FILE_UPLOAD_ERROR;
			return $result;
		}

        if ( empty($src) )
		{
			$result[0] = ERR_M_FS_FILE_NOT_FOUND;
			return $result;
		}
            
        if ( !self::IsFile($src) )
		{
			$result[0] = ERR_M_FS_FILE_NOT_FOUND;
			return $result;
		}
            
		$dest_file = self::CreateName($prefix, $src, $type, $usr);
					
		if ( $dest_file === false )
		{
			$result[0] = ERR_M_FS_FILE_UPLOAD_TYPE_WRONG;
			return $result;
		}
					
		// Создание пути для файла
		$an = self::GetPath($dest_file, $dir_deep, $dir_len);
		if( empty($an))
		{
			$result[0] = ERR_M_FS_INTERNAL_ERROR;
			return $result;
		}
						
		$dest = $dir.$an;
							
		$result[0] = self::Save($src, $dest, $max_size, $params);
		
		if( $result[0] === 0 )
			$result[1] = $dest_file;
		return $result;
    }

	/**
	 * Сохранение файла на сервере
	 * 
	 * @param string $src имя файла источника
	 * @param string $dest имя файла назначения
	 * @param int $max_size максимальный размер в байтах
	 * @param array $params параметры для ресайзинга и защиты
	 * @return int error
	 */
	static public function Save($src, $dest, $max_size = null, $params = array())
	{
		self::SetError();
		
		$src = self::GetRealPath($src);
		$dest = self::GetRealPath($dest);
		
		if( !self::IsFile($src) )
			return ERR_M_FS_FILE_NOT_FOUND;
		
		if($max_size != null)
		{
			$size = filesize($src);
			if($max_size < $size)
				return ERR_M_FS_FILE_SIZE_TO_BIG;
		}
		list(, $name) = self::ExplodePath($dest);

        if ( self::_securityCheck($name) )
            return ERR_M_FS_INTERNAL_ERROR;

		$tmp_file = null;
		if( isset($params['resize']) || isset($params['security']) || isset($params['crop']) )
		{
			$new_src = $src;
			$tmp_file = tempnam(null, __METHOD__);
			if( $tmp_file === false )
				return ERR_M_FS_FILE_CANT_CREATE_TF;
			
			// вырезаем часть картинки
			if( isset($params['crop']) ) 
			{
				
				if( !isset($params['crop']['w']) || !isset($params['crop']['h']) )
					return ERR_M_FS_WRONG_RESIZE_PARAMS;

				if( !isset($params['crop']['x']) || !isset($params['crop']['y']) )
					return ERR_M_FS_WRONG_COORDS_PARAMS;
					
				LibFactory::GetStatic('images');
				$res = Images::PrepareResize($new_src,
					6, $params['crop']['w'], $params['crop']['h'], $params['crop']['x'], $params['crop']['y']);
					
				if( !is_array($res) )
                    return $res;
					
				$res = Images::Resize($new_src, $tmp_file, $res);
				if( $res !== 0 )
					return $res;
				$new_src = $tmp_file;
			}
			
			// делаем ресайз
			if( isset($params['resize']) )
			{
				if( !isset($params['resize']['w']) || !isset($params['resize']['h']) )
					return ERR_M_FS_WRONG_RESIZE_PARAMS;
				LibFactory::GetStatic('images');
				$res = Images::PrepareResize($new_src, isset($params['resize']['tr'])?$params['resize']['tr']:null, $params['resize']['w'], $params['resize']['h'], 0, 0);
				if( !is_array($res) )
				{
					//self::$_error[101] = Images::Error($res);
                    return $res;
					//return ERR_M_FS_INTERNAL_ERROR;
				}
				
				// увеличиваем только если принудительное увеличение, в противном случае только уменьшаем
				if( ($res['small'] === true && isset($params['resize']['increase']) && $params['resize']['increase'] === true) || $res['small'] === false || $res['crop'] === true)
				{
					$res = Images::Resize($new_src, $tmp_file, $res);
					if( $res !== 0 )
                        return $res;
					$new_src = $tmp_file;
				}
			}

			// делаем ресайз
			if( isset($params['security']) )
			{
				LibFactory::GetStatic('images');
				$res = Images::PutSecurityImage($new_src, $tmp_file,
					isset($params['security']['file'])?$params['security']['file']:null,
					isset($params['security']['position'])?$params['security']['position']:null
				);
				if( $res !== ERR_M_IMAGES_DEFAULT_SECURITY_IMAGE_NOT_FOUND )
				{
					if( $res !== 0 )
	                    return $res;
						
					$new_src = $tmp_file;
				}
			}
		}

		$result = self::Copy($tmp_file===null ? $src : $new_src, $dest, true);
		
		if( $result == false ) {				
			return 73214;//ERR_M_FS_FILE_CANT_COPY;
		}
		if( $tmp_file !== null )
			if( self::Delete($tmp_file) !== true )
				return 73214;

		if( !self::Chmod($dest) )
			return ERR_M_FS_FILE_CANT_CHMOD;
		return 0;
	}
	
	/**
	 * Возвращает размер файла в байтах
	 * 
	 * @param string - имя файла
	 * 
	 * @return int - размер файла в байтах
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 */    
	static public function GetFilesize($name)
	{
		$name = self::GetRealPath($name);
		
			if( !self::IsFile($name) )
			throw new InvalidArgumentBTException('File "'.$name.'" not found.');
		
		$size = @filesize($name);
		if( $size === false )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not determine size of file "'.$name.'". '.$err['message']);
		}
		
		return $size;
	}
}

FileStore::Init();

?>
