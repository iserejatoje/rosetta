<?

static $empty_error_code = 0;
define('ERR_M_EMPTY_MASK', 0x00230000);
define('ERR_M_EMPTY_UNKNOWN_ERROR', ERR_M_EMPTY_MASK | $empty_error_code++);
$ERROR[ERR_M_EMPTY_UNKNOWN_ERROR]
	= 'Незвестная ошибка';

LibFactory::GetStatic('application');
class Mod_Empty extends ApplicationBaseMagic
{
	protected $_params;
	protected $_result = array();
	protected $_err;

	public function __construct()
	{	
		parent::__construct('empty');
		
	}
	
	function Init()
	{		
		global $CONFIG;
		
	}
	
	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}
	
	function Action($params)
	{	
		$this->_ActionMod($params);
	}

	
	protected function _ActionMod(&$params)
	{
		global $CONFIG;
		$this->_params['res'] = null;
		LibFactory::GetStatic('filestore');
 
		if(isset($this->_config['program']))
		{
			// отменили проверку, т.к. относительные пути проверить не удается.
			ob_start();
			@include($this->_config['program']);
			$this->_params['res'] = ob_get_contents();
			ob_end_clean();
		}
	}
	
	
	protected function _ActionPost()
	{
	}

	protected function _ActionGet()
	{
		if($this->_params['res'] === null )
			return "";
		else
			return $this->_params['res'];
	}

	

}
?>