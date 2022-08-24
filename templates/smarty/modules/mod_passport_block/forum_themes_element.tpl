<div style="padding: 5px;">
	<b><a href="{$l.url}">{$l.name}</a></b>
	<div style="padding: 4px 0px 0px 10px;">
		<span class="txt_color1">{$l.last_date|simply_date}:</span>
		{$l.message|strip_tags|truncate:60}
		<span class="tip"><a href="{$l.url}&act=message&mid={$l.message_id}">читать</a></span>
	</div>
</div>