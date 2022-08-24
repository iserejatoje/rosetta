{*{if $CURRENT_ENV.site.domain == 'domchel.ru' && $CURRENT_ENV.section=="comp"}
	{include file="design/200710_dom/common/a_banner_domchel_comp.tpl"}
{/if}*}
{*{if $CURRENT_ENV.site.domain == 'chel.ru'}
	<div align="center" style="padding: 10px;"><noindex><a href="http://korotron.ru/" target="_blank"><img src="/_img/themes/misc/banner_maket_korotron_1.gif" width="450" height="60" border="0" alt="" /></a></noindex></div>
{/if}*}
{if $CURRENT_ENV.site.domain == 'domchel.ru'}
	<div style="padding: 10px;"><noindex>{banner_v2 id="1478"}</noindex></div>
{elseif in_array($CURRENT_ENV.site.domain, array('cheldoctor.ru', '102doctora.ru', '116doctor.ru', '34doctora.ru', 'doctor59.ru', '72doctor.ru', '161doctor.ru', 'doctor63.ru'))}
	<div style="padding: 10px;"><noindex>{banner_v2 id="3571"}</noindex></div>
{elseif in_array($CURRENT_ENV.site.domain, array("autochel.ru","102km.ru","116auto.ru","34auto.ru","avto59.ru","161auto.ru","doroga63.ru","72avto.ru"))}
	<div style="padding: 10px;"><noindex>{banner_v2 id="4003"}</noindex></div>
{elseif in_array($CURRENT_ENV.site.domain, array("chelfin.ru","102banka.ru","116dengi.ru","34banka.ru","dengi59.ru","161bank.ru","dengi63.ru","72dengi.ru"))}
	<div style="padding: 10px;"><noindex>{banner_v2 id="1317"}</noindex></div>
{else}
	{if in_array($CURRENT_ENV.section, array('newsline_dom','articles','hints','design'))}
		{banner_v2 id="3843"}
	{elseif in_array($CURRENT_ENV.section, array('newsline_auto','autostop','pdd','accident','car','opinion','poputchik'))}
		{banner_v2 id="3897"}
	{elseif in_array($CURRENT_ENV.section, array('exchange','newsline_fin','tech','skills','credit','news_fin','predict','poll_fin'))}
		{banner_v2 id="3974"}
	{elseif in_array($CURRENT_ENV.section, array('afisha','weekfilm','wedding','starspeak','travel','inspect','love','horoscope','dream'))}
		{banner_v2 id="3940"}
	{else}
		{banner_v2 id="3796"}
	{/if}
{/if}