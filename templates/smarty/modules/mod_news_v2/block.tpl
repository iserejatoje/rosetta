<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_right">
  <tr><th><span>
		{$ENV.site.title[$ENV.section]}
</span></th></tr>
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr><td align="left" class="title_normal" style="padding-bottom:2px;">
		<a href="/{$ENV.section}/{$res.group}{$l.id}.html">
		{if $l.type==2}
			<b>{$l.name_arr.name}</b>,<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.name_arr.position}{if $l.name_arr.text}: <b>{$l.name_arr.text}</b>{/if}
		{else}
			{$l.name}
		{/if}
		</a>
		</td><tr>
		<tr><td style="padding-bottom:2px">
		{if $l.img1.file }
			<a href="/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{foreach from=$l.anon item=anon key=k}
		{if $k<3 }{$anon}{/if}
		{/foreach}
		</td><tr>
		{if $l.otz.count }
		<tr><td style="padding-bottom:2px">
			{foreach from=$l.otz.list item=o}
				<div class="smalltext">
				<span class="title_normal"><b>{$o.name|truncate:20:"...":false}:</b></span> {$o.otziv|truncate:40:"...":false}
				<a href="{if $o.url}{$o.url}{else}/{$ENV.section}/{$res.group}{$l.id}.html?p={$o.p}#{$o.id}{/if}"><small>&gt;&gt;</small></a>
				</div>
			{/foreach}
		</td><tr>
		{/if}
	{/foreach}
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		<tr><th><span>{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</span></td></tr>
		<tr><td style="padding-bottom:2px"><div align="center">
		{if $l.img1.file }
			<a href="/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
			<a href="/{$ENV.section}/{$res.group}{$l.id}.html">
			{if $l.type==2}
				<b>{$l.name_arr.name}</b>,<br /><font style="text-decoration:none;">{$l.name_arr.position}</font>
			{else}
				<b>{$l.name}</b>
			{/if}</a>
		</div>
		{if $l.otz.count }
			{foreach from=$l.otz.list item=o}
				<div class="smalltext">
				<span class="title_normal"><b>{$o.name|truncate:20:"...":false}:</b></span> {$o.otziv|truncate:40:"...":false}
				<a href="{if $o.url}{$o.url}{else}/{$ENV.section}/{$res.group}{$l.id}.html?p={$o.p}#{$o.id}{/if}"><small>&gt;&gt;</small></a>
				</div>
			{/foreach}
		{/if}
		</div>
		</td></tr>
	{/foreach}
{/if}
</table>
