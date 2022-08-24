<?

class Data
{
    static $TAGS_LIST = array(
		'B', 'I', 'U', 'SMALL', 'BIG', 'LEFT', 'CENTER', 'RIGHT', 'JUSTIFY', 'LIST', 'EMAIL', 'URL', 'QUOTE', 'MEDIA','UGALLERY', 'IMG'
	);

	function CutDownStr($source, $MAX_STR_LEN)
	{
		if ( strlen($source) > $MAX_STR_LEN ) {
	        $dest = substr($source, 0, $MAX_STR_LEN);
			$dest = substr($dest, 0, strrpos($dest, " "));
			return $dest."&nbsp;...";
		} else
			return $source;
	}

	static function Escape($var)
	{
		if(is_array($var))
			foreach($var as $k=>$v)
				$ret[$k] = self::Escape($v);
		else
			$ret = addslashes($var);
		return $ret;
	}

	static function Is_Number($value)
	{
		if(strlen($value) <= 0)
			return false;
		return ctype_digit("".$value)?true:false;
	}

	static function Is_SignedNumber($value)
	{
		if(strlen($value) <= 0)
			return false;
		if($value{0} == '-')
			return ctype_digit("".substr($value, 1, strlen($value)-1))?true:false;
		return ctype_digit("".$value)?true:false;
	}

	static function Is_String($value)
	{
		if(strlen($value) <= 0)
			return false;
		return ctype_alnum("".$value)?true:false;
	}

	static function Is_Alpha($value)
	{
		if(strlen($value) <= 0)
			return false;
		return ctype_alpha("".$value)?true:false;
	}

	static function Is_Alpha_Range($value, $from, $to)
	{
		if(strlen($value) <= 0 || !is_numeric($from) || !is_numeric($to) || $from < 0 || $from > 255 || $to < 0 || $to > 255)
			return false;

		if($from > $to)
		{
			$from+=$to;
			$to = $from - $to;
			$from = $from - $to;
		}

		$len = strlen($value);
		for($i = 0; $i<$len; $i++)
		{
			$code = ord(substr($value, $i, 1));
			if($code < $from || $code > $to)
				return false;
		}
		return true;
	}

	static function Is_Email($email)
	{
		if($email == "")
			return false;
		if ( !preg_match('/^[a-z0-9\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $email) )
			return false;

		return true;
	}

	static function Is_Phone($phone)
	{
		if ($phone == "")
			return false;


		if (preg_match("@^\+7\-\(\d{3}\)\-\d{3}\-\d{4}$@", $phone) == 0
				&& preg_match("@^\+7|8\d{10}$@", $phone) == 0
			)
		{
			return false;
		}

		return true;
	}


	/**
	* Возвращает данные в виде строки в определенном порядке с разделителем
	* в случае, если в данных есть пробел, помещаются в кавычках
	*
	* @param array data данные для вывода (ключ - поле из массива order, значение - данные для вывода)
	* @param mixed order порядок данных (массив или строка(разделена запятыми))
	* @param array default порядок данных по умолчанию
	* @param string delimiter разделитель, по умолчанию пробел
	*
	* @return string    отформатированный по строкам текст
	*/
	static function GetOrderedData($data, $order, $default = null, $delimiter = ' ')
	{
		if(is_string($order) && strlen(trim($order)) != 0)
			$order = explode(',', $order);
		if(!is_array($order) || count($order) == 0)
		{
			if($default == null)
				return '';
			else
				$order = $default;
		}

		$ret = '';
		foreach($order as $ord)
		{
			if(strlen($ret) != 0)
				$ret.= $delimiter;
			if(strpos($data[$ord], $delimiter) !== false)
				$ret.= '"'.$data[$ord].'"';
			else
				$ret.= $data[$ord];
		}

		return $ret;
	}

	static function ChangeQuotes($text)
	{
		if (is_string($text)) {
			$text = str_replace("'","&#039;",$text);
			$text = str_replace("\"","&quot;",$text);
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::ChangeQuotes($text[$key]);
			}
		}
		return $text;
	}

	function ChangeTags($text)
	{
		if (is_string($text)) {
			$text = str_replace("<","&lt;",$text);
			$text = str_replace(">","&gt;",$text);
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::ChangeTags($text[$key]);
			}
		}
		return $text;
	}

	static function ChangeBR($text)
	{
		if (is_string($text)) {
			$text = str_replace("\n","<br>",$text);
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::ChangeBR($text[$key]);
			}
		}
		return $text;
	}

	static function HTMLOut($text)
	{
		if (is_string($text)) {
			$text = self::ChangeBR(self::ChangeTags(self::ChangeQuotes($text)));
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::HTMLOut($text[$key]);
			}
		}
		return $text;
	}

	static function HTMLOutTArea($text)
	{
		if (is_string($text)) {
			$text = self::ChangeTags(self::ChangeQuotes($text));
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::HTMLOutTArea($text[$key]);
			}
		}
		return $text;
	}

    static function InputClean($input) {
	    $input = htmlentities($input, ENT_QUOTES, 'cp1251');

	    if(get_magic_quotes_gpc ()) {
	        $input = stripslashes ($input);
	    }
	    $input = strip_tags($input);
	    $input = addcslashes($input, "00\n\r\\32");

	    return $input;
	}

	/**
	* Возвращет текст отворматированный по строкам
	*
	* @param
	* text string       текст, который надо форматировать
	* text_before int   длина строки перед текстом
	* text_after int    длина строки после текста
	* line int          количество строк
	* len int           длина каждой строки
	* w_len int         максимальная длина слова (не должна быть больше длины строки)
	* add string        строка добавляется если текст был обрезан
	*
	* @return string    отформатированный по строкам текст
	*/
	static function Scrap_text($text="", $text_before=0, $text_after=0, $line=1, $len=30, $w_len=20, $add="...")
	{
		$ar = explode(" ", $text, 20);
		if( count($ar)==1 )
		{
			if( strlen($ar[0])>$w_len )
				$result=substr($ar[0],0,$w_len).$add;
			else
				$result=$ar[0];
		}
		else
		{
			$line_c=1;
			$cur_line="";
			while( list($k,$v)=each($ar) )
			{
				if( strlen($v)>$w_len )
					$v=substr($v,0,$w_len).$add;

				if( $line_c==1 )
					$text_add = $text_before;
				else if($line_c==$line)
					$text_add = $text_after;
				else
					$text_add = 0;

				if( (strlen($cur_line)+strlen($v)+$text_add) > $len )
				{
					$result.=($result?"\n":"").$cur_line;
					$cur_line=$v." ";
					$line_c++;
					$line_add=0;
				}
				else
					$cur_line.=$v." ";

				if($line < $line_c)
					break;
			}
			if( $line>=$line_c && $cur_line )
				$result.=($result?"\n":"").$cur_line;
			elseif($line < $line_c)
				$result.=$add;
		}

		return $result;
	}

	/**
	* Разбивает текст на части разделяя их "..."
	*
	* @param string $string Исходный текст
	* @param integer $length Максимальная длина результата
	* @param integer $parts Количество частей в результате
	* @return string
	*/
	static function ScrapText($string,$length,$parts = 1) {

		$parts = ($parts < 1) ? 1 : $parts;
		$partLength = round($length/$parts)-$parts*4-1;
		$string = str_replace("\n",' ',$string);
		$string = wordwrap($string, $partLength, "\n", false);
		$string = explode("\n",$string);

		$result = rtrim($string[0],' ,.!?').'... ';
		for ($i=1;$i<sizeof($string) && $i < $parts;$i++) {
			$result .= rtrim($string[$i+1],' ,.!?').'... ';
		}
		return $result;
	}

	/**
	* Пока запихнул сюда... :(
	* Формирует массив для создания ссылок стриничной навигации
	* @param
	* col int          Количество записей на странице
	* colinblock int   Количество ссылок в блоке (чтобы все страничы не вываливать)
	* c_count int      Количество записей всего
	* c_p int          Номер текущей страницы
	* c_link string    заготовка ссылки для навигации, например: /somepart/somefile.php?a1=1&a2=2&...&p=@p@
	*                  заменяет "@p@" на $c_p
	* c_type int       1 = 1 2 3 4
	*                  2 = 1-10 11-20 21-30
	* @return array
	* back string      ссылка на пред. страницу
	* next string      ссылка на след. страницу
	* btn array(
	* 	array(
	* 		text string      текст ссылки
	* 		link string      сама ссылка
	* 		active int       (1 = текущая, 0 = другая)
	* 	)
	* )
	*/
	function GetNavigationPagesNumber($col, $colinblock, $c_count, $c_p, $c_link, $c_type = 1, $onepage = 0)
	{
		$list['back'] = "";
		$list['next'] = "";
		$list['btn'] = array();
		$list['current'] = str_replace("@p@", $c_p, $c_link);
		if ($col > 0 && (($c_count > $col) || $onepage))
		{
			$colpage = ceil($c_count / $col);// кол-во страниц
			if ($c_p > $colpage)
				return;// если такой стриницы нет
			if($colpage > $colinblock)
			{
				$colinblock1 = floor($colinblock / 2);
				$colinblock2 = $colinblock - $colinblock1 - 1;
				if( ($c_p - $colinblock1) < 1 )
				{
					$b1 = 1;
					$b2 = $colinblock;
				}
				elseif( ($c_p + $colinblock2) > $colpage )
				{
					$b1 = $colpage - $colinblock + 1;
					$b2 = $colpage;
				}
				else
				{
					$b1 = $c_p - $colinblock1;
					$b2 = $c_p + $colinblock2;
				}
			}
			else
			{
				$b1 = 1;
				$b2 = $colpage;
			}
			if ($c_p <> 1)
			{
				$list['back'] = str_replace("@p@", ($c_p - 1), $c_link);
				$list['first'] = str_replace("@p@", 1, $c_link);
			}
			if ($c_p<>$colpage)
			{
				$list['next'] = str_replace("@p@", ($c_p + 1), $c_link);
				$list['last'] = str_replace("@p@", $colpage, $c_link);
			}
			for ($i = $b1; $i <= $b2; $i++)
			{
				$pl_start = ($col * ($i - 1)) + 1;
				$pl_end = (($col * $i) > $c_count?$c_count:($col * $i));
				if ($c_type == 2)
					$list['btn'][$i]["text"] = $pl_start."-".$pl_end;
				else
					$list['btn'][$i]["text"] = $i;
				$list['btn'][$i]["link"] = str_replace("@p@", $i, $c_link);
				if ($i == $c_p)
					$list['btn'][$i]["active"] = 1;
				else
					$list['btn'][$i]["active"] = 0;
			}
		}
		$list['c_p'] = $c_p;
		$list['colpage'] = $colpage;
		return $list;
	}

	/**
	* Удаляет все ключи массива $a1, которые попадаются в массиве $a2
	* @param
	* $a1 - Array
	* $a2 - mixed (Array, String)
	* @return
	* Array
	*/
	static function remove_keys($a1, $a2)
	{
		if( !is_array($a1) )
			return $a1;
		if( !is_array($a2) )
			$a2 = array($a2);


		foreach($a2 as $k)
 		{
 			if( array_key_exists($k, $a1))
				unset($a1[$k]);
 		}

		return $a1;
	}


	/**
	* формирует строку {ключ}$g1{значение}[$g2{ключ}$g1{значение}]
	* @param
	* $g1 - string (delimeter 1)
	* $g2 - string (delimeter 1)
	* @return
	* String
	*/
	static function array_to_assoc_str($g1, $g2, $a)
	{
		$res = "";
		foreach($a as $k=>$v)
			$res .= ($res?$g2:"").$k.$g1.$v;

		return $res;
	}


	static function SQLAddCond($sqlt = null, $where = null)
	{
		if( $sqlt === null || $where === null)
			return array("", true);

		if( $where )
			$sqlt.= " AND";
		if( !$where )
		{
			$sqlt.= " WHERE";
			$where = true;
		}

		return array($sqlt, $where);
	}


	// генерация случайной строки
	// in:  $len - длинна строки (по умолчанию 32 символа)
	// out: строка
    function GetRandStr($len=32)
    {
    	$str="";
    	for($i=1;$i<=$len;$i++)
    	{
    	    $r=round(rand(0,61))+48;
        	if($r>57) $r=$r+7;
	        if($r>90) $r+=6;
    	    $str.=chr($r);
	    }
    	return $str;
    }

	private function __bbcloser($tag)
	{
		if($tag == 'I')			return '</i>';
		if($tag == 'B')			return '</b>';
		if($tag == 'U')			return '</span>';
		if($tag == 'SMALL')		return '</span>';
		if($tag == 'BIG')		return '</span>';
		if($tag == 'LEFT')		return '</div>';
		if($tag == 'CENTER')	return '</div>';
		if($tag == 'RIGHT')		return '</div>';
		if($tag == 'JUSTIFY')	return '</div>';
		if($tag == 'LIST')		return '</ul>';
		if($tag == 'EMAIL')		return '</a>';
		if($tag == 'URL')		return '</a>';
		if($tag == 'QUOTE')		return '</div>';
		if($tag == 'MEDIA')		return '';
		if($tag == 'IMG')		return '';
		if(preg_match('@EMAIL=([a-zA-Z0-9._%-]+@[a-zA-Z0-9._%-]+\.[a-zA-Z]{2,4})@i', $tag, $matches) || $tag == 'EMAIL')
			return '</a>';
		if(preg_match('@URL=(?:https?://|ftp://)?([-\w+&@#/%?=~_|!:,.;]*[-\w+&@#/%=~_|])@i', $tag, $matches) || $tag == 'URL')
			return '</a>';
	}

	public static $media_regexp = array(
		array('pattern' => '@http://media\.rugion\.ru/m/\?id=([\d]+)@', 'params' => array('id' => 1), 'code' => 'rugion'),
		array('pattern' => '@http://media\.rugion\.ru/m_modified/\?id=([\d]+)@', 'params' => array('id' => 1), 'code' => 'rugion2'),
		array('pattern' => '@http://www\.youtube\.com/watch\?v=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'youtube'),
		array('pattern' => '@http://www\.youtube\.com/view_play_list\?p=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'youtubepl'),
		array('pattern' => '@http://rutube\.ru/tracks/[\d]+\.html?.*v=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'rutube'),
		array('pattern' => '@http://(player\.)?vimeo\.com/(video/)?([\d]+)@', 'params' => array('id' => 3), 'code' => 'vimeo'),
		array('pattern' => '@http://static\.video\.yandex\.ru/lite/([\w\d\./\-_]+)@', 'params' => array('id' => 1), 'code' => 'yandex'),
		array('pattern' => '@http://russia.ru/video/([\w_\-\.\d]+)@', 'params' => array('id' => 1), 'code' => 'russia'),
		array('pattern' => '@http://video\.mail\.ru/mail/([\w\d\./\-_]+/[\d]+).html@', 'params' => array('id' => 1), 'code' => 'video.mail'),
		array('pattern' => '@http://vision\.rambler\.ru/users/([\w\.\-_\d/]+)@', 'params' => array('id' => 1), 'code' => 'vision.rambler'),
		array('pattern' => '@http://video\.qip\.ru/video/view/\?id=([\d\w]+)@', 'params' => array('id' => 1), 'code' => 'video.qip'),
		array('pattern' => '@http://smotri\.com/video/view/\?id=([\d\w]+)@', 'params' => array('id' => 1), 'code' => 'smotri'),
	);

	public static $media_code = array(
		'rugion' => '<object type="application/x-shockwave-flash" id="player" width="425" height="300" data="http://media.rugion.ru/m/?id={id}"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://media.rugion.ru/m/?id={id}" /></object>',
		'rugion2' => '<object type="application/x-shockwave-flash" id="player" width="425" height="300" data="http://media.rugion.ru/m/?id={id}"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://media.rugion.ru/m/?id={id}" /></object>',
		'youtube' => '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/{id}&hl=ru&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/{id}&hl=ru&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>',
		'youtubepl' => '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/p/{id}&amp;hl=ru"></param><embed src="http://www.youtube.com/p/{id}&amp;hl=ru" type="application/x-shockwave-flash" width="480" height="385"></embed></object>',
		'rutube' => '<OBJECT width="470" height="353"><PARAM name="movie" value="http://video.rutube.ru/{id}"></PARAM><PARAM name="wmode" value="window"></PARAM><PARAM name="allowFullScreen" value="true"></PARAM><EMBED src="http://video.rutube.ru/{id}" type="application/x-shockwave-flash" wmode="window" width="470" height="353" allowFullScreen="true" ></EMBED></OBJECT>',
		'vimeo' => '<iframe src="http://player.vimeo.com/video/{id}?color=ffffff" width="400" height="225" frameborder="0"></iframe>',
		'yandex' => '<object width="450" height="338"><param name="video" value="http://static.video.yandex.ru/lite/{id}"/><param name="allowFullScreen" value="true"/><param name="scale" value="noscale"/><embed src="http://static.video.yandex.ru/lite/{id}/" type="application/x-shockwave-flash" width="450" height="338" allowFullScreen="true" scale="noscale"> </embed></object>',
		'russia' => '<object width="608" height="342" type="application/x-shockwave-flash" data="http://www.russia.ru/player/main.swf" style="visibility: visible;"><param name="allowFullscreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><param name="bgcolor" value="#000000"><param name="flashvars" value="from=russia&amp;name={id}"></object>',
		'video.mail' => '<object width="626" height="367" type="application/x-shockwave-flash" data="http://img.mail.ru/r/video2/player_v2.swf?2" ><param name="movie" value="http://img.mail.ru/r/video2/player_v2.swf?2" /><param name="flashvars" value="movieSrc=mail/{id}" /><param name="devicefont" value="false"/><param name="menu" value="false"/><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /></object>',
		'vision.rambler' => '<object width="480" height="291" id="videoplayer" data="http://vision.rambler.ru/i/ev.swf?v=3&amp;id={id}&amp;where=video" type="application/x-shockwave-flash"><param value="always" name="allowScriptAccess"></param><param value="true" name="allowFullScreen"></param><embed src="http://vision.rambler.ru/i/ev.swf?v=3&amp;id={id}&amp;where=video" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="291"></embed></object>',
		'video.qip' => '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="640" height="360"><param name="movie" value="http://pics.video.qip.ru/player.swf?file={id}&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.video.qip.ru%2Fcskins%2Fqip%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.video.qip.ru%2Fskin_ng.xml" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#ffffff" /><embed src="http://pics.video.qip.ru/player.swf?file={id}&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.video.qip.ru%2Fcskins%2Fqip%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.video.qip.ru%2Fskin_ng.xml" quality="high" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"  width="640" height="360" type="application/x-shockwave-flash"></embed></object>',
		'smotri' => '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="640" height="360"><param name="movie" value="http://pics.smotri.com/player.swf?file={id}&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#ffffff" /><embed src="http://pics.smotri.com/player.swf?file={id}&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" quality="high" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"  width="640" height="360" type="application/x-shockwave-flash"></embed></object>',
	);

	/**
	 * Конвертация BB тэгов в HTML представление
	 */
	static function BBTagsConvert($text, $nl2br = true)
	{
		// заменяем < и > на &lt; и &gt;
		$text = self::ChangeTags($text);

		// обработка BB тэгов
		// открывающие парные тэги помещаем на стек
		// закрывающие ищем в стеке, закрываем все предыдущие, если нет игнорируем
		// особняком стоит [*], пока нет закрывающего тэга, надо придумать как сделать

		$len = strlen($text);
		$out = '';
		$closetag = false;
		$tagname = '';
		$stack = array();
		// в цикле если находим [, то идем в обработку тэга и идем до конца тэга, если нет, то просто копируем символ в выход
		for($i = 0; $i < $len; $i++)
		{
			if($text{$i} == '[')
			{
				$pos = strpos($text, ']', $i);
				//
				if($pos == false)
				{
					// больше нет закрывающих скобок, тупо копируем все и выходим из цикла
					$out.= substr($text, $i);
					break;
				}
				else
				{
					if($text{$i+1} == '/')
					{
						// закрывающий тэг
						$closetag = true;
						$tagname = substr($text, $i+2, $pos - $i - 2);
					}
					else
					{
						// открывающий или одиночный
						$closetag = false;
						$tagname = substr($text, $i+1, $pos - $i - 1);
					}

					//echo $tagname.'<br>';

					list($tagname, $params) = explode('=', $tagname, 2);
					// проверка правильности для парметризированных тэгов, для их удаления
					if($tagname === 'EMAIL' && $closetag === false)
					{
						if(!preg_match('/^[\w._%\-]+@[\w._%\-]+\.[a-zA-Z]{2,4}$/', $params))
							$tagname = 'NO-TAG';
					}

					if($tagname === 'URL' && $closetag === false)
					{
						if(!preg_match('/^(?:(?:https?|ftp|file)?:\/\/)?[-\s\d\w+&@#\/%?=~_|!:,.;]*[-\s\d\w+&@#\/%=~_|]$/', $params))
							$tagname = 'NO-TAG';
					}
					// если тэг известный (для url и email отдельная проверка)
					if(in_array($tagname, Data::$TAGS_LIST))
					{
						if($closetag === true) // закрывающий
						{
							// то разворачиваем стек до этого тэга, иначе это не тэг и пропускаем его
							$stack_open = array(); // опять открыть тэги
							do
							{
								$item = array_pop($stack);
								list($tag, $par) = $item;
								// тэги кончились
								if($item == NULL)
									break;
								$out.= Data::__bbcloser($tag);
								array_push($stack_open, array($tag, $par));
							}while($tag != $tagname);
							$item = end($stack_open);
							if($item[0] == $tagname)
								array_pop($stack_open);
						}
						else
							$stack_open = array(array($tagname, $params)); // открыть тэг
						do
						{
							$item = array_pop($stack_open);
							list($tag, $par) = $item;
							// парные тэги
							if($tag == 'I')			$out.= '<i>';
							if($tag == 'B')			$out.= '<b>';
							if($tag == 'U')			$out.= '<span style="text-decoration:underline">';
							if($tag == 'SMALL')		$out.= '<span style="font-size:80%">';
							if($tag == 'BIG')		$out.= '<span style="font-size:120%">';
							if($tag == 'LEFT')		$out.= '<div align="left">';
							if($tag == 'CENTER')	$out.= '<div align="center">';
							if($tag == 'RIGHT')		$out.= '<div align="right">';
							if($tag == 'JUSTIFY')	$out.= '<div style="text-align:justify">';
							if($tag == 'LIST')		$out.= '<ul>';
							if($tag == 'QUOTE')		$out.= '<div class="bbquotetitle">Цитата:</div><div class="bbquote">';
							if($tag == 'EMAIL')
							{
								$out.= '<a href="mailto:'.$par.'">';
							}
							if($tag == 'URL')
							{
								if(!preg_match("@^(https?|ftp)://@", $par))
									$pref = 'http://';

								$par = urldecode($par); // Декодируем ссылку
								$par = mb_convert_encoding ( $par, "windows-1251" , 'auto' ); // Определение кодировки текста в ссылки и изменение на внутреннюю

								$out.= '<a href="'.$pref.$par.'" target="_blank">';
							}
							if($tag == 'MEDIA')
							{
								$mpos = strpos($text, '[/MEDIA]', $pos);
								if($mpos !== false)
								{

									$pos++;
									$url = substr($text, $pos, $mpos - $pos);
									$pos = $mpos + 7;

									foreach(self::$media_regexp as $e)
									{
										$matches = array();

										if(preg_match($e['pattern'], $url, $matches))
										{
											$out.= str_replace('{id}', $matches[$e['params']['id']], self::$media_code[$e['code']]);
										}
									}
								}
							}
							/*if($tag == 'IMG')
							{
								$mpos = strpos($text, '[/IMG]', $pos);
								if($mpos !== false)
								{
									$pos++;
									$url = substr($text, $pos, $mpos - $pos);
									$out.= '<img src="'.$url.'"/>';
									$pos+= strlen($url)-1;
								}
							}*/
							if($item != NULL)
								array_push($stack, array($tag, $par));
							// одиночные тэги
							if($tag == '*')		$out.= '<li>';
						}while($item != NULL);
					}
					else
					// не тэг, просто копируем первый символ
					{
						$out.= $text{$i};
						continue;
					}
					// ставим указатель на следующий за тэгом символ
					$i = $pos;
					//var_dump($stack);
				}
			}
			else
				$out.= $text{$i};
		}
		while(NULL != (list($tag, $par) = array_pop($stack)))
			$out.= Data::__bbcloser($tag);
		$text = $out;

		// ентер
		if($nl2br === true)
			$text = nl2br($text);

		return $text;
	}

	/**
	 * Вырезает BB-теги из текста
	 **/
	static function BBTagsRemove($text)
	{

		$bb_tags = array(
						'@\[\*\]@i',
						'@\[[\/]*B\]@i',
						'@\[[\/]*I\]@i',
						'@\[[\/]*U\]@i',
						'@\[[\/]*SMALL\]@i',
						'@\[[\/]*BIG\]@i',
						'@\[[\/]*LEFT\]@i',
						'@\[[\/]*CENTER\]@i',
						'@\[[\/]*RIGHT\]@i',
						'@\[[\/]*JUSTIFY\]@i',
						'@\[[\/]*LIST\]@i',
						'@\[[\/]*EMAIL[^\]]*\]@i',
						'@\[[\/]*URL[^\]]*\]@i',
						'@\[[\/]*QUOTE[^\]]*\]@i',
					);

		return preg_replace($bb_tags,'',$text);

	}

	/**
	 * Конвертация смайлов в HTML представление
	 */
	static function SmilesConvert($text, $regexp, $smiles, $path, $limit = 0)
	{
		// вставка смайлов
		//$text = str_replace($smiles['from'], $smiles['to'], $text);
		$start = "<img src=\"";
		$end = "\">";
		if($limit != 0)
		{
			$text = preg_replace($regexp.'e', "\$start.\$path.\$smiles['\\1'].\$end", $text, $limit);
			$text = preg_replace($regexp, "", $text);
		}
		else
			$text = preg_replace($regexp.'e', "\$start.\$path.\$smiles['\\1'].\$end", $text);

		return $text;
	}

	/**
	 * Очистка от повторяющихся пробелов и ентеров
	 */
	static function RepeatedConvert($text, $max = 5)
	{
		$text = preg_replace('@(<br[^>]*>(\s*)){'.$max.',}@i', "<br />", $text);
		$text = preg_replace('@(\s){'.$max.',}@', " ", $text);

		return $text;
	}

	/**
	* Переделанная функция array_merge_recursive
	* Оригинал превращает совпадающие ключи в массив,
	* здесь это исправленно.
	* @param array array1[, array array2[, array array3]]
	* @return array
	*/
	static function array_merge_recursive_changed()
	{
		$tmp = func_get_arg(0);
		$count = func_num_args();
		for($i = 1; $i < $count; $i++)
		{
			$tmp1 = func_get_arg($i);
			$tmp = self::array_merge_recursive_changed2($tmp, $tmp1);
		}
		return $tmp;
	}
	static function array_merge_recursive_changed2($tmp, $tmp1)
	{
		if(is_array($tmp))
		{
			if(is_array($tmp1))
				foreach($tmp1 as $k=>$v)
					if(isset($tmp[$k]))
						$tmp[$k] = self::array_merge_recursive_changed2($tmp[$k], $tmp1[$k]);
					else
						$tmp[$k] = $tmp1[$k];
			else
				$tmp = $tmp1;
		}
		else
			$tmp = $tmp1;

		unset($tmp1);
		return $tmp;
	}


	static function e_backtrace($message = "", $ret = false)
	{
		global $CONFIG;
		if($_GET['backtrace']==12 || $CONFIG['params']['backtrace'] == true || $ret === true)
		{
			$tab = "";
			$ar = debug_backtrace();
			if(count($ar)>0)
				foreach($ar as $k=>$v)
				{
					$err.= $tab.'file: '.$v['file'].':'.$v['line']."\n";
					if(count($v['args'])>0){
						$err.= $tab.$v['class'].$v['type'].$v['function']."(\n";
						$err.= self::e_dump_args($v['args'], $tab."\t", "\n");
						$err.= $tab.")\n";
					}
					else
						$err.= $tab.$v['class'].$v['type'].$v['function']."()\n";
					$tab.= "\t";
				}
			if($ret === true)
				return $err;
			else
				echo "<pre>".$err."</pre>";
		}
		else
		{
			$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(empty($_SERVER['REQUEST_URI']))
				$url.= "?backtrace=12";
			else if(strpos($_SERVER['REQUEST_URI'], "?") !== false)
				$url.= "&backtrace=12";
			else
				$url.= "?backtrace=12";
			error_log("EEx: ".$message." Url: ".$url);
		}
	}

	static function e_dump_args($var, $pref = "", $post = "")
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

	static function build_query_string($data, $keys, $use_keys = true, $numeric_prefix = '', $arg_separator = '&') {

		if (is_array($data) && is_array($keys)) {
			$keys = array_flip($keys);

			if ($use_keys)
				return http_build_query(array_intersect_key($data,$keys),$numeric_prefix,$arg_separator);
			else
				return http_build_query(array_diff_key($data,$keys),$numeric_prefix,$arg_separator);
		}
		return '';
	}

	static function ToLatin($str)
	{
		$str = str_replace(array('А','В','Е','К','М','Н','О','Р','С','Т','Х','а','е','о','р','с','у','х','и'), // русские
						   array('A','B','E','K','M','H','O','P','C','T','X','a','e','o','p','c','y','x','u'), // латинские
						   $str);
		$str = strtolower($str);
		return $str;
	}

	static function NormalizeFloat($float)
	{
		$r = localeconv();
		return str_replace($r['decimal_point'], '.', ''.$float);
	}

	static function ChangeMemoryLimit($val)
	{
		$now = self::SizeStringToBytes(ini_get('memory_limit'));
		//error_log('memory_limit1:' .ini_get('memory_limit') . ':' . $now);
		$now += $val;
		//error_log('memory_limit2:' .$now . ':' . self::BytesToSizeString($now));
		return ini_set('memory_limit', self::BytesToSizeString($now));
	}

	static function SizeStringToBytes($val)
	{
		$val = trim($val);
		$last = strtolower($val{strlen($val)-1});
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	static function BytesToSizeString($val)
	{
		$last = '';
		if( $val > 1024 )
		{
			$val = ceil($val / 1024);
			$last = 'K';
		}
		if( $val > 1024 )
		{
			$val = ceil($val / 1024);
			$last = 'M';
		}
		if( $val > 1024 )
		{
			$val = ceil($val / 1024);
			$last = 'G';
		}

		return $val . $last;
	}
}

