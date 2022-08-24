<script type="text/javascript" language="javascript" src="/_scripts/modules/job/usercard.js"></script>
{include file="`$TEMPLATE.sectiontitle`" rtitle="Настройка"}

<form method="post" enctype="application/x-www-form-urlencoded" name="chem" onSubmit="return TestParamE(this)">
<input type="hidden" name="cmd" value="changeuserinfo"/>
<input type="hidden" name="what" value="email"/>

<table cellpadding="0" cellspacing="0" border="0" align="center" width="500">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="2" border="0" width="100%" >
				<tr>
					<td class="t1" bgcolor="#DEE7E7" colspan="2" align="center">Адрес для получения рассылок</td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#e9efef" width="30%">E-mail</td>
					<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="email"  size="36"  maxlength="50" value="{$data.email}" class="t7"/></td>
				<tr>
					<td class="t1" align="right" bgcolor="#e9efef" width="30%">Пароль</td>
					<td class="t7" align="left" bgcolor="#F6FBFB"><input type="password" name="oldpwd"  size="16"  maxlength="16" class="t7"/></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<center><input type="submit" value="Изменить E-Mail" class="t7"></center>
</form>
<br/><br/>

{if $data.status == 1}
	{include file="`$TEMPLATE.ssections.finfo`" res="`$data.list`"}
{/if}

<form method="post" enctype="application/x-www-form-urlencoded" name="chpass" onSubmit="return TestParamP(this)">
<input type="hidden" name="cmd" value="changeuserinfo"/>
<input type="hidden" name="what" value="pass"/>

<table cellpadding="0" cellspacing="0" border="0" align="center" width="500">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="2" border="0" width="100%" >
				<tr>
					<td class="t1" bgcolor="#DEE7E7" colspan="2" align="center">Изменение пароля</td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#e9efef" width="30%">Действующий пароль</td>
					<td class="t7" align="left" bgcolor="#F6FBFB"><input type="password" name="oldpwd" size="16" maxlength="16" class="t7"/></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#e9efef" width="30%">Новый пароль</td>
					<td class="t7" align="left" bgcolor="#F6FBFB"><input type="password" name="pwd1" s size="16" maxlength="16" class="t7"/></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#e9efef" width="30%">Повторите пароль</td>
					<td class="t7" align="left" bgcolor="#F6FBFB"><input type="password" name="pwd2" size="16" maxlength="16" class="t7"/></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<center><input type="submit" value="Изменить пароль" class="in"></center>
</form>

