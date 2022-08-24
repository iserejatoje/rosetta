{*<table border=0 cellpadding=0 cellspacing=0 width=100%>
  <tr><td align=right class=txt>{$GLOBAL.title[$SITE_SECTION]}</td></tr>
  <tr><td height="1px" bgcolor="#333333"><img src="/_img/x.gif" width="1" height="1"></td></tr>
</table> *}
<table width=100% border=0 cellspacing=0 cellpadding=3>
{assign var="date" value=0}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
	<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
	<tr><td align="center" class="dop2" bgcolor="#999999">{$l.date|date_format:"%d"} {$l.date|month_to_string:2}</td></tr>
{/if}
	<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
	<tr valign="bottom"><td align="left">
	{$l.date|date_format:"%H:%M"} <a href="/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}"><b>{$l.name}</b></a>
	</td></tr>
{/foreach}
</table>