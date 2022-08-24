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
<table width="100%" class="block_right" cellspacing="3" cellpadding="0">
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
	<tr><td class="weis" align="left"><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr><td align="left">
		<a href="{$l.Link}{$l.NewsID}.html" class="weis_big"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span><br/><span class="anon_position">{$l.TitleArr.position}: {$l.TitleArr.text}{else}{$l.Title}{/if}</span></a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
	</td></tr>
	<tr><td align="left">
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" style="margin-right:3px;" /></a>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td align="left">
			{if !empty($l.Comment)}
			<table width="100%" border="0px" cellspacing="0px" cellpadding="0px">
                      <tr>
                        <td width="3" bgcolor="#FFFFFF"><img src="/_img/x.gif" width="3" height="1" border="0"></td>
                        <td bgcolor="#A0C547" class="dop10" style="padding-left:10px;padding-top:5;padding-bottom:5;">
					<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}</b>, 
					{$l.Comment.Created|date_format:"%e.%m"}:
					&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200805_afisha/bull2.gif" width="12" height="14" border="0" align="middle" alt="читать далее" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			</td>
                      </tr>
	            </table>
			{/if}
		</td>
	</tr>
	<tr valign="bottom"><td>
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>