<?php

/*****************************************
*
* Бизнес-логика курсов валют
*
* @author Овчинников Евгений
* @version 0.1
* @created xx-окт-2010
******************************************/

abstract class BL_modules_exchange
{
	protected $_db			= null;
	protected $_slave		= true;
	/**
	 * obj lib.redis
	 * @var lib_Redis
	 */
	protected $_redis		= null;
	protected $_tables		= array();
	protected $_use_cache	= true;

    /* Конструктор
     * Ноу комментс
	 */
	public function __construct()
	{
		$cfg_tables = dirname(__FILE__) . "/exchange/config/" . strtolower(get_class($this)) . "_tables.php";
		if (is_file($cfg_tables))
			$this->_tables = include $cfg_tables;

		$this->_redis = LibFactory::GetInstance('redis');
		$this->_redis->Init('exchange');
	}

	/* Инициализация класса
	 *
	 * @param array $params - массив параметров array('db' - имя базы данных, 'tables' - список таблиц, 'slave' - использовать slave, true/false)
	 */
	function Init($params = array())
	{
		if (isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);
		else
			$this->_db = DBFactory::GetInstance('exchange');

		if (isset($params['tables']) && is_array($params['tables']))
			$this->_tables = $params['tables'];

		if (isset($params['slave']) && $params['slave'] === true)
			$this->_slave = true;
		else if (isset($params['slave']) && $params['slave'] === false)
			$this->_slave = false;
	}

	/*
	 * Возвращает количество курсов по фильтру
	 *
	 * @param array $filter - список фильтров
	 * @return int
	 */
	public function getExchangeCurrencyCount($filter) {

		$sql = "SELECT COUNT(*) FROM ".$this->_tables['price_currency'];
		$sql.= " WHERE TRUE ";

		if (is_numeric($filter['currencyid']) && $filter['currencyid'] > 0)
			$sql.= " AND CurrencyID = ".(int) $filter['currencyid'];
		else if (is_array($filter['currencyid']) && sizeof($filter['currencyid'])) {
			foreach($filter['currencyid'] as &$id)
				$id = (int) $id;

			$sql.= " AND CurrencyID IN(".implode(',', $filter['currencyid']).")";
		}

		if (is_numeric($filter['date']) && $filter['date'] > 0) {
			$sql.= " AND `Date` = '".date('Y-m-d', $filter['date'])."'";
		} else if (is_numeric($filter['date_start']) && $filter['date_start'] > 0
			&& is_numeric($filter['date_end']) && $filter['date_end'] > 0) {
				$sql.= " AND `Date` BETWEEN '".date('Y-m-d', $filter['date_start'])."' AND '".date('Y-m-d', $filter['date_end'])."'";
		}

		if (is_numeric($filter['bankid']))
			$sql.= " AND BankID = ".(int) $filter['bankid'];

		if (false === ($res = $this->_db->query($sql)))
			return false;

		list($count) = $res->fetch_row();
		return $count;
	}

	/*
	 * Возвращает курсы по фильтру
	 *
	 * @param array $filter - список фильтров
	 * @return array
	 */
	public function getExchangeCurrency($filter) {

		if (!isset($filter['field']) || strtoupper($filter['field']) != 'DATE')
			$filter['field'] = 'Date';

		if (!isset($filter['dir']) || !in_array(strtoupper($filter['dir']), array('ASC', 'DESC')))
			$filter['dir'] = 'ASC';

		$sql = "SELECT * FROM ".$this->_tables['price_currency'];
		$sql.= " WHERE TRUE ";

		if (is_numeric($filter['currencyid']) && $filter['currencyid'] > 0)
			$sql.= " AND CurrencyID = ".(int) $filter['currencyid'];
		else if (is_array($filter['currencyid']) && sizeof($filter['currencyid'])) {
			foreach($filter['currencyid'] as &$id)
				$id = (int) $id;

			$sql.= " AND CurrencyID IN(".implode(',', $filter['currencyid']).")";
		}

		if (is_numeric($filter['date']) && $filter['date'] > 0) {
			$sql.= " AND `Date` = '".date('Y-m-d', $filter['date'])."'";
		} else if (is_numeric($filter['date_start']) && $filter['date_start'] > 0
			&& is_numeric($filter['date_end']) && $filter['date_end'] > 0) {
				$sql.= " AND `Date` BETWEEN '".date('Y-m-d', $filter['date_start'])."' AND '".date('Y-m-d', $filter['date_end'])."'";
		}

		if (is_numeric($filter['bankid']))
			$sql.= " AND BankID = ".(int) $filter['bankid'];

		$sql.= " ORDER by `".$filter['field']."` ".$filter['dir'];

		if (is_numeric($filter['limit']) && $filter['limit'] > 0) {
			$sql .= ' LIMIT ';
			if (is_numeric($filter['offset']) && $filter['offset'] > 0)
				$sql .= (int) $filter['offset'].', ';

			$sql .= (int) $filter['limit'];
		}

		if (false === ($res = $this->_db->query($sql)))
			return false;

		$list = array();
		while (false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		return $list;
	}

	public function cacheCurrencyListExists() {
		return $this->_redis->Exists('currency_list_' . $this->_tables['currency']);
	}
	
	/*
	 * Возвращает список валют
	 *
	 * @return array
	 */
	public function getCurrencyList() {
		
		$list = $this->_redis->Get('currency_list_' . $this->_tables['currency']);
		if ($list === null) {
			$sql = "SELECT * FROM ".$this->_tables['currency'];
	
			if (false === ($res = $this->_db->query($sql)))
				return false;
	
			$list = array();
			while (false != ($row = $res->fetch_assoc())) {
				$list[$row['ID']] = $row;
			}
			
			$this->_redis->set('currency_list_' . $this->_tables['currency'], serialize($list), 86400);
		} else
			$list = unserialize($list);

		return $list;
	}

	/*
	 * Возвращает список валют с запрошеными идентифкаторами
	 *
	 * @param array $ids - список идентификаторов валют
	 * @return array
	 */
	public function getCurrencyByID($ids = array()) {

		if (!is_array($ids))
			$ids = (array) $ids;

		$keys = array();
		foreach ($ids as $k => $id) {
			if (!is_numeric($id) || $id <= 0)
				continue ;

			$keys[$k] = 'currency_' . $this->_tables['currency'].'_'.$id;
		}

		if (empty($keys))
			return array();

		$keys = $this->_redis->MGet($keys);
		if (!is_array($keys) || empty($keys))
			return array();

		$result = array();
		foreach ($keys as $k => $v) {
			if ($v === null) {
				$currency = $this->_getCurrencyByID($ids[$k]);
				if (empty($currency))
					continue ;

				$result[$currency['ID']] = $currency;
				$this->_redis->set('currency_' . $this->_tables['currency'].'_'.$currency['ID'], serialize($currency), 86400);
			} else {
				$v = unserialize($v);
				if ($v !== null)
					$result[$v['ID']] = $v;
			}
		}

		return $result;
	}

	/*
	 * Возвращает список валют
	 *
	 * @param array $ids - список идентификаторов валют
	 * @return array
	 */
	protected function _getCurrencyByID($id) {

		$sql = "SELECT * FROM ".$this->_tables['currency'];
		$sql.= " WHERE ID = ".(int) $id;

		$currency = $this->_db->query($sql)->fetch_assoc();
		return $currency;
	}
	
	public function cacheCurrencyExists($cid) {
		return $this->_redis->Exists('currency_' . $this->_tables['currency'].'_'.$cid);
	}

	/*
	 * Добавить валюту
	 *
	 * @param array $data
	 * @return bool - false в случае неудачи
	 */
	public function addCurrency($data) {
		if (empty($data))
			return false;

		foreach($data as $k => $v)
			$data[$k] = "`$k` = '".addslashes($v)."'";
			
		$this->_db->query('START TRANSACTION');
			
		$sql = "INSERT INTO ".$this->_tables['currency']." SET ";
		$sql.= implode(',', $data);
		if ($this->_db->query($sql) !== false) {
			if ($this->cacheAddCurrency($this->_db->insert_id) === true) {
				$this->_db->query('COMMIT');
				return $this->_db->insert_id;
			}
		}

		$this->_db->query('ROLLBACK');
		return false;
	}	
	
	/*
	 * Удалить валюту
	 *
	 * @param int $cid
	 * @return bool - false в случае неудачи
	 */
	public function removeCurrency($cid) {
		if (!is_numeric($cid) || $cid <= 0)
			return false;
		
		if ($this->cacheRemoveCurrency($cid) === false)
			return false;
			
		return true;
	}
	
	/*
	 * Удалить валюту из хранилища БД
	 *
	 * @param int $cid
	 * @return bool - false в случае неудачи
	 */
	public function storageRemoveCurrency($cid) {
		if (!is_numeric($cid) || $cid <= 0)
			return false;

		$sql = "DELETE FROM ".$this->_tables['currency']." WHERE ";
		$sql.= " ID = ".(int) $cid;

		if ($this->_db->query($sql) === false)
			return false;

		return true;
	}
	
	/*
	 * Удалить валюту из хранилища redis
	 *
	 * @param int $cid
	 * @return bool - false в случае неудачи
	 */
	public function cacheRemoveCurrency($cid) {
		if (!is_numeric($cid) || $cid <= 0)
			return false;

		$this->_redis->Set('currency_' . $this->_tables['currency'].'_'.$cid, serialize(null), 86400);
		if (false === ($list = $this->getCurrencyList()))
			return false;
			
		unset($list[$cid]);		
		$this->_redis->Set('currency_list_' . $this->_tables['currency'], serialize($list), 86400);
		
		return true;
	}
	
	/*
	 * Добавить валюту в хранилище redis
	 *
	 * @param int $cid
	 * @return bool - false в случае неудачи
	 */
	public function cacheAddCurrency($cid) {
		if (!is_numeric($cid) || $cid <= 0)
			return false;

		if (false === ($list = $this->getCurrencyList()))
			return false;
			
		$currency = $this->_getCurrencyByID($cid);
		if (empty($currency))
			return false;
		
		$list[$cid] = $currency;
		
		$this->_redis->Set('currency_' . $this->_tables['currency'].'_'.$cid, serialize($currency), 86400);
		$this->_redis->Set('currency_list_' . $this->_tables['currency'], serialize($list), 86400);
		
		return true;
	}

	/*
	 * Сортирует список курсов валют по полям Order, Name банка которому принадлежат курсы
	 *
	 * @param array &$list
	 */
	public function sortExchangeList(&$list) {
		return uasort($list, array($this, '_sortExchangeList'));
	}

	/*
	 * sortExchangeList CallBack
	 *
	 * @param int
	 */
	protected function _sortExchangeList($a, $b) {
		if ($a['Order'] == $b['Order'])
			return strcasecmp($a['Name'], $b['Name']);;

		return $a['Order'] < $b['Order'] ? 1 : -1;
	}
}
