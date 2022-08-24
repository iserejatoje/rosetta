<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>История сообщений - {$ENV.site.domain}</title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" type="text/css" href="/style.css" />
</head>
{capture name=pageslink}
<div><b>Страницы:</b>
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<b>{$l.text}</b>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
</div>
{/capture}
<body><br>
	<table cellpadding=5 cellspacing=0 border=0 width=100%>
		<tr><td valign=middle align=left style="padding: 0px 5px 0px 5px">
			<table cellpadding=0 cellspacing=0 border=0>
				<tr><td rowspan=2>
					<a href="/{$SITE_SECTION}/user/{$res.userTo.user.id}.html"><img border=0 src="{if !empty($res.userTo.user.photos[0].img)}{$res.userTo.user.photos[0].img}{else}/img/love/nofoto.gif{/if}"></a> &#160;
				</td><td>
					<a href="/{$SITE_SECTION}/user/{$res.userTo.user.id}.html" title="Посмотреть анкету" target="_blank"><b><font color="#2297C6">{$res.userTo.user.name}</font></b></a>,&#160;</td><td><img valign=middle src={if $res.userTo.user.gender==2}"/img/love/women.gif" alt="Девушка"{else}"/img/love/men.gif" alt="Парень"{/if}></td><td>&#160;<b>{$res.userTo.user.age}</b>&#160;</td><td><img src="/img/love/{$res.userTo.user.zodiak.img}" alt="{$res.userTo.user.zodiak.alt}" width=16 height=16></td><td>, {$res.userTo.user.city}

<!--LiveInternet counter--><script language="JavaScript"><!--
document.write('<img src="http://counter.yadro.ru/hit?r'+
escape(document.referrer)+((typeof(screen)=='undefined')?'':
';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+';'+Math.random()+
'" width=1 height=1 alt="">')//--></script><!--/LiveInternet--><a href="http://top100.rambler.ru/top100/"><img src="http://counter.rambler.ru/top100.cnt?{$GLOBAL.rambid}" alt="Rambler's Top100" width=1 height=1 border=0></a>

				</td></tr>
			<tr><td colspan=5>{*<font class=lit1>Был{if $res.to.gender==2}a{/if} {$res.to.what_lasttime}</font>*}</td></tr></table>
		</td></tr>
		<tr><td bgcolor="#2297C6" heigth=1></td></tr>
		</table>
		<br>
		{$smarty.capture.pageslink}
		<br>
		{if !empty($res.list)}
			{foreach from=$res.list item=l}
			{if !$l.isnew}<img src="/img/love/001.gif" alt="письмо прочитано">{else}<img src="/img/love/002.gif" alt="письмо не прочитано">{/if}&#160;
				<font color="#{if $l.uid == $res.uid}990000{else}2297C6{/if}">
				<b>{$res.name[$l.uid]}</b> {$l.date|date_format:"%d.%m.%Y"} в {$l.date|date_format:"%H:%M"}<br>
				{$l.message}</font><hr color="#A0CADB" width=100 size=1 align=left>
			{/foreach}
		{/if}
<center><!--begin of Top100 logo--><a href="http://top100.rambler.ru/top100/"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-gray2.gif" alt="Rambler's Top100" width=88 height=31 border=0></a><!--end of Top100 logo -->&nbsp;<!--LiveInternet logo--><a href="http://www.liveinternet.ru/click" target=_blank><img src="http://counter.yadro.ru/logo?44.1" border=0 width=31 height=31 alt="liveinternet.ru"></a><!--/LiveInternet--></center>
</body>
</html>