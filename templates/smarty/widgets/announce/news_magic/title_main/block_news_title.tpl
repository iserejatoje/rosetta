{foreach from=$res.list item=l}
<!--regid={$CURRENT_ENV.regid}-->
	<div class="title">
		<span><a href="/service/go/?url={"`$l.Link`"|escape:"url"}" target="_blank">{$res.title}</a></span>
		{if $withdate}&nbsp;<span class="graytext">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span>{/if}
	</div>

	<div class="content">
		{if !empty($l.ThumbnailImg.file)}
			<div class="thumb" {if $l.ThumbnailImg.file}style="background-image: url({$l.ThumbnailImg.file});"{/if}>
				<div{if $l.AddMaterial==2} class="type-video"{/if}>
					<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank"><img src="/_img/x.gif" width="90" height="90" alt="{$title}" /></a>
				</div>
			</div>
		{/if}
		<div class="text">
			<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank">
			{if $l.TitleType == 2}
				<span class="bigtitle">{$l.TitleArr.name}</span>,<br />
				<span class="position">{$l.TitleArr.position}{if $l.TitleArr.text}:</span> <span class="quotation">{$l.TitleArr.text}</span>{else}</span>{/if}{else}<span class="smalltitle">{$l.Title}</span>
			{/if}
			</a>
			{if $l.AddMaterial == 1}&nbsp;<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" align="absmiddle" />{*{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" align="absmiddle" />*}{/if}<br />
			{if $l.TitleType != 2}<a class="view" href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank">{$l.Anon|truncate:230:"...":false}</a>{/if}
			{if $l.AddMaterial == 2}
				<br /><img src="/_img/design/200608_title/common/video_tgreen.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" align="absmiddle" />
				{if $l.ForAddMaterial}{if $CURRENT_ENV.site.domain != $ENV.site.domain}<a class="video" href="/service/go/?url={"`$l.Link``$l.NewsID`.html#video"|escape:"url"}" target="_blank">{else}
				<a class="video" href="{$l.Link}{$l.NewsID}.html#video" target="_blank">{/if}{$l.ForAddMaterial}</a>{/if}
			{/if}
		</div>
	</div>
	<div class="under">
		{if !empty($l.Comment)}
			<span class="author">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</span>
			<span class="comment">{$l.Comment.Text|truncate:30:"...":false}</span><a href="/service/go/?url={"`$l.Link``$l.NewsID`.html?p=last#comment`$l.Comment.CommentID`"|escape:"url"}" target="_blank" title="Читать далее">далее</a>
		{/if}
	</div>
{/foreach}