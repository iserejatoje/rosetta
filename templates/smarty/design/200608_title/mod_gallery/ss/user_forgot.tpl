{if $page.errors.success}
<br/><br/>
<div align="center"><font color="green"><b>{$page.errors.success}</b></font><br/><br/>
<a href="/{$ENV.section}/">На главную</a> | <a href="/{$ENV.section}/user/login.html">Авторизация</a></div>
{else}
{if $page.errors.global}<div><font color="red"><b>{$page.errors.global}</b></font></div>{/if}
<script language="JavaScript" type="text/javascript" src="/_scripts/modules/gallery/checkform.js"></script>
<table width="100%" cellpadding="0" cellspacing="3" border="0">
	<form name="frm" method="post" enctype="multipart/form-data" onsubmit="return chForgotForm(this)">
	<input type="hidden" name="action" value="forgot" />
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td>
		Если вы потеряли или забыли пароль, то вы можете использовать функцию восстановления пароля.<br/>
		Введите в форме E-Mail, указанный при регистрации.<br/><br/>
		</td>
	</tr>
	<tr>
		<td  align="left" valign="top" width="60%">
		<table  align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right"><b>E-mail:</b></td>
			<td align="left"><input type="text" name="email" maxlength="100" style="width:295px;" value="{$page.email}"></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left"><input class="SubmitBut" type="submit" value="Напомнить" style="width:150px;"></td>
		</tr>
		</table>

		</td>
	</tr>
	</form>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
{/if}
