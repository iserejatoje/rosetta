{if isset($BLOCKS.header[0])}
	{$BLOCKS.header[0]}
{else}
	{include file="design/200608_title/common/header_simple.tpl"}
{/if}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
	<td height="100%">
{foreach from=$BLOCKS.main item=block }
	{$block}
{/foreach}
	</td>
</tr>
</table>

{if isset($BLOCKS.footer[0])}
	{$BLOCKS.footer[0]}
{else}
	{include file="design/200608_title/common/footer_simple.tpl"}
{/if}
