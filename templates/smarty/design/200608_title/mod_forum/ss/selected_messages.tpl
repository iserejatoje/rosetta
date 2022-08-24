{if $USER->IsAuth()}

{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div class="fpageslink">Страницы:
	{if $res.pages.back!="" }<a href="{$res.pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="{$res.pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
	</div>
{/if}
{/capture}
<form method="POST" onsubmit="return checkaction(this);">
<input type="hidden" name="p" value="{$res.page}">
<input type="hidden" name="action" value="delete_selected">
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
	<td width="10" class="ftable_header">&nbsp;</td>
</tr>
{if is_array($res.themes) &&count($res.themes) > 0}
{excycle values="frow_first,frow_second"}
{foreach from=$res.themes item=l}
<tr class="{excycle}">
	<td width="16" align="center">{if $l.closed!=0}<img src="{$CONFIG.image_url}t_closed.gif" alt="закрытая" title="закрытая">
		{elseif $l.fixed!=0}<img src="{$CONFIG.image_url}t_fixed.gif" alt="закрепленная" title="закрепленная">
		{elseif $l.messages>20}<img src="{$CONFIG.image_url}t_hot.gif" alt="горячая" title="горячая">
		{else}<img src="{$CONFIG.image_url}t_opened.gif" alt="открытая" title="открытая">{/if}</td>
	<td>{if !empty($l.icon)}<img src="{$CONFIG.image_url}icons/{$l.icon}" alt="{$l.alt}" title="{$l.alt}">{else}&nbsp;{/if}</td>
	<td>
		<span class="fsmall">{foreach from=$l.path item=l2}
		{if $l2.data.type=='section'}<a href="{$CONFIG.files.get.view.string}?id={$l2.id}">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if} &gt; 
		{/foreach}</span><br>
		{*{if $l.closed!=0}<font color="red">Закрытая тема:</font> {/if}*}
		{if $l.visible==0}<font color="blue">Скрытая тема:</font> {/if}
		{if $l.moderate!=0}<span style="color:green;font-weight:bold" title="Тема на премодерации">М:</span> {/if}
		{*{if $l.fixed!=0}<font color="blue">Закрепленная тема:</font> {/if}*}
		<a href="{$CONFIG.files.get.theme.string}?id={$l.id}&act=last"><b>{$l.name}</b></a>
	</td>
	<td align="center">{if $l.user}<a href="{$l.user_info.infourl}" target="_blank">{/if}{$l.login}{if $l.user}</a>{/if}</td>
	<td align="center"><b>{$l.messages|number_format:0:" ":" "}</b></td>
	<td align="center">{$l.views|number_format:0:" ":" "}</td>
	<td>{if $l.last_user}<a href="{$l.last_user_info.infourl}" target="_blank">{/if}<b>{$l.last_login}</b>{if $l.last_user}</a>{/if}<br><span class="small">{$l.last_date|simply_date}</span></td>
	<td align="center"><input type="checkbox" name="ids[]" value="{$l.id}"></td>
</tr>
{/foreach}
{else}
<tr>
	<td colspan="8" align="center">Список избранных тем пуст.</td>
</tr>
{/if}
</table>
{$smarty.capture.pageslink}
{if is_array($res.themes) &&count($res.themes) > 0}
<div align="center">
	<input type="submit" value="Удалить темы из избранного" class="fcontrol">
</div>
{/if}
</form>
<br>
<div align="right">
	<select id="changesection" class="fcontrol">
		<option value="">- Перейти в раздел -</option>
		{foreach from=$res.sections_list item=l}
		<option value="{$l.id}"{if $res.theme.sec_id==$l.id} selected{/if}>&nbsp;&nbsp;{$l.data.title|indent:$l.level:"&nbsp;&nbsp;&nbsp;"}</option>
		{/foreach}
	</select>
	&nbsp;&nbsp;<input type="button" value="перейти" class="fcontrol" onclick="obj=document.getElementById('changesection');if(obj.options[obj.selectedIndex].value!='') location.href='{$CONFIG.files.get.view.string}?id='+obj.options[obj.selectedIndex].value;">
</div>
<br>
{else}
<div align="center" class="fmtable_nickname" style="padding:30px;padding-bottom:50px;">
Чтобы просматривать избранные темы вам необходимо войти на форум.<br> <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Войти в форум</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.
</div>
{/if}