
<center><a href="/{$SITE_SECTION}/add.php" title="Добавить свои фотографии и описание"><b>Разместить свои фотографии с места ДТП</b></a></center><br>

{capture name=pages}
	{if $res.pages.back!="" }<a href="{$res.pages.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<b>{$l.text}</b>&nbsp;
		{/if}
	{/foreach}
	{if $res.pages.next!="" }<a href="{$res.pages.next}">&gt;&gt;</a>{/if}
{/capture}
<center>{$smarty.capture.pages}
<table border='0' width='100%' cellpadding='5' cellspacing='1' class='text11'>
<tr>
{foreach from=$res.data item=l key=k name=list}
	
	<td class="td" align="center" width="33%" valign="top">{$l.Date|date_format:"%e %B %Y"} г.<br>
		<a href="/{$SITE_SECTION}/{$l.ID}.php" class="a1">
			<img src="{$l.Small.url}" width="{$l.Small.w}" height="{$l.Small.h}"  style="border: #BAD5EA solid 2px" border="0"></a><br>
			<table cellpadding=0 align=center cellspacing=0 border=0>
				<tr>{if $l.IsUser}
					<td align=right width=20>
						<img src="/_img/design/200710_auto/puser.gif" title="добавлена пользователем" alt="добавлена пользователем" border="0">
					</td>
					{/if}
					<td width="150" align="center">&#160;
						<a href="/{$SITE_SECTION}/{$l.ID}.php" class="a1">{$l.Name}</a>
					</td>
					
				</tr>
			</table>
		{if $l.comment}
			<font class="dop3"><font class="dop2"><b>{if $l.comment.user.name}<a href="{$l.comment.user.url}" target="_blank">{$l.comment.user.name|truncate:30}</a>{else}{if $l.comment.name!=''}{$l.comment.name|truncate:30}{else}Гость{/if}{/if}, {$l.comment.date|date_format:"%d.%m"}</font>:</b>&nbsp;{$l.comment.text|truncate:50}</font>
		{/if}
	</td>
	{if !$smarty.foreach.list.last && ($k+1) % 3 == 0}<tr></tr>{/if}
{/foreach}
</tr>
</table>
<br>{$smarty.capture.pages}</center>
<hr color="#005A52" style="height:1px">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="small">Примечание: Автокатастрофы, отмеченные знаком&#160;</td>
		<td><img src="/_img/design/200710_auto/puser.gif"></td>
		<td class="small">,&#160;добавлены пользователями сайта.</td>
	</tr>
</table>