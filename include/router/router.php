<?php

use MaxMind\Db\Reader;
use CNZ\Helpers\Util as util;

LibFactory::GetMStatic('sxgeo', 'SxGeo');
LibFactory::GetMStatic('cities', 'citiesmgr');
LibFactory::GetStatic('data');

$citymgr = CitiesMgr::GetInstance();
$url = MAIN_DOMAIN;
$ip = '';
// $ip = '37.192.40.10';

// $ip = '176.196.72.141'; // Кемерово

// $ip = util::ip();
// $databaseFile = 'GeoLite2-City.mmdb';
// $path = ENGINE_PATH.'/resources/static/'.$databaseFile;
// $reader = new Reader($path);
// $cityname = $reader->get($ip)['city']['names']['ru'];
// $city = $citymgr->getCityByName($cityname);
// $reader->close();

$subject = is_null($_SERVER['SERVER_NAME']) === false ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];

$pattern = '/^(\w*).'.$url.'$/';
preg_match($pattern, $subject, $matches);

$city = $matches[1];

if ($city == 'www') {
    Response::Redirect(App::$Protocol . $url);
}

if (!empty($city)) {
    $city = $city == 'kemerovo' ? 'kemerovo' : $city;
    $cityInfo = $citymgr->GetCityInfo($city);

    $OBJECTS['city'] = $cityInfo;
    App::SetCityObject($cityInfo);
    if($cityInfo->IsDefault)
        Response::Redirect(App::$Protocol . $url);
} else {
    $cityInfo = $citymgr->GetCityInfo();
    App::SetCityObject($cityInfo);
    // $location = $OBJECTS['user']->GetLocationInfo();

    // $cityInfo = $citymgr->GetCityInfo($location['city']['name_en']);

    // if ($cityInfo && $cityInfo->IsDefault == 0) {
    // 	Response::Redirect('http://'.$cityInfo->Domain.'.'.$url);
    // } else {
    // 	$defaultCity = $citymgr->GetCity(1); //выбрать домен с ид 1
    // 	Response::Redirect('http://'.$url);
    // }
    // exit;
}
