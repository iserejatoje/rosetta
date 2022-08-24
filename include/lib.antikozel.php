<?

/**
	Противодействие публикации неблагонадежных ссылок,
	которые размещают козлы, вроде elitrabota.ru
*/

class lib_AntiKozel
{
	public $Dictionaries = array(
		'spam.txt',
		'mat.txt',
		'stopword_common.txt',
		'job_common.txt',
	);
	
	private $_depth = 0;
	private $_check_exist = false;
	
	private $_cache = array();
	
	
	/**
	 * Проверка урла на наличие недопустимых редиректов
	 *
	 * @param string $url - проверяемый URL
	 * @param string $check_exist - выполнять ли проверку  на пустой ответ
	 * @exception InvalidArgumentMyException
	 */
	public function CheckUrl($url, $check_exist = false)
	{
		if ( empty($url) )
			throw new InvalidArgumentMyException('Url not set');
		
		$this->_depth = 0;
		$this->_check_exist = $check_exist;
		
		if ( isset($this->_cache[$url]) )
			return $this->_cache[$url];
		
		$this->_cache[$url] = $this->_CheckUrl($url);
		
		return $this->_cache[$url];
	}
	
	private function _CheckUrl($url)
	{
		$_curl = LibFactory::GetInstance('curl');
		$_curl->Init();
		$_curl->setParams(array( 
					'type' => 'module',
					'use_proxy' => false,
					'follow_redirect' => false,
					'get_headers' => true,
					'silent' => true,
					'retry' => 2,
					'timeout' => 10,
				));
		
		// больше 2 редиректов - нафиг
		if ( $this->_depth > 2 )
			return false;
		
		$this->_depth++;
		
		$content = $_curl->query( array( 'url' => $url ) );
		
		// если сайт не ответил - не пускаем
		if ( $content === false )
		{
			if ( $this->_check_exist )
				return false;
			else
				return true;
		}
		
		trace::log("not empty ". $url);
		
		$content = str_replace("\n", " ", $content);
		
		// если ответ не содержит заголовка - не пускаем
		if ( !preg_match('@^HTTP/\d+\.\d+ (\d+)@i', $content, $matche) )
			return false;
		
		trace::log("has header " .$matche[1]);
		
		// проверяем HTTP-редирект
		if ( $matche[1] == '300' || $matche[1] == '301'  || $matche[1] == '302'  || $matche[1] == '303' )
		{
			if ( !preg_match('@Location:\s*([^\s]+)@i', $content, $matche) )
				return false;
			
			$target = $matche[1];
			
			trace::log("has http-redirect to ". $target);
			
			// если редиректит на страницу в том же домене - идем по ссылке, может слеша в урле не хватало
			if ( false !== ($target = $this->_CheckDomain($url, $target)) )
				return $this->_CheckUrl($target);
			else
				return false;
		}
		
		trace::log("no http-redirect");
		
		// проверяем наличие редиректа мета-тегом
		if ( preg_match('@<meta\s*http-equiv=[\'\"]Refresh[\'\"]\s*content=[\'\"]\d+[,;]URL=[\'\"]?([^\'\"]+)@i', $content, $matche) )
		{
			trace::log("meta-tag redirect found");
			if ( !$this->_CheckDomain($url, $matche[1]) )
				return false;
		}
		
		trace::log("no invalid meta-tag redirect");
		
		// проверяем javascript-редиректы
		if ( preg_match('@(?:document|window)\.location(?:.href)?\s*=(\".+\"|\'.+\')\s*;@i', $content, $matches) )
		{
			$target = $matche[1];
			
			// проверим урл цензором
			LibFactory::GetStatic('censor');
			$censor = new lib_censor(true, $this->_dict_common);
			$censor->load_dictionary($this->Dictionaries);
			if ( $censor->is_censored($target) === false )
				return false;
		}
		
		trace::log("no invalid js-redirect");
		
		if ( App::$User->ID == 28154 )
		{
			trace::log("ALL OK, BUT 28154");
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Проверка того, что переход осуществляется внутри одного домена второго уровня
	 *
	 * @param string $source - исходный URL
	 * @param string $target - целевой URL
	 * @exception InvalidArgumentMyException
	 */
	private function _CheckDomain($source, $target)
	{
		if ( !preg_match('@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2,4})@', $source, $source_domain) )
			return false;

		if ( substr($target, 0, 1) == '/' )
		{
			$target = $source_domain[0] . $target;
			trace::log('inner redirect to: '. $target);
		}

		if ( !preg_match('@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2,4})@', $target, $target_domain) )
			return false;
		
		// домен 1го уровня
		if ( strtolower(array_pop($source_domain)) != strtolower(array_pop($target_domain)) )
			return false;
		
		// домен 2го уровня
		if ( strtolower(array_pop($source_domain)) != strtolower(array_pop($target_domain)) )
			return false;
		
		return $target;
	}
	
	/**
	 * Функция определения уровня доменного имени.
	 *
	 * @param string $url - URL
	 * @return int - уровень домена (for example: ru - 1, 74.ru - 2)
	 * @exception InvalidArgumentMyException
	 */
	public function GetDomainDepth($url)
	{
		if( !is_string($url) || $url == '' )
			throw new InvalidArgumentMyException('Url is empty or not a string');
		
		if ( !preg_match('@^(https?|ftp)://@i', $url) )
			$url = 'http://'. $url;
		
		$host = @parse_url($url, PHP_URL_HOST);
		
		if( $host === false )
		{
			$err = error_get_last();
			throw new InvalidArgumentMyException($err['message']);
		}
		
		$host = trim(preg_replace('@\.+@', '.', $host), '. ');
		if( $host == '' )
			throw new InvalidArgumentMyException('Host is empty');
		
		$parts = explode('.',$host);
		$count = count($parts);
		// Если первый элемент хоста www, то -1 от $count.
		if( $parts[0]=='www' && $count > 1 )
			$count--;
		
		return $count;
	}	
	
}


?>
