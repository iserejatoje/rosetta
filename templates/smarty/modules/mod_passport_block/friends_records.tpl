{if $res.myfriends_count > 0}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span><a href="{$res.friends_url}">Друзья - {$res.myfriends_count|number_format:0:'':' '}</a></span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>

<div style="padding-left:6px;">
{foreach from=$res.myfriends item=l}
	<div style="float: left;">
	{include file="`$CONFIG.templates.user_small_block`" user=$l}
	</div>
{/foreach}
</div>
<div style="clear: both;margin-bottom:30px;"></div>
{/if}