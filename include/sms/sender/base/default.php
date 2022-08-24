<?php

/**
* SMSSender provider base
*/
abstract class SMS_Sender_Base_Default
{	
	public function __construct()
	{
			
	}
		
	abstract public function Send();
	
	abstract public function GetBalance();
	
}
