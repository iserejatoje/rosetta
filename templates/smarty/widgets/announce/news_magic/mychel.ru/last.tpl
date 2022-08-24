{if !empty($res.list)}
<div class="section_title1"></div>
<div class="section_title2"></div>
<div class="section_title_last">{$res.title}</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
	<tr><td align="left" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		</td><tr>
		<tr><td align="left" style="padding-bottom:2px;">
			<a href="{$l.Link}{$l.NewsID}.html" class="wies_big">
			{if $l.TitleType==2}
				{$l.TitleArr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
			{else}
				{$l.Title}
			{/if}
			</a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td>
	<tr>
	<tr>
		<td align="left" style="padding-bottom:2px">
		{$l.Anon}
		</td>
	<tr>
	{if !empty($l.Comment) }
		<tr>
			<td align="left" style="padding-bottom:2px" class="dop10">
				<span class="dop10"><b>{if !empty($l.Comment.User.Name)}{*<a href="{$l.Comment.User.InfoUrl}">*}{$l.Comment.User.Name|truncate:20:"...":false}{*</a>*}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</td>
		</tr>
	{/if}
	{/foreach}
{else}
	<tr>
		<td>
{* это случай без текста, здесь все форматировано по центру *}
{foreach from=$res.list item=l key=k}
<div class="section_last_content">
	<div class="section_last_date">
			{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</div>
			{if $l.ThumbnailImg.file }
				<div class="section_last_img">
				<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
				</div>
			{/if}
<div class="section_last_title">
			<a href="{$l.Link}{$l.NewsID}.html">
			{if $l.TitleType==2}<b>{$l.TitleArr.name}</b>,<br />{$l.TitleArr.position}
			{else}<b>{$l.Title}</b>{/if}</a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
</div>			
			{if !empty($l.Comment) }
			<div class="section_last_comment">
			<b><span class="dop10">{if !empty($l.Comment.User.Name)}{*<a href="{$l.Comment.User.InfoUrl}">*}{$l.Comment.User.Name|truncate:20:"...":false}{*</a>*}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
				{$l.Comment.Created|date_format:"%e.%m"}:</span></b> {$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><img src="/_img/design/200805_afisha/bull2.gif" alt="читать далее" align="middle" border="0" height="14" width="12" style="vertical-align:top;" /></a>
			</div>
			{/if}
</div> 
{/foreach}
{/if}
		</td>
	</tr>
<tr>
	<td height="2" align="right"><img src="/_img/design/200805_afisha/search_korner.gif" width="16" height="16"></td>
</tr>
</table>
{/if}
