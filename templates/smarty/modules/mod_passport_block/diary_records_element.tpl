<div style="padding: 5px;">
	<a href="/user/{$res.UserID}/blogs/post/{$l->ID}.php">{if $l->Title}<b>{$l->Title|truncate:45}</b>{else}<b>{$l->Text|strip_tags|truncate:45}</b>{/if}</a>
	<div style="padding: 4px 0px 0px 10px;">
		<span class="txt_color1">{$l->Created|simply_date}:</span>
		{$l->Text|strip_tags|truncate:30}
		<span class="tip"><a href="/user/{$res.UserID}/blogs/post/{$l->ID}.php">читать</a></span>
	</div>
</div>