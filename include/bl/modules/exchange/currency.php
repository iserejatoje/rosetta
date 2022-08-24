<?php

require_once($CONFIG['engine_path'] . 'include/bl/modules/exchange.php');

/*****************************************
 *
 * Бизнес-логика курсов валют
 *
 * @author Овчинников Евгений
 * @version 0.1
 * @created xx-окт-2010
 ******************************************/

class BL_modules_exchange_currency extends BL_modules_exchange
{
	/*
	 * Возвращает курсы валют
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getExchangeByDate($time, $citycode)
	{
		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time "' . $time . '" is not valid.');

		if (empty($citycode))
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is empty.');

		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		$result = $this->getBanksByCityCode($citycode, 1);

		$this->sortExchangeList($result);
		return $this->_prepareExchangeByDate($result, $time);
	}

	protected function _prepareExchangeByDate(array $list, $time)
	{
		$curArr = $this->getCurrencyList();
		if (empty($curArr) || empty($list))
			return $list;

		$mget = array();
		foreach ($list as $bid => $v)
		{
			$list[$bid]['PriceList'] = array();

			foreach ($curArr as $k => $v)
			{
				$mget[] = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $bid . '_' . $k . '_' . date('Ymd', $time);
				$list[$bid]['PriceList'][$k] = sizeof($mget) - 1;
			}
		}

		if (empty($mget))
			return $list;

		$mget = $this->_redis->MGet($mget);
		foreach ($list as $bid => $v)
		{
			foreach ($v['PriceList'] as $cid => $k)
			{
				if ($mget[$k] !== null)
				{
					$mget[$k] = unserialize($mget[$k]);
					if ($mget[$k] !== null)
					{
						$list[$bid]['PriceList'][$cid] = array(
							'Sell'	 => $mget[$k]['Sell'],
							'Buy'	 => $mget[$k]['Buy'],
						);
					}
					else
						unset($list[$bid]['PriceList'][$cid]);
				}
				else
				{
					$currency = $this->getExchangeCurrencyByDate($cid, $bid, $time);
					if ($currency !== null)
						$list[$bid]['PriceList'][$cid] = array(
							'Sell'	 => $currency['Sell'],
							'Buy'	 => $currency['Buy'],
						);
					else
						unset($list[$bid]['PriceList'][$cid]);
				}
			}

			if (empty($list[$bid]['PriceList']))
				unset($list[$bid]);
		}

		return $list;
	}

	/*
	 * Возвращает курсы валют
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 *
	 * @return array
	 */
	protected function _getExchangeByDate($time, $citycode)
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'] . " as b ";
		$sql .= " INNER JOIN " . $this->_tables['price_currency'] . " as c ON(c.`BankID` = b.ID) ";
		$sql .= " WHERE b.`CityCode` = '" . addslashes($citycode) . "' ";
		$sql .= " AND b.`isVisible` = 1 ";
		$sql .= " AND c.`Date` = '" . date('Y-m-d', $time) . "' ";
		$sql .= " ORDER by b.`Order` DESC ";

		$list = array();
		$res = $this->_db->query($sql);
		while (false != ($row = $res->fetch_assoc()))
		{
			if (!isset($list[$row['BankID']]))
			{
				$list[$row['BankID']] = array(
					'BankID'	 => $row['BankID'],
					'Name'		 => $row['Name'],
					'CityCode'	 => $row['CityCode'],
					'Address'	 => $row['Address'],
					'Phone'		 => $row['Phone'],
					'UserID'	 => $row['UserID'],
					'PlaceID'	 => $row['PlaceID'],
					'isVisible'	 => $row['isVisible'],
					'Url'		 => $row['Url'],
					'XmlUrl'	 => $row['XmlUrl'],
					'Order'		 => $row['Order'],
					'PriceList'	 => array(),
				);
			}

			$list[$row['BankID']]['PriceList'][$row['CurrencyID']] = array(
				'Sell'	 => $row['Sell'],
				'Buy'	 => $row['Buy'],
			);
		}

		$this->sortExchangeList($list);
		return $list;
	}

	/*
	 * Проверяет доступность в кеше курс валюты банка
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $bid - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return bool
	 */
	public function cacheExchangeCurrencyByDateExists($cid, $bid, $time)
	{
		return $this->_redis->Exists('currency_by_date_' . $this->_tables['price_currency'] . '_' . $bid . '_' . $cid . '_' . date('Ymd', $time));
	}

	/*
	 * Обновляет в кеше курс валюты банка
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $bid - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateExchangeCurrencyByDateCache($cid, $bid, $time)
	{
		if (!is_numeric($bid) || $bid <= 0)
			throw new InvalidArgumentBTException('Bank id specified"' . $bid . '" is not valid.');

		if (!is_numeric($cid) || $cid <= 0)
			throw new InvalidArgumentBTException('Currency id specified"' . $cid . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $bid . '_' . $cid . '_' . date('Ymd', $time);

		$result = $this->_getExchangeCurrencyByDate($cid, $bid, $time);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}

	/*
	 * Возвращает курс валюты банка
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $bid - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getExchangeCurrencyByDate($cid, $bid, $time)
	{
		if (!is_numeric($bid) || $bid <= 0)
			throw new InvalidArgumentBTException('Bank id specified"' . $bid . '" is not valid.');

		if (!is_numeric($cid) || $cid <= 0)
			throw new InvalidArgumentBTException('Currency id specified"' . $cid . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $bid . '_' . $cid . '_' . date('Ymd', $time);
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getExchangeCurrencyByDate($cid, $bid, $time);
			$this->_redis->set($cacheid, serialize($result), 86400);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает курс валюты банка
	 *
	 * @param int $cid - Идентификатор валюты
	 * @param int $bid - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return array
	 */
	protected function _getExchangeCurrencyByDate($cid, $bid, $time)
	{
		$sql = "SELECT * FROM " . $this->_tables['price_currency'];
		$sql .= " WHERE `BankID` = " . (int) $bid;
		$sql .= " AND `CurrencyID` = " . (int) $cid;
		$sql .= " AND `Date` = '" . date('Y-m-d', $time) . "'";

		$res = $this->_db->query($sql);
		return $res->fetch_assoc();
	}

	/*
	 * Проверяет в кеше курсы валют банка
	 *
	 * @param int $id - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return bool
	 */
	public function cacheBankExchangeByDateExsists($id, $time)
	{
		return $this->_redis->Exists('bank_by_date_' . $this->_tables['price_currency'] . '_' . $id . '_' . date('Ymd', $time));
	}
	
	/*
	 * Обновляет в кеше курсы валют банка
	 *
	 * @param int $id - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateBankExchangeByDateCache($id, $time)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time "' . $time . '" is not valid.');

		$cacheid = 'bank_by_date_' . $this->_tables['price_currency'] . '_' . $id . '_' . date('Ymd', $time);

		$result = $this->_getBankExchangeByDate($id, $time);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}
	
	/*
	 * Возвращает курсы валют банка
	 *
	 * @param int $id - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getBankExchangeByDate($id, $time)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time "' . $time . '" is not valid.');

		$cacheid = 'bank_by_date_' . $this->_tables['price_currency'] . '_' . $id . '_' . date('Ymd', $time);
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getBankExchangeByDate($id, $time);
			$this->_redis->set($cacheid, serialize($result), 86400);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает курсы валют банка
	 *
	 * @param int $id - Идентификатор банка
	 * @param int $time - Дата в формате timestamp
	 *
	 * @return array
	 */
	protected function _getBankExchangeByDate($id, $time)
	{
		$sql = "SELECT * FROM " . $this->_tables['price_currency'];
		$sql .= " WHERE `Date` = '" . date('Y-m-d', $time) . "'";
		$sql .= " AND BankID = " . (int) $id;

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
	 * @param string $citycode - CityCode города
	 *
	 * @return bool
	 */
	public function cacheLastDateExchangeExists($citycode)
	{
		return $this->_redis->Exists('last_date_' . $this->_tables['banks'] . '_' . $this->_tables['price_currency'] . '_' . $citycode);
	}

	/*
	 * Обновляет в кеше последнюю дату за которую имеются курсы
	 *
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateLastDateExchangeCache($citycode)
	{
		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		$cacheid = 'last_date_' . $this->_tables['banks'] . '_' . $this->_tables['price_currency'] . '_' . $citycode;

		$result = $this->_getLastDateExchange($citycode);
		$this->_redis->set($cacheid, $result, 86400);

		return true;
	}

	/*
	 * Возвращает последнюю дату за которую имеются курсы
	 *
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return int - Дата в формате timestamp
	 */
	public function getLastDateExchange($citycode)
	{
		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		$cacheid = 'last_date_' . $this->_tables['banks'] . '_' . $this->_tables['price_currency'] . '_' . $citycode;
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getLastDateExchange($citycode);
			$this->_redis->set($cacheid, $result, 86400);
		}

		return $result;
	}

	/*
	 * Возвращает последнюю дату за которую имеются курсы
	 *
	 * @param string $citycode - CityCode города
	 *
	 * @return int - Дата в формате timestamp
	 */
	protected function _getLastDateExchange($citycode)
	{
		$sql = "SELECT MAX(c.Date) FROM " . $this->_tables['banks'] . " as b ";
		$sql .= " INNER JOIN " . $this->_tables['price_currency'] . " as c ON(c.`BankID` = b.ID) ";
		$sql .= " WHERE b.`CityCode` = '" . addslashes($citycode) . "' ";
		$sql .= " AND b.`isVisible` = 1 ";

		$res = $this->_db->query($sql);

		list($date) = $res->fetch_row();
		return strtotime($date);
	}

	/*
	 * Проверяет в кеше предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function cachePrevDateExchangeExists($time, $citycode)
	{
		return $this->_redis->Exists('prev_date_' . $this->_tables['price_currency'] . '_' . $citycode . '_' . date('Ymd', $time));
	}

	/*
	 * Обновляет в кеше предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updatePrevDateExchangeCache($time, $citycode)
	{
		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'prev_date_' . $this->_tables['price_currency'] . '_' . $citycode . '_' . date('Ymd', $time);

		$result = $this->_getPrevDateExchange($time, $citycode);
		$this->_redis->set($cacheid, $result, 10800);

		return true;
	}

	/*
	 * Возвращает предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 * @throws InvalidArgumentBTException
	 *
	 * @return int - Дата в формате timestamp
	 */
	public function getPrevDateExchange($time, $citycode)
	{
		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		if (!is_numeric($time) || $time <= 0)
			throw new InvalidArgumentBTException('Time specified "' . $time . '" is not valid.');

		$cacheid = 'prev_date_' . $this->_tables['price_currency'] . '_' . $citycode . '_' . date('Ymd', $time);
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getPrevDateExchange($time, $citycode);
			$this->_redis->set($cacheid, $result, 10800);
		}

		return $result;
	}

	/*
	 * Возвращает предыдущую дату за которую имеются курсы
	 *
	 * @param int $time - Дата в формате timestamp
	 * @param string $citycode - CityCode города
	 *
	 * @return int - Дата в формате timestamp
	 */
	protected function _getPrevDateExchange($time, $citycode)
	{
		$sql = "SELECT MAX(c.Date) FROM " . $this->_tables['banks'] . " as b ";
		$sql .= " INNER JOIN " . $this->_tables['price_currency'] . " as c ON(c.`BankID` = b.ID) ";
		$sql .= " WHERE b.`CityCode` = '" . addslashes($citycode) . "' ";
		$sql .= " AND b.`isVisible` = 1 ";
		$sql .= " AND Date < '" . date('Y-m-d', $time) . "'";

		$res = $this->_db->query($sql);

		list($date) = $res->fetch_row();
		return strtotime($date);
	}

	/*
	 * Возвращает список ссылок для импорта курсов
	 *
	 * @param int $limit - Количество ссылок
	 * @param int $offset - Смещение
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getImportUrls($limit = 10, $offset = 0)
	{
		if (!is_numeric($limit) || $limit < 0)
			throw new InvalidArgumentBTException('Limit specified "' . $limit . '" is not valid.');

		if (!is_numeric($offset) || $offset < 0)
			throw new InvalidArgumentBTException('Offset specified "' . $offset . '" is not valid.');

		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE `XmlUrl` != ''";

		if ($limit)
		{
			if ($offset)
				$sql .= " LIMIT " . $offset . ", " . $limit;
			else
				$sql .= " LIMIT " . $limit;
		}

		$list = array();
		$res = $this->_db->query($sql);
		while (false != ($row = $res->fetch_assoc()))
		{
			$list[] = $row;
		}

		return $list;
	}

	/*
	 * Сохранение курсов валют
	 *
	 * @param array $data - Данные для сохранение в базу
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function setCurrencyPrice(array $data)
	{
		if (empty($data))
			return false;

		$data = array_change_key_case($data, CASE_LOWER);
		if (!is_numeric($data['bankid']) || $data['bankid'] <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $data['bankid'] . '" is not valid.');

		if (!is_numeric($data['currencyid']) || $data['currencyid'] <= 0)
			throw new InvalidArgumentBTException('Currency id specified "' . $data['currencyid'] . '" is not valid.');

		$time = strtotime($data['date']);
		if (empty($data['date']) || $time <= 0)
			throw new InvalidArgumentBTException('Date specified "' . $data['date'] . '" is not valid.');

		$bank = $this->getBank($data['bankid']);
		if (empty($bank))
			throw new InvalidArgumentBTException('Bank "' . $data['bankid'] . '" not found.');

		$data = array(
			'BankID'	 => $data['bankid'],
			'CurrencyID' => $data['currencyid'],
			'Sell'		 => $data['sell'],
			'Buy'		 => $data['buy'],
			'Date'		 => $data['date'],
		);

		$cacheid = 'currency_by_date_' . $this->_tables['price_currency'] . '_' . $data['BankID'] . '_' . $data['CurrencyID'] . '_' . date('Ymd', $time);
		$this->_redis->set($cacheid, serialize($data), 86400);

		$list = $this->getBankExchangeByDate($data['BankID'], $time);
		$list[$data['CurrencyID']] = $data;
		
		$this->_redis->set('bank_by_date_' . $this->_tables['price_currency'] . '_' . $data['BankID'] . '_' . date('Ymd', $time), serialize($list), 86400);
		
		$lastdate = $this->getLastDateExchange($bank['CityCode']);
		if ($lastdate === null || $lastdate < $time)
		{
			$cacheid = 'last_date_' . $this->_tables['banks'] . '_' . $this->_tables['price_currency'] . '_' . $bank['CityCode'];
			$this->_redis->set($cacheid, $time, 86400);
		}

		EventMgr::Raise('bl/modules/exchange/currency/price/set', array(
			'data'	 => $data,
			'bank'	 => $bank,
		));

		return true;
	}

	public function storageSetCurrencyPrice(array $data)
	{
		if (empty($data))
			return true;

		$data = array_change_key_case($data, CASE_LOWER);
		if (!is_numeric($data['bankid']) || $data['bankid'] <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $data['bankid'] . '" is not valid.');

		if (!is_numeric($data['currencyid']) || $data['currencyid'] <= 0)
			throw new InvalidArgumentBTException('Currency id specified "' . $data['currencyid'] . '" is not valid.');

		$time = strtotime($data['date']);
		if (empty($data['date']) || $time <= 0)
			throw new InvalidArgumentBTException('Date specified "' . $data['date'] . '" is not valid.');

		$data = $data;
		foreach ($data as $k => $v)
			$data[$k] = "`$k` = '" . addslashes($v) . "'";

		$sql = "REPLACE INTO " . $this->_tables['price_currency'] . " SET ";
		$sql .= implode(',', $data);

		return $this->_db->query($sql);
	}

	/*
	 * Проверяет доступность в кеше списка банков
	 *
	 * @param string $citycode - CityCode города
	 * @param int $isvisible - Видимость объектов в списке
	 *
	 * @return bool
	 */
	public function cacheBanksByCityCodeExists($citycode, $isvisible = 1)
	{
		return $this->_redis->Exists('banks_by_citycode_' . $this->_tables['banks'] . '_' . $citycode . '_' . $isvisible);
	}

	/*
	 * Обновляет в кеше список банков
	 *
	 * @param string $citycode - CityCode города
	 * @param int $isvisible - Видимость объектов в списке
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateBanksByCityCodeCache($citycode, $isvisible = 1)
	{
		if (empty($citycode))
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is empty.');

		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		$cacheid = 'banks_by_citycode_' . $this->_tables['banks'] . '_' . $citycode . '_' . $isvisible;

		$result = $this->_getBanksByCityCode($citycode, $isvisible);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}

	/*
	 * Возвращает список банков
	 *
	 * @param string $citycode - CityCode города
	 * @param int $isvisible - Видимость объектов в списке
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getBanksByCityCode($citycode, $isvisible = 1)
	{
		if (empty($citycode))
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is empty.');

		if (strlen($citycode) != 22)
			throw new InvalidArgumentBTException('City code specified "' . $citycode . '" is not valid.');

		$cacheid = 'banks_by_citycode_' . $this->_tables['banks'] . '_' . $citycode . '_' . $isvisible;
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getBanksByCityCode($citycode, $isvisible);
			$this->_redis->set($cacheid, serialize($result), 86400);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает список банков
	 *
	 * @param string $citycode - CityCode города
	 * @param int $isvisible - Видимость объектов в списке
	 *
	 * @return array
	 */
	public function _getBanksByCityCode($citycode, $isvisible)
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE `CityCode` = '" . addslashes($citycode) . "' ";
		$sql .= " AND `isVisible` = " . (int) $isvisible;
		$sql .= " ORDER by `Name` ";

		$list = array();
		$res = $this->_db->query($sql);
		while (false != ($row = $res->fetch_assoc()))
		{
			$list[$row['ID']] = $row;
		}

		return $list;
	}

	/*
	 * Проверяет доступность в кеше списка банков пользователя
	 *
	 * @param int $uid - Идентификатор пользователя
	 * @param int $isvisible - Видимость объектов в списке
	 *
	 * @return bool
	 */
	public function cacheBanksByUserIDExists($uid, $isvisible = 1)
	{
		return $this->_redis->Exists('banks_by_userid_' . $this->_tables['banks'] . '_' . $uid . '_' . $isvisible);
	}

	/*
	 * Обновляет в кеше список банков пользователя
	 *
	 * @param int $uid - Идентификатор пользователя
	 * @param int $isvisible - Видимость объектов в списке
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateBanksByUserIDCache($uid, $isvisible = 1)
	{
		if (!is_numeric($uid) || $uid <= 0)
			throw new InvalidArgumentBTException('User id specified "' . $uid . '" is not valid.');

		$cacheid = 'banks_by_userid_' . $this->_tables['banks'] . '_' . $uid . '_' . $isvisible;

		$result = $this->_getBanksByUserID($uid, $isvisible);
		$this->_redis->set($cacheid, serialize($result), 259200);

		return true;
	}

	/*
	 * Возвращает список банков пользователя
	 *
	 * @param int $uid - Идентификатор пользователя
	 * @param int $isvisible - Видимость объектов в списке
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getBanksByUserID($uid, $isvisible = 1)
	{
		if (!is_numeric($uid) || $uid <= 0)
			throw new InvalidArgumentBTException('User id specified "' . $uid . '" is not valid.');

		$cacheid = 'banks_by_userid_' . $this->_tables['banks'] . '_' . $uid . '_' . $isvisible;
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getBanksByUserID($uid, $isvisible);
			$this->_redis->set($cacheid, serialize($result), 259200);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает список банков пользователя
	 *
	 * @param int $uid - Идентификатор пользователя
	 * @param int $isvisible - Видимость объектов в списке
	 *
	 * @return array
	 */
	protected function _getBanksByUserID($uid, $isvisible)
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE `UserID` = " . (int) $uid;
		$sql .= " AND `isVisible` = " . (int) $isvisible;

		$list = array();
		$res = $this->_db->query($sql);
		while (false != ($row = $res->fetch_assoc()))
		{
			$list[$row['ID']] = $row;
		}

		return $list;
	}

	/*
	 * Возвращает количество банков по фильтру
	 *
	 * @param array $filter - список фильтров
	 *
	 * @return int
	 */
	public function getBanksCount(array $filter = array())
	{
		$sql = "SELECT COUNT(0) FROM " . $this->_tables['banks'];
		$sql .= " WHERE true ";

		if (is_numeric($filter['bankid']))
			$sql .= " AND `ID` = " . (int) $filter['bankid'];

		if ($filter['name'])
			$sql .= " AND `Name` = '" . addslashes($filter['name']) . "'";

		if ($filter['sourcename'])
			$sql .= " AND `SourceName` = '" . addslashes($filter['sourcename']) . "'";

		if (is_numeric($filter['userid']))
			$sql .= " AND `UserID` = '" . addslashes($filter['userid']) . "'";

		if ($filter['citycode'])
			$sql .= " AND `CityCode` = '" . addslashes($filter['citycode']) . "'";

		if ($this->_slave)
			$res = $this->_db->query($sql);
		else
			$res = $this->_db->query($sql);

		list($count) = $res->fetch_row();
		return $count;
	}

	/*
	 * Возвращает список банков по фильтру
	 *
	 * @param array $filter - список фильтров
	 *
	 * @return array
	 */
	public function getBanks(array $filter = array())
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE true ";

		if (is_numeric($filter['bankid']))
			$sql .= " AND `ID` = " . (int) $filter['bankid'];

		if ($filter['name'])
			$sql .= " AND `Name` = '" . addslashes($filter['name']) . "'";

		if ($filter['sourcename'])
			$sql .= " AND `SourceName` = '" . addslashes($filter['sourcename']) . "'";

		if (is_numeric($filter['userid']))
			$sql .= " AND `UserID` = '" . addslashes($filter['userid']) . "'";

		if ($filter['citycode'])
			$sql .= " AND `CityCode` = '" . addslashes($filter['citycode']) . "'";

		$sql .= ' ORDER by Name ASC ';
		if (is_numeric($filter['limit']) && $filter['limit'] > 0)
		{
			$sql .= ' LIMIT ';
			if (is_numeric($filter['offset']) && $filter['offset'] > 0)
				$sql .= (int) $filter['offset'] . ', ';

			$sql .= (int) $filter['limit'];
		}

		if ($this->_slave)
			$res = $this->_db->query($sql);
		else
			$res = $this->_db->query($sql);

		$list = array();
		while (false != ($row = $res->fetch_assoc()))
		{
			$list[] = $row;
		}

		return $list;
	}

	/*
	 * Проверяет доступность в кеше информации о банке
	 *
	 * @param int $id - Идентификатор банка
	 *
	 * @return bool
	 */
	public function cacheBankExists($id)
	{
		return $this->_redis->Exists('bank_' . $this->_tables['banks'] . '_' . (int) $id);
	}

	/*
	 * Обновляет в кеше информацию о банке
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateBankCache($id)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$cacheid = 'bank_' . $this->_tables['banks'] . '_' . (int) $id;

		$result = $this->_getBank($id);
		$this->_redis->set($cacheid, serialize($result), 259200);

		return true;
	}

	/*
	 * Возвращает банк
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getBank($id)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$cacheid = 'bank_' . $this->_tables['banks'] . '_' . (int) $id;
		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getBank($id);
			$this->_redis->set($cacheid, serialize($result), 259200);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает банк
	 *
	 * @param int $id - Идентификатор банка
	 *
	 * @return array
	 */
	protected function _getBank($id)
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE `ID` = " . (int) $id;

		$res = $this->_db->query($sql);
		return $res->fetch_assoc();
	}

	/*
	 * Проверяет доступность в кеше банка по имени
	 *
	 * @param string $name - Имя на источнике
	 * @param string $source - Источник
	 *
	 * @return array
	 */
	public function cacheBankBySourceNameExists($name, $source = '')
	{
		if (trim($source) == '')
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name));
		else
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name) . '_' . trim($source));

		return $this->_redis->Exists($cacheid);
	}

	/*
	 * Обновляет в кеше банк по имени
	 *
	 * @param string $name - Имя на источнике
	 * @param string $source - Источник
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function updateBankBySourceCache($name, $source = '')
	{
		if (trim($name) == '')
			throw new InvalidArgumentBTException('Source bank name specified is empty.');

		if (trim($source) == '')
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name));
		else
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name) . '_' . trim($source));

		$result = $this->_getBankBySourceName($name, $source);
		$this->_redis->set($cacheid, serialize($result), 86400);

		return true;
	}

	/*
	 * Возвращает банк по имени
	 *
	 * @param string $name - Имя на источнике
	 * @param string $source - Источник
	 * @throws InvalidArgumentBTException
	 *
	 * @return array
	 */
	public function getBankBySourceName($name, $source = '')
	{
		if (trim($name) == '')
			throw new InvalidArgumentBTException('Source bank name specified is empty.');

		if (trim($source) == '')
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name));
		else
			$cacheid = 'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($name) . '_' . trim($source));

		if ($this->_use_cache === false || null === ($result = $this->_redis->get($cacheid)))
		{
			$result = $this->_getBankBySourceName($name, $source);
			$this->_redis->set($cacheid, serialize($result), 86400);
		}
		else
			$result = unserialize($result);

		return $result;
	}

	/*
	 * Возвращает банк по имени
	 *
	 * @param string $name - Имя на источнике
	 * @param string $source - Источник
	 *
	 * @return array
	 */
	protected function _getBankBySourceName($name, $source)
	{
		$sql = "SELECT * FROM " . $this->_tables['banks'];
		$sql .= " WHERE `SourceName` = '" . addslashes($name) . "'";

		if ($source != '')
			$sql .= " AND `Source` = '" . addslashes($source) . "'";

		$res = $this->_db->query($sql);
		return $res->fetch_assoc();
	}

	/*
	 * Добавить банк
	 *
	 * @param array $data - Данные о банке
	 *
	 * @return bool
	 */
	public function addBank(array $data)
	{
		if (empty($data))
			return false;

		foreach ($data as $k => $v)
			$data[$k] = "`$k` = '" . addslashes($v) . "'";

		$this->_db->query('START TRANSACTION');

		$sql = "INSERT INTO " . $this->_tables['banks'] . " SET ";
		$sql .= implode(',', $data);

		if ($this->_db->query($sql) !== false)
		{
			$bankid = $this->_db->insert_id;
			if ($this->cacheAddBank($bankid) === true)
			{
				$this->_db->query('COMMIT');

				EventMgr::Raise('bl/modules/exchange/currency/bank/add', array(
					'bankid' => $bankid,
				));

				return $bankid;
			}
		}

		$this->_db->query('ROLLBACK');
		return false;
	}

	/*
	 * Добавляет в кеш информацию о банке
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	protected function cacheAddBank($id)
	{
		$bank = $this->getBank($id);
		if ($bank === null)
			return false;

		if ($this->cacheBanksByCityCodeExists($bank['CityCode'], $bank['isVisible']))
			$this->updateBanksByCityCodeCache($bank['CityCode'], $bank['isVisible']);

		if ($this->cacheBanksByUserIDExists($bank['UserID'], $bank['isVisible']))
			$this->updateBanksByUserIDCache($bank['UserID'], $bank['isVisible']);

		if ($bank['SourceName'])
		{
			if ($this->cacheBankBySourceNameExists($bank['SourceName']))
			{
				if ($this->updateBankBySourceCache($bank['SourceName']) === false)
					return false;
			}

			if ($this->cacheBankBySourceNameExists($bank['SourceName'], $bank['Source']))
			{
				if ($this->updateBankBySourceCache($bank['SourceName'], $bank['Source']) === false)
					return false;
			}
		}

		return true;
	}

	/*
	 * Удалить банк
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function deleteBank($id)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$bank = $this->getBank($id);
		if (empty($bank))
			throw new InvalidArgumentBTException('Bank "' . $id . '" not found.');

		if ($this->cacheDeleteBank($id) === false)
			return false;

		EventMgr::Raise('bl/modules/exchange/currency/bank/delete', array(
			'bankid' => $id,
			'data'	 => $bank,
		));

		return true;
	}

	/*
	 * Удалить банк из кеша
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	protected function cacheDeleteBank($id)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$bank = $this->getBank($id);
		if (empty($bank))
			throw new InvalidArgumentBTException('Bank "' . $id . '" not found.');

		$bank['isDel'] = 1; 
			
		$mset = array(
			'bank_' . $this->_tables['banks'] . '_' . (int) $id => serialize(null),
			'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($bank['SourceName'])) => serialize($bank),
			'bank_' . $this->_tables['banks'] . '_' . md5(strtolower($bank['SourceName']) . '_' . trim($bank['Source'])) => serialize($bank),
		);

		if ($bank['CityCode'] && strlen($bank['CityCode']) == 22)
		{
			$list = $this->getBanksByCityCode($bank['CityCode'], 1);
			unset($list[$id]);

			$mset['banks_by_citycode_' . $this->_tables['banks'] . '_' . $bank['CityCode'] . '_1'] = serialize($list);
		}

		if ($bank['UserID'] > 0)
		{
			$list = $this->getBanksByUserID($bank['UserID'], 1);
			unset($list[$id]);

			$mset['banks_by_userid_' . $this->_tables['banks'] . '_' . $bank['UserID'] . '_1'] = serialize($list);
		}

		$this->_redis->MSet($mset, 86400);
		return true;
	}

	/*
	 * Удалить банк из БД
	 *
	 * @param int $id - Идентификатор банка
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function storageDeleteBank($id)
	{
		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$sql = "DELETE FROM " . $this->_tables['banks'];
		$sql .= " WHERE ID = " . (int) $id;

		return $this->_db->query($sql);
	}

	/*
	 * Обновить банк
	 *
	 * @param int $id - Идентификатор банка
	 * @param array $data - Данные о банке
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function updateBank($id, array $data)
	{
		if (empty($data))
			return false;

		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$bank = $this->getBank($id);
		if (empty($bank))
			throw new InvalidArgumentBTException('Bank "' . $id . '" not found.');

		$data = array_change_key_case($data, CASE_LOWER);
		foreach ($bank as $k => $v)
		{
			if ($k == 'Source' || $k == 'SourceName')
				continue;

			$field = strtolower($k);

			if (!isset($data[$field]))
				continue;

			$bank[$k] = $data[$field];
		}

		if ($this->cacheUpdateBank($id, $bank) === false)
			return false;

		unset($data['Source'], $data['SourceName']);
		EventMgr::Raise('bl/modules/exchange/currency/bank/update', array(
			'bankid' => $id,
			'data'	 => $data,
		));

		return true;
	}

	/*
	 * Обновить банк в кеше
	 *
	 * @param int $id - Идентификатор банка
	 * @param array $data - Данные о банке
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	protected function cacheUpdateBank($id, array $data)
	{
		if (empty($data))
			return true;

		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		$bank = $this->getBank($id);
		if (empty($bank))
			throw new InvalidArgumentBTException('Bank "' . $id . '" not found.');

		$mset = array(
			'bank_' . $this->_tables['banks'] . '_' . (int) $id => serialize($data),
		);

		if ($data['UserID'] > 0)
		{
			$list = $this->getBanksByUserID($data['UserID'], 1);
			
			unset($list[$id]);
			if ($data['isVisible'] == 1)
				$list[$id] = $data;

			$mset['banks_by_userid_' . $this->_tables['banks'] . '_' . $data['UserID'] . '_1'] = serialize($list);
		}

		if ($data['CityCode'] && strlen($data['CityCode']) == 22)
		{
			$list = $this->getBanksByCityCode($data['CityCode'], 1);
			
			unset($list[$id]);
			if ($data['isVisible'] == 1)
				$list[$id] = $data;

			$mset['banks_by_citycode_' . $this->_tables['banks'] . '_' . $data['CityCode'] . '_1'] = serialize($list);
		}

		if (strlen($bank['CityCode']) == 22 && $bank['CityCode'] != $data['CityCode'])
		{
			$list = $this->getBanksByCityCode($bank['CityCode'], 1);
			unset($list[$id]);

			$mset['banks_by_citycode_' . $this->_tables['banks'] . '_' . $bank['CityCode'] . '_1'] = serialize($list);
		}

		if ($bank['UserID'] > 0 && $bank['UserID'] != $data['UserID'])
		{
			$list = $this->getBanksByUserID($bank['UserID'], 1);
			unset($list[$id]);

			$mset['banks_by_userid_' . $this->_tables['banks'] . '_' . $bank['UserID'] . '_1'] = serialize($list);
		}

		$this->_redis->MSet($mset, 86400);
		return true;
	}

	/*
	 * Обновить банк в БД
	 *
	 * @param int $id - Идентификатор банка
	 * @param array $data - Данные о банке
	 * @throws InvalidArgumentBTException
	 *
	 * @return bool
	 */
	public function storageUpdateBank($id, array $data)
	{
		if (empty($data))
			return true;

		if (!is_numeric($id) || $id <= 0)
			throw new InvalidArgumentBTException('Bank id specified "' . $id . '" is not valid.');

		foreach ($data as $k => $v)
			$data[$k] = "`$k` = '" . addslashes($v) . "'";

		$sql = "UPDATE " . $this->_tables['banks'] . " SET ";
		$sql .= implode(',', $data);
		$sql .= " WHERE ID = " . (int) $id;

		return $this->_db->query($sql);
	}

	/*
	 * Добавить валюту
	 *
	 * @param array $data
	 * @return bool - false в случае неудачи
	 */
	public function addCurrency($data)
	{
		if (($cid = parent::addCurrency($data)) === false)
			return false;

		EventMgr::Raise('bl/modules/exchange/currency/add', array(
			'currencyid' => $cid,
		));

		return true;
	}

	/*
	 * Удалить валюту
	 *
	 * @param int $cid
	 * @return bool - false в случае неудачи
	 */
	public function removeCurrency($cid)
	{
		if (parent::removeCurrency($cid) === false)
			return false;

		EventMgr::Raise('bl/modules/exchange/currency/remove', array(
			'currencyid' => $cid,
		));

		return true;
	}
}
