<br><br><br>
<form method="POST" action="_login.html">
{if isset($ERROR.login)}
<div align="center" class="ferror">{$ERROR.login}</div><br>
{/if}
<table align="center" cellspacing="0">
<tr><td align="right" class="fheader_text">Логин</td><td><input type="text" name="login" value="{$login}"></td></tr>
<tr><td align="right" class="fheader_text">Пароль</td><td><input type="password" name="password"></td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox" name="remember" value="1"{if $remember==1} checked{/if}> Запомнить?</td></tr>
<tr><td class="fbreakline">&nbsp;</td><td class="fbreakline"><input type="submit" value="Вход"></td></tr>
</table>
{if isset($ERROR.login)}
<br><div align="center">Если Вы забыли пароль, <a href="remember.html">воспользуйтесь системой восстановления паролей</a>.</div>
{/if}
</form>