{if !empty($res.nodes)}


{foreach from=$res.nodes item=l name=last}
<div align="left" class="block_title" style="text-align: left; padding-left: 18px; padding-right:0px; position:relative; margin-bottom: 2px;">
	<span><a href="/{$CURRENT_ENV.section}/{$l.path}/">{$l.name|truncate:30}</a></span>
</div>
	{if sizeof($l.nodes)}
		{foreach from=$l.nodes item=l1}

		{if $l1.id == $res.id}
			<div style="padding: 3px 0px 5px 5px" class="bg_color2 text11">
				<b>{$l1.name|truncate:30}</b>
			</div>
		{else}
			<div style="padding: 3px 0px 5px 5px">
				<a href="/{$CURRENT_ENV.section}/{$l1.path}/" class="text11">{$l1.name|truncate:30}</a>
			</div>
		{/if}
		
			{if sizeof($l1.nodes)}
				{foreach from=$l1.nodes item=l2}
				{if $l2.id == $res.id}
					<div style="padding: 3px 0px 5px 15px" class="bg_color2 text11">
						<b>{$l2.name|truncate:30}</b>
					</div>
				{else}
					<div style="padding: 3px 0px 5px 15px">
						<a href="/{$CURRENT_ENV.section}/{$l2.path}/" class="text11">{$l2.name|truncate:30}</a>
					</div>
				{/if}
				
				{if sizeof($l2.nodes)}
					{foreach from=$l2.nodes item=l3}
						<div style="padding: 0px 0px 5px 25px">
							<a href="/{$ENV.section}/{$l3.path}/" class="text11">{$l3.name|truncate:30}</a><br/>
						</div>
					{/foreach}
				{/if}
				
				{/foreach}
			{/if}
		{/foreach}
	{/if}

{/foreach}
{if !empty($res.all_services)}
	<br/><br/><br/><br/>		
	<div align="left" class="block_title" style="text-align: left; padding-left: 18px; padding-right:0px; position:relative; margin-bottom: 2px;">
		<span><a href="{$res.all_services}" class="text11">ВСЕ СЕРВИСЫ</a></span>
	</div>
{/if}
<div style="clear:both;"></div>
{/if}