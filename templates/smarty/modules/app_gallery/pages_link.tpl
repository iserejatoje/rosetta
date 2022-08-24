{*if is_array($pages.btn) && sizeof($pages.btn)}
<div>
	<div class="pager" {if $left}style="float:left"{/if}>
	
		{if $hide_title !== true}<div class="ptitle">Страницы:</div>{/if}
		
		{if $pages.first}
			<div class="page"><a href="{$pages.first}" title="Первая страница">&lt;&lt;</a></div>
		{/if}
		{if $pages.back}
			<div class="page"><a href="{$pages.back}" title="Предыдущая страница">&lt;</a></div>
		{/if}
		
		{foreach from=$pages.btn item=l}
		{if $l.active}
		<div class="page current">{$l.text}</div>
		{else}
		<div class="page"><a href="{$l.link}">{$l.text}</a></div>
		{/if}
		{/foreach}
		
		{if $pages.next}
			<div class="page"><a href="{$pages.next}" title="Следующая страница">&gt;</a></div>
		{/if}
		{if $pages.last}
			<div class="page"><a href="{$pages.last}" title="Последняя страница">&gt;&gt;</a></div>
		{/if}
		
		<br clear="both"/>
	</div><br clear="both"/>
</div>
{/if*}

{capture name=pageslink}
{if !empty($pages.btn)}
	<div class="pager">
	<span class="ptitle">Страницы:</span>
	{if $pages.first}
		<a href="{$pages.first}" class="page">первая</a>
	{/if}
	{if $pages.back!="" }<a href="{$pages.back}" class="page">&lt;&lt;</a>{/if}
	{foreach from=$pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="page">{$l.text}</a>
		{else}
			&nbsp;<span class="current">{$l.text}</span>
		{/if}
	{/foreach}
	{if $pages.next!="" }&nbsp;<a href="{$pages.next}" class="page">&gt;&gt;</a>{/if}
	{if $pages.last}
		<a href="{$pages.last}" class="page">последняя</a>
	{/if}
	<br clear="both"/>
	</div><br clear="both"/>	
{/if}
{/capture}
{$smarty.capture.pageslink}