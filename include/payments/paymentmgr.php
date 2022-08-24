<?
require_once (ENGINE_PATH.'include/payments/payment.php');
require_once (ENGINE_PATH.'include/payments/account.php');

spl_autoload_register(function ($class_name)
{
	// echo ENGINE_PATH.'include/payments/'.mb_strtolower($class_name).'.php'; exit;
	if (file_exists(ENGINE_PATH.'include/payments/'.$class_name . '.php'))
	{
		include_once(ENGINE_PATH.'include/payments/'.mb_strtolower($class_name).'.php');
		return true;
	}
	// error_log("Class file not found: ".ENGINE_PATH.'include/payments/'.$class_name . '.php');
	return false;

});

class PaymentMgr
{
	private $_Payments = array();
	private $_Accounts = array();

	public $_db			= null;
	public $_tables		= array(
		'payments' => 'payments',
		'payment_vals' => 'payment_field_values',
		'accounts' => 'payment_accounts',
	);

	private $_cache		= null;

	public static $PM_SKEY = 'JKaa8a2Ljgalgh';

	public static $params = [
		'mnt_currency_code' => [
			'type' => 'single',
			'values' => [
				'RUB' => 'RUB',
				'USD' => 'USD',
				'EUR' => 'EUR',
			],
		],

		'mnt_test_mode' => [
			'type' => 'single',
			'values' => [
				0 => 'рабочий режим',
				1 => 'тестовый режим',
			],
		],

		'paymentsystemunitid' => [
			'type' => 'single',
			'values' => [
                2243990 => 'VISA, MasterCard, МИP',
				1015 => 'Монетка.Ру',
				1020 => 'Яндекс.Деньги',
				1017 => 'WebMoney',
				822360 => 'Qiwi Кошелек',
				1087645 => 'Alipay',
			]
		],

		'paymentsystemlimitids' => [
			'type' => 'multiple',
			'values' => [
				1015 => 'Монетка.Ру',
				1020 => 'Яндекс.Деньги',
				1017 => 'WebMoney',
				822360 => 'Qiwi Кошелек',
				1087645 => 'Alipay',
			]
		],

	];

	public function __construct()
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$this->_db = DBFactory::GetInstance('gilmon');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_CITIES_CANT_CONNECT_TODB', ERR_L_CITIES_CANT_CONNECT_TODB);

		$this->_cache = $this->getCache();
	}

	public function getCache()
	{
		LibFactory::GetStatic('cache');

		$cache = new Cache();
		$cache->Init('memcache', 'paymentmgr');

		return $cache;
	}

	static function &getInstance ()
	{
		static $instance;

		if (!isset($instance)) {
			$cl = __CLASS__;
			$instance = new $cl();
		}

		return $instance;
	}

	private function _paymentObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$pm = new Payment($info);
		if (isset($info['PaymentID']))
			$this->_Payments[ $info['PaymentID'] ] = $pm;

		return $pm;
	}

	public function AddPayment(array $info)
	{
		unset($info['PaymentID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "INSERT INTO ".$this->_tables['payments']." SET ".implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	public function RemovePayment($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$filter = array(
			'flags' => array(
				'objects' => true,
				'PaymentID' => $id,
			),
			'dbg' => 1,
		);
		$accounts = $this->GetAccounts($filter);

		if(is_array($accounts) && sizeof($accounts) > 0)
		{
			foreach($accounts as $account)
				$account->Remove();
		}

		$sql = "DELETE FROM ".$this->_tables['payments']." WHERE PaymentID = ".$id;

		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('payment_'.$id);

			unset($this->_Payments[$id]);
			return true;
		}

		return false;
	}

	public function UpdatePayment(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['PaymentID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "UPDATE ".$this->_tables['payments']." SET ".implode(', ', $fields);
		$sql.= " WHERE PaymentID = ".$info['PaymentID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('payment_'.$info['PaymentID']);

			return true;
		}

		return false;
	}

	public function GetPayment($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_Payments[$id]) )
			return $this->_Payments[$id];

		$info = false;

		$cacheid = 'payment_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = "SELECT * FROM ".$this->_tables['payments']." WHERE PaymentID = ".$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$rk = $this->_paymentObject($info);
		return $rk;
	}

	public function GetPayments($filter)
	{
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Ord')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Name');
			$filter['dir'] = array('ASC');
		}

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
		else
			$sql = 'SELECT * ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['payments'].' ';

		$where = array();

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['payments'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['payments'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
			$group = array();
			foreach($filter['group']['fields'] as $v) {
				$group[] = ' '.$this->_tables['payments'].'.`'.$v.'`';
			}

			$sql .= ' GROUP by '.implode(', ', $group);
		}

		if (isset($filter['having']) && $filter['having'])
			$sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

		$sql.= ' ORDER by ';

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		if($filter['dbg'])
			echo $sql;

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $this->_db->query($sql)->fetch_row();
		}

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ($filter['flags']['objects'] === true)
			{
				if ( isset($this->_Payments[$row['PaymentID']]) )
					$row = $this->_Payments[$row['PaymentID']];
				else
					$row = $this->_paymentObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	// ==================================================================

	private function _accountObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);
		$pm = $this->GetPayment($info['paymentid']);
		$cls = $pm->NameID;

		if(class_exists($cls))
			$account = new $cls($info);
		else
			$account = new Account($info);

		// if (isset($info['AccountID']))
		// 	$this->_Accounts[ $info['AccountID'] ] = $account;

		return $account;
	}

	public function AddAccount(array $info)
	{
		unset($info['AccountID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			if($k == 'Fields')
				$fields[] = "`$k` = AES_ENCRYPT('".addslashes($v)."', '".self::$PM_SKEY."')";
			else
				$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "INSERT INTO ".$this->_tables['accounts']." SET ".implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	public function RemoveAccount($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$sql = "DELETE FROM ".$this->_tables['accounts']." WHERE AccountID = ".$id;

		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('account_'.$id);

			unset($this->_Accounts[$id]);
			return true;
		}

		return false;
	}

	public function UpdateAccount(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['AccountID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			if($k == 'Fields')
				$fields[] = "`$k` = AES_ENCRYPT('".addslashes($v)."', '".self::$PM_SKEY."')";
			else
				$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "UPDATE ".$this->_tables['accounts']." SET ".implode(', ', $fields);
		$sql.= " WHERE AccountID = ".$info['AccountID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('account_'.$info['AccountID']);

			return true;
		}

		return false;
	}

	public function GetAccount($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_Accounts[$id]) )
			return $this->_Accounts[$id];

		$info = false;

		$cacheid = 'account_'.$id;

		// if ($this->_cache !== null)
		// 	$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = "SELECT AccountID, PaymentID, Name, AES_DECRYPT(Fields, '".self::$PM_SKEY."') as Fields";
			$sql .= " FROM ".$this->_tables['accounts']." WHERE AccountID = ".$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$account = $this->_accountObject($info);
		return $account;
	}

	// public function GetAccountByNameID($nameid)
	// {
	// 	$nameid = mb_strtolower($nameid);
	// 	if (mb_strlen($nameid) == 0)
	// 		return null;

	// 	if ( isset($this->_Accounts[$nameid]) )
	// 		return $this->_Accounts[$nameid];

	// 	$info = false;
	// 	$cacheid = 'account_'.$nameid;

	// 	if ($this->_cache !== null)
	// 		$info = $this->_cache->get($cacheid);

	// 	if ($_GET['nocache']>12)
	// 		$info = false;

	// 	if ($info === false)
	// 	{
	// 		$sql  = "SELECT AccountID, PaymentID, Name, AES_DECRYPT(Fields, '".self::$PM_SKEY."') as Fields";
	// 		$sql .= " FROM ".$this->_tables['accounts']." WHERE NameID = ".$nameid;

	// 		if (false === ($res = $this->_db->query($sql)))
	// 			return null;

	// 		if (!$res->num_rows )
	// 			return null;

	// 		$info = $res->fetch_assoc();
	// 		if ($this->_cache !== null)
	// 			$this->_cache->set($cacheid, $info, 3600 * 24);
	// 	}

	// 	$account = $this->_accountObject($info);
	// 	return $account;
	// }

	public function GetAccounts($filter)
	{
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Ord')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Name');
			$filter['dir'] = array('ASC');
		}

		if ( isset($filter['flags']['PaymentID']) && $filter['flags']['PaymentID'] != -1 )
			$filter['flags']['PaymentID'] = (int) $filter['flags']['PaymentID'];
		elseif (!isset($filter['flags']['PaymentID']))
			$filter['flags']['PaymentID'] = -1;

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS AccountID, PaymentID, Name, AES_DECRYPT(Fields, "'.self::$PM_SKEY.'") as Fields ';
		else
			$sql = 'SELECT AccountID, PaymentID, Name, AES_DECRYPT(Fields, "'.self::$PM_SKEY.'") as Fields ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['accounts'].' ';

		$where = array();

		if ( $filter['flags']['PaymentID'] != -1 )
			$where[] = ' '.$this->_tables['accounts'].'.PaymentID = '.$filter['flags']['PaymentID'];

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['accounts'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['accounts'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
			$group = array();
			foreach($filter['group']['fields'] as $v) {
				$group[] = ' '.$this->_tables['accounts'].'.`'.$v.'`';
			}

			$sql .= ' GROUP by '.implode(', ', $group);
		}

		if (isset($filter['having']) && $filter['having'])
			$sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

		$sql.= ' ORDER by ';

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' `'.$filter['field'][$k].'` '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		if($filter['dbg'])
			echo $sql;

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $this->_db->query($sql)->fetch_row();
		}

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ($filter['flags']['objects'] === true)
			{
				if ( isset($this->_Accounts[$row['AccountID']]) )
					$row = $this->_Accounts[$row['AccountID']];
				else
					$row = $this->_accountObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	public function GetDefaultAcc()
	{
		$filter = array(
			'flags' => array(
				'objects' => true,
			),
			'dbg' => 0,
		);

        $accounts = $this->GetAccounts($filter);

		if($accounts)
			return $accounts[0];
		else
			return false;
	}

	public function GetPaymentTypes()
	{
		LibFactory::GetStatic('bl');
		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'payments');

		$types = [];
		foreach($config['payment_types'] as $k => $item) {
			if($item['enabled'] == 0)
				continue;

			$list = [];
			foreach($item['list'] as $code => $type) {
				if($type['enabled'] == 0)
					continue;

				$list[$code]['name'] = $type['name'];
				$list[$code]['class'] = $type['class'];
				$list[$code]['haslabel'] = $type['haslabel'];

				$types[$k]['name'] = $item['name'];
				$types[$k]['class'] = $item['class'];
				$types[$k]['nofolding'] = $item['nofolding'];
				$types[$k]['list'] = $list;
			}
		}

		return $types;
	}

	public function Dispose()
	{

	}
}
?>
