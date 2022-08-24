<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
<tr><td align="center">

		<form name="frmreg" method="post" onSubmit="javascript:return checkfrmreg(this)">
		<input type="hidden" name="action" value="registration" />
		<table align="center" cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td align="left" colspan="2" bgcolor="#C3E6EA" style="padding:3px;padding-left:8px;"><a name="discuss"><font class="t1">Регистрация</font></a></td>
		</tr>
{if $page.error}
<tr><td align="center" colspan="2" style="color:red;"><b>{"<br/><br/>"|implode:$page.error}</b></td></tr>
{/if}
<tr>
			<td align="right">ФИО<b>*</b>:</td>
			<td width="200" align="left"><input type="text" name="name" style="width:200px" value="{if $ENV._POST.action}{$ENV._POST.name}{/if}"></td>
		</tr>
		<tr>
			<td align="right">E-mail<b>*</b>:</td>
			<td width="200" align="left"><input type="text" name="email" style="width:200px" value="{if $ENV._POST.action}{$ENV._POST.email}{/if}"></td>
		</tr>
		<tr>
			<td align="right">Организация:</td>
			<td width="200" align="left"><input type="text" name="firm" style="width:200px" value="{if $ENV._POST.action}{$ENV._POST.firm}{/if}"></td>
		</tr>
		<tr>
			<td align="right">Контакты:</td>
			<td width="200" align="left"><textarea name="contacts" style="width:200px;height:80px;">{if $ENV._POST.action}{$ENV._POST.contacts}{/if}</textarea></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Регистрация" style="width:100px;">&nbsp;&nbsp;
			<input class="button" type="reset" value="Очистить" style="width:100px;">
			</td>
		</tr>
		<tr><td colspan="2"><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
		<tr>
			<td align="center" colspan="2" class="small">
			Поля, помеченные <b>*</b> - обязательны
			</td>
		</tr>
		</table>
		</form>
<script language='Javascript'>
<!--
{literal}
function checkfrmreg(form){
	if (isEmpty(form.name.value)){
		alert("Введите свое имя!");
		form.name.focus();
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