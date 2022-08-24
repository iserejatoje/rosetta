{if $res.users_count > 0}
<div class="block_anon">
		<div class="title title_rt">
			<div class="left">
				<div><a href="{$res.url_all}">{$res.title} ({$res.users_count|number_format:0:'':' '})</a></div>
			</div>
		</div>

		<div class="widget_content">
			<div class="content_float">
				{foreach from=$res.users item=l}
					<div class="float_left">
					{include file="`$res.templates.users_block`" user=$l}
					</div>
				{/foreach}
				<div class="cleaner"/>
			</div>
			
			{if $res.users_count > sizeof($res.users)}
				<div class="actions_panel">
					<div class="actions_rs"><a href="{$res.url_all}">Все {$res.title|strtolower} ({$res.users_count})</a></div>
				</div>
				<div class="cleaner"/>
			{/if}
		</div>
</div>
{/if}