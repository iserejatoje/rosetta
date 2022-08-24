<?

class Trace
{
	private static $config = array();
	private static $log = array();
	private static $start_time = 0;
	private static $start_memory = 0;
	private static $prev_time = 0;
	private static $prev_memory = 0;
	private static $started = false;
	
	static public function Init()
	{
		self::$config['trace'] = false;
	}
	
	static public function SetConfig($name, $value)
	{
		self::$config[$name] = $value;
	}
	
	static public function Start()
	{
		if( self::$started === true )
			return;
		self::$start_time = self::$prev_time = microtime(true);
		self::$start_memory = self::$prev_memory = memory_get_usage();
		self::SetConfig('trace', true);
		self::Log('<b>start</b>');
		self::$started = true;
	}
	
	static public function GetConfig($name)
	{
		return self::$config[$name];
	}
	
	static public function VarDump($var)
	{	
		self::Log(highlight_string("<?\n".var_export($var, true)."\n?>", true));
	}
	
	static public function Log($str)
	{
		if(isset(self::$config['trace']) && self::$config['trace'] === true)
		{
			if ($_GET['show_call_place'] == 'true') {
				$bt = debug_backtrace();
				if ($bt[0]['class'] != 'Trace')
					$str = 'FILE: '.$bt[0]['file'].':'.$bt[0]['line'].'<br/>'.$str;
				else
					$str = 'FILE: '.$bt[1]['file'].':'.$bt[1]['line'].'<br/>'.$str;
			}

			$m = memory_get_usage();
			$t = microtime(true);
			self::$log[] = array(
					'time'			=> $t,
					'memory'		=> $m,
					'prev_time'		=> self::$prev_time,
					'prev_memory'	=> self::$prev_memory,
					'log'			=> $str,
					);
			self::$prev_time		= $t;
			self::$prev_memory		= $m;
		}
	}
	
	static public function Error($str)
	{
		self::Log('<font color="red">'.$str.'</font>');
	}
	
	static public function BackTrace($str, $obj = null)
	{
		if( is_null($obj) )
		{
			$obj = debug_backtrace();
			array_shift($obj);
		}
		$pid = rand(0,9999);
		error_log("BT[".$pid."]: ".$str);
		$err = self::_BackTrace($obj, $str, $pid, false);
		self::Log('<font color="purple">'.$str.'</font><br /><pre>'.$err.'</pre>');
	}

	static public function BackTraceReturn($str, $obj = null)
	{
		if( is_null($obj) )
		{
			$obj = debug_backtrace();
			array_shift($obj);
		}
		return self::_BackTrace($obj, $str, 0, true);
	}

	static protected function _BackTrace($obj, $str = '', $pid = 0, $ret = false)
	{
		$tab = "";
		if(is_array($obj) && sizeof($obj)>0)
			foreach($obj as $k=>$v)
			{
				$kr = "BT[".$pid."][".$k."]: file: ".$v['file'].':'.$v['line'].' ';
				$err.= $tab.'file: '.$v['file'].':'.$v['line']."\n";
				if(sizeof($v['args'])>0){
					$err.= $tab.$v['class'].$v['type'].$v['function']."(\n";
					$err.= self::e_dump_args($v['args'], $tab."\t", "\n");
					$err.= $tab.")\n";
					$kr.= $v['class'].$v['type'].$v['function']."(".self::e_dump_args($v['args'], '', ",").")";
				}
				else
				{
					$err.= $tab.$v['class'].$v['type'].$v['function']."()\n";
					$kr.= $v['class'].$v['type'].$v['function']."()";
				}
				$tab.= "\t";
				if( $ret === false )
					error_log($kr);
			}
		return $err;
	}

	static private function e_dump_args($var, $pref = "", $post = "")
	{
		$er = "";
		foreach($var as $k=>$v)
		{
			$er .= $pref.$k." => ";
			if(is_string($v))
				$er .= "'".$v."'";
			else if(is_null($v))
				$er .= "NULL";
			else if(is_array($v))
				$er .= "array(".$post.self::e_dump_args($v, $pref.substr($pref, -1), $post).$pref.")";
			else if(is_object($v))
				$er .= "[Object]";
			else
				$er .= $v;
			$er .= $post;
		}
		return $er;
	}
	
	static private $header = '<tr>
		<th colspan="2">time</th>
		<th rowspan="2">log</th>
		<th colspan="3">memory</th>
		</tr><tr>
		<th>total</th>
		<th>prev</th>
		<th>full</th>
		<th>total</th>
		<th>prev</th>
		</tr>';
	
	static public function GetHTMLLog()
	{
		TRACE::Log('<b>end</b>');
		$log = '';
		if(sizeof(self::$log) > 0)
		{
			$log.= '<table width="100%">';
			$cnt = 0;
			$bgcolor = '#F0F0F0';
			foreach(self::$log as $l)
			{
				if($cnt % 20 == 0)
					$log.= self::$header;
				++$cnt;
				$log.= '<tr bgcolor="'.$bgcolor.'">';
				$log.= '<td width="80">'.number_format($l['time'] - self::$start_time, 6).'</td>';
				$log.= '<td width="80">'.number_format($l['time'] - $l['prev_time'], 6).'</td>';
				$log.= '<td>'.$l['log'].'</td>';
				$log.= '<td width="80" align="right">'.number_format($l['memory'], 0, '.', ' ').'</td>';
				$log.= '<td width="80" align="right">'.number_format($l['memory'] - self::$start_memory, 0, '.', ' ').'</td>';
				$log.= '<td width="80" align="right">'.number_format($l['memory'] - $l['prev_memory'], 0, '.', ' ').'</td>';
				if($bgcolor == '#F0F0F0')
					$bgcolor = '#E0E0E0';
				else
					$bgcolor = '#F0F0F0';
			}
			$log.= '</table>';
		}
		return $log;
	}
	
	static public function getStartTime()
	{
		return self::$start_time;
	}
}
