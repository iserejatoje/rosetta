<?

class FileMagic
{
    const MT_ARCHIVE = 1;
    const MT_IMAGE = 2;
    const MT_WIMAGE = 3;
    const MT_TEXT = 4;
    const MT_OFFICE = 5;
    const MT_OTHER = 6;
    const MT_VIDEO = 7;
    const MT_AUDIO = 8;

	private static $types_valid_default = array(
		'application/x-rar', 
        'application/x-gzip',
        'application/x-tar',
        'application/zip',
        'application/x-zip',
		'application/msword',
        'application/vnd.ms-excel',
        'application/pdf',

        'image/vnd.djvu',
		'image/bmp',
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/tiff',
        'application/x-shockwave-flash',
		'image/x-icon',
        'text/css',
        'text/html',
        'text/plain',
        'text/rtf',
        'text/xml',	
		
		
		
	);
	// disposition - как отдавать файл attachment - сохранить, inline - показать (если браузер не может показать, предложит сохранить, но это бывает не всегда)
	// со временем дополнить
	private static $mime_types = array(
		// archives
        'application/x-rar'						=> array('extension' => 'rar',	'type' => 'archive', 'disposition' => 'attachment'),
        'application/x-gzip'					=> array('extension' => 'gz',	'type' => 'archive', 'disposition' => 'attachment'),
        'application/x-tar'						=> array('extension' => 'tar',	'type' => 'archive', 'disposition' => 'attachment'),
        'application/zip'						=> array('extension' => 'zip',	'type' => 'archive', 'disposition' => 'attachment',
            'valid_ext' => array('zip','odt','ods','odg','odp','odf','sxm','odb','sxw','sxc','docx','xlsx')),
        'application/x-zip'						=> array('extension' => 'zip',	'type' => 'archive', 'disposition' => 'attachment',
            'valid_ext' => array('zip','odt','ods','odg','odp','odf','sxm','odb','sxw','sxc','docx','xlsx')),
        'application/x-shockwave-flash'			=> array('extension' => 'swf',	'type' => 'image', 'disposition' => 'inline'),

		// audio
		'audio/mpeg'							=> array('extension' => 'mp3',	'type' => 'image', 'disposition' => 'attachment'),
		
		// video
		'video/x-msvideo'						=> array('extension' => 'avi',	'type' => 'image', 'disposition' => 'attachment'),
		'video/mp4'								=> array('extension' => 'mp4',	'type' => 'image', 'disposition' => 'attachment',
														'valid_ext' => array('mp4', 'avi')),

		// image
        'image/bmp'								=> array('extension' => 'bmp',	'type' => 'image', 'disposition' => 'inline'),
        'image/cgm'								=> array('extension' => 'cgm',	'type' => 'image', 'disposition' => 'inline'),
        'image/g3fax'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/gif'								=> array('extension' => 'gif',	'type' => 'image', 'disposition' => 'inline'),
        'image/ief'								=> array('extension' => 'ief',	'type' => 'image', 'disposition' => 'inline'),
        'image/jpeg'							=> array('extension' => 'jpg',	'type' => 'image', 'disposition' => 'inline'),
        'image/naplps'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/png'								=> array('extension' => 'png',	'type' => 'image', 'disposition' => 'inline'),
        'image/prs.btif'						=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/prs.pti'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/svg+xml'							=> array('extension' => 'svg',	'type' => 'image', 'disposition' => 'inline'),
        'image/t38'								=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/tiff'							=> array('extension' => 'tif',	'type' => 'image', 'disposition' => 'inline'),
        'image/tiff-fx'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.cns.inf2'					=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.djvu'						=> array('extension' => 'djvu',	'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.dwg'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.dxf'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.fastbidsheet'				=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.fpx'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.fst'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.fujixerox.edmics-mmr'		=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.fujixerox.edmics-rlc'		=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.globalgraphics.pgb'			=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.mix'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.ms-modi'						=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.net-fpx'						=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.svf'							=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.wap.wbmp'					=> array('extension' => 'wbmp',	'type' => 'image', 'disposition' => 'inline'),
        'image/vnd.xiff'						=> array('extension' => '',		'type' => 'image', 'disposition' => 'inline'),
        'image/x-cmu-raster'					=> array('extension' => 'ras',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-icon'							=> array('extension' => 'ico',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-portable-anymap'				=> array('extension' => 'pnm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-portable-bitmap'				=> array('extension' => 'pbm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-portable-graymap'				=> array('extension' => 'pgm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-portable-pixmap'				=> array('extension' => 'ppm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-rgb'							=> array('extension' => 'rgb',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-xbitmap'						=> array('extension' => 'xbm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-xpixmap'						=> array('extension' => 'xpm',	'type' => 'image', 'disposition' => 'inline'),
        'image/x-xwindowdump'					=> array('extension' => 'xwd',	'type' => 'image', 'disposition' => 'inline'),

        // Text
        'text/calendar'							=> array('extension' => 'ics',	'type' => 'text', 'disposition' => 'attachment'),
        'text/css'								=> array('extension' => 'css',	'type' => 'text', 'disposition' => 'inline'),
        'text/directory'						=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/enriched'							=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/html'								=> array('extension' => 'html',	'type' => 'text', 'disposition' => 'inline'),
        'text/parityfec'						=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/plain'							=> array('extension' => 'txt',	'type' => 'text', 'disposition' => 'inline'),
        'text/prs.lines.tag'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/rfc822-headers'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/richtext'							=> array('extension' => 'rtx',	'type' => 'text', 'disposition' => 'attachment'),
        'text/rtf'								=> array('extension' => 'rtf',	'type' => 'text', 'disposition' => 'attachment'),
        'text/sgml'								=> array('extension' => 'sgm',	'type' => 'text', 'disposition' => 'inline'),
        'text/t140'								=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/tab-separated-values'				=> array('extension' => 'tsv',	'type' => 'text', 'disposition' => 'inline'),
        'text/uri-list'							=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.abc'							=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.curl'							=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.dmclientscript'				=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.fly'							=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.fmi.flexstor'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.in3d.3dml'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.in3d.spot'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.iptc.nitf'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.iptc.newsml'					=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.latex-z'						=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.motorola.reflex'				=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.ms-mediapackage'				=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.net2phone.commcenter.command'	=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.sun.j2me.app-descriptor'		=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.wap.si'						=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.wap.sl'						=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.wap.wml'						=> array('extension' => 'wml',	'type' => 'text', 'disposition' => 'inline'),
        'text/vnd.wap.wmlscrip'					=> array('extension' => 'wmls',	'type' => 'text', 'disposition' => 'inline'),
        'text/x-setext'							=> array('extension' => 'etx',	'type' => 'text', 'disposition' => 'inline'),
        'text/xml'								=> array('extension' => 'xml',	'type' => 'text', 'disposition' => 'inline'),
        'text/xml-external-parsed-entity'		=> array('extension' => '',		'type' => 'text', 'disposition' => 'inline'),
        'application/x-javascript'				=> array('extension' => 'js',	'type' => 'text', 'disposition' => 'inline'),
        'application/xml'						=> array('extension' => 'xml',	'type' => 'image', 'disposition' => 'inline'),

        // office
        'application/msword'					=> array('extension' => 'doc',	'type' => 'office', 'disposition' => 'attachment',
            'valid_ext' => array('doc', 'sdw', 'xls', 'sdd', 'ppt', 'pot', 'smf')),
        'application/vnd.ms-excel'				=> array('extension' => 'xls',	'type' => 'office', 'disposition' => 'attachment'),
        'application/pdf'						=> array('extension' => 'pdf',	'type' => 'office', 'disposition' => 'inline'),
        'application/postscript'				=> array('extension' => 'ps',	'type' => 'office', 'disposition' => 'inline'),
        'application/vnd.ms-artgalry'			=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-asf'				=> array('extension' => 'asf',	'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-lrm'				=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-powerpoint'			=> array('extension' => 'ppt',	'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-project'			=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-tnef'				=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-works'				=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),
        'application/vnd.ms-wpl'				=> array('extension' => '',		'type' => 'office', 'disposition' => 'attachment'),

        // Other
        'application/octet-stream'				=> array('extension' => '',		'type' => 'other', 'disposition' => 'attachment',
            'valid_ext' => array('flv', 'avi')),
	);

    private static $mime_types_list = array(
		// archives
        1 => array(
            'application/x-rar',
            'application/x-gzip',
            'application/x-tar',
            'application/zip',
            'application/x-zip',
            'application/x-shockwave-flash',
		),
		// image
        2 => array(
            'image/bmp',
            'image/cgm',
            'image/g3fax',
            'image/gif',
            'image/ief',
            'image/jpeg',
            'image/naplps',
            'image/png',
            'image/prs.btif',
            'image/prs.pti',
            'image/svg+xml',
            'image/t38',
            'image/tiff',
            'image/tiff-fx',
            'image/vnd.cns.inf2',
            'image/vnd.djvu',
            'image/vnd.dwg',
            'image/vnd.dxf',
            'image/vnd.fastbidsheet',
            'image/vnd.fpx',
            'image/vnd.fst',
            'image/vnd.fujixerox.edmics-mmr',
            'image/vnd.fujixerox.edmics-rlc',
            'image/vnd.globalgraphics.pgb',
            'image/vnd.mix',
            'image/vnd.ms-modi',
            'image/vnd.net-fpx',
            'image/vnd.svf',
            'image/vnd.wap.wbmp',
            'image/vnd.xiff',
            'image/x-cmu-raster',
            'image/x-icon',
            'image/x-portable-anymap',
            'image/x-portable-bitmap',
            'image/x-portable-graymap',
            'image/x-portable-pixmap',
            'image/x-rgb',
            'image/x-xbitmap',
            'image/x-xpixmap',
            'image/x-xwindowdump',
		),

        // Images for web
        3 => array(
            'image/gif',
            'image/jpeg',
            'image/png',
		),

        // text
        4 => array(
            'text/calendar',
            'text/css',
            'text/directory',
            'text/enriched',
            'text/html',
            'text/parityfec',
            'text/plain',
            'text/prs.lines.tag',
            'text/rfc822-headers',
            'text/richtext',
            'text/rtf',
            'text/sgml',
            'text/t140',
            'text/tab-separated-values',
            'text/uri-list',
            'text/vnd.abc',
            'text/vnd.curl',
            'text/vnd.dmclientscript',
            'text/vnd.fly',
            'text/vnd.fmi.flexstor',
            'text/vnd.in3d.3dml',
            'text/vnd.in3d.spot',
            'text/vnd.iptc.nitf',
            'text/vnd.iptc.newsml',
            'text/vnd.latex-z',
            'text/vnd.motorola.reflex',
            'text/vnd.ms-mediapackage',
            'text/vnd.net2phone.commcenter.command',
            'text/vnd.sun.j2me.app-descriptor',
            'text/vnd.wap.si',
            'text/vnd.wap.sl',
            'text/vnd.wap.wml',
            'text/vnd.wap.wmlscrip',
            'text/x-setext',
            'text/xml',
            'text/xml-external-parsed-entity',
            'application/x-javascript',
            'application/xml',
		),

        // office
        5 => array(
            'application/msword',
            'application/vnd.ms-excel',
            'application/pdf',
            'application/postscript',
            'application/vnd.ms-artgalry',
            'application/vnd.ms-asf',
            'application/vnd.ms-lrm',
            'application/vnd.ms-powerpoint',
            'application/vnd.ms-project',
            'application/vnd.ms-tnef',
            'application/vnd.ms-works',
            'application/vnd.ms-wpl',
	        'application/zip',
	        'application/x-zip',
		),
		// binary

		// other
        6 => array(
            'application/octet-stream',
        ),
		
		// video
		7 => array(
			'application/octet-stream',
			'video/x-msvideo',
			'video/mp4',
		),

		// audio
		8 => array(
			'application/octet-stream',
			'audio/mpeg',
		),

	);
	
	// выбор контент тайпа для отправки файла, при их использовании файлики будут открываться
	private static $extensions = array(
	
	);
	
	private static $defaultcontenttype = 'application/octet-stream'; // вообще бинарники
	
	private static $finfo = null;

    /**
	 * Корректировка расширения файла
	 *
	 * @param string - путь до файла
	 * @param array - информация о типе файла
	 *
	 * @return string - путь до файл
	 */
	public static function CorrectName($path, $type = null)
	{
		if($type === null)
			$type = self::GetFileInfo($path);
		if($type['mime_type'] === self::$defaultcontenttype)
			return $path;
		
		$pos = strrpos($path, '.');
		if($pos !== false)
		{
			$ext = substr($path, $pos+1);
			$path = substr($path, 0, $pos);			
		}

		// если нет параметра valid_ext, то меняем и если есть, но расширение не найдено среди доступных
		if( !isset($type['valid_ext']) || (isset($type['valid_ext']) && !in_array($ext, $type['valid_ext'])))
			return $path.'.'.$type['extension'];
		return $path.'.'.$ext;
	}

    /**
	 * Корректировка расширения файла
	 *
	 * @param string - путь до файла
	 * @param array - информация о типе файла
	 *
	 * @return string - путь до файл
	 * @exception RuntimeBTException
	 * @exception InvalidArgumentBTException
	 */
	public static function CorrectName_NEW($path, $type = null)
	{
		if($type === null)
			$type = self::GetFileInfo_NEW($path);
		if($type['mime_type'] === self::$defaultcontenttype)
			return $path;
		
		$pos = strrpos($path, '.');
		if($pos !== false)
		{
			$ext = substr($path, $pos+1);
			$path = substr($path, 0, $pos);			
		}

		// если нет параметра valid_ext, то меняем и если есть, но расширение не найдено среди доступных
		if( !isset($type['valid_ext']) || (isset($type['valid_ext']) && !in_array($ext, $type['valid_ext'])))
			return $path.'.'.$type['extension'];
		return $path.'.'.$ext;
	}

    /**
	 * Получение ресурса "finfo" для опеределения mimetype файла
	 * @return resource on success or FALSE on failure.
	 */
	public static function GetFileInfoHandler()
	{
		if(self::$finfo === false)
			return null;
			
		if(self::$finfo !== null)
			return self::$finfo;
			
		self::$finfo = new finfo(FILEINFO_MIME, '/usr/share/file/magic');
		if(!self::$finfo)
		{
			self::$finfo = false;
			return null;
		}
		return self::$finfo;
	}

    /**
	 * Получение ресурса "finfo" для опеределения mimetype файла
	 * @return resource on success or Exception
	 * @exception RuntimeBTException
	 */
	public static function GetFileInfoHandler_NEW()
	{
		if(self::$finfo === false)
			throw new RuntimeBTException('Can not get FINFO resource (second time)');
			
		if(self::$finfo !== null)
			return self::$finfo;
			
		self::$finfo = new finfo(FILEINFO_MIME);
		if(!self::$finfo)
		{
			self::$finfo = false;
			throw new RuntimeBTException('Can not get FINFO resource (first time)');
		}
		return self::$finfo;
	}

    /**
	 * Получает mimetype информацию по умолчанию
	 * @return array
	 */
	public static function GetFileInfoDefault()
	{
		$mt = self::$mime_types[self::$defaultcontenttype];
		$mt['mime_type'] = self::$defaultcontenttype;
		return $mt;
	}

    /**
	 * Получение mimetype информации о файле
	 *
	 * @param string - путь до файла
	 * @param string - пользовательское имя файла
	 *
	 * @return array
	 */
	public static function GetFileInfo($path, $test_name = null)
	{
		if($test_name === null)
			$test_name = $path;
		$fi = self::GetFileInfoHandler();
		if($fi === null)
			return self::GetFileInfoDefault();
		
		if(is_file($path)) // если файла нет, вместо false $fi->file($path) вернет cannot open ()
		{
			$mtype = $fi->file($path);
			list($mtype,) = explode(';', $mtype, 2);
			
			// для некоторых типов (например msword вращается строка "application/msword application/msword")
			list($mtype,) = explode(' ', $mtype, 2);
		}
		else
			$mtype = false;

		if(!$mtype)
			return self::GetFileInfoDefault();

        $mt = self::$mime_types[$mtype];
		
		$pos = strrpos($test_name, '.');
		if($pos !== false)
		{
			$ext = substr($test_name, $pos+1);
			if(isset($mt['valid_ext']) && in_array($ext, $mt['valid_ext']))
				$mt['extension'] = $ext;
		}
		
		$mt['mime_type'] = $mtype;
		return $mt;
	}

    /**
	 * Получение mimetype информации о файле
	 *
	 * @param string - путь до файла
	 * @param string - пользовательское имя файла
	 *
	 * @return array
	 * @exception RuntimeBTException
	 * @exception InvalidArgumentBTException
	 */
	public static function GetFileInfo_NEW($path, $test_name = null)
	{
		if($test_name === null)
			$test_name = $path;
		$fi = self::GetFileInfoHandler_NEW();
		if($fi === null)
			return self::GetFileInfoDefault();
		
		if(is_file($path)) // если файла нет, вместо false $fi->file($path) вернет cannot open ()
		{
			$mtype = $fi->file($path);
			list($mtype,) = explode(';', $mtype, 2);
		}
		else
			throw new InvalidArgumentBTException('File "'.$path.'" not found');

		if(!$mtype)
			return self::GetFileInfoDefault();

        $mt = self::$mime_types[$mtype];
		
		$pos = strrpos($test_name, '.');
		if($pos !== false)
		{
			$ext = substr($test_name, $pos+1);
			if(isset($mt['valid_ext']) && in_array($ext, $mt['valid_ext']))
				$mt['extension'] = $ext;
		}
		
		$mt['mime_type'] = $mtype;
		return $mt;
	}

    /**
	 * Получение mimetype информации о файле из группы
	 *
	 * @param string - путь до файла
	 * @param int - группа файлов
     * @param string - пользовательское имя файла
	 *
	 * @return array (0 => array(mimetype информация по файлу ), 1 => array(список mimetype's из запрошеной группы))
	 */
    public static function GetFileInfoByType($path, $types = null, $test_name = null) {

        if($types === null)
			$types = self::$types_valid_default;
        else if ( is_int($types) && isset(self::$mime_types_list[$types]) )
            $types = array_keys(self::$mime_types_list[$types]);

        if ( empty($types) )
            return null;

        if ( false == ($mt = self::GetFileInfo($path, $test_name)) )
            return null;

        return array($mt, $types);
    }

    /**
	 * Получение mimetype информации о файле из группы
	 *
	 * @param string - путь до файла
	 * @param int - группа файлов
     * @param string - пользовательское имя файла
	 *
	 * @return array (0 => array(mimetype информация по файлу ), 1 => array(список mimetype's из запрошеной группы))
	 * @exception InvalidArgumentBTException
	 */
    public static function GetFileInfoByType_NEW($path, $types = null, $test_name = null)
	{
		$types_arr = false;
        if($types === null)
			$types_arr = self::$types_valid_default;
        else if ( is_int($types) && isset(self::$mime_types_list[$types]) )
            $types_arr = self::$mime_types_list[$types];

        if ( $types_arr == false )
            throw new InvalidArgumentBTException('Incorrect mimetype parameter');

        $mt = self::GetFileInfo_NEW($path, $test_name);

        return array($mt, $types_arr);
    }

    /**
	 * Проверяет принадлежность типа файла к группе
	 *
	 * @param string - путь до файла
	 * @param int - группа файлов
	 *
	 * @return bool - true при успехе, иначе false
	 */
	public static function IsValidType($path, $types = null)
	{
        $mt = self::GetFileInfoByType($path, $types, null);
        if ( empty($mt) )
            return false;

        list($mt, $types) = $mt;
        return in_array($mt['mime_type'], $types);
	}


    /**
	 * Проверяет принадлежность типа файла к группе
	 *
	 * @param string - путь до файла
	 * @param int - группа файлов
	 *
	 * @return bool - true при успехе, иначе false
	 */
	public static function IsValidType_NEW($path, $types = null)
	{
        try
		{
			list($file_info, $mime_types) = self::GetFileInfoByType_NEW($path, $types);
			if ( !in_array($file_info['mime_type'], $mime_types) )
				return false;			
		}
		catch (Exception $e)
		{
			return false;
		}
		return true;
	}


}

?>