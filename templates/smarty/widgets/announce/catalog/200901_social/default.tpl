{if !empty($res.nodes)}
<ul class="bulleted_list">
{foreach from=$res.nodes item=l name=last}
	{if $l.id == $res.id}
		<li class="level1_current">
		{$l.name|truncate:30}
	{else}
		<li class="level1">
		<a href="/{$ENV.section}/{$l.path}/">{$l.name|truncate:30}</a>
	{/if}
	{if sizeof($l.nodes)}
		<ul class="bulleted_list">
		{foreach from=$l.nodes item=l2}
			<li class="level2"><a href="/{$ENV.section}/{$l2.path}/">{$l2.name|truncate:30}</a></li>
		{/foreach}
		</ul>
	{/if}
	</li>
{/foreach}
</ul>
{/if}