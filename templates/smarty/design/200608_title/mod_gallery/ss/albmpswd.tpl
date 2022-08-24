<table width="100%" cellpadding="0" cellspacing="3" border="0">
	<form name="frm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="albmpswd" />
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
{if $page.errors.global}
	<tr>
		<td align="center" style="color:red;">
			<b>{$page.errors.global}</b><br/><br/>
		</td>
	</tr>
{/if}
	<tr>
		<td align="left"  valign="bottom" style="padding-top:5px;">
		Для доступа в альбом «{$page.name}» требуется ввести пароль.
		</td>
	</tr>
	<tr>
		<td  align="left" valign="top" width="60%">
		<table  align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right"><b>Введите пароль:</b></td>
			<td align="left"><input type="password" maxlength="50" name="password" style="width:295px;" maxlength="50" value=""></td>
		</tr>
		</table>

		</td>
	</tr>
	<tr>
		<td align="left"  valign="bottom" style="padding-top:5px;">
		<input class="SubmitBut" type="submit" value="Войти" style="width:150px;">&nbsp;
		</td>
	</tr>
	</form>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
