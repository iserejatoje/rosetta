<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="left">
	<td class="block_title" style="text-align: left;padding-left: 18px"><span>Мой дневник</span></td>
</tr>
</table>
{*<div align="right" class="tip"><a href="/passport/announce/diary.php"><font color="#999999">настройка</font><img src="/_img/modules/passport/settings.gif" height="10" width="10" border="0" title="настройка" style="vertical-align:middle;margin-left:4px;" /></a></div>*}
<div class="tip">
	<a href="{$res.my_all_url}"><font color="#999999">мои записи: {$res.my_count}</font></a>&nbsp;&nbsp;&nbsp;
	<a href="{$res.add_url}">добавить</a>
</div>
{foreach from=$res.my_messages item=l}
<div style="padding-bottom:4px;">
	<div class="tip"><a href="{$l.url}">{$l.name}</a></div>
	{if $l.messages>0}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов({$l.messages}): <a href="{$l.url}">{$l.last_date|simply_date}</a></div>{/if}
</div>
{/foreach}
