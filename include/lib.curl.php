<?
class Lib_Curl
{
	private $_proxy = null;
	private $_params = array(
		'type' => 'module',				// module || command
		'follow_redirect' => true,
		'silent' => true,
		'no_error' => true,
		'agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
		'cookie' => '',					// cookie data || cokie file name
		'referrer' => '',
		'httpheader' => array(
			'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Encoding: none',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7',
		),
		'get_headers' => false, 		// get headers too
		'print_command' => false, 		// print curl command
		'use_proxy' => false, 			// get using proxy from proxy list
		'query' => null, 				// array of post data
		'url' => '',
		'retry' => 5, 					// retry count
		'timeout' => 30,
		'only_proxy' => false, 			// get only via proxy!
		'username' => null, 			// user name for http-autentificalion
		'password' => null				// password for http-autentification
	);

	public $_error = '';

	public $_errno = 0;
	private $_bad_proxy_code = array(7, 52, 28); // if curl return this code then proxy is bad
	private $_error_text = array(
		1 => 'Unsupported protocol. This build of curl has no support for this protocol.',
		2 => 'Failed to initialize.',
		3 => 'URL malformat. The syntax was not correct.',
		4 => 'URL user malformatted. The user-part of the URL syntax was not correct.',
		5 => 'Couldn\'t resolve proxy. The given proxy host could not be resolved.',
		6 => 'Couldn\'t resolve host. The given remote host was not resolved.',
		7 => 'Failed to connect to host.',
		8 => 'FTP weird server reply. The server sent data curl couldn\'t parse.',
		9 => 'FTP access denied. The server denied login.',
		10 => 'FTP user/password incorrect. Either one or both were not accepted by the server.',
		11 => 'FTP weird PASS reply. Curl couldn\'t parse the reply sent to the PASS request.',
		12 => 'FTP weird USER reply. Curl couldn\'t parse the reply sent to the USER request.',
		13 => 'FTP weird PASV reply, Curl couldn\'t parse the reply sent to the PASV request.',
		14 => 'FTP weird 227 format. Curl couldn\'t parse the 227-line the server sent.',
		15 => 'FTP can\'t get host. Couldn\'t resolve the host IP we got in the 227-line.',
		16 => 'FTP can\'t reconnect. Couldn\'t connect to the host we got in the 227-line.',
		17 => 'FTP couldn\'t set binary. Couldn\'t change transfer method to binary.',
		18 => 'Partial file. Only a part of the file was transfered.',
		19 => 'FTP couldn\'t download/access the given file, the RETR (or similar) command failed.',
		20 => 'FTP write error. The transfer was reported bad by the server.',
		21 => 'FTP quote error. A quote command returned error from the server.',
		22 => 'HTTP page not retrieved. The requested url was not found or returned another error with the HTTP error code being 400 or above.\n This return code only appears if -f/--fail is used.',
		23 => 'Write error. Curl couldn\'t write data to a local filesystem or similar.',
		24 => 'Malformed user. User name badly specified.',
		25 => 'FTP couldn\'t STOR file. The server denied the STOR operation, used for FTP uploading.',
		6 => 'Read error. Various reading problems.',
		27 => 'Out of memory. A memory allocation request failed.',
		28 => 'Operation timeout. The specified time-out period was reached according to the conditions.',
		29 => 'FTP couldn\'t set ASCII. The server returned an unknown reply.',
		30 => 'FTP PORT failed. The PORT command failed. Not all FTP servers support the PORT command, try doing a transfer using PASV instead!',
		31 => 'FTP couldn\'t use REST. The REST command failed. This command is used for resumed FTP transfers.',
		32 => 'FTP couldn\'t use SIZE. The SIZE command failed. The command is an extension to the original FTP spec RFC 959.',
		33 => 'HTTP range error. The range "command" didn\'t work.',
		34 => 'HTTP post error. Internal post-request generation error.',
		35 => 'SSL connect error. The SSL handshaking failed.',
		36 => 'FTP bad download resume. Couldn\'t continue an earlier aborted download.',
		37 => 'FILE couldn\'t read file. Failed to open the file. Permissions?',
		38 => 'LDAP cannot bind. LDAP bind operation failed.',
		39 => 'LDAP search failed.',
		40 => 'Library not found. The LDAP library was not found.',
		41 => 'Function not found. A required LDAP function was not found.',
		42 => 'Aborted by callback. An application told curl to abort the operation.',
		43 => 'Internal error. A function was called with a bad parameter.',
		44 => 'Internal error. A function was called in a bad order.',
		45 => 'Interface error. A specified outgoing interface could not be used.',
		46 => 'Bad password entered. An error was signaled when the password was entered.',
		47 => 'Too many redirects. When following redirects, curl hit the maximum amount.',
		48 => 'Unknown TELNET option specified.',
		49 => 'Malformed telnet option.',
		51 => 'The remote peer\'s SSL certificate wasn\'t ok',
		52 => 'The server didn\'t reply anything, which here is considered an error.',
		53 => 'SSL crypto engine not found',
		54 => 'Cannot set SSL crypto engine as default',
		55 => 'Failed sending network data',
		56 => 'Failure in receiving network data',
		57 => 'Share is in use (internal error)',
		58 => 'Problem with the local certificate',
		59 => 'Couldn\'t use specified SSL cipher',
		60 => 'Problem with the CA cert (path? permission?)',
		61 => 'Unrecognized transfer encoding',
		62 => 'Invalid LDAP URL',
		63 => 'Maximum file size exceeded',
	);

	public function Init()
	{
		//LibFactory::GetStatic('networkutils');
	}

	public function setParams($params = array())
	{
		if(!is_array($params))
			return false;

		if(sizeof($params)>0)
			foreach($params as $k=>$v)
				$this->_params[$k] = $v;

		return true;
	}

	public function generate_query($params = array())
	{
		if(!is_array($params))
			return false;

		$post = "";
		foreach($params as $k=>$v)
			$post.= ($post==""?"":"&").$k."=".urlencode($v);

		unset($k, $v, $params);
		return $post;
	}

	public function generate_cookie($params = array())
	{
		if(!is_array($params))
			return false;

		$post = "";
		foreach($params as $k=>$v)
			$post.= ($post==""?"":"; ").urlencode($k)."=".urlencode($v);

		unset($k, $v, $params);
		return $post;
	}

	public function query($params = array())
	{
		if(!is_array($params))
			return false;

		$_params = $this->_params;
		if(sizeof($params)>0)
			foreach($params as $k=>$v)
				$_params[$k] = $v;
		unset($k, $v, $params);

		if($_params['url'] == '')
		{
			error_log("Please specify the URL.");
			return false;
		}

		if($_params['type'] == 'module')
		{
			if(!extension_loaded('curl'))
				@dl("curl.".PHP_SHLIB_SUFFIX);
			if(!extension_loaded('curl'))
			{
				error_log("Curl php module not found.");
				return false;
			}
		}
		else if($_params['type'] == 'command')
		{
			if( preg_match("@on@", strtolower(ini_get('safe_mode'))) )
			{
				error_log("exec() forbidden, because php in SAFE_MODE");
				return false;
			}
			if( preg_match("@exec@", strtolower(ini_get('disable_functions'))) )
			{
				error_log("exec() forbidden by disable_functions directive [php.ini]");
				return false;
			}
			$info = @shell_exec("curl -V");
			if( !preg_match("@^curl [\d\.]+@", $info) )
			{
				error_log("curl not found: ".$info);
				return false;
			}
		}
		else
		{
			error_log("Please specify the type of curl query (module|command)");
			return false;
		}

		if($_params['use_proxy'] && $this->_proxy === null)
		{
			$this->_proxy = LibFactory::GetInstance('proxy');
			$this->_proxy->Init();
		}

		if(is_array($_params['query']))
			$_params['query'] = $this->generate_query($_params['query']);
		else if(!is_string($_params['query']))
			$_params['query'] = '';

		if(is_array($_params['cookie']))
			$_params['cookie'] = $this->generate_cookie($_params['cookie']);
		else if(!is_string($_params['cookie']))
			$_params['cookie'] = '';

		if($_params['type'] == 'module')
			return $this->_query_module($_params);
		else if($_params['type'] == 'command')
			return $this->_query_command($_params);
		else
			return false;
	}

	private function _query_command(&$params)
	{
		$cmd = "curl";
		if($params['follow_redirect'])
			$cmd.= " -L";
		if($params['no_error'])
			$cmd.= " -f";
		if($params['silent'])
			$cmd.= " -s";
		if(is_integer($params['timeout']))
			$cmd.= " --max-time ".$params['timeout'];
//			$cmd.= " --connect-timeout ".$params['timeout']; - это работает как то не так... вообще не работает
		if($params['agent'])
			$cmd.= " -A \"".$params['agent']."\"";
		if($params['cookie']!='')
		{
			if(is_file($params['cookie']))
				$cmd.= " -c \"".$params['cookie']."\"";
			if($params['cookie'])
				$cmd.= " -b \"".$params['cookie']."\"";
		}
		if($params['referrer'])
			$cmd.= " -e \"".$params['referrer']."\"";
		if($params['get_headers'])
			$cmd.= " -i";
		if($params['query']!='')
			$cmd.= " -d \"".$params['query']."\"";

		if ( $params['username'] )
		{
			$cmd.= " -u ".$params['username'];
			if ( $params['password'] )
				$cmd.= ":".$params['password'];
		}

		if($params['url'])
			$cmd.= ' "'.$params['url'].'"';

		$this->_params['referrer'] = $params['url'];

/*
		if(!$params['use_proxy'])
		{
			$host = @parse_url($params['url'], PHP_URL_HOST);
			if($host === false)
			{
				echo "Url ".$params['url']." is bad.\n";
				return false;
			}
			$port = @parse_url($params['url'], PHP_URL_PORT);
			if($port === false)
				$port = 80;
			if(!NetworkUtils::is_host_reachable($host, $port))
			{
				echo $host.":".$port." is unreacable.\n";
				return false;
			}
			unset($host, $port);
		}
*/

		$i = 0;
		while($params['retry'] > $i)
		{
			$prrr = "";
			if($params['use_proxy'])
				if(($proxy = $this->_proxy->GetProxy()) !== false)
				{
					//error_log("VIA-PROXY: ".$proxy);
					$prrr = " -x ".$proxy;
				}
			if($params['only_proxy'] && $proxy == false)
			{
				error_log("lib.curl error: no proxy in DB");
				break;
			}
/*
			if($params['use_proxy'] && $proxy !== false)
			{
				if(!NetworkUtils::is_host_reachable($proxy))
				{
					$this->_proxy->Bad($proxy);
					echo $proxy." is unreacable.\n";
					$i++;
					continue;
				}
			}
*/
			if($params['print_command'])
				echo "CMD: ".$cmd.$prrr."\n";

			exec($cmd.$prrr, $info, $ret);
			if(is_array($info))
				$info = implode("\n", $info);
			else
				$info = "";
			$this->_errno = $ret;
			if($this->_errno!=0)
			{
				if($params['use_proxy'])
					if(in_array($this->_errno, $this->_bad_proxy_code) && $proxy !== false)
						$this->_proxy->Bad($proxy);
				$this->_error = $this->_error_text[$this->_errno];
				error_log("Curl error: (".$this->_errno.") ".$this->_error);
			}
			else
				break;
			$i++;
		}

		unset($proxy, $i, $err, $prrr, $cmd, $ret);
		unset($cmd);
		return $info;
	}

	private function _query_module($params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);// return into a variable

		if(is_integer($params['timeout']))
			curl_setopt($ch, CURLOPT_TIMEOUT, $params['timeout']);

		if($params['follow_redirect'])
		{
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		}

		if(is_array($params['httpheader']) && sizeof($params['httpheader']))
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $params['httpheader']); //send header
		}
		if($params['no_error'])
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		if($params['silent'])
			curl_setopt($ch, CURLOPT_MUTE, 1);
		if($params['agent'])
			curl_setopt($ch, CURLOPT_USERAGENT, $params['agent']);
		if($params['cookie']!='')
		{
			if(is_file($params['cookie']))
			{
				curl_setopt($ch, CURLOPT_COOKIEFILE, $params['cookie']);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $params['cookie']);
			}
			else
				curl_setopt($ch, CURLOPT_COOKIE, $params['cookie']);
		}
		if($params['referrer'])
			curl_setopt($ch, CURLOPT_REFERER, $params['referrer']);
		if($params['get_headers'])
			curl_setopt($ch, CURLOPT_HEADER, 1);
		if($params['no_body'])
			curl_setopt($ch, CURLOPT_NOBODY, 1);
		if($params['query']!='')
		{
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params['query']); // add POST fields
		}
		else
			curl_setopt($ch, CURLOPT_POST, 0); // set GET method

		if ( $params['username'] )
			curl_setopt($ch, CURLOPT_USERPWD, $params['username'].( $params['password'] ? ":".$params['password'] : "" ));

		if($params['url'])
			curl_setopt($ch, CURLOPT_URL, $params['url']);

		$this->_params['referrer'] = $params['url'];

/*
		if(!$params['use_proxy'])
		{
			$host = @parse_url($params['url'], PHP_URL_HOST);
			if($host === false)
			{
				echo "Url ".$params['url']." is bad.\n";
				return false;
			}
			$port = @parse_url($params['url'], PHP_URL_PORT);
			if($port === false)
				$port = 80;
			if(!NetworkUtils::is_host_reachable($host, $port))
			{
				echo $host.":".$port." is unreacable.\n";
				return false;
			}
			unset($host, $port);
		}
*/

		$info = "";
        $i = 0;
		while($params['retry'] > $i)
		{
			if($params['use_proxy'])
				if(($proxy = $this->_proxy->GetProxy()) !== false)
				{
					//error_log("VIA-PROXY: ".$proxy);
					curl_setopt($ch, CURLOPT_PROXY, $proxy);
				}
			if($params['only_proxy'] && $proxy == false)
			{
				error_log("lib.curl error: no proxy in DB");
				break;
			}
/*
			if($params['use_proxy'] && $proxy !== false)
			{
				if(!NetworkUtils::is_host_reachable($proxy))
				{
					$this->_proxy->Bad($proxy);
					echo $proxy." is unreacable.\n";
					$i++;
					continue;
				}
			}
*/
			$info = curl_exec($ch); // run the whole process
			$this->_errno = curl_errno($ch);
			if($this->_errno!=0 || $info === false)
			{
				if($params['use_proxy'])
					if(in_array($this->_errno, $this->_bad_proxy_code) && $proxy !== false)
						$this->_proxy->Bad($proxy);
				$this->_error = curl_error($ch);
				if($this->_error == '')
					$this->_error = $this->_error_text[$this->_errno];
				error_log("Curl error: (".$this->_errno.") ".$this->_error);
			}
			else
				break;
			$i++;
		}
		curl_close($ch);

		unset($ch, $proxy, $i, $err);
		return $info;
	}

}

