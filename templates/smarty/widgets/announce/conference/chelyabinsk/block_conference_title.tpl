<table border=0 cellpadding=3 cellspacing=0 width=100%>
	<tr><td align="left" class="dop2" bgcolor="#999999">{$res.title}</td></tr>
</table>

<table width=100% border=0 cellspacing=0 cellpadding=0>
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l key=k}
		<tr>
			<td colspan="2"><img src="/_img/x.gif" width="1" height="3"></td>
		</tr>
		<tr>
			<td align="center" style="padding-right: 5px; padding-bottom: 5px;">
				{if !empty($l.ThumbnailImg.file)}<a href="{$l.Link}{$l.NameID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="left" border="0"></a>{/if}
			</td>
			<td align="left" class="t_blue" style="padding-bottom:2px;">
				{if !$l.isNow}
					<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
				{elseif $l.isNow==1}
					<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
				{/if}
				<a href="{$l.Link}{$l.NameID}.html">
				{if $l.TitleType==2}
					{$l.Anon|truncate:400:"...":true} 
					{$l.TitleArr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
				{else}
					{$l.Title}
				{/if}</a>
			</td>
		<tr>
		{if !empty($l.Comment)}
			<tr>
				<td align="left" style="padding-bottom:2px" class="small" colspan="2">
				<font color=#F78729><b>{if !empty($l.Comment.user.Name)}{$l.Comment.user.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> {$l.Comment.Text|truncate:30:"...":false}
				<a class="ssyl" href="{$l.Link}{$l.NameID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее">далее</a>
				</td>
			</tr>
		{/if}
	{/foreach}
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		<tr>
			<td colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
		</tr>
		<tr>
			<td align="center" style="padding-right: 5px; padding-bottom: 5px;">
				{if !empty($l.ThumbnailImg.file)}<a href="{$l.Link}{$l.NameID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="left" border="0"></a>{/if}
			</td>
			<td align="left" class="t_blue" valign="top">
				{if !$l.isNow}
					<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
				{elseif $l.isNow==1}
					<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
				{/if}
				<a href="{$l.Link}{$l.NameID}.html">
				{if $l.TitleType==2}
					<b>{$l.TitleArr.name}</b>,<br /><font style="text-decoration:none;">{$l.TitleArr.position}</font>
				{else}
					<b>{$l.Title}</b>
				{/if}</a>
			</td>
		</tr>

		{if !empty($l.Comment)}
			<tr>
				<td colspan="2">
					<img src="/_img/x.gif" width="1" height="5" border="0" alt=""/>
				</td>
			</tr>
			<tr>
				<td align="left" style="padding-bottom:2px" class="small" colspan="2">
				<font color=#F78729><b>{if !empty($l.Comment.user.Name)}{$l.Comment.user.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> {$l.Comment.Text|truncate:30:"...":false}
				<a class="ssyl" href="{$l.Link}{$l.NameID}?p=last#comment{$l.Comment.CommentID}" title="Читать далее">далее</a>
				</td>
			</tr>
		{/if}
	{/foreach}
{/if}
</table>
