<center>
<script language="JavaScript">
<!--{literal}
function ClearParent() {

	if (window.opener.document.forms.firmform) {
		window.opener.document.forms.firmform.login.value = "";
		window.opener.document.forms.firmform.password.value = "";
	}
}

function ToLowerCase(str)
{ var ns, re;
  re = /^s+/;
  str.value = str.value.replace(re, "");
  re = /s+$/;
  str.value = str.value.replace(re, "");
  str.value = str.value.toLowerCase();
}
function tstname(str)
{ var re, f;
  re = /[^a-z0-9_-]+/;
  f = str.match(re);
  if( f != null) {
    return false;
  } else {
    return true;
  }
}
function tstem(str)
{ var re, f;
  re = /^\s*([\w+-\.&_]+)@([\w+-\.&]+)\s*$/;
  f = str.match(re);
  if(f != null)  {
    return true;
  } else {
    return false;
  }
}
function TestParam(frm)
{
  if( frm.rlogin.value.length == 0) {  //frm.uname.value.length
    alert("Поле ИМЯ не заполнено.");
    frm.rlogin.focus();
    return false;
  }
  if(! tstname(frm.rlogin.value)) {  // frm.uname.value
    alert("Поле ИМЯ заполнено неправильно. ИМЯ может содержать только МАЛЕНЬКИЕ латинские буквы и цифры");
    frm.rlogin.focus();
    return false;
  }
  if(! tstem(frm.remail.value)) {  // frm.email.value
    alert("Поле EMAIL заполнено неправильно. EMAIL должен выглядеть примерно так: somebody@somewhere");
    frm.remail.focus();
    return false;
  }
  if( frm.rpass1.value.length == 0 || frm.rpass2.value.length == 0) {  // ... pwd1, pwd2...
    alert("Поля ПАРОЛЬ и ПОДТВЕРДИТЕ ПАРОЛЬ не заполнены.");
    frm.rpass1.focus();
    return false;
  }
  if( frm.rpass1.value != frm.rpass2.value ) {
    alert("Пароли не совпадают.");
    frm.rpass1.focus(); // pwd1
    return false;
  }
  
  if (window.opener.document.forms.firmform) {
	window.opener.document.forms.firmform.login.value = frm.uname.value;
	window.opener.document.forms.firmform.password.value = frm.pwd1.value;
	}

  return true;
}
ClearParent();
{/literal}
//-->
</script>

<br>
<font class="text16">Регистрация в разделе</font>
<br><br><form name="regform" method="post" onsubmit="return TestParam(this)">
<input type="hidden" name="action" value="register">
<table cellpadding=3 cellspacing=2 border=0 align="center">
{if $res.error}
<tr>
	<td colspan="2"><font color="red"><strong>Ошибка:</strong></font><br>{$res.error}<br><br></td>
</tr>
{/if}
<tr>
	<td align="right" bgcolor="#F3F8F8"><b>Имя</b>:</td>
	<td align="left">
<!--onChange="ToLowerCase(this.form.uname)"-->
	<input type="text" name="rlogin" maxlength="50" size="25" style="font-size:12px" value="{$res.rlogin}"></td>
</tr>
<tr>
	<td align="right" bgcolor="#F3F8F8"><b>E-mail</b>:</td>
	<td align="left">
		<input type=text name=remail maxlength="50" size=25 style="font-size:12px" value="{$res.remail}"></td>
</tr>
<tr>
	<td align="right" bgcolor="#F3F8F8"><b>Пароль</b>:</td>
	<td align="left">
		<input type=password name="rpass1" maxlength=16 size=25 style="font-size:12px"></td>
</tr>
<tr>
	<td align="right" bgcolor="#F3F8F8"><b>Подтверждение пароля</b>:</td>
	<td align="left">
		<input type=password name="rpass2"  maxlength=16 size=25 style="font-size:12px"></td>
</tr>                                         
</table>
<p>все поля обязательны для заполнения.</p>
<input type=submit value="Зарегистрироваться" class=button>
</form>