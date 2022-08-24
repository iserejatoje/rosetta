<?php

//2do: нужно избавиться от свойства ERRORS
//2do: сконветить все $ERRORS[ в UserError::$Errors[
//2do: начать пользоваться методом GetAnchor...


/**
 * Класс для накопления пользовательскийх ошибок
 *
 */
class UserError
{
	/**
	 * Экземпляр объекта.
	 */
	static protected $_me				= null;

	/**
	 * Ассоциативный массив, разрешающий текст ошибки по ее номеру
	 *
	 * @var array 
	 *
	 */
	static public $Errors				= array();
	
	/**
	 * Разделитель при выводе ошибок
	 *
	 * @var string 
	 *
	 */
	static private $_linedelimiter		= '<br />';
	
	/**
	 * Массив накопленных ошибок
	 *
	 * @var array 
	 *
	 */
	static private $_errors				= array();
	
	/**
	 * Флаг критической ошибки
	 *
	 * @var bool 
	 *
	 */
	static private $_critical			= false;
	
	
	
	private function __construct($delimiter = '<br/>')
	{
		self::$_linedelimiter = $delimiter;
	}
	
	/**
	 * Добавить ошибку с индексом и параметры взять из массива
	 *
	 * @param string $index Индекс ошибки в массиве
	 * @param integer $errno Номер ошибки
	 * @param array $args набор параметров для текста ошибки
	 *
	 */
	static public function AddErrorWithArgsIndexed($index, $errno, $args = array())
	{
		if( !is_array($args) )
			$args = array();
		self::_AddErrorIndexed($index, $errno, $args);
	}
	
	/**
	 * Добавить ошибку с индексом
	 * третий и последующие аргументы будут параметрами для вставки в строку
	 *
	 * @param mixed $index Индекс ошибки в массиве
	 * @param mixed $errno Номер ошибки
	 *
	 */
	static public function AddErrorIndexed($index, $errno)
	{
		$args = func_get_args();
		array_shift($args);
		array_shift($args);
		self::_AddErrorIndexed($index, $errno, $args);
	}
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	/**
	 * Добавить ошибку с индексом (internal)
	 *
	 * @param mixed $index Индекс ошибки в массиве
	 * @param mixed $errno Номер ошибки
	 * @param array $args параметры для подстановки в ошибку
	 *
	 */
	static private function _AddErrorIndexed($index, $errno, $args)
	{
		if(self::$_critical === true)
			return;
		if($index == null)
			self::$_errors[] = vsprintf(self::$Errors[$errno], $args);
		else
		{
			if(!empty(self::$_errors[$index]))
				self::$_errors[$index].= self::$_linedelimiter;
			self::$_errors[$index] .= vsprintf(self::$Errors[$errno], $args);
		}
	}
	
	/**
	 * Ставим критическую ошибку. (перетираем все ошибки)
	 * второй и последующие аргументы будут параметрами для вставки в строку
	 *
	 * @param integer $errno Номер ошибки
	 *
	 */
	static public function SetCriticalError($errno)
	{
		$args = func_get_args();
		array_shift($args);
		self::$_errors = array();
		self::_AddErrorIndexed(null, $errno, $args);
		self::$_critical = true;
	}
	
	/**
	 * Добавить ошибку без индекса
	 * второй и последующие аргументы будут параметрами для вставки в строку
	 *
	 * @param mixed $errno Номер ошибки
	 *
	 */
	static public function AddError($errno)
	{
		$args = func_get_args();
		array_shift($args);
		self::_AddErrorIndexed(null, $errno, $args);
	}
	
	/**
	 * Удалить ошибки из списка
	 */
	static public function DropErrors()
	{
		self::$_errors = array();
		$_critical = false;
	}
	
	/**
	 * Возвращает список ошибок разделенных разделителем
	 *
	 * @param string $delimiter Разделитель (default: <br />)
	 * @return string Текст ошибок
	 *
	 */
	static public function GetErrorsText($delimiter = null)
	{
		$delimiter = ($delimiter !== null) ? $delimiter : self::$_linedelimiter;
		$text = '';
		foreach(self::$_errors as $k=>$v)
		{
			$text.= ($text==''?'':$delimiter) . self::GetErrorAnchor($k) . $v;
		}
		return $text;		
	}
	
	/**
	 * Возвращает список ошибок разделенных разделителем без якорей
	 *
	 * @param string $delimiter Разделитель (default: <br />)
	 * @return string Текст ошибок
	 *
	 */
	static public function GetErrorsTextWithoutAnchor($delimiter = null)
	{
		$delimiter = ($delimiter !== null) ? $delimiter : self::$_linedelimiter;
		$text = '';
		foreach(self::$_errors as $k=>$v)
		{
			$text.= ($text==''?'':$delimiter) . $v;
		}
		return $text;		
	}
	
	/**
	 * Возвращает массив ошибок в чистом виде
	 *
	 * @return array массив ошибок
	 *
	 */
	static public function GetErrorsArray()
	{
		return self::$_errors;		
	}
	
	/**
	 * Возвращает JS-код, который направляет пользователя к ошибке
	 *
	 * @param mixed $index ключ массива ошибок
	 * @return array массив ошибок
	 *
	 */
	static public function SetFocusToError($index = null)
	{
		return;
		if( $index === null)
		{
			foreach(self::$_errors as $k=>$v)
			{
				$index = $k;
				break;
			}
		}
		elseif( !isset(self::$_errors[$index]))
			$index = null;
		
		if( $index === null )
			return '';
		else
			return "window.location.href = '#ue_".strval($index)."';\n";
	}
	
	/**
	 * Возвращает якорь для определенного индекса ошибки
	 *
	 * @param mixed $index ключ массива ошибок
	 * @return array массив ошибок
	 *
	 */
	static public function GetErrorAnchor($index)
	{
		return '';
		return '<a name="ue_'.strval($index).'"></a>';
	}
	
	/**
	 * Возвращает текст ошибки по номеру
	 * второй и последующие аргументы будут параметрами для вставки в строку
	 *
	 * @param int $errno номер ошибки
	 * @return string Текст ошибки
	 *
	 */
	static public function GetError($errno)
	{
		if( !isset(self::$Errors[$errno]) )
			return "";
		$args = func_get_args();
		array_shift($args);
		if( sizeof($args) > 0 )
			return vsprintf(self::$Errors[$errno], $args);
		else
			return self::$Errors[$errno];
	}
	
	/**
	 * Возвращает текст ошибки по индексу вместе с якорем
	 *
	 * @param mixed $index индекс ошибки в массиве ошибок
	 * @return string Текст ошибки
	 *
	 */
	static public function GetErrorByIndex($index)
	{
		if( !isset(self::$_errors[$index]) )
			return "";
		return self::GetErrorAnchor($index) . self::$_errors[$index];
	}
	
	/**
	 * Возвращает текст ошибки по индексу без якоря
	 *
	 * @param mixed $index индекс ошибки в массиве ошибок
	 * @return string Текст ошибки
	 *
	 */
	static public function GetErrorByIndexWithoutAnchor($index)
	{
		if( !isset(self::$_errors[$index]) )
			return "";
		return self::$_errors[$index];
	}
	
	/**
	 * Есть ли ошибки
	 *
	 * @return bool true - ошибки есть, false - ошибок нет
	 *
	 */
	static public function IsError()
	{
		return count(self::$_errors)>0;
	}
	
	/**
	 * Есть ли критическая ошибка
	 *
	 * @return bool true - есть, false - нет
	 *
	 */
	static public function IsCritical()
	{
		return self::$_critical;
	}
	
	public function __get($name)
	{
		switch($name)
		{
		case 'ERRORS':
			return self::$_errors;
		}
	}

	public static function getMe()
	{
		if( self::$_me === null )
			self::$_me = new self;
		return self::$_me;
	}
	
}


UserError::getMe();
//2do: нужно убрать
UserError::$Errors =& $ERROR;

define('ERR_TEXT', 0);
UserError::$Errors[ERR_TEXT] = '%s';


