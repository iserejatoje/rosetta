{if count($res.array)}
<table class="block_left" width="100%" cellpadding="0" cellspacing="0">
{if $res.title}
<tr>
	<th style="white-space: nowrap"><span>{$res.title}</span></th>
</tr>
{/if}
<tr>
	<td>

{if count($res.array)}
<table width="100%" cellpadding="3" cellspacing="1">
{foreach from=$res.array item=l key=k}
<tr valign="top" class="{cycle values=,bg_color4}">
	<td><a href="/{$ENV.section}/list.php?s={$l.link_s}"><b>{$l.name}</b></a>{if $res.need_count} ({$l.count}){/if}</td>
</tr>
{/foreach}
</table>
{/if}

	</td>
</tr>
</table>
{/if}