{if $res.users_count > 0}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span><a href="{$res.url_all}">{$res.title} - {$res.users_count|number_format:0:'':' '}</a></span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>
<div style="margin-left:0px;">
{foreach from=$res.users item=l}
	<div style="float: left;">
	{include file="`$res.templates.users_block`" user=$l}
	</div>
{/foreach}
</div>
<div style="clear: both; height:10px;"></div>

{/if}