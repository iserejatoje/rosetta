<?

class Event_Passport_User_Register extends AEvent
{
	public function &ListHandlers()
	{
		return array(
			array('name' => 'passport/user/ouremail/create', 'method' => 'async'),
		);
	}
}
