{if is_array($res.list) && sizeof($res.list)}
<div class="block_info">
	<div class="title title_lt">
		<div class="left">
			<div>
				<div class="actions"><span class="edit"><a href="/passport/guests.php">Все гости</a></span></div>
				<div>Гости{if $res.list.count} ({$res.list.count}){/if}</div>				
			</div>
		</div>
	</div>

	
	<div class="widget_content">
		<div class="content_float">	
			{foreach from=$res.list.users item=l}
			<div class="float_left">
				{include file=$config.templates.users_block user=$l}
			</div>			
			{/foreach}			
		</div>
		<div style="clear:both"></div>
	</div>
</div>
{/if}