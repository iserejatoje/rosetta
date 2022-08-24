<div class="current">
	<div class="title">Погода в городах</div>

	<div style="padding-left: 15px;">
		{assign var=iteration value=1}
		<div style="float:left; width: 22%;" class="columns">
		{foreach from=$res.cities item=list key=letter name=letters}
			<div>{$letter}<br/>
			
			{foreach from=$list item=city name=cities}
				<div><a href="/{$ENV.section}/{$city.TransName}/">{$city.Name}{if isset($res.parent[$city.Code])} ({$res.parent[$city.Code].FullName}){/if}</a><br/></div>
				
				{if $iteration % $res.row_count == 0}
			</div>
		</div>
		<div style="float:left; width: 22%;" class="columns">
			{if !$smarty.foreach.cities.last}<div>{$letter}<br/>{/if}
				{/if}
				{assign var=iteration value=$iteration+1}
			{/foreach}
			
			{if ($iteration-1) % $res.row_count != 0}
			</div>
			{/if}
		{/foreach}
		</div>
	</div>
</div>