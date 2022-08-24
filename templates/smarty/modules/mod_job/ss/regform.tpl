<script type="text/javascript" language="javascript" src="/_scripts/modules/job/reg.js"></script>
{include file="`$TEMPLATE.sectiontitle`" rtitle="Регистрация"}

<table cellpadding="0" cellspacing="0" border="0" width="95%" class="t7" align="center">
	<tr>
		<td>Регистрация в разделе работа позволит Вам получить доступ к
		услугам: подписка, добавление, редактирование размещенных вакансий и
		резюме.<br /><br />
		Бесплатный почтовый ящик <font class="s1"><b>ваше_имя@{$CURRENT_ENV.site.domain}</b></font>
		можно получить <a href="http://{$CURRENT_ENV.site.domain}/mail/reg.php" target="_blank" class="s1">здесь</a>.
		</td>
	</tr>
</table>
<br/><br/>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="50%" align="center" valign="top">
		<form name="regformr" method="POST" enctype="application/x-www-form-urlencoded" onSubmit="return TestParamR(this)">
		<input type="hidden" name="cmd" value="registry">
		<input type="hidden" name="rstate" value="rd">
		<table cellpadding="0" cellspacing="0" border="0" width="90%">
			<tr>
				<td>
				<table cellpadding="4" cellspacing="2" border="0" width="100%">
					<tr>
						<td class="t1" align="center" bgcolor="#DEE7E7" colspan="2">Регистрация для работодателей</td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">Компания</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="text" name="fname" maxlength="16" size="25" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">E-mail</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="text" name="email" maxlength="50" size="25" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Имя</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="text" name="name" maxlength="16" size="16" onChange="ToLowerCase(this.form.name)" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">Пароль</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="password" name="pwd1" maxlength="16" size="16" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">Повторите пароль</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="password" name="pwd2" maxlength="16" size="16" class="t7"></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center"><br/>
					<input id="confirml" name="confirm" style="vertical-align: middle" type="checkbox" value="1" />
					<label for="confirml">Я принимаю правила размещения</label>
				</td>
			</tr>
		</table><br/>
		<input type="submit" class="in" value="Зарегистрироваться">
		</form>
		</td>
		<td width="50%" align="center" valign="top">
		<form name="regforms" method="POST" enctype="application/x-www-form-urlencoded" onSubmit="return TestParamS(this)">
		<input type="hidden" name="cmd" value="registry"> <input type="hidden" name="rstate" value="sk">
		<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="90%">
			<tr>
				<td>
					<table cellpadding="4" cellspacing="2" border="0" width="100%">
					<tr>
						<td class="t1" align="center" bgcolor="#DEE7E7" colspan="2">Регистрация для соискателей</td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">E-mail</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="text" name="email" maxlength="50" size="25" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Имя</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="text" name="name" maxlength="16" size="16" onChange="ToLowerCase(this.form.name)" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">Пароль</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="password" name="pwd1" maxlength="16" size="16" class="t7"></td>
					</tr>
					<tr>
						<td class="t1" align="right" bgcolor="#DEE7E7">Повторите пароль</td>
						<td class="t7" align="left" bgcolor="#f6fbfb"><input type="password" name="pwd2" maxlength="16" size="16" class="t7"></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center"><br/>
					<input id="confirmr" name="confirm" style="vertical-align: middle" type="checkbox" value="1" />
					<label for="confirmr">Я принимаю правила размещения</label>
				</td>
			</tr>
		</table>
		<br/>
		<input class="in" type="submit" value="Зарегистрироваться">
		</form>
		</td>
	</tr>
</table>

<br />
<div align="center">Все поля обязательны для заполнения.</div>
<br />
<div align="center">С правилами размещения вакансий/резюме Вы можете ознакомиться <a href="http://info74.ru/?view=rulejob" target="_blank">здесь</a>.</div>
<br />

{include file="`$TEMPLATE.midbanner`"}