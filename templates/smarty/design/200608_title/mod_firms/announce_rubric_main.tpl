{if !empty($BLOCK.res)}
<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td style="width:22px;">
				<a href="/firms/" target="_blank" class="a16b"><img src="/_img/design/200608_title/common/icon_firms_p.gif" border="0"></a></td><td>&nbsp;<a href="/firms/" target="_blank" class="a16b">Справочник:</a>
			</td></tr>
			</table>
	</td></tr>
</table>
<table style="padding-left: 3px;" width="100%" cellspacing="0" cellpadding="1" border="0">
{foreach from=$BLOCK.res item=l}
	<tr><td style="padding-left: 10px;">
		<a href="/firms/{$l.path}/" target="_blank">{$l.data.shorttitle}</a> <font class="txt_blue">(<font style="font-size: 11px; font-weight: bold;">{$l.data.cnt}</font>)</font>
	</td></tr>
{/foreach}
	<tr><td style="padding-left: 10px;">
		<a href="/firms/" target="_blank">Все рубрики</a>
	</td></tr>
	<tr><td align="left" style="padding-left: 1px;"><a href="/firms/addorg.html" target="_blank" style="font-size: 9px; color: rgb(138, 163, 166);">Добавить компанию</a></td></tr>
</table>
{/if}