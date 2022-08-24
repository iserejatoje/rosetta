<script type="text/javascript" language="javascript" src="/_scripts/modules/job/checkvac.js"></script>
{if $page.action == 'vacancy_add'}
	{if $page.preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новая вакансия - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новая вакансия"}
	{/if}
{else}
	{if $page.preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование вакансии `$page.vacancy.vid` - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование вакансии `$page.vacancy.vid`"}
	{/if}
	<div class="title" style="padding:0px 5px 0px 5px;"><a href="/{$ENV.section}/vacancy/{$page.vacancy.vid}.html" class="text11" target="_blank">Ссылка на вакансию</a></div>
{/if}

{if $page.vacancy.moderate < 0}
<div style="padding:10px">
	<p style="color:red"><b>Отказано в размещении вакансии</b></p>
	<p style="color:red">{$CONFIG.moderator_marks[$page.vacancy.moderate].message}</p>
	<p style="color:red">Отредактируйте вакансию.</p>
</div>
{/if}

{if $page.vacancy === false}
<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td align="center" style="color:red">
			<b>Вакансия не найдена.</b>
		</td>
	</tr>
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/vacancy.php">К списку вакансий</a> ]</td>
	</tr>
</table>
{else}

{if $page.preview}

<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
<tr>
	<td class="bg_color2" align='right' width="130">Город</td>
	<td class="bg_color4">
		{if $page.vacancy.city_id}{$page.city_arr[$page.vacancy.city_id].name}{else}{$page.vacancy.city}{/if}
	</td>
</tr>
{if $page.vacancy.region}
<tr>
	<td class="bg_color2" align='right' width="130">Район</td>
	<td class="bg_color4">{$page.regions[$page.vacancy.region].name}</td>
</tr>
{/if}
<tr>
	<td class="bg_color2" align='right' width="130">Фирма</td>
	<td class="bg_color4">
		{if isset($page.vacancy.fid) && $page.vacancy.fid > 0}
			<a href="/{$ENV.section}/vacancy/firm/{$page.vacancy.fid}.php" title="Полный список вакансий этой компании">{$page.vacancy.firm}</a>
			{if $page.vacancy.img_small}<br/><a href="/{$ENV.section}/vacancy/firm/{$page.vacancy.fid}.php" title="Полный список вакансий этой компании"><img vspace="2" src="{$page.vacancy.img_small.file}" alt="{$page.vacancy.firm|escape:"html"}" border="0"/></a>{/if}
		{else}{$page.vacancy.firm}{/if}
	</td>
</tr>
{if $page.vacancy.dolgnost}
<tr>
	<td class="bg_color2" align='right' width="130">Должность</td>
	<td class="bg_color4">{$page.vacancy.dolgnost}</td>
</tr>
{/if}
{if $page.vacancy.paysum_text}
<tr>
	<td class="bg_color2" align='right' width="130">Зарплата, руб.</td>
	<td class="bg_color4">{$page.vacancy.paysum_text}</td>
</tr>
{/if}
{if $page.vacancy.payform}
<tr>
	<td class="bg_color2" align='right' width="130">Форма оплаты</td>
	<td class="bg_color4">{$page.payform_arr[$page.vacancy.payform]}</td>
</tr>
{/if}
{if $page.vacancy.grafik}
<tr>
	<td class="bg_color2" align='right' width="130">График работы</td>
	<td class="bg_color4">{$page.graphic_arr[$page.vacancy.grafik]}</td>
</tr>
{/if}
{if $page.vacancy.jtype}
<tr>
	<td class="bg_color2" align='right' width="130">Тип работы</td>
	<td class="bg_color4">{$page.job_type_arr[$page.vacancy.jtype]}</td>
</tr>
{/if}
{if $page.vacancy.uslov}
<tr>
	<td class="bg_color2" align='right' width="130">Условия </td>
	<td class="bg_color4">{$page.vacancy.uslov|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.treb}
<tr>
	<td class="bg_color2" align='right' width="130">Требования </td>
	<td class="bg_color4">{$page.vacancy.treb|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.obyaz}
<tr>
	<td class="bg_color2" align='right' width="130">Обязанности </td>
	<td class="bg_color4">{$page.vacancy.obyaz|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.firm_about}
<tr>
	<td class="bg_color2" align='right' width="130">О компании </td>
	<td class="bg_color4">{$page.vacancy.firm_about|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.educat}
<tr>
	<td class="bg_color2" align='right' width="130">Образование</td>
	<td class="bg_color4">{$page.education_arr[$page.vacancy.educat]}</td>
</tr>
{/if}
{if $page.vacancy.stage}
<tr>
	<td class="bg_color2" align='right' width="130">Стаж</td>
	<td class="bg_color4">{$page.vacancy.stage}</td>
</tr>
{/if}
{if $page.vacancy.lang}
<tr>
	<td class="bg_color2" align='right' width="130">Знание языков</td>
	<td class="bg_color4">{$page.vacancy.lang|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.comp}
<tr>
	<td class="bg_color2" align='right' width="130">Знание компьютера</td>
	<td class="bg_color4">{$page.vacancy.comp|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.baeduc}
<tr>
	<td class="bg_color2" align='right' width="130">Бизнес-образование</td>
	<td class="bg_color4">{$page.vacancy.baeduc|nl2br}</td>
</tr>
{/if}
{if $page.vacancy.pol}
<tr>
	<td class="bg_color2" align='right' width="130">Пол</td>
	<td class="bg_color4">{$page.sex_arr[$page.vacancy.pol]}</td>
</tr>
{/if}
{if $page.vacancy.ability}
<tr>
	<td class="bg_color2" align='right' width="130">Степень ограничения трудоспособности</td>
	<td class="bg_color4">{$page.ability_arr[$page.vacancy.ability]}</td>
</tr>
{/if}
{if $page.vacancy.contact}
<tr>
	<td class="bg_color2" align='right' width="130">Контактное лицо</td>
	<td class="bg_color4">{$page.vacancy.contact}</td>
</tr>
{/if}
{if $page.vacancy.phones}
<tr>
	<td class="bg_color2" align='right' width="130">Телефон</td>
	<td class="bg_color4">{$page.vacancy.phones}</td>
</tr>
{/if}
{if $page.vacancy.faxes}
<tr>
	<td class="bg_color2" align='right' width="130">Факс</td>
	<td class="bg_color4">{$page.vacancy.faxes}</td>
</tr>
{/if}

{if $page.vacancy.email}
<tr>
	<td class="bg_color2" align="right" width="130">E-mail</td>
	{php}
	if ($this->_tpl_vars['page']['vacancy']['email'] != '') {
		$this->_tpl_vars['page']['vacancy']['email_text'] = implode(', ',$this->_tpl_vars['page']['vacancy']['email']);
	}
	{/php}
	<td class="bg_color4">
		{$page.vacancy.email_text}
	</td>
</tr>
{/if}

{if $page.vacancy.http}
<tr>
	<td class="bg_color2" align='right' width="130">http://</td>
	<td class="bg_color4">{if $page.vacancy.http!=""}{$page.vacancy.http|url:false}{/if}</td>
</tr>
{/if}

{if $page.vacancy.addr}
<tr>
	<td class="bg_color2" align='right' width="130">Адрес</td>
	<td class="bg_color4">{$page.vacancy.addr}</td>
</tr>
{/if}

<tr>
	<td align='center' colspan='2'>
		<form name="vacancy_form" method='post'>
		<input type=hidden name="action" value="{$page.action}">
		<input type=hidden name="back" value="0">
		<input type=hidden name="vdate" value="{$page.vacancy.vdate}">
		<input type=hidden name="is_firm" value="{$page.vacancy.is_firm}">
		<input type=hidden name="preview" value="0">
		<input type=hidden name="city" value="{$page.vacancy.city|escape:"html"}">
		<input type=hidden name="city_id" value="{$page.vacancy.city_id}">
		<input type=hidden name="region" value="{$page.vacancy.region}">
		<input type=hidden name="pay" value="{$page.vacancy.paysum_text|escape:"html"}">
		<input type=hidden name="payform" value="{$page.vacancy.payform}">
		<input type=hidden name="grafik" value="{$page.vacancy.grafik}">
		<input type=hidden name="jtype" value="{$page.vacancy.jtype}">
		<input type=hidden name="rid" value="{$page.vacancy.rid}">
		<input type=hidden name="dol" value="{$page.vacancy.dolgnost|escape:"html"}">
		<input type=hidden name="educat" value="{$page.vacancy.educat|escape:"html"}">
		<input type=hidden name="pol" value="{$page.vacancy.pol}">
		<input type=hidden name="stage" value="{$page.vacancy.stage}">
		<input type=hidden name="uslov" value="{$page.vacancy.uslov|escape:"html"}">
		<input type=hidden name="treb" value="{$page.vacancy.treb|escape:"html"}">
		<input type=hidden name="obyaz" value="{$page.vacancy.obyaz|escape:"html"}">
		<input type=hidden name="firm_about" value="{$page.vacancy.firm_about|escape:"html"}">
		<input type=hidden name="firm" value="{$page.vacancy.firm|escape:"html"}">
		<input type=hidden name="phone" value="{$page.vacancy.phones|escape:"html"}">
		<input type=hidden name="contact" value="{$page.vacancy.contact|escape:"html"}">
		<input type=hidden name="faxes" value="{$page.vacancy.faxes|escape:"html"}">
		{foreach from=$page.vacancy.email item=i}
		<input type=hidden name="email[]" value="{$i}">
		{/foreach}
		<input type=hidden name="http" value="{$page.vacancy.http|escape:"html"}">
		<input type=hidden name="addr" value="{$page.vacancy.addr|escape:"html"}">
		<input type=hidden name="lang" value="{$page.vacancy.lang|escape:"html"}">
		<input type=hidden name="baeduc" value="{$page.vacancy.baeduc|escape:"html"}">
		<input type=hidden name="ability" value="{$page.vacancy.ability|escape:"html"}">
		<input type=hidden name="comp" value="{$page.vacancy.comp|escape:"html"}">
		{if $page.vacancy.hide}<input type="hidden" name="hide" value="{$page.vacancy.hide}">{/if}
		{*if $page.vacancy.moderate<0}<input type='hidden' name='moderate' value="{$page.vacancy.moderate}">{/if*}
		{*<input type=hidden name="paysum_text" value="{$page.vacancy.paysum_text}">*}
		<input type="submit" onclick="this.disabled=true; vacancy_form.submit();" value="{if $page.action == 'vacancy_add'}Разместить{else}Изменить{/if}" width="150">&nbsp;&nbsp;&nbsp;

		<input type=button value="Назад" onclick="vacancy_form.back.value=1; vacancy_form.submit()">

		<!--input type=button value="Назад" onclick="window.history.go(-1)"/-->
		</center>
		</form>
	</td>
</tr>
</table>

{else}

{if isset($page.err) && is_array($page.err)}
	<br/><div align="center" style="color:red;"><b>
		{foreach from=$page.err item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/><br/>
{/if}

<script language="JavaScript">
{literal}
<!--

function addEmailField() {

	var list = document.getElementById('email_list');

	fold = document.createElement('span');
	fold.innerHTML = ''+
	'<input name="email[]" value="" style="width:95%">'+
	'<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/_img/design/200608_title/bullet_delete.gif" hspace="4" border="0" alt="Удалить E-Mail"/></a></br>';
	list.appendChild(fold);
}

//-->
{/literal}
</script>


			<form name="vacancy_form" method=post onSubmit='return CheckVacForm(this)'>
			<input type=hidden name="action" value="{$page.action}">
			<input type=hidden name="vdate" value="{$page.vacancy.vdate}">
			<input type=hidden name="is_firm" value="{$page.vacancy.is_firm}">
			<input type=hidden name="preview" value="0">
			<table cellpadding="0" cellspacing="2" border="0" width="550" class="table2" align="center">
				{php} $this->_tpl_vars['selected'] = false; {/php}
				<tr>
					<td class="bg_color2" align="right" width="140">Город:</td>
					<td class="bg_color4">
						<select id="city_id" name="city_id" size="1" style="width:200px" onchange="mod_job.change_city(this, 'region', 'city');">
							{foreach from=$page.city_arr item=v key=k}
								{if ($ENV.site.domain=="mgorsk.ru" && $k==2376) || ($ENV.site.domain=="74.ru" && $k!=2376) || ($ENV.site.domain=="tolyatty.ru" && $k==1748) || ($ENV.site.domain=="63.ru" && $k!=1748) || ($ENV.site.domain=="sterlitamak1.ru" && $k==399) || ($ENV.site.domain=="ufa1.ru" && $k!=399) || !in_array($ENV.site.domain,array('mgorsk.ru','74.ru','tolyatty.ru','63.ru','ufa1.ru','sterlitamak1.ru'))}
								<option value="{$k}"{if $page.vacancy.city_id == $k || ($res.vacancy.city_id == -1 && $CONFIG.default_city == $k)}{php} $this->_tpl_vars['selected'] = true; {/php}selected="selected"{/if}>{$v.name}</option>
								{/if}
							{/foreach}
							<option value="0" {if !$selected} selected="selected"{/if}>Другой...</option>
						</select>
						{if $ENV.site.domain=="74.ru"}
						<a href="http://mgorsk.ru/job/my/vacancy/add.php" class="text11" target="_blank">Магнитогорск</a>
						{elseif $ENV.site.domain=="mgorsk.ru"}
						<a href="http://74.ru/job/my/vacancy/add.php" class="text11" target="_blank">Челябинская область</a>
						{/if}
						{if $ENV.site.domain=="63.ru"}
						<a href="http://tolyatty.ru/job/my/vacancy/add.php" class="text11" target="_blank">Тольятти</a>
						{elseif $ENV.site.domain=="tolyatty.ru"}
						<a href="http://63.ru/job/my/vacancy/add.php" class="text11" target="_blank">Самарская область</a>
						{/if}
						{if $ENV.site.domain=="72.ru"}
						<noindex><a href="http://86.ru/job/my/vacancy/add.php" rel="nofollow" class="text11" target="_blank">ХМАО</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/my/vacancy/add.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
						{elseif $ENV.site.domain=="86.ru"}
						<noindex><a href="http://72.ru/job/my/vacancy/add.php"  rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/my/vacancy/add.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
                        			{elseif $ENV.site.domain=="89.ru"}
						<noindex><a href="http://72.ru/job/my/vacancy/add.php" rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://86.ru/job/my/vacancy/add.php" rel="nofollow" class="text11" target="_blank">ХМАО</a><noindex>
						{/if}
						{if $ENV.site.domain=="ufa1.ru"}
						<a href="http://sterlitamak1.ru/job/my/vacancy/add.php" class="text11" target="_blank">Стерлитамак</a>
						{elseif $ENV.site.domain=="sterlitamak1.ru"}
						<a href="http://ufa1.ru/job/my/vacancy/add.php" class="text11" target="_blank">Республика Башкортостан</a>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Другой:</td>
					<td class="bg_color4">
						<input id="city" name="city" value="{if !$selected}{$page.vacancy.city|escape:"html"}{/if}" style="width:200px"{if $selected} disabled="true"{/if}>
					</td>
				</tr>
				{php} $this->_tpl_vars['selected'] = false; {/php}
				<tr>
					<td class="bg_color2" align="right" width="140" >Раздел:</td>
					<td class="bg_color4">
						<select name="rid" size="1" style="width:100%">
							{foreach from=$page.section_arr.razdel item=v}
								<option value="{$v.rid}" {if $v.rid == $page.vacancy.rid} selected="selected"{/if}>{$v.rname}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Должность:</td>
					<td class="bg_color4">
						<input name='dol' maxlength="50" value="{$page.vacancy.dolgnost|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Зарплата:</td>
					<td class="bg_color4">
						<input name='pay' size=10 maxlength="35" value="{$page.vacancy.paysum_text|escape:"html"}">&nbsp;&nbsp;руб.
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Форма оплаты:</td>
					<td class="bg_color4">
						<select name="payform" size=1 style="width:200px">
							<option value="0">Любая</option>
							{foreach from=$page.payform_arr item=v key=k}
								<option value="{$k}" {if $k == $page.vacancy.payform}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Тип работы:</td>
					<td class="bg_color4">
						<select name="jtype" size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.job_type_arr item=v key=k}
								<option value="{$k}" {if $k == $page.vacancy.jtype}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">График работы:</td>
					<td class="bg_color4">
						<select name="grafik" size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.graphic_arr item=v key=k}
								<option value="{$k}" {if $k == $page.vacancy.grafik}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Условия:</td>
					<td class="bg_color4">
						<textarea name='uslov' rows="8" wrap=virtual style="width:100%">{$page.vacancy.uslov}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Требования:</td>
					<td class="bg_color4">
						<textarea name='treb' rows="8" wrap=virtual style="width:100%">{$page.vacancy.treb}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Обязанности:</td>
					<td class="bg_color4">
						<textarea name='obyaz' rows="8" wrap=virtual style="width:100%">{$page.vacancy.obyaz}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">О компании:</td>
					<td class="bg_color4">
						<textarea name='firm_about' rows="8" wrap=virtual style="width:100%">{$page.vacancy.firm_about}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Образование:</td>
					<td class="bg_color4">
						<select name=educat size=1 style="width:200px">
							<option value="0">Любое</option>
							{foreach from=$page.education_arr item=v key=k}
								<option value="{$k}" {if $k == $page.vacancy.educat}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Стаж от:</td>
					<td class="bg_color4">
						<input name='stage' size=4 value="{$page.vacancy.stage|escape:"html"}"> лет
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Знание языков:</td>
					<td class="bg_color4">
						<textarea name='lang' rows=4 wrap="virtual" style="width:100%">{$page.vacancy.lang}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Знание компьютера:</td>
					<td class="bg_color4">
						<textarea name='comp' rows=4 wrap="virtual" style="width:100%">{$page.vacancy.comp}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Бизнес-образование:</td>
					<td class="bg_color4">
						<textarea name='baeduc' rows=4 wrap=virtual style="width:100%">{$page.vacancy.baeduc}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Пол:</td>
					<td class="bg_color4">
						<select name="pol" size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.sex_arr item=v key=k}
								<option value="{$k}" {if $k == $page.vacancy.pol}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Степень ограничения трудоспособности:</td>
					<td class="bg_color4">
						<select name=ability size=1 style="width:200px">
							{foreach from=$page.ability_arr item=a key=_k}
							<option value="{$_k}" {if $_k == $page.vacancy.ability}selected="selected"{/if}>{$a}</option>
							{/foreach}
						</select><br/>
<span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span>
					</td>
				</tr>
				{if $page.action == 'vacancy_add'}
				<tr>
					<td class="bg_color2" align="right" width="140">Срок размещения:</td>
					<td class="bg_color4">
						<select name=srok size=1 style="width:200px">
							<option value="1" {if 1 == $page.vacancy.srok}selected="selected"{/if}>1 неделя</option>
							<option value="2" {if 2 == $page.vacancy.srok}selected="selected"{/if}>2 недели</option>
							<option value="3" {if 3 == $page.vacancy.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4" {if 4 == $page.vacancy.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="140">&nbsp;</td>
					<td class="bg_color4">
						<input name="getms" id="getms" type="checkbox" value="1"{if $page.vacancy.getms} checked="checked"{/if}>
						<label for="getms">Получать личные сообщения</label>
					</td>
				</tr>
				<tr>
					<th colspan="2">Контактная информация</th>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="140">Компания:</td>
					<td class="bg_color4">
						<input name="firm" value="{$page.vacancy.firm|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Место работы (район):</td>
					<td class="bg_color4">
						<select id="region" name="region" size="1" style="width:200px"{if $selected} disabled="true"{/if}>
							<option value="0">не задано</option>
							{foreach from=$page.regions item=v key=k}
								{if $v.name}<option value="{$k}" {if $page.vacancy.region == $k} {php} $this->_tpl_vars['selected'] = true; {/php}selected="selected"{/if}>{$v.name}</option>{/if}
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" bgcolor="#E9EFEF">Адрес:</td>
					<td bgcolor="#F6FBFB">
						<input name="addr" value="{$page.vacancy.addr|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Контактное лицо:</td>
					<td class="bg_color4">
						<input name='contact' value="{$page.vacancy.contact|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Телефон:</td>
					<td class="bg_color4">
						<input name='phone' value="{$page.vacancy.phones|escape:"html"}" style="width:100%">
						<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Факс:</td>
					<td class="bg_color4">
						<input name='fax' value="{$page.vacancy.faxes|escape:"html"}" style="width:100%">
						<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">http://</td>
					<td class="bg_color4">
						<input name='http' value="{$page.vacancy.http|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140" rowspan="2">E-mail:</td>
					<td class="bg_color4"><div style="float:right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить E-Mail" vspace="3" hspace="4"/></a></div></td>
				</tr>
				<tr>
					<td class="bg_color4">
						<span id="email_list">
					{if is_array($page.vacancy.email)}
						{foreach from=$page.vacancy.email item=mail key=_k}
						<span>
							<input name="email[]" value="{$mail|trim}" style="width:95%">{if $_k > 0}<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/_img/design/200608_title/bullet_delete.gif" hspace="4" border="0" alt="Удалить E-Mail"/></a>{/if}</br>
						</span>
						{/foreach}
					{else}
						<span>
							<input name="email[]" style="width:95%"></br>
						</span>
					{/if}
						</span>
						Бесплатный почтовый ящик <b>ваше_имя@{$ENV.site.domain}</b> можно получить <a href="http://{$ENV.site.domain}/mail/reg.php" target=_blank class='s1'>здесь</a>.
					</td>
				</tr>
				{if $page.action != 'vacancy_add'}
				<tr>
					<td class="bg_color2" align="right" width="140">Размещать&nbsp;до:</td>
					<td class="bg_color4">{if $page.vacancy.moderate>=0}{$page.vacancy.vdate}{else}не размещена{/if}</td>
				</tr>
				{if $page.vacancy.moderate>=0}
				<tr>
					<td class="bg_color2" align="right" width="140">Продлить размещение на:</td>
					<td class="bg_color4">
						<select name="srok" size=1>
							<option value="0">не продлять</option>
							<option value="1"{if 1 == $page.vacancy.srok}selected="selected"{/if}>1 неделю</option>
							<option value="2"{if 2 == $page.vacancy.srok}selected="selected"{/if}>2 недели</option>
							<option value="3"{if 3 == $page.vacancy.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4"{if 4 == $page.vacancy.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{/if}
				{/if}
				{if $page.vacancy.is_firm && $page.vacancy.moderate>=0}
				<tr>
					<td class="bg_color2" align="right" width="140">Не отображать на сайте:</td>
					<td class="bg_color4">
						<input type='checkbox' name='hide' value="checked" {if $page.vacancy.hide}checked="checked"{/if}/>
					</td>
				</tr>
				{else}
					{if $page.vacancy.hide}<input type='hidden' name='hide' value="1" checked="checked"/>{/if}
					{if $page.vacancy.moderate<0}
						<input type='hidden' name='moderate' value="{$page.vacancy.moderate}">
					{/if}
				{/if}
			</table><br/>
			<center>
			<input type="submit" name="_submit" value="{if $page.action == 'vacancy_add'}Разместить{else}Изменить{/if}" width="150">&nbsp;&nbsp;&nbsp;
			<input type="button" name="_preview" value="Предварительный просмотр" onclick="vacancy_form.preview.value=1; if (CheckVacForm(vacancy_form)) vacancy_form.submit();">&nbsp;&nbsp;&nbsp;
			{*<input type="reset"  value="  Сброс   "/>&nbsp;&nbsp;&nbsp;*}
			<input type=button value="Назад" onclick="window.history.go(-1)"/></center>
			</form>
<br/>

{/if}

{/if}