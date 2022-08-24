<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tbody><tr><td align="left" style="padding-left: 15px;" class="block_title_obl"><span>{$res.title}</span></td></tr>
</tbody></table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_left">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr>
			<td align="left" style="padding-bottom:2px;">
				<span class="bl_date_news">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span><br/>
				{if !$l.isNow}
					<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
				{elseif $l.isNow==1}
					<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
				{/if}
				<a href="{$l.Link}{$l.NameID}.html">
					{if $l.TitleType==2}
						<font style="font-size: 16px;"><b>{$l.TitleArr.name}</b></font>,
						<br/>
						<font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}
							{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
						</font>
					{else}
						<font style="font-size: 16px;"><b>{$l.Title}</b></font>
					{/if}
				</a>
		</td>
		<tr>
		<tr>
			<td align="left" style="padding-bottom:2px">
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NameID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			{$l.Anon}
			</td>
		<tr>
		{if !empty($l.Comment) }
		<tr>
			<td  align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="{$l.Link}{$l.NameID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</td>
		</tr>
		{/if}
	{/foreach}
{else}
{* это случай без текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		{if $SITE_SECTION!="bizvip"}
		<tr>
			<td>
				<span class="bl_date_news">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span><br/>
				{if !$l.isNow}
					<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
				{elseif $l.isNow==1}
					<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
				{/if}
				<a href="{$l.Link}{$l.NameID}.html" class="bl_title_news">
				{if $l.TitleType==2}
					<font style="font-size: 16px;"><b>{$l.TitleArr.name}</b></font>,<br />{$l.TitleArr.position}</font>
				{else}
					<font style="font-size: 16px;"><b>{$l.Title}</b></font>
				{/if}
				</a>
			</td>
		</tr>
		{/if}
		<tr>
			<td style="padding-bottom:2px"><div align="center" class="bl_body">
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NameID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.Title|strip_tags}" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{/if}
		</div>
		{if !empty($l.Comment)}
			<div class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="{$l.Link}{$l.NameID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</div>
		{/if}
		</td>
		</tr>
		<tr><td height="1" bgcolor="#cccccc" style="padding: 0px;"/></tr>
	{/foreach}
{/if}
</table>