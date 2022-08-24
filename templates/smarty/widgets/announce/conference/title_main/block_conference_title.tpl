{foreach from=$res.list item=l}
<!--regid={$CURRENT_ENV.regid}-->
	<div class="title">
		<span><a href="/service/go/?url={"`$l.Link`"|escape:"url"}" target="_blank">{$res.title}</a>{if $res.withdate}&nbsp;<span class="graytext">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span>{/if}</span>
		{if $l.isNow==1}<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" align="absmiddle" />{/if}
	</div>
	
	<div class="content">
		{if !empty($l.ThumbnailImg.file)}
			<div class="thumb" style="background-image: url({$l.ThumbnailImg.file});">
				<div{if $l.AddMaterial==2} class="type-video"{/if}>
					<a href="/service/go/?url={"`$l.Link``$l.NameID`.html"|escape:"url"}" target="_blank"><img src="/_img/x.gif" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" alt="" /></a>
				</div>
			</div>
		{/if}
		<div class="text">
			{if !$l.isNow}
				<span class="boldtext redtext">{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</span><br />
			{/if}
			<a href="/service/go/?url={"`$l.Link``$l.NameID`.html"|escape:"url"}" target="_blank">
			{if $l.TitleType==2}
				<span class="bigtitle">{$l.TitleArr.name}</span>,<br /><span class="position">{$l.TitleArr.position}</span>{if $l.TitleArr.text}: <span class="quotation">{$l.TitleArr.text}</span>{/if}
			{else}<span class="bigtitle">{$l.Title}</span>{/if}
			</a>
			{if $l.AddMaterial==1}
				<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" align="absmiddle" />
			{elseif $l.AddMaterial==2}
				<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" align="absmiddle" />
			{/if}<br />
			{if $l.isNow < 2}
				<a class="view" href="/service/go/?url={"`$l.Link``$l.NameID`.html"|escape:"url"}" target="_blank">{$l.Anon|truncate:400:"...":true}</a>
					<br /><span class="questions"><a href="/service/go/?url={"`$l.Link``$l.NameID`.html#question"|escape:"url"}" target="_blank">задать вопрос</a></span>
			{else}			
				<br /><span class="questions"><a href="/service/go/?url={"`$l.Link``$l.NameID`.html#questions"|escape:"url"}" target="_blank">читать ответы</a></span>
			{/if}
		</div>
	</div>
	<div class="under">
		{if !empty($l.Comment)}
			<span class="author">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</span>
			<span class="comment">{$l.Comment.Text|truncate:30:"...":false}</span><a href="/service/go/?url={"`$l.Link``$l.NameID`.html?p=last#comment`$l.Comment.CommentID`"|escape:"url"}" target="_blank" title="Читать далее">далее</a>
		{/if}
	</div>
{/foreach}