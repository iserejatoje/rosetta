<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
	<td bgcolor="#92B3C7"><img src="/_img/x.gif" width="1" height="3"></td>
</tr>
<tr>
	<td bgcolor="#F1F6F9">
	<table border="0" cellspacing="0" cellpadding="0" class="block_main_news">
	<tr>
		<th>&nbsp;&nbsp;&nbsp;&nbsp;<span>{$res.title}</span>&nbsp;&nbsp;&nbsp;&nbsp;</th>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td valign="top"><img src="/_img/x.gif" width="1" height="5"></td>
</tr>
</table>
<table width="100%" class="block_main" cellspacing="3" cellpadding="0" >
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
	<tr align="right"><td><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr valign="bottom"><td>
{/if}
	<div><span class="bl_date">{$l.Date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}">{$l.Title}</a></span>
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
<br/>