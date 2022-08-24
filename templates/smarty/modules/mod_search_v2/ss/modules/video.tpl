{if $doc.data.Thumb.url}
	<div class="video-item">
		<div class="thumb" style="background: url({$doc.data.Thumb.url}) no-repeat left top;">
			<div style="position:absolute;">
				<a href="{$doc.data.url}" target="_blank"><img border="0" src="/_img/x.gif" width="120" height="80"/></a>
			</div>
			<div class="button"><a href="{$doc.data.url}" target="_blank"><img src="/_img/x.gif" width="24" height="16"/></a></div>
			<div class="duration"><a href="{$doc.data.url}" target="_blank">{$doc.data.Duration}</a></div>
		</div>
		<div class="descr">
			<span class="views">Просмотров: {$doc.data.Views}</span>
		</div>
	</div>
{/if}

<a class="result_ref" target="_blank" href="{$doc.url}"><span style="line-height: 17px;">{$doc.title}</span></a><br/>

<span style="line-height:17px;">{$doc.data.text}</span><br/>

<small>
	<font color="#888888">{$doc.small_url}</font>
	{if $doc.pubDate}- {$doc.pubDate|date_format:"%d.%m.%Y"}{/if}
</small>
