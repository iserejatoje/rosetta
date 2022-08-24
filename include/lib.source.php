<?php

class Source
{
	static function GetData($source, $params)
	{
		global $CONFIG, $OBJECTS;
		
		$source = str_replace(':','.',$source);
		if(is_file($CONFIG['engine_path']."include/source/$source.php"))
		{
			include_once $CONFIG['engine_path']."include/source/$source.php";
			$source = str_replace('.','_',$source);
			return call_user_func('source_'.$source, $params);
		}
		else
			return false;
	}
}

?>