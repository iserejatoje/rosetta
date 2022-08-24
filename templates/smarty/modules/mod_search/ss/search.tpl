{*if $CURRENT_ENV.regid == 74 && $USER->ID != 1}
<script id="ig74_sr" charset="windows-1251"></script>
<script charset="windows-1251"><!--//
{literal}
//var ig74_direct_titleColor = '004D4E';
//var ig74_direct_siteurlColor = '888888';
//var ig74_market_offerlinkColor = '004D4E';

var ig74_r = Math.round(Math.random() * 100000);
var ig74_q='{/literal}{$page.form.query}{literal}';
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
{*if $CURRENT_ENV.regid == 74 || $USER->ID == 1 || $smarty.get.test==1*}
<script id="ig74_sr" charset="windows-1251"></script>
<script charset="windows-1251"><!--//
{literal}

$(document).ready(function() {
	var ig74_r = Math.round(Math.random() * 100000);
	var ig74_q='{/literal}{$page.form.query}{literal}';

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
var yandex_premium_fontColor = '000000';
var yandex_premium_titleColor = '336633';
var yandex_premium_siteurlColor = '006600';
function yandex_premium_print(){ }

// Настройки объявлений Директа
var yandex_direct_fontColor = '000000';
var yandex_direct_BorderColor = 'FFFFFF';
var yandex_direct_BgColor = 'FFFFFF';
var yandex_direct_headerBgColor = 'FFFFFF';
var yandex_direct_titleColor = '005A52';
var yandex_direct_siteurlColor = '666666';
var yandex_direct_linkColor = '005A52';
var yandex_direct_favicon = true;
function yandex_direct_print(){}

// Настройки объявлений Маркета
var yandex_market_fontColor = '000000';
var yandex_market_BorderColor = 'FFFFFF';
var yandex_market_BgColor = 'FFFFFF';
var yandex_market_headerBgColor = 'FFFFFF';
var yandex_market_catColor = '666666';
var yandex_market_offerlinkColor = '005A52';
var yandex_market_linkColor = '005A52';
function yandex_market_print(){}

var yandex_r = Math.round(Math.random() * 100000);
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/code/{/literal}{$yandex_direct[$CURRENT_ENV.regid]}{literal}?rnd=' + yandex_r + '&text={/literal}{$page.form.query|escape:"url"}{literal}&page-no={/literal}{$page.form.params.page}{literal}"></'+'sc'+'ript>');
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

{if isset($UERROR->ERRORS.result)}

<table width="100%" cellpadding="20" cellspacing="0" border="0">
	<tr>
		<td class="error" align="center"><span>{$UERROR->ERRORS.result}</span></td>
	</tr>
</table>

{else}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td width="75%" style="padding-left:20px;">

			<table id="hint" width="100%" cellpadding="0" cellspacing="0" border="0" style="display:none; margin-bottom: 5px;">
				<tr valign="top" align="left">
					<td width="15px"><img src="/_img/design/200608_title/common/exclamation.gif" style="margin-top:1px;" width="11" height="11" border="0" /></td>
					<td id="hint_text" style="font-size:11px; color: #555555;"></td>
				</tr>
			</table>
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
{/literal}
{php}
if( in_array($this->_tpl_vars['CURRENT_ENV']['regid'], array(74,72,63,59)) )
{
	$hints = array();
	if($this->_tpl_vars['CURRENT_ENV']['regid'] == 74)
	{
		$hints[] = array(
			1 => 'А знаете ли вы? Что вариант поиска "на 74.ru" - это поиск на всех сайтах «ИГ 74»:<br>74.ru, Chelyabinsk.ru, Chel.ru, ChelFin.ru, ChelDiplom.ru, AutoChel.ru, VIP-autochel.ru, DomChel.ru, MyChel.ru, 2074.ru, и др.',
			2 => '',
		);
		$hints[] = array(
			1 => 'Есть предложения/отзывы по поиску? Пишите <a href="http://74.ru/forum/theme.php?id=113473" target="_blank">сюда</a>.',
			2 => '',
		);
	}
	if($this->_tpl_vars['CURRENT_ENV']['regid'] == 63)
		$hints[] = array(
			1 => 'А знаете ли вы? Что вариант поиска "на 63.ru" - это поиск на всех сайтах «Информационной группы 63»:<br>63.ru, GazetaSamara.ru, Dengi63.ru, Doroga63.ru, Dom63.ru, FreeTime63.ru, и др.',
			2 => '',
		);
	if($this->_tpl_vars['CURRENT_ENV']['regid'] == 59)
		$hints[] = array(
			1 => 'А знаете ли вы? Что вариант поиска "на 59.ru" - это поиск на всех сайтах «Информационной группы 59»:<br>59.ru, dengi59.ru, avto59.ru, kvartira59.ru, и др.',
			2 => '',
		);
	if($this->_tpl_vars['CURRENT_ENV']['regid'] == 72)
		$hints[] = array(
			1 => 'А знаете ли вы? Что вариант поиска "на 72.ru" - это поиск на всех сайтах «ИГ 72»:<br>72.ru, 72dengi.ru,	72avto.ru,	72dom.ru, и др.',
			2 => '',
		);
	$which = rand(0, count($hints)-1);
echo "
hint_t1 = '".$hints[$which][1]."';
hint_t2 = '".$hints[$which][2]."';
";
}
else
{
echo "
hint_t1 = '';
hint_t2 = '';
";
}
{/php}
{literal}
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

	Вы искали "<b>{$page.form.query}</b>"
	{if $page.results.engine=="Yandex_XML"}
		{if $page.form.params.where == 1}
			в Интернете
		{elseif $page.form.params.where == 2}
			в {$CURRENT_ENV.site.name_where}
		{elseif $page.form.params.where == 3}
			на {$CURRENT_ENV.site.domain}
		{/if}
	{else}
		{if isset($res.a_c) && $res.a_c > 0}
			<input type="checkbox" name="a_c" value="{$res.a_c}" id="where_3_cat" checked="checked" /><label for="where_3_cat">
		{if $res.section.type == 1}
			на сайте {$res.section.name}
		{else}
			в разделе {$res.section.name}{if !empty($res.section.parent)} на сайте {$res.section.parent.name}{/if}
		{/if}
			</label>
			&nbsp;&nbsp;
	{/if}
	
		{assign var=a_c value=$smarty.get.a_c}
		{if isset($page.results.section)}
			{if $page.results.section.type == 1}
				на сайте <b>{$page.results.section.name}</b>
			{else} 
				в разделе <b>{$page.results.section.name}</b>{if !empty($page.results.section.parent)} на сайте <b>{$page.results.section.parent.name}</b>{/if}
			{/if}
		{/if}
		{if isset($page.form.params.tag) && $page.form.params.tag > 0}
			Тематика документов - <b>{$page.results.tags[$page.form.params.tag]}</b>
		{/if}
	{/if}<br/>
	
	{* <noindex><div style="float:right; color: #AAAAAA;"><div style="float: left; margin-top: 4px;">Поиск осуществлен с использованием технологии </div><a href="http://yandex.ru/" target="_blank" rel="nofollow"><img src="http://company.yandex.ru/i/50x23.gif" border="0" hspace="5" /></a></div></noindex> *}
	{if $page.results.count.all}
		{if $page.results.engine=="Yandex_XML"}
			<noindex><a href="http://yandex.ru/" target="_blank" rel="nofollow"><img style="vertical-align:bottom;" src="http://data.yandex.ru/i?ctype=4&path=h12810750_yandex_rb.png" border="0" hspace="5" /></a> нашел <b>{$page.results.count.all|number_format:0:",":" "}</b> {word_for_number number=$page.results.count.all first="документ" second="документа" third="документов"}</noindex>
		{else}
			Найдено документов: <b>{$page.results.count.all|number_format:0:",":" "}</b>
		{/if}
	{/if}
	

			{*if in_array($CURRENT_ENV.regid, array(74))*}
			<div style="display:block;" id="ig74_elite"></div>
			{*/if*}
			<div style="padding-left:40px; padding-top:10px;">
				<script type="text/javascript">yandex_premium_print()</script>
			</div>
			
			<ol>
			{foreach from=$page.results.groups item=l key=k}
				<li value="{$page.results.first_number+$k}" style="padding-bottom:10px;">
				{if $l.doccount==1}
					{foreach from=$l.docs item=doc}				
						{if !empty($doc.title)}
							{if $doc.data.template && isset($TEMPLATE.ssections.modules[$doc.data.template])}
								{include file="`$TEMPLATE.ssections.modules[$doc.data.template]`"}
							{else}						
								<a target="_blank" href="{$doc.url}" {if isset($page.results.reqid)}onmousedown="r('xmlsrch/clid={$yandex_direct[$CURRENT_ENV.regid]}/reqid=<{$page.results.reqid}>/resnum=<{$page.results.first_number+$k}>', this)"{/if}><span>{$doc.title}</span></a><br>
								{foreach from=$doc.passages item=passage}{if $passage}<span>{$passage}</span><br>{/if}{/foreach}
								<small><font color="#888888">{$doc.url|truncate:100:"..."}</font>
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

{/if}
