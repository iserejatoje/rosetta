{include file="`$TEMPLATE.sectiontitle`" rtitle="Подписка"}
<br/><center>Для управления подпиской Вам необходимо 
<a href="/{$CURRENT_ENV.section}/?cmd=regfrm">зарегистрироваться</a>.
<br/>Если Вы уже зарегистрированы, то войдите через форму.</center><br/><br/>

<table cellpadding="0" cellspacing="0" border="0" width="580" align="center">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" >
				<tr bgcolor="#DEE7E7">
					<td class="t1" align="center" width="50%">Вход для зарегистрированных пользователей ресурса</td>
				</tr>
				<tr>
					<td class="t7" bgcolor="#f3f8f8" align="center" valign="top">    
					<!-- форма вход для зарегистрированных пользователей -->
					<form name="eform" action="/{$CURRENT_ENV.section}/" method="post" enctype="application/x-www-form-urlencoded">
					<input name="cmd" type="hidden" value="enter">
					<input type="hidden" name="action" value="edres">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="t1">имя:</td>
								<td><input type="text" name="name"  maxlength="16" size="18"  class="t7"></td>
							</tr>
							<tr>
								<td class="t1">пароль:&nbsp;&nbsp;</td>
								<td><input type="password" name="password"  maxlength="16" size="18"  class="t7"></td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<table cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td><input type="checkbox" name="remember" value="1"></td>
											<td class="t1">&#160;запомнить</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><input type="submit" value="  Вход  " class="in"></td>
							</tr>
						</table>
					</form>
					</td>
					<!-- конец формы вход для зарегистрированных пользователей -->
				</tr>
				<tr>
					<td class="t1" align="center" bgcolor="#DEE7E7">Если Вы забыли пароль</td>
				</tr>
				<tr>
					<td class="t7" bgcolor="#F3F8F8" align="center">
					<!-- форма забыли пароль -->
					<form name="eform" action="/{$CURRENT_ENV.section}/" enctype="application/x-www-form-urlencoded" method="post">
					<input name="cmd" type="hidden" value="losspasswd">
					введите ваш e-mail, указанный при регистрации
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="t1">e-mail:&nbsp;&nbsp;&nbsp; </td>
							<td><input type="text" name="email"  maxlength="50" size="18" class="t7"></td>
						</tr>
						<tr>
							<td colspan="2" align="center" class="t7"><input type="submit" value="Выслать пароль" class="in"></td>
						</tr>
					</table>
					</form>
					<!-- конец формы забыли пароль -->
					Имя и пароль будут высланы вам по электронной почте.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br/>
{include file="`$TEMPLATE.midbanner`"}