<?php

/**
* SMS-receiver-provider
*/
abstract class SMS_Receiver_Base_Default
{
	/*
		Ошибки провайдера:
		0 - нет ошибок
		1-99 - ошибки в провайдере
		100+ - ошибки обработки запроса
	*/
	protected static $ERR_OK = 0;
	
	// ошибка действия
	protected $status = 0;
	
	// сообщения об ошибках провайдера
	protected $error_messages = array();
	
	// 2do: должно уехать в отдельный класс
	protected $action_errors = array();
	
	// тип провайдера
	protected $name = null;	
	protected $params = array();
	
	// объект ресивера
	protected $mgr = null;

	public function __construct($name)
	{
		$this->name = $name;
	}
	
	/**
	* Проверка доступа к провайдеру
	*/
	abstract function CheckAccess($params);
	
	/**
	* Обработка полученного запроса
	*/
	abstract function Receive($params);
	
	/**
	* Вывод сообщения о результате обработки
	*/
	public function PrintResult()
	{	
		// вывод сообщения об ошибке
		echo $this->GetError($this->status);
	}
	
	/**
	* Формирование сообщения об ошибе
	*/
	public function GetError($status)
	{
		if ( isset($this->error_messages[$status]) || isset($this->action_errors[$status]) )
		{
			if ( $status < 100 )
				return $this->error_messages[$status];
			else
				return $this->action_errors[$status];
		}
		else
			return 'Неизвестная ошибка';
	}
	
	/**
	* Выполнение действий
	* 2do: Здесь можно сделать подгрузку класса действия и прокидывание ему параметров
	* сейчас действия реализуются переопределением этого метода в классе провайдера
	*/
	//protected function Action($name,$action);
	
}
