
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
	<th>&nbsp;</th>
	<th width=50%>Название</th>
	<th width=15%>Дата создания</th>
	<th width=35%>Информация</th>
{if $USER->ID==$smarty.get.id}
	<th>Действие</th>
{/if}
</tr>
{excycle values="#F5F9FA,#FFFFFF"}
{foreach from=$res.list item=l}
<tr bgcolor={excycle}>
	{if $l.type==1}	
		{if $l.preview.url!=''}
			<td><a href="{$CONFIG.files.get.gallery_list.string}?id={$smarty.get.id}&parentid={$l.id}"><img src="{$l.preview.url}" width="{$l.preview.w}" height="{$l.preview.h}"></a></td>
		{else}
			<td>&nbsp;</td>				
		{/if}
		<td><img src="/_img/modules/mod_dnevniki/dirpic.gif" width=24 border=0 align=absmiddle alt="Папка" title="Папка"></td>
		<td><a href="{$CONFIG.files.get.gallery_list.string}?id={$smarty.get.id}&parentid={$l.id}"><b>{$l.name|escape}</a></td>
	{else}
		{if $l.img_small.url!=''}
			<td><a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$smarty.get.id}&parentid={$smarty.get.parentid}"><img src="{$l.img_small.url}" width="{$l.img_small.w}" height="{$l.img_small.h}"></a></td>
		{else}
			<td>&nbsp;</td>							
		{/if}
		<td><img src="/_img/modules/mod_dnevniki/imgpic.gif" width=24 border=0 align=absmiddle alt="Картинка" title="Картинка"></td>		
		<td><a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$smarty.get.id}&parentid={$smarty.get.parentid}">{$l.name|escape}</a></td>
	{/if}
	<td>{$l.date|date_format:'%d-%m-%Y<br>%H:%S'}</td>
	{if $l.type==1}	
	         <td>
			Папок: <b>{$l.finfo[1]|number_format:0:",":" "}</b><br>
			Фотографий: <b>{$l.finfo[2]|number_format:0:",":" "}</b>
		</td>
	{else}	
		{if $l.img.file!=''}
			<td>({$l.img.w}x{$l.img.h}px)&nbsp;({if $l.img.size>1024}{$l.img.size/1024|number_format:0:",":" "}{else}{$l.img.size/1024|number_format:0:",":" "}{/if}Кб)<br>
			<a href='{$CONFIG.files.get.gallery_comment.string}?parentid={$smarty.get.parentid}&id={$smarty.get.id}&gid={$l.id}'><img src='/_img/modules/mod_dnevniki/com.gif' height=15 border=0 align=absmiddle alt="Комментариев" border=0></a>&nbsp;<b>{$l.img.count_comment|number_format:0:",":" "}</b>&nbsp;&nbsp;&nbsp;
			<a href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$smarty.get.id}&parentid={$smarty.get.parentid}"><img src='/_img/modules/mod_dnevniki/eye.gif' height=15 border=0 align=absmiddle alt="Просмотров" border=0></a>&nbsp;<b>{$l.shows|number_format:0:",":" "}</b>
			</td>
		{else}
			<td>&nbsp;</td>	
		{/if}
	{/if}
	{if $smarty.get.id==$USER->ID}
		<td align=center>
        {if $l.type==1}	
			<a href='{$CONFIG.files.get.gallery_folder_edit.string}?id={$smarty.get.id}&parentid={$smarty.get.parentid}&gid={$l.id}&p={$smarty.get.p}'><img src='/_img/modules/mod_dnevniki/btnwrite.gif' width=16 border=0 align=absmiddle alt='Редактировать'></a>
		{else}
			<a href='{$CONFIG.files.get.gallery_edit.string}?id={$smarty.get.id}&parentid={$smarty.get.parentid}&gid={$l.id}&p={$smarty.get.p}'><img src='/_img/modules/mod_dnevniki/btnwrite.gif' width=16 border=0 align=absmiddle alt='Редактировать'></a>
		{/if}
		&nbsp;<a href='{$CONFIG.files.get.gallery_del.string}?id={$smarty.get.id}&parentid={$smarty.get.parentid}&gid={$l.id}&p={$smarty.get.p}'><img src='/_img/modules/mod_dnevniki/btndel.gif' width=20 border=0 align=absmiddle alt='Удалить'></a></td>
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