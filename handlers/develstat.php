<?
/**
 * Хендлер для отображения статистики
 * @package Handlers
 */
 
class Handler_develstat extends IHandler
{
	private $show = true;

	public function Init($params)
	{
	
		//2do: определение домена, пути, раздела
		//2do: перенести сюда инициализацию
		
		if(isset($params['params']['init']) && $params['params']['init'] === true)
		{
			$this->show = false;
			//TRACE::Start();
			
			if($_GET['dbprof'] > 10)
				emysqli::SetProfiling(true);
		}
	}
	
	public function Run()
	{
		global $CONFIG;
		
		if($this->show === false)
		{
			$this->show = true;
			return;
		}
		$end = microtime(true);
		
		// залогируем профайлинг
		if($_GET['dbprof'] > 10)
		{
			$ps = emysqli::GetProfiles();
			
			if(count($ps) > 0)
			{
				foreach($ps as $p)
				{
					Trace::Log('Profiling: '.$p['title']);
					if(count($p) > 0)
					{
						foreach($p['profile'] as $_p)
						{
							Trace::Log('ID: '.$_p['id'].' Time: '.$_p['time'].' Query: '.$_p['query']);
						}
					}
				}
			}
		}
		
		echo '<div style="background-color:#dddddd;font-size:18px;">отладочная информация</div>';
		echo 'Время генерации страницы: '.number_format($end - Trace::getStartTime(), 8).' секунд<br>';
		echo 'IP: '.$_SERVER['REMOTE_ADDR'].'&nbsp;&nbsp;&nbsp;BACKEND: '.$_SERVER['SERVER_ADDR'].'&nbsp;&nbsp;&nbsp;SectionId: '.$CONFIG['env']['sectionid'].'<br>';
		if(Trace::GetConfig('trace') === true)
		{
			echo Trace::GetHTMLLog();
		}
	}
	
	public function Dispose()
	{
	}
}
?>