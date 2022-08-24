<?


class NetworkUtils
{
	public static function ping($host, $port = null, $return = 1)
	{
		$arr = explode(":", $host);
		if(sizeof($arr)>1)
		{
			$host = $arr[0];
			$port = $arr[1];
		}
		unset($arr);
		if(empty($host))
		{
			if($return == 2)
				return "Host $host is bad.";
			else
				return false;
		}
		
		// Making the package
		$type= "\x08";
		$code= "\x00";
		$checksum= "\x00\x00";
		$identifier = "\x00\x00";
		$seqNumber = "\x00\x00";
		$data= "Scarface";
		$package = $type.$code.$checksum.$identifier.$seqNumber.$data;
		$checksum = self::icmpChecksum($package); // Calculate the checksum
		$package = $type.$code.$checksum.$identifier.$seqNumber.$data;

		$socket = socket_create(AF_INET, SOCK_RAW, 1);
		if(socket_connect($socket, $host, $port) === false)
		{
			if($return == 2)
			{
				$err = "Ping err: (".socket_last_error().") ".socket_strerror(socket_last_error());
				socket_close($socket);
				return $err;
			}
			else
			{
				socket_close($socket);
				return false;
			}
		}
		$startTime = microtime(true);
		socket_send($socket, $package, strLen($package), 0);
		if (socket_read($socket, 255))
		{
			if($return == 2)
			{
				$err = round(microtime(true) - $startTime, 4) .' seconds';
				socket_close($socket);
				return $err;
			}
			else
			{
				socket_close($socket);
				return true;
			}
		}
		else
		{
			if($return == 2)
			{
				$err = "Ping err: (".socket_last_error().") ".socket_strerror(socket_last_error());
				socket_close($socket);
				return $err;
			}
			else
			{
				socket_close($socket);
				return false;
			}
		}
	}

	public static function icmpChecksum($data)
	{
		if (strlen($data)%2)
			$data .= "\x00";
	
		$bit = unpack('n*', $data);
		$sum = array_sum($bit);
	
		while ($sum >> 16)
			$sum = ($sum >> 16) + ($sum & 0xffff);
	
		return pack('n*', ~$sum);
	}


	public static function is_host_reachable($host, $port = null, $return = 1)
	{
		if(is_string($host))
			$arr = explode(":", $host);
		if( is_array($arr) && sizeof($arr)>1 )
		{
			$host = $arr[0];
			$port = $arr[1];
		}
		unset($arr);
		if(empty($host))
		{
			if($return == 2)
				return "Host $host is bad.";
			else
				return false;
		}
		if($port === null)
		{
			if($return == 2)
				return "Please specify a port.";
			else
				return false;
		}
		
		$fp = @fsockopen($host, $port, $errno, $errstr, 3);
		if($fp === false)
		{
			if($return == 2)
				return "(".$errno.") ".$errstr;
			else
				return false;
		}
		else
		{
			fclose($fp);
			if($return == 2)
				return "Good host";
			else
				return true;
		}
	}

}

?>