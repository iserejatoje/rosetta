<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
	</tr>
	<tr>
		<td align="left">
			<font class="footer_links_reklama">{$res.title}</font>
		</td>
	</tr>
</table>
<table width="100%" class="block_right" cellspacing="0" cellpadding="0" >
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
	<tr align="left"><td><span class="weis_big">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr valign="bottom"><td align="left">
{/if}
	<div style="margin-top:5px;" class="weis">{$l.Date|date_format:"%H:%M"} <a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" {if $l.isMarked>0}style="color:red;"{/if}>{$l.Title}</a>
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
	<tr>
		<td><img src="/_img/x.gif" height="6" width="1" alt="" /></td>
	</tr>
</table>