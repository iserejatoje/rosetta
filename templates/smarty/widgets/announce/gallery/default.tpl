{if is_array($res)}

<div style="padding-top:5px">
{if is_array($res.data)}
{foreach from=$res.data item=l}
<div align="center">
	<div align="center" style="width: 136px">
		<a href="{$l.url}"><img src="{$l.thumb.url}" width="{$l.thumb.width}" height="{$l.thumb.height}" title="{$l.title}" border="0" /></a>
	</div>
	<div style="padding: 4px;">
		<a href="{$l.url}">{$l.title|truncate:50}</a>
		{if $l.count > 0}
			{*<sup class="tip">{$l.count}</sup>*}
			<br/><span class="tip">Фотографий: <b>{$l.count}</b></span>
		{/if}
	</div>
</div>
{/foreach}
{/if}
<div class="tip" style="padding-bottom: 4px;">
	<br/>
	<a href="/community/{$res.obj_id}/gallery/">Все альбомы</a>
{if $res.can_add === true}
	&nbsp;&nbsp;
	<a href="/community/{$res.obj_id}/gallery/gallery/{$res.gallery_id}/addalbum.php">Добавить</a>
{/if}
</div>
</div>

{/if}