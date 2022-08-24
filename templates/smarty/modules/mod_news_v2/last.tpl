<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_left">
{if $res.withxt==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr><td align="left" style="padding-bottom:2px;">
		<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html">
		{if $l.type==2}
			{$l.name_arr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.name_arr.position}{if $l.name_arr.text}: <b>{$l.name_arr.text}</b>{/if}
		{else}
			{$l.name}
		{/if}
		</a>
		</td><tr>
		<tr><td align="left" style="padding-bottom:2px">
		{if $l.img1.file }
			<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{foreach from=$l.anon item=anon key=k}
		{if $k<3 }{$anon}{/if}
		{/foreach}
		</td><tr>
		{if $l.otz.count }
			{foreach from=$l.otz.list item=o}
				<tr><td align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{$o.name}:</b></span> {$o.otziv|truncate:40:"...":false}
				<a href='/{$SITE_SECTION}/{$res.group}{$l.id}.html?p={$o.p}#{$o.id}'><small>&gt;&gt;</small></a>
				</td></tr>
			{/foreach}
		{/if}
	{/foreach}
{else}
{* это случай без текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		{if $SITE_SECTION!="bizvip"}<tr><td><div align="center" style="padding:0px"><span class="bl_date_news">{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</span></div></td></tr>{/if}
		<tr><td style="padding-bottom:2px"><div align="center" class="bl_body">
		{if $l.img1.file }
			<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html" class="bl_title_news"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
			<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html" class="bl_title_news">
			{if $l.type==2}
				<b>{$l.name_arr.name}</b>,<br /><font style="text-decoration:none;">{$l.name_arr.position}</font>
			{else}
				<b>{$l.name}</b>
			{/if}</a>
		</div>
		{if $l.otz.count}
			{foreach from=$l.otz.list item=o}
				<div class="comment_descr">
				<span class="comment_name"><b>{$o.name|truncate:20:"...":false}:</b></span> {$o.otziv|truncate:40:"...":false}
				<a href="{$o.url}"><small>&gt;&gt;</small></a>
				</div>
			{/foreach}
		{/if}
		</td></tr>
	{/foreach}
{/if}
</table>
