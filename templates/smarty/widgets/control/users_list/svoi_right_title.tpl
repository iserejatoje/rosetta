<div class="block_title" style="text-align: left; padding-left: 6px; padding-right: 0px; position: relative;"><span>Модераторы</span></div>
<div style="margin-top: 5px;">

	{foreach from=$res.users item=l}
    <div align="center"  style="padding-bottom:5px;">
		{include file="`$res.templates.users_block`" user=$l}
    </div>
	{/foreach}

</div>
{if $res.show_url_all}
<div class="tip" style="padding-bottom:4px;"><br />
	<a href="/svoi/community/{$res.obj_id}/users/moderators/">Все модераторы</a>
</div>
{/if}
