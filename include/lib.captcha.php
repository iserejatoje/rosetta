<?
/**
 * CAPTCHA для второй версии движка
 */
class lib_captcha
{
	public $config = array(
		'font' => "resources/fonts/DejaVuSans.ttf",
		);
	
	function __construct()
	{
	}
	
	// {{{ html code generation
	/**
	 * генерация кода
	 *
	 * @access public
	 * @return string
	 */
	function get_code($key = null)
	{
		global $OBJECTS;
		LibFactory::GetStatic('textutil');
		$code = rand(1000, 9999);
		$code = strtolower($code);
		
		if (!empty($key))
			$OBJECTS['user']->Session['captcha_code_'.$key] = $code;
		else
			$OBJECTS['user']->Session['captcha_code'] = $code;

		return $code;
	}
	
	function get_path($key = null)
	{
		if (!empty($key))
			return '/site/captcha/'.$key.'/';
		return '/site/captcha/';
	}
	
	// }}}
	
	/**
	 * проверка правильности кода
	 *
	 * @access public
	 * @param int $user_value значение введенное пользователем
	 * @return bool результат
	 */
	function is_valid($user_value = null)
	{
		global $OBJECTS;
		
		$user_value = strtoupper($user_value);
		
		if (isset($_REQUEST['captcha_key'])) {
			$session_value = $OBJECTS['user']->Session['captcha_code_'.$_REQUEST['captcha_key']];
			unset($OBJECTS['user']->Session['captcha_code_'.$_REQUEST['captcha_key']]);
		} else {
			$session_value = $OBJECTS['user']->Session['captcha_code'];
			unset($OBJECTS['user']->Session['captcha_code']);
		}

		if($user_value == null)
			$user_value = strtoupper($_REQUEST['captcha_code']);
		
		if(strlen($session_value) != 4 && strlen($user_value) != 4)
			return false;
		
		return $session_value == $user_value;
	}
	
	/**
	 * генерация изображения
	 *
	 * @access public
	 * @param int $value число на картинке
	 */
	function get_image($value)
	{
		$width = 150;                  //Ширина изображения
		$height = 50;                  //Высота изображения
		$font_size = 13.5;   			//Размер шрифта
		$let_amount = 6;               //Количество символов, которые нужно набрать
		$fon_let_amount = 40;          //Количество символов, которые находятся на фоне
		 
		$letters = array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','9');
		$colors = array('10','30','50','70','90','110','130','150','170','190','210');

		$src = imagecreatetruecolor($width,$height);
		$fon = imagecolorallocate($src,241,249,254);
		imagefill($src,0,0,$fon);


		for($i=0;$i<$fon_let_amount;$i++)
		{
			$color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),105); 
			$letter = $letters[rand(0,sizeof($letters)-1)];
			$size = rand($font_size-2,$font_size+2);
			imagettftext($src,$size,rand(0,45),rand($width*0.1,$width-$width*0.1),rand($height*0.2,$height),$color,$this->config['font'],$letter);
		}

		for($i = 0, $len = strlen($value); $i < $len; $i++)
		{
			$color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],$colors[rand(0,sizeof($colors)-1)],$colors[rand(0,sizeof($colors)-1)],rand(0,10)); 
			$letter = $value{$i};
			$size = rand($font_size*2.1-2,$font_size*2.1+2);
			$x = $i*25 + rand(30,35);
			$y = (($height*2)/3) + rand(0,5);			
			imagettftext($src,$size,rand(0,10),$x,$y,$color,$this->config['font'],$letter);
		}

		return $src;
	}
}

?>