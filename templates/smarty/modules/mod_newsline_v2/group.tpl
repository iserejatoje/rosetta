{if $res.title!=""}
<table border=0 cellpadding=0 cellspacing=0 width=100%>
  <tr><td align=right>{$res.title}</td></tr>
  <tr><td height="1px" bgcolor="#333333"><img src="/_img/x.gif" width="1" height="1"></td></tr>
</table>
{/if}
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td align="left">
{foreach from=$res.list item=l}
	<a href="/{$ENV.section}/{$l.modname}/">{$l.name}</a>
	<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
{/foreach}			
	<a href="/{$ENV.section}/">показать все</a>
</td></tr>
</table>
