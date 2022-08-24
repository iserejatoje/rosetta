<div style="height:142px">
<table cellspacing="4" cellpadding="0" border="0" width="100%">
<tr>
	<td>
{if isset($smarty.get.tst) || $CURRENT_ENV.regid == 56}
		<table class="t12" cellpadding="0" cellspacing="0" border="0">
			<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><b>Командный зачет</b></td></tr>
		</table>
{else}
		<table class="t12" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">Командный зачет</td>
				<tr><td align="left" height=1 bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
			</tr>
			<tr></tr>
		</table>
{/if}
	</td>
</tr>
<tr>
	<td>
		<table border="0" cellspacing="2" cellpadding="2" width="100%">
		<tr>
			<td bgcolor="#E9EFEF" colspan="2" align="center" style="color:#03424A"><b>Страна</b></td>
			<td bgcolor="#E9EFEF" align="center" style="color:#03424A"><b>Место</b></td>
			<td bgcolor="#E9EFEF" align="center" style="color:#03424A"><b>Всего</b></td>
			<td bgcolor="#E9EFEF" align="center" style="color:#BA7701"><b>Золото</b></td>
			<td bgcolor="#E9EFEF" align="center" style="color:#A0A0A0"><b>Серебро</b></td>
			<td bgcolor="#E9EFEF" align="center" style="color:#BA2747"><b>Бронза</b></td>
		</tr>
		{foreach from=$res.list item=l key=k}
		<tr{if $k%2==1} bgcolor="#f0f4f4"{/if}>
			<td>{if $l.FlagSmall}<img border="0" src="_i/flags/small/{$l.FlagSmall}">{/if}</td>
			<td width="100%">{$l.Name}</td>
			<td align="center">{$l.place}</td>
			<td align="center">{$l.Gold+$l.Silver+$l.Bronze}</td>
			<td align="center" style="color:#BA7701">{$l.Gold}</td>
			<td align="center" style="color:#A0A0A0">{$l.Silver}</td>
			<td align="center" style="color:#BA2747">{$l.Bronze}</td>
		</tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>
</div>