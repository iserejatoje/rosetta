{if in_array($CURRENT_ENV.site.domain, array("72.ru","63.ru","161.ru","ufa1.ru","116.ru","v1.ru","45.ru","29.ru","93.ru","kbs.ru","76.ru","48.ru","26.ru","86.ru","89.ru","164.ru","56.ru","mgorsk.ru","ekat.ru","62.ru","tolyatty.ru","sterlitamak1.ru","51.ru","sochi1.ru","178.ru","38.ru","70.ru","42.ru","71.ru","43.ru","35.ru","omsk1.ru","53.ru","75.ru","14.ru","68.ru","provoronezh.ru","60.ru","154.ru")) && !in_array($CURRENT_ENV.section, array('newsline_fin','tech','skills','news_fin','newscomp_fin','fin_analytic','predict','newsline_auto','news_auto','autostop','pdd','accident','instructor','photoreport','autostory','newsline_dom','news_dom','articles','hints','expert','design','weekfilm','wedding','starspeak','travel','inspect'))}
	{banner_v2 id="1479"}<br/>
{/if}
{if $page.id }

	{$page.blocks.text}
	<p align="right"><a href="/{$CURRENT_ENV.section}/{$page.id}-print.html" class="descr" target="print" onclick="window.open('about:blank', 'print','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></p>

	{$page.blocks.crossref}

	{if $page.blocks.poll}
		{$page.blocks.poll}
	{/if}

{if in_array($CURRENT_ENV.section,array('news','newscomp','expert')) && $CURRENT_ENV.site.domain=="domchel.ru"}
<!--b2b-->
{include file="common/a_b2bcontext.tpl"}
<!--/b2b-->
{/if}

{if $CURRENT_ENV.site.domain=="chelfin.ru"}{banner_v2 id="1317"}{/if}

	{if $page.is_forum}
		{$page.blocks.comments}
	{/if}
	{if $page.is_forum}
		{$page.blocks.askform}
	{/if}
{*<div id="forum_form"></div>
<script>blocks_get_block(
	'/block_forum/form.html',
	{ldelim}scid:{$page.forum.section_id}, theme:{$page.forum.theme}{rdelim},
	function(data){ldelim}blocks_add_to_page('forum_form',data){rdelim}
	);</script>*}

{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$ENV.section}/{$page.group}">Последняя статья</a>
	</center>
{/if}
