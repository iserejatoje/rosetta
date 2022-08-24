<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
	<tr><th><span>{if in_array($CURRENT_ENV.regid,array(72))}50{else}100{/if}</span></th></tr>
</table>

<table class="menu-klass" width="100%" bgcolor="#ffffff" border="0" cellpadding="3" cellspacing="1">
{foreach from=$res.list item=l}
		<tr {if $l.top10 && !$l.selected}bgcolor="#fff6e6"{elseif $l.selected}class="block_title2"{/if}> 
			<td valign="top" width="100%" style="padding-left: 16px;" class="descr">
		        <li>{if $l.selected}
				<b>{$l.name}</b>
			{else}
				<a href="/{$SITE_SECTION}/{$l.id}.html">{$l.name}</a>
			{/if}</li>
      			</td>
		</tr>
{/foreach}
		<tr>
			<td style="padding-left: 16px;"><a href="/{$SITE_SECTION}/comment.html"><b>Обсуждение</b></a></td>
		</tr>
</table>