<?php
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
	function smarty_modifier_scrap_text($text="", $text_before=0, $text_after=0, $line=1, $len=30, $w_len=20, $add="...")
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
?>