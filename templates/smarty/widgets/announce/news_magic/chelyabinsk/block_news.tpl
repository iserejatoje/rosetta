{if count($res.list)}
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l key=k}
	<table border=0 cellpadding=3 cellspacing=0 width=100%>
	  <tr><td align="left" class="dop2" bgcolor="#999999">{$res.title}</td></tr>
	</table>
	<table width=100% border=0 cellspacing=0 cellpadding=0>
		{if $k>0}
			<tr><td bgcolor="#666666"><img src='/_img/x.gif' width=1 height=1 border=0></td></tr>
		{/if}
		<tr><td><img src=/_img/x.gif width=1 height=3></td></tr>
		<tr><td align="left" class="zag2" style="padding-bottom:2px;">
		<a href="{$l.Link}{$l.NewsID}.html" class="zag2">
		{if $l.TitleType==2}
			{$l.TitleArr.name},{*<br/><font style="font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}*}
		{else}
			{$l.Title}
		{/if}
		</a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td></tr>
		<tr><td align="left" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{if $l.TitleType==2}
	                <font style="font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if} <a href="{$l.Link}{$l.NewsID}.html" class="ssyl">далее</a>
		{else}
			{foreach from=$l.Anon item=Anon key=k}
			{if $k<3 }{$Anon|truncate:110:"...":false} <a href="{$l.Link}{$l.NewsID}.html" class="ssyl">далее</a>{/if}
			{/foreach}
		{/if}
		</td><tr>
		{if !empty($l.Comment)}
				<tr><td align="left" style="padding-bottom:2px" class="small">
				<font color="#F78729"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> 
				{$l.Comment.Text|truncate:40:"...":false}
				{if strpos($l.Link,$CURRENT_ENV.site.domain)>0}<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">{else}<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html?p=last#comment`$l.Comment.CommentID`"|escape:"url"}" > {/if} <small>&gt;&gt;</small></a>
				</td></tr>
		{/if}
	{/foreach}
	</table>
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
	<table border=0 cellpadding=3 cellspacing=0 width=100%>
	  <tr><td align="left" class="dop2" bgcolor="#999999">{*if $l.id==28 && $ENV.section=="diary"}Пожелания сборной России{elseif $l.id==1498 && $ENV.section=="news"}Пожелания челябинским спортсменам{else*}{$ENV.site.title[$ENV.section]}{*/if*}</td></tr>
	</table>
	<table width=100% border=0 cellspacing=0 cellpadding=0>
		{if $k>0}
			<tr><td bgcolor="#666666"><img src='/_img/x.gif' width=1 height=1 border=0></td></tr>
		{/if}
		<tr><td><img src="/_img/x.gif" width="1" height="8" border="0" alt="" /></td></tr>
		<tr><td align="center" style="padding-bottom:2px" class="t_green">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</td></tr>
		<tr><td align="center" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.Title|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
		</td></tr>
		<tr valign="bottom"><td align="center" class="t_blue">
		<a href="{$l.Link}{$l.NewsID}.html">
		{if $l.TitleType==2}
			<b>{$l.TitleArr.name}</b>,<br /><font style="text-decoration:none;">{$l.TitleArr.position}</font>
		{else}
			<b>{$l.Title}</b>
		{/if}</a>
		</td></tr>
		<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt"" /></td></tr>
		{if !empty($l.Comment)}
				<tr><td align="left" style="padding-bottom:2px" class="small">
				<font color=#F78729><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> 
				{$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a>
				</td></tr>
			</div>
		{/if}
	</table>
	{/foreach}
{/if}
{/if}