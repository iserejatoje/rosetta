<table cellpadding="0" cellspacing="0" width="100%">
<tr bgcolor="#FFFFFF" >
	<td height="2"><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
<tr bgcolor="#CCCCCC" >
	<td height="4"><img src="/_img/x.gif" width="1" height="4"></td>
</tr>
<tr>
	<td style="background: #87B30A url('/_img/design/200805_afisha/green_search_bg.gif') repeat-x; padding-left: 10px" class="zag1" align="left">
		<br/>{$GLOBAL.title[$SITE_SECTION]}
	</td>
</tr>
<tr>
	<td height="5"><img src="/_img/x.gif" width="1" height="5"></td>
</tr>
</table>
<table width=100% border=0 cellspacing=1 cellpadding=3>
	{assign var="date" value=0}
	{assign var="opened" value=false}
	{foreach from=$res.list item=l key=y}
	{if date("Ymd",$date) != date("Ymd",$l.Date)}
	{if $opened==true}
	{assign var="opened" value=false}
		<div align="right" style="padding: 10px 0px 10px 0px;"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
		</td></tr>
	{/if}
		{assign var="date" value=$l.Date}
		{assign var="opened" value=true}
		<tr align="left"><th><font class="weis_big">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</th></tr>
		<tr valign="bottom"><td valign=top align=left>
	{/if}
		{*<div style="margin-top:5px;" class="weis">{$l.Date|date_format:"%H:%M"} <a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" {if $l.isMarked>0}style="color:red;"{/if}>{$l.Title}</a>*}
		<div style="margin-top:5px;" class="weis">{$l.Date|date_format:"%H:%M"} <a href="{$l.Link}{$l.NewsID}.html" {if $l.isMarked>0}style="color:red;"{/if}>{$l.Title}</a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
	{/foreach}
	{if $opened==true}
		<div align="right" style="padding: 10px 0px 10px 0px;"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
		</td></tr>
	{/if}
</table>