{capture name=pageslink}
{if !empty($pages.btn)}
	<div class="fpageslink">Страницы:
	{if $pages.back!="" }<a href="{$pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $pages.next!="" }&nbsp;<a href="{$pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
	</div>
{/if}
{/capture}
<script>{literal}
function checkaction(form)
{
	obj = form.elements['action'];
	if(obj.options[obj.selectedIndex].value=='')
		return false;
	return true;
}
{/literal}</script>
{if !empty($sections)}
{if $IsModerator}
<form method="POST" onsubmit="return checkaction(this);">
<input type="hidden" name="_action" value="_msection.html">
{/if}
<table width="100%" cellpadding="4">
<tr>
	<td class="ftable_header">Разделы</td>
	<td width="50" class="ftable_header" align="center">Тем</td>
	<td width="50" class="ftable_header" align="center">Сооб.</td>
	<td width="280" class="ftable_header" align="center">Последний ответ</td>
	{if $IsModerator}
	<td width="13" class="ftable_header">&nbsp;</td>
	{/if}
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$sections item=l}
<tr class="{excycle}">
	<td>
		{if $l.visible==0}<font color="blue">Скрытый раздел:</font> {/if}
		<a href="view.html?id={$l.id}"><b>{$l.name}</b></a><br><span class="fdescription">{$l.descr}</span>
		{if !empty($l.children)}<div class="fsubsection" style="padding-top:8px">
		{foreach from=$l.children item=l2}
        <a href="view.html?id={$l2.id}">{$l2.name}</a>&nbsp; 
        {/foreach}
        </div>
		{/if}</td>
	<td width="50" align="center" valign="top">{$l.themes|number_format:0:" ":" "}</td>
	<td width="50" align="center" valign="top">{$l.messages|number_format:0:" ":" "}</td>
	<td width="280" class="fsmall" valign="top">{if $l.last_login}{$l.last_date|simply_date}<br>Тема: {if !empty($l.last_theme_id)}<a href="theme.html?id={$l.last_theme_id}&act=last">{/if}<b>{$l.last_theme}</b>{if !empty($l.last_theme_id)}</a>{/if}{/if}<br>{if !empty($l.last_login)}Ответил: {if $l.last_user}<a href="profile.html?user={$l.last_user}" target="_blank">{/if}{$l.last_login}{if $l.last_user}</a>{/if}{/if}</td>
	{if $IsModerator}
	<td width="13" align="center" valign="top"><input type="checkbox" name="ids[]" value="{$l.id}"></td>
	{/if}
</tr>
{/foreach}
</table>
{if $IsModerator}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие для раздела -</option>
		<option value="close">Закрыть разделы</option>
		<option value="open">Открыть разделы</option>
		<option value="hide">Скрыть разделы</option>
		<option value="show">Показать разделы</option>
	</select>
	<input type="hidden" name="sectionid" value="{$sec_id}">
	<input type="submit" value="ОК" class="fcontrol">
</div>
</form>
{/if}
{/if}

{if $sec_id != 0}
{if $canaddtheme==true || $IsModerator}<div style="padding-left:4px"><b><a href="newtheme.html?id={$sec_id}">Новая тема</a></b></div>{/if}
{if empty($themes)}
{if $canaddtheme==true}
<div align="center"><b>Раздел пуст</b></div>
{/if}
{else}
{if $IsModerator}
<form method="POST" onsubmit="return checkaction(this);">
<input type="hidden" name="_action" value="_mtheme.html">
{/if}
<table width="100%" cellspacing="0" cellpadding="0"><tr>
<td>{$smarty.capture.pageslink}</td>
<td align="right">{if $USER->IsAuth()}<a href="_addsubscribe.html?id={$sec_id}&type=0" class="fpageslink" target="_blank">Подписаться на раздел</a>{/if}</td>
</tr></table>
<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td width="16" class="ftable_header">&nbsp;</td>
	<td width="16" class="ftable_header">&nbsp;</td>
	<td class="ftable_header">Тема</td>
	<td class="ftable_header" align="center">Автор</td>
	<td width="50" class="ftable_header" align="center">Ответов</td>
	<td width="70" class="ftable_header" align="center">Просмотров</td>
	<td width="130" class="ftable_header" align="center">Последний ответ</td>
	{if $IsModerator}
	<td width="13" class="ftable_header"></td>
	{/if}
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$themes item=l}
<tr class="{if $l.fixed!=0}frow_fixed{elseif $l.closed!=0}frow_closed{else}{excycle}{/if}">
	<td width="16" align="center">{if $l.closed!=0}<img src="{$ImgPath}t_closed.gif" alt="закрытая" title="закрытая">
		{elseif $l.fixed!=0}<img src="{$ImgPath}t_fixed.gif" alt="закрепленная" title="закрепленная">
		{elseif $l.messages>20}<img src="{$ImgPath}t_hot.gif" alt="горячая" title="горячая">
		{else}<img src="{$ImgPath}t_opened.gif" alt="открытая" title="открытая">{/if}</td>
	<td>{if !empty($l.icon)}<img src="{$ImgPath}icons/{$l.icon}" alt="{$l.alt}" title="{$l.alt}">{else}&nbsp;{/if}</td>
	<td>
		{*{if $l.closed!=0}<font color="red">Закрытая тема:</font> {/if}*}
		{if $l.visible==0}<font color="blue">Скрытая тема:</font> {/if}
		{if $l.moderate!=0}<span style="color:red;font-weight:bold" title="Тема на предмодерации">М:</span> {/if}
		{*{if $l.fixed!=0}<font color="blue">Закрепленная тема:</font> {/if}*}
		<a href="theme.html?id={$l.id}"><b>{$l.name}</b></a><br>{*{$l.descr}*}
		{if !empty($l.pages)}<span class="small">Страницы: {foreach from=$l.pages item=p}{if $p=='...'}, ...{else}{if $p!=1},{/if} <a href="theme.html?id={$l.id}&p={$p}">{$p}</a>{/if}{/foreach}</span>{/if}</td>
	<td align="center">{if $l.user}<a href="profile.html?user={$l.last_user}" target="_blank">{/if}{$l.login}{if $l.user}</a>{/if}</td>
	<td align="center"><b>{$l.messages|number_format:0:" ":" "}</b></td>
	<td align="center">{$l.views|number_format:0:" ":" "}</td>
	<td>{if $l.last_user}<a href="profile.html?user={$l.last_user}" target="_blank">{/if}<b>{$l.last_login}</b>{if $l.last_user}</a>{/if}<br><span class="small">{$l.last_date|simply_date}</span></td>
	{if $IsModerator}
	<td width="13" align="center"><input type="checkbox" name="ids[]" value="{$l.id}"></td>
	{/if}
</tr>
{/foreach}
</table>
{$smarty.capture.pageslink}
<br>
<div align="right">
	<select id="changesection" class="fcontrol">
		<option value="">- Перейти в раздел -</option>
		{foreach from=$sections_list item=l}
		<option value="{$l.id}"{if $sec_id==$l.id} selected{/if}>&nbsp;&nbsp;{$l.data.title|indent:$l.level:"&nbsp;&nbsp;&nbsp;"}</option>
		{/foreach}
	</select>
	&nbsp;&nbsp;<input type="button" value="перейти" class="fcontrol" onclick="obj=document.getElementById('changesection');if(obj.options[obj.selectedIndex].value!='') location.href='view.html?id='+obj.options[obj.selectedIndex].value;">
</div>
{if $IsModerator}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие для темы -</option>
		<option value="move">Переместить темы</option>
		<option value="delete">Удалить темы</option>
		<option value="fix">Закрепить темы</option>
		<option value="unfix">Открепить темы</option>
		<option value="close">Закрыть темы</option>
		<option value="open">Открыть темы</option>
{*		<option value="hide">Скрыть темы</option>
		<option value="show">Показать темы</option>*}
		<option value="onpremod">Включить премодерацию</option>
		<option value="offpremod">Выключить премодерацию</option>
	</select>
	<input type="hidden" name="p" value="{$page}">
	<input type="hidden" name="sectionid" value="{$sec_id}">
	<input type="submit" value="ОК" class="fcontrol">
</div>
</form>
{/if}
{/if}
{/if}
<br>
{$other_forum_block}<br>
{include file=$TEMPLATE.ssections.__statistic}