{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>
		{else}
			&nbsp;<span class="pageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
<tr><td align="center" class="zag2"><b>{if $SITE_SECTION=="medicine"}Лидеры медицины за {$smarty.now|date_format:"%Y"} год{else}{$res.title}{/if}</b></td></tr>
{if $smarty.capture.pageslink!="" }
<tr><td height="10px"></td></tr>
<tr><td align="right">
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=i}
	{if $i!=0}
	<tr><td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td></tr>
	{/if}
	<tr><td class="zag_u">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td class=zag>
		<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html">
		{if $l.type==2 }
			{$l.name_arr.name}<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">
			{$l.name_arr.position}:<br/> <b>{$l.name_arr.text}</b></font>
		{else}
			{$l.name}
		{/if}
		</a>
		</td></tr>
{*		<tr><td bgcolor=#333333><img src='/_img/x.gif' width=1 height=4 border=0></td></tr>*}
		</table>
	</td></tr>
	<tr><td><img src='/_img/x.gif' width=1 height=3 border=0></td></tr>
	<tr><td>
	{if $l.img1.file}
	<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
	{/if}
	<font class="small">{$l.date|date_format:"%e"} {$l.date|month_to_string:2} {$l.date|date_format:"%Y"}</font><br />
	{foreach from=$l.anon item=anon key=k}
	{$anon}
	{/foreach}
	</td><tr>
	{if $l.otz.count }
		{foreach from=$l.otz.list item=o}
			<tr><td align="left" style="padding-bottom:2px" class="small">
			<font color="#F78729"><b>{$o.name|truncate:20:"...":false}:</b></font> {$o.otziv|truncate:80:"...":false}
			<a href='/{$SITE_SECTION}/{$last.group}{$l.id}.html?p={$o.p}#{$o.id}'><small>&gt;&gt;</small></a>
			</td></tr>
		{/foreach}
	{/if}
	{/foreach}
	</table>

</td></tr>
{if $smarty.capture.pageslink!="" }
<tr><td height="10px"></td></tr>
<tr><td align="right">
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
</table>