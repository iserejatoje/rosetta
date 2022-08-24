<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">
Система восстановления пароля поможет Вам вспомнить пароль.
<br /><br />
Для этого необходимо ввести свой Email, и пароль будет Вам выслан.
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">

		<form name="frmforgot" method="post" onSubmit="javascript:return checkfrmforgot(this)">
		<input type="hidden" name="action" value="forgot" />
		<table align="center" cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td align="left" colspan="2" bgcolor="#C3E6EA" style="padding:3px;padding-left:8px;"><a name="discuss"><font class="t1">Восстановление пароля</font></a></td>
		</tr>
{if $page.error}
<tr><td align="center" colspan="2" style="color:red;"><b>{"<br/><br/>"|implode:$page.error}</b></td></tr>
{/if}	<tr>
			<td align="right">E-mail:</td>
			<td width="200" align="left"><input type="text" name="email" style="width:200px" value="{if $ENV._POST.action}{$ENV._POST.email}{/if}"></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Восстановить" style="width:100px;">
			</td>
		</tr>
		</table>
		</form>
<script language='Javascript'>
<!--
{literal}
function checkfrmforgot(form){
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