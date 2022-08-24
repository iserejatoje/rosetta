<?

class MailConfig
{
	private static $Config = array(
		'14.ru' => array(
			'sectionid' => 177,
		),
		'116.ru' => array(
			'sectionid' => 350,
		),
		'ufa1.ru' => array(
			'sectionid' => 473,
		),
		'yarsk1.ru' => array(
			'sectionid' => 3176,
		),
		'kbs.ru' => array(
			'sectionid' => 3176,
		),
		'26.ru' => array(
			'sectionid' => 178,
		),
		'29.ru' => array(
			'sectionid' => 179,
		),
		'v1.ru' => array(
			'sectionid' => 491,
		),
		'35.ru' => array(
			'sectionid' => 157,
		),
		'38.ru' => array(
			'sectionid' => 158,
		),
		'42.ru' => array(
			'sectionid' => 159,
		),
		'43.ru' => array(
			'sectionid' => 160,
		),
		'45.ru' => array(
			'sectionid' => 161,
		),
		'48.ru' => array(
			'sectionid' => 162,
		),
		'51.ru' => array(
			'sectionid' => 163,
		),
		'53.ru' => array(
			'sectionid' => 164,
		),
		'154.ru' => array(
			'sectionid' => 3898,
		),
		'omsk1.ru' => array(
			'sectionid' => 423,
		),
		'56.ru' => array(
			'sectionid' => 165,
		),
		'59.ru' => array(
			'sectionid' => 131,
		),
		'60.ru' => array(
			'sectionid' => 166,
		),
		'161.ru' => array(
			'sectionid' => 435,
		),
		'rostov1.ru' => array(
			'sectionid' => 435,
		),
		'62.ru' => array(
			'sectionid' => 167,
		),
		'63.ru' => array(
			'sectionid' => 130,
		),
		'ekat.ru' => array(
			'sectionid' => 176,
		),
		'68.ru' => array(
			'sectionid' => 168,
		),
		'70.ru' => array(
			'sectionid' => 169,
		),
		'71.ru' => array(
			'sectionid' => 170,
		),
		'72.ru' => array(
			'sectionid' => 171,
		),
		'74.ru' => array(
			'sectionid' => 115,
		),
		'chel.ru' => array(
			'sectionid' => 115,
		),
		'chelyabinsk.ru' => array(
			'sectionid' => 115,
		),
		'autochel.ru' => array(
			'sectionid' => 115,
		),
		'chelfin.ru' => array(
			'sectionid' => 115,
		),
		'mychel.ru' => array(
			'sectionid' => 115,
		),
		'domchel.ru' => array(
			'sectionid' => 115,
		),
		'2074.ru' => array(
			'sectionid' => 115,
		),
		'cheldiplom.ru' => array(
			'sectionid' => 115,
		),
		'75.ru' => array(
			'sectionid' => 172,
		),
		'76.ru' => array(
			'sectionid' => 173,
		),
		'178.ru' => array(
			'sectionid' => 821,
		),
		'neva1.ru' => array(
			'sectionid' => 821,
		),
		'86.ru' => array(
			'sectionid' => 174,
		),
		'89.ru' => array(
			'sectionid' => 175,
		),
		'93.ru' => array(
			'sectionid' => 820,
		),
		'sochi1.ru' => array(
			'sectionid' => 1024,
		),
		'mgorsk.ru' => array(
			'sectionid' => 4274,
		),
		'tolyatty.ru' => array(
			'sectionid' => 4644,
		),
		'sterlitamak1.ru' => array(
			'sectionid' => 9982,
		),
	);
	
	
	/**
	 * Возвращает SectionId раздела обслуживающего Email
	 * 
	 * @param string $email email
	 * @return int
	 */
	public static function GetSectionIdByEmail($email)
	{
		$email = strtolower($email);
		if(!Data::Is_Email($email))
			return false;
		
		list(, $domain) = explode("@", $email);

		if ( isset(self::$Config[$domain]) )
			return self::$Config[$domain]['sectionid'];
		else
			return null;
	}
	
}

?>
