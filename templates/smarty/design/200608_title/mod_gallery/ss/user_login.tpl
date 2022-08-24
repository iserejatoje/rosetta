{if $page.errors.success}
<br/><br/>
<div align="center"><font color="green"><b>{$page.errors.success}</b></font><br/><br/>
<a href="/{$ENV.section}/">На главную</a> | <a href="/{$ENV.section}/user/login.html">Авторизация</a></div>
{else}
{if $page.errors.global}<font color="red"><b>{$page.errors.global}</b></font>{/if}
<script language="JavaScript" type="text/javascript" src="/_scripts/modules/gallery/checkform.js"></script>
<table width="100%" cellpadding="0" cellspacing="3" border="0">
	<form name="frm" method="post" enctype="multipart/form-data" onsubmit="return chLoginForm(this)">
	<input type="hidden" name="action" value="login" />
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td>
		Для добавления нового альбома или фотографии вам необходимо <a href="/{$ENV.section}/user/registration.html">зарегистрироваться</a>.<br/>
		Если вы уже зарегистрированы, то воспользуйтесь формой входа.<br/><br/>
		</td>
	</tr>
	<tr>
		<td  align="left" valign="top" width="60%">
		<table  align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right"><b>E-mail:</b></td>
			<td align="left"><input type="text" name="login" maxlength="100" style="width:295px;" value="{$login}"></td>
		</tr>
		<tr>
			<td align="right"><b>Пароль:</b></td>
			<td align="left"><input type="password" name="password" maxlength="50" style="width:295px;" value=""></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left"><a href="/{$ENV.section}/user/registration.html" class="s1">Регистрация</a> | <a href="/{$ENV.section}/user/forgot.html"  align="right" class="s1">Восстановить пароль</a></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left"><input class="SubmitBut" type="submit" value="Войти" style="width:70px;">&nbsp;</td>
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