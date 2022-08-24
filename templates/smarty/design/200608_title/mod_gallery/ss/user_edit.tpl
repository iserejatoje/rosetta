{if $page.errors.success}
<br/><br/>
<div align="center"><font color="green"><b>{$page.errors.success}</b></font><br/><br/>
<a href="/{$ENV.section}/">На главную</a>{if !$user->id} | <a href="/{$ENV.section}/user/login.html">Авторизация</a>{/if}</div>
{else}
{if $page.errors.global}<div><font color="red"><b>{$page.errors.global}</b></font></div>{/if}
<script language="JavaScript" type="text/javascript" src="/_scripts/modules/gallery/checkform.js"></script>
<form name="frm" method="post" enctype="multipart/form-data" onsubmit="return chUserForm(this)">
	<input type="hidden" name="action" value="edit_user" />
<table width="100%" cellpadding="0" cellspacing="3" border="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td>
		Здесь вы можете изменить E-Mail и имя/ник указанные при регистрации.<br/>
		Так же вы можете изменить свой пароль.<br/><br/>
		</td>
	</tr>
	<tr>
		<td  align="left" valign="top" width="60%">
		<table  align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right"><b>Ник:</b></td>
			<td align="left"><input type="text" disabled="disabled" style="width:295px;" value="{$user->login}"></td>
		</tr>
		<tr>
			<td align="right"><b>E-mail:</b></td>
			<td align="left"><input type="text" name="email" maxlength="100" style="width:295px;" value="{$user->email}"></td>
		</tr>
		
	<tr>
		<td align="left"  valign="bottom" style="padding-top:5px;">
		Изменить пароль:
		</td>
	</tr>
		<tr>
			<td align="right"><b>Новый пароль:</b></td>
			<td align="left"><input type="password" name="pass1" maxlength="50" style="width:295px;" value=""></td>
		</tr>
		<tr>
			<td align="right"><b>Повторите:</b></td>
			<td align="left"><input type="password" name="pass2" maxlength="50" style="width:295px;" value=""></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left"><input class="SubmitBut" type="submit" value="Сохранить"></td>
		</tr>
		</table>

		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
	</form>
{/if}