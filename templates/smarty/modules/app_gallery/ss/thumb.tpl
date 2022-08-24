<div style="float:left; margin-right:20px; margin-bottom: 10px; width:110px;" align="center">
	<div class="{if $active}with_border_active{else}with_border3{/if}" id="thumb{$photo.id}" style="background: transparent url({if $hide}/_i/svoi/gallery/thumb/no_photo.gif{else}{$photo.thumb.url}{/if}) center no-repeat; width:{$CONFIG.thumb.img_size.max_width}px; height:{$CONFIG.thumb.img_size.max_height}px;"{if $hide} onmouseover="app_gallery.showPhoto(this,'{$photo.thumb.url}');"{/if}>
		<a href="{$photo.url}" title="{$photo.descr|truncate:120}">
			<img height="100" border="0" width="100" src="/_img/x.gif"/>
		</a>
	</div>
	{if !$notitle}
	<div style="margin-top:4px; height: 30px;">
		<a href="{$photo.url}">{$photo.title|truncate:20}</a>
	</div>
	{if isset($count)}
	<div class="tip" style="height: 12px;">
		{*<sup class="tip">{$count}</sup>*}
		Фотографий: <b>{$count}</b>
	</div>
	{/if}
	{/if}
</div>