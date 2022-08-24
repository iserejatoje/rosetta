<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>


<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>{$page.type}</span></td></tr>
<tr>
	<td>
{if count($page.err)>0}
{foreach from=$page.err item=l}
	{$l}<br />
{/foreach}
{/if}
{if count($page.actions)>0}
<br />
{foreach from=$page.actions item=url key=action}
	<a href="{$url}" class="a12b">{$action}</a>&nbsp;&nbsp;
{/foreach}
{/if}
	</td>
</tr>
</table>
