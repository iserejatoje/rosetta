{literal}
<?

class My {
	
	/**
	 * параметры подключения к базе данных
	 */
	public static $db = array(
		'host' => 'localhost',
		'name' => 'db_name',
		'user' => 'username',
		'pass' => 'password',
	);
	
	/**
	 * массивы преобразования данных
	 */
{/literal}
	public static $prepare_sale = array(
		'rub' => array(
{foreach from=$CONFIG.arrays.rubrics item=l key=k}
			'{$l}' => {$k},
{/foreach}
		),
		'objects' => array(
{foreach from=$CONFIG.arrays.objects item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'regions' => array(
{foreach from=$CONFIG.arrays.regions item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'series' => array(
{foreach from=$CONFIG.arrays.series item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'build_type' => array(
{foreach from=$CONFIG.arrays.build_type item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'status' => array(
{foreach from=$CONFIG.arrays.status item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'age_build' => array(
{foreach from=$CONFIG.arrays.age_build item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'stage' => array(
{foreach from=$CONFIG.arrays.stage item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'decoration' => array(
{foreach from=$CONFIG.arrays.decoration item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'site_unit' => array(
{foreach from=$CONFIG.arrays.site_unit item=l key=k}
			'{$l}' => {$k},
{/foreach}
		),
		'price_unit' => array(
{foreach from=$CONFIG.arrays.price_unit item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'lavatory' => array(
{foreach from=$CONFIG.arrays.lavatory item=l key=k}
			'{$l.b}' => {$k},
{/foreach}
		),
		'floors' => array(
{foreach from=$CONFIG.arrays.floors item=l key=k}
			'{$l}' => {$l},
{/foreach}
		),
		'floor' => array(
{foreach from=$CONFIG.arrays.floors item=l key=k}
			'{$l}' => {$l},
{/foreach}
		),
{literal}
	);

	/**
	 * Кодировка исходных данных
	 */
	public static $charset = 'windows-1251';
	

	
	/**
	 * Служебные переменные
	 */
	public static $db_link = null;
	public static $xml = null;
	public static $internal_charset = 'UTF-8';
	

}

function generate()
{
	// выбираем объявления из БД
	$sql = "SELECT * FROM [your_table] LIMIT 10000";
	if( ($res = mysql_query($sql, My::$db_link)) === false )
	{
		put_error("не могу выбрать данные из базы");
		return false;
	}
	
	// создаем документ XML
	My::$xml = new DOMDocument('1.0', My::$internal_charset);
	My::$xml->formatOutput = true;
	
	$root = My::$xml->appendChild(My::$xml->createElement('Export-Sale'));
	$root->appendChild(My::$xml->createElement('Date', date('c')));
	$xml_list = $root->appendChild(My::$xml->createElement('Advertises'));
	// выбираем каждую запись
	while($row = mysql_fetch_assoc($res))
	{
		// создаем объект объявления 
		$elem = My::$xml->createElement('Adv');
		$elem->setAttribute('ID', prepare_int($row['id']));
		/**
		 * Обязательные поля
		 */
		// Рубрика
		$elem->appendChild(My::$xml->createElement('Rub', prepare_array($row['rub'], 'rub')));
		// Тип жилья
		$elem->appendChild(My::$xml->createElement('Object', prepare_array($row['object'], 'objects')));
		// Район
		$elem->appendChild(My::$xml->createElement('Region', prepare_array($row['region'], 'regions')));
		// Серия
		$elem->appendChild(My::$xml->createElement('Series', prepare_array($row['series'], 'series')));
		// Тип дома
		$elem->appendChild(My::$xml->createElement('Build-type', prepare_array($row['build_type'], 'build_type')));
		// Состояние
		$elem->appendChild(My::$xml->createElement('Status', prepare_array($row['status'], 'status')));
		// Стадия строительства
		$elem->appendChild(My::$xml->createElement('Stage', prepare_array($row['stage'], 'stage')));
		// Адрес (Доп. информация о месторасположении)
		$elem->appendChild(prepare_text($row['address'], 'Address'));
		// Площадь помещения (кв.м.)
		$elem->appendChild(My::$xml->createElement('Area-Build', prepare_float($row['area_build'])));
		// Этажность помещения
		$elem->appendChild(My::$xml->createElement('Floor', prepare_float($row['floor'])));
		// Этажность дома
		$elem->appendChild(My::$xml->createElement('Floors', prepare_float($row['floors'])));
		// Площадь участка
		$elem->appendChild(My::$xml->createElement('Area-Site', prepare_float($row['area_site'])));
		// Площадь участка (ед. измерения)
		$elem->appendChild(My::$xml->createElement('Area-Site-Unit', prepare_array($row['area_site_unit'], 'site_unit')));
		// Контакты
		$elem->appendChild(prepare_text($row['contacts'], 'Contacts'));
		
		/**
		 * Необязательные поля
		 */
		// Доп. информация
		$elem->appendChild(prepare_text($row['description'], 'Description'));
		// Возможность продажи по ипотеке
		$elem->appendChild(My::$xml->createElement('Ipoteka', ($row['ipoteka']?1:0))));
		// Цена
		$elem->appendChild(My::$xml->createElement('Price', prepare_float($row['price'])));
		// price_unit
		$elem->appendChild(My::$xml->createElement('Price-Unit', prepare_value($row['price_unit'], 'price_unit')));
		// Возраст дома
		$elem->appendChild(My::$xml->createElement('Age-Build', prepare_value($row['age_build'], 'age_build')));
		// Отделка
		$elem->appendChild(My::$xml->createElement('Decoration', prepare_value($row['decoration'], 'decoration')));
		// Санузел
		$elem->appendChild(My::$xml->createElement('Lavatory', prepare_value($row['lavatory'], 'lavatory')));
		// Телефон
		$elem->appendChild(My::$xml->createElement('Phone', ($row['phone']?1:0)));
		// Балкон
		$elem->appendChild(My::$xml->createElement('Balcony', ($row['balcony']?1:0)));
		// Лифт
		$elem->appendChild(My::$xml->createElement('Elevator', ($row['lift']?1:0)));
		// Домофон
		$elem->appendChild(My::$xml->createElement('Intercom', ($row['comm']?1:0)));
		// Сигнализация
		$elem->appendChild(My::$xml->createElement('Alarm', ($row['sign']?1:0)));
		// Мебель
		$elem->appendChild(My::$xml->createElement('Furniture', ($row['mebel']?1:0)));
		// Фотографии $row['img'] - должен быть полный адрес до картинки. например: http://domchel.ru/images/sale/1.jpg
		$imgs = My::$xml->createElement('Images');
		if(isset($row['img']))
		{
			$imgs->appendChild(My::$xml->createElement('Image', $row['img']));
		}
		$elem->appendChild($imgs);
		unset($imgs);
		
		// добавляем объект объявления в список 
		$xml_list->appendChild($elem);
	}
	echo My::$xml->saveXML();
}

function prepare_array($value, $arr_key = null)
{
	if(isset(My::$prepare_sale[$arr_key]) && isset(My::$prepare_sale[$arr_key][$value])) 
		return My::$prepare_sale[$arr_key][$value];
	else
		return null;
	return $value;
}

function prepare_int($value)
{
	return intval($value);
}

function prepare_float($value)
{
	return floatval($value);
}

function prepare_value($value)
{
	if( is_array($value) )
	{
		foreach ($value as $k=>$v)
		{
			if(is_array($v) || is_object($v))
				$v = 'значение слишком глубокое';
			$value[$k] = convert_charset(htmlspecialchars($v));
		}
		return $value;
	}
	else
		return convert_charset(htmlspecialchars($value));
}

function prepare_text($value, $name)
{
	$desc = My::$xml->createElement($name);
	$desc->appendChild(My::$xml->createCDATASection(prepare_value($value)));
	return $desc;
}

function convert_charset($value)
{
	if(My::$charset === My::$internal_charset)
		return $value;
	else 
		return iconv(My::$charset, My::$internal_charset, $value); 
}

function db_open()
{
	if(My::$db_link !== null)
		return true;

	My::$db_link = mysql_connect(My::$db['host'], My::$db['user'], My::$db['pass']);
	if( My::$db_link === false )
	{
		put_error("Не могу соединиться с БД.");
		return false;
	}
	
	if( mysql_select_db(My::$db['name'], My::$db_link) === false )
	{
		put_error("Не могу выбрать БД '".My::$db['name']."'.");
		return false;
	}
	
	return true;
}
function db_close()
{
	if(My::$db_link === null)
		return false;

	return mysql_close(My::$db_link);
}

function put_error($msg)
{
	echo $msg."\n";
}



// Подключаемся к базе данных
if( db_open() === false )
	exit; 
// Генерируем XML
generate();
// отключаемся от базы данных
if( db_close() === false )
	exit; 



?>
{/literal}