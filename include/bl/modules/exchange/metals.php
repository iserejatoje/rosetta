<?php

require_once($CONFIG['engine_path'] . 'include/bl/modules/exchange/currency.php');

/*****************************************
 *										
 * Бизнес-логика курсов драгоценных металлов
 *
 * @author Овчинников Евгений
 * @version 0.1
 * @created xx-окт-2010
 ******************************************/

class BL_modules_exchange_metals extends BL_modules_exchange_currency
{
	/*
	 * Сохранение курсов драгоценных металов
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
		$res = $this->_redis->set($cacheid, serialize($data), 86400);

		$list = $this->getBankExchangeByDate($data['BankID'], $time);
		$list[$data['CurrencyID']] = $data;
		
		$this->_redis->set('bank_by_date_' . $this->_tables['price_currency'] . '_' . $data['BankID'] . '_' . date('Ymd', $time), serialize($list), 86400);
		
		$lastdate = $this->getLastDateExchange($bank['CityCode']);
		if ($lastdate === null || $lastdate < $time)
		{
			$cacheid = 'last_date_' . $this->_tables['banks'] . '_' . $this->_tables['price_currency'] . '_' . $bank['CityCode'];
			$this->_redis->set($cacheid, $time, 86400);
		}

		EventMgr::Raise('bl/modules/exchange/metals/price/set', array(
			'data'	 => $data,
			'bank'	 => $bank,
		));

		return true;
	}
}
