{include file="`$TEMPLATE.sectiontitle`" rtitle="Напомнить пароль"}
<br/><br/>
<table cellpadding="0" cellspacing="0" border="0" width="580" align="center">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" >
				<tr>
					<td class="t1" align="center" bgcolor="#DEE7E7">Если Вы забыли пароль</td>
				</tr>
				<tr>
					<td class="t7" bgcolor="#F3F8F8" align="center">
					<form name=eform enctype="application/x-www-form-urlencoded" method=post>
						<input name=cmd type=hidden value=losspasswd>введите ваш e-mail, указанный при регистрации
						<table>
								<td class="t1">e-mail:&nbsp;&nbsp;&nbsp; </td>
								<td><input type=text name=email  maxlength="50" size="18" class="t7"></td>
							</tr>
							<tr>
								<td colspan="2" align="center" class="t7"><input type=submit value="Выслать пароль" class="in"><br/></td>
							</tr>
						</table>
						Имя и пароль будут высланы вам по электронной почте.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}