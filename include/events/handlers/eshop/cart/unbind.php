<?

class EventHandler_Eshop_Cart_Unbind extends AEventHandler
{
	
	public function HandleEvent($params)
	{
		LibFactory::GetMStatic('eshop', 'eshopmgr');
		EShopMgr::GetInstance()->UnBindCartUser($params['userid']);
		return true;
	}
}
