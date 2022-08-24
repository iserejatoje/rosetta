<?

include_once "config.php";
$CONFIG['engine_path'] = ENGINE_PATH;

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

ini_set('memory_limit', 100 * 1024 * 1024);
setlocale(LC_ALL, array('ru_RU.utf8', 'ru_RU.utf8')); 

// Парсим параметры
#print_r($argv);
$CONFIG['params'] = array();
if( is_array($argv) && count($argv)>0 )
	foreach ($argv as $k=>$v)
		if($k>0 && preg_match("@^([^\=]+)(\=[\"\']?(.*)[\"\']?)?$@", $v, $rg))
			$CONFIG['params'][$rg[1]] = $rg[3];

$CONFIG['params']['skip_maintanance'] = (bool) $CONFIG['params']['skip_maintanance'];
if( is_file(VAR_PATH.'maintanance.html') && $CONFIG['params']['skip_maintanance'] === false )
{
	error_log("Application now in maintance mode. Please try later...\n");
	exit(1);
}


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
App::$Terminal = App::TM_CLI;
require_once $CONFIG['engine_path']."configure/engine.php";
require_once $CONFIG['engine_path']."include/log.php";
$OBJECTS['log'] = new ActionsLog();
App::SetLogObject($OBJECTS['log']);

include_once $CONFIG['engine_path']."include/lib.stpl.php";
include_once $CONFIG['engine_path']."include/lib.mailsender.php";
LibFactory::GetStatic('data');

// это надо будет убрать если что в другой файл
list($ns, $action) = explode(':', $CONFIG['params']['action']);

if(!is_file($CONFIG['engine_path']."shell/$ns.php"))
{
	echo "fatal error: namespace not found\n\n";
	exit();
}
	
include $CONFIG['engine_path']."shell/$ns.php";

$ns = str_replace("../", "", $ns);
$ns = str_replace("/", "_", $ns);
$obj = new $ns();
if(!is_object($obj))
{
	echo "fatal error: namespace not found\n\n";
	exit();
}

$obj->Name = get_class($obj);

if(empty($action))
	echo $obj->GetUsage();
else
	echo $obj->Action($action, $CONFIG['params']);


class base_shell
{
	public $Name = 'base_shell'; // RTTI
	public $pid = 0;
	function __construct()
	{
		$this->pid = posix_getpid();
	}
	
	function __destruct()
	{
	}
	
	// стандартный обработчик, для него требуется реализация методов A_del и A_show
	// в данные функции передается массив идентификаторов
	// комманды ключ - идентификатор, значение - действие
	function Action($action, $params)
	{
		$f = array($this, 'A_'.$action);
		if(is_callable($f))
			return call_user_func($f, $params);
		else
			$this->GetUsage();
	}
	
	// возвращает true в случае, если уже запущен процесс с текущей командной строкой
	function IsProcessExists()
	{
		$cmd = 'ps ax -o pid,command --no-headers|grep "'.ENGINE_PATH.'shell.php"|grep -v "ps"|grep -v "grep"';
		$processes = shell_exec($cmd);
		$processes = explode("\n", $processes);
		
		$cmdline = file_get_contents("/proc/".$this->pid."/cmdline");
		$cmdline = trim(str_replace(chr(0), ' ', $cmdline));
		foreach($processes as $p)
		{
			if(strlen(trim($p)) == 0)
				continue;
			list($pid, $cl) = explode(" ", $p, 2);
			if($cmdline == $cl && $this->pid != $pid)
			{
				return true;
			}
		}
		return false;
	}
	
	function NotifyByTemplate($tpl, $email, $params) {
		
		if (!is_array($email))
			$email = (array) $email;
		
		if (!is_array($tpl))
			$tpl = (array) $tpl;
		
		if (empty($email))
			return false;
		
		if ( !STPL::IsTemplate($tpl[0]) && !STPL::IsTemplate($tpl[1]) )
			return false;

		$mail = new MailSender();
		foreach($email as $k => $v) {
			if (Data::Is_Email($k))
			{
				$mail->AddAddress('to', $k, (empty($v) ? null : $v));
			}
			elseif (Data::Is_Email($v))
			{
				$mail->AddAddress('to', $v);
			}
		}
		
		$params = array_change_key_case($params, CASE_LOWER);
		
		$mail->AddAddress('from', $params['from']);
		
		if (!isset($params['subject']) || empty($params['subject']))
			$params['subject'] = 'Без темы';
		
		$mail->AddHeader('Subject', $params['subject'],  false);
		$mail->body_type = MailSender::BT_ALTERNATIVE;

		if ( STPL::IsTemplate($tpl[0]) )
			$mail->AddBody('plain', html_entity_decode(STPL::Fetch($tpl[0], $params)), MailSender::BT_PLAIN);

		if ( STPL::IsTemplate($tpl[1]) )
			$mail->AddBody('html', STPL::Fetch($tpl[1], $params), MailSender::BT_HTML);
		
		$mail->Send(true, true, true);
		$mail = null; unset($mail);
	}

	// список стандартных действий
	function GetUsage()
	{
		return '		
usage: '.$this->Name.'
	help not found

';
	}
}
