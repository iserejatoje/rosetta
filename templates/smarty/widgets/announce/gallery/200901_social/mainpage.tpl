{if is_array($res.data) && sizeof($res.data)}
<div class="block_anon">
	<div class="title title_rt">
		<div class="left">
			<div><a href="{$res.url}">Фотогалерея{if $res.count} ({$res.count}){/if}</a></div>
		</div>
	</div>

	<div class="widget_content">
		<div class="content_float">
			{foreach from=$res.data item=l}
			<div class="float_left">
				<div class="gallery_item">
					<div style="background-image: url({$l.thumb.url});" class="image"><a href="{$l.url}"><img src="/_img/x.gif"/></a></div>
					<div class="name"><a href="{$l.url}">{$l.title|truncate:50}</a></div>
					<div class="info">Фотографий: <b>{$l.count}</b></div>
				</div>
			</div>
			{/foreach}
			<div class="cleaner"/>
		</div>
		
		{if $res.count > sizeof($res.data) || $res.can_add=== true}
		<div class="actions_panel">
			<div class="actions_rs">
				{if $res.count > sizeof($res.data)}<a href="{$res.url}">Все альбомы ({$res.count})</a>{/if}
				{if $res.count > sizeof($res.data) && $res.can_add=== true}<br/>{/if}
				{if $res.can_add=== true}<a href="{$res.url}gallery/{$res.gallery_id}/addalbum.php">Создать альбом</a>{/if}
			</div>
		</div>
		<br clear="both"/>
		{/if}
	</div>
</div>
{/if}