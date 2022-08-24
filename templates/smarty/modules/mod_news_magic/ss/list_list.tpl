{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}{
	foreach from=$res.pageslink.btn item=l}
		{if !$l.active
			}&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>{
		else
			}&nbsp;<span class="pageslink_active"> {$l.text} </span>{
		/if}
	{/foreach
	}{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<h1 class="title">{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}</h1>
{if $smarty.capture.pageslink!="" }
<div style="text-align:right">{$smarty.capture.pageslink}</div>
<br clear="both"/>
{/if}

{if sizeof($res.list)}
<div class="articles">
	{foreach from=$res.list item=l name=atr}
	<div class="article-item">
		
		<div class="datestamp">
			<div>
				<span class="cal1 cal1x">{$l.Date|date_format:"%d"}</span>
				<span class="cal2">{$l.Date|date_format:"%m"}</span>
				<span class="cal3">{$l.Date|date_format:"%Y"}</span>
			</div>
		</div>
			
		<div class="article-title">
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html">{$l.Title}</a>
		</div>
		
		
		<br/>
		<div class="article-text">
			{if $l.ThumbnailImg.file}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title}" align="left" style="padding-right: 10px;padding-bottom: 10px;" /></a>
			{/if}
			{$l.Anon}			
		</div>
		<br/>
	</div>
	<br clear="both"/>
	{/foreach}
</div>
{/if}