<?php

interface Control_IPager
{
	public function GetMaxPage();

	public function GetPage();
	
	public function SetMaxPage($maxpage);

	public function SetPage($page);
}
?>