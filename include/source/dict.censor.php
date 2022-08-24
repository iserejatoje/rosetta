<?php

/**
 * Получение слов из указанного словаря lib.censor
 * http://rugion.ru/service/source/dict.censor?output_type=plain&dict=job_common.txt&passw=aEo8uiE1&state=list
 * @param varchar dict  - название словаря
 * @param varchar passw - пароль
 * @param varchar state - действие
 * @return array данные text - слово из словаря
 */
function source_dict_censor($params) {
	global $DCONFIG;

	LibFactory::GetStatic('data');

	$dict = Data::InputClean($params["dict"]);
	$passw = Data::InputClean($params["passw"]);
	$state = Data::InputClean($params["state"]);
	$arr = array();

	if ($passw=="aEo8uiE1" && $state="list") {
		LibFactory::GetStatic('censor');
		$censor = new lib_censor(true, array($dict));
		foreach ($censor as $c)
			foreach ($c as $words) 
				foreach ($words as $word) {
					$arr[]["word"] = $word;
				}
	}
	return $arr;
}