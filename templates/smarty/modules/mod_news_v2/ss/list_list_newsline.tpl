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
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=i}
	{if $i!=0}
	<tr><td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td></tr>
	{/if}
	<tr><td>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td>
			<span class="title">{if date('Ymd') != date('Ymd', $l.date)}{$l.date|date_format:"%e.%m.%Y"}{/if} {$l.date|date_format:"%H:%M"}</span>
			<span class="title2"><a name="{$l.id}"></a>{$l.name}</span>
		</td></tr>
{*		<tr><td bgcolor=#333333><img src="/_img/x.gif" width="1" height="4" border="0"></td></tr>*}
		</table>
	</td></tr>
	<tr><td><img src="/_img/x.gif" width="1" height="3" border="0"></td></tr>
	<tr><td>
	{$l.text|screen_href|mailto_crypt}
	</td><tr>
	{if $l.author_name}<tr><td align="right"><span class="txt_color1"><b>{if $l.author_email }<a href="mailto:{$l.author_email}">{$l.author_name}</a>{else}{$l.author_name}{/if},</b> <i>специально для {$ENV.site.domain|ucfirst}</i></span></td></tr>{/if}
	{if $l.photographer_name}<tr><td align="right"><span class="txt_color1">{$l.photographer_name}</span></td></tr>{/if}
	<tr><td><table cellpadding="0" cellspacing="0" width="100%"><tr>
		{if !empty($l.link) && !strpos($l.link, 'rugion.ru') && $CURRENT_ENV.regid == 74}<td><noindex><a href="{$l.link}" target="_blank">обсудить на форуме</a></noindex></td>{/if}
		<td align="right"><noindex><a class="descr" href="/{$ENV.section}/{$l.id}.html">постоянный адрес новости</a></noindex></td>
	</tr></table></td></tr>
	<tr><td><br /></td></tr>
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