{if $page.err.global}
<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" style="padding-left: 10px;">
			<b>Ошибка!</b><br /><br />
			<font color="red">{$page.err.global}</font>
		</td>
	</tr>
</table>
{else}
	{$page.list}
{/if}
<br/><br/>
{*{if $smarty.get.ddd>10}
{debug}
{/if}*}
