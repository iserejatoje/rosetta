<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="right"><span>{$res.title}</span></td>
	</tr>
	<tr>
		<td height="1px" bgcolor="#333333"><img src="/_img/x.gif" width="1" height="1"></td>
	</tr>
</table>
<table width="100%" class="block_left" cellspacing="0" cellpadding="0" >
	{assign var="date" value=0}
	{assign var="opened" value=false}
	{foreach from=$res.list item=l key=y}
	{if date("Ymd",$date) != date("Ymd",$l.Date)}
	{assign var="date" value=$l.Date}
	{if $opened==true}
	{assign var="opened" value=false}
		</td></tr>
	{/if}
		{assign var="opened" value=true}
		<tr align="right"><th><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></th></tr>
		<tr valign="bottom"><td>
	{/if}
		<div><span class="bl_date">{$l.Date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}">{$l.Title}</a></span></div>		
	{/foreach}
	{if $opened==true}
		</td></tr>
	{/if}
</table>