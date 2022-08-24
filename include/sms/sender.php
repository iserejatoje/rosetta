<?php

require_once ($CONFIG['engine_path'].'configure/lib/sms/error.php');

class SMSSender
{			
	/**
	* Получение объекта провайдера
	* 
	* @param string $name имя провайдера
	* @return object Provider объект провайдера
	* @exception RuntimeBTException
	*/
	public static function GetProvider($name)
	{
		global $CONFIG;
		
		$file = dirname(__FILE__).'/sender/providers/'.$name.'.php';
		
		if ( is_file($file) )
		{
			// создаем объект провайдера
			include_once $file;
			$cname = 'SMS_Sender_Provider_'.$name;
			if ( class_exists($cname) === true )
				return new $cname($name,$this);
			else
				return null;
		}		
		throw new RuntimeBTException('ERR_L_SMS_CANT_LOAD_PROVIDER SMS_Sender_Provider_'.$name, ERR_L_SMS_CANT_LOAD_PROVIDER, array($name));
	}
	
	/**
	* Получение списка провайдеров
	* 
	* @return array список провайдеров
	*/
	public static function GetProviderList()
	{
		global $CONFIG;
		
		$list = array();
		$path = dirname(__FILE__).'/sender/providers/';
		$dIterator = new DirectoryIterator($path);
		foreach ( $dIterator as $dir )
			if ( $dIterator->isFile() === true )
				$list[] = str_replace('.php','', $dIterator->getFileName() );
		
		return $list;
	}
}