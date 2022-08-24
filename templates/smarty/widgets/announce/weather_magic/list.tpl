<table width="100%" cellspacing="0" cellpadding="0" border="0" class="content">    
  {foreach from=$res.list item=l}
  <tr>
	<td class="tableft"><a href="/{$res.url}/{$l.TransName}/">{$l.Name}</a></td>
	<td class="tabright">{if $l.T > 0}+{/if}{$l.T}</td>
  </tr>
  {/foreach}
{if $res.type==2}
<tr>
	<td colspan="2" align="right"><br/><noindex><a href="/{$res.url}/cities/" rel="nofollow" class="footer_links">Все города</a></noindex></td>
</tr>
{/if}
</table>