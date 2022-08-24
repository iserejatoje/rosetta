{if $CURRENT_ENV.regid==24}{assign var="directid" value="43210"}{/if}
{if $CURRENT_ENV.regid==26}{assign var="directid" value="10833"}{/if}
{if $CURRENT_ENV.regid==29}{assign var="directid" value="19331"}{/if}
{if $CURRENT_ENV.regid==35}{assign var="directid" value="38832"}{/if}
{if $CURRENT_ENV.regid==38}{assign var="directid" value="19333"}{/if}
{if $CURRENT_ENV.regid==42}{assign var="directid" value="19335"}{/if}
{if $CURRENT_ENV.regid==43}{assign var="directid" value="36247"}{/if}
{if $CURRENT_ENV.regid==45}{assign var="directid" value="19337"}{/if}
{if $CURRENT_ENV.regid==48}{assign var="directid" value="19339"}{/if}
{if $CURRENT_ENV.regid==51}{assign var="directid" value="19344"}{/if}
{if $CURRENT_ENV.regid==56}{assign var="directid" value="19346"}{/if}
{if $CURRENT_ENV.regid==62}{assign var="directid" value="19354"}{/if}
{if $CURRENT_ENV.regid==66}{assign var="directid" value="19359"}{/if}
{if $CURRENT_ENV.regid==68}{assign var="directid" value="38828"}{/if}
{if $CURRENT_ENV.regid==70}{assign var="directid" value="19361"}{/if}
{if $CURRENT_ENV.regid==71}{assign var="directid" value="19363"}{/if}
{if $CURRENT_ENV.regid==76}{assign var="directid" value="19365"}{/if}
{if $CURRENT_ENV.regid==78}{assign var="directid" value="43209"}{/if}
{if $CURRENT_ENV.regid==86}{assign var="directid" value="30009"}{/if}
{if $CURRENT_ENV.regid==89}{assign var="directid" value="30007"}{/if}
{if $CURRENT_ENV.regid==93}{assign var="directid" value="38830"}{/if}
{if $CURRENT_ENV.regid==174}{assign var="directid" value="44222"}{/if}
{if $CURRENT_ENV.regid==163}{assign var="directid" value="46346"}{/if}
{if !empty($directid)}
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = {/literal}{$directid}{literal};
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'vertical';
yandex_direct_border_type = 'ad';
yandex_direct_limit = 4;
yandex_direct_header_bg_color = 'EDF6F8';
yandex_direct_bg_color = 'EDF6F8';
yandex_direct_border_color = 'E0F3F3';
yandex_direct_title_color = '005A52';
yandex_direct_url_color = '000000';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'BBC6C1';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}