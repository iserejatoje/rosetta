{if !empty($res.nodes)}
{foreach from=$res.nodes item=l name=last}
<div style="padding: 3px 0px 5px 5px">
	{if $l.id == $res.id}
		{$l.name|truncate:30}
	{else}
		<a href="/{$ENV.section}/{$l.path}/">{$l.name|truncate:30}</a>
	{/if}
	{if sizeof($l.nodes)}<div style="padding: 5px 0px 0px 15px">
		{foreach from=$l.nodes item=l2}
			<a href="/{$ENV.section}/{$l2.path}/">{$l2.name|truncate:30}</a><br/>
		{/foreach}
		</div>
	{/if}
</div>
{/foreach}
<div style="clear:both;"></div>
{/if}