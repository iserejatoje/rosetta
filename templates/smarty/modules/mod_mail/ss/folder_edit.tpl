<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>
		{if $page.form.is_new}	
			Создать новую папку
		{else}
			Редактирование папки "{$page.form.old_name}"
		{/if}
			</span></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="20px"></td></tr>
</table>
{if count($page.form.err)>0}	
{include  file="`$TEMPLATE.errors`" errors_list=$page.form.err}
{/if}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="20px"></td></tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>
{if $page.form.is_new}	
	Создать новую папку
{else}
	Редактирование папки
{/if}
</span></td></tr>
<tr><td>
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<form name="mod_mail_folder_edit_form" id="mail_folder_edit_form" method="post" onsubmit="return mod_mail_folder_edit_form_check(this)">
	<input type="hidden" name="action" value="folder_edit" />
	<input type="hidden" name="is_new" value="{$page.form.is_new}" />
	<tr>
		<td width="100px" align="right">Название:</td>
		<td width="300px" align="left"><input type="text" name="name" style="width:300px" value="{$page.form.name}" /></td>
	</tr>
	<tr>
		<td align="center" colspan="2">
{if $page.form.is_new}	
			<input type="submit" style="width:150px;" value="Создать" />
{else}
			<input type="submit" style="width:150px;" value="Сохранить" />
{/if}
		</td>
	</tr>
	</form>
	</table>
</td></tr>
</table>
<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_folder_edit_form_check_send = false;
	function mod_mail_folder_edit_form_check(form)
	{
		if(mod_mail_folder_edit_form_check_send)
			return false;
			
		if (isEmpty(form.name.value))
		{
			alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_INCORRECT_FOLDER_NAME)|escape:"quotes"}{literal}');
			form.name.focus();
			return false;
		}
		
		if (form.name.value.length>{/literal}{$CONFIG.limits.folder_name_len}{literal})
		{
			alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_INCORRECT_FOLDER_NAME_LEN, $CONFIG.limits.folder_name_len)|escape:"quotes"}{literal}');
			form.name.focus();
			return false;
		}
		
		mod_mail_folder_edit_form_check_send = true;
		return true;
	}
	
	function isEmpty (txt)
	{
		var ch;
		if (txt == "") return true;
		for (var i=0; i<txt.length; i++){
			ch = txt.charAt(i);
			if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
		}
		return true;
	}

//    -->{/literal}
</script>
