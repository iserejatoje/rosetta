{if isset($BLOCKS.header[0])}
	{$BLOCKS.header[0]}
{else}
	{include file="modules/mod_passport/common/header_simple.tpl"}
{/if}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
	<td>
{$BLOCKS.main[0]}
	</td>
</tr>
</table>

{if isset($BLOCKS.footer[0])}
	{$BLOCKS.footer[0]}
{else}
	{include file="modules/mod_passport/common/footer_simple.tpl"}
{/if}
