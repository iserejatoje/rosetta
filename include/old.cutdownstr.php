<?
	function CutDownStr($source, $MAX_STR_LEN)
	{
		if ( strlen($source) > $MAX_STR_LEN ) {
	        $dest = substr($source, 0, $MAX_STR_LEN);
			$dest = substr($dest, 0, strrpos($dest, " "));
			return $dest."&nbsp;...";
		} else
			return $source;
	}
?>