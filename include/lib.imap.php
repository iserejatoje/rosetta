<?
/**
* Библиотека работы с IMAP
* Пределана из Iloha IMAP Library (IIL)
* (C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
*
* PURPOSE:
*		Provide alternative IMAP library that doesn't rely on the standard 
*		C-Client based version.  This allows IlohaMail to function regardless
*		of whether or not the PHP build it's running on has IMAP functionality
*		built-in.
*	USEAGE:
*		Function containing "C_" in name require connection handler.
*		To obtain connection handler, use $this->Connect()
* 
* @date		$Date: 2006/09/10 13:00:00 $
*/

/**
* Зависимости:
* Lib:
*		utf7
* 
*/

LibFactory::GetStatic('utf7');

class Lib_imap
{
	static $Name             = "imap";
	public $error            = 0;
	public $errornum         = 0;
	public $selected         = 0;
	public $conn             = null;
	private $timeout         = 2;
	private $stream_timeout  = 3;
	private $icl_ssl         = 0;
	private $icl_port        = "143";
	private $body_types      = array(
		0 => "",
		1 => "HEADER",
		2 => "MIME",
		3 => "TEXT",
	);
	public $verbose          = 0;

	function Lib_imap()
	{
		global $CONFIG, $LCONFIG;
		
		LibFactory::GetConfig(self::$Name);
		$this->_config = $LCONFIG[self::$Name];
		if(isset($this->_config["icl_ssl"]))
			$this->icl_ssl = $this->_config["icl_ssl"];
		if(isset($this->_config["icl_port"]))
			$this->icl_port = $this->_config["icl_port"];
		if(isset($this->_config["ignore_folders"]))
			$this->ignore_folders = $this->_config["ignore_folders"];
		
		if($_GET['debug'] == 3)
			$this->verbose = 1;
	}


	function SplitHeaderLine($string)
	{
		$pos = strpos($string, ":");
		if($pos !== false)
		{
			$res[0] = substr($string, 0, $pos);
			$res[1] = trim(substr($string, $pos+1));
			return $res;
		}
		else
			return array('', '');
	}

	function ExplodeQuotedString($delimiter, $string)
	{
		$quotes = explode("\"", $string);
		while ( list($key, $val) = each($quotes))
			if (($key % 2) == 1) 
				$quotes[$key] = str_replace($delimiter, "_!@!_", $quotes[$key]);
		$string = implode("\"", $quotes);

		$result = explode($delimiter, $string);
		while ( list($key, $val) = each($result) )
			$result[$key] = str_replace("_!@!_", $delimiter, $result[$key]);

		return $result;
	}

	/**
	* считывает строку ответа сервера
	* считывает до встречи символа \n
	*/
	function ReadLine($size)
	{
		$line="";
		if ($this->conn->fp)
			do{
				$buffer = fgets($this->conn->fp, 1024);
				$endID = strlen($buffer) - 1;
				$end = ($buffer[$endID] == "\n");
				$line .= $buffer;
			}while(!$end);
		if($this->verbose)
			error_log('IMAP <:'.$line);
		//Trace::Log('<font color="green">IMAP <:'.$line.'</font>');
		return $line;
	}

	/**
	* Посылает серверу строку
	*/
	function WriteLine($line)
	{
		if($this->verbose)
			error_log('IMAP >:'.$line);
		//Trace::Log('<font color="red">IMAP >:'.$line.'</font>');
		if ($this->conn->fp)
			return fputs($this->conn->fp, $line);
		return false;
	}

	/**
	* считывает ответ сервера в несколько строк
	*/
	function ReadReply()
	{
		do{
			$line = chop(trim($this->ReadLine(1024)));
		}while($line[0]=="*");
		return $line;
	}

	/**
	* Разбирает ответ сервера
	* @return 
	*  0 - OK
	* -1 - NO
	* -2 - BAD
	* -3 - No result
	*/
	function ParseResult($string)
	{
		$a = explode(" ", $string);
		if (count($a) > 2){
			if (strcasecmp($a[1], "OK")==0)
				return 0;
			else if (strcasecmp($a[1], "NO"))
				return -1;
			else if (strcasecmp($a[1], "BAD"))
				return -2;
		}
		else
			return -3;
	}

	/**
	* check if $string starts with $match
	*/
	function StartsWith($string, $match)
	{
		if ($string[0] == $match[0])
		{
			$pos = strpos($string, $match);
			if ( $pos === false)
				return false;
			else if ( $pos == 0)
				return true;
			else
				return false;
		}
		else
			return false;
	}

	function C_Authenticate($user, $pass, $encChallenge)
	{
		// initialize ipad, opad
		for($i = 0; $i < 64; $i++){
			$ipad .= chr(0x36);
			$opad .= chr(0x5C);
		}
		
		// pad $pass so it's 64 bytes
		$padLen = 64 - strlen($pass);
		for($i = 0; $i < $padLen; $i++)
			$pass .= chr(0);
		
		// generate hash
		$hash = md5($this->my_xor($pass,$opad) . pack("H*", md5($this->my_xor($pass, $ipad) . base64_decode($encChallenge))));
		
		// generate reply
		$reply = base64_encode($user." ".$hash);

		// send result, get reply
		$this->WriteLine($reply."\r\n");
		$line = $this->ReadLine(1024);

		// process result
		if ($this->ParseResult($line)==0)
		{
			$this->conn->error .= "";
			$this->conn->errorNum = 0;
			return true;
		}
		else
		{
			$this->conn->error .= "Authentication failed (AUTH): <br>\"".$line."\"";
			$this->conn->errorNum = -2;
			return false;
		}
	}

	function C_Login($user, $password)
	{

		$this->WriteLine("a001 LOGIN $user \"$password\"\r\n");

		do{
			$line = $this->ReadReply($this->conn->fp);
		}while(!$this->StartsWith($line, "a001 "));

		if( $this->ParseResult($line) === 0 )
		{
			$this->conn->error .= "";
			$this->conn->errorNum = 0;
			return true;
		}
		else
		{
			fclose($this->conn->fp);
			$this->conn->error .= "Authentication failed (LOGIN):<br>\"".$line."\"";
			$this->conn->errorNum = -2;
			return false;
		}
	}

	function Connect($host, $user, $password)
	{	
		
		$this->error = "";
		$this->errornum = 0;

		//strip slashes
		$user = stripslashes($user);
		$password = stripslashes($password);

		//set auth method
		$auth_method = "plain";
		if (func_num_args() >= 3)
		{
			$auth_array = func_get_arg(2);
			if (is_array($auth_array))
				$auth_method = $auth_array["imap"];
			if (empty($auth_method))
				$auth_method = "plain";
		}
		$message = "INITIAL: $auth_method\n";
		$result = false;
		
		//initialize connection
		$this->conn = new iilConnection;
		$this->conn->error = "";
		$this->conn->errorNum = 0;
		$this->conn->selected = "";
		$this->conn->host = $host;

		//check input
		if (empty($host))
			$this->error .= "Invalid host<br>\n";
		if (empty($user))
			$this->error .= "Invalid user<br>\n";
		if (empty($password))
			$this->error .= "Invalid password<br>\n";

		if (!empty($this->error))
			return false;

		//check for SSL
		if ($this->icl_ssl)
			$host = "ssl://".$host;

		//open socket connection
		$this->conn->fp = fsockopen($host, $this->icl_port, $this->conn->errorNum, $this->conn->error, $this->timeout);
		if ($this->conn->fp)
		{
			// здесь можно попробовать ставить $this->stream_timeout (на чтение и запись данных)
			//stream_set_timeout($this->conn->fp, $this->stream_timeout);
			
			$this->error .= "Socket connection established\r\n";
			$line = $this->ReadLine(300);

			if (strcasecmp($auth_method, "check")==0)
			{
				//check for supported auth methods

				//default to plain text auth
				$auth_method = "plain";

				//check for CRAM-MD5
				$this->WriteLine("cp01 CAPABILITY\r\n");
				do{
					$line = trim(chop($this->ReadLine(100)));
					$a = explode(" ", $line);
					if ($line[0]=="*")
						while ( list($k, $w) = each($a) )
							if ( (strcasecmp($w, "AUTH=CRAM_MD5")==0)	|| (strcasecmp($w, "AUTH=CRAM-MD5")==0)	)
								$auth_method = "auth";
				}while($a[0] != "cp01");
			}

			if (strcasecmp($auth_method, "auth")==0)
			{
				$this->conn->message .= "Trying CRAM-MD5\n";

				//do CRAM-MD5 authentication
				$this->WriteLine("a000 AUTHENTICATE CRAM-MD5\r\n");
				$line = trim(chop($this->ReadLine(1024)));
				if ($line[0]=="+")
				{
					$this->conn->message .= "Got challenge: $line\n";
					//got a challenge string, try CRAM-5
					$result = $this->C_Authenticate($user, $password, substr($line,2));
					$this->conn->message.= "Tried CRAM-MD5: $result \n";
				}
				else
				{
					$this->conn->message .= "No challenge ($line), try plain\n";
					$auth = "plain";
				}
			}

			if ( ($result === false) || (strcasecmp($auth, "plain")==0) )
			{
				//do plain text auth
				$result = $this->C_Login($user, $password);
				$this->conn->message .= "Tried PLAIN: $result \n";
			}

			$this->conn->message .= $auth;

			if($result === false)
			{
				$this->error = $this->conn->error;
				$this->errornum = $this->conn->errorNum;
			}
		}
		else
		{
			$this->error = $this->conn->error;//"Could not connect to $host at port $this->icl_port";
			$this->errornum = $this->conn->errorNum;//-1;
			return false;
		}

		if ($result === false)
			return false;
		else
			return true;
	}

	function Close()
	{
//		if ($this->WriteLine("A341 CLOSE\r\n")) {
//			fgets($this->conn->fp, 1024);
//		}
		if ($this->WriteLine("I LOGOUT\r\n")){
			$this->ReadLine(1024);
			fclose($this->conn->fp);
		}
	}

	function ClearCache($user, $host)
	{
	}

	function C_CreateFolder($folder)
	{
		if ($this->WriteLine("c CREATE \"".Lib_utf7::EncodeString($folder)."\"\r\n"))
		{
			do{
				$line=$this->ReadLine(300);
			}while($line[0]!="c");
			if($this->ParseResult($line)===0)
				return true;
			else
				$this->conn->error = $line;
		}
		return false;
	}

	function C_RenameFolder($from, $to)
	{
		if ($this->WriteLine("r RENAME \"".Lib_utf7::EncodeString($from)."\" \"".Lib_utf7::EncodeString($to)."\"\r\n"))
		{
			do{
				$line=$this->ReadLine(300);
			}while($line[0]!="r");
			if($this->ParseResult($line)===0)
				return true;
			else
				$this->conn->error = $line;
		}
		return false;
	}

	function C_DeleteFolder($folder)
	{
		if ($this->WriteLine("d DELETE \"".Lib_utf7::EncodeString($folder)."\"\r\n"))
		{
			do{
				$line=$this->ReadLine(300);
			}while($line[0]!="d");
			if($this->ParseResult($line)===0)
				return true;
			else
				$this->conn->error = $line;
		}
		return false;
	}

	function C_ClearFolder($folder)
	{
		$num_in_trash = $this->C_CountMessages($folder);
		if ($num_in_trash > 0)
		{
			if($this->C_Delete($folder, "1:".$num_in_trash))
				if($this->C_Expunge($folder))
					return true;
		}
		else
			return true;
		return false;
	}

	/**
	* Удаляем сообщения, помеченные как удаленые (\\Deleted)
	*/
	function C_Expunge($mailbox)
	{
		if ($this->C_Select($mailbox))
		{
			$c = 0;
			$this->WriteLine("exp1 EXPUNGE\r\n");
			do{
				$line = chop($this->ReadLine(100));
				if ($line[0]=="*")
					$c++;
			}while (!$this->StartsWith($line, "exp1"));
			
			if ($this->ParseResult($line) === 0)
				return $c;
			else
			{
				$this->conn->error = '$this->C_Expunge: '.$line;
				return false;
			}
		}
		
		return false;
	}

	/**
	* Помечает влагами сообщения
	* @param 
	* mailbox - почтовый ящик (папка)
	* messages - список сообщений (1,2,3 | 1:3)
	* flag - флаг
	* method - 1) только добавить этот флаг
	*          2) только убрать этот флаг
	*          3) убратьвсе флаги и поставить только этот
	*/
	function C_Flag($mailbox, $messages, $flag, $method = 0)
	{
		$methods = array(
			0 => "+",
			1 => "-",
			2 => "",
		);
		$flags = array(
			"SEEN"=>"\\Seen",
			"DELETED"=>"\\DELETED",
			"RECENT"=>"\\RECENT",
			"ANSWERED"=>"\\Answered",
			"DRAFT"=>"\\Draft",
			"FLAGGED"=>"\\Flagged",
		);
		$flag = strtoupper($flag);
		$flag = $flags[$flag];
		if(!array_key_exists($method, $methods))
			$method = 0;
		if ($this->C_Select($mailbox))
		{
			$c = 0;
			$this->WriteLine("del".$method."1 STORE $messages ".$methods[$method]."FLAGS (".$flag.")\r\n");
			do{
				$line = chop($this->ReadLine(100));
				if ($line[0]=="*")
					$c++;
			}while (!$this->StartsWith($line, "del".$method."1"));
			
			if ($this->ParseResult($line) === 0)
				return $c;
			else
			{
				$this->conn->error = $line;
				return false;
			}
		}
		else
		{
			$this->conn->error = "Select failed 1";
			return false;
		}
	}

	/**
	* Помечает письма удаленными
	* @param 
	* mailbox - почтовый ящик (папка)
	* messages - список сообщений (1,2,3 | 1:3)
	*/
	function C_Delete($mailbox, $messages)
	{
		return $this->C_Flag($mailbox, $messages, "DELETED", 0);
	}

	function C_Undelete($mailbox, $messages)
	{
		return $this->C_Flag($mailbox, $messages, "DELETED", 1);
	}

	function C_Unseen($mailbox, $message)
	{
		return $this->C_Flag($mailbox, $messages, "SEEN", 1);
	}

	function C_Copy($messages, $from, $to)
	{
		if ($this->C_Select($from))
		{
			$c = 0;
			$this->WriteLine("cpy1 COPY $messages \"".Lib_utf7::EncodeString($to)."\"\r\n");
			$line = $this->ReadReply();
			if($this->ParseResult($line)!==0)
			{
				$this->conn->error = "$this->C_Copy: ".$line."<br>\n";
				return false;
			}
			else
				return true;
		}
		else
			return false;
	}

	/**
	* перпеместим сообщение
	* (скопируем, удалим, очистим)
	*/
	function C_Move($messages, $from, $to)
	{
		if($this->C_Copy($messages, $from, $to))
			if( $this->C_Delete($from, $messages) )
				if( $this->C_Expunge($from) )
					return true;
		return false;
	}

	function C_Subscribe($folder)
	{
		$query = "sub1 SUBSCRIBE \"".Lib_utf7::EncodeString($folder)."\"\r\n";
		$this->WriteLine($query);
		$line = trim(chop($this->ReadLine(10000)));
		if($this->ParseResult($line)===0)
			return true;
		return false;
	}

	function C_UnSubscribe($folder)
	{
		$query = "usub1 UNSUBSCRIBE \"".Lib_utf7::EncodeString($folder)."\"\r\n";
		$this->WriteLine($query);
		$line = trim(chop($this->ReadLine(10000)));
		if($this->ParseResult($line)===0)
			return true;
		return false;
	}

	function C_Append($folder, $message)
	{
		$message = str_replace("\r", "", $message);
		$message = str_replace("\n", "\r\n", $message);		

		$len = strlen($message);
		$request = "A APPEND \"".Lib_utf7::EncodeString($folder)."\" (\\Seen) {".$len."}\r\n";
		if ($this->WriteLine($request))
		{
			$line = $this->ReadLine(100);

			$sent = fwrite($this->conn->fp, $message."\r\n");
			fflush($this->conn->fp);
			do{
				$line = $this->ReadLine(1000);
			}while($line[0]!="A");

			if($this->ParseResult($line)===0)
				return true;
			else
				$this->conn->error .= $line."<br>\n";
		}
		else
			$this->conn->error .= "Couldn't send command \"$request\"<br>\n";
		return false;
	}

	function C_ListMailboxes($ref, $mailbox, $subscribed = false)
	{
		$folders = array();

		if($subscribed)
			$com = "LSUB";
		else
			$com = "LIST";
		
		if (empty($mailbox))
			$mailbox="*";

		if (!$this->WriteLine("lmb ".$com." \"".$ref."\" \"".Lib_utf7::EncodeString($mailbox)."\"\r\n"))
			return false;

		$i = 0;
		do{
			$line = $this->ReadLine(500);
			$a = explode(" ", $line);
			if (($line[0]=="*") && ($a[1]==$com))
			{
				$line = rtrim($line);
				// split one line
				$a = $this->ExplodeQuotedString(" ", $line);
				// last string is folder name
				$folder = Lib_utf7::DecodeString(str_replace("\"", "", $a[count($a)-1]));
				if( !in_array($folder, $folders) )
					$folders[$i] = $folder;
				// second from last is delimiter
				$delim = str_replace("\"", "", $a[count($a)-2]);
				// is it a container?
				$i++;
			}
		}while (!$this->StartsWith($line, "lmb"));

		if (is_array($folders))
		{
			if (!empty($ref))
			{
				// if rootdir was specified, make sure it's the first element
				// some IMAP servers (i.e. Courier) won't return it
				if ($ref[strlen($ref)-1] == $delim)
					$ref = substr($ref, 0, strlen($ref)-1);
				if ($folders[0]!=$ref)
					array_unshift($folders, $ref);
			}
			return $folders;
		}
		else
			return false;
	}

	function C_FixNameMailboxes($ref, $mailbox, $subscribed = false)
	{
		$folders = array();

		if($subscribed)
			$com = "LSUB";
		else
			$com = "LIST";
		
		if (empty($mailbox))
			$mailbox="*";

		if (!$this->WriteLine("lmb ".$com." \"".$ref."\" \"".Lib_utf7::EncodeString($mailbox)."\"\r\n"))
			return false;

		$i = 0;
		do{
			$line = $this->ReadLine(500);
			$a = explode(" ", $line);
			if (($line[0]=="*") && ($a[1]==$com))
			{
				$line = rtrim($line);
				// split one line
				$a = $this->ExplodeQuotedString(" ", $line);
				// last string is folder name
				$folder = str_replace("\"", "", $a[count($a)-1]);
				$folder = preg_replace("/^INBOX/", "", $folder);
				$folder = preg_replace("/^\./", "", $folder);
				if( $folder && !in_array($folder, $folders) )
					$folders[$i] = $folder;
				// second from last is delimiter
				$delim = str_replace("\"", "", $a[count($a)-2]);
				// is it a container?
				$i++;
			}
		}while (!$this->StartsWith($line, "lmb"));

		if (is_array($folders))
		{
			if (!empty($ref))
			{
				// if rootdir was specified, make sure it's the first element
				// some IMAP servers (i.e. Courier) won't return it
				if ($ref[strlen($ref)-1] == $delim)
					$ref = substr($ref, 0, strlen($ref)-1);
				if ($folders[0]!=$ref)
					array_unshift($folders, $ref);
			}
			if(count($folders)>0)
				foreach($folders as $v)
				{
					if(in_array($v, array('Spam', 'Saved', 'Drafts', 'Trash', 'Sent')))
						continue;
					if($v == str_replace("&-", "&", Lib_utf7::EncodeString($v)))
						continue;
		//			echo "rename - ".$user_dir.$v ."---". $user_dir.Lib_utf7::EncodeString($v)."<br>";
//					$cmd = "mv \"".$user_dir.$v."\" \"".$user_dir.Lib_utf7::EncodeString($v)."\"";
//					echo "\n[dddddddddd] ".$cmd."\n";
		//			exec($cmd, $res);
		//			echo implode("<br>", $res);
//					echo "r RENAME \"".$v."\" \"".Lib_utf7::EncodeString($v."_temp")."\"\r\n"."<br/>";
//					if ($this->WriteLine("r RENAME \"".$v."\" \"".Lib_utf7::EncodeString($v."_temp")."\"\r\n"))
//					{
//						do{
//							$line=$this->ReadLine(300);
//						}while($line[0]!="r");
//						if($this->ParseResult($line)===0)
//							return true;
//						else
//							$this->conn->error = $line;
//					}
//					echo "r RENAME \"".Lib_utf7::EncodeString($v."_temp")."\" \"".Lib_utf7::EncodeString($v)."\"\r\n"."<br/>";
//					if ($this->WriteLine("r RENAME \"".Lib_utf7::EncodeString($v."_temp")."\" \"".Lib_utf7::EncodeString($v)."\"\r\n"))
//					{
//						do{
//							$line=$this->ReadLine(300);
//						}while($line[0]!="r");
//						if($this->ParseResult($line)===0)
//							return true;
//						else
//							$this->conn->error = $line;
//					}
				}
			return $folders;
		}
		else
			return false;
	}

	function C_ListSubscribed($ref, $mailbox)
	{
		return $this->C_ListMailboxes($ref, $mailbox, true);
	}

	/**
	* Выбираем почтовый ящик
	*/
	function C_Select($mailbox, $full = false)
	{
		if (strcasecmp($this->conn->selected, $mailbox)==0)
		{
			if($full)
				return array(true, $this->conn->selected_count['exists'], $this->conn->selected_count['recent']);
			else
				return true;
		}

		
		if ($this->WriteLine("sel1 SELECT \"".Lib_utf7::EncodeString($mailbox)."\"\r\n"))
		{
			do{
				$line = chop($this->ReadLine(300));
				$a = explode(" ", $line);
				if ((count($a) == 3) && (strcasecmp($a[2], "EXISTS")==0))
					$this->conn->selected_count['exists'] = intval($a[1]);
				if ((count($a) == 3) && (strcasecmp($a[2], "RECENT")==0))
					$this->conn->selected_count['recent'] = intval($a[1]);
			}while (!$this->StartsWith($line, "sel1"));

			if($this->ParseResult($line) === 0)
			{
				$this->conn->selected = $mailbox;
				if($full)
					return array(true, $this->conn->selected_count['exists'], $this->conn->selected_count['recent']);
				else
					return true;
			}
			else
				return false;
		}
		else
			return false;
	}

	/**
	* Проверяем налчие новых сообщений
	*/
	function C_CheckForRecent($mailbox)
	{
		if (empty($mailbox))
			$mailbox="INBOX";
		
		$result = -2;
		
		$this->WriteLine("a002 EXAMINE \"".Lib_utf7::EncodeString($mailbox)."\"\r\n");
		do{
			$line = chop($this->ReadLine(300));
			$a = explode(" ", $line);
			if ( ($a[0]=="*") && (strcasecmp($a[2], "RECENT")==0) )
				$result = intval($a[1]);
		}while(!$this->StartsWith($a[0],"a002"));
		
		return $result;
	}

	function C_Search($folder, $criteria)
	{
		if ($this->C_Select($folder))
		{
			$c = 0;
			
			$query = "srch1 SEARCH ".chop($criteria)."\r\n";
			$this->WriteLine($query);
			$messages = array();
			do{
				$line = trim(chop($this->ReadLine(10000)));
				if (preg_match("@^\* SEARCH ([\s\d]+)$@", $line, $rg))
					if(trim($rg[1]) != "")
						$messages = explode(" ", trim($rg[1]));
			}while(!$this->StartsWith($line, "srch1"));
			
			if ($this->ParseResult($line) === 0)
				return $messages;
			else
			{
				$this->conn->error = "$this->C_Search: ".$line."<br>\n";
				return false;
			}
		}
		else
		{
			$this->conn->error = "$this->C_Search: Couldn't select \"$folder\" <br>\n";
			return false;
		}
	}

	/**
	* Количество сообщений в папке
	*/
	function C_CountMessages($mailbox, $full = false)
	{
		$arr = $this->C_Select($mailbox, true);
		if($arr === false)
		{
			if($full)
				return array(0, 0);
			else
				return 0;
		}
		
		if($full)
			return array($arr[1], $arr[2]);
		else
			return $arr[1];
	}

	function C_CountUnseen($folder)
	{
		$index = $this->C_Search($folder, "ALL UNSEEN");
		if (is_array($index))
			return count($index);
		else
			return 0;
	}

	/**
	* Достаем заголовки сообщений.
	*/
	function C_FetchHeaders($mailbox, $message_set, $part = 0)
	{
		$result = array();
		
		if (!$this->C_Select($mailbox))
			return false;
			
		if( $part==0 || empty($part) )
			$part = "";

		$key = "fh1";
		$request = $key." FETCH $message_set (BODY.PEEK[". ($part ? $part."." : "") ."HEADER.FIELDS (DATE FROM TO SUBJECT REPLY-TO CC CONTENT-TRANSFER-ENCODING CONTENT-TYPE MESSAGE-ID X-PRIORITY)])\r\n";
			
		if (!$this->WriteLine($request))
			return false;
		
		do
		{
			$line = chop($this->ReadLine(200));
			$a = explode(" ", $line);
			if (($line[0]=="*") && ($a[2]=="FETCH"))
			{
				$id = $a[1];
				/*
					Start parsing headers.  The problem is, some header "lines" take up multiple lines.
					So, we'll read ahead, and if the one we're reading now is a valid header, we'll
					process the previous line.  Otherwise, we'll keep adding the strings until we come
					to the next valid header line.
				*/
				$i = 0;
				$lines = array();
				do{
					$line = chop($this->ReadLine(300));
					if (ord($line[0])<=32)
						$lines[$i].=(empty($lines[$i])?"":"\n").trim(chop($line));
					else
					{
						$i++;
						$lines[$i] = trim(chop($line));
					}
				}while( $line[0] != ")" );
				
				//	create array with header field:data
				$result[$id] = array();
				$result[$id]['id'] = $id;
				while ( list($lines_key, $str) = each($lines) )
				{
					list($field, $string) = $this->SplitHeaderLine($str);
					if(!empty($field))
						$result[$id][strtolower($field)] = $string;
				}
			}
		}while(strcmp($a[0], $key)!=0);
		
		if ($part)
			return $result;
		
		/* 
			FETCH uid, size, flags
			Sample reply line: "* 3 FETCH (UID 2417 RFC822.SIZE 2730 FLAGS (\Seen \Deleted))"
		*/
		$command_key = "fh2";
		$request = $command_key." FETCH $message_set (UID RFC822.SIZE FLAGS INTERNALDATE)\r\n";
		if (!$this->WriteLine($request))
			return false;
		
		do{
			$line = chop($this->ReadLine(200));
			$a = explode(" ", $line);
			if ($line[0]=="*")
			{
				//get outter most parens
				$open_pos = strpos($line, "(") + 1;
				$close_pos = strrpos($line, ")");
				if ($open_pos && $close_pos)
				{
					//extract ID from pre-paren
					$pre_str = substr($line, 0, $open_pos);
					$pre_a = explode(" ", $line);
					$id = $pre_a[1];
					
					//get data
					$str = substr($line, $open_pos, $close_pos - $open_pos);
					
					//swap parents with quotes, then explode
					$str = eregi_replace("[()]", "\"", $str);
					$a = $this->ExplodeQuotedString(" ", $str);
					
					//did we get the right number of replies?
					if (count($a)==8)
						for ($i=0;$i<8;$i=$i+2)
						{
							if (strcasecmp($a[$i],"UID")==0)
								$result[$id]['uid'] = $a[$i+1];
							else if (strcasecmp($a[$i],"RFC822.SIZE")==0)
								$result[$id]['size'] = $a[$i+1];
							else if (strcasecmp($a[$i],"INTERNALDATE")==0)
								$result[$id]['internaldate'] = $a[$i+1];
							else if (strcasecmp($a[$i],"FLAGS")==0)
								$result[$id]['flags'] = $a[$i+1];
						}
				}
			}
		}while(strpos($line, $command_key)===false);
			
		return $result;
	}

	/**
	* Выборка определенного куска из сообщения.
	*/
	function C_FetchSection($mailbox, $id, $part = 0, $subpart = 0)
	{
		$result = false;
		
		if ( $part == 0 || empty($part) )
			$part = "";
		
		if( isset($this->body_types[$subpart]) && $subpart != 0)
			$part .= ($part?".":"").$this->body_types[$subpart];
		
		if( $part == "" )
			$part = $this->body_types[3];
		
		if(!$this->C_Select($mailbox))
			return false;

		$reply_key = "* ".$id;
		$key = "ftch1 ";
		$request = $key."FETCH $id (BODY.PEEK[$part])\r\n";

		if (!$this->WriteLine($request))
			return false;

		do{
			$line = chop($this->ReadLine(1000));
			$a = explode(" ", $line);
		}while($a[2]!="FETCH");
		$len = strlen($line);

		if ($line[$len-1] == ")")
		//one line response, get everything between first and last quotes
		{
			$from = strpos($line, "\"") + 1;
			$to = strrpos($line, "\"");
			$result = substr($line, $from, $to - $from);
		}
		else if ($line[$len-1] == "}")
		//multi-line request, find sizes of content and receive that many bytes
		{
			if(preg_match('@\{(\d+)\}@', $line, $rg))
				$bytes = intval($rg[1]);
			else
				$bytes = 0;
			$received = 0;
			while ($received < $bytes)
			{
				$remaining = $bytes - $received;
				$line = $this->ReadLine(1024);
				$len = strlen($line);
				if ($len > $remaining)
					$line = substr($line, 0, $remaining);
				$received += strlen($line);
				$result .= chop($line)."\n";
			}
		}

		// read in anything up until 'til last line
		do{
			$line = $this->ReadLine(1024);
		}while(!$this->StartsWith($line, $key));
        
		if (strlen($result)>0)
			return substr($result, 0, strlen($result)-1);
		else
			return false;
	}

	/**
	* Выборка стркутуры сообщения.
	*/
	function C_FetchStructureString($folder, $id)
	{
		$result = false;
		if(!$this->C_Select($folder))
			return false;
			
		$key = "F1247";
		if ($this->WriteLine("$key FETCH $id (BODYSTRUCTURE)\r\n"))
		{
			do{
				$line = chop($this->ReadLine(5000));
				if ($line[0]=="*")
				{
					if (ereg("}$", $line))
					{
						preg_match("/(.+){([0-9]+)}/", $str, $match);  
						$result = $match[1];
						do{
							$line = chop($this->ReadLine(100));
							if (!preg_match("/^$key/", $line))
								$result .= $line;
							else
								$done = true;
						}while(!$done);
					}
					else
						$result = $line;
					list($pre, $post) = explode("BODYSTRUCTURE ", $result);
					$result = substr($post, 0, strlen($post)-1);		//truncate last ')' and return
				}
			}while (!preg_match("/^$key/",$line));
		}
		return $result;
	}


/*
==============================================
         НЕИСПОЛЬЗУЕМЫЕ МЕТОДЫ
        -----------------------
возможно когда то они будет использоватся.. :)
==============================================
*/

	function FormatSearchDate($month, $day, $year)
	{
		$month = (int)$month;
		$months = array(
				1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 
				5=>"May", 6=>"Jun", 7=>"Jul", 8=>"Aug", 
				9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec"
				);
		return $day."-".$months[$month]."-".$year;
	}

	function my_xor($string, $string2)
	{
		$result = "";
		$size = strlen($string);
		for($i = 0; $i < $size; $i++)
			$result .= chr(ord($string[$i]) ^ ord($string2[$i]));
		return $result;
	}

	function C_GetQuota()
	{
		/*
		b GETQUOTAROOT "INBOX"
		* QUOTAROOT INBOX user/rchijiiwa1
		* QUOTA user/rchijiiwa1 (STORAGE 654 9765)
		b OK Completed
		*/
		$fp = $this->conn->fp;
		$result = false;
		$quota_line = "";
		
		//get line containing quota info
		if ($this->WriteLine("qt1 GETQUOTAROOT \"INBOX\"\r\n"))
		{
			do{
				$line=chop($this->ReadLine(5000));
				if ($this->StartsWith($line, "* QUOTA "))
					$quota_line = $line;
			}while(!$this->StartsWith($line, "qt1"));
		}
		
		//return false if not found, parse if found
		if (!empty($quota_line))
		{
			$quota_line = eregi_replace("[()]", "", $quota_line);
			$parts = explode(" ", $quota_line);
			$storage_part = array_search("STORAGE", $parts);
			if ($storage_part>0)
			{
				$result = array();
				$used = $parts[$storage_part+1];
				$total = $parts[$storage_part+2];
				$result["used"] = $used;
				$result["total"] = $total;
				$result["percent"] = round(($used/$total)*100);
				$result["free"] = 100 - $result["percent"];
			}
		}
		
		return $result;
	}


	function C_GetHierarchyDelimiter()
	{
		$delimiter = false;
		if (!$this->WriteLine("ghd LIST \"\" \"\"\r\n"))
			return false;
		
		do{
			$line = $this->ReadLine(500);
			if ($line[0]=="*")
			{
				$line = rtrim($line);
				$a = $this->ExplodeQuotedString(" ", $line);
				if ($a[0]=="*")
					$delimiter = str_replace("\"", "", $a[count($a)-2]);
			}
		}while (!$this->StartsWith($line, "ghd"));

		return $delimiter;
	}

	function C_UID2ID($folder, $uid)
	{
		if ($uid > 0)
		{
			$id_a = $this->C_Search($folder, "UID $uid");
			if (is_array($id_a))
			{
				$count = count($id_a);
				if ($count > 1)
					return false;
				else
					return $id_a[0];
			}
		}
		return false;
	}


}


class iilConnection
{
	var $fp;
	var $error;
	var $errorNum;
	var $selected;
	var $selected_count;
	var $message;
	var $host;
}

?>