<?
/**
 * Временный сорс для хипа
 * будет переделан в хэндлер
 */

LibFactory::GetStatic('heap');

$action = App::$Request->Post['action']->Value(Request::OUT_HTML_CLEAN);
$result = array( 'success' => false );

switch ( $action )
{
	case 'queues':
		try
		{
			$list =& Heap::QueueList();
			$result['list'] = array();
			foreach ( $list as $queue_id => $l )
			{
				if ( strpos($l['Title'], ' - ') !== false )
				{
					list($group, $title) = explode(' - ', $l['Title']);
					$result['list'][$group][$queue_id] = $l['Title'];
				}
				else
					$result['list'][$queue_id] = $l['Title'];
			}
			unset($list);
			$result['success'] = true;
		}
		catch (MyException $e)
		{
			$result['error'] = 'Не удалось получить список очередей';
		}
		break;
	case 'ship':
		$queue_id = App::$Request->Post['queue_id']->Value(Request::OUT_HTML_CLEAN);
		try
		{
			Heap::StartTransaction();
			$object =& Heap::Queue($queue_id)->Pop();
			if ( $object !== null )
			{
				Heap::UsersQueue()->Push($object);
				$result['object'] = $object->AsArray();
			}
			Heap::Commit();
			$result['success'] = true;
		}
		catch (MyException $e)
		{
			Heap::Rollback();
			$result['error'] = 'Не удалось получить объект';
		}
		break;
	case 'return':
		$object_id = App::$Request->Post['object_id']->Value(Request::OUT_HTML_CLEAN);
		$queue_id = App::$Request->Post['queue_id']->Value(Request::OUT_HTML_CLEAN);
		try
		{
			Heap::StartTransaction();
			$object =& Heap::UsersQueue()->Pop($object_id);
			if ( $object !== null )
				Heap::Queue($queue_id)->Push($object);
			Heap::Commit();
			$result['success'] = true;
		}
		catch (MyException $e)
		{
			Heap::Rollback();
			$result['error'] = 'Не удалось вернуть объект';
		}
		break;
	case 'action':
		$object_id = App::$Request->Post['object_id']->Value(Request::OUT_HTML_CLEAN);
		$event_name = App::$Request->Post['event_name']->Value(Request::OUT_HTML_CLEAN);
		try
		{
			Heap::StartTransaction();
			$object =& Heap::UsersQueue()->Pop($object_id);
			if ( $object === null )
				throw new RuntimeMyException("Heap object not found");
			if ( !is_array($object->Actions[$event_name]) )
				throw new RuntimeMyException("Heap event '". $event_name ."' not found");
			
			// Создаем событие для обработки действия модератора
			$params = (array) $object->Actions[$event_name]['params'];
			
			EventMgr::Raise($event_name, $params);
			
			Heap::Commit();
			
			$result['success'] = true;
		}
		catch (MyException $e)
		{
			Heap::Rollback();
			$result['error'] = 'Не удалось выполнить действие над объектом';
		}
		break;
	default:
		$result = array( 'error' => 'Доступ запрещен' );
}

include_once ENGINE_PATH .'include/json.php';
$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';
$json->send($result);

exit;

?>