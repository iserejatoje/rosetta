

{if count($res.list)==0}
<br/><br/><div align="center">У Вас нет ни одной компании, проверенной модератором.<br/>
Для добавления компании перейдите по ссылке <a href="/{$SITE_SECTION}/addorg.html">Добавить компанию</a></div><br/><br/>
{else}

{capture name=pageslink}
{if count($res.pages.btn) > 0}<span class="gl">
	Страницы:&#160;
	{if !empty($res.pages.back)}<a href="{$res.pages.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if !empty($res.pages.next)}<a href="{$res.pages.next}">&gt;&gt;</a>{/if}
{/if}</span>
{/capture}


<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
<tr><td colspan="3">{if $smarty.capture.pageslink!="" }
	{$smarty.capture.pageslink}
{/if}</td></tr>
<tr bgcolor="#dee7e7">
	<th class="gl">Дата обновления</th>
	<th class="gl">Название</th>
	<th class="gl">Действие</th>
</tr>
{excycle values="#FFFFFF,#F3F8F8"}
{foreach from=$res.list item=l}
<tr bgcolor="{excycle}">
	<td align="center" nowrap="nowrap">{$l.created|date_format:"%d.%m.%Y %H:%M"}</td>
	<td>{$l.name}</td>
	<td align="center" nowrap="nowrap"><a href="/{$SITE_SECTION}/editorg.html?id={$l.id}">править</a>&nbsp;|&nbsp;<a href="/{$SITE_SECTION}/delorg.html?id={$l.id}">удалить</a></td>
</tr>
{/foreach}
<tr><td colspan="3">{if $smarty.capture.pageslink!="" }
	{$smarty.capture.pageslink}
{/if}</td></tr>
</table>
{/if}