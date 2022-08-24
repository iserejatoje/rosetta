
{capture name="typevac"}
	<span class="s1">
	{if $res.ftype==1}<img src="/_img/modules/job/icon_a.png" width="11" height="11" alt="Кадровое агентство" title="Кадровое агентство" />&nbsp;вакансия агенства{/if}
	{if $res.ftype==2}<img src="/_img/modules/job/icon_r.png" width="11" height="11" alt="Прямой работодатель" title="Прямой работодатель" />&nbsp;прямой работодатель{/if}
	</span>
{/capture}
{capture name="rname"}
	Просмотр данных по вакансии {$res.vid} {$smarty.capture.typevac}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

<div align="right" class="text11" style="padding-bottom:3px">
{if $USER->IsAuth() && !$res.fav}<span id="ln{$res.vid}"><a class="ssyl" href="/{$ENV.section}/favorites/add/vacancy/{$res.vid}.php" onclick="mod_job.toFavorites({$res.vid}, 'vacancy'); return false;">Добавить вакансию в избранное</a>&nbsp;|&nbsp;</span>{/if}
<a href="/{$ENV.section}/vacancy/{$res.vid}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
</div>

<table cellpadding=4 cellspacing=1 border="0" width="100%">
{if $res.city}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Город</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.city}</td>
</tr>
{/if}
{if $res.region}
<tr>
	<td class="bg_color2" align='right' width="130">Место работы (район)</td>
	<td class="bg_color4">{$res.regions[$res.region].name}</td>
</tr>
{/if}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Фирма</td>
	<td class="dopp" bgcolor="#F6FBFB">
		{if isset($res.fid) && $res.fid > 0}
			<a href="/{$ENV.section}/vacancy/firm/{$res.fid}.php" title="Полный список вакансий этой компании">{$res.firm}</a>
			{if $res.img_small}<br/><a href="/{$ENV.section}/vacancy/firm/{$res.fid}.php" title="Полный список вакансий этой компании"><img vspace="2" src="{$res.img_small.file}" alt="{$res.firm|escape:"html"}" border="0"/></a>{/if}
		{else}{$res.firm}{/if}
	</td>
</tr>
{if $res.dolgnost}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Должность</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.dolgnost}</td>
</tr>
{/if}
{if $res.paysum}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Зарплата, руб.</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.paysum}</td>
</tr>
{/if}
{if $res.payform}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Форма оплаты</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.payform}</td>
</tr>
{/if}
{if $res.grafik}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">График работы</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.grafik}</td>
</tr>
{/if}
{if $res.jtype}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Тип работы</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.jtype}</td>
</tr>
{/if}
{if $res.uslov}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Условия </td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.uslov|nl2br}</td>
</tr>
{/if}
{if $res.treb}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Требования </td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.treb|nl2br}</td>
</tr>
{/if}
{if $res.obyaz}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Обязанности </td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.obyaz|nl2br}</td>
</tr>
{/if}
{if $res.firm_about}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">О компании </td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.firm_about|nl2br}</td>
</tr>
{/if}
{if $res.educat}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Образование</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.educat}</td>
</tr>
{/if}
{if $res.stage}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Стаж</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.stage}</td>
</tr>
{/if}
{if $res.lang}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Знание языков</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.lang|nl2br}</td>
</tr>
{/if}
{if $res.comp}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Знание компьютера</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.comp|nl2br}</td>
</tr>
{/if}
{if $res.baeduc}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Бизнес-образование</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.baeduc|nl2br}</td>
</tr>
{/if}
{if $res.pol}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Пол</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.pol}</td>
</tr>
{/if}
{if $res.ability}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Степень ограничения трудоспособности</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.ability}</td>
</tr>
{/if}
{if !empty($res.replyjs) && !isset($rjs)}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130"></td>
	<td class="dopp" bgcolor="#F6FBFB"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
</tr>
{/if}
{if $res.phones}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Телефон</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.phones}</td>
</tr>
{/if}
{if $res.faxes}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Факс</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.faxes}</td>
</tr>
{/if}
{if $res.email}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">E-mail</td>
	{php}
	if ($this->_tpl_vars['res']['email'] != '') {
		$this->_tpl_vars['res']['email'] = explode(',',$this->_tpl_vars['res']['email']);
		foreach($this->_tpl_vars['res']['email'] as &$m)
			$m = '<a href="mailto:'.trim($m).'"/>'.trim($m).'</a>';
		$this->_tpl_vars['res']['email'] = implode(', ',$this->_tpl_vars['res']['email']);
	}
	{/php}
	<td class="dopp" bgcolor="#F6FBFB">{*if $res.email != ""}{$res.email|mailto_crypt}{/if*}{$res.email}</td>
</tr>
{/if}
{if $res.http}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">http://</td>
	<td class="dopp" bgcolor="#F6FBFB">{if $res.http!=""}<noindex><a href="http://{$res.http}" target="_blank">{$res.http|trim:" / "}</a></noindex>{/if}</td>
</tr>
{/if}
{if $res.addr}
<tr>
	<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Адрес</td>
	<td class="dopp" bgcolor="#F6FBFB">{$res.addr}</td>
</tr>
{/if}
<tr>
	<td colspan=2>Это объявление некорректно? <a href="#" onclick="mod_job_incorrect_obj.show({$res.vid}, 'vacancy'); return false;">Сообщите нам об этом</a>.
	</td>
</tr>
{* if $USER->IsAuth() && !$res.fav}
<tr id="ln{$res.vid}">
	<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/favorites/add/vacancy/{$res.vid}.php" onclick="mod_job.toFavorites({$res.vid}, 'vacancy'); return false;" >Добавить вакансию в избранное</a></td>
</tr>
{/if *}
<tr>
	<td colspan="2" align="center" class="s1"><a href="http://74.ru/job/my/vacancy.php" target="_blank">Редактировать вакансию</a></td>
</tr>
<tr>
	<td colspan="2" align="center" class="s1"><a href="http://74.ru/job/my/vacancy.php" target="_blank">Удалить вакансию</a></td>
</tr>
{*
<tr>
	<td colspan="2" align="center" class="s1"><a href="/{$ENV.section}/vacancy/{$res.vid}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></td>
</tr>
*}
</table><br/>

<div id="incorrect_container_{$res.vid}" class="incorrect_container" align="center" style="display: none;">&nbsp;</div>

{include file="`$CONFIG.templates.ssections.incorrect_form`" incorrect_marks="`$res.incorrect_marks`"}
<br/><br/>
{*include file="`$TEMPLATE.midbanner`"*}
<br/><br/>
