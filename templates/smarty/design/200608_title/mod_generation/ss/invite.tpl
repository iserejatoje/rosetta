<p><font class=title>Пригласить в Клуб</font></p>
<table width="100%" cellpadding="15" cellspacing="0" border="0">
	<tr>
		<td>			
			<p align="justify">
				Если вы хотите пригласить в клуб &laquo;Поколение 74&raquo; 
				нового участника, то введите его имя, фамилию и e-mail и нажмите кнопку &laquo;отправить&raquo;.
			</p>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>
			<form id="invite_user" action="/{$ENV.section}/{$CONFIG.files.get.invite.string}" method="post" onsubmit="return valid_invite_user(this)">
			<input type=hidden name=action value=invite>
			<table cellpadding="0" cellspacing="1" border="0" width="450">
				<tr>
					<td>
						<table width="100%" cellpadding="2" cellspacing="1" border="0">
							{if isset($UERROR->ERRORS.firstname)}
							<tr>
								<td></td>
								<td><font color="red">{$UERROR->ERRORS.firstname}</font></td>
							</tr>
							{/if}
							<tr>
								<td align="right" width="150">Имя:</td>
								<td>
									<input type="text" name="firstname" maxlength="50" style="width:300" value="{$page.form.FirstName|escape}">
								</td>
							</tr>
							{if isset($UERROR->ERRORS.lastname)}
							<tr>
								<td></td>
								<td><font color="red">{$UERROR->ERRORS.lastname}</font></td>
							</tr>
							{/if}
							<tr>
								<td align="right" width="150">Фамилия:</td>
								<td><input type="text" name="lastname" maxlength="50" style="width:300" value="{$page.form.LastName|escape}"></td>
							</tr>
							{if isset($UERROR->ERRORS.email)}
							<tr>
								<td></td>
								<td><font color="red">{$UERROR->ERRORS.email}</font></td>
							</tr>
							{/if}
							<tr>
								<td align="right" width="150">E-mail:</td>
								<td><input type="text" name="email" maxlength="50" style="width:300" value="{$page.form.EMail|escape}"></td>
							</tr>
							<tr>
								<td colspan="2" align="right">
									<input name="btnsub" type="submit" value="отправить" style="width:100">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>

		</td>
	</tr>
	<tr><td height="20"></td></tr>
</table>

{literal}
<SCRIPT language="JavaScript">
<!--
var frminvite = document.getElementById('invite_user');
//frminvite.email.focus();
if (frminvite)
	frminvite.btnsub.disabled=false;
function valid_invite_user(frm){

  if( frm.email.value.length == 0) {
    alert("Введите E-mail!");
    frm.email.focus();
    return false;
  }
  frm.btnsub.disabled=true;
  return true;
}
-->
</SCRIPT>
{/literal}
