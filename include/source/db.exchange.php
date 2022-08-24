<?php

function source_db_exchange($params)
{
	global $DCONFIG;
	switch(strtolower($params['type'])) {
		case 'cbrf';
			if (!is_numeric($params['cid']) || $params['cid'] <= 0)
				return null;
		
			$cid = (int) $params['cid'];

			LibFactory::GetStatic('bl');
			$bl = BLFactory::GetInstance('modules/exchange/currency_cbrf');

			$time = $bl->getLastDateExchange();
			if ($time <= 0)
				return null;

			$price = $bl->getExchangeCurrencyByDate($cid, $time);
			if (!is_array($price) || !sizeof($price))
				return null;

			$lc = localeconv();
			return str_replace($lc['decimal_point'], '.', $price['Value']);
		break;
		default:
			return null;
	}
}
