<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* Файл:     modifier.copyright_date.php
* Тип:      modifier
* Имя:      copyright_date
* Назначение:  Вставка годов копирайта, например 2005-2007
*
* IN: дата начала копирайта
* -------------------------------------------------------------
*/
function smarty_modifier_copyright_date($string)
{
    if (empty($string)) {
        $smarty->trigger_error("modifier copyright_date: missing 'date_start' parameter");
        return;
    }

    $date_now = date("Y");
		if( intval($date_now) <= intval($string) )
	    return $string;
		else
	    return $string."-".$date_now;
}
?>