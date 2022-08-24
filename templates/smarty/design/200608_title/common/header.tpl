<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

{php}
	if (in_array(App::$CurrentEnv['regid'],array(63,59,72,2,34,16,61))) 
	{
		App::$Title->Add('link', array(
		    'rel' => 'alternate',
		    'href' => 'http://'.App::$CurrentEnv['site']['domain'].'/rss/type/'.App::$CurrentEnv['site']['domain'].'/news.xml',
		    'title' => App::$CurrentEnv['site']['domain'].' - Новости и статьи',
		    'type' => 'application/rss+xml',
		    ));
	}
	App::$Title->AddStyle('/_styles/design/200608_title/common/styles.css');
	App::$Title->AddScript('/_scripts/design/200608_title/scripts.js');
{/php}

{$TITLE->Head}

{*<link rel="stylesheet" type="text/css" href="/_styles/design/200608_title/common/styles.css" />
<script type="text/javascript" language="javascript" src="/_scripts/design/200608_title/scripts.js"></script>

{if in_array($CURRENT_ENV.regid,array(63,59,72,2,34,16,61))}
<link rel="alternate" type="application/rss+xml" title="{$CURRENT_ENV.site.domain} - Новости и статьи" href="http://{$CURRENT_ENV.site.domain}/rss/type/{$CURRENT_ENV.site.domain}/news.xml" />
{/if}*}

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


{if $BLOCKS.header.sitebar}{$BLOCKS.header.sitebar}{/if}
{include file="design/200608_title/common/a_remind.tpl"}
<table style="height:100%;" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
	<td{* colspan="{$__page_cols}"*}>
{* НЕ форумы, почта, карта, помощь, отправить заявку *}
{if !in_array($CURRENT_ENV.sectioninfo.module, array('themes','mail_v2','map_yandex','map_google','help')) && !in_array($CURRENT_ENV.section, array('claim', 'price', 'passport')) && strpos($CURRENT_ENV.section, 'social')!==0  && strpos($CURRENT_ENV.section, 'passport') === false}
<div align="center" style="padding: 1px 0px 1px 0px;">


{if in_array($CURRENT_ENV.section, array('newsline_dom','articles','realty','hints','design','expert'))}

	{banner_v2 id="4027"}
	<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr align="center">
			<td>{banner_v2 id="1578"}</td>
			<td>{banner_v2 id="3815"}</td>
		</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('newsline_auto','autostop','pdd','accident','car','opinion','poputchik'))}

	{banner_v2 id="1504"}
	<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr align="center">
		<td>{banner_v2 id="1667"}</td>
		<td>{banner_v2 id="3877"}</td>
	</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('exchange','newsline_fin','tech','skills','credit','news_fin','predict','poll_fin'))}

	{banner_v2 id="1670"}
	<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr align="center">
		<td>{banner_v2 id="3941"}</td>
		<td>{banner_v2 id="3942"}</td>
	</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('afisha','weekfilm','wedding','starspeak','travel','inspect','love','horoscope','dream'))}

	{banner_v2 id="4038"}
	<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr align="center">
		<td>{banner_v2 id="3912"}</td>
		<td>{banner_v2 id="3913"}</td>
	</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('job'))}
		{banner_v2 id="651"}
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr align="center"><td>{banner_v2 id="3786"}</td><td>{banner_v2 id="3787"}</td></tr>
		</table>

{elseif in_array($CURRENT_ENV.section, array('weather'))}
	{banner_v2 id="1726"}
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td width="50%">{banner_v2 id="3788"}</td>
		<td width="50%">{banner_v2 id="3789"}</td>
	</tr>
	</table>
	
{elseif in_array($CURRENT_ENV.section, array('forum'))}
	{banner_v2 id="4041"}
		
{elseif in_array($CURRENT_ENV.sectioninfo.module, array('board','video','firms','shedule','poll_v2','search_sphinx_v2','contest','consult_v2','conference','site_map','info_page','gallery','lostfound')) || in_array($CURRENT_ENV.section, array('radio','competition'))}
	{banner_v2 id="2842"}
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td width="50%">{banner_v2 id="3850"}</td>
		<td width="50%">{banner_v2 id="3851"}</td>
	</tr>
	</table>
{else}

	{banner_v2 id="2118"}
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td width="50%">{banner_v2 id="1900"}</td>
		<td width="50%">{banner_v2 id="1983"}</td>
	</tr>
	</table>

{/if}
</div>
{/if}

{$block_script}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td valign="middle" align="center">
	<a href="http://{$CURRENT_ENV.site.regdomain}/" target="_blank">{*if isset($BLOCKS.header.logo) && $BLOCKS.header.logo !== false}{$BLOCKS.header.logo}{else*}<img src="/_img/design/200608_title/logo/logo.{$CURRENT_ENV.site.domain}.gif" border="0" alt="" title="" width="150" height="60" />{*/if*}</a>
    </td>
    <td width="100%" bgcolor="#FFFFFF" >
      <table width="100%" cellpadding="0" cellspacing="0" border="0">
{if $CURRENT_ENV.regid>0}
        <tr>
          <td width="30" bgcolor="#FFFFFF">&nbsp;</td>
          <td colspan="2" valign="bottom" width="100%" class="bg_color1" style="height: 20px;">
			{* Menu top begin *}
				{if $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.regdomain`/common/header_menu_top.tpl")}
					{include file="design/199801_title_main/`$CURRENT_ENV.site.regdomain`/common/header_menu_top.tpl"}
				{elseif isset($BLOCKS.header.header_menu_top)}
					{$BLOCKS.header.header_menu_top}
				{else}
					{* меню по умолчанию *}
					{include file="design/200608_title/common/header_menu_top_default.tpl"}
				{/if}
			{* Menu top end *}
		</td>
        </tr>
{/if}
        <tr>
          <td width="30" bgcolor="#FFFFFF"></td>
          <td width="30" height="100%" class="bg_color2">&#160;</td>
          <td width="100%" rowspan="3" class="bg_color2" valign="middle">
				{* Header content begin *}
				{if $CURRENT_ENV.section=='job_magic' || $CURRENT_ENV.section=='job'}
					{include file="design/200608_title/common/header_content_job_magic.tpl"}
				{elseif $CURRENT_ENV.section=='passport' || strpos($CURRENT_ENV.section, 'user') === 0}
					{include file="design/200608_title/common/header_content_passport.tpl"}
				{elseif $CURRENT_ENV.section=='search' || $CURRENT_ENV.section=='search_v2'}
					{include file="design/200608_title/common/header_content_search.tpl"}
				{elseif $CURRENT_ENV.section=='svoi'}
					{include file="design/200608_title/common/header_content_social.tpl"}				
				{else}
					{include file="design/200608_title/common/header_content_default.tpl"}
				{/if}
				{* Header content end *}
          </td>
        </tr>
        <tr>
          <td height="60" width="60" colspan="2" background="/_img/design/200608_title/logo_bg.gif">{
			if $CURRENT_ENV.section=='job'}<img style="padding-top:0px;margin:0px;" src="/_img/design/200608_title/logo_themes/logo_job_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Работа" title="{$CURRENT_ENV.site.domain} - Работа" />{
			elseif $CURRENT_ENV.section=='tours'}<img src="/_img/design/200608_title/logo_themes/logo_tours_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Туры" title="{$CURRENT_ENV.site.domain} - Туры" />{
			elseif $CURRENT_ENV.section=='baraholka'}<img src="/_img/design/200608_title/logo_themes/logo_board_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Барахолка" title="{$CURRENT_ENV.site.domain} - Барахолка" />{
			elseif $CURRENT_ENV.section=='buronahodok'}<img src="/_img/design/200608_title/logo_themes/logo_buronahodok_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Бюро находок" title="{$CURRENT_ENV.site.domain} - Бюро находок" />{
			elseif $CURRENT_ENV.section=='video'}<img src="/_img/design/200608_title/logo_themes/logo_video_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Видео" title="{$CURRENT_ENV.site.domain} - Видео" />{
			elseif $CURRENT_ENV.section=='radio'}<img src="/_img/design/200608_title/logo_themes/logo_radio_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Радио" title="{$CURRENT_ENV.site.domain} - Радио" />{
			elseif $CURRENT_ENV.section=='mail'}<img src="/_img/design/200608_title/logo_themes/logo_mail_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Почта" title="{$CURRENT_ENV.site.domain} - Почта" />{
			elseif $CURRENT_ENV.section=='search' || $CURRENT_ENV.section=='search_sphinx'}<img src="/_img/design/200608_title/logo_themes/logo_search_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Поиск" title="{$CURRENT_ENV.site.domain} - Поиск" />{
			elseif $CURRENT_ENV.section=='weather' || $CURRENT_ENV.section=='weather_magic'}<img src="/_img/design/200608_title/logo_themes/logo_weather_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Погода" title="{$CURRENT_ENV.site.domain} - Погода" />{
			elseif $CURRENT_ENV.section=='utro'}<img src="/_img/design/200608_title/logo_themes/logo_weather_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Утро с 74.ru" title="{$CURRENT_ENV.site.domain} -  Утро с 74.ru" />{
			elseif $CURRENT_ENV.section=='horoscope'}<img src="/_img/design/200608_title/logo_themes/logo_horoscope_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Гороскоп" title="{$CURRENT_ENV.site.domain} - Гороскоп" />{
			elseif $CURRENT_ENV.section=='dnevniki' || $CURRENT_ENV.section=='diaries' }<img src="/_img/design/200608_title/logo_themes/logo_dnevniki_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Дневники" title="{$CURRENT_ENV.site.domain} - Дневники" />{
			elseif strpos($CURRENT_ENV.section,"blogs")>0 || $CURRENT_ENV.section=='svoi'}<img src="/_img/design/200608_title/logo_themes/logo_dnevniki_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Блоги" title="{$CURRENT_ENV.site.domain} - Блоги" />{
			elseif $CURRENT_ENV.section=='forum'}<img src="/_img/design/200608_title/logo_themes/logo_forum_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Форум" title="{$CURRENT_ENV.site.domain} - Форум" />{
			elseif $CURRENT_ENV.section=='passport' || strpos($CURRENT_ENV.section, 'passport') !== false}<img src="/_img/design/200608_title/logo_themes/logo_forum_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Паспорт" title="{$CURRENT_ENV.site.domain} - Паспорт" />{
			elseif $CURRENT_ENV.section=='social'}<img src="/_img/design/200608_title/logo_themes/logo_forum_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Социальная сеть" title="{$CURRENT_ENV.site.domain} - Социальная сеть" />{
			elseif $CURRENT_ENV.section=='poll' || $CURRENT_ENV.section=='help'}<img src="/_img/design/200608_title/logo_themes/logo_poll_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Опрос" title="{$CURRENT_ENV.site.domain} - Опрос" />{
			elseif $CURRENT_ENV.section=='map'}<img src="/_img/design/200608_title/logo_themes/logo_map_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Карта" title="{$CURRENT_ENV.site.domain} - Карта" />{
			elseif $CURRENT_ENV.section=='legal_policy'}<img src="/_img/design/200608_title/logo_themes/logo_text_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Правовое соглашение" title="{$CURRENT_ENV.site.domain} - Правовое соглашение" />{
			elseif $CURRENT_ENV.section=='consult'}<img src="/_img/design/200608_title/logo_themes/logo_poll_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Онлайн-консультация" title="{$CURRENT_ENV.site.domain} - Онлайн-консультация" />{
			elseif $CURRENT_ENV.section=='schedule'}<img src="/_img/design/200608_title/logo_themes/logo_shedule_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Расписания" title="{$CURRENT_ENV.site.domain} - Расписания" />{
			elseif $CURRENT_ENV.section=='change'
			|| $CURRENT_ENV.section=='sale'
			|| $CURRENT_ENV.section=='rent'
			|| $CURRENT_ENV.section=='commerce'
			|| $CURRENT_ENV.section=='users'}<img src="/_img/design/200608_title/logo_themes/logo_text_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain} - Недвижимость" title="{$CURRENT_ENV.site.domain} - Недвижимость" />{
			else}<img src="/_img/design/200608_title/logo_themes/logo_text_60x60.gif" width="60" height="60" border="0" alt="{$CURRENT_ENV.site.domain}" title="{$CURRENT_ENV.site.domain}" />{/if}</td>
        </tr>
        <tr>
          <td width="30" bgcolor="#FFFFFF"></td>
          <td width="30" height="100%" class="bg_color2"></td>
        </tr> 
        
		<!-- Header menu bottom begin -->
		{if isset($BLOCKS.header.header_menu_bottom)}
        <tr>
			<td valign="bottom" bgcolor="#FFFFFF" >&nbsp;</td>
			<td colspan="2" valign="bottom" class="bg_color2">
				{$BLOCKS.header.header_menu_bottom}
          </td>
        </tr>
		{else}
		<tr>
			<td valign="bottom" bgcolor="#FFFFFF" >&nbsp;</td>
			<td colspan="2" valign="bottom" class="bg_color2">
				<br/>
          </td>
        </tr>
		{/if}
		<!-- Header menu bottom end -->
		
      </table>
    </td>
  </tr>
</table>

{if ($CURRENT_ENV.site.domain=='161.ru' && $CURRENT_ENV.section=='map') || ($CURRENT_ENV.section!='passport' && $CURRENT_ENV.section!='help' && $CURRENT_ENV.section!='map' && strpos($CURRENT_ENV.section, 'social')!==0 && strpos($CURRENT_ENV.section, 'passport') === false)}
	{if $SMARTY->is_template("design/200608_title/common/under_header_banner.tpl")}
		{include file="design/200608_title/common/under_header_banner.tpl"}
	{elseif isset($BLOCKS.header.under_header_banner)}
		{$BLOCKS.header.under_header_banner}
	{else}
		<div style="height:5px;overflow:hidden">&nbsp;</div>	
	{/if}

	{if isset($BLOCKS.header.razdel_line)}
		{$BLOCKS.header.razdel_line}
	{/if}
{else}
	<br />
{/if}
	</td>
</tr>