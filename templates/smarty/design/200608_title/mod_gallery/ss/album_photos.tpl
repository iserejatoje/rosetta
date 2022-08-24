{capture name=pageslink}
{if sizeof($pageslink.btn)}
<table border="0" cellpadding="3" cellspacing="0">
<tr>
	<td class="fheader_spath">Страницы:&#160;</td>
	{if $pageslink.back!="" }<td><a href="{$pageslink.back}" alt="Назад" title="Назад"><img src="/img/design/back.gif" alt="" border="0" height="10" width="10"></a></td>{/if}
	<td class="fheader_spath">
	{foreach from=$pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}" class="fmainmenu_link">{$l.text}</a>&nbsp;
		{else}
			<span class="fheader_spath">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	</td>
	{if $pageslink.next!="" }<td><a href="{$pageslink.next}" alt="Вперед" title="Вперед"><img src="/img/design/next.gif" alt="" border="0" height="10" width="10"></a></td>{/if}
</tr>
</table>
{/if}
{/capture}
<div align="center" class="zag2">
		<font color="#000000">Автор: </font>
		<a href="/{$ENV.section}/list/albums/u{$album.uid}.html"><font color="#005A52" 
		title="Смотреть альбомы {$album.user}">{$album.user}</font></a>
</div>
{$smarty.capture.pageslink}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		{foreach from=$photos key=_k item=photo name=photos}			
		<td align="center" width="33%" height="120" valign="top">
			<a href="/{$ENV.section}/view/photo/{$photo.id}.html">{if !empty($photo.image)}
					<img src="{$photo.image}" {$photo.image_size} style="border:#005A52 solid 1px" vspace="2" alt="Фото"  title="Смотреть фото &laquo;{$photo.name}&raquo;" />
				{else}<img src="/_img/design/200608_title/none.jpg" style="border: #005A52 solid 1px" vspace="2" alt="Нет фото" />{/if}</a><br/>
			<a href="/{$ENV.section}/view/photo/{$photo.id}.html"><font color="#005A52" title="Смотреть фото &laquo;{$photo.name}&raquo;"><b>{$photo.name}</b></font></a>
			{if $photo.comment && $photo.comment.name}<br/><br/><font class="zag3">{$photo.comment.name|truncate:30:"...":false},&nbsp;{"d.m"|date:$photo.comment.date}:</font>
					<font class="otzyv"><a class="otzyv" href="/{$ENV.section}/view/photo/{$photo.comment.st_id}.html#{$photo.comment.id}" title="последний комментарий">{$photo.comment.otziv}</a></font>
			{/if}
		</td>
	{if ($_k+1)%3 == 0 && !$smarty.foreach.photos.last}
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#005A52"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
	{/if}
		{/foreach}
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
</table>
{$smarty.capture.pageslink}