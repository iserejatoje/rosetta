
{if $res.error}
<div align="center"><font color="red"><strong>Ошибка:</strong></font><br>{$res.error}</div>
<br>
{/if}
<table width="385" border="0" align="center" cellpadding="3" cellspacing="2">
	<form method="post">
	<input type="hidden" name="action" value="usettings">
	<input type="hidden" name="saction" value="semail">	
	<tr><td colspan="2" align="center">Вы можете изменить адрес, на который приходят Ваши подписки.</td></tr>
	<tr>
		<td align="right" bgcolor="#F3F8F8" width="110">E-mail:</td>
		<td width="257"><input type="text" name="remail" maxlength="64" style="width:100%;font-size:12px" value="{$res.remail}" /></td>
	</tr>
	<tr>
		<td align="right" bgcolor="#F3F8F8" width="110">Пароль:</td>
		<td width="257"><input type="password" name="rpass" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Изменить" class="button"></td>
	</tr>
	</form>
	<tr><td colspan="2">&nbsp;</td></tr>
	<form method="post">
	<input type="hidden" name="action" value="usettings">
	<input type="hidden" name="saction" value="spass">
	<tr><td colspan="2" align="center">Если Вы хотите сменить ваш пароль, заполните эти поля.</td></tr>
	<tr>
		<td align="right" bgcolor="#F3F8F8" width="110">Старый пароль:</td>
		<td width="257"><input type="password" name="rpass" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td align="right" bgcolor="#F3F8F8" width="110">Новый пароль:</td>
		<td width="257"><input type="password" name="rpass1" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td align="right" bgcolor="#F3F8F8" width="110">Подтвержение:</td>
		<td width="257"><input type="password" name="rpass2" maxlength="64" style="width:100%;font-size:12px" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Изменить" class="button"></td>
	</tr>
	</form>
</table>