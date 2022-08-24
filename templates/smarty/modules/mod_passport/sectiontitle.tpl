{if isset($res.type)}
{assign var="type" value=$res.type}
{/if}

<div style="margin-bottom:15px;">

{if $type == 2}
{if sizeof($TITLE->Path) > 1}
<div style="font-size:10px;">
	{foreach from=$TITLE->Path item=url name=path}
		{if $smarty.foreach.path.iteration == 1}
			<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;" class="title"><a href="{$url.link}" class="zag3">{$url.name}</a></div>
		{elseif $smarty.foreach.path.iteration > 1}
			{if $smarty.foreach.path.iteration == 2}
				<div style="margin-left:30px; margin-bottom:5px;">
			{/if}
			{if $url.link != ''}
				<a href="{$url.link}" class="zag3">{$url.name}</a>
			{else}
				{$url.name}
			{/if}
			{if !$smarty.foreach.path.last}
			/
			{else}
			</div>
			{/if}
		{else}
			{if !$smarty.foreach.path.last}
				{if $url.link != ''}
					<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;"><a href="{$url.link}" class="zag3">{$url.name}</a></div>
				{else}
					<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;">{$url.name}</div>
				{/if}
			{else}
<div style="margin-top:10px;" class="title">{$url.name}</div>
			{/if}
		{/if}
	{/foreach}
</div>
{/if}
{*
<div style="font-size:10px;">
	{foreach from=$TITLE->Path item=url name=path}
		{if $smarty.foreach.path.iteration == 1}
			<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;" class="title"><a href="{$url.link}" class="zag3">{$user_name}</a></div>
		{elseif $smarty.foreach.path.iteration > 1}
			{if $smarty.foreach.path.iteration == 2}
				<div style="margin-left:30px; margin-bottom:5px;">
			{/if}
			{if $url.link != ''}
				<a href="{$url.link}" class="zag3">{$url.name}</a>
			{else}
				{$url.name}
			{/if}
			{if !$smarty.foreach.path.last}
			/
			{else}
			</div>
			{/if}
		{else}
			{if !$smarty.foreach.path.last}
				{if $url.link != ''}
					<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;"><a href="{$url.link}" class="zag3">{$url.name}</a></div>
				{else}
					<div style="margin-left:{math equation="x * y" x=10 y=$smarty.foreach.path.iteration}px; margin-bottom:5px;">{$url.name}</div>
				{/if}
			{else}
<div style="margin-top:10px;" class="title">{$url.name}</div>
			{/if}
		{/if}
	{/foreach}
</div>
*}
{/if}
</div>