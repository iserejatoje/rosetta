<?

/**
 * Хендлер для работы с модулями
 * @package Handlers
 */

// задание по uri
// если uri строка, то в качестве источника берется остаток строки
// если uri регулярка, то в $params['index_source'] индекс из регулярки

class Handler_place extends IHandler
{
	private $json;
	private $source;
	public function Init($params)
	{
	}
	
	public function IsLast()
	{
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS;
		
		LibFactory::GetMStatic('place', 'placemgr');
		$placeID = App::$Request->Get['params']->Int(null, Request::UNSIGNED_NUM);
		$sections = PlaceMgr::getInstance()->GetPlaceSections($placeID);
		
		if ( !empty($sections[0]) && null !== ($section = PlaceMgr::getInstance()->GetAll($sections[0])) ) {
			list($root, ) = explode(',',$section->Path);
			
			if ( null !== ($section = PlaceMgr::getInstance()->GetAll($root)) && 
				$section->SectionId && 
				false != ($link = ModuleFactory::GetLinkBySectionId($section->SectionId)) )
			
				Response::Redirect($link."details/{$sections[0]}/{$placeID}/");	
			
		}
		Response::Status(404, RS_SENDPAGE | RS_EXIT);		
	}
		
	
	public function Dispose()
	{
	}
}
?>