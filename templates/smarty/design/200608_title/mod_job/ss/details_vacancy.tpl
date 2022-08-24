{capture name="typevac"}
	<span class="t13">
	{if $res.ftype==1}<img src="/_img/modules/job/icon_a.png" width="11" height="11" alt="Кадровое агентство" title="Кадровое агентство" />&nbsp;вакансия агенства{/if}
	{if $res.ftype==2}<img src="/_img/modules/job/icon_r.png" width="11" height="11" alt="Прямой работодатель" title="Прямой работодатель" />&nbsp;прямой работодатель{/if}
	</span>
{/capture}
{capture name="rname"}
	Просмотр данных по вакансии {$res.vid} {$smarty.capture.typevac}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

{if $res.in_state == 1}

	<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	{if $res.city}
		<tr>
			<td class="bg_color2" align='right' width="130">Город</td>
			<td class="bg_color4">{$res.city}</td>
		</tr>
	{/if}
	{if $res.dolgnost}
	<tr>
			<td class="bg_color2" align='right' width="130">Должность</td>
			<td class="bg_color4">{$res.dolgnost}</td>
	</tr>
	{/if}
	<tr>
		<td class="bg_color2" align='right' width="130"></td>
		<td class="bg_color4">Срок размещения вакансии истек</td>
	</tr>
	</table>
{elseif is_array($res) && !sizeof($res) }
	<div align="center">
		<span style="color:red;"><b>Запрошенная вами вакансия не найдена</b></span><br/><br/>
		<a href="/{$ENV.section}/vacancy/1.php">Перейти к списку вакансий</a>
	</div>
{else}
	<div class="text11" style="padding-bottom:3px; float:left">
		Просмотров: {$res.views}
	</div>
	<div align="right" class="text11" style="padding-bottom:3px">
	{if $res.canaddfavorite}<span id="ln{$res.vid}"><a class="ssyl" href="/{$ENV.section}/favorites/add/vacancy/{$res.vid}.php" onclick="mod_job.toFavorites({$res.vid}, 'vacancy'); return false;">Добавить вакансию в избранное</a>&nbsp;|&nbsp;</span>{/if}
	<a href="/{$ENV.section}/vacancy/{$res.vid}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
	</div>

	<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	{if $res.city}
	<tr>
		<td class="bg_color2" align='right' width="130">Город</td>
		<td class="bg_color4">{$res.city}</td>
	</tr>
	{/if}
	{if $res.region}
	<tr>
		<td class="bg_color2" align='right' width="130">Место работы (район)</td>
		<td class="bg_color4">{$res.regions[$res.region].name}</td>
	</tr>
	{/if}
	{if $res.fid > 0 || $res.firm}
	<tr>
		<td class="bg_color2" align='right' width="130">Фирма</td>
		<td class="bg_color4">
			{if $res.fid > 0}
				<div style="float:left">
						<a href="/{$ENV.section}/vacancy/firm/{$res.fid}.php" title="Полный список вакансий этой компании">{$res.firm}</a>
				</div>
				{if !empty($res.dopsv)}
				<div align="right">
					<a class="tip" style="color:#999" href="javascript:void(0);" onclick="$('#dopsv').slideToggle('normal');">о компании...</a>
				</div>
				{/if}
				<div style="clear:both">
					{if $res.img_small}<a href="/{$ENV.section}/vacancy/firm/{$res.fid}.php" title="Полный список вакансий этой компании"><img vspace="2" src="{$res.img_small.file}" alt="{$res.firm|escape:"html"}" border="0" /></a>{/if}
				</div>
				{if !empty($res.dopsv)}
				<div id="dopsv" style="display:none; padding-top:5px">
					{$res.dopsv|nl2br}
				</div>
				{/if}
			{else}{$res.firm}{/if}
		</td>
	</tr>
	{/if}
	{if $res.dolgnost}
	<tr>
		<td class="bg_color2" align='right' width="130">Должность</td>
		<td class="bg_color4">{$res.dolgnost}</td>
	</tr>
	{/if}
	{if $res.paysum_text}
	<tr>
		<td class="bg_color2" align='right' width="130">Зарплата, руб.</td>
		<td class="bg_color4">{$res.paysum_text}</td>
	</tr>
	{/if}
	{if $res.payform}
	<tr>
		<td class="bg_color2" align='right' width="130">Форма оплаты</td>
		<td class="bg_color4">{$res.payform}</td>
	</tr>
	{/if}
	{if $res.grafik}
	<tr>
		<td class="bg_color2" align='right' width="130">График работы</td>
		<td class="bg_color4">{$res.grafik}</td>
	</tr>
	{/if}
	{if $res.jtype}
	<tr>
		<td class="bg_color2" align='right' width="130">Тип работы</td>
		<td class="bg_color4">{$res.jtype}</td>
	</tr>
	{/if}
	{if $res.uslov}
	<tr>
		<td class="bg_color2" align='right' width="130">Условия </td>
		<td class="bg_color4">{$res.uslov|nl2br}</td>
	</tr>
	{/if}
	{if $res.treb}
	<tr>
		<td class="bg_color2" align='right' width="130">Требования </td>
		<td class="bg_color4">{$res.treb|nl2br}</td>
	</tr>
	{/if}
	{if $res.obyaz}
	<tr>
		<td class="bg_color2" align='right' width="130">Обязанности </td>
		<td class="bg_color4">{$res.obyaz|nl2br}</td>
	</tr>
	{/if}
	{if $res.firm_about}
	<tr>
		<td class="bg_color2" align='right' width="130">О компании </td>
		<td class="bg_color4">{$res.firm_about|nl2br}</td>
	</tr>
	{/if}
	{if $res.educat}
	<tr>
		<td class="bg_color2" align='right' width="130">Образование</td>
		<td class="bg_color4">{$res.educat}</td>
	</tr>
	{/if}
	{if $res.stage}
	<tr>
		<td class="bg_color2" align='right' width="130">Стаж</td>
		<td class="bg_color4">{$res.stage}</td>
	</tr>
	{/if}
	{if $res.lang}
	<tr>
		<td class="bg_color2" align='right' width="130">Знание языков</td>
		<td class="bg_color4">{$res.lang|nl2br}</td>
	</tr>
	{/if}
	{if $res.comp}
	<tr>
		<td class="bg_color2" align='right' width="130">Знание компьютера</td>
		<td class="bg_color4">{$res.comp|nl2br}</td>
	</tr>
	{/if}
	{if $res.baeduc}
	<tr>
		<td class="bg_color2" align='right' width="130">Бизнес-образование</td>
		<td class="bg_color4">{$res.baeduc|nl2br}</td>
	</tr>
	{/if}
	{if $res.pol}
	<tr>
		<td class="bg_color2" align='right' width="130">Пол</td>
		<td class="bg_color4">{$res.pol}</td>
	</tr>
	{/if}
	{if $res.ability}
	<tr>
		<td class="bg_color2" align='right' width="130">Степень ограничения трудоспособности</td>
		<td class="bg_color4">{$res.ability}</td>
	</tr>
	{/if}
	{if !empty($res.replyjs) && !isset($rjs)}
		{if !empty($res.getms)}
	<tr>
		<td class="bg_color2" align="right" width="130"></td>
		<td class="bg_color4"><a href="#" onclick="{$res.replyjs};return false;">Отправить&nbsp;мгновенное&nbsp;сообщение</a>{if !empty($res.resumesend_js)}&nbsp;&nbsp;&nbsp; <a href="#" onclick="{$res.resumesend_js};return false;">Отправить&nbsp;свое&nbsp;резюме</a>{/if}</td>
	</tr>
		{/if}
	{elseif !$USER->IsAuth() && $res.uid>0 && !empty($res.getms)}
	<tr>    
		<td class="bg_color2" align="right" width="130"></td>
		<td class="bg_color4"><span style="font-size: 11px;">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span></td>
	</tr>

	{/if}
	{if $res.phones}
	<tr>
		<td class="bg_color2" align='right' width="130">Телефон</td>
		<td class="bg_color4">{$res.phones}</td>
	</tr>
	{/if}
	{if $res.contact}
	<tr>
		<td class="bg_color2" align='right' width="130">Контактное лицо</td>
		<td class="bg_color4">{$res.contact}</td>
	</tr>
	{/if}
	{if $res.faxes}
	<tr>
		<td class="bg_color2" align='right' width="130">Факс</td>
		<td class="bg_color4">{$res.faxes}</td>
	</tr>
	{/if}
	{if $res.email}
	<tr>
		<td class="bg_color2" align="right" width="130">E-mail</td>
		{php}
		if ($this->_tpl_vars['res']['email'] != '') {
			$this->_tpl_vars['res']['email'] = explode(',',$this->_tpl_vars['res']['email']);
			foreach($this->_tpl_vars['res']['email'] as &$m)
				$m = '<a href="mailto:'.trim($m).'"/>'.trim($m).'</a>';
			$this->_tpl_vars['res']['email'] = implode(', ',$this->_tpl_vars['res']['email']);
		}
		{/php}
		<td class="bg_color4">{*if $res.email != ""}{$res.email|mailto_crypt}{/if*}{$res.email}</td>
	</tr>
	{/if}

	{if $res.http}
	<tr>
		<td class="bg_color2" align='right' width="130">http://</td>
		<td class="bg_color4">{if $res.http!=""}<noindex><a href="http://{$res.http|url:false}" target="_blank">{$res.http|url:false}</a></noindex>{/if}</td>
	</tr>
	{/if}

	{if $res.addr}
	<tr>
		<td class="bg_color2" align='right' width="130">Адрес</td>
		<td class="bg_color4">{$res.addr}</td>
	</tr>
	{/if}
	{if $res.show_incorrect == 1}	
	<tr>
		<td colspan=2>Это объявление некорректно? <a href="#" onclick="mod_job_incorrect_obj.show({$res.vid}, 'vacancy'); return false;">Сообщите нам об этом</a>.
		</td>
	</tr>	
	{/if}

	{if $res.canedit}<tr>
		{*<td align="left">{if $res.previd!=0}<a href="/{$ENV.section}/vacancy/{$res.previd}{if $res._rid || $res._fid}/{$res._rid}{/if}{if $res._fid}/{$res._fid}{/if}.html{if $res.search && $res.params}?{$res.params}{/if}">предыдущая</a>{/if}</td>*}
		<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/vacancy.php">Редактировать вакансию</a></td>
		{*<td align="right">{if $res.nextid!=0}<a href="/{$ENV.section}/vacancy/{$res.nextid}{if $res._rid || $res._fid}/{$res._rid}{/if}{if $res._fid}/{$res._fid}{/if}.html{if $res.search && $res.params}?{$res.params}{/if}">следующая</a>{/if}</td>*}
	</tr>
	<tr>
		<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/vacancy.php">Удалить вакансию</a></td>
	</tr>{/if}

	</table>
{/if}
<div id="incorrect_container_{$res.vid}" class="incorrect_container" align="center" style="display: none;">&nbsp;</div>

{include file="`$CONFIG.templates.ssections.incorrect_form`" incorrect_marks="`$res.incorrect_marks`"}
<br/>

{if in_array($CURRENT_ENV.regid,array(74,2,16,34,59,63,72,61))}
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
{/literal}
{if $CURRENT_ENV.regid==74}
yandex_partner_id = 45973;
{elseif $CURRENT_ENV.regid==63}
yandex_partner_id = 46288;
{elseif $CURRENT_ENV.regid==59}
yandex_partner_id = 46287;
{elseif $CURRENT_ENV.regid==72}
yandex_partner_id = 46289;
{elseif $CURRENT_ENV.regid==16}
yandex_partner_id = 46284;
{elseif $CURRENT_ENV.regid==61}
yandex_partner_id = 19348;
{elseif $CURRENT_ENV.regid==2}
yandex_partner_id = 19327;
{elseif $CURRENT_ENV.regid==34}
yandex_partner_id = 46285;
{/if}
{literal}
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.8;
yandex_direct_type = 'horizontal';
yandex_direct_border_type = 'ad';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'EDF6F8';
yandex_direct_bg_color = 'EDF6F8';
yandex_direct_border_color = 'E0F3F3';
yandex_direct_title_color = '005A52';
yandex_direct_url_color = '000000';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'BBC6C1';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/resource/context.js?rnd=' + Math.round(Math.random() * 100000) + '"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
<!-- Яндекс.Директ -->
{/if}
<br/><br/>
{include file="`$TEMPLATE.midbanner`"}