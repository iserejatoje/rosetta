<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Создание сообщения</span></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>Создание сообщения</span></td></tr>
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
<form name="mod_mail_message_new_form" id="mod_mail_message_new_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="message_send">
<input type="hidden" name="subaction" value="">
<input type="hidden" name="msg" value="{$page.form.msg}">
<input type="hidden" name="file" value="">
<tr align="left" valign="middle">
	<td width="100px" align="right">Кому:</td>
	<td><input type="text" name="to" style="width:400px;" value="{$page.form.to}" />&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.addressbook_popup.string}?field=to" onclick="mod_mail_message_new_get_address('to'); return false;" title="Вставить из адресной книги"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Вставить из адресной книги" /></a></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Копии:</td>
	<td><input type="text" name="cc" style="width:400px;" value="{$page.form.cc}" />&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.addressbook_popup.string}?field=cc" onclick="mod_mail_message_new_get_address('cc'); return false;" title="Вставить из адресной книги"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Вставить из адресной книги" /></a></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Скрытая:</td>
	<td><input type="text" name="bcc" style="width:400px;" value="{$page.form.bcc}" />&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.addressbook_popup.string}?field=bcc" onclick="mod_mail_message_new_get_address('bcc'); return false;" title="Вставить из адресной книги"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Вставить из адресной книги" /></a></td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Тема:</td>
	<td><input type="text" name="subject" style="width:400px;" value="{$page.form.subject}" /></td>
</tr>
<tr align="left">
	<td width="100px" align="right">Вложения:</td>
	<td>
		<table width="400px" cellpadding="0" cellspacing="0" border="0">
		{assign var="i" value=1}
	{if count($page.form.files)>0}
		{foreach from=$page.form.files item=file key=k}
			<tr valign="middle" align="right">
				<td width="20px" style="padding-right:5px;">{$i}.</td>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr valign="middle" align="left">
						<td class="text10"><noBR>{$file.name|replace:" ":"&nbsp;"}</noBR></td>
						<td class="bg_underline" width="100%">&nbsp;</td>
						<td class="text10" align="right">{$file.size.0}&nbsp;{$file.size.1}</td>
						<td align="right"><button onclick="mod_mail_message_new_form_action('delete_file-{$k|default:100}');" style="margin-left:20px; height:18px; font-size: 10px; width:80px;">Удалить</button></td>
					</tr>
					</table>
				</td>
			</tr>
			{assign var="i" value="`$i+1`"}
		{/foreach}
	{/if}
	{if $page.form.files_count != 0 || $page.form.files_weight <=0}
			<tr valign="middle" align="right">
				<td width="20px" style="padding-right:5px;">{$i}.</td>
				<td>
	<input type="file" name="upload" style="width:260px">
	<button onclick="mod_mail_message_new_form_action('upload_file');" style="margin-left:20px; height:18px; font-size: 10px; width:80px;">Добавить</button>
				</td>
			</tr>
	{/if}
		</table>
		<span class="tip">
	{if $page.form.files_count == 0}
		Вы присоединили максимальное количество файлов.<br />
	{elseif $page.form.files_weight <=0}
		Вы присоединили максимальный объем файлов.<br />
	{else}
		Вы можете присоединить еще {$page.form.files_count} файл(а, ов) общим объемом {$page.form.files_weight2.0} {$page.form.files_weight2.1}.<br />
		Объем каждого файла не должен превышать 2 Мб.<br />
	{/if}
		</span>
	</td>
</tr>
</table>

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left"><td>
Текст сообщения:
</td></tr>
<tr align="left"><td>
<textarea name="text" style="width:100%; height:300px;">{$page.form.text}</textarea>
</td></tr>
</table>

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left" valign="middle">
	<td width="100px" align="right">Важность:</td>
	<td>
	<select name="priority" id="priority" style="width:145px;">
	{foreach from=$page.form.priority_flags item=fl key=k}
		<option value="{if is_int($k)}{0}{else}{$k}{/if}"{if strval($k) == $page.form.priority} selected{/if}>{$fl.name}</option>
	{/foreach}
	</select>
	</td>
</tr>
</table>

<br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left"><td>
<input type="checkbox" name="save_in_sent" id="save_in_sent"{if $page.form.save_in_sent} checked{/if}/><label for="save_in_sent"> Сохранить копию письма в папке «Отправленные»</label>
<br />
<input type="checkbox" name="notify_me" id="notify_me"{if $page.form.notify_me} checked{/if}/><label for="notify_me"> Сообщить о прочтении письма</label>
</td></tr>
<tr align="left"><td>
<button onclick="mod_mail_message_new_form_action('');" style="width:150px;">Отправить</button>
&nbsp;&nbsp;&nbsp;
<button onclick="mod_mail_message_new_form_action('save_draft');" style="width:150px;">В черновики</button>
</td></tr>
</table>

<br />

</form>

<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_message_new_form = document.getElementById('mod_mail_message_new_form');
	var mod_mail_message_new_form_action_send = false;
	function mod_mail_message_new_form_action(act)
	{
		if(mod_mail_message_new_form_action_send)
			return false;
		
		if(act == '')
		{
			if(mod_mail_message_new_form.to.value == '')
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_INCORRECT_MESSAGE_NO_TO)}{literal}');
				mod_mail_message_new_form.to.focus();
				return false;
			}
		}
		else if(act == 'save_draft')
		{
//
		}
		else if(act == 'upload_file')
		{
//
		}
		else if(act.substring(0, 11) == 'delete_file')
		{
			mod_mail_message_new_form.file.value = act.substring(12);
			act = 'delete_file';
		}
		else
		{
			return false;
		}
		
		mod_mail_message_new_form.subaction.value = act;
			
		mod_mail_message_new_form_action_send = true;
		mod_mail_message_new_form.submit();
		return true;
	}

	function mod_mail_message_new_insert_into_field(field, value)
	{
		if(mod_mail_message_new_form[field].value != '')
			mod_mail_message_new_form[field].value += ', ';
		mod_mail_message_new_form[field].value += value;
	}

	function mod_mail_message_new_get_address(field)
	{
		OpenWindow('{/literal}/{$ENV.section}/{$CONFIG.files.get.addressbook_popup.string}?field={literal}'+field, 'get_address'+field, 600, 500);
	}
	
	
	
//    -->{/literal}
</script>


