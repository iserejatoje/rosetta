<?php

// Deprecated! Надо использовать константы из класса.
define('RS_NONE',		0x0000);
define('RS_EXIT',		0x0001);
define('RS_SENDPAGE',	0x0002);

class Response
{
	const STATUS_NONE		= 0x0000;
	const STATUS_EXIT		= 0x0001;
	const STATUS_SENDPAGE	= 0x0002;

	static private $status_codes = array(
		200 => 'OK',
		206 => 'Partial Content',
		301 => 'Found',
		302 => 'Found',
		403 => 'Forbidden',
		402 => 'Payment Required',
		404 => 'Not Found',
		408 => 'Request timeout',
		413 => 'Request entity too large',
		423 => 'Locked',
		500 => 'Internal Server Error',
		502 => 'Bad Gateway',
		503 => 'Service unavailable',
		504 => 'Gateway timeout',
	);

	static private $EncodeOutput = false;

	static public function EncodeOutput($buffer)
	{
		if( self::$EncodeOutput === true )
			$buffer = iconv(App::GetInternalEncoding(), App::GetExternalEncoding(), $buffer);
		self::$EncodeOutput = false;
		return $buffer;
	}

	static public function StartEncodeBuffering()
	{
		self::$EncodeOutput = true;

		return self::StartBuffering(array("Response", "EncodeOutput"));
	}

	static public function StartBuffering($callback = null)
	{
		return ob_start($callback);
	}

	static public function FlushBuffering()
	{
		$ar = ob_get_status();
		if( isset($ar['level']) && $ar['level']>0 )
			return false;
		return ob_end_flush();
	}

	static public function CleanBuffering()
	{
		$ar = ob_get_status();
		if( isset($ar['level']) && $ar['level']>0 )
			return false;
		return ob_end_clean();
	}

	/**
	 * Установка статуса ответа
	 * @param int код статуса (например 404)
	 * @param int флаги
	 */
	static public function Status($status, $flags = self::STATUS_NONE)
	{
		// $exit = false, $sendpage = true;
		self::NoCache();
		if(!self::IsHeaderSent(true))
			header($_SERVER["SERVER_PROTOCOL"].' '.$status.' '.self::$status_codes[$status]);
		if($flags & self::STATUS_SENDPAGE)
		{
			if(is_file(sprintf(ENGINE_PATH."resources/http_error_page/%s.html", $status))){
				echo file_get_contents(sprintf(ENGINE_PATH."resources/http_error_page/%s.html", $status));
			}
		}
		if($flags & self::STATUS_EXIT)
			exit();
	}

	/**
	 * Отключение кэширования заголовком
	 */
	static public function NoCache()
	{
		if(self::IsHeaderSent(true))
			return;
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
		header("Pragma: no-cache");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Last-Modified: ".date("r", time() - 86400));
	}

	/**
	 * Редирект на url
	 */
	static public function Redirect($url, $exit = true)
	{
		if(!self::IsHeaderSent(true))
			header('Location: '.$url);
		if($exit === true)
			exit();
	}

	static public function IsHeaderSent($loging = false)
	{
		$file = '';
		$line = '';
		if(headers_sent($file, $line))
		{
			if($loging === true)
			{
				error_log('Headers already sent in file: '.$file.' on line: '.$line);
				//throw new ResponseDomainBTException('Headers already sent in file: '.$file.' on line: '.$line);
			}
			return true;
		}
		return false;
	}

	static public function Header($params, $value = null)
	{
		if (empty($params))
			return false;

		if (is_array($params) && sizeof($params)) {
			foreach($params as $k => $v) {
				header($k.': '.$v);
			}

			return true;
		}

		header($params.': '.(string) $value);
		return true;
	}
}

class ResponseDomainBTException extends DomainBTException {}
