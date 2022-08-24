{literal}
<script type="text/javascript">
function form_submit ()
{
        var username = document.getElementById('form_username').value;
        var domain = document.getElementById('form_domain').value;
        document.getElementById('form_email').value = username + '@' + domain;
        form.login.submit();
}
</script>
{/literal}
<table class="t11" width="220" cellpadding="0" cellspacing="0" border="0">
<tr align="center"><td>
  <table class="t11" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<form method="post" action="/passport/login.php" enctype="application/x-www-form-urlencoded" name="login"
onSubmit="form_submit();">
<input type="hidden" name="action" value="login" />
<input type="hidden" name="domain" value="{$CURRENT_ENV.site.domain}" id="form_domain" /> 
<input type="hidden" name="email" id="form_email" value="" />
<input type="hidden" name="url" value="/mail/messages.php?fld=inbox" />
  <tr>
                <td align="right" class="t11">Логин:&nbsp;</td>
                <td align="left">
                <input type="text" name="username" style="width:70px;" id="form_username"
/>&nbsp;<b>@{$CURRENT_ENV.site.domain}</b>
                </td>
        </tr>
  <tr>
                <td align="right" class="t11">Пароль:&nbsp;</td>
                <td align="left">
                <input type="password" name="password" style="width:70px;" />
                <input type="submit" value="войти" style="width:68px;" />
                </td>
        </tr>
</form>
  </table>
</td></tr>
<tr><td align="center" class="t11">
<a href="/passport/register.php" class="a11_lgrey"><font color="red">Получить e-mail!</font></a>{*&nbsp;&nbsp;<a href="/mail/help.common.html" class="a11_lgrey">Помощь</a>*}&nbsp;&nbsp;<input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label>
</td></tr>
</table>