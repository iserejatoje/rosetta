<div>
		
		<b>
		
		{*<a href="/" colspan="3">Главная</a>
		 / <a href="/{$SITE_SECTION}/">{$GLOBAL.title[$SITE_SECTION]}</a>*}
		 
		{foreach from=$TITLE->Path item=url name=path}
			{if !$smarty.foreach.path.last}
				 {if !$smarty.foreach.path.first}/ {/if}<a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{elseif $url.link != ''}
				/ <a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{else}
				/ {$url.name}
			{/if}
		{/foreach}
		
		</b>
</div>
<br/>