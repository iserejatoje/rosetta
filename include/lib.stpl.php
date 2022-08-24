<?

class STPL // StupidTPL
{
	static private $cfg = array();
	
	const DefaultTheme = 'default';
	
	const ThemeExists		= 2;
	const DefualtExists		= 1;
	const NotExists			= 0;
	
	static function SetTheme($theme = null)
	{
		if($theme === null)
			unset(self::$cfg['theme']);
			
		if(is_string($theme))
			self::$cfg['theme'] = $theme;
	}
	
	static function GetTheme()
	{
		return self::$cfg['theme'];
	}
	
	static function IsTemplate($template)
	{
		if( !empty(self::$cfg['theme']) && is_file(ENGINE_PATH.'templates/stpl/'.self::$cfg['theme'].'/'.$template.'.php'))
			return self::ThemeExists;
		elseif(is_file(ENGINE_PATH.'templates/stpl/'.self::DefaultTheme.'/'.$template.'.php'))
			return self::DefualtExists;
		else
			return self::NotExists;
	}
	

	static protected function GetTemplate($template)
	{
		if(!empty(self::$cfg['theme']))
		{
			$file = ENGINE_PATH.'templates/stpl/'.self::$cfg['theme'].'/'.$template.'.php';
			if( is_file($file) )
				return $file;
		}
		
		$file = ENGINE_PATH.'templates/stpl/'.self::DefaultTheme.'/'.$template.'.php';
		if( is_file($file) )
			return $file;
		
		Data::e_backtrace('Template not found in ' . 
					ENGINE_PATH.'templates/stpl/'.self::$cfg['theme'].'/'.$template.'.php and ' . 
					ENGINE_PATH.'templates/stpl/'.self::DefaultTheme.'/'.$template.'.php');
		
		return false;
	}

	
	static public function Fetch($template, $vars = array())
	{
		$file = self::GetTemplate($template);		
		if( $file !== false )
			return STPL_Helper::Fetch_Template($file, $vars);
		return '';
	}
	
	
	static public function Display($template, $vars = array())
	{
		$file = self::GetTemplate($template);
		if( $file !== false )
			STPL_Helper::Display_Template($file, $vars);
	}

	
}

class STPL_Helper
{
	
	static public function Fetch_Template($template, $vars)
	{
		ob_start();
		include($template);
		return ob_get_clean();
	}
	
	static public function Display_Template($template, $vars)
	{
		include($template);
		return true;
	}
	
}
?>