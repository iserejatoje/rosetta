{if $res.title!=""}
<table border=0 cellpadding=3 cellspacing=0 width=100%>
  <tr><td class="block_title"><span>{$res.title}</span></td></tr>
</table>
{/if}
<table width=100% cellpadding=3 cellspacing=0 border=0>
{foreach from=$res.list item=l}
<tr><td align="left" style="padding-left: 5px;">
	<a href="/{$SITE_SECTION}/{$l.modname}/" class="text11"><b>{$l.name}</b></a>
</td></tr>
{/foreach}			
<tr><td align="right" style="padding-left: 5px;">
	<a href="/{$SITE_SECTION}/" class="text11">показать все</a>
</td></tr>
</table>
