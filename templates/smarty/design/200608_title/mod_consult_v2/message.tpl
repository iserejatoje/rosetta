<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td align="center">
			{if $UERROR->IsError()}
			{php}echo UserError::GetErrorsText(){/php}
			{/if}
		</td>
	</tr>
	{if $page.main}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/">К списку разделов</a> ]</td>
	</tr>
	{/if}
	{if $page.back}
	<tr>
		<td align="center"><br/>[ <a href="#" onclick="window.history.back()">Назад</a> ]</td>
	</tr>
	{/if}
	{if $page.back_link}
	<tr>
		<td align="center"><br/>[ <a href="{$page.back_link}">Назад</a> ]</td>
	</tr>
	{/if}
</table>
