{if isset($BLOCKS.header[0])}
{$BLOCKS.header[0]}
{else}
{include file="design/200608_title/common/header.tpl"}
{/if}
<tr valign="top">
	<td style="height:100%;">
	{foreach from=$BLOCKS.main item=block }
		{$block}
	{/foreach}
	</td>
</tr>
{if isset($BLOCKS.footer[0])}
{$BLOCKS.footer[0]}
{else}
{include file="design/200608_title/common/footer.tpl"}
{/if}


