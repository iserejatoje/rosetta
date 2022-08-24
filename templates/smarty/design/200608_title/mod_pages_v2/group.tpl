{if $res.title!=""}
<table border=0 cellpadding=0 cellspacing=0 width=100%>
  <tr><td align="left" class="zag4">{$res.title}</td></tr>
  <tr><td height="3px" bgcolor="#CCCCCC"><img src="/_img/x.gif" width="1" height="3"></td></tr>
</table>
{/if}
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td align="left">
{foreach from=$res.list item=l}
	<a href="/{$SITE_SECTION}/{$l.modname}/">{$l.name}</a>
	<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
{/foreach}			
	<a href="/{$SITE_SECTION}/">показать все</a>
</td></tr>
</table>
