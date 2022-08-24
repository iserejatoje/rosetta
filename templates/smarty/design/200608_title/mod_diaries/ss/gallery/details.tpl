
{if !sizeof($res.photo)}

	<br/><br/><br/><center>Фотография не найдена</center><br/><br/>

{else}

<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td><img src="/_img/x.gif" width=0 height=15 border=0></td></tr>
<tr><td>
	<table align==center cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr><td colspan=3 align=left>
		{$res.nav}
	</td></tr>
	<tr><td colspan=3><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
	<tr align=center valign=middle>
		{if !empty($res.pageslink_back.gid)}<td width=5%>
			<a href='{$CONFIG.files.get.gallery_details.string}?{$res.pageslink_back.link}&gid={$res.pageslink_back.gid}' title='предыдущая'>&lt;&lt;</a>
		</td>
		{/if}
		<td width=90%>
			{if $res.photo.prop=="imgzoom"}
				<a href="{$CONFIG.files.get.imgzoom.string}?img={$res.original.url}" onmouseover="window.status='Кликни для увеличения';return true;" onmouseout="window.status=defaultStatus" target="_blank" onclick="javascript:ImgZoom('{$CONFIG.files.get.imgzoom.string}?img={$res.original.url}','gallery{$res.list.id}',{$res.original.w+25},{$res.original.h+40});return false;">
				<img src="{$res.photo.url}" width="{$res.photo.w}" height="{$res.photo.h}" border="0" alt='Кликни для увеличения'>
				</a>
			{else}
				<img src="{$res.photo.url}" width="{$res.photo.w}" height="{$res.photo.h}" border="0">
			{/if}
		</td>
		{if !empty($res.pageslink_next.gid)}
		<td width=5%>
			<a href='{$CONFIG.files.get.gallery_details.string}?{$res.pageslink_next.link}&gid={$res.pageslink_next.gid}' title='следующая'>&gt;&gt;</a>
		</td>
		{/if}
	</tr>
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=10 border=0></td></tr>
<tr><td>
	<table align=center width=95% cellpadding=4 cellspacing=1 border=0>
	<tr align=left valign=top class="block_title2">
		<td width=20%><b>Название:</b></td>
		<td width=80% bgcolor=#F5F9FA>{$res.list.name}&nbsp;</td>
	</tr>
	<tr align=left valign=top class="block_title2">
		<td><b>Дата создания:</b></td>
		<td bgcolor=#F5F9FA>{$res.list.date|date_format:'%d-%m-%Y %H:%S'}&nbsp;</td>
	</tr>
	<tr align=left valign=top class="block_title2">
		<td><b>Дополнительная информация:</b></td>
		<td bgcolor=#F5F9FA>{$res.list.text}&nbsp;</td>
	</tr>
	<tr align=left valign=top class="block_title2">
		<td><b>Просмотров:</b></td>
		<td bgcolor=#F5F9FA>{$res.list.shows|number_format:0:",":" "}&nbsp;</td>
	</tr>
{if !$res.list.nocomment}
	<tr align=left valign=top class="block_title2">
		<td><b>Комментариев:</b></td>
		<td bgcolor=#F5F9FA>{if !$res.list.nocomment}{$res.list.comment|number_format:0:",":" "}{else}0{/if}
		&nbsp;&nbsp;<a href='{$CONFIG.files.get.gallery_comment.string}?parentid={$smarty.get.parentid}&id={$smarty.get.id}&gid={$smarty.get.gid}'>Смотреть</a>
		&nbsp;&nbsp;<a href='{$CONFIG.files.get.gallery_comment.string}?parentid={$smarty.get.parentid}&id={$smarty.get.id}&gid={$smarty.get.gid}#addcomment'>Добавить</a>
		</td>
	</tr>
{/if}
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=10 border=0></td></tr>
<tr><td align=center>
	<table align=center cellpadding=5 cellspacing=1 border=0 bgcolor=#999999>
	<tr align="center" valign="top" bgcolor="#ffffff">
	{foreach from=$res.pageslink item=l}
		<td class="comment_descr">
		{if $l.prop=="img"}
	                <a  href="{$CONFIG.files.get.gallery_details.string}?{$l.temp}&gid={$l.gid}">
			<img src="{$l.url}" width="{$l.w}" height="{$l.h}" border="0">
			</a>
		{else}
			<img src="{$l.url}" width="{$l.w}" height="{$l.h}" border="0">

		{/if}{if $CURRENT_ENV.site.domain=="cheldoctor.ru"}<br />{$l.name}{/if}
		</td>
	{/foreach}
	</tr>
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
</table>
{/if}