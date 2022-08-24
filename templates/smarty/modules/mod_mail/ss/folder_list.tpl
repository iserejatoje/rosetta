<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Список папок</span></td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr valign="middle">
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.folder_edit.string}"><span>Создать новую папку</span></a></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

{if count($page.error.err)>0}	
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
{/if}

<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="center">
	<th>Название</th>
	<th width="80px">Новых</th>
	<th width="80px">Всего</th>
{*	<th width="5%">Объем, Кб</th>*}
	<th width="400px">Действия</th>
</tr>
{if count($page.list.list)>0}
<form name="mod_mail_folder_list_form" id="mod_mail_folder_list_form" method="post">
<input type="hidden" name="action" value="">
<input type="hidden" name="fld" value="">
{foreach from=$page.list.list item=l key=k}
<tr align="center" valign="middle" onmouseover="this.style.bgcolor='#CCCCCC';" onmouseover="this.style.bgcolor='';">
	<td align="left"><a href="/{$ENV.section}/{$CONFIG.files.get.messages.string}?fld={$l.sysname|urlencode}&p=1">{if $l.count_unseen>0}<b>{$l.name}</b>{else}{$l.name}{/if}</a></td>
	<td>{if $l.count_unseen>0}<b>{$l.count_unseen}</b>{else}{$l.count_unseen}{/if}</td>
	<td>{$l.count}</td>
{*	<td>&nbsp;</td>*}
	<td>
{if !isset($CONFIG.limits.folder_permission[$l.sysname]) || $CONFIG.limits.folder_permission[$l.sysname].edit==1}
		<a href="/{$ENV.section}/{$CONFIG.files.get.folder_edit.string}?fld={$l.sysname|urlencode}">редактировать</a>
		&nbsp;&nbsp;
{/if}
{if !isset($CONFIG.limits.folder_permission[$l.sysname]) || $CONFIG.limits.folder_permission[$l.sysname].delete==1}
		<a href="#" onclick="mod_mail_folder_list_action('folder_delete', '{$l.sysname}', '{$l.name|escape:"quotes"}'); return false;">удалить</a>&nbsp;&nbsp;
{/if}
{if !isset($CONFIG.limits.folder_permission[$l.sysname]) || $CONFIG.limits.folder_permission[$l.sysname].clear==1}
	{if $l.sysname == "Trash"}
		<a href="#" onclick="mod_mail_clear_trash(); return false;">очистить</a>&nbsp;&nbsp;
	{else}
		<a href="#" onclick="mod_mail_folder_list_action('folder_clear', '{$l.sysname}', '{$l.name|escape:"quotes"}'); return false;">очистить</a>&nbsp;&nbsp;
	{/if}
{/if}
	</td>
</tr>
{/foreach}
</form>
{else}

<tr align="center">
	<td colspan="5">
	пусто
	</td>
</tr>

{/if}
</table>
<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_folder_list_form = document.getElementById('mod_mail_folder_list_form');

	var mod_mail_folder_list_action_send = false;
	function mod_mail_folder_list_action(act, fld, fld2)
	{
		if(mod_mail_folder_list_action_send)
			return false;
		
		if(fld2 == "")
			fld2 = fld;

		if(act == 'folder_delete')
		{
			if(!confirm('Вы уверены что хотите удалить папку '+fld2+'?'))
				return false;
		}
		else if(act == 'folder_clear')
		{
			if(!confirm('Вы уверены что хотите очистить папку '+fld2+'?'))
				return false;
		}
		else
		{
			return false;
		}
		
		mod_mail_folder_list_form.action.value = act;
		mod_mail_folder_list_form.fld.value = fld;
			
		mod_mail_folder_list_action_send = true;
		mod_mail_folder_list_form.submit();
		return true;
	}
	
//    -->{/literal}
</script>
