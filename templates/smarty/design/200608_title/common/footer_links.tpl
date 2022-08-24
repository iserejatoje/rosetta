{assign var="twitter_link" value=""}

{if $CURRENT_ENV.regid == 74}
	{assign var="twitter_link" value="_74ru_"}
{elseif $CURRENT_ENV.regid == 2}
	{assign var="twitter_link" value="ufa1ru"}
{elseif $CURRENT_ENV.regid == 16}
	{assign var="twitter_link" value="116ru"}
{elseif $CURRENT_ENV.regid == 29}
	{assign var="twitter_link" value="_29ru_"}
{elseif $CURRENT_ENV.regid == 34}
	{assign var="twitter_link" value="_v1ru_"}
{elseif $CURRENT_ENV.regid == 45}
	{assign var="twitter_link" value="45ru"}
{elseif $CURRENT_ENV.regid == 56}
	{assign var="twitter_link" value="56ru"}
{elseif $CURRENT_ENV.regid == 59}
	{assign var="twitter_link" value="59ru"}
{elseif $CURRENT_ENV.regid == 61}
	{assign var="twitter_link" value="161ru"}
{elseif $CURRENT_ENV.regid == 63}
	{assign var="twitter_link" value="63ru"}
{elseif $CURRENT_ENV.regid == 64}
	{assign var="twitter_link" value="164ru"}
{elseif $CURRENT_ENV.regid == 72}
	{assign var="twitter_link" value="72ru"}
{elseif $CURRENT_ENV.regid == 76}
	{assign var="twitter_link" value="76ru"}
{elseif $CURRENT_ENV.regid == 93}
	{assign var="twitter_link" value="93ru"}
{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="94%" class="footer_links">
	Copyright &#169; {2001|copyright_date}. <noindex><a href="{if $CURRENT_ENV.regid == '74'}http://info74.ru/{else}http://rugion.ru/stat/{/if}" target="_blank" class="footer_links" rel="nofollow">{$CURRENT_ENV.site.company}</a></noindex>.&nbsp;
	{if !empty($CURRENT_ENV.site.regdomain) && $CURRENT_ENV.site.legal_policy_show}
	<a href="/service/go/?url={"http://`$CURRENT_ENV.site.regdomain`/legal_policy/"|escape:"url"}" target="_blank" class="footer_links">Порядок и правила использования информации</a>.
	{/if}
	</td>
    <td width="100" rowspan="2">
	{if !empty($CURRENT_ENV.site.regdomain) && $CURRENT_ENV.site.rss_show}
		<table border="0" cellspacing="0" cellpadding="0" align="right">
			<tr>
				{if !empty($twitter_link) && $CURRENT_ENV.site.domain == $CURRENT_ENV.site.regdomain}
					<td style="padding-right: 8px;"><noindex><a target="_blank" href="http://twitter.com/{$twitter_link}" rel="nofollow"><img src="/_img/design/common/twitter_icon_24x24.gif" width="24" height="24" alt="Twitter" border="0" align="absmiddle" title="Twitter" /></a></noindex></td>
				{/if}
				<td><a href="/service/go/?url={"http://`$CURRENT_ENV.site.regdomain`/rss/"|escape:"url"}" title="RSS" target="_blank"><img border="0" src="/_img/modules/rss/feed_icon_24x24.gif{*/_img/modules/rss/feed_icon_12x12.gif*}" width="24" height="24" alt="RSS" style="margin-top:2px;margin-right:3px;"></a></td>
				{*<td style="padding-right:20px;"><a href="/service/go/?url={"http://`$CURRENT_ENV.site.regdomain`/rss/"|escape:"url"}" title="RSS" target="_blank" class="footer_links">RSS</a></td>*}
			</tr>
		</table>
	{/if}
	</td>
</tr>
<tr>
	<td class="footer_links">
		{if !empty($CURRENT_ENV.site.regdomain)}
			{if !empty($CURRENT_ENV.site.reklama_url)}
			{assign var="url_case" value=$CURRENT_ENV.site.reklama_url}
		{else}
			{if in_array($CURRENT_ENV.site.domain, array('38.ru','42.ru','43.ru','48.ru','51.ru','53.ru','154.ru','omsk1.ru','56.ru','tolyatty.ru','60.ru','62.ru','ekat.ru','68.ru','70.ru','71.ru','178.ru'))}
				{assign var="url_case" value="http://`$CURRENT_ENV.site.regdomain`/price/"}
			{else}
				{assign var="url_case" value="http://`$CURRENT_ENV.site.regdomain`/pages/reklama.html"}
			{/if}
		{/if}
		{if $CURRENT_ENV.regid == 74 && !empty($CURRENT_ENV.site.reklama_url) && strpos($CURRENT_ENV.site.reklama_url, 'info74.ru')}
			{assign var="fl_noindex" value=1}
		{else}
			{assign var="fl_noindex" value=0}
		{/if}
		{if $fl_noindex}<noindex>{/if}
		{if $CURRENT_ENV.site.domain=='chel.ru'}
		<a href="{$url_case}" target="_blank" class="footer_links_reklama" rel="nofollow">Реклама на сайте</a>.&nbsp;
		{else}
		<a href="{if !$fl_noindex}/service/go/?url={$url_case|escape:"url"}{else}{$url_case}{/if}" target="_blank" class="footer_links_reklama" rel="nofollow">Реклама на сайте</a>.&nbsp;
		{/if}
		{if $CURRENT_ENV.regid == 74}
			<a href="http://info74.ru/about/project" target="_blank" class="footer_links">О проекте</a>.&nbsp;
		{/if}
		{if $fl_noindex}</noindex>{/if}
		{if $CURRENT_ENV.site.wap_show}
		Мобильная версия: <a href="/service/go/?url={"http://`$CURRENT_ENV.site.regdomain`/help/mobile/"|escape:"url"}" target="_blank" class="footer_links">m.{$CURRENT_ENV.site.regdomain}</a>.&nbsp;
		{/if}
		<a href="/site_map/" target="_blank" class="footer_links">Карта сайта</a>.&nbsp;
		<font class="footer_links" style="cursor: pointer; text-decoration: underline;" title="Открыть" target="ublock" onclick="window.open('http://{if !empty($CURRENT_ENV.site.regdomain) && in_array($CURRENT_ENV.regid, array('02', '16', '24', '34', '55', '59', '61', '63', '72', '74'))}{$CURRENT_ENV.site.regdomain}{else}rugion.ru{/if}/feedback/?from={$CURRENT_ENV.sectionid}', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</font>.&nbsp;
		{if $CURRENT_ENV.regid == 72}
			<a href="/service/go/?url={"http://`$CURRENT_ENV.site.regdomain`/pages/about.html"|escape:"url"}" target="_blank" class="footer_links">О проекте {$CURRENT_ENV.site.regdomain}</a>.&nbsp;
		{/if}
		{if $CURRENT_ENV.site.team_show}
			{if $CURRENT_ENV.regid != '74'}{assign var="url_case1" value=$CURRENT_ENV.site.regdomain}{else}{assign var="url_case1" value=$CURRENT_ENV.site.domain}{/if}
			{if $CURRENT_ENV.regid != '74'}{assign var="url_case2" value=$CURRENT_ENV.regid}{else}{assign var="url_case2" value=''}{/if}
			<a href="/service/go/?url={"http://`$url_case1`/pages/team`$url_case2`.html"|escape:"url"}" target="_blank" class="footer_links">Команда</a>.
		{/if}
		<a href="/help/" target="_blank" class="footer_links">Помощь</a>.&nbsp;
	{/if}
	<br/>
	Увидели ошибку? Выделите текст и нажмите Ctrl + Enter
	</td>
</tr>
</table>