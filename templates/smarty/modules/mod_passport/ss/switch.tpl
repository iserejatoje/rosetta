<div >
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td style="text-align: center;">

		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Сменить пользователя</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>

<table align="center" width="400px" cellpadding="0" cellspacing="0" border="0">
	<tr valign="middle" align="center">
		<td height="20px">
			Для смены пользователя введите E-Mail или ID того пользователя под которым хотите войти.<br /><br />
		</td>
	</tr>
</table>

<table class="table" align="center" width="350" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="block_title2"><span>Вход</span></td>
	</tr>
	{if $UERROR->GetErrorByIndex('switch') != ''}
	<tr>
		<td class="error"><span>{$UERROR->GetErrorByIndex('switch')}</span></td>
	</tr>
	{/if}
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<form name="mod_passport_swith_form" id="mod_passport_swith_form" method="post">
			<input type="hidden" name="action" value="switch" />
			<input type="hidden" name="url" value="{$page.form.url}" />
			
			{if $UERROR->GetErrorByIndex('id') != ''}
			<tr>
				<td width="100px" align="right">&nbsp;</td>
				<td width="250px" align="left" class="error"><span>{$UERROR->GetErrorByIndex('id')}</span></td>
			</tr>
			{/if}

			<tr>
				<td width="100px" align="right">ID:</td>
				<td width="250px" align="left"><input tabindex="1" type="id" name="id"  value="{$page.form.id}" style="width:250px" /></td>
			</tr>
			
			{if $UERROR->GetErrorByIndex('email') != ''}
			<tr>
				<td width="100px" align="right">&nbsp;</td>
				<td width="250px" align="left" class="error"><span>{$UERROR->GetErrorByIndex('email')}</span></td>
			</tr>
			{/if}
			
			<tr>
				<td width="100px" align="right">E-Mail:</td>
				<td width="250px" align="left">
					<input type="text" tabindex="2" name="email" style="width:250px" value="{$page.form.email}" />
				</td>
			</tr>
			
			<tr>
				<td align="center" colspan="2">
					<input tabindex="3" type="submit" id="send_button" style="width:150px;" value="Войти" />
				</td>
			</tr>

			</form>
			</table>
		</td>
	</tr>
</table>
