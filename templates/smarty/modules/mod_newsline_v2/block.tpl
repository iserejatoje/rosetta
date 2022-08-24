<table border=0 cellpadding=3 cellspacing=0 width=100%>
  <tr><td align="left" class="dop2" bgcolor="#999999">{$ENV.site.title[$ENV.section]}</td></tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=0>
{assign var="date" value=0}
{foreach from=$res.list item=l key=y}
{assign var="changed" value="false"}
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
{assign var="changed" value="true"}
	<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
	<tr><td align="left"><b>{$l.date|date_format:"%d"} {$l.date|month_to_string:2}</b></td></tr>
	<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
{/if}
	<tr valign="bottom"><td align="left">
	<b>{$l.date|date_format:"%H:%M"}</b> <a href="/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}">{$l.name}</a>
	</td></tr>
	<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt"" /></td></tr>
{if $changed=="true"}
	<tr><td bgcolor="#FFFFFF"><img src='/_img/x.gif' width=1 height=4 border=0></td></tr>
{/if}
{/foreach}
</table>