<?

// слегка кастомная реализация base64, нет дополнения левыми символоми и можно таблицу поменять когда захоца
class basex64
{
	static private $table = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-";
	// получение длинны, для закодированного блока и раскодированного, зачем в пхп, даже не знаю
	public static function EncodeLength($len)
	{
		if($len % 3 > 0)
			return ($len + 3 - $len % 3) * 4 / 3;
		else
			return $len * 4 / 3;
	}

	public static function DecodeLength($len)
	{
		if($len % 4 > 0)
			return ($len + 4 - $len % 4) * 3 / 4;
		else
			return $len * 3 / 4;
	}

	public static function Encode($src)
	{
		$pos_src = 0;
		$len_src = strlen($src);
		while(true)
		{
			$dst.= substr(self::$table, ord($src[$pos_src]) >> 2, 1);
			if($len_src == 1)
			{
				$dst.= substr(self::$table, (ord($src[$pos_src]) & 0x03) << 4, 1);
				break;
			}
			$dst.= substr(self::$table, (ord($src[$pos_src + 1]) >> 4) + ((ord($src[$pos_src]) & 0x03) << 4), 1);
			if($len_src == 2)
			{
				$dst.= substr(self::$table, (ord($src[$pos_src + 1]) & 0x0F) << 2, 1);
				break;
			}
			$dst.= substr(self::$table, (ord($src[$pos_src + 2]) >> 6) + ((ord($src[$pos_src + 1]) & 0x0F) << 2), 1);
			$dst.= substr(self::$table, ord($src[$pos_src + 2]) & 0x3F, 1);

			if($len_src <= 3)
				break;
			$len_src-= 3;
			$pos_src+= 3;
		}
		return $dst;
	}

	// 4 > 3
	//$0	1 >> 4 + 0 << 2
	//$1	1 << 4 + 2 >> 2
	//$2	2 << 6 + 3
	public static function Decode($src)
	{
		$pos_src = 0;
		$len_src = strlen($src);
		while(true)
		{
			if($len_src >= 1) $c0 = strpos(self::$table, $src[$pos_src]);		else $c0 = 0;
			if($len_src >= 2) $c1 = strpos(self::$table, $src[$pos_src + 1]);	else $c1 = 0;
			if($len_src >= 3) $c2 = strpos(self::$table, $src[$pos_src + 2]);	else $c2 = 0;
			if($len_src >= 4) $c3 = strpos(self::$table, $src[$pos_src + 3]);	else $c3 = 0;
			if($len_src == 1)
			{
				$dst.= chr($c0 << 2);
				break;
			}
			$dst.= chr(($c1 >> 4) + ($c0 << 2));
			if($len_src == 2)
			{
				$dst.= chr($c1 << 4);
				break;
			}
			$dst.= chr(($c1 << 4) + ($c2 >> 2));
			if($len_src == 3)
			{
				$dst.= chr($c2 << 6);
				break;
			}
			$dst.= chr(($c2 << 6) + $c3);

			if($len_src <= 4)
				break;
			$len_src-= 4;
			$pos_src+= 4;
		}
		return $dst;
	}
}
?>