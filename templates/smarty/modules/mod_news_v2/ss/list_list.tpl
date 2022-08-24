{if in_array($CURRENT_ENV.site.domain, array("72.ru","63.ru","161.ru","ufa1.ru","116.ru","v1.ru","45.ru","29.ru","93.ru","kbs.ru","76.ru","48.ru","26.ru","86.ru","89.ru","164.ru","56.ru","mgorsk.ru","ekat.ru","62.ru","tolyatty.ru","sterlitamak1.ru","51.ru","sochi1.ru","178.ru","38.ru","70.ru","42.ru","71.ru","43.ru","35.ru","omsk1.ru","53.ru","75.ru","14.ru","68.ru","provoronezh.ru","60.ru","154.ru")) && !in_array($CURRENT_ENV.section, array('newsline_fin','tech','skills','news_fin','newscomp_fin','fin_analytic','predict','newsline_auto','news_auto','autostop','pdd','accident','instructor','photoreport','autostory','newsline_dom','news_dom','articles','hints','expert','design','weekfilm','wedding','starspeak','travel','inspect'))}
	{banner_v2 id="1479"}<br/>
{/if}
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
<tr><td align="center" class="title2">{$res.title}</td></tr>
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
	<tr><td>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td class="archive_href">
		<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html">
		{if $l.type==2 }
			<b>{$l.name_arr.name}</b><br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">
			{$l.name_arr.position}:<br/> <b>{$l.name_arr.text}</b></font>
		{else}
			{$l.name}
		{/if}
		</a>
		</td></tr>
{*		<tr><td bgcolor=#333333><img src='/_img/x.gif' width=1 height=4 border=0></td></tr>*}
		</table>
	</td></tr>
	<tr><td><img src="/_img/x.gif" width="1" height="3" border="0"></td></tr>
	<tr><td>
	{if $l.img1.file}
	<a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-top:3px;margin-bottom:3px;" /></a>
	{/if}
	<span class="bl_date_news">{$l.date|date_format:"%e"} {$l.date|month_to_string:2} {$l.date|date_format:"%Y"}</span><br />
	{foreach from=$l.anon item=anon key=k}
	{$anon|screen_href|mailto_crypt}
	{/foreach}
	</td><tr>
	{if $l.otz.count }
	<tr><td align="left" style="padding-bottom:2px" class="comment_descr">
		{foreach from=$l.otz.list item=o}
			<span class="comment_name"><b>{$o.name|truncate:20:"...":false}:</b></span> {$o.otziv|truncate:80:"...":false}
			<a href="{if $o.url}{$o.url}{else}/{$SITE_SECTION}/{$last.group}{$l.id}.html?p={$o.p}#{$o.id}{/if}"><small>&gt;&gt;</small></a>
		{/foreach}
	</td></tr>
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