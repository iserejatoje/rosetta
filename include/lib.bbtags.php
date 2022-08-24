<?
// для теста, после теста в другое место


class bbtags
{
	static $GalleryMgr = null;
	
	static $TAGS_LIST = array(
		'B', 'I', 'U', 'SMALL', 'BIG', 'LEFT', 'CENTER', 'RIGHT', 'JUSTIFY', 'LIST', 'EMAIL', 'URL', 'QUOTE', 'MEDIA','UGALLERY', 'IMG'
	);
	
	public static $media_regexp = array(
		array('pattern' => '@http://media\.rugion\.ru/m/\?id=([\d]+)@', 'params' => array('id' => 1), 'code' => 'rugion'),
		array('pattern' => '@http://www\.youtube\.com/watch\?v=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'youtube'),
		array('pattern' => '@http://www\.youtube\.com/view_play_list\?p=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'youtubepl'),
		array('pattern' => '@http://rutube\.ru/tracks/[\d]+\.html?.*v=([\w\-_]+)@', 'params' => array('id' => 1), 'code' => 'rutube'),
		
	);
	
	public static $media_code = array(
		'rugion' => '<object type="application/x-shockwave-flash" id="player" width="425" height="300" data="http://media.rugion.ru/m/?id={id}"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://media.rugion.ru/m/?id={id}" /></object>',
		'youtube' => '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/{id}&hl=ru&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/{id}&hl=ru&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>',
		'youtubepl' => '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/p/{id}&amp;hl=ru"></param><embed src="http://www.youtube.com/p/{id}&amp;hl=ru" type="application/x-shockwave-flash" width="480" height="385"></embed></object>',
		'rutube' => '<OBJECT width="470" height="353"><PARAM name="movie" value="http://video.rutube.ru/{id}"></PARAM><PARAM name="wmode" value="window"></PARAM><PARAM name="allowFullScreen" value="true"></PARAM><EMBED src="http://video.rutube.ru/{id}" type="application/x-shockwave-flash" wmode="window" width="470" height="353" allowFullScreen="true" ></EMBED></OBJECT>',
		
	);

	static function __bbcloser($tag)
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
		if($tag == 'EMAIL')		return '</a></noindex>';
		if($tag == 'URL')		return '</a></noindex>';
		if($tag == 'QUOTE')		return '</div>';
		if($tag == 'MEDIA')		return '';		
		if($tag == 'UGALLERY')	return '';
		if($tag == 'IMG')		return '';
		
		if(preg_match('@UGALLERY=(\d+)@i', $tag, $matches))
			return '';
		
		if(preg_match('@EMAIL=([a-zA-Z0-9._%-]+@[a-zA-Z0-9._%-]+\.[a-zA-Z]{2,4})@i', $tag, $matches) || $tag == 'EMAIL')
			return '</a></noindex>';
		if(preg_match('@URL=(?:https?://|ftp://)?([-\w+&@#/%?=~_|!:,.;]*[-\w+&@#/%=~_|])@i', $tag, $matches) || $tag == 'EMAIL')
			return '</a></noindex>';
	}

	static function StripBBTags( $str ){
	
		return preg_replace("@\[/?(i|b|u|small|big|left|center|right|justify|list|email|url|quote|url.*?|email.*?)\]@i", "", $str);
	}	
	
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
										
					$tagname = strtoupper($tagname);
					
					// проверка правильности для парметризированных тэгов, для их удаления
					if($tagname === 'EMAIL' && $closetag === false)
					{
						if(!preg_match('/^[\w._%\-]+@[\w._%\-]+\.[a-zA-Z]{2,4}$/', $params))
							$tagname = 'NO-TAG';
					}

					if($tagname === 'URL' && $closetag === false)
					{
						if(!preg_match('/^(?:(?:https?|ftp|file)?:\/\/)?[-\w+&@#\/%?=~_|!:,.;]*[-\w+&@#\/%=~_|]$/', $params))
							$tagname = 'NO-TAG';
					}
															
					if($tagname === 'UGALLERY' && $closetag === false)
					{
						if(!preg_match('/^(\d+)$/', $params))
							$tagname = 'NO-TAG';
					}
										
					//error_log(print_r($tagname, true));
					//error_log(print_r(Data::$TAGS_LIST, true));
					
					// если тэг известный (для url и email отдельная проверка)
					if(in_array($tagname, self::$TAGS_LIST))
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
								$out.= self::__bbcloser($tag);
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
							
							$tag = strtoupper($tag);
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
							//if($tag == 'UGALLERY') $out.= '<a href="#">Цитата:</div><div class="bbquote">';
							
							if($tag == 'UGALLERY') $out.= self::Convert_UGALLERY($par);
							
							if($tag == 'EMAIL')
							{
								$out.= '<noindex><a href="mailto:'.$par.'" rel="nofollow">';
							}
							if($tag == 'URL')
							{
								if(!preg_match("@^(https?|ftp)://@", $par))
									$pref = 'http://';
								$out.= '<noindex><a href="'.$pref.$par.'" target="_blank" rel="nofollow">';
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
							if($tag == 'IMG')							
							{								
								$mpos = strpos($text, '[/IMG]', $pos);
								if($mpos !== false)
								{
									$pos++;
									$url = substr($text, $pos, $mpos - $pos);
									$out.= '<img src="'.$url.'"/>';
								}
							}
							
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
			$out.= self::__bbcloser($tag);
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
						'@\[[\/]*UGALLERY[^\]]*\]@i',
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
	
	// заменяем < и > на &lt; и &gt;
	static function ChangeTags( $text ){
		
		$text = str_replace("<", "&lt;", $text);
		$text = str_replace(">", "&gt;", $text);
		
		return $text;
	}
	
	
	static function Convert_UGALLERY( $imageid ){
	
		if ( !isset(self::$GalleryMgr) )
			return false;
		
		LibFactory::GetMStatic('gallery', 'standalonegalleryphoto');
		$photo = new StandAloneGalleryPhoto($imageid, self::$GalleryMgr);
		
		if ( !isset($photo) )
			return null;
	
		$vars = array();
		$vars['photo']= array(
			'id'		 	=> $photo->ID,
			'title' 		=> $photo->Title,
			'userid'		=> $photo->User->ID,
			'descr' 		=> $photo->Description,
			'url' 			=> '/photo/'.$photo->ID.'.php',
			'thumb' => array(
				'url'	=> $photo->ThumbUrl,
				'width'	=> $photo->ThumbWidth,
				'height'=> $photo->ThumbHeight,
				'size'	=> $photo->ThumbSize,
				),
			'photo' => array(
				'url'	=> $photo->PhotoUrl,
				'width'	=> $photo->PhotoWidth,
				'height'=> $photo->PhotoHeight,
				'size'	=> $photo->PhotoSize,
				)
		);

		return trim(STPL::Fetch('modules/app_diaries/_states/thumb', $vars));
	
	}
}
?>