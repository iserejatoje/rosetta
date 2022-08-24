<?
	if(is_file($CONFIG['engine_path']."include/WideImage/WideImage.php"))
	{
		include_once $CONFIG['engine_path']."include/WideImage/WideImage.php";
	}
	else
		return false;