{if $page.no_folder}
{* Нет такой папки *}
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

<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
<b>{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_FOLDER_IS_EMPTY)}</b>
	</td>
</tr>
</table>



{else}
{* Показываем письмо *}



{if count($page.error.err)>0}	
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="5px"></td></tr>
</table>
{/if}

{* list of messages *}
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
<tr><td colspan="2" height="3px" class="bg_color2" style="padding:0px;"><img src="/_img/x.gif" width="1" height="3" border="0" /></td></tr>

{if $message.headers.from.string!=""}
<tr align="left" valign="middle">
	<td width="100px" align="right" class="bg_color2">От кого:</td>
	<td>{if count($message.headers.from.array)>0}{foreach from=$message.headers.from.array item=from key=k}{if $k>0}, {/if}{if $from.name}{$from.name|escape:"tags"} &lt;{$from.user}@{$from.host}&gt;{else}{$from.user}@{$from.host}{/if}{/foreach}{else}{$message.headers.from.string}{/if}</td>
</tr>
{/if}
{if $message.headers.to.string!=""}
<tr align="left" valign="middle">
	<td align="right" class="bg_color2">Кому:</td>
	<td>{if count($message.headers.to.array)>0}{foreach from=$message.headers.to.array item=to key=k}{if $k>0}, {/if}{if $to.name}{$to.name|escape:"tags"} &lt;{$to.user}@{$to.host}&gt;{else}{$to.user}@{$to.host}{/if}{/foreach}{else}{$message.headers.to.string}{/if}</td>
</tr>
{/if}
{if $message.headers.cc.string!=""}
<tr align="left" valign="middle">
	<td align="right" class="bg_color2">Копии:</td>
	<td>{if count($message.headers.cc.array)>0}{foreach from=$message.headers.cc.array item=cc key=k}{if $k>0}, {/if}{if $cc.name}{$cc.name|escape:"tags"} &lt;{$cc.user}@{$cc.host}&gt;{else}{$cc.user}@{$cc.host}{/if}{/foreach}{else}{$message.headers.cc.string}{/if}</td>
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
			{$l.text|escape:"tags"|nl2br}
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
	</tr>
	{foreach from=$message.message.enclosure.partlist item=l key=k}
	<tr align="left" valign="top">
		<td>{$l.name}</td>
		<td>{$l.typestring}</td>
		<td align="right">{$l.size.0} {$l.size.1}</td>
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



<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_message_form = document.getElementById('mod_mail_message_form');
	var mod_mail_message_txt_part_active = {/literal}{$smarty.get.txt_part|default:0}{literal};
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
