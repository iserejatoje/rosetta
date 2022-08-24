<div class="title">
	<span><a href="/service/go/?url={if $res.sections[0].Link}{$res.sections[0].Link|escape:"url"}{else}{$res.section.Link|escape:"url"}{/if}" target="_blank">{$res.title}</a></span>
	{if $withdate}&nbsp;<span class="graytext">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span>{/if}
</div>

<div class="content">
	{foreach from=$res.list item=l key=y}
	<div class="line">
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" align="absmiddle" alt="" />
		{capture name="date"}{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}{/capture}
		<a target="_blank" href="/service/go/?url={$smarty.capture.date|escape:"url"}"{if $l.Order>0} class="redtext"{/if}>{$l.Title}</a>
		{if $l.AddMaterial==1}
			&nbsp;<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" align="absmiddle" />
		{elseif $l.AddMaterial==2}
			&nbsp;<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" align="absmiddle" />
		{/if}
	</div>
	{/foreach}
</div>