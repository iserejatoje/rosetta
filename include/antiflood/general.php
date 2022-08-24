<?
class AntiFloodProvider_general extends AAntiFloodProvider
{
	public function CheckRule($rule, $data = null)
	{
		global $OBJECTS;
		foreach($rule as $key => $value)
		{
			$vn = null;
			if($key == 'user')
			{
				if($OBJECTS['user']->IsAuth())
				{					
					if($value != 'auth') return false;					
				}
				else
				{					
					if($value == 'auth') return false;					
				}
            }
			elseif(strpos($key, 'get.') === 0)
			{
				$vn = substr($key, 4);
				$vv = $_GET[$vn];
            }
			elseif(strpos($key, 'post.') === 0)
			{
				$vn = substr($key, 5);
				$vv = $_POST[$vn];
            }
			elseif(strpos($key, 'request.') === 0)
			{
				$vn = substr($key, 8);
				$vv = $_REQUEST[$vn];
            }
			elseif(strpos($key, 'cookie.') === 0)
			{
				$vn = substr($key, 7);
				$vv = $_COOKIE[$vn];
            }
			elseif(strpos($key, 'server.') === 0)
			{
				$vn = substr($key, 7);
				$vv = $_SERVER[$vn];
            }
			elseif($data !== null && strpos($key, 'data.') === 0)
			{
				$vn = substr($key, 5);
				$vv = $data[$vn];
            }
			if($vn !== null)
			{
				if($vv != $value)
					return false;
            }
        }
		
		return true;
    }

	public function ModifyScore($score, $rule)
	{
		if(!isset($rule['multiply']))
			$rule['multiply'] = 1;
		$score['score'] = $score['score'] * $rule['multiply'] + $rule['add'];
		return $score;
    }
}
?>