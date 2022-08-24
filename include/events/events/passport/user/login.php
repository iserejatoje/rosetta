<?

class Event_Passport_User_Login extends AEvent
{
	public function &ListHandlers()
	{
		return array(
			array('name' => 'eshop/cart/bind', 'method' => 'sync'),
		);
	}
}
