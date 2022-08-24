{if !empty($BLOCK.list.list)}
<table width="100%" class="block_right" cellspacing="3" cellpadding="0" >
	<tr><th><span>{$CURRENT_ENV.site.title.accident}</span></th></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="block_left">
	{foreach from=$BLOCK.list.list item=l}
		<tr> 
			<td valign=top align="left">
				
				{$l.date|date_format:"%e"} {$l.date|month_to_string:2}
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				
				<a href="/{$BLOCK.section}/show/{$l.id}.html"><img src="{$l.img.file}" width="{$l.img.w}" height="{$l.img.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{if $l.text }
					{$l.text}
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
				
				<a href="/{$BLOCK.section}/show/{$l.id}.html"><b>{$l.name}</b></a>
				{if is_array($l.otz.list) && sizeof($l.otz.list) }
					<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
					<div align="left" class="comment_descr">
					{foreach from=$l.otz.list item=o}
						<font class="comment_name">{$o.name|truncate:20:"...":false}</font>, <font class="comment_date">{$o.date|date_format:"%e.%m"}:</font>
						&nbsp;{$o.otziv|truncate:40:"...":false}&nbsp;<a href="/{$BLOCK.section}/show/{$l.id}.html#{$o.id}" title="читать далее">&gt;&gt;</a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0" style="vertical-align:text-top;"><br />
					{/foreach}</div>
				{/if}
			</td>
		</tr>
	{/foreach}
</table>
{/if}