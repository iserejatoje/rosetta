<?php

/**
 * Главный класс исключений приложения
 */
class MyException extends Exception
{
	protected $user_error_args	= array();
	/**
	 * @param $message string
	 * @param $code integer
	 * @param $user_error_args array
	 */
	public function __construct($message = '', $code = 0, $user_error_args = array())
	{

		parent::__construct($message, $code);
		
		if( !is_array($user_error_args) )
			$user_error_args = array();
		$this->user_error_args = $user_error_args;
	}
	
	/**
	 * возвращает массив с данными для кода ошибки
	 * @return array
	 */
	public function getUserErrorArgs()
	{
		return $this->user_error_args;
	}

}

/**
 * Главный класс исключений приложения
 */
class BTException extends MyException
{
	/**
	 * @param $message string
	 * @param $code integer
	 * @param $user_error_args array
	 */
	public function __construct($message = '', $code = 0, $user_error_args = array())
	{
		parent::__construct($message, $code, $user_error_args);
		
	}

}

/**
 * Логический класс исключений приложения
 * Логическая ошибка в чем либо (не критическая)
 */
class LogicBTException extends BTException {}
class LogicMyException extends MyException {}

/**
 * Исклюение о неверном аргументе функции
 * Надо использовать когда входные параметры не соответствуют спецификации
 * @example Вместо имени файла пришла пустая строка или число или bool
 */
class InvalidArgumentBTException extends LogicBTException {}
class InvalidArgumentMyException extends LogicMyException {}

/**
 * Исклюение о вызове в некорректном контексте
 * Надо использовать когда вызывать данный метод в текущих условиях нельзя
 * @example Попытка отправить заголовок, когда заголовки уже отправлены
 */
class DomainBTException extends LogicBTException {}
class DomainMyException extends LogicMyException {}

/**
 * Критическое исключение в ходе работы приложения
 * Надо использовать когда при обращении к какой-нить библиотеке
 * или работе с внешними ресурсами возникла ошибка 
 * @example не удалось подключиться к БД, не удалось сохранить файл на диск
 */
class RuntimeBTException extends BTException {}
class RuntimeMyException extends MyException {}

/**
 * Обработчик не перехваченных исключений
 * Выдает 500ую ошибку и завершает работу приложения,
 * если это не исключение внутри библиотеки Response
 * @param $e
 */
function BTExceptionHandler($e)
{
	
	// нельзя вызывать Response, если в нем исключение возникло.
	if( !is_a($e, 'ResponseDomainBTException') )
		App::Stop();
}

set_exception_handler('BTExceptionHandler');


// Example
//throw new RuntimeBTException('opanki');


