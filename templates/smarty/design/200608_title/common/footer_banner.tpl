{if $CURRENT_ENV.regid == 61}
	<noindex>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
	<tr><td align="center">
	<script language="JavaScript" src="http://ran.rostov-don.ru/cgi-bin/jsrc/stosheodin"></script><noscript>
	<a href="http://ran.rostov-don.ru/cgi-bin/href/stosheodin|65535/"
	target=_top><img
	src="http://ran.rostov-don.ru/cgi-bin/banner/stosheodin?65535"
	alt="r[a[n Network" width=468 height=60 border=0></noscript>
	</td></tr>
	</table>
	</noindex>

{elseif $CURRENT_ENV.regid == 26}
	{if in_array($CURRENT_ENV.section,array('newsline','job','dnevniki'))}
		{banner_v2 id="2684"}
	{/if}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2683"}
	{/if}

{elseif $CURRENT_ENV.regid == 29}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2682"}
	{/if}

{elseif $CURRENT_ENV.regid == 45}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2685"}
	{/if}

{elseif $CURRENT_ENV.regid == 56}
	{if in_array($CURRENT_ENV.section,array('newsline','job','dnevniki'))}
		{banner_v2 id="2690"}
	{/if}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2689"}
	{/if}
{elseif $CURRENT_ENV.regid == 76}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2687"}
	{/if}
{elseif $CURRENT_ENV.regid == 174}
	{if in_array($CURRENT_ENV.section,array('newsline','job','dnevniki'))}
		{banner_v2 id="2692"}
	{/if}
	{if in_array($CURRENT_ENV.section,array('weather','mail','horoscope','search'))}
		{banner_v2 id="2691"}
	{/if}

{elseif $CURRENT_ENV.regid == 72}
	<noindex>
	<table cellpadding="1" cellspacing="0" border="0" width="100%">
	<tr align="center">
		<td width="20%"><a href="http://www.banzay.ru/" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/banzai_2.gif" width="167" height="40" border="0" alt="" /></a></td>
		<td width="20%"><img src="/_img/design/200608_title/misc/72.ru/national_business.gif" width="178" height="40" border="0" alt="" /></td>
		<td width="20%"><img src="/_img/design/200608_title/misc/72.ru/dir-yral.gif" width="100" height="40" border="0" alt="" /></td>
		<td width="20%"><a href="http://www.karavan-reklama.ru/" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/karavan-uslug.gif" width="120" height="40" border="0" alt="" /></td>
		<td width="20%">{banner_v2 id="2831"}</td>
	</tr>
	<tr align="center">
		<td width="20%"><a href="http://zebra-press.ru/" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/zebra2.gif" width="100" height="40" border="0" alt="" /></td>
		<td width="20%"><a href="http://www.106-1.ru/" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/autoradio.gif" width="53" height="40" border="0" alt="" /></a></td>
		<td width="20%"><a href="http://www.101-FM.ru/" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/shanson.gif" width="88" height="40" border="0" alt="" /></a></td>
		<td width="20%">{banner_v2 id="665"}
			{*<a href="http://www.prospektgroup.ru/izdan.php?id=1" rel="nofollow" target="_blank"><img src="/_img/design/200608_title/misc/72.ru/newauto.png" width="185" height="40" border="0" alt="" /></a>*}
		</td>
		<td></td>
	</tr>
	</table>
	</noindex>

{elseif $CURRENT_ENV.regid == 2}
	<br/>
	<table width="100%" cellpadding="0" cellspacing="5" border="0">
	{if $CURRENT_ENV.section=="weather"}
	<tr>
		<td align="center"  colspan="3">{banner_v2 id="2813"}</td>
	</tr>
	{/if}
	{*if in_array($CURRENT_ENV.section, array('newsline', 'person','conference'))}
	<tr>
		<td align="center"  colspan="3">{banner_v2 id=969}</td>
	</tr>
	{/if*}
	</table>

{/if}