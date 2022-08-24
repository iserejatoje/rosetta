<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_password" />
<h2>Пароль</h2>
<br /><br />
<table class="padding4">
{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" width="150" class="bg_color2">Новый пароль</td>
		<td class="bg_color4"><input type="password" name="password" style="width:155px;" /></td>
	</tr>
	<tr>
		<td class="bg_color2" align="right">Подтвердите новый пароль</td>
		<td class="bg_color4"><input type="password" name="password2" style="width:155px;" /></td>
	</tr>
{if $UERROR->GetErrorByIndex('password_old') != ''}
	<tr>
		<td>&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('password_old')}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right">Старый пароль</td>
		<td class="bg_color4"><input type="password" name="password_old" style="width:155px;" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>