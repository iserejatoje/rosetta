<?

class Title
{
	static $TO_TITLE		= 1;
	static $TO_KEYWORDS		= 2;
	static $TO_DESCRIPTION	= 4;	
	static $TO_ALL			= 7;	
	
	static $use_optimizer	= false;

	static $DEF_SCRIPT = array('type'=>'text/javascript', 'language'=>'javascript', 'src'=>'', 'charset'=>'utf-8');
	
	static private $cfg = array(
		'mo' => array(	// сервер отдачи CSS и JS
			'host' => 'http://moptimizer.be.dc-chel.w.rugion.ru:8082',				// для внутренних нужд
			'path' => '/nservice/moptimizer/',						// путь отдавальщика
			'maxlink' => 2048,										// максимальная длинна урла, с учетом запаса на 1 урл
			'pathprefixcommon' => '',	// префикс пути к сайту, для формирования полного урла к файлам
																	// если не известен домен, путь к 74, чтобы не менять пути стилей
			'cmd' => array(
				'link'		=> 'getlink',
				'files'		=> 'getfiles'
			),
		),
	);
	
	public $Delim;
	public $Tags = array();	
	
	function __construct($delimiter = ' - ') {
		global $CONFIG;
		
		self::$cfg['mo']['pathprefixcommon'] = ENGINE_PATH.'resources/';
		
		$this->Delim = $delimiter;
		
		//if($_GET['debug'] > 12) self::$use_optimizer = true;
		if($_GET['nomo'] > 10) self::$use_optimizer = false;
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
			$isie = true;
		
		if($isie)
			$this->AddStyle('/_styles/themes/fix_ie/png.css');
	}
	
	public function Add($tag, $attr = array(), $values = '', $before = false) {
			
		if ( empty($tag) )
			return false;
		
		if ( !is_array($tag) )
			return $this->_add(array($tag), array($attr), array($values), $before);
		else		
			return $this->_add($tag, $attr, $values, $before);
	}
	
	private function _add($tags, $attr, $values, $before) {
	
		if ( !is_array($tags) )
			return;

		foreach ($tags as $k => $tag)
		{
			$tag = strtolower($tag);
			
			if ( !isset($this->Tags[$tag]) )
				$this->Tags[$tag] = array();
			
			$value = is_array($values) ? $values[$k] : (string) $values;
			switch ($tag) {
				case 'script':

					if ( is_string($attr[$k]) )
						$attr[$k] = array('src' => $attr[$k]) ;
					else if(!is_array($attr[$k]))
						continue;
						
					$attr[$k] = array_merge(self::$DEF_SCRIPT, $attr[$k]);
					$attr[$k]['cdata'] = $value;
					
					$this->Tags[$tag][$attr[$k]['src']] = $attr[$k];
					$this->Tags['scripts'] = &$this->Tags[$tag];
				break;
				
				case 'link':
					$attr[$k]['cdata'] = $value;
					$this->Tags['link'][ strtolower($attr[$k]['rel']).$attr[$k]['href'] ] = $attr[$k];
				break;
				
				case 'meta':
					$attr[$k]['cdata'] = $value;
					$this->Tags[$tag][ strtolower($attr[$k]['http-equiv']).$attr[$k]['name'] ] = $attr[$k];
				break;
				
				case 'path':
					$attr[$k] = ( is_array($attr[$k]) ) ? $attr[$k]['link'] : $attr[$k];
					
					if ( !$before )			
						$this->Tags[$tag][] = array(
							'name' => $value,
							'link' => $attr[$k],		
						);
					else
						array_unshift($this->Tags[$tag], array(
							'name' => $value,
							'link' => $attr[$k],		
						));
				break;
				
				case 'title':
				case 'keywords':
				case 'description':
					if ( !$before )			
						$this->Tags[$tag][] = $value;
					else
						array_unshift($this->Tags[$tag], $value);
				break;
				
				default: 
					$attr[$k] = (array) $attr[$k];
					$attr[$k]['cdata'] = $value;
						
					if ( !$before )			
						$this->Tags[$tag][] = $attr[$k];
					else
						array_unshift($this->Tags[$tag], $attr[$k]); 
			}			
		}
		return true;
	}
	
	
	function Append($value, $to = null)
	{	
		if ($to === null)
			$to = self::$TO_TITLE;
		
		$value = strip_tags($value);
		if($to & self::$TO_TITLE)
			$this->_add(array('title'), array(), array($value), false);
		
		if($to & self::$TO_KEYWORDS)
			$this->_add(array('keywords'), array(), array($value), false);
		
		if($to & self::$TO_DESCRIPTION)
			$this->_add(array('description'), array(), array($value), false);
	}
	
	function AppendBefore($value, $to = null)
	{
		if ($to === null)
			$to = self::$TO_TITLE;
			
		if($to & self::$TO_TITLE)
			$this->_add(array('title'), array(), array($value), true);

		if($to & self::$TO_KEYWORDS)
			$this->_add(array('keywords'), array(), array($value), true);

		if($to & self::$TO_DESCRIPTION)
			$this->_add(array('description'), array(), array($value), true);
	}

	public function AddScript($value = null) {
		if( empty($value) )
			return false;
		return $this->Add('script', $value);
	}
	
	public function AddScripts($value = null) {
		if( is_array($value) && sizeof($value) )
		{
			foreach ($value as $v)
				$this->AddScript($v);
			return true;
		}
		return false;
	}
	
	public function AddStyle($value = null) {
		if( empty($value) )
			return false;
		return $this->Add('link', array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => $value, 'src' => $value));
	}
	
	// для стилей делает обращение через сервер отдачи CSS и JS, оптимизируя запросы
	public function CompressFiles($index)
	{
		global $CONFIG;
		
		//error_log('compress');
		
		$attr = $vattr = null;
		if($index == 'script')
		{
			$type = 'js';
			$sattr = 'src';
		}
		elseif($index == 'link')
		{
			$type = 'css';
			$sattr = 'href';
			$attr = 'rel';
			$vattr = 'stylesheet';
		}
		else
			return;
		$new = $buf = array(); // $buf временны массив для накопления в случае ошибки
		$link = $deflink = self::$cfg['mo']['host'].self::$cfg['mo']['path'].self::$cfg['mo']['cmd']['link'].'/'.$type.'/?files=';
		
		//error_log('count['.$index.']: '.count($this->Tags[$index]));
		
		if(count($this->Tags[$index]) == 0)
			return;
			
		foreach($this->Tags[$index] as $k => $v)
		{
			$copy = false;
			// пропускаем, если не тот тип
			if($attr !== null && $v[$attr] != $vattr)
				$copy = true;
				
			// пропускаем абсолютные урлы
			if(strpos($v[$sattr], 'http://') === 0)
				$copy = true;
			
			if($copy == false)
			{
				// проверяем не сжат ли урл
				if(strpos($v[$sattr], self::$cfg['mo']['path']) === 0)
					$copy = true;
			}
				
			if($copy == false)
			{
				$pref = '';
				if(strpos($v[$sattr], '/_styles') === 0 || strpos($v[$sattr], '/_scripts') === 0)
				{
					$pref = self::$cfg['mo']['pathprefixcommon'];
				}
				//elseif(isset($CONFIG['env']['regid']))
				//	$pref = self::$cfg['mo']['pathprefix'].$CONFIG['env']['site']['domain'];
				else
					$copy = true;
			}
			
			if($copy === false)
			{
				$link.= $pref.substr($v[$sattr], 2).';';// обрезаем "/_"
				$buf[$k] = $v;
				//error_log('link len: '.strlen($link).' max: '.self::$cfg['mo']['maxlink']);
				if(strlen($link) > self::$cfg['mo']['maxlink'] && count($buf) > 0)
				{
					//if($_GET['debug']>12)
					//	error_log("1: ".$link);
					$url = $this->CurlGet($link);
					if($url !== null)
					{
						if($type == 'css')
							$new[] = array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => $url, 'src' => $url);
						elseif($type == 'js')
							$new[] = array('type' => 'text/javascript',  'language' => 'javascript', 'src' => $url, 'charset' => self::$DEF_SCRIPT['charset']);
						$buf = array();
						$link = $deflink;
					}
					else
					{
						$link = $deflink;
						$new = array_merge($new, $buf);
						$buf = array();
					}
				}
			}
			else
				$new[$k] = $v;
		}
		
		if(count($buf) > 0)
		{
			//if($_GET['debug']>12)
			//	error_log("2: ".$link);
			$url = $this->CurlGet($link);
			if($url !== null)
			{
				if($type == 'css')
					$new[] = array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => $url, 'src' => $url);
				elseif($type == 'js')
					$new[] = array('type' => 'text/javascript',  'language' => 'javascript', 'src' => $url, 'charset' => self::$DEF_SCRIPT['charset']);
				$buf = array();
				$link = $deflink;
			}
			else
			{
				$link = $deflink;
				$new = array_merge($new, $buf);
				$buf = array();
			}
		}
		$this->Tags[$index] = $new;
	}	
	
	private function CurlGet($url)
	{
		//error_log('query: '.$url);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_NOBODY, 0);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl);
		$errno = curl_errno($curl);
		curl_close($curl);
		
		if($errno == 0 && is_string($res) && strlen($res) > 20)
			return $res;
		else
			return null;
	}
	
	public function AddStyles($value = null) {
		if( is_array($value) && sizeof($value) ) {
			foreach ($value as $v) $this->AddStyle($v);
			return true;
		}
		return false;
	}

	public function AddPath($name, $link = null) {
		$this->Add('path', $link, $name);
	}
	
	public function AddPathBefore($name, $link = null) {
		$this->Add('path', $link, $name, true);
	}
		
	protected function prepareHTML($name, $close = false) {
		global $CONFIG;
		// компрессия, пока для debug=12
		//if($_GET['debug'] == 12)
		// обрежем админку, слишком много скриптов
		
		if($name == 'link' || $name == 'script')
		{
			//$nn = STreeMgr::GetNodeByID($CONFIG['env']['sectionid']);
			if((self::$use_optimizer === true || $_GET['debug'] == 12) && $CONFIG['env']['site']['domain'] != 'site.rugion.ru' && strpos($_SERVER['REQUEST_URI'], '/home') !== 0)
			{
				$this->CompressFiles($name);
			}
		}
		
		$result = '';
		if ( is_array($this->Tags[$name]) && sizeof($this->Tags[$name]) )
			foreach( $this->Tags[$name] as $data ) {
				$result .= "\n<{$name}";
				foreach($data as $k => $v) {
					if ($k != 'cdata') $result .= ' '.$k.'="'.addcslashes($v, '"').'"';
				}
				
				if ( $data['cdata'] )
					$result .= '>'.$data['cdata'].'</'.$name.'>';
				elseif ( $close )
					$result .= '></'.$name.'>';
				else
					$result .= ' />';
			}
		return $result;
	}
				
	function __get($name) {
		global $CONFIG;
		
		$name = strtolower($name);
		if ( is_array($this->Tags[$name]) && !is_array($this->Tags[$name][0]) )
			$this->Tags[$name] = array_unique($this->Tags[$name]);
		
		switch($name) {
			case 'title':
				if ( isset($this->Tags['title']) && is_array($this->Tags['title']) )
					return implode($this->Delim,$this->Tags['title']);
			break;
			case 'keywords':
				if ( isset($this->Tags['keywords']) && is_array($this->Tags['keywords']) )
					return implode(', ',$this->Tags['keywords']);
			break;
			case 'description':
				if ( isset($this->Tags['description']) && is_array($this->Tags['description']) )
					return implode(' ',$this->Tags['description']);
			break;
			case 'styles':
				return $this->Tags['link'];
			case 'head':				
				$title			= $this->Title;
				$keywords		= $this->keywords;
				$description	= $this->description;
				
				$this->Add('meta', array('name' => 'keywords', 'content' => $keywords));
				$this->Add('meta', array('name' => 'description', 'content' => $description));

				return $this->prepareHTML('meta').'<title>'.$title.'</title>'
							.$this->prepareHTML('link')
							.$this->prepareHTML('script', true);
			break;
			default:
				return $this->Tags[$name];
		}
	}
	
	function __set($name, $value) {
		$name = strtolower($name);
		
		switch($name) {
			case 'title':
			case 'keywords':
			case 'description':
				return $this->Tags[$name] = array($value);
			break;	
		}
		return null;
	}
}

?>
