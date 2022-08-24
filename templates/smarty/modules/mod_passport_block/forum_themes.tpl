{if count($res.themes)>0}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Пишет в форуме</span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>
<div style="margin-bottom:30px;">
{foreach from=$res.themes item=l}
	{include file="`$CONFIG.templates.forum_themes_element`" l=$l}
{/foreach}

{/if}
</div>
