<?php

static $error_code = 1;
define('ERR_M_POLL_MASK', 0x00420000);

define('ERR_M_POLL_SECOND_VOTE', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_SECOND_VOTE] 
	= 'Вы уже голосовали сегодня.';

define('ERR_M_POLL_WRONG_ANSWERS_COUNT', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_WRONG_ANSWERS_COUNT] 
	= 'Вы указали неверное число ответов.';	
	
define('ERR_M_POLL_ANSWER_NOT_SET', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_ANSWER_NOT_SET] 
	= 'Вы не указали ответ.';	

define('ERR_M_POLL_WRONG_CAPTCHA', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_WRONG_CAPTCHA] 
	= 'Вы неправильно ввели защитный код.';

define('ERR_M_POLL_SECTION_IS_CLOSED', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_SECTION_IS_CLOSED] 
	= 'Запрошенный вами раздел закрыт для голосования.';

define('ERR_M_POLL_NOT_FOUND', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_NOT_FOUND]
	= 'Опрос не найден.';

define('ERR_M_POLL_GROUP_NAME_EMPTY', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_GROUP_NAME_EMPTY]
	= 'Необходимо указать название группы.';
	
define('ERR_M_POLL_GROUP_SECTION_LIST_EMPTY', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_GROUP_SECTION_LIST_EMPTY]
	= 'Необходимо выбрать хотя бы один раздел.';
	
define('ERR_M_POLL_GROUP_NAME_EXISTS', ERR_M_POLL_MASK | $error_code++);
UserError::$Errors[ERR_M_POLL_GROUP_NAME_EXISTS]
	= 'Указанное вами имя группы уже существует.';


LibFactory::GetStatic('application');
class Mod_Poll extends ApplicationBaseMagic {
	protected $_page = 'main';
	protected $_db;
	protected $_params;
	protected $_result = array();
	protected $_RefID;
	protected $captcha;
	
	protected $_module_caching = true;
	
	public function __construct() {
		parent::__construct('poll');
	}
	
	function Init() {
		global $OBJECTS;

		LibFactory::GetStatic('arrays');
		LibFactory::GetStatic('data');
		$this->_db = DBFactory::GetInstance($this->_config['db']);
	}	
	
	public function AppInit($params) {
		global $OBJECTS, $CONFIG;
	}	
	
	public function &GetPropertyByRef($name) {
		return parent::GetPropertyByRef($name);
	}
	
	protected function CheckDetailsAccess($PollId, $UseCookies) {
		global $OBJECTS;
		
		if (($uid = Request::GetUID()) == '')
			return false;
		
		$ip = getenv('REMOTE_ADDR');
		if (empty($ip))
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		
		$sql = 'SELECT count(*)';
		$sql.= ' FROM '.$this->_config['tables']['hosts'];
		$sql.= ' WHERE PollId = '.$PollId;		
		
		if($OBJECTS['user']->IsAuth())
			//чтобы не было многих регистраций от одного компа, лазейка была
			$sql.= ' AND (UserId = '.$OBJECTS['user']->ID.' OR Cookies = \''.addslashes($uid).'\')';
		else if($UseCookies)
			$sql.= ' AND Cookies = \''.addslashes($uid).'\'';
		else
			$sql.= ' AND ip = \''.addslashes($ip).'\'';
			
		$sql.= ' AND Date >= CURRENT_DATE()';

		$res = $this->_db->query($sql);
		if (false == ($row = $res->fetch_row()) || $row[0] > 0)
			return false;

		return true;
	}
}