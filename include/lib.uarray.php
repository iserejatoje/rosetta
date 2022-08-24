<?

class UArray
{
	// группа функций для перевода массива в линейный и обратно
	// ключи будут формироваться через /
	public static function ToLinear($arr)
	{
		return self::convToLinear($arr);
	}
	
	private static function convToLinear($arr, $key = '')
	{
		if(!is_array($arr) || count($arr) == 0)
			return array();
			
		$_arr = array();
		
		foreach($arr as $k => $v)
		{
			if(is_array($v))
				$_arr = array_merge($_arr, self::convToLinear($v, self::mergeKey($key, $k)));
			else
				$_arr[self::mergeKey($key, $k)] = $v;
		}
		return $_arr;
	}
	
	private static function mergeKey($k1, $k2)
	{
		if(strlen($k1) > 0)
			return $k1.'/'.self::escapeKey($k2);
		else
			return self::escapeKey($k2);
	}
	
	private static function escapeKey($k)
	{
		return str_replace('/', '%2F', $k);
	}
	
	private static function unescapeKey($k)
	{
		return str_replace('%2F', '/', $k);
	}
	
	// в случае ошибки вернет null
	// например для массива с элементами
	// item => 1
	// item/1 => 2
	public static function FromLinear($arr)
	{
		$_arr = array();
		if(!is_array($arr) || count($arr) == 0)
			return $arr;
		foreach($arr as $k => $v)
		{
			$key = explode('/', $k);
			if(self::setValue($_arr, $key, $v) === false)
				return null;
		}
		return $_arr;
	}
	
	private static function setValue(&$arr, $k, $v)
	{
		$key = self::unescapeKey(array_shift($k));
		if(count($k) > 0)
		{
			if(isset($arr[$key]) && !is_array($arr[$key]))
				return false;
			if(self::setValue($arr[$key], $k, $v) === false)
				return false;
		}
		else
		{
			if(isset($arr[$key]))
				return false;
			$arr[$key] = $v;
		}
	}

	public static function sortByKeyName(array &$arr, $name, $sort_flags = SORT_STRING) {
	
		self::_sortByKeyName(null, null, $name, $sort_flags);
		uasort($arr, array('self', '_sortByKeyName'));
	}

	protected function _sortByKeyName($a, $b, $n = null, $sort_flags = SORT_STRING) {
		static $name, $sf;
		
		if ($n === null) {
			if (SORT_STRING == $sf)
				return strcasecmp($a[$name], $b[$name]);
			else if (SORT_REGULAR == $sf) {
				if ($a[$name] == $b[$name])
					return 0;
			
				return ($a[$name] <= $b[$name] ? -1 : 1);
			} else
				return 0;
		}

		$name = $n;
		$sf = $sort_flags;
	}
	
	public static function rsortByKeyName(array &$arr, $name, $sort_flags = SORT_STRING) {
	
		self::_sortByKeyName(null, null, $name, $sort_flags);
		uasort($arr, array('self', '_rsortByKeyName'));
	}

	protected function _rsortByKeyName($a, $b, $n = null, $sort_flags = SORT_STRING) {
		static $name, $sf;
		
		if ($n === null) {
			if (SORT_STRING == $sf) {
				$r = strcasecmp($a[$name], $b[$name]);
				
				if ($r == 0)
					return 0;
					
				return ($r == -1 ? 1 : -1);
			} else if (SORT_REGULAR == $sf) {
				if ($a[$name] == $b[$name])
					return 0;
			
				return ($a[$name] <= $b[$name] ? 1 : -1);
			} else
				return 0;
		}

		$name = $n;
		$sf = $sort_flags;
	}
	
	/**
	* Рекурсивно сортирует массив
	*/
	public static function ksortRecursive(array &$arr) {
		ksort($arr, SORT_STRING);
		array_walk($arr, array('self','_ksortRecursive'));
	}
	
	protected static function _ksortRecursive(&$i, $k) {
		if (!is_array($i))
			return $i;

		ksort($i, SORT_STRING);
		array_walk($i, array('self','_ksortRecursive'));
	}
}
?>