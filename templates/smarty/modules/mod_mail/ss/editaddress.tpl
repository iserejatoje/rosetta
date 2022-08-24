<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{if $page.form.id}Редактирование адреса{else}Добавить адрес{/if}</span></td>
		</tr>
		{if $smarty.capture.pageslink!="" }
		<tr>
			<td height="25px">
		{$smarty.capture.pageslink}
			</td>
		</tr>
		{/if}
		</table>
	
	</td>
</tr>
</table>


<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;{$page.form.email|escape:"tags"}</span></td></tr>
</table>

{if count($page.error.err)>0}	
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>
{/if}


<table width="100%" cellpadding="2" cellspacing="0" border="0">
<form name="mod_mail_editaddress_form" id="mod_mail_editaddress_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="editaddress">
<input type="hidden" name="id" value="{$page.form.id}">
<input type="hidden" name="url" value="{$page.form.url}">
<tr align="left" valign="middle">
	<td width="100px" align="right">Ник:</td>
	<td><input type="text" name="nick" style="width:100%;" value="{$page.form.nick}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Фамилия:</td>
	<td><input type="text" name="lastname" style="width:100%;" value="{$page.form.lastname}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Имя:</td>
	<td><input type="text" name="firstname" style="width:100%;" value="{$page.form.firstname}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Отчество:</td>
	<td><input type="text" name="midname" style="width:100%;" value="{$page.form.midname}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Email (<b>*</b>):</td>
	<td><input type="text" name="email" style="width:100%;" value="{$page.form.email}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Телефон:</td>
	<td><input type="text" name="phone" style="width:100%;" value="{$page.form.phone}" /></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Комментарии:</td>
	<td><textarea name="comments" style="width:100%; height:200px;">{$page.form.comments}</textarea></td>
</tr>
</table>

<br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left"><td>
* - обязательные к заполнению!
</td></tr>
<tr align="left"><td>
<button onclick="mod_mail_editaddress_form_action('editaddress');" style="width:150px;">{if $page.form.id}Сохранить{else}Добавить{/if}</button>
</td></tr>
</form>
</table>


<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_editaddress_form = document.getElementById('mod_mail_editaddress_form');
	var mod_mail_editaddress_form_action_send = false;
	function mod_mail_editaddress_form_action(act)
	{
		if(mod_mail_editaddress_form_action_send)
			return false;
		
		if(act == 'editaddress')
		{
			if(mod_mail_editaddress_form.email.value == '')
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_INCORRECT_ADDRESS_EMAIL)}{literal}');
				mod_mail_editaddress_form.email.focus();
				return false;
			}
		}
		else
		{
			return false;
		}
		
		mod_mail_editaddress_form_action_send = true;
		mod_mail_editaddress_form.submit();
		return true;
	}
	
//    -->{/literal}
</script>


