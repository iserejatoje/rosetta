<? if ($vars['banner']->Type == BannerMgr::T_IMAGE || $vars['banner']->Type == BannerMgr::T_IMAGE_WITH_BTN) { ?>
<img src="<?=$vars['banner']->File['f']?>" width="<? if ($vars['banner']->Width == 0 || $vars['banner']->Width > 400) { ?>400<? } else { ?><?=$vars['banner']->Width?><? } ?>px"/>
<? } else if ($vars['banner']->Type == BannerMgr::T_FLASH) { 
	$width = $vars['banner']->Width == 0 || $vars['banner']->Width > 400 ? 400 : $vars['banner']->Width;
?>
<object width="<?=$width?>"<? if ($width < 400) { ?> height="<?=$vars['banner']->Height?>"<? } ?>>
	<param name="movie" value="<?=$vars['banner']->File['f']?>"/>
	<param name="quality" value="high" />
	<param name="wmode" value="transparent">
	<embed src="<?=$vars['banner']->File['f']?>" quality="high" type="application/x-shockwave-flash" wmode="transparent" menu="false" width="<?=$width?>"<? if ($width < 400) { ?> height="<?=$vars['banner']->Height?>"<? } ?>></embed>
</object>
<? } ?>