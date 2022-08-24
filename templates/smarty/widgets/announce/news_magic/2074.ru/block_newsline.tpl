<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
			<td colspan="2" bgcolor="#D1E6F0" class="title">
				<em><IMG src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</em></td>
		</tr>
		<tr>
			<td valign="top">
			<table cellpadding="4" cellspacing="0" border="0">
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
<tr align="center"><td><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr><td>
{/if}
	  	{$l.Date|date_format:"%H:%M"}</span> <a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" {if $l.Order>0}style="color:red;"{/if}>{$l.Title}</a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/><img src="/_img/x.gif" width="1" height="4" /><br/>
	{/foreach}
{if $opened==true}
	</td></tr>
{/if}
			</table>
			</td>
		</tr>
</table> 