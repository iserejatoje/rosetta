<?

class Event_Passport_User_Logout extends AEvent
{
	public function &ListHandlers()
	{
		return array(
			array('name' => 'eshop/cart/unbind', 'method' => 'sync'),
		);
	}
}
