<table width="100%" cellpadding="0" cellspacing="0">
{if count($res.usersList)>0}
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<b>На Ваши вопросы отвечают:</b><br />
			{foreach from=$res.usersList item=l}
				&nbsp;&nbsp;<a href="/{$ENV.section}/user/{$l.ID}.html">{$l.LastName} {$l.FirstName} {$l.MidName}</a>, {$l.Position}<br />
			{/foreach}
		</td>
	</tr>
{/if}
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<br/><br/>