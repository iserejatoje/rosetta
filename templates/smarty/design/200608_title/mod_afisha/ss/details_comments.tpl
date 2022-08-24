{if $res.count }
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><font class="zag5">Мнение читателей:</font></td>
	</tr>
	<tr>
		<td bgcolor="#1F68A0"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="5px"></td></tr>
<tr><td>
	<small>Всего мнений: {$res.count}</small>
</td></tr>
{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}
{if $smarty.capture.pageslink!="" }
<tr><td height="5px"></td></tr>
<tr><td>
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=k}
		<tr align="left" valign="top">
			<td colspan="2">
				<table width="100%" cellpadding="4" cellspacing="0" border="0">
				<tr align="left" bgcolor="E3F1FB">
					<td colspan="2"><a name="{$l.id}"></a><font color=#cc0000><b>{$k}.</b></font>&nbsp;&nbsp;{if $l.email }<a href="mailto:{$l.email}">{$l.name|truncate:30:"..."}</a>{else}{$l.name|truncate:30:"..."}{/if}&nbsp;&nbsp;{$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}</td>
				</tr>
				<tr><td align="left" colspan="2">{$l.otziv|with_href}</td></tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2" height="15px"></td></tr>
	{/foreach}
	</table>

</td></tr>
{if $smarty.capture.pageslink!="" }
<tr><td height="5px"></td></tr>
<tr><td>
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="20px"></td></tr>
</table>
{/if} {* {if $res.count } *}
