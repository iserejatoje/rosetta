{*<table border=0 cellpadding=0 cellspacing=0 width=100%>
  <tr><td align=right class=txt>&nbsp;</td></tr>
  <tr><td height="1px" bgcolor="#333333"><img src="/_img/x.gif" width="1" height="1"></td></tr>
</table> *}
<table width=100% border=0 cellspacing=0 cellpadding=0>
{if $last.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$last.list item=l}
		{if $k>0}
			<tr><td bgcolor="#CCCCCC"><img src='/_img/x.gif' width=1 height=1 border=0></td></tr>
		{/if}
		<tr><td><img src=/_img/x.gif width=1 height=3></td></tr>
		<tr><td align="left" class="zag3" style="padding-bottom:2px;">
		<a href="/{$SITE_SECTION}/{$last.group}{$l.id}.html">
		{if $l.type==2}
			{$l.name_arr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.name_arr.position}{if $l.name_arr.text}: <b>{$l.name_arr.text}</b>{/if}
		{else}
			{$l.name}
		{/if}
		</a>
		</td><tr>
		<tr><td align="left" style="padding-bottom:2px">
		{if $l.img1.file }
			<a href="/{$SITE_SECTION}/{$last.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{foreach from=$l.anon item=anon key=k}
		{if $k<3 }{$anon}{/if}
		{/foreach}
		</td><tr>
		{if $l.otz.count }
			{foreach from=$l.otz.list item=o}
				<tr><td align="left" style="padding-bottom:2px" class="small">
				<font color="#F78729"><b>{$o.name}:</b></font> {$o.otziv|truncate:40:"...":false}
				<a href='/{$SITE_SECTION}/{$last.group}{$l.id}.html?p={$o.p}#{$o.id}'><small>&gt;&gt;</small></a>
				</td></tr>
			{/foreach}
		{/if}
	{/foreach}
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$last.list item=l key=k}
		{if $k>0}
			<tr><td bgcolor="#CCCCCC"><img src='/_img/x.gif' width=1 height=1 border=0></td></tr>
		{/if}
		<tr><td><img src="/_img/x.gif" width="1" height="8" border="0" alt="" /></td></tr>
		<tr><td align="center" style="padding-bottom:2px" class="t_green">{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td></tr>
		<tr><td align="center" style="padding-bottom:2px">
		{if $l.img1.file }
			<a href="/{$SITE_SECTION}/{$last.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
		</td></tr>
		<tr valign="bottom"><td align="center" class="t_blue">
		<a href="/{$SITE_SECTION}/{$last.group}{$l.id}.html">
		{if $l.type==2}
			<b>{$l.name_arr.name}</b>,<br /><font style="text-decoration:none;">{$l.name_arr.position}</font>
		{else}
			<b>{$l.name}</b>
		{/if}</a>
		</td></tr>
		<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt"" /></td></tr>
		{if $l.otz.count }
			{foreach from=$l.otz.list item=o}
				<tr><td align="left" style="padding-bottom:2px" class="small">
				<font color=#F78729><b>{$o.name|truncate:20:"...":false}:</b></font> {$o.otziv|truncate:40:"...":false}
				<a href='/{$SITE_SECTION}/{$last.group}{$l.id}.html?p={$o.p}#{$o.id}'><small>&gt;&gt;</small></a>
				</td></tr>
			{/foreach}
			</div>
		{/if}
	{/foreach}
{/if}
<tr><td bgcolor="#FFFFFF"><img src='/_img/x.gif' width=1 height=1 border=0></td></tr>
</table>
