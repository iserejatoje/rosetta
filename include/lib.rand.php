<?
// просто рандомайзер всякостей
class Rand
{
	const GRS_CMD_CONST = 1;
	const GRS_CMD_SYMBOL = 2;
	const GRS_CMD_RANGE = 3;

	const GRS_SET_ALPHA = 1;
	const GRS_SET_DIGIT = 2;
	
	static $Rules;
	
	// случайная строка по правилам
	static function RandStrByRule($rule)
	{
		$cnt = 0;
		$scnt = 0;
		$buf = "";
		// алгоритм пока один
		foreach($rule as $v)
		{
			switch($v['cmd'])
			{
			case self::GRS_CMD_CONST:
				$buf.= $v['tset'];
				break;
			case self::GRS_CMD_SYMBOL:
				if($v['max'] != $v['min'])
					$cnt = rand($v['min'], $v['max']);
				else
					$cnt = $v['min'];
				for($j = 0; $j < $cnt; $j++)
					$buf.= substr($v['tset'], rand(0, strlen($v['tset']) - 1), 1);
				break;
			case self::GRS_CMD_RANGE:
				if($v['max'] != $v['min'])
					$cnt = rand($v['min'], $v['max']);
				else
					$cnt = $v['min'];
				$scnt = -1;
				if($v['set'] & self::GRS_SET_ALPHA)
					$scnt+= 26;
				if($v['set'] & self::GRS_SET_DIGIT)
					$scnt+= 10;
				if($scnt == 0 || $cnt == 0)
					break;
				for($j = 0; $j < $cnt; $j++)
				{
					$code = rand(0, $scnt);
					$code+= 48; // двинули до числа
					if(!($v['set'] & self::GRS_SET_DIGIT) && $v['set'] & self::GRS_SET_ALPHA)
						$code+= 49;
					else if($v['set'] & self::GRS_SET_DIGIT && $v['set'] & self::GRS_SET_ALPHA && $code > 57)
						$code+= 39;
					$buf.= chr($code);
				}
				break;
			}
		}
		
		return $buf;
	}
}

Rand::$Rules = array(
	'banner_js' => array(
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 2, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 0, 'max' => 1, 'tset' => "-/.",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 2, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "imva",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 3, 'max' => 5, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
	),
	'banner_single' => array(
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 2, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 0, 'max' => 1, 'tset' => "-/.",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 2, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "strx",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 3, 'max' => 5, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
	),
/*
	'banner_js' => array(
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 0, 'max' => 1, 'tset' => "-/.",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 2, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "jbeh",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 3, 'max' => 5, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
	),
	'banner_single' => array(
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 0, 'max' => 1, 'tset' => "-/.",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 2, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 4, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA, 'min' => 2, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_DIGIT, 'min' => 1, 'max' => 3, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "strx",),
		array('cmd' => Rand::GRS_CMD_RANGE, 'set' => Rand::GRS_SET_ALPHA | Rand::GRS_SET_DIGIT, 'min' => 3, 'max' => 5, 'tset' => '',),
		array('cmd' => Rand::GRS_CMD_SYMBOL, 'set' => 0, 'min' => 1, 'max' => 1, 'tset' => "/",),
	),
*/
);

?>