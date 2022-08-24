<form style="margin:0px" method="post"{if isset($page.form.ssl_url)} action="{$page.form.ssl_url}"{/if}>
<table width="550" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td class="nyroModalTitle">
			<div style="float:right">
				<img class="nyroModalClose" style="cursor:pointer;cursor:hand;padding-top:2px;" src="/_img/modules/passport/im/close.gif " />
			</div>
			<div align="left">Вход</div>
		</td>
	</tr>
	<tr bgcolor="#E0F3F3">
		<td align="center" width="100%">
			<table align="center" width="350" cellpadding="0" cellspacing="0" border="0">
				<tr valign="middle">
					<td height="20px">Пожалуйста, введите свой e-mail и пароль:</td>
				</tr>
			</table>
			<table width="350" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="100px" align="right">E-Mail:</td>
					<td width="250px" align="left">
						<input type="text" tabindex="1" id="ajax_email" name="email" style="width:250px" value="{$page.form.email}" />
					</td>
				</tr>
				<tr>
					<td width="100px" align="right">Пароль:</td>
					<td width="250px" align="left"><input tabindex="3" id="ajax_password" type="password" name="password" style="width:250px" /></td>
				</tr>
				<tr>
					<td align="right" colspan="2">
						<input tabindex="4" type="checkbox" name="remember" id="ajax_remember" value="1"{if $page.form.remember} checked="checked"{/if} /> <label for="ajax_remember">Запомнить</label>
						&nbsp;&nbsp;&nbsp;
						<input type="button" id="imSendButton" class="nyroModalSend" value="Войти" />
						<input type="button" class="nyroModalClose" value="Закрыть" />
					</td>
				</tr>
				<tr valign="top">
					<td align="right" colspan="2">
						<a tabindex="6" href="/{$ENV.section}/{$CONFIG.files.get.register.string}" target="_blank">Зарегистрироваться</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a tabindex="7" href="/{$ENV.section}/{$CONFIG.files.get.forgot.string}" target="_blank">Забыли пароль?</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>