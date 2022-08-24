{if $page.no_folder}
{* Нет такой папки *}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>Ошибка</span></td></tr>
<tr>
	<td>
{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_NO_FOLDER)}
	</td>
</tr>
</table>

{elseif $page.folder_is_empty}
{* папка пуста *}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{$page.folder.name}</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>

<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
<b>{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_FOLDER_IS_EMPTY)}</b>
	</td>
</tr>
</table>


{else}
{* Показываем все письмаи т.д. *}

{capture name=pageslink}
{if count($page.list.pageslink.btn)>0}
<span class="pageslink">Страницы:
	{if $page.list.pageslink.back!="" }<a href="{$page.list.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$page.list.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $page.list.pageslink.next!="" }<a href="{$page.list.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{$page.folder.name}</span></td>
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


{if count($page.error.err)>0}
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
{/if}



<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table">
<form name="mod_mail_messages_form" id="mod_mail_messages_form" method="post">
<input type="hidden" name="action" value="">
<input type="hidden" name="url" value="">
<input type="hidden" name="fld" value="{$smarty.get.fld|escape:"quotes"}">
<tr align="center">
	<th width="20px" style="padding:0px; padding-left:3px;"><input type="checkbox" id="mainch" ></th>
	<th width="20px" style="padding-top:6px;"><img src="/_img/modules/mail/ico/let_open.gif" width="14" height="14" alt="" border="0" style="margin-left:3px;margin-right:3px;" /></td>
	<th width="20px"><img src="/_img/modules/mail/ico/enclosure.gif" width="14" height="14" border="0" style="margin-left:3px;margin-right:3px;" /></th>
{if $smarty.get.fld=='Drafts' || $smarty.get.fld=='Sent'}
	<th width="40%"><a href="?sf=to&so={if $smarty.get.so=='d'}a{else}d{/if}&{$page.list.link_sort}">Получатель{if $smarty.get.sf=='to'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
{else}
	<th width="40%"><a href="?sf=from&so={if $smarty.get.so=='d'}a{else}d{/if}&{$page.list.link_sort}">Автор{if $smarty.get.sf=='from'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
{/if}
	<th width="60%"><a href="?sf=subject&so={if $smarty.get.so=='d'}a{else}d{/if}&{$page.list.link_sort}">Тема{if $smarty.get.sf=='subject'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="100px"><a href="?sf=date&so={if $smarty.get.so=='d'}a{else}d{/if}&{$page.list.link_sort}">Дата{if $smarty.get.sf=='date'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a><br/><img src="/_img/x.gif" width="100" height="1" alt="" border="0" /></th>
	<th width="80px"><a href="?sf=size&so={if $smarty.get.so=='d'}a{else}d{/if}&{$page.list.link_sort}">Размер{if $smarty.get.sf=='size'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a><br/><img src="/_img/x.gif" width="80" height="1" alt="" border="0" /></th>
</tr>
{*{if $smarty.get.sf=='size'} class="bg_table_sort"{/if}*}

{if count($page.list.list)>0}
{foreach from=$page.list.list item=l key=k}
{capture assign=link}{strip}
{if $smarty.get.fld=='Drafts'}
	/{$ENV.section}/{$CONFIG.files.get.message_reply.string}?action=edit&fld={$smarty.get.fld|escape:"url"}&id={$l.id}
{else}
	{$page.list.link_message}&id={$l.id}
{/if}
{/strip}{/capture}
<tr align="left" valign="top" id="tr{$k}">
	<td align="center"><input type="checkbox" id="ch{$k}" name="ch[{$l.id}]"{if $l.checked} checked{/if} ></td>
	<td align="center"><img src="/_img/modules/mail/ico/let_{if $l.flags.seen}open{else}close{/if}_{$l.x_priority}.gif" width="14" height="14" alt="" border="0" style="margin:3px;" title="{strip}
	{if $l.flags.seen}Прочтенное{else}Непрочтенное{/if}
	{/strip} {strip}{if $l.x_priority<3}важное{elseif $l.x_priority>3}неважное{/if}
	{/strip}" alt="" /></td>
	<td align="center">
	{if count($l.enclosure.partlist)>0}
		<img src="/_img/modules/mail/ico/enclosure.gif" width="14" height="14" border="0" style="margin:3px;" onmouseover="getElem('enclosure_hint_{$l.id}').style.visibility = 'visible';" onmouseout="getElem('enclosure_hint_{$l.id}').style.visibility = 'hidden';" />
		<div class="hint" id="enclosure_hint_{$l.id}" style="width:250px;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		{assign var="pi" value="1"}
		{foreach from=$l.enclosure.partlist item=pl key=pk}
			<tr align="right" valign="top">
				<td width="10px">{$pi}.</td>
				<td align="left">{$pl.name|escape:"tags"|escape:"quotes"}</td>
				<td width="60px">{$pl.size.0} {$pl.size.1}</td>
			</tr>
			{assign var="pi" value="`$pi+1`"}
		{/foreach}
		</table>
		</div>
	{/if}
	</td>
{if $smarty.get.fld=='Drafts' || $smarty.get.fld=='Sent'}
	<td><a id="a1_{$k}" href="{strip}
	{$link}
	">{if !$l.flags.seen}<b>{/if}
	{if count($l.to.array)>0}
	{foreach from=$l.to.array item=to key=ltk}{if $ltk>0}, {/if}{if $to.name}<span title="{$to.user}@{$to.host}">{$to.name|escape:"tags"}</span>{else}{$to.user}@{$to.host}{/if}{/foreach}
	{else}
	{$l.to.string}
	{/if}
	{if !$l.flags.seen}</b>{/if}
	{/strip}</a></td>
{else}
	<td><a id="a1_{$k}" href="{strip}
	{$link}
	">{if !$l.flags.seen}<b>{/if}
	{if count($l.from.array)>0}
	{foreach from=$l.from.array item=from key=ltk}{if $ltk>0}, {/if}{if $from.name}<span title="{$from.user}@{$from.host}">{$from.name|escape:"tags"}</span>{else}{$from.user}@{$from.host}{/if}{/foreach}
	{else}
	{$l.from.string}
	{/if}
	{if !$l.flags.seen}</b>{/if}
	{/strip}</a></td>
{/if}
	<td><a id="a2_{$k}" href="{$link}">{if !$l.flags.seen}<b>{/if}{$l.subject|escape:"tags"|default:'<span title="Тема не указана">&lt;нет темы&gt;</span>'}{if !$l.flags.seen}</b>{/if}</a></td>
	<td align="center">{if !$l.flags.seen}<b>{/if}
	{if $l.timestamp == 0}
		<span title="Дата не указана или не определена" style="cursor:pointer; cursor:hand;">&lt;???&gt;</span>
	{elseif date('Ymd', $l.timestamp) == date('Ymd', $smarty.now)}
		{$l.timestamp|date_format:"%H:%M"}
	{else}
		{$l.timestamp|date_format:"%e"} {$l.timestamp|month_to_string:3}
		{if date('Y', $l.timestamp) != date('Y', $smarty.now)}
			{$l.timestamp|date_format:"%Y"}
		{/if}
	{/if}
	{if !$l.flags.seen}</b>{/if}</td>
	<td align="right">{if !$l.flags.seen}<b>{/if}{$l.size.0} {$l.size.1}{if !$l.seen}</b>{/if}</td>
</tr>
{/foreach}
{/if}

</table>

<br/>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="80px">
	{if $smarty.get.fld=='Trash'}
	<button onclick="mod_mail_messages_form_action('folder_clear');" style="width:70px;">Очистить</button>
	{else}
	<button onclick="mod_mail_messages_form_action('messages_delete');" style="width:70px;">Удалить</button>
	{/if}
	</td>
	<td align="right" width="110px">Переместить в:&nbsp;</td>
	<td width="150px">
	<select name="folder" id="folder" style="width:145px;">
	{foreach from=$page.menu.folders item=l key=k}
		{if $l.sysname!=$smarty.get.fld}
			<option value="{$l.sysname}"{if $l.sysname==$page.menu.folder} selected{/if}>{$l.name} ({$l.count})</option>
		{/if}
	{/foreach}
	</select>
	</td>
	<td width="50px"><button onclick="mod_mail_messages_form_action('messages_move');" style="width:30px;">ОК</button></td>
	<td align="right" width="90px">Пометить:&nbsp;</td>
	<td width="150px">
	<select name="flag" id="flag" style="width:145px;">
	{foreach from=$page.menu.flags item=l key=k}
		<option value="{if is_int($k)}{0}{else}{$k}{/if}"{if strval($k) == $page.menu.flag} selected{/if}>{$l.name2}</option>
	{/foreach}
	</select>
	</td>
	<td width="50px"><button onclick="mod_mail_messages_form_action('messages_setflag');" style="width:30px;">ОК</button></td>
</tr>
</form>
</table>

<br/>

{if $smarty.capture.pageslink!="" }
{$smarty.capture.pageslink}
{/if}

<script type="text/javascript" language="javascript" src="/_scripts/themes/lines.js"></script>
<script type="text/javascript" language="javascript">
<!--
{literal}
lines_params.start = 0;
lines_params.end = {/literal}{$page.list.i-1|default:0}{literal},
lines_params.tr = 'tr';
lines_params.ch = 'ch';
lines_params.mainch = 'mainch';
lines_params.nobubble = ['a1_', 'a2_'];
lines_class.over = 'lines_over';
lines_class.normal = '';
lines_class.selected = 'lines_selected';
lines_init();
{/literal}
//-->
</script>
<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_messages_form = document.getElementById('mod_mail_messages_form');
	var mod_mail_messages_col = {/literal}{$page.list.i|default:0}{literal};
	var mod_mail_messages_start = 0;

	var mod_mail_messages_form_action_send = false;
	function mod_mail_messages_form_action(act)
	{
		if(mod_mail_messages_form_action_send)
			return false;

		if(act == 'messages_delete')
		{
			if(!mod_mail_messages_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_NO_MESSAGES_SELECTED)}{literal}');
				return false;
			}
		}
		else if(act == 'folder_clear')
		{
			mod_mail_messages_form.url.value = window.location.href;
		}
		else if(act == 'messages_setflag')
		{
			if(!mod_mail_messages_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_NO_MESSAGES_SELECTED)}{literal}');
				return false;
			}
			if(mod_mail_messages_form.flag.value == 0)
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_INCORRECT_FLAG)}{literal}');
				mod_mail_messages_form.flag.focus();
				return false;
			}
		}
		else if(act == 'messages_move')
		{
			if(!mod_mail_messages_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_NO_MESSAGES_SELECTED)}{literal}');
				return false;
			}
		}
		else
		{
			return false;
		}

		mod_mail_messages_form.action.value = act;

		mod_mail_messages_form_action_send = true;
		mod_mail_messages_form.submit();
		return true;
	}

	function mod_mail_messages_IsSelected(elem)
	{
		if (mod_mail_messages_start>=mod_mail_messages_col)
			return;
		for(var i=mod_mail_messages_start; i < mod_mail_messages_col; i++)
			if( document.getElementById(elem + ''+ i).checked )
				return true;
		return false;
	}

//    -->{/literal}
</script>


{/if}
