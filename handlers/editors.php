<?

/**
 * Хендлер для работы с модулями
 * @package Handlers
 */

// задание по uri
// если uri строка, то в качестве источника берется остаток строки
// если uri регулярка, то в $params['index_source'] индекс из регулярки

class Handler_editors extends IHandler
{
	public function Init($params)
	{
		global $CONFIG;

		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		
		$pos = strpos($_SERVER['REQUEST_URI'], '?');
		if($pos === false)
			$url = $_SERVER['REQUEST_URI'];
		else
			$url = substr($_SERVER['REQUEST_URI'], 0, $pos);
		
	}
	
	public function IsLast()
	{
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS, $CONFIG;

		Response::NoCache();
		if ( !$OBJECTS['user']->IsInRole('e_adm_execute_filemanager') )
			Response::Status(403, RS_EXIT);
		
		$fname = substr(HandlerFactory::$env['url'], strlen('/service/editors/'));
		$file = ENGINE_PATH."resources/scripts/themes/editors/".$fname;

		global $httpRequestInput, $MCErrorHandler, $mcFileManagerConfig, $basepath, $config, $mcLogger, $man, $mcImageManagerConfig;
		global $mcConfig, $compressor;

		if( preg_match('@\.php$@', $file) )
		{
			chdir(dirname($file));
			include_once(basename($file));
		}
		else
		{
			LibFactory::GetStatic('filemagic');
	        if ( is_file($file) )
			{
				if( preg_match('@\.css$@', $file) )
				{
					header('Content-type: text/css');
				}
				elseif( preg_match('@\.js$@', $file) )
				{
					header('Content-type: text/javascript');
				}
				elseif ( null !== ($mt = FileMagic::GetFileInfoByType($file)) )
				{
			        list($mt, $types) = $mt;
					header('Content-type: '.$mt['mime_type']);
				}
				echo $file;
				exit;
				readfile($file);
			}
		}
		exit;
	}
	
	public function Dispose()
	{
	}
}
?>