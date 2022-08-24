{*if $CURRENT_ENV.regid == 74 && $USER->ID != 1}
<script id="ig74_sr" charset="windows-1251"></script>
<script charset="windows-1251"><!--//
{literal}
//var ig74_direct_titleColor = '004D4E';
//var ig74_direct_siteurlColor = '888888';
//var ig74_market_offerlinkColor = '004D4E';

var ig74_r = Math.round(Math.random() * 100000);
var ig74_q='{/literal}{$page.form.params.query}{literal}';
var ig74_h='http://74.ru/direct/code?text='+ig74_q+'&p={/literal}{$page.form.params.page}{literal}&r='+ig74_r+'&d='+document.domain;
if(document.getElementById){
	setTimeout(
		function(){
			document.getElementById('ig74_sr').src=ig74_h;
		},10
	)
}
{/literal}
--></script>
{elseif $USER->ID == 1*}
{*if $CURRENT_ENV.regid == 74*}
<script id="ig74_sr" charset="windows-1251"></script>
<script charset="windows-1251"><!--//
{literal}

$(document).ready(function() {
	var ig74_r = Math.round(Math.random() * 100000);
	var ig74_q='{/literal}{$page.form.params.query}{literal}';

	document.getElementById('ig74_sr').src = 
		'/service/direct/show.html?q='+ig74_q+'&r='+ig74_r+'&rid={/literal}{$CURRENT_ENV.regid}{literal}&d='+document.domain;
});

{/literal}
//--></script>
{*/if*}

{php}
$this->_tpl_vars['yandex_direct'] = array(
	2 => 19328,
	16 => 30012,
	24 => 43211,
	26 => 36246,
	29 => 19332,
	34 => 30011,
	35 => 38833,
	38 => 19334,
	42 => 19336,
	43 => 36273,
	45 => 19338,
	48 => 19340,
	51 => 19345,
	55 => 36245,
	56 => 19347,
	59 => 1547,
	61 => 19349,
	62 => 19356,
	63 => 1546,
	64 => 56472,
	66 => 19360,
	68 => 38829,
	70 => 19362,
	71 => 19364,
	72 => 30006,
	74 => 1356,
	76 => 19366,
	78 => 37343,
	86 => 30010,
	89 => 30008,
	93 => 38831,
	174 => 44223,
	163 => 46345
);
{/php}

{if isset($yandex_direct[$CURRENT_ENV.regid])}
<script type="text/javascript">
<!--
{literal}

// Размер шрифтов
var yandex_ad_fontSize = 1;

// Настройки Спец. размещения
var yandex_premium_BgColor = 'EDF6F8';
var yandex_premium_fontColor = '000000';
var yandex_premium_titleColor = '005581';
var yandex_premium_siteurlColor = '888888';
function yandex_premium_print(){ }

// Настройки объявлений Директа
var yandex_direct_fontColor = '000000';
var yandex_direct_BgColor = 'F5F5F5';
var yandex_direct_titleColor = '005581';
var yandex_direct_siteurlColor = '888888';
var yandex_direct_linkColor = '005581';
var yandex_direct_BorderColor = 'FFFFFF';
var yandex_direct_favicon = true;
function yandex_direct_print(){}

// Настройки объявлений Маркета
var yandex_market_fontColor = '000000';
var yandex_market_BgColor = 'F5F5F5';
var yandex_market_catColor = '666666';
var yandex_market_offerlinkColor = '005581';
var yandex_market_linkColor = '005581';
var yandex_market_BorderColor = 'FFFFFF';
var yandex_market_headerBgColor = 'FFFFFF';
function yandex_market_print(){}

var yandex_r = Math.round(Math.random() * 100000);
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/code/{/literal}{$yandex_direct[$CURRENT_ENV.regid]}{literal}?rnd=' + yandex_r + '&text={/literal}{$page.form.params.query|escape:"url"}{literal}&page-no={/literal}{$page.form.params.page}{literal}"></'+'sc'+'ript>');
{/literal}
//--></script>
{else}
<script type="text/javascript"><!--
{literal}
function yandex_premium_print(){}
function yandex_direct_print(){}
function yandex_market_print(){}
{/literal}
//--></script>
{/if}

{*if $UERROR->GetErrorByIndex('result') != ''}


<table width="100%" cellpadding="20" cellspacing="0" border="0">
	<tr>
		<td class="error" align="center"><span>{$UERROR->GetErrorByIndex('result')}</span></td>
	</tr>
</table>

{else*}
<script type="text/javascript" language="javascript">
{literal}
<!--
var hint_obj = document.getElementById('hint');
var hint_text = document.getElementById('hint_text');
var hint_t1 = '';
var hint_t2 = '';


function r(w, a) {
    var unique = new Date().getTime();
    var path = a ? a.href : document.location;
    document.createElement('IMG').src = 'http://clck.yandex.ru/click/dtype=' + w + '/u=' + unique + '/*' + path; 
}

function HintInit()
{
	if(hint_t1 != '')
	{
		HintHide();
		hint_obj.style.display = 'block';
	}
}
function HintShow()
{
	hint_text.innerHTML = hint_t2 + '<span style="cursor:pointer; cursor:hand;" title="Свернуть" onclick="HintHide();"><u>&lt;&lt;</u></span>';
}
function HintHide()
{
	hint_text.innerHTML = hint_t1;
	if(hint_t2 != '')
		hint_text.innerHTML = hint_text.innerHTML + '<span style="cursor:pointer; cursor:hand;" title="Развернуть" onclick="HintShow();"><u>&gt;&gt;</u></span>';
}

HintInit();

//-->
{/literal}
</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td width="75%" style="padding-left:20px;">

			<table id="hint" width="100%" cellpadding="0" cellspacing="0" border="0" style="display:none; margin-bottom: 5px;">
				<tr valign="top" align="left">
					<td width="15px"><img src="/_img/design/200608_title/common/exclamation.gif" style="margin-top:1px;" width="11" height="11" border="0" /></td>
					<td id="hint_text" style="font-size:11px; color: #555555;"></td>
				</tr>
			</table>
			
	<div style="float:left;padding-top: 11px;"><a href="javascript:void(0);" class="search_params_ref" onclick="ToggleParams()">{if $page.form.params.adv_params == 0}Ещё настройки{else}Скрыть настройки{/if}</a></div>
	{if $page.results.groups > 0}
	<div style="float:right;background-color:#EDEDED;padding: 8px 4px 7px 3px;">
		{if $page.results.engine=="Yandex_XML"}
			<noindex><a href="http://yandex.ru/" target="_blank" rel="nofollow"><img style="vertical-align:bottom;" src="http://data.yandex.ru/i?ctype=4&path=h12810750_yandex_rb.png" border="0" hspace="5" /></a> нашел <b>{$page.results.count.all|number_format:0:",":" "}</b> по "<b>{$page.form.params.query}</b>"</noindex>
		{else}
			Результата <b>{$page.results.count.all|number_format:0:",":" "}</b> по "<b>{$page.form.params.query}</b>"
		{/if}
	</div>
	{/if}		
	<div style="clear:both"></div>
	

			{*if in_array($CURRENT_ENV.regid, array(74))*}
			<div style="display:block;" id="ig74_elite"></div>
			{*/if*}
			
			<div class="query_params"{if $page.form.params.adv_params == 0} style="display:none"{/if}>
				<ul>
					<li class="item_title">Где искать:</li>		
					
					{foreach from=$page.form.params.arr_t item=l key=k}
					{if $k==$page.form.params.tag}
					<li class="active">»&nbsp;{$l}</li>
					{else}
					<li class="item_link"><a href="/{$CURRENT_ENV.section}/search.php?sortby={$page.form.params.sortby}&where={$page.form.params.where}&query={$page.form.params.query}&a_in={$page.form.params.a_in}&a_spell={$page.form.params.a_spell}&a_t={$k}&a_c={$page.form.params.a_c}&adv_params=1">{$l}</a></li>
					{/if}
					{/foreach}					
					
					<li class="item_title" style="padding-top: 25px;">Как искать:</li>
					{foreach from=$page.form.params.arr_spell item=l key=k}
					{if $k==$page.form.params.a_spell}
					<li class="active">»&nbsp;{$l}</li>
					{else}
					<li class="item_link"><a href="/{$CURRENT_ENV.section}/search.php?sortby={$page.form.params.sortby}&where={$page.form.params.where}&query={$page.form.params.query}&a_in={$page.form.params.a_in}&a_spell={$k}&a_t={$page.form.params.tag}&a_c={$page.form.params.a_c}&adv_params=1">{$l}</a></li>
					{/if}
					{/foreach}	
					
					<li class="item_title" style="padding-top: 25px;">Сайт:</li>
					{if $page.form.params.a_c == 0}
					<li class="active">»&nbsp;Любой</li>
					{else}
					<li class="item_link"><a href="/{$CURRENT_ENV.section}/search.php?sortby={$page.form.params.sortby}&where={$page.form.params.where}&query={$page.form.params.query}&a_in={$page.form.params.a_in}&a_spell={$page.form.params.a_spell}&a_t={$page.form.params.tag}&a_c=0&adv_params=1">Любой</a></li>
					{/if}
					{foreach from=$page.form.params.arr_c item=l key=k}					
					{if $k==$page.form.params.a_c}
					<li class="active">»&nbsp;{$l.name}</li>
					{else}
					<li class="item_link"><a href="/{$CURRENT_ENV.section}/search.php?sortby={$page.form.params.sortby}&where={$page.form.params.where}&query={$page.form.params.query}&a_in={$page.form.params.a_in}&a_spell={$page.form.params.a_spell}&a_t={$page.form.params.tag}&a_c={$k}&adv_params=1">{$l.name}</a></li>
					{/if}
					{/foreach}	
				</ul>
			</div>
			{if $page.results.groups == 0}
			<div class="query_result"{if $page.form.params.adv_params == 1} style="margin-left:203px;"{/if}><br/>
				<div style="padding-left: 10px;">
					Не найдено ни одного документа, соответствующего запросу <b>"{$page.form.params.query}"</b>.<br/><br/>
					
					Рекомендации:<br/>
					<ul style="list-style-type:disk; margin:0px;padding-left:25px;">
						<li>Убедитесь, что все слова написаны без ошибок.</li>
						<li>Попробуйте использовать другой запрос.</li>
						<li>Попробуйте использовать более точный параметр поиска в меню <b>"ещё настройки"</b>.</li>
					</ul>
				</div>
			</div>
			{else}
			<div class="query_result"{if $page.form.params.adv_params == 1} style="margin-left:203px;"{/if}>
				<div style="padding-left:40px; padding-top:10px;">
					<script type="text/javascript">yandex_premium_print()</script>
				</div>
				<ol>
				{foreach from=$page.results.groups item=l key=k}
					<li value="{$page.results.first_number+$k}">
					{if $l.doccount==1}
						{foreach from=$l.docs item=doc}				
							{if !empty($doc.title)}
								{if $doc.data.template && isset($TEMPLATE.ssections.modules[$doc.data.template])}									
									{include file="`$TEMPLATE.ssections.modules[$doc.data.template]`"}
								{else}						
									<a class="result_ref" target="_blank" href="{$doc.url}" {if isset($page.results.reqid)}onmousedown="r('xmlsrch/clid={$yandex_direct[$CURRENT_ENV.regid]}/reqid=<{$page.results.reqid}>/resnum=<{$page.results.first_number+$k}>', this)"{/if}><span>{$doc.title}</span></a><br>
									{foreach from=$doc.passages item=passage}{if $passage}<span style="line-height:17px;">{$passage}</span><br>{/if}{/foreach}
									{if is_array($doc.sections)}
									{foreach from=$doc.sections item=section name=sections_list}
										<a href="{$section.path}" target="_blank" style="color:#005581;">{$section.title}</a>{if !$smarty.foreach.sections_list.last}, {/if}
									{/foreach}<br/>
									{/if}
									<small><font color="#888888">{if $page.results.engine=="Yandex_XML"}{$doc.url}{else}{$doc.small_url}{/if}</font>
									{if $doc.size}({if $doc.size>1024}{$doc.size/1024|number_format:0:",":" "} Кб{else}{$doc.size|number_format:0:",":" "} байт{/if}){/if}
									{if $doc.pubDate}- {$doc.pubDate|date_format:"%d.%m.%Y"}{/if}
									{if $doc.relevance_priority}{if $doc.relevance_priority=="phrase"}{elseif $doc.relevance_priority=="strict"}- строгое соответствие{else}- нестрогое соответствие{/if}{/if}</small>
								{/if}
							{else}
								<font color="#888888">Документ удален</font>
							{/if}
						{/foreach}
					{/if}					
					</li>
				{/foreach}
				</ol>
			</div>
			{if isset($page.results.reqid)}
                        <para><script type="text/javascript">{literal}r('xmlsrch/clid={/literal}{$yandex_direct[$CURRENT_ENV.regid]}{literal}/reqid={/literal}<{$page.results.reqid}>{literal}', this){/literal}</script></para>
			{/if}

			{if is_array($page.results.pageslink.btn) && sizeof($page.results.pageslink.btn)}
				Страницы:<br />
				{if $page.results.pageslink.back!="" 
					}<a href="{$page.results.pageslink.back}">&larr; предыдущая</a>{
				else
					}&larr; предыдущая{
				/if}
				&nbsp;&nbsp;&nbsp;&nbsp;
				
				{if $page.results.pageslink.next!="" 
					}<a href="{$page.results.pageslink.next}">следующая &rarr;</a>{
				else
					}следующая &rarr;{
				/if}
				<br /><br />
				
				<span class="pageslink">
				{foreach from=$page.results.pageslink.btn item=l}
					{if !$l.active}
						<a href="{$l.link}">{$l.text}</a>&nbsp;
					{else}
						<span class="pageslink_active">{$l.text}</span>&nbsp;
					{/if}
				{/foreach}
				</span>
			{/if}
			
			
			<br /><br />
			
			Отсортировано 
			{if $page.form.params.sortby == 'rlv'}
				<span class="pageslink_active">&nbsp;по релевантности&nbsp;</span>
			{else}
				<a href="?sortby=rlv&{$page.results.temp_str_sortby}">по релевантности</a>
			{/if}
			&nbsp;
			{if $page.form.params.sortby=="tm"}
				<span class="pageslink_active">&nbsp;по дате&nbsp;</span>
			{else}
				<a href="?sortby=tm&{$page.results.temp_str_sortby}">по дате</a>
			{/if}

			<br /><br />
			{/if} {* Конец проверки $page.results.groups > 0 *}
		</td>
		<td width="25%" style="padding-right:20px;">

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="padding-left:20px;padding-bottom:10px;">
						<script type="text/javascript">yandex_direct_print()</script>
					</td>
				</tr>
				<tr>
					<td style="padding-left:20px;padding-bottom:10px;">
						<script type="text/javascript">yandex_market_print()</script>
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>

	{if $page.results.engine=='Yandex_XML'}
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td align="center">
					Поиск организован с использованием <a href="http://xml.yandex.ru" target="_blank">Яндекс.XML</a>
					<br/><br/>
				</td>
			</tr>
		</table>
	{/if}

{*/if*}
