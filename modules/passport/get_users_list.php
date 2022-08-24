<?
Response::NoCache();

// это здесь обязательно, т.к. этот же метод показывает пользовательскую инфу.
if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$type = $this->_page;

if( $this->_page == 'users' )
	$type = 'all';
else if( $this->_page == 'im_contacts' )
	$type = 'contacts';
else if( $this->_page == 'mypage_friends' )
	$type = 'myfriends';

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
if( !in_array($type, array('friends', 'myfriends')) )
{
	$OBJECTS['title']->AppendBefore('Пользователи');
}

return $this->_Get_Users(array('type' => $type));

?>