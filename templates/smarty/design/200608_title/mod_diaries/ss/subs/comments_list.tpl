{assign var=_show_title value=false}

{include  file="`$TEMPLATE.menu_subs`"}		
<table width=100% cellpadding=0 cellspacing=0 border=0>
{capture name=pageslink}
{if count($res.list.pageslink.btn)>0}
<span class="pageslink">Страницы: 
	{if $res.list.pageslink.back!="" }<a href="{$res.list.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.list.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.list.pageslink.next!="" }<a href="{$res.list.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}
<tr><td>
 <table width=100% cellpadding=0 cellspacing=0 border=0>
 <tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
 {if $smarty.capture.pageslink!="" }
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 {/if}
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 <tr><td align=center>
<table width=100% cellpadding=3 cellspacing=1 border=0>
<form name=frmsubscribe method=POST>
<input type=hidden name=action value=subs_comments>
{if count($res.error.err)>0}	
<tr><td align=center bgcolor=#ffffff>{include  file="`$TEMPLATE.errors`" errors_list=$res.error.err}</td></tr>
{/if}
{if $res.list.count>0}
<tr>
<td align="right" class="text11" colspan=3>Всего подписок: {$res.list.count}. Возможно: {$res.list.count_all}.</td>
</tr>
<tr class="block_title2">
	<th width=40%>Название дневника</th>
	<th width=50%>Название записи</th>
	<th width=10%>Отписаться</th>
</tr>
{excycle values="#F5F9FA,#FFFFFF"}
{foreach from=$res.list.comments item=l key=k}
<tr bgcolor="{excycle}">
	<td><a href="/{$ENV.section}/{$CONFIG.files.get.journals_record.string}?id={$l.sjid}">{$l.uname}</td>	
	{if $l.rname}
		<td><a href="{$CONFIG.files.get.journals_comment.string}?id={$l.sjid}&rid={$l.srid}">{$l.rname}</td>
	{else}
		<td><a href="{$CONFIG.files.get.journals_comment.string}?id={$l.sjid}&rid={$l.srid}">Без названия</td>
	{/if}
	<td align=center><input type=checkbox name=ch{$k}>
		<input type=hidden name=row_{$k} value="type{$l.stype}rid{$l.srid}uid{$l.sjid}">
	</td>
</tr>
{/foreach}
<input type=hidden name=num_rows value={$res.list.count}>
<tr>
	<td colspan=3 align=center><input name=btnsub class=button type=submit value="сохранить изменения" style="width:200"></td>
</tr>
{else} 
	<tr><td align=center colspan=3><b>Список пуст.</td></tr>
{/if}
</form>
</table>
 </td></tr>
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 {if $smarty.capture.pageslink!="" }
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 {/if}
 </table>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
</table>