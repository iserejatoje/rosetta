{capture name=pageslink}
	{include file="`$TEMPLATE.pages_link`" pages=$page.pageslink}
{/capture}

<div class="gallery-popup">

	<table class="path">
		<tr>
			<td>
				{$TITLE->Path[1].name}
			</td>
		</tr>
	</table>

	<div class="t-line">
		<div class="content">
			<div style="float:left;">
				Выберите альбом
			</div>
			<div style="float:right;">
				{$smarty.capture.pageslink}
			</div>
		</div>
	</div>

	<div class="list">
		<div>
			{foreach from=$page.albums item=l}
				<div class="gallery_thumb">
					<div class="thumb{if $active} active{/if}" id="thumb{$l.id}" style="background: transparent url({if $hide}/_i/svoi/gallery/thumb/no_photo.gif{else}{$l.thumb.url}{/if}) left no-repeat; width:{$CONFIG.thumb.img_size.max_width}px; height:{$CONFIG.thumb.img_size.max_height}px;"{if $hide} onmouseover="app_gallery.showPhoto(this,'{$l.thumb.url}');"{/if}>
						<a href="{$l.url}" title="{if $l.descr}{$l.descr|truncate:120|escape:'quotes'}{else}{$l.title|truncate:120|escape:'quotes'}{/if}">
							<img height="100" border="0" width="100" src="/_img/x.gif"/>
						</a>
					</div>
					<div class="title">
						<a href="{$l.url}" title="{$l.title}">{$l.title|truncate:15:'...':true|escape:"html"}</a>
					</div>
					{if isset($l.count)}
					<div style="height: 12px;" class="comment">
						Фотографий: <b>{$l.count}</b>
					</div>
					{/if}
				</div>
			{/foreach}
			<br clear="both"/>
		</div>
	</div>
	
	<div class="b-line-padding"> </div>
	
	<div class="b-line">
		<div class="content">
			{if $USER->ID == $page.gallery.uniqueid}
				<a href="/user/{$USER->ID}/gallery/popup/gallery/{$page.gallery.id}/addalbum.php"><img src="/_img/design/200608_title/app_gallery2/buttons/add_album_btn.gif" width="135" height="25" align="left"/></a>
			{/if}
			<div style="padding-top: 7px;float:right;">
				{$smarty.capture.pageslink}
			</div><br clear="both"/>
		</div>
	</div>
	
</div>