
<table width="385" border="0" align="center" cellpadding="3" cellspacing="2">
	<form method="post">
	<input type="hidden" name="action" value="auth">
	<tr><td colspan="2" align="center" nowrap="nowrap">Для добавления/редактирования компании<br/>необходимо пройти процедуру авторизации.</td></tr>
	<tr>
		<td align="right" bgcolor="#F0F0F0" width="80">Имя:</td>
		<td width="287"><input type="text" name="login" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td align="right" bgcolor="#F0F0F0" width="80">Пароль:</td>
		<td><input type="password" name="password" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Войти" class="button"></td>
	</tr>
	</form>
	<tr><td colspan="2">&nbsp;</td></tr>
	<form method="post">
	<input type="hidden" name="action" value="remind">
	<tr><td colspan="2" align="center" nowrap="nowrap">Если Вы забыли пароль, введите e-mail,<br>
указанный Вами при регистрации.</td></tr>
	{if $res.error}
	<tr>
		<td width="150" align="right" valign="top"></td>
		<td><font color="red"><strong>Ошибка:</strong></font><br>{$res.error}</td>
	</tr>
	{/if}
	<tr>
		<td align="right" bgcolor="#F0F0F0">E-Mail:</td>
		<td><input type="text" name="email" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Выслать пароль" class="button"></td>
	</tr>
	<tr><td colspan="2" align="center" nowrap="nowrap">Имя и пароль будут высланы Вам по электронной почте.</td></tr>
	</form>
</table>