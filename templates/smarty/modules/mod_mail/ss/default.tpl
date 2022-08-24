<br /><br /><br />

<table cellpadding="20" cellspacing="20" border="0">
<tr><td width="90"></td>
	<td valign="top" style="background-color:#e9efef;padding-left:30px;padding-right:30px;">
		<div class="title2">Вход</div>
		<br />
		
		<form name="mod_passport_login_form" id="mod_passport_login_form" action="/passport/login.php" method="post">
			<input type="hidden" name="action" value="login" />
			<input type="hidden" name="url" value="{$page.url}" />
			
			<div class="txt_color1"><b>E-Mail</b></div>
			<div>
				<input type="text" tabindex="1" name="email" style="width:250px" value="{$page.form.email}" />
			</div>
			<br />
			
			<div class="txt_color1"><b>Пароль</b></div>
			<div>
				<input tabindex="3" type="password" name="password" style="width:250px" />
			</div>
			<br />
			
			<div>
				<input tabindex="4" type="submit" id="send_button" style="width:100px;" value="Войти" />
				&nbsp;&nbsp;&nbsp;
				<input tabindex="5" type="checkbox" name="remember" id="remember" value="1"{if $page.form.remember} checked="checked"{/if} />&nbsp;<label for="remember">Запомнить</label>
			</div>
			<br />
			
			<div class="t9" style="text-align:right">
				<a tabindex="6" href="/passport/forgot.php?url={$page.url}">Забыли пароль?</a>
			</div>
		</form>
	</td>
	<td valign="top" width="440">
		<div class="title2"><a href="/passport/register.php">Регистрация</a></div>
		<br />
		<div class="txt_color5"><b>Электронная почта теперь стала ближе!</b></div>
		Почтовый ящик с именем твоего региона не потребует долгой регистрации, настрой почтовую программу и пользуйся всеми возможностями современной электронной почты и дома, и на работе!
	</td>
</tr>
</table>

