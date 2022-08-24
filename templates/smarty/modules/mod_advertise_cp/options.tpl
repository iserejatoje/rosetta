<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="left" class="t1">
<a href="/{$ENV.section}/" class="t1">Вернуться в личный кабинет</a>
</td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">

		<form name="frm" method="post">
		<input type="hidden" name="action" value="options" />
		<table align="center" cellpadding="2" cellspacing="0" border="0">
		<tr bgcolor="#E9EFEF">
			<td align="left" colspan="2" style="padding:3px;padding-left:8px;"><font class="t1">Персональные данные</font></td>
		</tr>
	<tr>
			<td align="right">E-mail:</td>
			<td width="200" align="left"><b>{$page.user.email}</b></td>
		</tr>
		<tr>
			<td align="right">ФИО:</td>
			<td width="200" align="left"><input type="text" name="name" style="width:200px" value="{if $ENV._POST.action == 'options'}{$ENV._POST.name|htmlspecialchars}{else}{$page.user.name|htmlspecialchars}{/if}"></td>
		</tr>
		<tr>
			<td align="right">Организация:</td>
			<td width="200" align="left"><input type="text" name="firm" style="width:200px" value="{if $ENV._POST.action == 'options'}{$ENV._POST.firm|htmlspecialchars}{else}{$page.user.firm|htmlspecialchars}{/if}"></td>
		</tr>
		<tr>
			<td align="right">Контакты:</td>
			<td width="200" align="left"><textarea name="contacts" style="width:200px;height:80px;">{if $ENV._POST.action == 'options'}{$ENV._POST.contacts|strip_tags}{else}{$page.user.contacts|strip_tags}{/if}</textarea></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Сохранить" style="width:100px;">&nbsp;&nbsp;
			<input class="button" type="reset" value="Очистить" style="width:100px;">
			</td>
		</tr>
		</form>

		<tr><td colspan="2"><img src="/_img/x.gif" width="1" height="40" border="0" alt="" /></td></tr>

		<form name="frmchpass" method="post">
		<input type="hidden" name="action" value="changepassword" />
		<tr bgcolor="#E9EFEF">
			<td align="left" colspan="2" style="padding:3px;padding-left:8px;"><font class="t1">Смена пароля</font></td>
		</tr>
{if $page.error}
	<tr><td align="center" colspan="2" style="color:red;"><b>{"<br/>"|implode:$page.error}</b></td></tr>
{/if}
	<tr>
			<td align="right">Новый пароль:</td>
			<td width="200" align="left"><input type="password" name="password1" style="width:200px"></td>
		</tr>
		<tr>
			<td align="right">Повторите пароль:</td>
			<td width="200" align="left"><input type="password" name="password2" style="width:200px"></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Изменить" style="width:100px;">&nbsp;&nbsp;
			<input class="button" type="reset" value="Очистить" style="width:100px;">
			</td>
		</tr>
		</form>
		</table>

</td></tr>

<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
</table>