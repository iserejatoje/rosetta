{*{assign var="__page_cols" value="3"}{if $TEMPLATE.left}{assign var="__page_cols" value="`$__page_cols+1`"}{/if}{if $TEMPLATE.right}{assign var="__page_cols" value="`$__page_cols+1`"}{/if}*}
{if isset($BLOCKS.footer.footer_banner)}
	<tr><td>
		{$BLOCKS.footer.footer_banner}
</td></tr>
{/if}
<tr>
	<td>
		{include file="design/200608_title/common/a_links_footer.tpl"}
	</td>
</tr>
<tr>
	<td{* colspan="{$__page_cols}"*}>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="bg_color2">
				<tr valign="middle" align="center">
					<td>
						<table border="0" width="100%" cellspacing="0" cellpadding="10">
						<tr><td align="left">
						{include file="design/200608_title/common/footer_links.tpl"}
						</td></tr>
						</table>
					</td>
					<td width="260px" align="center">
<table cellpadding="3">
<tr>
<td>
{include file="design/200608_title/common/ctrl_error.tpl"}
<nobr><!--noindex--><noindex>
					{if $CURRENT_ENV.regid == 72 || $CURRENT_ENV.regid== 59}<!-- Начало кода счетчика УралWeb -->
<script language="JavaScript" type="text/javascript">
<!--
  uralweb_d=document;
  uralweb_a='';
  uralweb_a+='&r='+escape(uralweb_d.referrer);
  uralweb_js=10;
//-->
</script>
<script language="JavaScript1.1" type="text/javascript">
<!--
  uralweb_a+='&j='+navigator.javaEnabled();
  uralweb_js=11;
//-->
</script>
<script language="JavaScript1.2" type="text/javascript">
<!--
  uralweb_s=screen;
  uralweb_a+='&s='+uralweb_s.width+'*'+uralweb_s.height;
  uralweb_a+='&d='+(uralweb_s.colorDepth?uralweb_s.colorDepth:uralweb_s.pixelDepth);
  uralweb_js=12;
//-->
</script>
<script language="JavaScript1.3" type="text/javascript">
<!--
  uralweb_js=13;
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
uralweb_d.write('<a href="http://www.uralweb.ru/rating/go/{$CURRENT_ENV.regid}" rel="nofollow">'+
'<img border="0" src="http://hc.uralweb.ru/hc/{$CURRENT_ENV.regid}?js='+
uralweb_js+'&amp;rand='+Math.random()+uralweb_a+
'" width="88" height="31" alt="УралWeb"><'+'/a>');
//-->
</script>

<noscript>
<a href="http://www.uralweb.ru/rating/go/{$CURRENT_ENV.regid}" rel="nofollow">
<img border="0" src="http://hc.uralweb.ru/hc/{$CURRENT_ENV.regid}?js=0" width="88" height="31" alt="УралWeb"></a>
</noscript>
<!-- конец кода счетчика УралWeb --> 
{elseif $CURRENT_ENV.site.domain == 'ufa1.ru'}
<!-- Начало кода счетчика УралWeb -->
<script language="JavaScript" type="text/javascript">
<!--
  uralweb_d=document;
  uralweb_a='';
  uralweb_a+='&r='+escape(uralweb_d.referrer);
  uralweb_js=10;
//-->
</script>
<script language="JavaScript1.1" type="text/javascript">
<!--
  uralweb_a+='&j='+navigator.javaEnabled();
  uralweb_js=11;
//-->
</script>
<script language="JavaScript1.2" type="text/javascript">
<!--
  uralweb_s=screen;
  uralweb_a+='&s='+uralweb_s.width+'*'+uralweb_s.height;
  uralweb_a+='&d='+(uralweb_s.colorDepth?uralweb_s.colorDepth:uralweb_s.pixelDepth);
  uralweb_js=12;
//-->
</script>
<script language="JavaScript1.3" type="text/javascript">
<!--
  uralweb_js=13;
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
uralweb_d.write('<a href="http://www.uralweb.ru/rating/go/ufa1" rel="nofollow">'+
'<img border="0" src="http://hc.uralweb.ru/hc/ufa1?js='+
uralweb_js+'&amp;rand='+Math.random()+uralweb_a+
'" width="88" height="31" alt="УралWeb"><'+'/a>');
//-->
</script>

<noscript>
<a href="http://www.uralweb.ru/rating/go/ufa1" rel="nofollow">
<img border="0" src="http://hc.uralweb.ru/hc/ufa1?js=0" width="88" height="31" alt="УралWeb"></a>
</noscript>
<!-- конец кода счетчика УралWeb -->
{/if}
</td>
	{if $CURRENT_ENV.site.domain == '116.ru'}
	<td><a href="http://www.tatarstan.net/" target="_blank" rel="nofollow"><img src=http://www.tatarstan.net/cgi-bin/counters/gcount.pl?act=vis&typ=3&id=6364 width=88 height=31 border=0 alt="Tatarstan.Net - все сайты Татарстана"></a></td>
	{/if}
	<td><a target="_blank" href="http://top100.rambler.ru/cgi-bin/stats_top100.cgi?id={$CURRENT_ENV.site.rambler_id}&page=2&subpage=2&datarange=0&site=1" rel="nofollow"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-gray2.gif" alt="Rambler's Top100" width=88 height=31 border=0></a></td>
	<td>

{if in_array($CURRENT_ENV.regid,array(86,89,174,163,102,193,0))}
	<a href="http://www.liveinternet.ru/click" rel="nofollow" target=_blank><img src="http://counter.yadro.ru/logo?14.1" border=0 width="88" height="31" alt="liveinternet.ru" ></a>
{else}
<!--LiveInternet logo--><a href="http://www.liveinternet.ru/click;{if in_array($CURRENT_ENV.regid,array(2,16,61,34,72,59,63,74))}{if $CURRENT_ENV.regid==2}02{else}{$CURRENT_ENV.regid}{/if}{else}r{$CURRENT_ENV.regid}{/if}"
target="_blank"><img src="http://counter.yadro.ru/logo;{if in_array($CURRENT_ENV.regid,array(2,16,61,34,72,59,63,74))}{if $CURRENT_ENV.regid==2}02{else}{$CURRENT_ENV.regid}{/if}{else}r{$CURRENT_ENV.regid}{/if}?14.1"
title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня"
alt="" border="0" width="88" height="31"/></a><!--/LiveInternet--> 
	{/if}                                                                                                           
</td>

{if $CURRENT_ENV.site.domain == '74.ru' && $CURRENT_ENV.section == 'job'}
	<td>
<!-- Начало кода счетчика УралWeb -->
<script language="JavaScript" type="text/javascript">
<!--
  uralweb_d=document;
  uralweb_a='';
  uralweb_a+='&r='+escape(uralweb_d.referrer);
  uralweb_js=10;
//-->
</script>
<script language="JavaScript1.1" type="text/javascript">
<!--
  uralweb_a+='&j='+navigator.javaEnabled();
  uralweb_js=11;
//-->
</script>
<script language="JavaScript1.2" type="text/javascript">
<!--
  uralweb_s=screen;
  uralweb_a+='&s='+uralweb_s.width+'*'+uralweb_s.height;
  
uralweb_a+='&d='+(uralweb_s.colorDepth?uralweb_s.colorDepth:uralweb_s.pixelDepth);
  uralweb_js=12;
//-->
</script>
<script language="JavaScript1.3" type="text/javascript">
<!--
  uralweb_js=13;
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
uralweb_d.write('<a href="http://www.uralweb.ru/rating/go/job-74" rel="nofollow">'+
'<img border="0" src="http://hc.uralweb.ru/hc/job-74?js='+
uralweb_js+'&amp;rand='+Math.random()+uralweb_a+
'" width="88" height="31" alt="УралWeb"><'+'/a>');
//-->
</script>

<noscript>
<a href="http://www.uralweb.ru/rating/go/job-74" rel="nofollow">
<img border="0" src="http://hc.uralweb.ru/hc/job-74?js=0" width="88" 
height="31" alt="УралWeb"></a>
</noscript>
<!-- конец кода счетчика УралWeb -->
	</td>
{/if}
{if $CURRENT_ENV.site.domain == 'mgorsk.ru'}
<td>
<!-- Начало кода счетчика УралWeb -->
<script language="JavaScript" type="text/javascript">
<!--
  uralweb_d=document;
  uralweb_a='';
  uralweb_a+='&r='+escape(uralweb_d.referrer);
  uralweb_js=10;
//-->
</script>
<script language="JavaScript1.1" type="text/javascript">
<!--
  uralweb_a+='&j='+navigator.javaEnabled();
  uralweb_js=11;
//-->
</script>
<script language="JavaScript1.2" type="text/javascript">
<!--
  uralweb_s=screen;
  uralweb_a+='&s='+uralweb_s.width+'*'+uralweb_s.height;
  
uralweb_a+='&d='+(uralweb_s.colorDepth?uralweb_s.colorDepth:uralweb_s.pixelDepth);
  uralweb_js=12;
//-->
</script>
<script language="JavaScript1.3" type="text/javascript">
<!--
  uralweb_js=13;
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
uralweb_d.write('<a href="http://www.uralweb.ru/rating/go/mgorsk" rel="nofollow">'+
'<img border="0" src="http://hc.uralweb.ru/hc/mgorsk?js='+
uralweb_js+'&amp;rand='+Math.random()+uralweb_a+
'" width="88" height="31" alt="УралWeb" /><'+'/a>');
//-->
</script>

<noscript>
<a href="http://www.uralweb.ru/rating/go/mgorsk" rel="nofollow">
<img border="0" src="http://hc.uralweb.ru/hc/mgorsk?js=0" width="88" 
height="31" alt="УралWeb" /></a>
</noscript>
<!-- конец кода счетчика УралWeb -->
</td>
{/if}

</tr>
</table>
</nobr></noindex><!--/noindex-->

					</td>
				</tr>
			</table>
	</td>
</tr>
</table>
{if $CURRENT_ENV.regid == '61'}
<script language="JavaScript" type="text/javascript" 
src="http://js.ru.redtram.com/n4p/1/6/161.ru.neb_ai.js"></script>
{/if}
{if $CURRENT_ENV.regid == '74'}
<script type="text/javascript">{literal}
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
{/literal}</script>
<script type="text/javascript">{literal}
try {
var pageTracker = _gat._getTracker("UA-6052143-1");
pageTracker._trackPageview();
} catch(err) {}{/literal}</script>
{/if}
{if $CURRENT_ENV.regid == '174'}
<script type="text/javascript">{literal}
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
{/literal}</script>
<script type="text/javascript">{literal}
var pageTracker = _gat._getTracker("UA-6052143-5");
pageTracker._trackPageview();
{/literal}</script>
{/if}
{if $CURRENT_ENV.regid == '63'}
<script type="text/javascript">{literal}
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-9507399-1");
pageTracker._trackPageview();
} catch(err) {}{/literal}</script>
{/if}
{if $CURRENT_ENV.regid == '102'}
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-13040331-1");
pageTracker._trackPageview();
} catch(err) {}</script>
{/literal}
{/if}
{include file="modules/seo/clickheat.tpl"}
</body>
</html>
