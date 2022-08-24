{if !empty($res.nodes)}

{foreach from=$res.nodes item=l name=last}
	{if sizeof($l.nodes)}
		{foreach from=$l.nodes item=l1}		
			{if $l1.id == $res.id}
				{assign var="parent" value=$l.id}
			{/if}
			{if sizeof($l1.nodes)}
				{foreach from=$l1.nodes item=l2}
					{if $l2.id == $res.id}
						{assign var="parent" value=$l.id}
						{assign var="parent1" value=$l1.id}
					{/if}
				{/foreach}
			{/if}
		{/foreach}
	{/if}
{/foreach}

<ul class="bulleted_list">
{foreach from=$res.nodes item=l name=last}
	{if $l.id == $res.id || $l.id == $parent}
		<li class="current">
	{else}
		<li>
	{/if}
	<a href="/{$CURRENT_ENV.section}/{$l.path}/">{$l.name|truncate:30}</a></span>
	
	{if sizeof($l.nodes)}
		<ul>
		{foreach from=$l.nodes item=l1}		
			{if $l1.id == $res.id || $l1.id == $parent1}
				<li class="current">
			{else}
				<li>
			{/if}
			{if $l1.id == $res.id}
				<b>{$l1.name|truncate:30}</b>
			{else}
				<a href="/{$CURRENT_ENV.section}/{$l1.path}/"{if $l1.id == $parent1} class="current"{/if}>{$l1.name|truncate:30}</a>
			{/if}
		
			{if sizeof($l1.nodes)}
				<ul>
				{foreach from=$l1.nodes item=l2}
					{if $l2.id == $res.id}
						<li class="current"><b>{$l2.name|truncate:30}</b>
					{else}
						<li><a href="/{$CURRENT_ENV.section}/{$l2.path}/">{$l2.name|truncate:30}</a>
					{/if}					
					
					{if sizeof($l2.nodes)}
						<ul>
						{foreach from=$l2.nodes item=l3}
							<li><a href="/{$ENV.section}/{$l3.path}/">{$l3.name|truncate:30}</a><br/></li>
						{/foreach}
						</ul>
					{/if}
					</li>
				{/foreach}
				</ul>
			{/if}
			</li>
		{/foreach}
		</ul>
	{/if}
	</li>
{/foreach}
</ul>
{/if}