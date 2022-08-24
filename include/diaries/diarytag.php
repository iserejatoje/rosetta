<?php

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 13:24 19 ноября 2009 г.
 */
class DiaryTag
{
	public $ID						= null;
	public $Name					= null;
	public $Points					= null;
	
	function __construct(array $info) {
						
		$info = array_change_key_case($info, CASE_LOWER);
				
		if ( isset($info['tagid']) && Data::Is_Number($info['tagid']) )
			$this->ID = $info['tagid'];
				
		$this->Name		= $info['name'];		
		$this->Points		= $info['points'];	
	}

	public function __set($name, $value) {
		
		return null;
	}
	
	
	public function __get($name) {
	
		return null;
	}
	
	
	function __destruct() {

	}
}
?>