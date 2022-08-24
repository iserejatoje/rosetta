<?
$error_code = 0;
define('ERR_M_NEWS_MASK', 0x00570000);


LibFactory::GetStatic('application');
class Mod_News extends ApplicationBaseMagic
{
	protected $_page = 'news';
	protected $_params = array();
	protected $_cache = null;
	protected $_db = null;
	protected $_type = null;
	protected $_skip = null;
	protected $_module_caching = true;

	protected $newsmgr;

	public function __construct() {
		parent::__construct('news');
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('ustring');
		LibFactory::GetMStatic('news', 'newsmgr');

		$this->newsmgr = NewsMgr::GetInstance();
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