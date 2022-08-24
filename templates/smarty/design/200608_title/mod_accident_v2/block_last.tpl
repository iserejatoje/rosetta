{if sizeof($res.data)}
<table width="100%" class="block_right" cellspacing="3" cellpadding="0" >
<tr><th><span>Автокатастрофы</span></th></tr>
</table>
<table width="100%" class="block_right" cellspacing="3" cellpadding="0">
	{foreach from=$res.data item=l}
		<tr> 
			<td valign=top align="left">
				
				{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				
				<a href="/{$ENV.section}/{$l.ID}.php"><img src="{$l.img.url}" width="{$l.img.w}" height="{$l.img.h}" align="center" border="0" alt="{$l.Name|strip_tags}" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{if $l.Text }
					{$l.Text}
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
				
				<a href="/{$ENV.section}/{$l.ID}.php"><b>{$l.Name}</b></a>
				{if is_array($l.comments) && sizeof($l.comments) }
					<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
					<div align="left" class="comment_descr">
					{foreach from=$l.comments item=o}
						<b><font class="comment_name">{if $o.user}<a href="{$o.user.url}" target="_blank">{$o.user.name|truncate:20:"...":false}</a>{else}{if $o.name != ''}{$o.name|truncate:20:"...":false}{else}Гость{/if}{/if}</font>, <font class="comment_date">{$o.date|date_format:"%e.%m"}:</font></b>
						&nbsp;{$o.text|truncate:40:"...":false}&nbsp;<a href="/{$ENV.section}/{$l.ID}.php#comment{$o.id}" title="читать далее">&gt;&gt;</a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0" style="vertical-align:text-top;"><br />
					{/foreach}</div>
				{/if}
			</td>
		</tr>
	{/foreach}
</table>
{/if}