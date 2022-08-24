{if count($res.list)}
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
	</tr>
	<tr>
		<td  align="left" class="zag1" style="padding-left: 10px;">
			{$res.title}
		</td>
	</tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=3>
{if $BLOCK.list.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l key=y}
		<tr> 
			<td valign="top" align="left" style="padding-left: 10px; background-color: #87B30A;">
			<a href="{$l.Link}{$l.NewsID}.html" class="weis_big">
			{if $l.TitleType==2}
				<b>{$l.TitleArr.name}</b>, {$l.TitleArr.position}: {$l.TitleArr.text}
			{else}
				<b>{$l.Title}</b>
			{/if}
			</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br />
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;" vspace="5" /></a>
			{/if}
			{foreach from=$l.Anon item=Anon key=k}
			{if $k<3 }<img src="/_img/design/200805_afisha/bull2.gif" width="12" height="14" align="absmiddle" border="0" alt="-" />&nbsp;{$Anon}{/if}
			{/foreach}

			{if !empty($l.Comment)}
			<table width="100%" border="0px" cellspacing="0px" cellpadding="0px">
                      <tr>
                        <td width="3" bgcolor="#FFFFFF"><img src="/_img/x.gif" width="3" height="1" border="0"></td>
                        <td bgcolor="#A0C547" class="dop10" style="padding-left:10px;padding-top:5;padding-bottom:5;">
					<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}</b>, 
					{$l.Comment.Created|date_format:"%e.%m"}:
					&nbsp;{$l.Comment.Text|truncate:35:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200805_afisha/bull2.gif" width="12" height="14" border="0" align="middle" alt="читать далее" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			</td>
                      </tr>
            </table>
			{/if}
			</td>
		</tr>
		<tr><td style="padding: 1px; background-color: #87B30A;"><img src="/_img/x.gif" width="1" height="1" alt="" /></td></tr>
	{/foreach}
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=y}
		<tr> 
			<td valign="top" align="left" class="weis" style="padding-left: 10px; background-color: #87B30A;">
				{if $l.ThumbnailImg.file }
					<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}"  vspace="5" hspace="5" align="left" border="0" alt="{$l.name|strip_tags}" /></a>
				{/if}
				{if $l.TitleType==1 }
					{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
				
				{if $l.TitleType==2}
					<a href="{$l.Link}{$l.NewsID}.html" class="weis_big"><b>{$l.TitleArr.name}</b></a>,<br />{$l.TitleArr.position}: <b>{$l.TitleArr.text}</b>
				{else}
					<a href="{$l.Link}{$l.NewsID}.html" class="weis_big"><b>{$l.Title}</b></a>
				{/if}
				{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
			</td>
		</tr>
		<tr>
			<td style="background-color: #87B30A;">
				{if !empty($l.Comment)}
					<table width="100%" border="0px" cellspacing="0px" cellpadding="0px">
		                      <tr>
                		        <td width="3" bgcolor="#FFFFFF"><img src="/_img/x.gif" width="3" height="1" border="0"></td>
		                        <td bgcolor="#A0C547" class="dop10" style="padding-left:10px;padding-top:5;padding-bottom:5;">
						<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}</b>, 
						{$l.Date|date_format:"%e.%m"}:
						&nbsp;{$l.Comment.Text|truncate:35:"...":false}&nbsp;
						<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200805_afisha/bull2.gif" width="12" height="14" border="0" align="middle" alt="читать далее" /></a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
					</td>
		                      </tr>
			            </table>
				{/if}
			</td>
		</tr>
		<tr><td style="padding: 1px; background-color: #87B30A;"><img src="/_img/x.gif" width="1" height="1" alt="" /></td></tr>
	{/foreach}
{/if}
</table>
{/if}