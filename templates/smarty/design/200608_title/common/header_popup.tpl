{if $params.with_doctype}
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{/if}
<html>
<head>
{php}
	App::$Title->AddStyle('/_styles/design/200608_title/common/styles.css');
	App::$Title->AddScript('/_scripts/design/200608_title/scripts.js');
{/php}
{$TITLE->Head}
</head>
<body>
<div style="position:absolute; top:0px; left: 0px; width: 1px; height:1px;"><noindex>
	{if $CURRENT_ENV.site.domain == '116.ru'}<img src="http://www.tatarstan.net/cgi-bin/counters/gcount.pl?act=wrk&id=6364" width="1" height="1" border="0" alt="" />{/if}
	<!--begin of Top100-->
	<a href="http://counter.rambler.ru/top100/" rel="nofollow"><img src="http://counter.rambler.ru/top100.cnt?{$CURRENT_ENV.site.rambler_id}" alt="Rambler's Top100 Service" width=1 height=1 border=0></a>
	<!--end of Top100 code-->

		<!--LiveInternet counter--><script type="text/javascript"><!--
		new Image().src = "http://counter.yadro.ru/hit;{if in_array($CURRENT_ENV.regid,array(2,16,61,34,72,59,63,163,74,174,86,89,102))}{if $CURRENT_ENV.regid==163}63{elseif $CURRENT_ENV.regid==174}74{elseif $CURRENT_ENV.regid==86 || $CURRENT_ENV.regid==89}72{elseif $CURRENT_ENV.regid==2 || $CURRENT_ENV.regid==102}02{else}{$CURRENT_ENV.regid}{/if}{else}r{if $CURRENT_ENV.regid==193}93{else}{$CURRENT_ENV.regid}{/if}{/if}?r"+
		escape(document.referrer)+((typeof(screen)=="undefined")?"":
		";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
		screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
		";"+Math.random();//--></script><!--/LiveInternet-->

{*        <!--LiveInternet counter-->
        <script type='text/javascript' language='JavaScript'><!--
				document.write('<img src="http://counter.yadro.ru/hit?r'+
				escape(document.referrer)+((typeof(screen)=='undefined')?'':
				';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
				screen.colorDepth:screen.pixelDepth))+';'+Math.random()+
				'" width=1 height=1 alt="">')//--></script>
        <!--/LiveInternet-->*}

<!-- Yandex.Metrika --><script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
<div style="display:none;"><script type="text/javascript">{literal}
try { var yaCounter1172222 = new Ya.Metrika(1172222); } catch(e){}
{/literal}</script></div>
<noscript><div style="position:absolute"><img src="//mc.yandex.ru/watch/1172222" alt="" /></div></noscript><!-- /Yandex.Metrika -->
	{*<!-- SpyLOG -->
	<script src="http://tools.spylog.ru/counter2.2.js"  type='text/javascript' language='JavaScript' id="spylog_code" counter="995740" ></script>
	<!--/ SpyLOG -->*}
</noindex></div>