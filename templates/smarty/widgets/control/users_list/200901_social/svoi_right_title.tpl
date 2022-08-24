<div class="content_float">
	{foreach from=$res.users item=l}
	<div class="float_left">
		{include file="`$res.templates.users_block`" user=$l}
	</div>
	{/foreach}
	<div class="cleaner"/>
	
	{if $res.show_url_all}
		<br /><a href="/svoi/community/{$res.obj_id}/users/moderators/">Все модераторы</a>
	{/if}
</div>