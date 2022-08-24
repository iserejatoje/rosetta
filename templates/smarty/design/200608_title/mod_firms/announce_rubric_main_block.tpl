{if !empty($BLOCK.res)}
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left:2px; margin-bottom: 5px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>{if !empty($BLOCK.title)}<a href="{if $BLOCK.url}/service/go/?url={"`$BLOCK.url`"|escape:"url"}{else}/firms/{/if}" target="_blank" class="a12b">{$BLOCK.title}:</a>{/if}</td></tr>
</table>
<table style="padding-left: 3px;" width="100%" cellspacing="3" cellpadding="0" border="0">
{foreach from=$BLOCK.res item=l}
	<tr><td class="t11">
		{*<img src="img/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> *}<a class="a11" href="{if $BLOCK.url}/service/go/?url={"`$BLOCK.url`/`$l.path`/"|escape:"url"}{else}/firms{$l.path}/{/if}" target="_blank">{$l.data.shorttitle}</a> <font class="a11 txt_blue">(<font style="font-size: 11px; font-weight: bold;">{$l.data.cnt}</font>)</font>
	</td></tr>
{/foreach}
	<tr><td class="t11">
		<a href="{if $BLOCK.url}/service/go/?url={"`$BLOCK.url`"|escape:"url"}{else}/firms/{/if}" target="_blank" class="a11">Все рубрики</a>
	</td></tr>
	{if $BLOCK.showadd}
	<tr><td align="left" style="padding-left: 1px;"><a href="{if $BLOCK.url}/service/go/?url={"`$BLOCK.url`/addorg.html"|escape:"url"}{else}/firms/addorg.html{/if}" target="_blank" style="font-size: 9px; color: red;">Добавить компанию</a></td></tr>
	{/if}
</table>
{/if}