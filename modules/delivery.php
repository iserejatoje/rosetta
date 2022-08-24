<?
$error_code = 0;

LibFactory::GetStatic('application');
class Mod_Delivery extends ApplicationBaseMagic
{
	protected $_page = 'delivery';
	protected $_params = array();
	protected $_cache = null;
	protected $_db = null;
	protected $_type = null;
	protected $_skip = null;
	protected $_module_caching = true;

	protected $_cataloglink = null;

	protected $deliverymgr;

	public function __construct() {
		parent::__construct('delivery');
		LibFactory::GetStatic('ustring');
		LibFactory::GetMStatic('delivery', 'deliverymgr');

		$this->deliverymgr = DeliveryMgr::GetInstance();

	}

	function Init() {
		global $OBJECTS;

	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}

	public function &GetPropertyByRef($name)
	{
		return parent::GetPropertyByRef($name);
	}

	protected function _ActionGet()
	{
		global $OBJECTS, $CONFIG;

		return parent::_ActionGet();
	}

	protected function _ActionModRewrite(&$params)
	{
		global $OBJECTS;

		parent::_ActionModRewrite($params);
	}

}