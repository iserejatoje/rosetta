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

<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
<b>{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_FOLDER_IS_EMPTY)}</b>
	</td>
</tr>
</table>


{else}
{* Показываем письмо *}



<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{$page.folder.name}</span></td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message_reply.string}?action=reply&fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$smarty.get.part}">{strip}
			<img src="/_img/modules/mail/ico/answer.gif" width="16" height="16" border="0" align="absmiddle" title="Ответить" alt="Ответить" /> Ответить
			{/strip}</a></td>
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message_reply.string}?action=replyall&fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$smarty.get.part}">{strip}
			<img src="/_img/modules/mail/ico/answer_all.gif" width="16" height="16" border="0" align="absmiddle" title="Ответить всем" alt="Ответить всем" /> Ответить всем
			{/strip}</a></td>
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message_reply.string}?action=forward&fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$smarty.get.part}">{strip}
			<img src="/_img/modules/mail/ico/fwd.gif" width="16" height="16" border="0" align="absmiddle" title="Переслать" alt="Переслать" /> Переслать
			{/strip}</a></td>
		{*
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message_reply.string}?action=redirect&fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$smarty.get.part}">{strip}
			<img src="/_img/modules/mail/ico/redirect.gif" width="16" height="16" border="0" align="absmiddle" title="Ответить всем" alt="Ответить всем" /> Перенаправить
			{/strip}</a></td>
		*}
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message_print.string}?{$page.details.link}&id={$smarty.get.id}&part={$smarty.get.part}" target="_blank">{strip}
			<img src="/_img/modules/mail/ico/print.gif" width="16" height="16" border="0" align="absmiddle" title="Печать" alt="Печать" /> Печать
			{/strip}</a></td>
		{if $smarty.get.show_header==1}
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link}&id={$smarty.get.id}&part={$smarty.get.part}">{strip}
			<img src="/_img/modules/mail/ico/txt.gif" width="16" height="16" border="0" align="absmiddle" title="Текст" alt="Текст" /> Текст
			{/strip}</a></td>
		{else}
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link}&id={$smarty.get.id}&part={$smarty.get.part}&show_header=1">{strip}
			<img src="/_img/modules/mail/ico/rfc.gif" width="16" height="16" border="0" align="absmiddle" title="Заголовки" alt="Заголовки" /> Заголовки
			{/strip}</a></td>
		{/if}
		</tr>
		</table>
	
	</td>
</tr>
</table>



<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>
{if $smarty.get.fld=='Sent'}
	{if count($page.details.list.0.headers.to.array)>0}
	Письмо для 
		{if $page.details.list.0.headers.to.array.0.name}
			{$page.details.list.0.headers.to.array.0.name|escape:"tags"} &lt;{$page.details.list.0.headers.to.array.0.user}@{$page.details.list.0.headers.to.array.0.host}&gt;
		{else}
			{$page.details.list.0.headers.to.array.0.user}@{$page.details.list.0.headers.to.array.0.host}
		{/if}
		{if count($page.details.list.0.headers.to.array)>1}...{/if}
	{else}
		{$page.details.list.0.headers.to.string}
	{/if}
{else}
	{if count($page.details.list.0.headers.from.array)>0}
	Письмо от 
		{if $page.details.list.0.headers.from.array.0.name}
			{$page.details.list.0.headers.from.array.0.name|escape:"tags"} &lt;{$page.details.list.0.headers.from.array.0.user}@{$page.details.list.0.headers.from.array.0.host}&gt;
		{else}
			{$page.details.list.0.headers.from.array.0.user}@{$page.details.list.0.headers.from.array.0.host}
		{/if}
		{if count($page.details.list.0.headers.from.array)>1}...{/if}
	{else}
		{$page.details.list.0.headers.from.string}
	{/if}
{/if}
</span></td></tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="5px"></td></tr>
</table>
<table cellpadding="0" cellspacing="0" border="0">
<form name="mod_mail_message_form" id="mod_mail_message_form" method="post">
<input type="hidden" name="action" value="">
<input type="hidden" name="fld" value="{$smarty.get.fld|escape:"quotes"}">
<input type="hidden" name="ch[{$smarty.get.id}]" value="1">
<tr>
	<td width="80px">
	<button onclick="mod_mail_message_form_action('messages_delete');" style="width:70px;">Удалить</button>
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
	<td width="50px"><button onclick="mod_mail_message_form_action('messages_move');" style="width:30px;">ОК</button></td>
	<td align="right" width="90px">Пометить:&nbsp;</td>
	<td width="150px">
	<select name="flag" id="flag" style="width:145px;">
	{foreach from=$page.menu.flags item=l key=k}
		<option value="{if is_int($k)}{0}{else}{$k}{/if}"{if strval($k) == $page.menu.flag} selected{/if}>{$l.name2}</option>
	{/foreach}
	</select>
	</td>
	<td width="50px"><button onclick="mod_mail_message_form_action('messages_setflag');" style="width:30px;">ОК</button></td>
</tr>
</form>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>

{if count($page.error.err)>0}	
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>
{/if}


{* message details *}
{assign var="prev_part" value=""}
{foreach from=$page.details.list item=message key=key}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
{if $key>0}
	<td width="{$key*10}"><img src="/_img/x.gif" width="{$key*10}" height="1" border="0" /></td>
{/if}
	<td>


{* сообщение *}
<table width="100%" cellpadding="3" cellspacing="1" border="0">
{if $key>0}
<tr><td colspan="2" height="3px" class="bg_color2" style="padding:0px;"><img src="/_img/x.gif" width="1" height="3" border="0" /></td></tr>
{/if}

{if $message.headers.from.string!=""}
<tr align="left" valign="middle">
	<td width="100px" align="right" class="bg_color2">От кого:</td>
	<td>{strip}{if count($message.headers.from.array)>0}{foreach from=$message.headers.from.array item=from key=k}
		{if $k>0}, {/if}
		{if !($from.user==$page.user.username && $from.host==$page.user.domain)}<a href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}?name={$from.name|escape:"url"}&email={$from.user|escape:"url"}@{$from.host|escape:"url"}&url={$smarty.server.REQUEST_URI|escape:"url"}" title="Добавить в адресную книгу"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Добавить в адресную книгу" /></a>&nbsp;{/if}
		<span title="{$from.user}@{$from.host}">{if $from.name}{$from.name|escape:"tags"}{else}{$from.user}@{$from.host}{/if}</span>
	{/foreach}
	{else}
		{$message.headers.from.string}
	{/if}{/strip}</td>
</tr>
{/if}
{if $message.headers.to.string!=""}
<tr align="left" valign="middle">
	<td align="right" class="bg_color2">Кому:</td>
	<td>{strip}{if count($message.headers.to.array)>0}{foreach from=$message.headers.to.array item=to key=k}
		{if $k>0}, {/if}
		{if !($to.user==$page.user.username && $to.host==$page.user.domain)}<a href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}?name={$to.name|escape:"url"}&email={$to.user|escape:"url"}@{$to.host|escape:"url"}&url={$smarty.server.REQUEST_URI|escape:"url"}" title="Добавить в адресную книгу"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Добавить в адресную книгу" /></a>&nbsp;{/if}
		<span title="{$to.user}@{$to.host}">{if $to.name}{$to.name|escape:"tags"}{else}{$to.user}@{$to.host}{/if}</span>
	{/foreach}
	{else}
		{$message.headers.to.string}
	{/if}{/strip}</td>
</tr>
{/if}
{if $message.headers.cc.string!=""}
<tr align="left" valign="middle">
	<td align="right" class="bg_color2">Копии:</td>
	<td>{strip}{if count($message.headers.cc.array)>0}{foreach from=$message.headers.cc.array item=cc key=k}
		{if $k>0}, {/if}
		{if !($cc.user==$page.user.username && $cc.host==$page.user.domain)}<a href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}?name={$cc.name|escape:"url"}&email={$cc.user|escape:"url"}@{$cc.host|escape:"url"}&url={$smarty.server.REQUEST_URI|escape:"url"}"><img src="/_img/modules/mail/ico/people.gif" width="16" height="16" border="0" align="absmiddle" alt="Добавить адрес" title="Добавить в адресную книгу" /></a>&nbsp;{/if}
		<span title="{$cc.user}@{$cc.host}">{if $cc.name}{$cc.name|escape:"tags"}{else}{$cc.user}@{$cc.host}{/if}</span>
	{/foreach}
	{else}
		{$message.headers.cc.string}
	{/if}{/strip}</td>
</tr>
{/if}
<tr align="left" valign="middle">
	<td width="100px" align="right" class="bg_color2">Дата:</td>
	<td>{if $message.headers.timestamp==0}<span title="Дата не указана или не определена" style="cursor:pointer; cursor:hand;">&lt;???&gt;</span>{else}{$message.headers.timestamp|date_format:"%d.%m.%Y <small>%H:%M:%S</small>"}{/if}</td>
</tr>
{if $message.headers.subject}
<tr align="left" valign="middle">
	<td align="right" class="bg_color2">Тема:</td>
	<td>{$message.headers.subject|escape:"tags"}</td>
</tr>
{/if}
</table>

{if $page.details.last_message_key == $key}
{* показываем внутренности только у последнего сообщения *}

{if $smarty.get.show_header==1}
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr align="left"><td>
	<pre>{$page.details.header|escape:"tags"}</pre>
{*	{$page.details.header|escape:"tags"|replace:" ":"&nbsp;"|replace:"\t":"&nbsp;&nbsp;&nbsp;&nbsp;"|nl2br}*}
</td></tr>
</table>
{/if}

{if count($message.message.body)>1}
	<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr align="left">
		<td>
	{foreach from=$message.message.body item=l key=k}
		{if $k>0}&nbsp;&nbsp;{/if}
		<a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link_txt_part}&txt_part={$k}" onclick="mod_mail_message_change_txt_part({$k}); return false;">{strip}
		{if $l.type == 'text/plain'}
			{$k+1}. В виде текста
		{elseif $l.type == 'text/html'}
			{$k+1}. В виде HTML
		{else}
			{$k+1}. Неизвестный формат
		{/if}
		{/strip}</a>
	{/foreach}
		</td>
	</tr>
	</table>
{/if}
{if count($message.message.body)>0}
	<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr align="left"><td>
	{foreach from=$message.message.body item=l key=k}
	<div id="message_txt_part_{$k}" style="display:{if $smarty.get.txt_part == $k}block{else}none{/if};">
		{if $l.type == 'text/plain'}
			{$l.text|escape:"tags"|nl2br|with_href:true}
{*			{$l.text|escape:"tags"|replace:" ":"&nbsp;"|replace:"\t":"&nbsp;&nbsp;&nbsp;&nbsp;"|nl2br}*}
		{elseif $l.type == 'text/html'}
			<div><xHTML><xBODY>
			{$l.text}
			</xBODY></xHTML></div>
		{else}
			{$l.text|escape:"tags"|nl2br}
		{/if}
	</div>
	{/foreach}
	</td></tr>
	</table>
{/if}
{if count($message.message.enclosure.partlist)>0}
<br />
	<b>Вложения:</b><br />
	<table class="table" cellpadding="0" cellspacing="1" border="0">
	<tr valign="middle">
		<th width="250px">Имя файла</th>
		<th width="120px">Тип</th>
		<th width="100px">Размер</th>
		<th>&nbsp;</th>
	</tr>
	{foreach from=$message.message.enclosure.partlist item=l key=k}
	<tr align="left" valign="top">
		<td>{$l.name}</td>
		<td>{$l.typestring}</td>
		<td align="right">{$l.size.0} {$l.size.1}</td>
		<td>{strip}
		<a href="/{$ENV.section}/{$CONFIG.files.get.message_attachment.string}?fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$k}&method=load">Загрузить</a>
		{if $l.typecode == 2}
		&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link_part}&part={$k}">Открыть</a>
		{elseif $l.typecode == 5}
		&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.message_attachment.string}?fld={$smarty.get.fld|escape:"url"}&id={$smarty.get.id}&part={$k}&method=view">Просмотр</a>
		{/if}
		</td>{/strip}
	</tr>
	{/foreach}
	</table>
{/if}

{* END показываем внутренности только у последнего сообщения *}
{/if}
{* конец сообщения *}


	</td>
{if $key>0}
	<td width="14px"><a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link_part}&part={$prev_part}"><img src="/_img/modules/mail/ico/close.gif" width="14" height="14" border="0" style="margin-top:1px;" alt="X" title="закрыть сообщение" /></a></td>
{/if}
</tr>

{assign var="prev_part" value="`$message.part`"}

</table>



{/foreach}
{* END of message details *}

<br />
<table align="center" width="95%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="left" width="50%">{strip}
	{if $page.details.message_back}<a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link_message}&id={$page.details.message_back}">
	&larr; предыдущее письмо
	</a>{/if}
	{/strip}</td>
	<td align="right" width="50%">{strip}
	{if $page.details.message_next}<a href="/{$ENV.section}/{$CONFIG.files.get.message.string}?{$page.details.link_message}&id={$page.details.message_next}">
	следующее письмо &rarr;
	</a>{/if}
	{/strip}</td>
</tr>
</table>


<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_message_form = document.getElementById('mod_mail_message_form');
	var mod_mail_message_txt_part_active = {/literal}{$smarty.get.txt_part|default:0}{literal};
	var mod_mail_message_form_action_send = false;
	function mod_mail_message_form_action(act)
	{
		if(mod_mail_message_form_action_send)
			return false;
		
		if(act == 'messages_delete')
		{
//
		}
		else if(act == 'messages_setflag')
		{
			if(mod_mail_message_form.flag.value == 0)
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_INCORRECT_FLAG)}{literal}');
				mod_mail_message_form.flag.focus();
				return false;
			}
		}
		else if(act == 'messages_move')
		{
//
		}
		else
		{
			return false;
		}
		
		mod_mail_message_form.action.value = act;
			
		mod_mail_message_form_action_send = true;
		mod_mail_message_form.submit();
		return true;
	}
	
	function mod_mail_message_change_txt_part(d)
	{
		if(mod_mail_message_txt_part_active == d)
			return false;
		var block_old = document.getElementById('message_txt_part_'+mod_mail_message_txt_part_active);
		var block = document.getElementById('message_txt_part_'+d);
		block.style.display = 'block';
		block_old.style.display = 'none';
		mod_mail_message_txt_part_active = d;
	}
	
//    -->{/literal}
</script>


{/if}
