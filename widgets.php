<?

/**
 * Ядро
 * @package WSE
 */



register_shutdown_function(shutdown);
function shutdown()
{
	global $OBJECTS;
	if(is_object($OBJECTS['usersMgr']))
		$OBJECTS['usersMgr']->Dispose();
	if ( class_exists("lib_Redis") )
		lib_Redis::Dispose();
}

ini_set('memory_limit', 64 * 1024 * 1024);
ini_set('display_errors', 'Off');
setlocale(LC_ALL, array('ru_RU.utf8', 'ru_RU.utf8'));

require_once $CONFIG['engine_path']."include/lib.trace.php";
Trace::Init();
Trace::Start();
require_once $CONFIG['engine_path']."include/lib.exceptions.php";
require_once $CONFIG['engine_path']."include/lib.usererror.php";
//2do: избавиться от этого объекта
$OBJECTS['uerror'] = UserError::getMe();
require_once $CONFIG['engine_path']."include/lib.response.php";

require_once $CONFIG['engine_path']."include/db.php";
require_once $CONFIG['engine_path']."include/patterns_v2.php";
App::$Terminal = App::TM_HTTP;
require_once $CONFIG['engine_path']."configure/engine.php";
require_once $CONFIG['engine_path']."include/log.php";
$OBJECTS['log'] = new ActionsLog();
App::SetLogObject($OBJECTS['log']);

if ($_GET['env'] && isset($_GET['env']['userid'])) {
	LibFactory::GetStatic('gpassport');

	$OBJECTS['usersMgr'] = new PUsersMgr();
	$OBJECTS['user'] = $OBJECTS['usersMgr']->Login();

	if ($_GET['env']['userid'] && $_GET['env']['userid'] != $OBJECTS['user']->ID)
		Response::Status(404, RS_EXIT);

	$OBJECTS['log']->SetUserID($OBJECTS['user']->ID);
} else
	$OBJECTS['log']->SetUserID(0);


$handler = HandlerFactory::GetInstance('widget');
$handler->Init(array(
	'uri' => '/service/widget/'
));

$handler->Run();
$handler->Dispose();

exit(0);

