<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
<tr>
	<td width="30"><img src="/_img/design/200710_diplom/iconews.gif" width="37" height="35"></td>
	<td align="right" valign="top" background="/_img/design/200710_diplom/backnews.gif"><font style="font-family: verdana, arial, tahoma; font-size:10px; color:#003A60; font-weight:bold;">{$res.title}</font>&nbsp;&nbsp;</td>
</tr>
</table>
<table width="100%" class="block_main" cellspacing="4" cellpadding="1" >
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
	<tr><td><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr valign="bottom"><td>
{/if}
	<div><span class="bl_date">{$l.Date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" {if $l.Order>0}style="color:red;"{/if}>{$l.Title}</a></span>
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
<tr>
	<td align="right"><a href="{$l.Link}" title="все новости"><img  alt="все новости" src="/_img/design/200710_diplom/str.gif" width="11" height="11" border="0"></a></td>
</tr>
</table>