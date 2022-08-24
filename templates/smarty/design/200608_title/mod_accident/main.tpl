<table width=100% border=0 cellspacing=0 cellpadding=3>
	{foreach from=$BLOCK.list.list item=l}
		<tr> 
			<td valign=top align="left">
				<a href="{$BLOCK.module_url}/{$BLOCK.section}/show/{$l.id}.html"><img src="{$l.img.file}" width="{$l.img.w}" height="{$l.img.h}" align="left" border="0" alt="{$l.name|strip_tags}" style="margin-right:3px;margin-bottom:3px;" /></a>
				{$l.date|date_format:"%e"} {$l.date|month_to_string:2}
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				<a href="{$BLOCK.module_url}/{$BLOCK.section}/show/{$l.id}.html" class="zag1"><b>{$l.name}</b></a>
				{if $l.text!=""}
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
					{$l.text|truncate:180:"...":false}
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
			</td>
		</tr>
		<tr>
			<td>
				{if is_array($l.otz.list) && sizeof($l.otz.list) }
					<div align="left" class="dop3">
					{foreach from=$l.otz.list item=o}
						<b><font class="dop2">{$o.name|truncate:20:"...":false}, {$o.date|date_format:"%e.%m"}:</font></b>
						&nbsp;{$o.otziv|truncate:40:"...":false}&nbsp;<a href="{$BLOCK.module_url}/{$BLOCK.section}/show/{$l.id}.html#{$o.id}"><img src="/img/design/bull-spis.gif" width="9" height="7" border="0" align="middle" alt="читать далее" /></a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0" style="vertical-align:text-top;"><br />
					{/foreach}</div>
				{/if}
			</td>
		</tr>
	{/foreach}
</table>