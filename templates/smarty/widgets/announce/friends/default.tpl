<div class="tip" style="padding-top:2px;padding-left:6px;">
	<a href="{$res.url_all}"><font color="#999999">все друзья{if $res.myfriends_count>0}: {$res.myfriends_count}{/if}</font></a>
</div>
<div style="margin-top: 5px;">

	{foreach from=$res.myfriends item=l}
    <div align="center" style="padding-bottom:10px;">
		{include file=$config.templates.users_block user=$l}
    </div>
	{/foreach}

</div>