{$page.header}
<form method="post" action="">
<input type="hidden" name="action" value="delete_smessage" />
<input type="hidden" name="id" value="{$page.MessageID}" />

<table border="0" cellpadding="5" cellspacing="0" align="center" width="450">
	<tr>
		{if $page.minfo.type == 'theme'}
		<td colspan="2"><b>Вы действительно хотите удалить тему?</b></td>
		{else}
		<td colspan="2"><b>Вы действительно хотите удалить сообщение?</b></td>
		{/if}
	</tr>
	{php} if (($err = UserError::GetErrorByIndex('delete')) != '') { {/php}
	<tr>
		<td colspan="2" style="color:red">{php}echo $err;{/php}</td>
	</tr>
	{php} } {/php}
	<tr>
		<td><input type="checkbox" id="udelete" name="delete" value="1" /></td>
		<td width="100%"><label for="udelete">Удалить!</label></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="Продолжить" /> <input onclick="window.location.href='{$page.cancelUrl}';" type="button" value="Отмена" />
		</td>
	</tr>
</table>
</form>