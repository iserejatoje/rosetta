<?php
if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

if ($OBJECTS['user']->Rating < $this->_config['limits']['min_rating_for_domain'])
	Response::Redirect('/passport/mypage.php');
	
$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Выбери себе адрес!');

if (isset($OBJECTS['title']))
	$OBJECTS['title']->AddScript('/_scripts/modules/passport/domain.js');

return $this->_Get_Domain();	

?>