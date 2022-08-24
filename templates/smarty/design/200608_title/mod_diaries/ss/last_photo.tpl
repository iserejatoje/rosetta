{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы: 
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}
<br/>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td align="left"><font class="place_title"><span>Новые фото</span></font></td>
<td align="right" class="dop5">
	{foreach from=$res.date_show item=l key=k name=show}
		{if $l.select}
			{$l.t}
		{else}
			<a class="s4" href="{$CONFIG.files.get.last_photo.string}?date_show={$k}">{$l.t}</a>
		{/if}
		{if !$smarty.foreach.show.last}&nbsp;|&nbsp;{/if}
	{/foreach}
</td>
</tr>
</table><br/>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td>
 <table width=100% cellpadding=0 cellspacing=0 border=0>
 {if $smarty.capture.pageslink!="" }
 <tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 {/if}
 <tr><td align=center>
<table width=100% cellpadding=3 cellspacing=1 border=0>
<tr align=left bgcolor=#FFFFFF>
	<td colspan=5>{$res.nav}</td>
</tr>
{if count($res.list)>0}
<tr align=center class="block_title2">
	<th>&nbsp;</th>
	<th width=35%>Название</th>
	<th width=15%>Автор</th>
	<th width=15%>Дата создания</th>
	<th width=35%>Информация</th>
</tr>
{excycle values="#F5F9FA,#FFFFFF"}
{foreach from=$res.list item=l}
<tr bgcolor={excycle}>
		<td><a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$l.uid}&parentid={$l.parentid}"><img src="{$l.img.url}" width="{$l.img.w}" height="{$l.img.h}"></a></td>
		<td><a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$l.uid}&parentid={$l.parentid}">{$l.name|escape}</a></td>
		<td><a class=text11 href="{$CONFIG.files.get.journals_record.string}?id={$l.uid}">{$l.uname|escape}</a></td>
		<td>{$l.date|date_format:'%d-%m-%Y<br>%H:%S'}</td>
		{if $l.img.file!=''}
			<td>({$l.img.w}x{$l.img.h}px)&nbsp;({if $l.img.size>1024}{$l.img.size/1024|number_format:0:",":" "}{else}{$l.img.size/1024|number_format:0:",":" "}{/if}Кб)<br>
			<a href='{$CONFIG.files.get.gallery_comment.string}?parentid={$l.parentid}&id={$l.uid}&gid={$l.id}'><img src='/_img/modules/mod_dnevniki/com.gif' height=15 border=0 align=absmiddle alt="Комментариев" border=0></a>&nbsp;<b>{$l.img.count_comment|number_format:0:",":" "}</b>&nbsp;&nbsp;&nbsp;
			<a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$l.uid}&parentid={$l.parentid}"><img src='/_img/modules/mod_dnevniki/eye.gif' height=15 border=0 align=absmiddle alt="Просмотров" border=0></a>&nbsp;<b>{$l.shows|number_format:0:",":" "}</b>
			</td>
		{else}
			<td>&nbsp;</td>	
		{/if}
</tr>
{/foreach}

{else}
<tr><td colspan=6 align=center bgcolor=#e9efef><b>Раздел пуст.</b></td></tr>
{/if}
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