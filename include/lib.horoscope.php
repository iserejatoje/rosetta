<?

class lib_horoscope
{
	private $SectionId = 0;
	private $_config = null;		// конфиг раздела
	//private $_db;

	public $signstart = array(
		1 => 21,
		2 => 20,
		3 => 20,
		4 => 20,
		5 => 20,
		6 => 21,
		7 => 21,
		8 => 22,
		9 => 23,
		10 => 23,
		11 => 23,
		12 => 22,
	);
	
	public $signlist = array(
		1 => array(
			'name'	=> 'aries',
			'title'	=> 'Овен',
			'img'	=> '2oven.gif',
		),
		2 => array(
			'name' 	=> 'taurus',
			'title'	=> 'Телец',
			'img'	=> '2telets.gif',
		),
		3 => array(
			'name' 	=> 'gemini',
			'title'	=> 'Близнецы',
			'img'	=> '2bliznetsi.gif',
		),
		4 => array(
			'name' 	=> 'cancer',
			'title'	=> 'Рак',
			'img'	=> '2rak.gif',
		),
		5 => array(
			'name' 	=> 'leo',
			'title'	=> 'Лев',
			'img'	=> '2lev.gif',
		),
		6 => array(
			'name' 	=> 'virgo',
			'title'	=> 'Дева',
			'img'	=> '2deva.gif',
		),
		7 => array(
			'name' 	=> 'libra',
			'title'	=> 'Весы',
			'img'	=> '2vesi.gif',
		),
		8 => array(
			'name' 	=> 'scorpio',
			'title'	=> 'Скорпион',
			'img'	=> '2skorpion.gif',
		),
		9 => array(
			'name' 	=> 'sagittarius',
			'title'	=> 'Стрелец',
			'img'	=> '2strelets.gif',
		),
		10 => array(
			'name' 	=> 'capricorn',
			'title'	=> 'Козерог',
			'img'	=> '2kozerog.gif',
		),
		11 => array(
			'name' 	=> 'aquarius',
			'title'	=> 'Водолей',
			'img'	=> '2vodoley.gif',
		),
		12 => array(
			'name'	=> 'pisces',
			'title'	=> 'Рыбы',
			'img'	=> '2ribi.gif',
		),
	);


	function __construct()
	{
	}

	/**
	 * Инициализация
	 * @param int идентификатор раздела сайта
	 */
	public function Init($sectionid=4973)
	{
		LibFactory::GetStatic('data');
		if(!Data::Is_Number($sectionid))
		{
			/*Data::e_backtrace("SectionID '".$sectionid."' passed to ".__CLASS__." is incorrect.");
			return false;*/
		}

		$this->SectionId = $sectionid;

		$this->_config = ModuleFactory::GetConfigById('section', $this->SectionId);
		//$this->_db = DBFactory::GetInstance($this->_config['db']);

		return true;
	}

	/**
	 * Получение знака зодиака на заданную дату
	 */
	public function GetZodiacByDate($date)
	{
		if ( !$date )
			return false;
		
		$day = date("j", $date);
		$month = date("n", $date);
		$signId = 0;
		//$signId = ( ($day < $this->signstart[$month]) ? ($month-1) : ($month%12) );
		//trace::log($signId);
		
		if ($month == 1 && $day <=20) {$signId = 10;}
		elseif ($month == 1 && $day >=21) {$signId = 11;}
		elseif ($month == 2 && $day <=20) {$signId = 11;}
		elseif ($month == 2 && $day >=21) {$signId = 12;}
		elseif ($month == 3 && $day <=20) {$signId = 12;}
		elseif ($month == 3 && $day >=21) {$signId = 1;}
		elseif ($month == 4 && $day <=20) {$signId = 1;}
		elseif ($month == 4 && $day >=21) {$signId = 2;}
		elseif ($month == 5 && $day <=20) {$signId = 2;}
		elseif ($month == 5 && $day >=21) {$signId = 3;}
		elseif ($month == 6 && $day <=21) {$signId = 3;}
		elseif ($month == 6 && $day >=22) {$signId = 4;}
		elseif ($month == 7 && $day <=22) {$signId = 4;}
		elseif ($month == 7 && $day >=23) {$signId = 5;}
		elseif ($month == 8 && $day <=23) {$signId = 5;}
		elseif ($month == 8 && $day >=24) {$signId = 6;}
		elseif ($month == 9 && $day <=23) {$signId = 6;}
		elseif ($month == 9 && $day >=24) {$signId = 7;}
		elseif ($month == 10 && $day <=23) {$signId = 7;}
		elseif ($month == 10 && $day >=24) {$signId = 8;}
		elseif ($month == 11 && $day <=22) {$signId = 8;}
		elseif ($month == 11 && $day >=23) {$signId = 9;}
		elseif ($month == 12 && $day <=21) {$signId = 9;}
		elseif ($month == 12 && $day >=22) {$signId = 10;}

		if ( empty($this->signlist[$signId]) )
			return false;
		
		$sign = $this->signlist[$signId];
		$sign['id'] = $signId;
		$sign['icon_path'] = $this->_config['icon_dir'].$sign['img'];
		$sign['icon_sm_path'] = $this->_config['icon_dir_sm'].$sign['img'];
		
		return $sign;
	}
	/*
	* Получение зодиака по идентификатору
	*/
	public function GetZodiacByID($signId)
	{
		if ( $signId <= 0 )
			return false;

		if ( empty($this->signlist[$signId]) )
			return false;
		
		$sign = $this->signlist[$signId];
		$sign['id'] = $signId;
		$sign['icon_path'] = $this->_config['icon_dir'].$sign['img'];
		$sign['icon_sm_path'] = $this->_config['icon_dir_sm'].$sign['img'];
		
		return $sign;
	}
}

?>