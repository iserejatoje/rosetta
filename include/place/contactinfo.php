<?php
LibFactory::GetStatic('fieldsstruct');

/**
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:22
 */
class ContactInfo extends lib_fieldsstruct
{
	/**
	 * выставляет допустимые поля
	 * array('name','phone','fax','email','url')
	 */
	public function __construct()
	{
		parent::__construct(array('name','phone','fax','email','url'));
	}

	function __destruct()
	{
	}
}
?>