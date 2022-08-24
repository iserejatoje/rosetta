<?


LibFactory::GetStatic('application');
class Mod_Page extends ApplicationBaseMagic
{
	protected $_page = 'main';
	protected $_db;
	protected $_params;
	protected $pagemgr;
	protected $_module_caching = true;
	
	
	public function __construct() {
		parent::__construct('page');
	}

	function Init() {
		global $OBJECTS;
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
		LibFactory::GetStatic('ustring');
		
		LibFactory::GetMStatic('page', 'pagemgr');
		$this->pagemgr = PageMgr::GetInstance();
	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}
}
