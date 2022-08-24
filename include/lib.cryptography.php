<?

class Cryptography
{
	static $__xsx_code = array(0x5A, 0x37, 0x92);
	
	static function xsx_encode($n)
	{
		$y1 = rand(0,255);
		$y2 = rand(0,255);
		if(strlen($n) < 4)
		{
			$i1 = 0;
			$i2 = strlen($n) + 1;
		}
		else 
		{
			$i1 = 2;
			$i2 = 4;
		}
		
		$c = 0;
		$_y1 = $y1;
		for($i = 0; $i < strlen($n); $i++)
		{
			$x = ord(substr($n, $i, 1));
			$x^= self::$__xsx_code[0];
			$x-= self::$__xsx_code[1];
			if($x < 0)
				$x += 256;
			$x^= self::$__xsx_code[2];
			$x+= $_y1;
			if($x >=256)
				$x-= 256;
			$x^= $y2;
			if($c == $i1)
			{
				$s.= chr($y1);$c++;
			}
			if($c == $i2)
			{
				$s.= chr($y2);$c++;
			}
			$_y2*= 2;
			if($_y1 >= 256)
				$_y1-= 256;
			$_y1+= $y2;
			if($_y1 >= 256)
				$_y1-= 256;
			$s.= chr($x);
			$c++;
		}
		
		if(strlen($n) < 4)
			$s.= chr($y2);
		return $s;
	}
	

	function xsx_decode($n)
	{
		if(strlen($n) < 6)
		{
			$y1 = ord(substr($n,0,1));
			$i1 = 0;
			$y2 = ord(substr($n,strlen($n)-1,1));
			$i2 = strlen($n) - 1;
		}
		else
		{		
			$y1 = ord(substr($n,2,1));
			$i1 = 2;
			$y2 = ord(substr($n,4,1));
			$i2 = 4;
		}
		
		$_y1 = $y1;
		for($i = 0; $i < strlen($n); $i++)
		{
			if($i == $i1 || $i == $i2)
				continue;
			$x = ord(substr($n, $i, 1));
			$x^= $y2;
			$x-= $_y1;
			if($x < 0)
				$x+= 256;
			$x^= self::$__xsx_code[2];
			$x+= self::$__xsx_code[1];
			if($x >= 256)
				$x-= 256;		
			$x^= self::$__xsx_code[0];
			$_y2*= 2;
			if($_y1 >= 256)
				$_y1-= 256;
			$_y1+= $y2;
			if($_y1 >= 256)
				$_y1-= 256;
			$s.= chr($x);
		}
		return $s;
	}
}

?>