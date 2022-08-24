{foreach from=$res.sections item=l key=section}
 <br> <div class="fsmall" style="padding-left:10px;padding-right:4px;">
 <div class="fheader_stitle"><a href="{$res.urls[$section]}" class="fheader_stitle">{$section}</a></div>
{foreach from=$l item=l2}
	{if $l2.level==0}<nobr><a href="{$res.urls[$section]}{$CONFIG.files.get.view.string}?id={$l2.id}">{$l2.data.title}</a>&nbsp;</nobr>{/if}
{/foreach}
&nbsp;<a href="{$res.urls[$section]}{$CONFIG.files.get.active.string}"><font color="red">Активные&nbsp;дискуссии</a></nobr>
</div><br>
<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td width="16" class="ftable_header">&nbsp;</td>
	<td width="16" class="ftable_header">&nbsp;</td>
	<td class="ftable_header">Тема</td>
	<td class="ftable_header" align="center">Автор</td>
	<td width="50" class="ftable_header" align="center">Ответов</td>
	<td width="70" class="ftable_header" align="center">Просмотров</td>
	<td width="180" class="ftable_header" align="center">Последнее сообщение</td>
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$res.themes[$section] item=l}
<tr class="{excycle}">
	<td width="16" align="center">{if $l.closed!=0}<img src="{$CONFIG.image_url}t_closed.gif" alt="закрытая" title="закрытая">
		{elseif $l.fixed!=0}<img src="{$CONFIG.image_url}t_fixed.gif" alt="закрепленная" title="закрепленная">
		{elseif $l.messages>20}<img src="{$CONFIG.image_url}t_hot.gif" alt="горячая" title="горячая">
		{else}<img src="{$CONFIG.image_url}t_opened.gif" alt="открытая" title="открытая">{/if}</td>
	<td>{if !empty($l.icon)}<img src="{$CONFIG.image_url}icons/{$l.icon}" alt="{$l.alt}" title="{$l.alt}">{else}&nbsp;{/if}</td>
	<td>
		<span class="fsmall">{foreach from=$l.path item=l2}
		{if $l2.data.type=='section'}<a href="{$res.urls[$section]}{$CONFIG.files.get.view.string}?id={$l2.id}">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if} &gt;
		{/foreach}</span><br>
		{*{if $l.closed!=0}<font color="red">Закрытая тема:</font> {/if}*}
		{if $l.visible==0}<font color="blue">Скрытая тема:</font> {/if}
		{if $l.moderate!=0}<font color="green" title="Тема на премодерации">М:</font> {/if}
		{*{if $l.fixed!=0}<font color="blue">Закрепленная тема:</font> {/if}*}
		<a href="{$res.urls[$section]}{$CONFIG.files.get.theme.string}?id={$l.id}&act=last"><b>{$l.name}</b></a>
		{if !empty($l.pages)}<span class="small">Страницы: {foreach from=$l.pages item=p}{if $p=='...'}, ...{else}{if $p!=1},{/if} <a href="{$res.urls[$section]}{$CONFIG.files.get.theme.string}?id={$l.id}&p={$p}">{$p}</a>{/if}{/foreach}</span>{/if}
	</td>
	<td align="center">{if $l.user}<a href="{$l.user_info.infourl}" target="_blank">{/if}{$l.login}{if $l.user}</a>{/if}</td>
	<td align="center">{$l.messages|number_format:0:" ":" "}</td>
	<td align="center">{$l.views|number_format:0:" ":" "}</td>
	<td>{if $l.last_user}<a href="{$l.last_user_info.infourl}" target="_blank">{/if}<b>{$l.last_login}</b>{if $l.last_user}</a>{/if}<br><span class="small">{$l.last_date|simply_date}</span></td>
</tr>
{/foreach}
</table><br>
{/foreach}