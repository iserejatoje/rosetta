<html><head>
{$TITLE->Head}
<link href="/_styles/design/200608_main/common/styles.css" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="{$CURRENT_ENV.site.domain} - Новости и статьи" href="http://{$CURRENT_ENV.site.domain}/rss/type/{$CURRENT_ENV.site.domain}/news.xml" />
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="padding:0px">
{if isset($BLOCKS.header.our_projects) && $BLOCKS.header.our_projects !== false}
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center">
			{$BLOCKS.header.our_projects}
	</td>
</tr>
</table>
{/if}
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="bottom">
	<td align="left"><a href="#" class="a12b" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.{$CURRENT_ENV.site.domain}');OnCounterClick(15);">Сделай <font style="font-size: 17px;">{$CURRENT_ENV.site.domain}</font> ГЛАВНЫМ сайтом {$CURRENT_ENV.site.name_whose} интернета!</a></td>
	<td style="display:none" width="1"><noindex><!--LiveInternet counter--><script language="JavaScript"><!--
document.write('<img src="http://counter.yadro.ru/hit?r'+
escape(document.referrer)+((typeof(screen)=='undefined')?'':
';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
';'+Math.random()+
'" width=1 height=1 alt="">')//-->
</script><!--/LiveInternet-->
<a href="http://top100.rambler.ru/top100/" rel="nofollow"><img src="http://counter.rambler.ru/top100.cnt?{$CURRENT_ENV.site.rambler_id}" alt="Rambler's Top100" width=1 height=1 border=0></a></noindex></td>
	<td align="center" class="t11" style="color:#666666">{current_date}</td>
	<td align="right" class="t11">{$BLOCKS.top.statistic}</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td></tr></table>

<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="middle" align="center" bgcolor="#E9EFEF">
	<td width="14%">
		{if isset($BLOCKS.top.logo) && $BLOCKS.top.logo !== false}
			{$BLOCKS.top.logo}
		{else}
			<img src="/_img/design/200806_title_main/logo/logo.{$CURRENT_ENV.site.domain}.gif" border="0" alt="{$CURRENT_ENV.site.domain} - {$CURRENT_ENV.site.name}" title="{$CURRENT_ENV.site.domain} - {$CURRENT_ENV.site.name}" />
		{/if}
	</td>
	<td width="2"><img src="/_img/x.gif" width="2" height="1" border="0" alt="" /></td>
	<td>{$BLOCKS.top.weather}</td>
	<td width="2"><img src="/_img/x.gif" width="2" height="1" border="0" alt="" /></td>
	<td width="30%">

<!-- почта -->
{include file="design/200608_title/common/block_mail_main.tpl"}
<!--почта END -->

	</td>
</tr>
</table>

<!-- центрально меню -->
<div style="padding-top:6px;padding-bottom:7px" align="center" class="g11">
	<a href="/newsline/" class="g11" target="_blank">Новости</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/mail/" class="g11" target="_blank">Почта</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/job/" class="g11" target="_blank">Работа</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/map/" class="g11" target="_blank"><font color=red>Карта</font></a>
	<span class="gr11">|</span>&nbsp;
	<a href="/search/advanced.php?sortby=rlv&where=3&col_pp=10&text=" class="g11" target="_blank">Поиск</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/exchange/" class="g11" target="_blank">Финансы</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/advertise/" class="g11" target="_blank">Авто</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/sale/" class="g11" target="_blank">Недвижимость</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/baraholka/" class="g11" target="_blank">Барахолка</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/weather/" class="g11" target="_blank">Погода</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/blog/" class="g11" target="_blank">Дневники</a>&nbsp;
	<span class="gr11">|</span>&nbsp;
	<a href="/forum/" class="g11" target="_blank">Форумы</a>
</div><!--центральное меню -->