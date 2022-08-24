<div style="margin-top: 5px;">

	{foreach from=$res.users item=l}
    <div align="center" style="padding-bottom:5px;">
		{include file="`$res.templates.users_block`" user=$l}
    </div>
	{/foreach}

</div>
