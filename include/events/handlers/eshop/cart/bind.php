<?

class EventHandler_Eshop_Cart_Bind extends AEventHandler
{
	
	public function HandleEvent($params)
	{
		LibFactory::GetMStatic('eshop', 'eshopmgr');
		EShopMgr::GetInstance()->BindCartWithUser($params['userid']);
		return true;
	}
}
