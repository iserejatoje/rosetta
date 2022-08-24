{if is_array($res.myfriends) && sizeof($res.myfriends) && $res.myfriends_count > 0}
<div class="block_anon">
	<div class="title title_rt">
		<div class="left">
			<div><a href="{$res.infourl}">Друзья{if $res.myfriends_count} ({$res.myfriends_count}){/if}</a></div>
		</div>
	</div>

	<div class="widget_content">
		<div class="content_float">
			{foreach from=$res.myfriends item=l}
			<div class="float_left">
				{include file=$config.templates.users_block user=$l}
			</div>
			{/foreach}
			
			<div class="cleaner"></div>
			{if $res.myfriends_count > sizeof($res.myfriends)}
			<div class="actions_panel">
				<div class="actions_rs"><a href="{$res.infourl}">Все друзья{if $res.myfriends_count} ({$res.myfriends_count}){/if}</a></div>
			</div>
			<br clear="both"/>
			{/if}
		</div>
	</div>
</div>
{/if}