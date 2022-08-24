<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Восстановление пароля</span></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>
{if $page.step=="step1" || ($page.step=="step3" && $page.form.forgot_link === true)}
	Восстановление пароля
{elseif $page.step=="step2"}
	Контрольный вопрос
{elseif $page.step=="step3"}
	Ввод нового пароля
{/if}
</span></td></tr>
</table>

{if $page.step=="step1" && !isset($page.form.code)}

<table align="left" width="100%" cellpadding="2" cellspacing="0" border="0">
<form name="mod_mail_forgot_form" id="mod_mail_forgot_form" method="post" onsubmit="return mod_passport.remind1Submit();">
<input type="hidden" name="action" value="forgot">
{if  $UERROR->GetErrorByIndex('email') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{ $UERROR->GetErrorByIndex('email')}</span></td>
		<td>&nbsp;</td>
	</tr>
{/if}
<tr align="left" valign="middle">
	<td width="200px" align="right">E-mail:</td>
	<td><input type="text" id="email" name="email" style="width:100%;" value="{$page.form.email|escape:'html'}" /></td>
	<td width="200px"><span class="tip">Введите ваш e-mail, указанный при регистрации</span><br></td>
</tr>
<tr align="left" valign="middle">
	<td width="200px" align="right">&nbsp;</td>
	<td><br />
	<input type="submit" id="send_button" style="width:150px;" value="Дальше">
	</td>
	<td>&nbsp;</td>
</tr>
</form>
</table>

{elseif $page.step=="step1" && isset($page.form.code)}

<table align="left" width="100%" cellpadding="2" cellspacing="0" border="0">
<form name="mod_mail_forgot_form" id="mod_mail_forgot_form" method="post" onsubmit="return mod_passport.remind1Submit();">
<input type="hidden" name="action" value="forgot">
<tr align="left" valign="middle">
	<td width="200px" align="right">Секретный код:</td>
	<td><input type="text" id="code" name="code" style="width:100%;" value="{$page.form.code|escape:'html'}" /></td>
	<td width="200px"><span class="tip">Введите секретный код для востановления пароля</span><br></td>
</tr>
<tr align="left" valign="middle">
	<td width="200px" align="right">&nbsp;</td>
	<td><br />
	<input type="submit" id="send_button" style="width:150px;" value="Дальше">
	</td>
	<td>&nbsp;</td>
</tr>
</form>
</table>

{elseif $page.step=="step2"}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">

<form name="mod_mail_forgot_form" id="mod_mail_forgot_form" method="post" onsubmit="return mod_passport.remind2Submit();">
<input type="hidden" name="action" value="forgot"/>
<input type="hidden" name="forgot_link" value="0"/>
<table width="500" cellpadding="2" cellspacing="0" border="0">
<tr>
	<td width="200px" align="right">&nbsp;</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('answer') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('answer')}</span></td>
	</tr>
{/if}
<tr align="left" valign="middle">
	<td width="220px" align="right">{$page.form.question|ucfirst|escape:'html'}:</td>
	<td><input type="text" id="answer" name="answer" style="width:100%;" value="{$page.form.answer|escape:'html'}" /></td>
</tr>
{if $UERROR->GetErrorByIndex('captcha') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('captcha')}</span></td>
	</tr>
{/if}
<tr align="left" valign="top">
	<td width="200px" align="right">Контрольный код:</td>
	<td>
		<input type="text" name="captcha_code" value="" style="width:150" /><br />
		<img src="{$page.form.captcha_path}" width="150" height="50" border="0" /><br />
	</td>
</tr>
<tr align="left" valign="top">
	<td width="200px" align="right"></td>
	<td><br /><input type="submit" id="send_button" style="width:150px;" value="Дальше"></td>
</tr>
</table>
</form>
</td></tr>

{if $page.form.forgot_link === true}
	<tr>
		<td align="center"><br /><br /><br />

		<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="block_title2"><span>Восстановление через E-Mail</span></td>
			</tr>
		</table>

		<br />Если у Вас есть доступ к почтовому ящику 
		<b>{$USER->Session[$ENV.sectionid].forgot_email}</b>, то мы можем выслать секретный 
		код для восставновления пароля.<br /><br />
		
		<form name="mod_mail_forgot_form_link" id="mod_mail_forgot_form_link" method="post">
		<input type="hidden" name="action" value="forgot"/>
		<input type="hidden" name="forgot_link" value="1"/>
		
			<input type="submit" value="Отправить" />
		
		</form>
	
		</td>
	</tr>
{/if}

</table>

{elseif $page.step=="step3"}

<table align="left" width="500" cellpadding="2" cellspacing="0" border="0">
<form name="mod_mail_forgot_form" id="mod_mail_forgot_form" method="post" onsubmit="return mod_passport.remind3Submit();">
<input type="hidden" name="action" value="forgot">
<tr align="left" valign="top">
	<td width="200px" align="right">&nbsp;</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>
	</tr>
{/if}
<tr align="left" valign="top">
	<td width="200px" align="right">Новый пароль:</td>
	<td>
	<input type="password" id="new_pass" name="new_pass" style="width:100%;" />
	<br />
	<br />
{*	<span class="tip">Пароль должен содержать от 4 до 20 символов из списка: A-z, 0-9, ! @ # $ % ^ & * ( ) _ - + и не может совпадать с логином.</span>*}
	</td>
</tr>
<tr align="left" valign="top">
	<td width="200px" align="right">Еще раз новый пароль:</td>
	<td><input type="password" id="new_pass2" name="new_pass2" style="width:100%;" /></td>
</tr>
<tr align="left" valign="top">
	<td width="200px" align="right"></td>
	<td>
	<br />
	<input type="submit" id="send_button" style="width:150px;" value="Дальше">
	</td>
</tr>
</form>
</table>
	
{/if}