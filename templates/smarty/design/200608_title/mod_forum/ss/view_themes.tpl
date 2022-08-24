{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div class="fpageslink">Страницы:
	{if $res.pages.first!="" }<a href="{$res.pages.first}" class="fpageslink">первая</a>{/if}
	{if $res.pages.back!="" }<a href="{$res.pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="{$res.pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
	{if $res.pages.last!="" }&nbsp;<a href="{$res.pages.last}" class="fpageslink">последняя</a>{/if}
	</div>
{/if}
{/capture}
{if !$res.isroot}
{if $res.canaddtheme==true}<div style="padding-left:4px"><b><a href="{$CONFIG.files.get.new_theme.string}?id={$res.section_id}">Новая тема</a></b></div>{/if}
{if empty($res.themes)}
{if $res.canaddtheme==true}
<div align="center"><b>Раздел пуст</b></div>
{/if}
{else}
{if $res.canedittheme}
<form method="POST" onsubmit="return checkaction(this);">
{/if}
<div>{$smarty.capture.pageslink}</div>
<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td width="16" class="ftable_header">&nbsp;</td>
	<td width="16" class="ftable_header">&nbsp;</td>
	<td class="ftable_header">Тема</td>
	<td class="ftable_header" align="center">Автор</td>
	<td width="50" class="ftable_header" align="center">Ответов</td>
	<td width="70" class="ftable_header" align="center">Просмотров</td>
	<td width="130" class="ftable_header" align="center">Последний ответ</td>
	{if $res.canedittheme}
	<td width="13" class="ftable_header">
		<div class="s_divs" id="all_sel" onClick="SetChecks('ids[]', 1, 'all_unsel')" title="Выделить все">+</div><div class="s_divs" id="all_unsel" onClick="SetChecks('ids[]', 0, 'all_sel')" style="display:none;" title="Снять со всех">&mdash;</div>
	</td>
	{/if}
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$res.themes item=l}
{*if in_array($USER->ID, array(782423))*}
<tr class="{if $l.action_type == $CONFIG.actions.themes.delete}from_deleted{else}{if $l.fixed!=0}frow_fixed{elseif $l.closed!=0}frow_closed{else}{excycle}{/if}{/if}">
{*else}
<tr class="{if $l.fixed!=0}frow_fixed{elseif $l.closed!=0}frow_closed{else}{excycle}{/if}">
{/if*}
	<td width="16" align="center">
		{*if in_array($USER->ID, array(782423))*}
			{if $l.action_type == $CONFIG.actions.themes.delete}
				<img src="{$CONFIG.image_url}t_deleted.gif" alt="удаленная" title="удаленная">
			{else}
				{if $l.closed!=0}
					<img src="{$CONFIG.image_url}t_closed.gif" alt="закрытая" title="закрытая">
				{elseif $l.fixed!=0}
					<img src="{$CONFIG.image_url}t_fixed.gif" alt="закрепленная" title="закрепленная">
				{elseif $l.messages>20}
					<img src="{$CONFIG.image_url}t_hot.gif" alt="горячая" title="горячая">
				{else}
				<img src="{$CONFIG.image_url}t_opened.gif" alt="открытая" title="открытая">
				{/if}
			{/if}
		{*else}
			{if $l.closed!=0}
				<img src="{$CONFIG.image_url}t_closed.gif" alt="закрытая" title="закрытая">
			{elseif $l.fixed!=0}
				<img src="{$CONFIG.image_url}t_fixed.gif" alt="закрепленная" title="закрепленная">
			{elseif $l.messages>20}
				<img src="{$CONFIG.image_url}t_hot.gif" alt="горячая" title="горячая">
			{else}
			<img src="{$CONFIG.image_url}t_opened.gif" alt="открытая" title="открытая">{/if}
		{/if*}
	</td>
	<td>
		{if !empty($l.icon)}<img src="{$CONFIG.image_url}icons/{$l.icon}" alt="{$l.alt}" title="{$l.alt}">{else}&nbsp;{/if}
	</td>
	<td>
		{*if in_array($USER->ID, array(782423))*}
		
			{if $l.action_type == $CONFIG.actions.themes.delete}
				<a style="color:#898989" href="{$CONFIG.files.get.theme.string}?id={$l.id}"><b>{$l.name|wordwrap:80:' ':true}</b></a><br>
			{else}
				{*{if $l.closed!=0}<font color="red">Закрытая тема:</font> {/if}*}
				{if $l.visible==0}<font color="blue">Скрытая тема:</font> {/if}
				{if $l.moderate!=0}<span style="color:red;font-weight:bold" title="Тема на предмодерации">М:</span> {/if}
				{*{if $l.fixed!=0}<font color="blue">Закрепленная тема:</font> {/if}*}
				<a href="{$CONFIG.files.get.theme.string}?id={$l.id}"><b>{$l.name|wordwrap:80:' ':true}</b></a><br>{*{$l.descr}*}			
				{if !empty($l.pages)}<span class="small">Страницы: {foreach from=$l.pages item=p}{if $p=='...'}, ...{else}{if $p!=1},{/if} <a href="{$CONFIG.files.get.theme.string}?id={$l.id}&p={$p}">{$p}</a>{/if}{/foreach}</span>{/if}
			{/if}

			{if $l.action_type == $CONFIG.actions.themes.close}
			<span class="fthemeaction">Тема закрыта модератором {$l.action_user->Profile.general.ShowName} {$l.action_date|simply_date}</span>
			{elseif $l.action_type == $CONFIG.actions.themes.fixed}
			<span class="fthemeaction">Тема закреплена модератором {$l.action_user->Profile.general.ShowName} {$l.action_date|simply_date}</span>
			{elseif $l.action_type == $CONFIG.actions.themes.move}
			<span class="fthemeaction">Тема перемещена модератором {$l.action_user->Profile.general.ShowName} {$l.action_date|simply_date}</span>
			{elseif $l.action_type == $CONFIG.actions.themes.premoderate}
			<span class="fthemeaction">Тема премодерируется модератором {$l.action_user->Profile.general.ShowName} {$l.action_date|simply_date}</span>
			{elseif $l.action_type == $CONFIG.actions.themes.delete}
			<span class="fthemeaction">Тема удалена {if $l.action_user->ID == $l.user}автором{else}модератором {$l.action_user->Profile.general.ShowName}{/if} {$l.action_date|simply_date}</span>
			{/if}
		
		
	</td>
		
		
	<td align="center">{if $l.user}<a href="{$l.user_info.infourl}" target="_blank">{/if}{$l.login}{if $l.user}</a>{/if}</td>
	<td align="center"><b>{$l.messages|number_format:0:" ":" "}</b></td>
	<td align="center">{$l.views|number_format:0:" ":" "}</td>
	<td>{if $l.last_user}<a href="{$l.last_user_info.infourl}" target="_blank">{/if}<b>{$l.last_login}</b>{if $l.last_user}</a>{/if}<br><span class="small">{$l.last_date|simply_date}</span></td>
	{if $res.canedittheme}
	<td width="13" align="center">
	{if $l.action_type != $CONFIG.actions.themes.delete}<input type="checkbox" name="ids[]" value="{$l.id}">{/if}
	</td>
	{/if}
</tr>
{/foreach}
</table>
{$smarty.capture.pageslink}
<br>
<div align="right">
	<select id="changesection" class="fcontrol">
		<option value="">- Перейти в раздел -</option>
		{foreach from=$res.sections_list item=l}
		{if $l.data.visible==1}
		<option value="{$l.id}"{if $sec_id==$l.id} selected{/if}>&nbsp;&nbsp;{$l.data.title|indent:$l.level:"&nbsp;&nbsp;&nbsp;"}</option>
		{/if}
		{/foreach}
	</select>
	&nbsp;&nbsp;<input type="button" value="перейти" class="fcontrol" onclick="obj=document.getElementById('changesection');if(obj.options[obj.selectedIndex].value!='') location.href='{$CONFIG.files.get.view.string}?id='+obj.options[obj.selectedIndex].value;">
</div>
{if $res.canedittheme}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие для темы -</option>
		<option value="move_theme">Переместить темы</option>
		<option value="delete_theme">Удалить темы</option>
		<option value="fix_theme">Закрепить темы</option>
		<option value="unfix_theme">Открепить темы</option>
		<option value="close_theme">Закрыть темы</option>
		<option value="open_theme">Открыть темы</option>
		<option value="premod_theme">Включить премодерацию</option>
		<option value="unpremod_theme">Выключить премодерацию</option>
	</select>
	<input type="hidden" name="p" value="{$res.page}">
	<input type="hidden" name="section" value="{$res.section_id}">
	<input type="submit" value="ОК" class="fcontrol">
</div>
</form>
{/if}
{/if}
{/if}
<br>
{*$other_forum_block}<br>
{include file=$TEMPLATE.ssections.__statistic*}
