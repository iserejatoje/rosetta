<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr>
		<td align="right" class="block_title_obl"><span>{$GLOBAL.title[$ENV.section]}</span></td>
	</tr>
	<tr>
		<td align="right"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="right"><img src="/_img/x.gif" width="1" height="3" alt="" /></td>
	</tr>

{foreach from=$res.list item=l}
	<tr>
		<td align="right" valign="top">
			{if empty($l.child)}
				<font class="t5"><a href="/{$ENV.section}/{$l.path}/">{$l.name}</a>{* ({if $l.count}{$l.count}{else}0{/if}) *} </font>
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
{/foreach}
</table>
