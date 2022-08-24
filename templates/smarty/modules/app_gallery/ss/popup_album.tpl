{capture name=pageslink}
	{include file="`$TEMPLATE.pages_link`" pages=$page.pageslink}
{/capture}

<script>

{literal}

$(function() {

	var _document = window.opener.document;
	var _container = window.opener.getUserGalleryContainer();

	$('.gallery_thumb div a').each(function() {
		$(this).bind('click', function() {
			var photo = $(this).parents("div:eq(1)").attr('id').replace(/thumb(\d+)/,'$1');
			var input = window.opener.$(_container, _document);

			//window.opener.document.body.focus();
			//_container.click();
			if (input.getSelection().length > 0)
				input.replaceSelection('[UGALLERY='+photo+']');
			else
				input.insertAtCaretPos('[UGALLERY='+photo+']');
		});
	});	
});

{/literal}
</script>

<div class="gallery-popup">

	<table class="path">
		<tr>
			<td>
				<a href="{$TITLE->Path[1].link}" class="top">{$TITLE->Path[1].name}</a><br/>
				{$TITLE->Path[2].name}
			</td>
		</tr>
	</table>

	<div class="t-line">
		<div class="content">
			<div style="float:left;">
				Выберите фотографию в альбоме
			</div>
			{capture name=pageslink}
				{include file="`$TEMPLATE.pages_link`" pages=$page.pageslink}
			{/capture}

			<div style="float:right;">
				{$smarty.capture.pageslink}
			</div>
		</div>
	</div>

	{if !sizeof($page.photos)}
	<div class="info">Нет фотографий для просмотра.</div>
	{else}
	<div class="list">
		<div>
			{foreach from=$page.photos item=l}
				<div class="gallery_thumb" id="thumb{$l.id}" style="height:125px">
					<div class="thumb" style="background: transparent url({if $hide}/_i/svoi/gallery/thumb/no_photo.gif{else}{$l.thumb.url}{/if}) left no-repeat; width:{$CONFIG.thumb.img_size.max_width}px; height:{$CONFIG.thumb.img_size.max_height}px;"{if $hide} onmouseover="app_gallery.showPhoto(this,'{$l.thumb.url}');"{/if}>
						<a href="javascript:;" title="{$l.title|truncate:120|escape:'quotes'}">
							<img height="100" border="0" width="100" src="/_img/x.gif"/>
						</a>
					</div>
					<div class="select">
						{* <a href="javascript:;" title="{$l.title}">{$l.title|truncate:15:'...':true|escape:"html"}</a> *}
						<a href="javascript:;" title="Выбрать" class="select">Выбрать</a>
					</div>
				</div>
			{/foreach}
			<br clear="both"/>
		</div>
	</div>
	{/if}

	<div class="b-line-padding"> </div>
	
	<div class="b-line">
		<div class="content">
			{if $USER->ID == $page.album.userid}
				<a href="/user/{$USER->ID}/gallery/popup/album/{$page.album.id}/addphoto.php"><img src="/_img/design/200608_title/app_gallery2/buttons/add_photo_btn.gif" width="169" height="25" align="left"/></a>
			{/if}
			<div style="padding-top: 7px;float:right;">
				{$smarty.capture.pageslink}
			</div><br clear="both"/>
		</div>
	</div>

</div>