<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody>
<tr>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" class="t12">
		<tbody>
		<tr>
			<td align="left" style="padding: 1px 10px;" class="block_caption_main">
				<a target="_blank" href="/service/go/?url={$res.url|escape:"url"}">{$res.title}</a>
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr><td>
	<table cellspacing="0" cellpadding="0" border="0" class="t12">
	{foreach from=$res.list item=l}
	<tr><td class="block_content">
	{*<div class="t11">{$l.Date|simply_date}</div>*}
	{*if $l.photo.visible}
	<div style="background-image: url({$l.photo.thumb.url});" class="thumb">
		<div>
			<a target="_blank" href="/service/go/?url={$l.url|escape:"url"}"><img height="{$l.photo.thumb.height}" width="{$l.photo.thumb.width}" alt="{$l.photo.title}" src="/_img/x.gif"/></a>
		</div>
	</div>
	{/if*}
	<a href="/service/go/?url={$l.url|escape:"url"}" target="_blank" class="t11">{$l.Name}</a>
	</td></tr>
	{/foreach}
	</table>
</td>
</tr>
<tr><td><img src="/_img/x.gif" border="0" alt="" width="1" height="5" /></td></tr>
<tr><td style="font-size: 9px; color: rgb(138, 163, 166);"><a href="/service/go/?url={$res.url|escape:"url"}" target="_blank" style="font-size: 9px; color: rgb(138, 163, 166);">Все предложения</a> (<b>{$res.count}</b>)</td></tr>
</tbody>
</table>