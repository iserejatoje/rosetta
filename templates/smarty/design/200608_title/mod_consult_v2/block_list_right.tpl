<table class="block_right" width="100%" cellpadding="0" cellspacing="3">
<tbody><tr><th><span>{$GLOBAL.title[$ENV.section]}</span></th></tr>
</tbody></table>
<table width="100%" cellpadding="0" cellspacing="0">
{foreach from=$res.list item=l}
	{if !empty($l.child)}
	{foreach from=$l.child item=lc}
	{if !$lc.last_comment.readonly}
	<tr>
		<td align="left" valign="top" style="padding-left:10px">
				<font clas="t5"><a href="/{$ENV.section}/{$lc.path}/">{$lc.name}</a>{* ({if $l.count}{$l.count}{else}0{/if}) *} </font>
			{if is_array($lc.last_comment) && ($lc.last_comment.otziv!="")}
				<br/><font class="dop2">{$lc.last_comment.otziv|truncate:60:"...":false}</font> <a href="/{$ENV.section}/{$lc.path}/{$lc.last_comment.cid}.html#{$lc.last_comment.id}" class="s1"><small>&gt;&gt;</small></a>
			{/if}
		</td>
	</tr>
	<tr>
		<td align="right"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	</tr>
	{/if}			
	{/foreach}
	{else}
	{if !$l.last_comment.readonly}
	<tr>
		<td align="left" valign="top" style="padding-left:10px">
			{if empty($l.child)}
				<font class="t5"><a href="/{$ENV.section}/{$l.path}/" >{$l.name}</a>{* ({if $l.count}{$l.count}{else}0{/if}) *} </font>
			{else}
				<font class="t5"><a href="/{$ENV.section}/{$l.id}.html">{$l.name}</a>{* ({if $l.count}{$l.count}{else}0{/if}) *} </font>
			{/if}

			{if is_array($l.last_comment) && sizeof($l.last_comment)}
				<br/><font class="dop2">{$l.last_comment.otziv|truncate:60:"...":false}</font> <a href="/{$ENV.section}/{$l.last_comment.path}/{$l.last_comment.cid}.html#{$l.last_comment.id}" class="s1"><small>&gt;&gt;</small></a>
			{/if}
		</td>
	</tr>
	<tr>
		<td align="right"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	</tr>
	{/if}
	{/if}
{/foreach}
</table>