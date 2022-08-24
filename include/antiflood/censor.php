<?

// незакончена работа, будет использоваться библиотек censor

class AntiFloodProvider_censor extends AAntiFloodProvider
{
	public function CheckRule($rule, $data = null)
	{
		global $OBJECTS;
		TRACE::Log('Censor');
		if(is_array($rule['fields']))
		{
			foreach($rule['fields'] as $key)
			{
				TRACE::Log('Key: '.$key);
				if(strpos($key, 'get.') === 0)
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
					if($vv != 'aaa')
						return false;
				}
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