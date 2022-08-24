<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{if $page.form.id}Редактирование фильтра{else}Добавить фильтр{/if}</span></td>
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
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
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



<table cellpadding="2" cellspacing="0" border="0">
<form name="mod_mail_editfilter_form" id="mod_mail_editfilter_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="editfilter">
<input type="hidden" name="id" value="{$page.form.id}">
<input type="hidden" name="url" value="{$page.form.url}">
<tr align="left" valign="middle">
	<td colspan="2"><b>Для каких писем выполнять действие</b></td>
</tr>

<tr align="left" valign="middle">
	<td colspan="2">
	<input onclick="mod_mail_editfilter_change_cond();" type="radio" name="cond" id="cond_1" value="1"{if $page.form.cond==1} checked{/if} /><label for="cond_1"> Для всех писем</label><br/>
	<input onclick="mod_mail_editfilter_change_cond();" type="radio" name="cond" id="cond_2" value="2"{if $page.form.cond==2} checked{/if} /><label for="cond_2"> Для всех писем, кроме спама</label><br/>
	<input onclick="mod_mail_editfilter_change_cond();" type="radio" name="cond" id="cond_3" value="3"{if $page.form.cond==3} checked{/if} /><label for="cond_3"> Если письмо - спам</label><br/>
	<input onclick="mod_mail_editfilter_change_cond();" type="radio" name="cond" id="cond_4" value="4"{if $page.form.cond==4} checked{/if} /><label for="cond_4"> Для всех писем, удовлетворяющих</label>
	<select name="cond_type" style="width:150px">
	{foreach from=$page.form.cond_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.cond_type} selected{/if}>{$l}</option>
	{/foreach}
	</select> из нижеперечисленных:
	</td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0" style="display:{if $page.form.cond==4}block{else}none{/if};" id="table_cond_4">
<tr align="left" valign="middle">
	<td width="100px" align="right">поле "От":</td>
	<td>
	<select name="from_c" style="width:120px">
	{foreach from=$page.form.comp_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.from_c} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	<input type="text" name="from_t" style="width:220px;" value="{$page.form.from_t}" />
	</td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">поле "Кому":</td>
	<td>
	<select name="to_c" style="width:120px">
	{foreach from=$page.form.comp_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.to_c} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	<input type="text" name="to_t" style="width:220px;" value="{$page.form.to_t}" />
	</td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">поле "Копии":</td>
	<td>
	<select name="cc_c" style="width:120px">
	{foreach from=$page.form.comp_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.cc_c} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	<input type="text" name="cc_t" style="width:220px;" value="{$page.form.cc_t}" />
	</td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">поле "Тема":</td>
	<td>
	<select name="subject_c" style="width:120px">
	{foreach from=$page.form.comp_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.subject_c} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	<input type="text" name="subject_t" style="width:220px;" value="{$page.form.subject_t}" />
	</td>
</tr>
<tr align="left" valign="middle">
	<td width="100px" align="right">Размер:</td>
	<td>
	<select name="size_c" style="width:120px">
	{foreach from=$page.form.comp2_type_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.size_c} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	<input type="text" name="size_t" style="width:200px;" value="{$page.form.size_t}" /> Кб
	</td>
</tr>
</table>


<table cellpadding="2" cellspacing="0" border="0">
<tr><td colspan="2" height="10px"></td></tr>
<tr align="left" valign="middle">
	<td colspan="2"><b>Какое действие выполнять</b></td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0">
<tr align="left" valign="middle">
	<td><input type="radio" name="action_c" id="action_c_0" value="0"{if $page.form.action_c==0} checked{/if} /><label for="action_c_0"> Ничего не делать</label>
	</td>
</tr>
<tr align="left" valign="middle">
	<td><input type="radio" name="action_c" id="action_c_1" value="1"{if $page.form.action_c==1} checked{/if} /><label for="action_c_1"> Скопировать в папку:</label>
	<select name="action_move_folder" style="width:120px">
	{foreach from=$page.form.folder_arr item=l key=k}
	<option value="{$k}"{if $k==$page.form.action_move_folder} selected{/if}>{$l}</option>
	{/foreach}
	</select>
	</td>
</tr>
<tr align="left" valign="middle">
	<td><input type="radio" name="action_c" id="action_c_2" value="2"{if $page.form.action_c==2} checked{/if} /><label for="action_c_2"> Послать копию сообщения на адрес(а):</label>
	<input type="text" name="action_redirect" style="width:300px;" value="{$page.form.action_redirect}" />
	<br/>
	<span class="tip">Можно указать список адресов, разделенных знаком "пробел". Например: email1@site1.ru email2@site2.ru</span>
	</td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0">
<tr><td colspan="2" height="10px"></td></tr>
<tr align="left" valign="middle">
	<td colspan="2"><b>Исходное сообщение</b></td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0">
<tr align="left" valign="middle">
	<td>
	<input type="radio" name="action_delete" id="action_delete_1" value="1"{if $page.form.action_delete==1} checked{/if} /><label for="action_delete_1"> Удалить</label><br/>
	<input type="radio" name="action_delete" id="action_delete_0" value="0"{if $page.form.action_delete==0} checked{/if} /><label for="action_delete_0"> Поместить в папку "Входящие"</label><br/>
	</td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0">
<tr><td colspan="2" height="10px"></td></tr>
<tr align="left" valign="middle">
	<td colspan="2"><b>Свойства фильтра</b></td>
</tr>
</table>

<table cellpadding="2" cellspacing="0" border="0">
<tr align="left" valign="middle">
	<td colspan="2">Название фильтра: <input type="text" name="name" style="width:300px;" value="{$page.form.name}" /></td>
</tr>
<tr align="left" valign="middle">
	<td colspan="2">
	<input type="checkbox" name="lastone" id="lastone" value="1"{if $page.form.lastone==1} checked{/if} /><label for="lastone"> при срабатывании этого правила не выполнять остальные</label>
	</td>
</tr>
</table>

<br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left"><td>
<button onclick="mod_mail_editfilter_form_action('editfilter');" style="width:150px;">{if $page.form.id}Сохранить{else}Добавить{/if}</button>
</td></tr>
</form>
</table>


<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_editfilter_form = document.getElementById('mod_mail_editfilter_form');
	var mod_mail_editfilter_form_action_send = false;
	function mod_mail_editfilter_form_action(act)
	{
		if(mod_mail_editfilter_form_action_send)
			return false;
		
		if(act == 'editfilter')
		{
			if(mod_mail_editfilter_form.name.value == '')
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_INCORRECT_FILTER_NAME)}{literal}');
				mod_mail_editfilter_form.name.focus();
				return false;
			}
		}
		else
		{
			return false;
		}
		
		mod_mail_editfilter_form_action_send = true;
		mod_mail_editfilter_form.submit();
		return true;
	}
	
	function mod_mail_editfilter_change_cond()
	{
		if(document.getElementById('cond_4').checked)
		{
			document.getElementById('table_cond_4').style.display = 'block';
		}
		else
		{
			document.getElementById('table_cond_4').style.display = 'none';
		}
	}
	mod_mail_editfilter_change_cond();

//    -->{/literal}
</script>


