<?

class PRights_news_magic extends PRightsProvider
{
	static private $possible = array(
		'всем'
	);
		
	public function GetPossible()
	{
		return self::$possible;
    }

	public function GetRights($params)
	{
		$rights = array(0,1);
		return $rights;
    }
	
	public function GetDefault()
	{
		return 1;
	}
}

?>