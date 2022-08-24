<?
/**
 * Небольшие методы обработки текста
 */

class TextUtil
{
    static public $translate_simbols = array(
		'ru' => array(
			'ц', 'Ц', 'ш', 'щ', 'Ш', 'Щ', 'ж', 'Ж', 'э', 'я', 'ч', 'ю', 'ё', 'Э', 'Я', 'Ч', 'Ю', 'Ё', 'й', 'у', 'к', 'е', 'н', 'г', 'з', 'х', 'ъ', 'ф', 'ы', 'в', 'а', 'п', 'р', 'о', 'л', 'д', 'с', 'м', 'и', 'т', 'ь', 'б', 'Й', 'У', 'К', 'Е', 'Н', 'Г', 'З', 'Х', 'Ъ', 'Ф', 'Ы', 'В', 'А', 'П', 'Р', 'О', 'Л', 'Д', 'С', 'М', 'И', 'Т', 'Ь', 'Б'
		),
		'en' => array(
			'ts', 'Ts', 'sh', 'sh', 'Sh', 'Sh', 'zh', 'Zh', 'ye', 'ja', 'ch', 'yu', 'yo', 'Ye', 'Ja', 'Ch', 'Yu', 'Yo', 'i', 'u', 'k', 'e', 'n', 'g', 'z', 'h', "'", 'f', 'y', 'v', 'a', 'p', 'r', 'o', 'l', 'd', 's', 'm', 'i', 't', "'", 'b', 'I', 'U', 'K', 'E', 'N', 'G', 'Z', 'H', "'", 'F', 'Y', 'V', 'A', 'P', 'R', 'O', 'L', 'D', 'S', 'M', 'I', 'T', "'", 'B'
		),
	);

	/**
	 * Транслитит строку
	 * 
	 * @param string $str исходня строка
	 * @param string $from имя языка, из которого преобразовывать
	 * @param string $to имя языка, в который преобразовывать
	 * @return string результативная строка
	 */
	static public function Translit($str, $from = 'ru', $to = 'en')
	{
		$from_arr = self::$translate_simbols[$from];
		array_walk($from_arr, create_function('&$v,$k', ' $v = "@".addslashes($v)."@";'));

		return preg_replace($from_arr, self::$translate_simbols[$to], $str);
	}
	
	static function GenerateRandomString($len = 6)
	{
		$str = '';
		for($i = 1; $i <= $len; $i++)
		{
			$r = round(rand(0,61)) + 48;
			if($r > 57) $r = $r + 7;
			if($r > 90) $r += 6;
			$str .= chr($r);
		}
		return $str;
	}

}

?>