<?

/**
 * Хендлер для работы с доменами третьего уровня
 * @package Handlers
 */
class Handler_domain extends IHandler
{
	private $_params		= array();
	private $uri			= '/service/domain/';

	public function Init($params)
	{
		$this->_params = $params;
	}
	
	public function IsLast()
	{
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS, $CONFIG;

		// отрезаем путь хендлера
		$addr = $_SERVER['REQUEST_URI'];
		$pos = strpos($addr, $this->uri);
		if( $pos === false )
		{
			$this->_wrong_domain();
			return false;
		}
		$addr = substr($addr, strlen($this->uri) + $pos);

		$path_info = parse_url($addr);
		$addr = $path_info['path'];
		// находим состояние
		if( preg_match('@^resolve/([^\/]+)/(.*)$@', $addr, $rg) )
		{
			$query_array = array(
				'path'		=> $rg[2],
				'query'		=> $path_info['query'],
			);
			$this->_resolve($rg[1], $query_array);
		}
		$this->_wrong_domain();
	}
	
	private function _resolve($domain, $query_array = array())
	{
		$url = '';
		LibFactory::GetStatic('domain');
		$url = Domain::Resolve($domain);
		if( $url === false )
		{
			$this->_wrong_domain();
			return false;
		}
		
		if(isset($query_array['query']))
		{
			if( strpos($url, '?') !== false )
			{
				$url.= '&'.$query_array['query'];
			}
			else
			{
				$url.= $query_array['query']. '?'.$query_array['query'];
			}
		}
		Response::Redirect($url);
	}
	
	private function _wrong_domain()
	{
		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}
	
	public function Dispose()
	{
		return true;
	}
}
?>