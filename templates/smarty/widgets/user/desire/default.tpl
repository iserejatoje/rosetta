{if is_array($res.list) && count($res.list) > 0}
<div class="block_info">
	<div class="title title_lt">
		<div class="left">
			<div><a href="{$res.url}">Желания ({$res.count})</a></div>
		</div>
	</div>

	<div class="widget_content">
		<div class="content">

			<ul class="list">
			{foreach from=$res.list item=l}
				<li><a href="{$l.url}">{$l.Text}</a></li>
			{/foreach}
			</ul>			

		</div>
	</div>
</div>
{/if}