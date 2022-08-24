<?php

$start = microtime(true);
$log_pref = "\t(".$_SERVER["REQUEST_METHOD"].") - ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ."\n";
$GLOBALS['LOG_BLOCKS'] = false;
$GLOBALS['LOG_REQ'] = false;
$GLOBALS['LOG_DB'] = false;
$GLOBALS['LOG_SMARTY'] = false;
$GLOBALS['LOG_CACHE'] = false;

$GLOBALS['LOG_REQUEST'] = false;

ini_set('memory_limit', 64 * 1024 * 1024);
ini_set('display_errors', 'off');
// setlocale(LC_ALL, array('ru_RU.UTF-8', 'ru_RU.UTF-8'));
setlocale(LC_NUMERIC, '.');
header("Cache-Control: no-cache, max-age=0, must-revalidate, no-store");

require_once $CONFIG['engine_path']."include/lib.exceptions.php";
require_once $CONFIG['engine_path']."include/lib.usererror.php";
//2do: избавиться от этого объекта
$OBJECTS['uerror'] = UserError::getMe();

require_once $CONFIG['engine_path']."include/lib.response.php";
require_once $CONFIG['engine_path']."include/db.php";
require_once $CONFIG['engine_path']."include/patterns_v2.php";

App::$Terminal = App::TM_HTTP;
App::$Protocol = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' || $_SERVER['HTTPS'] == 'http' ? 'http://' : 'https://';

LibFactory::GetStatic('sections');
LibFactory::GetMStatic('banners', 'bannermgr');

LibFactory::GetStatic('gpassport');
$OBJECTS['usersMgr'] = new PUsersMgr();

$OBJECTS['user'] = $OBJECTS['usersMgr']->Login();

//роутинг
if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== 0 && strpos($_SERVER['REQUEST_URI'], '/account/') !== 0) {
    LibFactory::GetMStatic('router', 'router');
}

$hi = HandlerFactory::GetIterator();
foreach($hi as $handler)
{
    if($handler != null)
    {
        $handler->Run();
        $handler->Dispose();
    }
}

// exit(0);

