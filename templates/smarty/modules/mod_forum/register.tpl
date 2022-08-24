<form method="POST">
<input type="hidden" name="_action" value="_register.html"> 
<table width="500" align="center" cellpadding="2" cellspacing="0">
{if !empty($ERROR.other)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.other}</span></td></tr>
<tr><td><img src="/_img/x.gif" width="5" height="5"></td><td><img src="/_img/x.gif" width="8" height="5"></td></tr>{/if}
{if !empty($ERROR.login)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.login}</span></td></tr>{/if}
<tr><td width="130" align="right" class="fheader_text">Имя</td><td width="370"><input type="text" name="login" style="width:366px" value="{$login}"></td></tr>
<tr><td><img src="/_img/x.gif" width="5" height="5"></td><td><img src="/_img/x.gif" width="5" height="5"></td></tr>
{if !empty($ERROR.email)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.email}</span></td></tr>{/if}
<tr><td width="130" align="right" class="fheader_text">E-Mail</td><td width="370"><input type="text" name="email" style="width:366px" value="{$email}"></td></tr>
<tr><td><img src="/_img/x.gif" width="5" height="5"></td><td><img src="/_img/x.gif" width="5" height="5"></td></tr>
{if !empty($ERROR.pass)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.pass}</span></td></tr>{/if}
<tr><td width="130" align="right" class="fheader_text">Пароль</td><td width="370"><input type="password" name="pass1" style="width:366px"></td></tr>
<tr><td><img src="/_img/x.gif" width="5" height="5"></td><td><img src="/_img/x.gif" width="5" height="5"></td></tr>
<tr><td width="130" align="right" class="fheader_text">Повтор пароля</td><td width="370"><input type="password" name="pass2" style="width:366px"></td></tr>
<tr><td><img src="/_img/x.gif" width="5" height="5"></td><td><img src="/_img/x.gif" width="5" height="5"></td></tr>
{if !empty($ERROR.confirm)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.confirm}</span></td></tr>{/if}
<tr><td>&nbsp;</td></td><td><input type="checkbox" name="confirm" value="1"{if $confirm==1} checked="checked"{/if}> С <a href="rulez.html" target="_blank">правилами</a> согласен</td></tr>
<tr><td class="fbreakline">&nbsp;</td><td class="fbreakline"><input type="submit" value="Регистрация"></td></tr>
</table>
</form>