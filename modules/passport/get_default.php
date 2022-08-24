<?
if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();
else
	$this->redirect_not_authorized();
?>