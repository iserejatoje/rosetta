{include file="`$TEMPLATE.sectiontitle`" type="2"}

{if $page.gallery.descr}<div class="profile_div">{$page.gallery.descr}</div>{/if}
<div class="profile_div">
{if $page.canaddalbum}<a href="{$page.addalbumurl}">Добавить альбом</a>{/if}
</div>
<br/>

{capture name=pageslink}
{include file="`$TEMPLATE.pages_link`" pages=$page.pageslink}
{/capture}

{$smarty.capture.pageslink}<br/>

{foreach from=$page.albums item=l}
	{include file=$TEMPLATE.ssections.thumb photo=$l count=$l.count}
{/foreach}

{$smarty.capture.pageslink}<br/>