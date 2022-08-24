	{capture name="rname"}
		Просмотр данных по резюме {$res.id}
	{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

<div class="text11" style="padding-bottom:3px; float:left">
	Просмотров: {$res.views}
</div>
<div align="right" class="text11" style="padding-bottom:3px">
{if $res.canaddfavorite}<span id="ln{$res.id}"><a href="/{$ENV.section}/favorites/add/resume/{$res.id}.php" onclick="mod_job.toFavorites({$res.id}, 'resume'); return false;">Добавить резюме в избранное</a>&nbsp;|&nbsp;</span>{/if}
<a href="/{$ENV.section}/resume/{$res.id}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
</div>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.image.file)}<td><img src="{$res.image.file}" width="{$res.image.w}" height="{$res.image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				{if $res.fio}
				<tr>
					<td class="bg_color2" align="right" width="130">Ф.И.О.</td>
					<td class="bg_color4">{$res.fio}</td>
				</tr>
				{/if}
				{if $res.city}
				<tr>
					<td class="bg_color2" align="right" width="130">Город</td>
					<td class="bg_color4">{$res.city}</td>
				</tr>
				{/if}
				{if $res.dolgnost}
				<tr>
					<td class="bg_color2" align="right" width="130">Должность</td>
					<td class="bg_color4">{$res.dolgnost}</td>
				</tr>
				{/if}
				{if $res.pay}
				<tr>
					<td class="bg_color2" align="right" width="130">Зарплата</td>
					<td class="bg_color4">{$res.pay}</td>
				</tr>
				{/if}
				{if $res.grafik}
				<tr>
					<td class="bg_color2" align="right" width="130">График работы</td>
					<td class="bg_color4">{$res.grafik}</td>
				</tr>
				{/if}
				{if $res.jtype}
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы</td>
					<td class="bg_color4">{$res.jtype}</td>
				</tr>
				{/if}
				{if $res.educat}
				<tr>
					<td class="bg_color2" align="right" width="130">Образование</td>
					<td class="bg_color4">{$res.educat}</td>
				</tr>
				{/if}
				{if $res.vuz}
				<tr>
					<td class="bg_color2" align="right" width="130">Уч. заведение</td>
					<td class="bg_color4">{$res.vuz|nl2br}</td>
				</tr>
				{/if}
				{if $res.stage}
				<tr>
					<td class="bg_color2" align="right" width="130">Стаж</td>
					<td class="bg_color4">{$res.stage}</td>
				</tr>
				{/if}
				{if $res.prevrab}
				<tr>
					<td class="bg_color2" align="right" width="130">Предыдущие места<br>работы</td>
					<td class="bg_color4">{$res.prevrab|nl2br}</td>
				</tr>
				{/if}
				{if $res.lang}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание языков</td>
					<td class="bg_color4">{$res.lang|nl2br}</td>
				</tr>
				{/if}
				{if $res.comp}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание компьютера</td>
					<td class="bg_color4">{$res.comp|nl2br}</td>
				</tr>
				{/if}
				{if $res.baeduc}
				<tr>
					<td class="bg_color2" align="right" width="130">Бизнес-образование</td>
					<td class="bg_color4">{$res.baeduc|nl2br}</td>
				</tr>
				{/if}
				{if $res.dopsv}
				<tr>
					<td class="bg_color2" align="right" width="130">Дополнительные<br/>сведения</td>
					<td class="bg_color4">{$res.dopsv|nl2br}</td>
				</tr>
				{/if}
				{if $res.imp_type}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность</td>
					<td class="bg_color4">{$res.imp_type}</td>
				</tr>
				{/if}
				{if $res.pol}
				<tr>
					<td class="bg_color2" align="right" width="130">Пол</td>
					<td class="bg_color4">{$res.pol}</td>
				</tr>
				{/if}
				{if $res.ability}
				<tr>
					<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности</td>
					<td class="bg_color4">{$res.ability}</td>
				</tr>
				{/if}
				{if $res.age}
				<tr>
					<td class="bg_color2" align="right" width="130">Возраст</td>
					<td class="bg_color4">{$res.age}</td>
				</tr>
				{/if}
				{if $res.http}
				<tr>
					<td class="bg_color2" align="right" width="130">http://</td>
					<td class="bg_color4">{if $res.http!=""}<noindex><a href="http://{$res.http|url:false}" target="_blank">{$res.http|url:false}</a></noindex>{/if}</td>
				</tr>
				{/if}
				{if !empty($res.replyjs) && !isset($rjs)}
					{if !empty($res.getms)}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
				</tr>
					{/if}
				{elseif !$USER->IsAuth() && $res.uid>0}
				<tr>    <td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><span style="font-size: 11px;">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span></td>
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
				{if $res.phone}
				<tr>
					<td class="bg_color2" align="right" width="130">Телефон</td>
					<td class="bg_color4">{$res.phone}</td>
				</tr>
				{/if}
				{if $res.addr}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес</td>
					<td class="bg_color4">{$res.addr}</td>
				</tr>
				{/if}
				{*if !empty($res.replyjs)}
				<tr>
					<td colspan="2" align="center" class="text11"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
				</tr>
				{elseif !$USER->IsAuth() && $page.adv.uid>0}
				<tr>
					<td colspan="2" align="center" class="text11">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</td>
				</tr>
				{/if*}
				{if $res.canedit}<tr>
					<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/resume.php">Редактировать резюме</a></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/resume.php">Удалить резюме</a></td>
				</tr>{/if}
			</table>
		</td>
	</tr>
</table>
<br/>
{include file="`$TEMPLATE.midbanner`"}<br/><br/>
{if in_array($CURRENT_ENV.regid,array(74,2,16,34,59,63,72,61,174))}
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
{elseif $CURRENT_ENV.regid==174}
yandex_partner_id = 44222;
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
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<!-- Яндекс.Директ -->
{/if}