<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">
Для входа в личный кабинет введите свой Email и пароль.
<br /><br />
Если Вы не регистрировались ранее, то Вам необходимо пройти <a href="/{$ENV.section}/registration.html">регистрацию</a>.
<br />
Если Вы забыли пароль, то Вы можете <a href="/{$ENV.section}/forgot.html">восстановить пароль</a>.
<br /><br />
Личный кабинет дает возможность удобно управлять Вашими объявлениями.
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">

		<form name="frmlogin" method="post" onSubmit="javascript:return checkfrmlogin(this)">
		<input type="hidden" name="action" value="login" />
		<table align="center" cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td align="left" colspan="2" bgcolor="#C3E6EA" style="padding:3px;padding-left:8px;"><a name="discuss"><font class="zag1">Вход в личный кабинет</font></a></td>
		</tr>
		{if $page.error[0]}

<tr><td align="center" colspan="2" style="color:red;"><b>{$page.error[0]}</b></td></tr>
{/if}
	<tr>
			<td align="right">E-mail:</td>
			<td width="200" align="left"><input type="text" name="email" style="width:200px" value="{if $ENV._POST.action}{$ENV._POST.email|strip_tags|htmlspecialchars}{/if}">

			</td>
		</tr>
		{if $page.error.email}
		<tr>
			<td></td>
			<td width="200">
				<small style="color:red">{$page.error.email}</small>
			</td>
		</tr>
		{/if}
		<tr>
			<td align="right">Пароль:</td>
			<td width="200" align="left"><input type="password" name="password" style="width:200px">
			{if $page.error.password}
				<small style="color:red">{$page.error.password}</small>
			{/if}
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input type="checkbox" name="cook" {if $ENV._POST.cook} checked="checked"{/if}> автоматически входить
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Вход" style="width:100px;">
			</td>
		</tr>
		</table>
		</form>
<script language='Javascript'>
<!--
{literal}
function checkfrmlogin(form){
	if (isEmpty(form.password.value)){
		alert("Введите пароль!");
		form.password.focus();
		return false;
	}
	if (!isEmpty(form.email.value) && !isEmail(form.email.value)){
		alert("Вы неправильно ввели E-mail!");
		form.email.focus();
		return false;
	}
	return true;
}
{/literal}
//    -->
</script>

</td></tr>

<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
</table>