<?php

require_once($CONFIG['engine_path'] . 'include/bl/modules/exchange.php');

/*****************************************
 *
 * Бизнес-логика курсов валют ЦБ РФ
 *
 * @author Овчинников Евгений
 * @version 0.1
 * @created xx-окт-2010
 ******************************************/

class BL_modules_exchange_currency_cbrf extends BL_modules_exchange
{
	/*
	 * Проверяет доступность в кеше курсов валют
	 *
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return array
	 */
	public function cacheExchangeByDateExists($time)
	{
		return $this->_redis->Exists('by_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time));
	}

	/*
	 * Обновляет в кеше курсы валют
	 *
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateExchangeByDateCache($time)
	{
		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'by_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time);
		$result = $this->_getExchangeByDate($time);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}
	
	/*
	 * Возвращает курсы валют
	 *
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getExchangeByDate($time)
	{
		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'by_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time);

		$result = $this->_redis->get($cacheid);
		if ($this->_use_cache === false || $result === null)
		{
			$result = $this->_getExchangeByDate($time);
			$this->_redis->set($cacheid, serialize($result), 86400);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает курсы валют
	 *
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return array
	 */
	protected function _getExchangeByDate($time)
	{
		$sql = "SELECT * FROM " . $this->_tables['price_currency'];
		$sql .= " WHERE `Date` = '" . date('Y-m-d', $time) . "' ";

		$list = array();
		$res = $this->_db->query($sql);
		while (false != ($row = $res->fetch_assoc()))
		{
			$list[$row['CurrencyID']] = $row;
		}

		return $list;
	}

	/*
	 * Проверяет доступность в кеше последней даты за которую имеются курсы
	 *
	 * @return bool
	 */
	public function cacheLastDateExchangeExists()
	{
		return $this->_redis->Exists('last_date_cbrf_' . $this->_tables['price_currency']);
	}

	/*
	 * Обновляет в кеше последнюю дату за которую имеются курсы
	 *
	 * @return bool
	 */
	public function updateLastDateExchangeCache()
	{
		$cacheid = 'last_date_cbrf_' . $this->_tables['price_currency'];

		$result = $this->_getLastDateExchange();
		$this->_redis->set($cacheid, $result, 86400);

		return true;
	}

	/*
	 * Возвращает последнюю дату за которую имеются курсы
	 *
	 * @return int - Дата в формате timestamp
	 */
	public function getLastDateExchange()
	{
		$cacheid = 'last_date_cbrf_' . $this->_tables['price_currency'];

		$result = $this->_redis->get($cacheid);
		if ($this->_use_cache === false || $result === null)
		{
			$result = $this->_getLastDateExchange();
			$this->_redis->set($cacheid, $result, 86400);
		}

		return $result;
	}

	/*
	 * Возвращает последнюю дату за которую имеются курсы
	 *
	 * @return int - Дата в формате timestamp
	 */
	protected function _getLastDateExchange()
	{
		$sql = "SELECT Date FROM " . $this->_tables['price_currency'];
		$sql .= " ORDER by `Date` DESC LIMIT 1";

		$res = $this->_db->query($sql);

		list($date) = $res->fetch_row();
		return strtotime($date);
	}

	/*
	 * Проверяет доступность в кеше предыдущей даты за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return bool
	 */
	public function cachePrevDateExchangeExists($time)
	{
		return $this->_redis->Exists('prev_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time));
	}

	/*
	 * Обновляет в кеше предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updatePrevDateExchangeCache($time)
	{
		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'prev_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time);

		$result = $this->_getPrevDateExchange($time);
		$this->_redis->set($cacheid, $result, 10800);

		return true;
	}

	/*
	 * Возвращает предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return int - Дата в формате timestamp
	 */
	public function getPrevDateExchange($time)
	{
		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'prev_date_cbrf_' . $this->_tables['price_currency'] . '_' . date('Ymd', $time);

		$result = $this->_redis->get($cacheid);
		if ($this->_use_cache === false || $result === null)
		{
			$result = $this->_getPrevDateExchange($time);
			$this->_redis->set($cacheid, $result, 10800);
		}

		return $result;
	}

	/*
	 * Возвращает предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * 
	 * @return int - Дата в формате timestamp
	 */
	protected function _getPrevDateExchange($time)
	{
		$sql = "SELECT Date FROM " . $this->_tables['price_currency'];
		$sql .= " WHERE Date < '" . date('Y-m-d', $time) . "'";
		$sql .= " ORDER by `Date` DESC LIMIT 1";

		$res = $this->_db->query($sql);

		list($date) = $res->fetch_row();
		return strtotime($date);
	}

	/*
	 * Проверяет доступность курса валюты в кеше
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return bool
	 */
	public function cacheExchangeCurrencyByDateExists($cid, $time)
	{
		return $this->_redis->Exists('currency_by_date_' . $this->_tables['price_currency'] . '_' . $cid . '_' . date('Ymd', $time));
	}

	/*
	 * Обновляет курс валюты в кеше
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateExchangeCurrencyByDateCache($cid, $time)
	{
		if (!is_numeric($cid) || $cid <= 0)
			throw new InvalidArgumentBTException('Currency id specified"' . $cid . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $cid . '_' . date('Ymd', $time);
		$result = $this->_getExchangeCurrencyByDate($cid, $time);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}

	/*
	 * Возвращает курс валюты
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getExchangeCurrencyByDate($cid, $time)
	{
		if (!is_numeric($cid) || $cid <= 0)
			throw new InvalidArgumentBTException('Currency id specified"' . $cid . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $cid . '_' . date('Ymd', $time);

		$result = $this->_redis->get($cacheid);
		if ($this->_use_cache === false || $result === null)
		{
			$result = $this->_getExchangeCurrencyByDate($cid, $time);
			$this->_redis->set($cacheid, serialize($result), 86400);
		} else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает курс валюты
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return array
	 */
	protected function _getExchangeCurrencyByDate($cid, $time)
	{
		$sql = "SELECT * FROM " . $this->_tables['price_currency'];
		$sql .= " WHERE `CurrencyID` = " . (int) $cid;
		$sql .= " AND `Date` = '" . date('Y-m-d', $time) . "'";

		$res = $this->_db->query($sql);
		return $res->fetch_assoc();
	}

	/*
	 * Сохранение курсов валют
	 *
	 * @param array $data - Данные для сохранение в базу
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function setCurrencyPrice(array $data)
	{
		if (empty($data))
			return false;

		$data = array_change_key_case($data, CASE_LOWER);

		if (!is_numeric($data['currencyid']) || $data['currencyid'] <= 0)
			throw new InvalidArgumentBTException('Currency id specified "' . $data['currencyid'] . '" is not valid.');

		$time = strtotime($data['date']);
		if (empty($data['date']) || $time <= 0)
			throw new InvalidArgumentBTException('Date specified "' . $data['date'] . '" is not valid.');

		EventMgr::Raise('bl/modules/exchange/currency_cbrf/price/set', array(
			'data'	 => $data,
		));

		return true;
	}

	/*
	 * Сохранение курсов валют в БД
	 *
	 * @param array $data - Данные для сохранение в базу
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function storageSetCurrencyPrice($data)
	{
		if (empty($data))
			return true;

		if (!is_numeric($data['currencyid']) || $data['currencyid'] <= 0)
			throw new InvalidArgumentBTException('Currency id specified "' . $data['currencyid'] . '" is not valid.');

		$time = strtotime($data['date']);
		if (empty($data['date']) || $time <= 0)
			throw new InvalidArgumentBTException('Date specified "' . $data['date'] . '" is not valid.');

		foreach ($data as $k => $v)
			$data[$k] = "`$k` = '" . addslashes($v) . "'";

		$sql = "REPLACE INTO " . $this->_tables['price_currency'] . " SET ";
		$sql .= implode(',', $data);
		return $this->_db->query($sql);
	}

	/*
	 * Добавить валюту
	 *
	 * @param array $data
	 * @return bool
	 */
	public function addCurrency($data)
	{
		if (($cid = parent::addCurrency($data)) === false)
			return false;

		EventMgr::Raise('bl/modules/exchange/currency_cbrf/add', array(
			'currencyid' => $cid,
		));

		return true;
	}

	/*
	 * Удалить валюту
	 *
	 * @param int $cid
	 * @return bool
	 */
	public function removeCurrency($cid)
	{
		if (parent::removeCurrency($cid) === false)
			return false;

		EventMgr::Raise('bl/modules/exchange/currency_cbrf/remove', array(
			'currencyid' => $cid,
		));

		return true;
	}
}
