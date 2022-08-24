
{if $USER->IsAuth()}

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
<tr>
	<th><span>Пригласить в Клуб</span></th>
</tr> 
</table>

		<form action="/{$ENV.section}/{$CONFIG.files.get.invite.string}" method="post" onsubmit="return valid_block_invite(this)">
		<input type="hidden" name="action" value="invite">
			<table cellpadding="0" cellspacing="1" border="0" width="100%">
				<tr>
					<td>
						<table width="100%" cellpadding="2" cellspacing="1" border="0">
							<tr>
								<td align="right" width="70" class="text11">Имя:</td>
								<td><input type="text" name="firstname" maxlength="50" style="width:150;font-size:11px;" value="" /></td>
							</tr>
							<tr>
								<td align=right width="70" class="text11">Фамилия:</td>
								<td><input type="text" name="lastname" maxlength="50" style="width:150;font-size:11px;" value="" /></td>
							</tr>
							<tr>
								<td align="right" width="70" class="text11">E-mail:</td>
								<td><input type="text" name="email" maxlength="50" style="width:150;font-size:11px;" />
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input name="submit" type="submit" value="отправить" class="text11"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>

<SCRIPT language="JavaScript">
{literal}
function valid_block_invite(form){

  if( form.email.value.length == 0) {
    alert("Введите E-mail!");
    form.email.focus();
    return false;
  }
  form.submit.disabled=true;
  return true;
}
{/literal}
</SCRIPT>

{/if}