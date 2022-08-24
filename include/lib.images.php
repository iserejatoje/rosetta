<?

// {{{ Images Errors
static $images_error_code = 0;
define('ERR_M_IMAGES_MASK', 0x00012000);


define('ERR_M_IMAGES_FILE_NOT_FOUND', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_FILE_NOT_FOUND] = 'Файл не найден.';

define('ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT] = 'Не допустимый формат файла.';

define('ERR_M_IMAGES_PLEASE_SPECIFY_A_SOURCE_FILE_NAME', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_PLEASE_SPECIFY_A_SOURCE_FILE_NAME] = 'Необходимо указать исходный файл.';

define('ERR_M_IMAGES_PLEASE_SPECIFY_A_DESCTINATION_FILE_NAME', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_PLEASE_SPECIFY_A_DESCTINATION_FILE_NAME] = 'Необходимо укзать новый файл.';

define('ERR_M_IMAGES_CREATE_CANVAS_FAIL', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_CREATE_CANVAS_FAIL] = 'Не удалось создать шаблон.';

define('ERR_M_IMAGES_READ_IMAGE_FAIL', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_READ_IMAGE_FAIL] = 'Не удалось прочитать изображение.';

define('ERR_M_IMAGES_UNEXPECTED_IMAGE_FORMAT', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_UNEXPECTED_IMAGE_FORMAT] = 'Не известный формат изображение.';

define('ERR_M_IMAGES_RESAMPLE_ERROR', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_RESAMPLE_ERROR] = 'Не удалось преобразовать изображение.';

define('ERR_M_IMAGES_PUT_WATERMARK_ERROR', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_PUT_WATERMARK_ERROR] = 'Не удалось разместить логотип.';

define('ERR_M_IMAGES_CROP_ERROR', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_CROP_ERROR] = 'Не удалось вырезать изображение.';

define('ERR_M_IMAGES_DEFAULT_SECURITY_IMAGE_NOT_FOUND', ERR_M_IMAGES_MASK | $images_error_code++);
$ERROR[ERR_M_IMAGES_DEFAULT_SECURITY_IMAGE_NOT_FOUND] = 'Не найден логотип по-умолчанию.';

// }}}

class Images
{
	const ERR_Images_DEFAULT_SECURITY_IMAGE_NOT_FOUND			= 1;
	const ERR_Images_DEFAULT_SECURITY_IMAGE_BIGGER_THEN_SOURCE	= 2;
	
	const CDN_PREFIX					= '';
	const CDN_PREFIX_LEN				= 5;
	const CDN_CHAR_COUNT				= 10;

	static private $_security_border	= array(
		'x' => 10,
		'y' => 10,
		);
	
	static private $work_memory_limit	= '128M';
	
	static private $cur_memory_limit	= '';

	static private $is_log = false;
	static private $log_file = '/tmp/images.log';

	static public function Init()
	{
	}

	/**
	 * Подготовка данных для файла
	 *
	 * @param string $file имя файла
	 * @param string $dir путь до файла
	 * @param string $url url до файла
	 * @return array (path, url, w, h, size, mime)
	 */
	static public function PrepareImage($file, $dir = "", $url = "")
	{
		$img = array();
		LibFactory::GetStatic('filestore');
        $hm = $dir.$file;
        $hm = FileStore::GetRealPath($hm);

		if( FileStore::IsFile($hm) )
		{
			$img = array(
					"path"  => $dir.$file,
					"url"   => $url.$file,
					"w"     => $inf[0],
					"h"     => $inf[1],
					"size"  => @filesize($hm),
					"mime"  => $inf['mime'],
					);
		}
		return $img;
	}
	
	/**
	 * Подготовка параметров для ресайза
	 *
	 * @param string $src_file путь к файлу
	 * @param int $tr способ преобразования (0 - пропорционально, 1 - по ширине, 2 - по высоте, 3 - с отрезанием части картинки (центр), 4 - с отрезанием части картинки (лево/верх), 5 - с отрезанием части картинки (право/низ))
	 * @param int $w необходимая ширина
	 * @param int $h необходимая высота
	 * @param int $x смещение по X
	 * @param int $y смещение по Y
	 * @return array (x1, y1, w1, h1, w2, h2, tr, small) | errno
	 */
	static public function PrepareResize($src_file, $tr = 0, $w, $h, $x = 0, $y = 0)
	{
		if($src_file !== null)
		{	
			if(is_file($src_file))
			{
				if(!($info = @getimagesize($src_file)))
					return ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT;
			}
			else
				return ERR_M_IMAGES_FILE_NOT_FOUND;
		}
		else
			return ERR_M_IMAGES_PLEASE_SPECIFY_A_SOURCE_FILE_NAME;
		
		$list = array(
				'x1' => ($tr == 6) ? $x : 0,
				'y1' => ($tr == 6) ? $y : 0,
				'w1' => $info[0],
				'h1' => $info[1],
				'w2' => null,
				'h2' => null,
				'tr' => $tr,
				'small' => false,
				);
		
		$src_ratio = $info[0]/$info[1];
		$new_w = $w;
		$new_h = $h;
		$ratio = $w/$h;
		if($tr == 0)
		{
			if($ratio < $src_ratio)
				$new_h = $new_w/$src_ratio;
			else
				$new_w = $new_h*$src_ratio;
		}
		else if($tr == 1)
			$new_h = $new_w/$src_ratio;
		else if($tr == 2)
			$new_w = $new_h/$src_ratio;
		else if($tr == 3)
		{
			if($ratio > $src_ratio)
			{
				$list['h1'] = round($info[0]/$ratio);
				$list['y1'] = round(($info[1] - $list['h1'])/2);
			}
			else
			{
				$list['w1'] = round($info[1]*$ratio);
				$list['x1'] = round(($info[0] - $list['w1'])/2);
			}
		}
		else if($tr == 4)
		{
			if($ratio > $src_ratio)
				$list['h1'] = round($info[0]/$ratio);
			else
				$list['w1'] = round($info[1]*$ratio);
		}
		else if($tr == 5)
		{
			if($ratio > $src_ratio)
			{
				$list['h1'] = round($info[0]/$ratio);
				$list['y1'] = $info[1] - $list['h1'];
			}
			else
			{
				$list['w1'] = round($info[1]*$ratio);
				$list['x1'] = $info[0] - $list['w1'];
			}
		}
		else if($tr == 6) {
			if ( $info[0] < $list['x1']+$w || $info[1] < $list['y1']+$h )
				return ERR_M_IMAGES_CROP_ERROR;
				
			$list['w1'] = round($new_w);
			$list['h1'] = round($new_h);
		}
		
		$list['w2'] = round($new_w);
		$list['h2'] = round($new_h);
		
		if( $info[0] <= $w && $info[1] <= $h )
		{
			$list['small'] = true;
			return $list;
		}
		
		return $list;
	}
	
	/**
	 * Заливка изображения с изменением размеров
	 *
	 * @param string $src_file путь к файлу
	 * @param string $dest_file имя файла назначения (если null - отдать в return)
	 * @param array $params ассоциативный массив размеров (x1, y1, w1, h1, w2, h2)
	 * @param int $type формат картинки в итоге (если null - то как у исходной)
	 */
	static public function Resize($src_file = null, $dest_file = null, $params = null, $type = null)
	{
		if($src_file !== null)
		{
			if(is_file($src_file))
			{
				if(!($info = @getimagesize($src_file)))
					return ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT;
			}
			else
				return ERR_M_IMAGES_FILE_NOT_FOUND;
		}
		else
			return ERR_M_IMAGES_PLEASE_SPECIFY_A_SOURCE_FILE_NAME;
		
		if($dest_file === null)
			return ERR_M_IMAGES_PLEASE_SPECIFY_A_DESCTINATION_FILE_NAME;
		
		self::SetMemoryLimit();
		$dest_img = imagecreatetruecolor($params['w2'], $params['h2']);
		if(!$dest_img)
		{
			self::ReturnMemoryLimit();
			return ERR_M_IMAGES_CREATE_CANVAS_FAIL;
		}
		imageAntiAlias($dest_img, true);
		
		switch($info[2])
		{
			case 1: $src_img = imagecreatefromgif($src_file);	break;
			case 2: $src_img = imagecreatefromjpeg($src_file);	break;
			case 3: $src_img = imagecreatefrompng($src_file); 	break;
			default: self::ReturnMemoryLimit(); return ERR_M_IMAGES_UNEXPECTED_IMAGE_FORMAT;
		}
		if(!$src_img)
		{
			self::ReturnMemoryLimit();
			return ERR_M_IMAGES_READ_IMAGE_FAIL;
		}
		
		if( imagecopyresampled($dest_img, $src_img, 0, 0, $params['x1'], $params['y1'], $params['w2'], $params['h2'], $params['w1'], $params['h1']) === false )
		{
			self::ReturnMemoryLimit();
			return ERR_M_IMAGES_RESAMPLE_ERROR;
		}
		
		if($type === null)
			$type = $info[2];
		if( !(imagetypes() & $type) )
			$type = $info[2];
		
		switch($type)
		{
			case 1: imagegif($dest_img, $dest_file); break;
			case 2: imagejpeg($dest_img, $dest_file); break;
			case 3: imagepng($dest_img, $dest_file); break;
		}
		
		imagedestroy($dest_img);
		imagedestroy($src_img);
		
		self::ReturnMemoryLimit();
		
		return 0;
	}
	
	/**
	 * Наложение защитной картинки на изображение
	 *
	 * @param string $src_file путь к файлу
	 * @param string $dest_file путь к файлу назначения
	 * @param string $sec_file имя файла, с логотипом
	 * @param string код места положения
	 */
	static public function PutSecurityImage($src_file, $dest_file = null, $sec_file = null, $position = null)
	{
		if( $sec_file === null )
		{
			$sec_file = self::GetDefaultSecurityImage();
			if( $sec_file == '' )
				return ERR_M_IMAGES_DEFAULT_SECURITY_IMAGE_NOT_FOUND;
		}
        
		if( !is_file($src_file) )
			return ERR_M_IMAGES_FILE_NOT_FOUND;
					
		if( !is_file($sec_file) )
			return ERR_M_IMAGES_FILE_NOT_FOUND;

		if( $dest_file === null )
			$dest_file = $src_file;
		
		if($position === null)
			$position = 'br';
        
		if(!($info_src = @getimagesize($src_file)))
			return ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT;
		
		if(!($info_sec = @getimagesize($sec_file)))
			return ERR_M_IMAGES_INCOMPATIBLE_FILE_FORMAT;
		
		$src_x = $info_src[0];
		$src_y = $info_src[1];
		$sec_x = $info_sec[0];
		$sec_y = $info_sec[1];
		
		if($src_x - self::$_security_border['x']*2 < $sec_x
				|| $src_y - self::$_security_border['y']*2 < $sec_y
			)
			return 0;
		
		// X зависит от lcr - left, center, right
		if( strpos($position, 'l') !== false )
			$x = self::$_security_border['x'];
		else if( strpos($position, 'c') !== false )
			$x = ceil($src_x/2 - $sec_x/2);
		else if( strpos($position, 'r') !== false )
			$x = $src_x - $sec_x - self::$_security_border['x'];
		else
			$x = self::$_security_border['x'];
		
		// Y зависит от tmb - top, middle, bottom
		if( strpos($position, 't') !== false )
			$y = self::$_security_border['y'];
		else if( strpos($position, 'm') !== false )
			$y = ceil($src_y/2 - $sec_y/2);
		else if( strpos($position, 'b') !== false )
			$y = $src_y - $sec_y - self::$_security_border['y'];
		else
			$y = self::$_security_border['y'];
		
		self::SetMemoryLimit();
		switch($info_src[2])
		{
			case 1: $src_img = imagecreatefromgif($src_file);	break;
			case 2: $src_img = imagecreatefromjpeg($src_file);	break;
			case 3:  $src_img = imagecreatefrompng($src_file); 	break;
			default: self::ReturnMemoryLimit(); return ERR_M_IMAGES_UNEXPECTED_IMAGE_FORMAT;
		}
		if(!$src_img)
			return ERR_M_IMAGES_READ_IMAGE_FAIL;
		
		switch($info_sec[2])
		{
			case 1: $sec_img = imagecreatefromgif($sec_file);	break;
			case 2: $sec_img = imagecreatefromjpeg($sec_file);	break;
			case 3: $sec_img = imagecreatefrompng($sec_file); 	break;
			default: self::ReturnMemoryLimit(); return ERR_M_IMAGES_UNEXPECTED_IMAGE_FORMAT;
		}
		if(!$sec_img)
		{
			self::ReturnMemoryLimit();
			return ERR_M_IMAGES_READ_IMAGE_FAIL;
		}
		
		if(imagecopy($src_img, $sec_img, $x, $y, 0, 0, $sec_x, $sec_y)=== false)
		{
			self::ReturnMemoryLimit();
			return ERR_M_IMAGES_PUT_WATERMARK_ERROR;
		}
		
		switch($info_src[2])
		{
			case 1: imagegif($src_img, $dest_file);	break;
			case 2: imagejpeg($src_img, $dest_file, 80);	break;
			case 3: imagepng($src_img, $dest_file, 80); 	break;
		}
		imagedestroy($src_img);
		imagedestroy($sec_img);
		
		self::ReturnMemoryLimit();
		
		return 0;
	}
	
	
	/**
	 * Установить лимит памяти
	 *
	 * @param string $limit лимит
	 * @return string old value
	 *
	 */
	static private function SetMemoryLimit($limit = null)
	{
		if( $limit === null )
			$limit = self::$work_memory_limit;
		if($limit == '')
			return false;
		self::$cur_memory_limit = ini_set('memory_limit', self::$work_memory_limit);
		return self::$cur_memory_limit;
	}
	
	/**
	 * Вернуть лимит памяти
	 *
	 * @return string old value
	 *
	 */
	static private function ReturnMemoryLimit()
	{
		if(self::$cur_memory_limit == '')
			return false;
		return ini_set('memory_limit', self::$cur_memory_limit);
	}
	
	/**
	 * Вернуть дефолтный логотип
	 *
	 * @return string имя файла дефолтного логотипа
	 *
	 */
	static private function GetDefaultSecurityImage()
	{
		global $CONFIG, $DCONFIG;
		
		$path = ENGINE_PATH.'resources/img/themes/logos/transparent/%s.png';
		
		$domain = $CONFIG['env']['site']['domain'];
		if( isset($DCONFIG['SECTION_ID']) )
		{
			$n = STreeMgr::GetNodeByID($DCONFIG['SECTION_ID']);
			if ( $n !== null && $n->ParentID != 0 ) 
				$domain = 'takemix.ru';//$n->Parent->Name;
		}
			
		$file = sprintf($path, $domain);

		if( is_file($file) )
			return $file;
		else
			return '';
	}
	
	/**
	 * Подготовка данных для файла
	 *
	 * @param string $file имя файла
	 * @param string $dir путь до файла
	 * @param string $url url до файла
	 * @return array (path, url, w, h, size, mime)
	 */
	static public function PrepareImage_NEW($file, $dir = "", $url = "")
	{
		LibFactory::GetStatic('filestore');
		
		
		$img = array();
		try
		{
			$hm = FileStore::GetRealPath($dir.$file);
			if( !is_file($hm) )
				throw new RuntimeBTException('File "'.$hm.'" not found when prepare images called');
		
			$inf = @getimagesize($hm);
			if( $inf === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine image params of file "'.$hm.'": '.$err['message']);
			}

			$size = @filesize($hm);
			if( $size === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine size of file "'.$hm."\t".$from.'": '.$err['message']);
			}
		}
		catch (BTException $e)
		{
			return $img;
		}
				
		// преобразуем $url для распределения нагрузки
		/*if(false && strpos($url, 'http://mediacontent.rugion.ru/') === 0 )
		{
			// удалим из имени файла все кроме цифр и букв
			$txt = substr(preg_replace('@[^\da-z]@i', '', $file), 0, 2);
			$new_url = 'img.rugion.ru';
			if( $txt !== '' )
				$new_url = 'http://'.$txt.'.'.$new_url.'/';
			$url = preg_replace('@http\://mediacontent\.rugion\.ru/@', $new_url, $url);
			unset($new_url);
		}*/
		
		return array(
				"path"  => $dir.$file,
				"url"   => $url.$file,
				"w"     => $inf[0],
				"h"     => $inf[1],
				"size"  => $size,
				"mime"  => $inf['mime'],
				);
	}
	
	/**
	 * Подготовка данных для файла из объекта файла
	 *
	 * @param string $file имя файла
	 * @param string $dir путь до файла
	 * @return array (file, w, h, size, mime)
	 */
	static public function PrepareImageToObject($file, $dir = "")
	{
		LibFactory::GetStatic('filestore');
		
		$img = array();
		try
		{
			$hm = FileStore::GetRealPath($dir.$file);
			if( !is_file($hm) )
				throw new RuntimeBTException('File "'.$hm.'" not found when prepare images called');

			$inf = @getimagesize($hm);
			if( $inf === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine image params of file "'.$hm.'": '.$err['message']);
			}

			$size = @filesize($hm);
			if( $size === false )
			{
				$err = error_get_last();
				throw new RuntimeBTException('Can not determine size of file "'.$hm.'": '.$err['message']);
			}
		}
		catch (BTException $e)
		{
			return $img;
		}
		
		return array(
				"file"  => basename($file),
				"w"     => $inf[0],
				"h"     => $inf[1],
				"size"  => $size,
				"mime"  => $inf['mime'],
				);
	}
	
	/**
	 * Подготовка данных для файла из объекта файла
	 *
	 * @param array $object объект файла (file, w, h, size, mime)
	 * @param string $dir путь до файла
	 * @param string $url url до файла
	 * @return array (path, url, w, h, size, mime)
	 */
	static public function PrepareImageFromObject($object, $dir = "", $url = "")
	{
		LibFactory::GetStatic('filestore');
		
		$img = array();
		$dir = FileStore::GetRealPath($dir);
				
		return array(
				"path"  => $dir.$object['file'],
				"url"   => $url.$object['file'],
				"w"     => $object['w'],
				"h"     => $object['h'],
				"size"  => $object['size'],
				"mime"  => $object['mime'],
				);
	}
	
	
	
	/**
	 * Загрузить картинку в хранилище с созданием нескольких ее копий для различных параметров
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
	static public function MultipleUploadImages($file, $dir, $type = null, $max_size = null, $params = array(), $url = '', $index = null, $dir_deep = null, $dir_len = null)
	{
		LibFactory::GetStatic('filestore');
		
		$files = FileStore::MultipleUpload($file, $dir, $type, $max_size, $params, $url, $index, $dir_deep, $dir_len);
		$objects = array();
		
		try
		{
			foreach ( $files as $prefix => $l )
			{
				$objects[] = FileStore::ObjectToString( self::PrepareImageToObject(
						FileStore::GetPath_NEW($l),
						$dir.$prefix
					));
			}
		}
		catch ( MyException $e )
		{
			foreach ( $files as &$l )
				$l = $dir.$prefix .'/'. FileStore::GetPath_NEW($l);
			
			FileStore::MultipleDelete($files);
			
			throw new RuntimeBTException('Can\'t prepare uploaded images');
		}
	}
	
	
	/**
	 * Подготовка параметров для ресайза
	 *
	 * @param string $src_file путь к файлу
	 * @param int $tr способ преобразования (0 - пропорционально, 1 - по ширине, 2 - по высоте, 3 - с отрезанием части картинки (центр), 4 - с отрезанием части картинки (лево/верх), 5 - с отрезанием части картинки (право/низ), 6 - вырезание из указанного места)
	 * @param int $w необходимая ширина
	 * @param int $h необходимая высота
	 * @param int $x смещение по X
	 * @param int $y смещение по Y
	 * @return array (x1, y1, w1, h1, w2, h2, tr, small)
	 * @exception RuntimeBTException
	 * @exception InvalidArgumentBTException
	 */
	static public function PrepareResize_NEW($src_file, $tr = 0, $w = null, $h = null, $x = 0, $y = 0)
	{
		if( !is_file($src_file) )
			throw new InvalidArgumentBTException('File "'.$src_file.'" not found.');

		$info = @getimagesize($src_file);
		if( $info === false )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not determine image params of file "'.$src_file.'". '.$err['message']);
		}
		
		$list = array(
				'x1' => ($tr == 6) ? $x : 0,
				'y1' => ($tr == 6) ? $y : 0,
				'w1' => $info[0],
				'h1' => $info[1],
				'w2' => null,
				'h2' => null,
				'tr' => $tr,
				'small' => false,
				);
		
		$src_ratio = $info[0]/$info[1];
		$new_w = $w;
		$new_h = $h;
		$ratio = $w/$h;
		if($tr == 0)
		{
			if($ratio < $src_ratio)
				$new_h = $new_w/$src_ratio;
			else
				$new_w = $new_h*$src_ratio;
		}
		elseif($tr == 1)
			$new_h = $new_w/$src_ratio;
		elseif($tr == 2)
			$new_w = $new_h/$src_ratio;
		elseif($tr == 3)
		{
			if($ratio > $src_ratio)
			{
				$list['h1'] = round($info[0]/$ratio);
				$list['y1'] = round(($info[1] - $list['h1'])/2);
			}
			else
			{
				$list['w1'] = round($info[1]*$ratio);
				$list['x1'] = round(($info[0] - $list['w1'])/2);
			}
		}
		elseif($tr == 4)
		{
			if($ratio > $src_ratio)
				$list['h1'] = round($info[0]/$ratio);
			else
				$list['w1'] = round($info[1]*$ratio);
		}
		elseif($tr == 5)
		{
			if($ratio > $src_ratio)
			{
				$list['h1'] = round($info[0]/$ratio);
				$list['y1'] = $info[1] - $list['h1'];
			}
			else
			{
				$list['w1'] = round($info[1]*$ratio);
				$list['x1'] = $info[0] - $list['w1'];
			}
		}
		elseif($tr == 6)
		{
			if ( $info[0] < $list['x1']+$w || $info[1] < $list['y1']+$h )
				throw new InvalidArgumentBTException('Images crop error.');
			
			$list['w1'] = round($new_w);
			$list['h1'] = round($new_h);
		}
		
		$list['w2'] = round($new_w);
		$list['h2'] = round($new_h);
		
		if( $info[0] < $w && $info[1] < $h )
			$list['small'] = true;
		
		return $list;
	}
	
	/**
	 * Заливка изображения с изменением размеров
	 *
	 * @param string $src_file путь к файлу
	 * @param string $dest_file имя файла назначения (если null - отдать в return)
	 * @param array $params ассоциативный массив размеров (x1, y1, w1, h1, w2, h2)
	 * @param int $type формат картинки в итоге (если null - то как у исходной)
	 * @return bool
	 * @exception RuntimeBTException
	 * @exception InvalidArgumentBTException
	 * @exception BLImagesBTException
	 */
	static public function Resize_NEW($src_file, $dest_file, $params, $type = null)
	{
		
		if( !is_file($src_file) )
			throw new InvalidArgumentBTException('File "'.$src_file.'" not found.');

		$info = @getimagesize($src_file);
		
		if( $info === false )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not determine image params of file "'.$sec_file.'". '.$err['message']);
		}
		
		self::SetMemoryLimit();
		$dest_img = imagecreatetruecolor($params['w2'], $params['h2']);
		if(!$dest_img)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Can not create image canvas: w='.$params['w2'].', h='.$params['h2'].'. '.$err['message']);
		}
		
		
		switch($info[2])
		{
			case 1: $src_img = @imagecreatefromgif($src_file);	break;
			case 2: $src_img = @imagecreatefromjpeg($src_file);	break;
			case 3: $src_img = @imagecreatefrompng($src_file); 	break;
			default: self::ReturnMemoryLimit(); throw new RuntimeBTException('Unexpected image format: "'.$src_file.'"');
		}
		if(!$src_img)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Read image fail: "'.$src_file.'". '.$err['message']);
		}
		
		if( @imagecopyresampled($dest_img, $src_img, 0, 0, $params['x1'], $params['y1'], $params['w2'], $params['h2'], $params['w1'], $params['h1']) === false )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Resample error: "'.$src_file.'". '.$err['message']);
		}
		
		if($type === null)
			$type = $info[2];
		if( !(imagetypes() & $type) )
			$type = $info[2];
				
		$res = false;
		switch($type)
		{
			case 1: $res = @imagegif($dest_img, $dest_file); break;
			case 2: $res = @imagejpeg($dest_img, $dest_file, 95); break;
			case 3: $res = @imagepng($dest_img, $dest_file, 2, PNG_ALL_FILTERS); break;
		}
		if( !$res )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Image write to file error: "'.$dest_file.'". '.$err['message']);
		}
		
		$res = @imagedestroy($dest_img);
		if( !$res )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Error image destroy of "'.$dest_file.'". '.$err['message']);
		}
		$res = @imagedestroy($src_img);
		if( !$res )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Error image destroy of "'.$src_file.'". '.$err['message']);
		}
		
		self::ReturnMemoryLimit();
		
		return true;
	}
	
	/**
	 * Наложение защитной картинки на изображение
	 *
	 * @param string $src_file путь к файлу
	 * @param string $dest_file путь к файлу назначения
	 * @param string $sec_file имя файла, с логотипом
	 * @param string код места положения
	 * @exception BLImagesBTException
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
	 */
	static public function PutSecurityImage_NEW($src_file, $dest_file = null, $sec_file = null, $position = null)
	{
		if( $sec_file === null )
		{
			$sec_file = self::GetDefaultSecurityImage();
			if( $sec_file == '' )
				throw new BLImagesBTException('Default security image not found', self::ERR_Images_DEFAULT_SECURITY_IMAGE_NOT_FOUND);
		}
		
		if( !is_file($src_file) )
			throw new InvalidArgumentBTException('File "'.$src_file.'" not found');
		if( !is_file($sec_file) )
			throw new InvalidArgumentBTException('File "'.$sec_file.'" not found');

		if( $dest_file === null )
			$dest_file = $src_file;
		
		if($position === null)
			$position = 'br';

		$info_src = @getimagesize($src_file);
		if( $info_src === false )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not determine image params of file "'.$src_file.'". '.$err['message']);
		}
		
		$info_sec = @getimagesize($sec_file);
		if( $info_sec === false )
		{
			$err = error_get_last();
			throw new RuntimeBTException('Can not determine image params of file "'.$sec_file.'". '.$err['message']);
		}
		
		$src_x = $info_src[0];
		$src_y = $info_src[1];
		$sec_x = $info_sec[0];
		$sec_y = $info_sec[1];
		
		if($src_x - self::$_security_border['x']*2 < $sec_x
			|| $src_y - self::$_security_border['y']*2 < $sec_y
			)
			throw new BLImagesBTException('Security image bigger than source image. Can not put it :(', self::ERR_Images_DEFAULT_SECURITY_IMAGE_BIGGER_THEN_SOURCE);
			//return true;
		
		// X зависит от lcr - left, center, right
		if( strpos($position, 'l') !== false )
			$x = self::$_security_border['x'];
		else if( strpos($position, 'c') !== false )
			$x = ceil($src_x/2 - $sec_x/2);
		else if( strpos($position, 'r') !== false )
			$x = $src_x - $sec_x - self::$_security_border['x'];
		else
			$x = self::$_security_border['x'];
		
		// Y зависит от tmb - top, middle, bottom
		if( strpos($position, 't') !== false )
			$y = self::$_security_border['y'];
		else if( strpos($position, 'm') !== false )
			$y = ceil($src_y/2 - $sec_y/2);
		else if( strpos($position, 'b') !== false )
			$y = $src_y - $sec_y - self::$_security_border['y'];
		else
			$y = self::$_security_border['y'];
		
		self::SetMemoryLimit();
		switch($info_src[2])
		{
			case 1: $src_img = @imagecreatefromgif($src_file);	break;
			case 2: $src_img = @imagecreatefromjpeg($src_file);	break;
			case 3: $src_img = @imagecreatefrompng($src_file); 	break;
			default: self::ReturnMemoryLimit(); throw new RuntimeBTException('Unexpected image format: "'.$src_file.'"');
		}
		if(!$src_img)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Read image fail: "'.$src_file.'". '.$err['message']);
		}
		
		switch($info_sec[2])
		{
			case 1: $sec_img = @imagecreatefromgif($sec_file);	break;
			case 2: $sec_img = @imagecreatefromjpeg($sec_file);	break;
			case 3: $sec_img = @imagecreatefrompng($sec_file); 	break;
			default: self::ReturnMemoryLimit(); throw new RuntimeBTException('Unexpected image format: "'.$sec_file.'"');
		}
		if(!$sec_img)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Read image fail: "'.$sec_file.'". '.$err['message']);
		}
		
		if(@imagecopy($src_img, $sec_img, $x, $y, 0, 0, $sec_x, $sec_y)=== false)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Put watermark "'.$sec_file.'" on image "'.$src_file.'" fail. '.$err['message']);
		}
		
		$res = false;
		switch($info_src[2])
		{
			case 1: $res = @imagegif($src_img, $dest_file);	break;
			case 2: $res = @imagejpeg($src_img, $dest_file, 100);	break;
			case 3: $res = @imagepng($src_img, $dest_file, 2, PNG_ALL_FILTERS); 	break;
		}
		if(!$res)
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Image write to file error: "'.$dest_file.'". '.$err['message']);
		}
		
		$res = @imagedestroy($sec_img);
		if( !$res )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Error image destroy of "'.$sec_file.'". '.$err['message']);
		}
		$res = @imagedestroy($src_img);
		if( !$res )
		{
			$err = error_get_last();
			self::ReturnMemoryLimit();
			throw new RuntimeBTException('Error image destroy of "'.$src_file.'". '.$err['message']);
		}
		
		self::ReturnMemoryLimit();
		
		return true;
	}
	
}

Images::Init();

class BLImagesBTException extends LogicBTException {}
