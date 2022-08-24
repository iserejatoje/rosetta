{if !empty($res.list)}
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td background="/_img/design/200710_fin/zag1back.gif" valign="top" width="13">
		<img src="/_img/design/200710_fin/zag1.gif" height="13" width="13">
	</td>
	<td bgcolor="#b3c9d7">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th class="block_left" align="left"><span>{$res.title}</span></th>
			<td align="right" valign="bottom" width="10"><img src="/_img/design/200710_fin/zag1ugol.gif" height="23" width="10"></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td width="13"><img src="/_img/x.gif" height="5" width="1"></td>
	<td><img src="/_img/x.gif" height="5" width="1"></td>
</tr>
</table>
{/if}
<table width="100%" class="block_left" cellspacing="0" cellpadding="0" >
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.Date)}
{if $opened==true}
{assign var="opened" value=false}
	<div align="right"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
	</td></tr>
{/if}
	{assign var="date" value=$l.Date}
	{assign var="opened" value=true}
	<tr align="center"><th><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></th></tr>
	<tr valign="bottom"><td>
{/if}
	{*<div><span class="bl_date">{$l.Date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" {if $l.Order>0}style="color:red;"{/if}>{$l.Title}</a></span>*}
	<div><span class="bl_date">{$l.Date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="{$l.Link}{$l.NewsID}.html" {if $l.Order>0}style="color:red;"{/if}>{$l.Title}</a></span>
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
{/foreach}
{if $opened==true}
	<div align="right"><a href="{if !empty($res.section)}{$res.section.Link}{else}{$res.sections[0].Link}{/if}{'Y/m/d'|date:$date}/" class="descr">Все новости дня</a></div>
	</td></tr>
{/if}
</table>
