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
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=i}
	{if $i!=0}
	<tr><td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td></tr>
	{/if}
	<tr><td class="zag_u">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td class=zag4>
		{if $res.current_date > $l.date}{$l.date|date_format:"%e.%m.%Y"}{/if} {$l.date|date_format:"%H:%M"} <b><a name="{$l.id}">{$l.name}</a></b>
		</td></tr>
{*		<tr><td bgcolor=#333333><img src='/_img/x.gif' width=1 height=4 border=0></td></tr>*}
		</table>
	</td></tr>
	<tr><td><img src='/_img/x.gif' width=1 height=3 border=0></td></tr>
	<tr><td>
	{$l.text}
	</td><tr>
	{if $l.author_name}<tr><td align="right"><b>{if $l.author_email }<a href="mailto:{$l.author_email}">{$l.author_name}</a>{else}{$l.author_name}{/if}, <i>специально для Chelyabinsk.ru</i></b></td></tr>{/if}
	{if $l.photographer_name}<tr><td align="right">{$l.photographer_name}</td></tr>{/if}
	<tr><td align="right"><a class="descr" href="/{$ENV.section}/{$l.id}.html">постоянный адрес новости</a></td></tr>
	{if !empty($l.link)}<tr><td align="right"><a href="{$l.link}" class="ssyl" target="_blank">обсудить новость на форуме</a></td></tr>{/if}
	{if $l.otz.count }
		{foreach from=$l.otz.list item=o}
			<tr><td align="left" style="padding-bottom:2px" class="small">
			<font color="#F78729"><b>{$o.name|truncate:20:"...":false}:</b></font> {$o.otziv|truncate:80:"...":false}
			<a href='/{$ENV.section}/{$last.group}{$l.id}.html?p={$o.p}#{$o.id}'><small>&gt;&gt;</small></a>
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
<tr><td height="10px"><font style="font-size:8px;color:#ffffff;">{$smarty.now|date_format:"%Y-%m-%d %T"}</font></td></tr>
</table>