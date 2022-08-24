{include file="`$TEMPLATE.sectiontitle`" type="2"}
{if $page.album.descr != ''}
<div style="margin:10px;">{$page.album.descr}</div>
{/if}
{*<div class="title" style="padding: 5px">{$page.album.title}</div>*}
{if $page.gallery.descr}<div class="profile_div">{$page.album.descr}</div>{/if}
<div class="profile_div">
	{if $page.caneditalbum}
	<div style="float:right; margin-left:20px">
		<a href="{$page.actions.delete}">Удалить альбом</a>
	</div>
	<div style="float:right; margin-left:20px">
		<a href="{$page.actions.edit}">Редактировать альбом</a>
	</div>
	<div style="float:right">
		{if is_array($page.rights)}{include file=$TEMPLATE.rightsmenu rights=$page.rights right=$page.album.rights url=$page.actions.setrights}{/if}
	</div>
	{/if}
	{if $page.canaddphoto}<div><a href="{$page.addphotourl}">Добавить фотографию</a></div>{/if}
</div>

{capture name=pageslink}
{include file="`$TEMPLATE.pages_link`" pages=$page.pageslink}
{/capture}

{$smarty.capture.pageslink}<br/>

{foreach from=$page.photos item=l}
	{include file=$TEMPLATE.ssections.thumb photo=$l}
{/foreach}

{$smarty.capture.pageslink}<br/>

<div style="clear:both"></div>