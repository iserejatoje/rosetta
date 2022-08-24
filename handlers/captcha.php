<?

/**
 * Хендлер для работы с модулями
 * @package Handlers
 */
class Handler_captcha extends IHandler
{
	private $_params;

	public function Init($params)
	{
	//print_r($params);
		$this->_params = $params['params'];
	}
	
	public function IsLast()
	{
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS;
		$cp = LibFactory::GetInstance('captcha');
		
		Response::NoCache();		
		header("Content-type: image/png");

		$code = $cp->get_code($this->_params['key']);

		$img = $cp->get_image($code);
		
		imagepng($img);
		imagedestroy($img);
	}
	
	public function Dispose()
	{
	}
}
?>