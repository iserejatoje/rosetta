<div style="padding-left:10px;padding-right:4px;">{$section_block}<br></div>
<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td width="16" class="ftable_header">&nbsp;</td>
	<td width="16" class="ftable_header">&nbsp;</td>
	<td class="ftable_header">Тема</td>
	<td class="ftable_header" align="center">Автор</td>
	<td width="50" class="ftable_header" align="center">Ответов</td>
	<td width="70" class="ftable_header" align="center">Просмотров</td>
	<td width="130" class="ftable_header" align="center">Последний ответ</td>
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$themes item=l}
<tr class="{excycle}">
	<td width="16" align="center">{if $l.closed!=0}<img src="{$ImgPath}t_closed.gif" alt="закрытая" title="закрытая">
		{elseif $l.fixed!=0}<img src="{$ImgPath}t_fixed.gif" alt="закрепленная" title="закрепленная">
		{elseif $l.messages>20}<img src="{$ImgPath}t_hot.gif" alt="горячая" title="горячая">
		{else}<img src="{$ImgPath}t_opened.gif" alt="открытая" title="открытая">{/if}</td>
	<td>{if !empty($l.icon)}<img src="{$ImgPath}icons/{$l.icon}" alt="{$l.alt}" title="{$l.alt}">{else}&nbsp;{/if}</td>
	<td>
		<span class="fsmall">{foreach from=$l.path item=l2}
		{if $l2.data.type=='section'}<a href="view.html?id={$l2.id}">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if} &gt; 
		{/foreach}</span><br>
		{*{if $l.closed!=0}<font color="red">Закрытая тема:</font> {/if}*}
		{if $l.visible==0}<font color="blue">Скрытая тема:</font> {/if}
		{if $l.moderate!=0}<font color="green" title="Тема на премодерации">М:</font> {/if}
		{*{if $l.fixed!=0}<font color="blue">Закрепленная тема:</font> {/if}*}
		<a href="theme.html?id={$l.id}&act=last"><b>{$l.name}</b></a>
	</td>
	<td align="center">{if $l.user}<a href="profile.html?user={$l.last_user}" target="_blank">{/if}{$l.login}{if $l.user}</a>{/if}</td>
	<td align="center"><b>{$l.messages|number_format:0:" ":" "}</b></td>
	<td align="center">{$l.views|number_format:0:" ":" "}</td>
	<td>{if $l.last_user}<a href="profile.html?user={$l.last_user}" target="_blank">{/if}<b>{$l.last_login}</b>{if $l.last_user}</a>{/if}<br><span class="fsmall">{$l.last_date|simply_date}</span></td>
</tr>
{/foreach}
</table>
<br>
{$other_forum_block}<br>
{include file=$TEMPLATE.ssections.__statistic}
