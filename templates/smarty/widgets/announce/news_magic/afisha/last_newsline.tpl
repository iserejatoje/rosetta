{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.Date)}
{if $opened==true}
{assign var="opened" value=false}
	</table>
	<div align="right"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
{/if}
	{assign var="date" value=$l.Date}
	{assign var="opened" value=true}


<br/>
<font class="zag5">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</font><br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#C1211D"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	</tr>
</table>
<table width=100% border=0 cellspacing=1 cellpadding=3>
	<tr>
		<td valign=top align=left bgcolor="#FFFFFF">
{/if}
	<div style="margin-top:5px;"><b>{$l.Date|date_format:"%H:%M"}</b> <a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}">{$l.Title}</a>	
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
{/foreach}
{if $opened==true}
</table>
	<div align="right"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
{/if}