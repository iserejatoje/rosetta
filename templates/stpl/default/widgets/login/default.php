<? if (App::$User->IsAuth()) {?>
<div class="login_form login_form_autorised">
	<div class="welcome">
		Приветствуем, <?=$vars['showname']?>!
	</div>
	<div class="links">
		<a href="<?=$vars['url_mypage']?>">моя страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?=$vars['url_logout']?>">выход</a>
		<br>		
	</div>
</div>
<? } else { ?>
<div class="login_form">
	<form method="POST" action="<?=$vars['url_login']?>" name="widget_login_form">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="<?=$vars['url']?>" />
<table width="100%">
	<tr>		
		<td style="width:80px" class="text-field-container clear">
			<div class="text-rounder-left"></div>
			<div class="text-field"><input type="text" name="email" style="width: 55px" value="Email" onfocus="if(this.value=='Email')this.value='';" onblur="if(this.value=='')this.value='Email';" title="E-mail" /></div>			
			<div class="text-rounder-right"></div>
		</td>
		
		<td style="width:80px" class="text-field-container clear">
			<div class="text-rounder-left"></div>
			<div class="text-field"><input type="password" name="password" style="width: 55px" value="Пароль" onfocus="if(this.value=='Пароль')this.value='';" title="Пароль" /></div>			
			<div class="text-rounder-right"></div>
		</td>
		<td class="btn-container clear">
			<div class="btn">
				<div class="btn-wrapper"><a href="javascript:void(0)" onclick="document.forms.widget_login_form.submit()">Войти</a></div>
			</div>
		</td>		
	</tr>
</table>
<table width="100%">
	<tr>
		<td height="14px"><input type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/></td>
		<td valign="top" style="padding-top:4px;"><label title="Запомнить меня на этом компьютере" for="login_form_remember" style="color: #FFFFFF;">запомнить</label></td>	
		<td  valign="top" style="padding-top:4px;" align="right"><a href="<?=$vars['url_register']?>">Регистрация</a>&nbsp;&nbsp;<a href="<?=$vars['url_forgot']?>">Забыли пароль?</a></td>
	</tr>
</table>
</form>
</div>
<? } ?>