<script type="text/javascript" language="javascript" src="/_scripts/modules/job/checkres2.js" charset="windows-1251"></script>

{if $page.action == 'resume_add'}
	{if $page.preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новое резюме - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новое резюме"}
	{/if}
{else}
	{if $page.preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме `$page.resume.resid` - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме `$page.resume.resid`"}
	{/if}
	<div class="title" style="padding:0px 5px 0px 5px;"><a href="/{$ENV.section}/resume/{$page.resume.resid}.html" class="text11" target="_blank">Ссылка на резюме</a></div>
{/if}

{if $page.resume.moderate < 0 && $page.action!='resume_add'}
<div style="padding:10px">
	<p style="color:red"><b>Отказано в размещении резюме</b></p>
	<p style="color:red">{$CONFIG.moderator_marks_resume[$page.resume.moderate].message}</p>
	<p style="color:red">Отредактируйте резюме.</p>
</div>
{/if}

{if $page.resume === false}
<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td align="center" style="color:red">
			<b>Резюме не найдено.</b>
		</td>
	</tr>
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/vacancy.php">К списку вакансий</a> ]</td>
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

{if $page.preview}

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($page.resume.image.file) && !$page.delphoto}<td><img src="{$page.resume.image.file}" width="{$page.resume.image.w}" height="{$page.resume.image.h}" alt="{$page.resume.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				{if $page.resume.fio}
				<tr>
					<td class="bg_color2" align="right" width="130">Ф.И.О.</td>
					<td class="bg_color4">{$page.resume.fio}</td>
				</tr>
				{/if}
				{if $page.resume.city || $page.resume.city_id}
				<tr>
					<td class="bg_color2" align="right" width="130">Город</td>
					<td class="bg_color4">{if $page.resume.city_id}{$page.city_arr[$page.resume.city_id].name}{else}{$page.resume.city}{/if}</td>
				</tr>
				{/if}
				{if $page.resume.dolgnost}
				<tr>
					<td class="bg_color2" align="right" width="130">Должность</td>
					<td class="bg_color4">{$page.resume.dolgnost}</td>
				</tr>
				{/if}
				{if $page.resume.paysum_text}
				<tr>
					<td class="bg_color2" align="right" width="130">Зарплата</td>
					<td class="bg_color4">{$page.resume.paysum_text}</td>
				</tr>
				{/if}
				{if $page.resume.grafik}
				<tr>
					<td class="bg_color2" align="right" width="130">График работы</td>
					<td class="bg_color4">{$page.graphic_arr[$page.resume.grafik]}</td>
				</tr>
				{/if}
				{if $page.resume.jtype}
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы</td>
					<td class="bg_color4">{$page.job_type_arr[$page.resume.jtype]}</td>
				</tr>
				{/if}
				{if $page.resume.educat}
				<tr>
					<td class="bg_color2" align="right" width="130">Образование</td>
					<td class="bg_color4">{$page.education_arr[$page.resume.educat]}</td>
				</tr>
				{/if}
				{if $page.resume.vuz}
				<tr>
					<td class="bg_color2" align="right" width="130">Уч. заведение</td>
					<td class="bg_color4">{$page.resume.vuz|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.stage}
				<tr>
					<td class="bg_color2" align="right" width="130">Стаж</td>
					<td class="bg_color4">{$page.resume.stage}</td>
				</tr>
				{/if}
				{if $page.resume.prevrab}
				<tr>
					<td class="bg_color2" align="right" width="130">Предыдущие места<br>работы</td>
					<td class="bg_color4">{$page.resume.prevrab|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.lang}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание языков</td>
					<td class="bg_color4">{$page.resume.lang|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.comp}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание компьютера</td>
					<td class="bg_color4">{$page.resume.comp|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.baeduc}
				<tr>
					<td class="bg_color2" align="right" width="130">Бизнес-образование</td>
					<td class="bg_color4">{$page.resume.baeduc|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.dopsv}
				<tr>
					<td class="bg_color2" align="right" width="130">Дополнительные<br/>сведения</td>
					<td class="bg_color4">{$page.resume.dopsv|nl2br}</td>
				</tr>
				{/if}
				{if $page.resume.imp_type}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность</td>
					<td class="bg_color4">{$page.imp_type_arr[$page.resume.imp_type]}</td>
				</tr>
				{/if}
				{if $page.resume.pol}
				<tr>
					<td class="bg_color2" align="right" width="130">Пол</td>
					<td class="bg_color4">{$page.sex_arr[$page.resume.pol]}</td>
				</tr>
				{/if}
				{if $page.resume.ability}
				<tr>
					<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности</td>
					<td class="bg_color4">{$page.ability_arr[$page.resume.ability]}</td>
				</tr>
				{/if}
				{if $page.resume.vozrast}
				<tr>
					<td class="bg_color2" align="right" width="130">Возраст</td>
					<td class="bg_color4">{$page.resume.vozrast}</td>
				</tr>
				{/if}
				{if $page.resume.http}
				<tr>
					<td class="bg_color2" align="right" width="130">http://</td>
					<td class="bg_color4">{if $page.resume.http!=""}{$page.resume.http|url:false}{/if}</td>
				</tr>
				{/if}
				{if $page.resume.email}
				<tr>
					{php}
					if ($this->_tpl_vars['page']['resume']['email'] != '') {
						$this->_tpl_vars['page']['resume']['email_text'] = implode(', ',$this->_tpl_vars['page']['resume']['email']);
					}
					{/php}
					<td class="bg_color2" align="right" width="130">E-mail</td>
					<td class="bg_color4">
						{$page.resume.email_text}
					</td>
				</tr>
				{/if}
				{if $page.resume.phone}
				<tr>
					<td class="bg_color2" align="right" width="130">Телефон</td>
					<td class="bg_color4">{$page.resume.phone}</td>
				</tr>
				{/if}
				{if $page.resume.addr}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес</td>
					<td class="bg_color4">{$page.resume.addr}</td>
				</tr>
				{/if}

				<tr>
					<td align='center' colspan='2'>
						<form name="resume_form" method='post'>
						<input type=hidden name="uid" value="{$page.resume.user}">
						<input type=hidden name="back" value="0">
						<input type=hidden name="action" value="{$page.action}">
						<input type=hidden name="vdate" value="{$page.resume.vdate}">
						<input type=hidden name="fio" value="{$page.resume.fio|escape:"html"}">
						<input type=hidden name="pay" value="{$page.resume.paysum_text|escape:"html"}">
						<input type=hidden name="grafik" value="{$page.resume.grafik}">
						<input type=hidden name="jtype" value="{$page.resume.jtype}">
						<input type=hidden name="rid" value="{$page.resume.rid}">
						<input type=hidden name="dol" value="{$page.resume.dolgnost|escape:"html"}">
						<input type=hidden name="educat" value="{$page.resume.educat|escape:"html"}">
						<input type=hidden name="baeduc" value="{$page.resume.baeduc|escape:"html"}">
						<input type=hidden name="ability" value="{$page.resume.ability}">
						<input type=hidden name="vuz" value="{$page.resume.vuz|escape:"html"}">
						<input type=hidden name="pol" value="{$page.resume.pol}">
						<input type=hidden name="age" value="{$page.resume.vozrast}">
						<input type=hidden name="stage" value="{$page.resume.stage}">
						<input type=hidden name="prevrab" value="{$page.resume.prevrab|escape:"html"}">
						<input type=hidden name="imp_type" value="{$page.resume.imp_type}">
						<input type=hidden name="city" value="{$page.resume.city|escape:"html"}">
						<input type=hidden name="city_id" value="{$page.resume.city_id}">
						<input type=hidden name="comp" value="{$page.resume.comp|escape:"html"}">
						<input type=hidden name="lang" value="{$page.resume.lang|escape:"html"}">
						<input type=hidden name="dopsv" value="{$page.resume.dopsv|escape:"html"}">
						<input type=hidden name="adres" value="{$page.resume.addr|escape:"html"}">
						<input type=hidden name="tel" value="{$page.resume.phone|escape:"html"}">
						{foreach from=$page.resume.email item=i}
						<input type=hidden name="email[]" value="{$i}">
						{/foreach}
						<input type=hidden name="http" value="{$page.resume.http}">
						<input type=hidden name="preview_image" value="{$page.resume.image.filename}">
						{if $page.delphoto}
						<input type=hidden name="delphoto" value="{$page.delphoto}">
						{/if}
						<input type="submit" onclick="this.disabled=true; resume_form.submit();" value="{if $page.action == 'resume_add'}Разместить{else}Изменить{/if}" width="150">&nbsp;&nbsp;&nbsp;
						<input type=button value="Назад" onclick="resume_form.back.value=1; resume_form.submit()"/></center>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br/>

{else}

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
		<form name="resume_form" method="post" enctype="multipart/form-data" onSubmit='return CheckResForm(this)'>
		<input type="hidden" name="action" value="{$page.action}">
		<input type="hidden" name="vdate" value="{$page.resume.vdate}">
		<input type="hidden" name="preview" value="0">
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				{if $page.action == 'resume_add'}
				{php} $this->_tpl_vars['selected'] = false; {/php}
				<tr>
					<td class="bg_color2" align="right" width="140">Город</td>
					<td class="bg_color4">
						<select name="city_id" size="1" style="width:200px" onchange="{literal}if (this.value==0) {resume_form.city.disabled = false;} else {resume_form.city.disabled = true; resume_form.city.value='';}{/literal}">
							{foreach from=$page.city_arr item=v key=k}
								{if ($ENV.site.domain=="mgorsk.ru" && $k==2376) || ($ENV.site.domain=="74.ru" && $k!=2376) || ($ENV.site.domain=="tolyatty.ru" && $k==1748) || ($ENV.site.domain=="63.ru" && $k!=1748) || ($ENV.site.domain=="sterlitamak1.ru" && $k==399) || ($ENV.site.domain=="ufa1.ru" && $k!=399) || !in_array($ENV.site.domain,array('mgorsk.ru','74.ru','tolyatty.ru','63.ru','ufa1.ru','sterlitamak1.ru'))}
								<option value="{$k}" {if $page.resume.city_id == $k || ($page.resume.city_id == -1 && $CONFIG.default_city == $k)}{php} $this->_tpl_vars['selected'] = true; {/php} selected="selected"{/if}>{$v.name}</option>
								{/if}
							{/foreach}
							<option value="0" {if !$selected}selected="selected"{/if}>Другой...</option>
						</select>
						{if $ENV.site.domain=="74.ru"}
						<a href="http://mgorsk.ru/job/my/vacancy/add.php" class="text11" target="_blank">Магнитогорск</a>
						{elseif $ENV.site.domain=="mgorsk.ru"}
						<a href="http://74.ru/job/my/vacancy/add.php" class="text11" target="_blank">Челябинская область</a>
						{/if}
						{if $ENV.site.domain=="63.ru"}
						<a href="http://tolyatty.ru/job/my/resume/add.php" class="text11" target="_blank">Тольятти</a>
						{elseif $ENV.site.domain=="tolyatty.ru"}
						<a href="http://63.ru/job/my/resume/add.php" class="text11" target="_blank">Самарская область</a>
						{/if}
						{if $ENV.site.domain=="72.ru"}
						<noindex><a href="http://86.ru/job/my/resume/add.php" rel="nofollow" class="text11" target="_blank">ХМАО</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/my/resume/add.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
						{elseif $ENV.site.domain=="86.ru"}
						<noindex><a href="http://72.ru/job/my/resume/add.php"  rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/my/resume/add.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
                        			{elseif $ENV.site.domain=="89.ru"}
						<noindex><a href="http://72.ru/job/my/resume/add.php" rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://86.ru/job/my/resume/add.php" rel="nofollow" class="text11" target="_blank">ХМАО</a><noindex>
						{/if}
						{if $ENV.site.domain=="ufa1.ru"}
						<a href="http://sterlitamak1.ru/job/my/resume/add.php" class="text11" target="_blank">Стерлитамак</a>
						{elseif $ENV.site.domain=="sterlitamak1.ru"}
						<a href="http://ufa1.ru/job/my/resume/add.php" class="text11" target="_blank">Республика Башкортостан</a>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Другой:</td>
					<td class="bg_color4" align="left">
						<input type="text" name="city" value="{if !$selected}{$page.resume.city|escape:"html"}{/if}" style="width:200px"{if !$page.resume.city} disabled="true"{/if} />
					</td>
				</tr>
			{else}
				<tr>
					<td class="bg_color2" align="right" width="140">Город:</td>
					<td class="bg_color4">
						<input type="hidden" name="city_id" value="{if isset($page.city_arr[$page.resume.city_id])}{$page.resume.city_id}{elseif trim($page.resume.city) == ''}{$CONFIG.default_city}{else}0{/if}"/>
						<input type="hidden" name="city" value="{$page.resume.city|escape:"html"}"/>{if isset($page.city_arr[$page.resume.city_id])}{$page.city_arr[$page.resume.city_id].name}{elseif !empty($page.resume.city)}{$page.resume.city}{else}{$page.city_arr[$CONFIG.default_city].name}{/if}</td>
				</tr>
			{/if}
				<tr>
					<td class="bg_color2" align="right" width="140">ФИО:</td>
					<td class="bg_color4">
						<input name=fio value="{$page.resume.fio|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Раздел:</td>
					<td class="bg_color4">
						<select name="rid" size="1" style="width:100%">
							{foreach from=$page.section_arr.razdel item=v}
								<option value="{$v.rid}" {if $v.rid == $page.resume.rid} selected="selected"{/if}>{$v.rname}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Претендуемая должность:</td>
					<td class="bg_color4">
						<input name="dol" value="{$page.resume.dolgnost|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Зарплата:</td>
					<td class="bg_color4">
						<input name=pay size=10 maxlength="35" value="{$page.resume.paysum_text|escape:"html"}">&nbsp;&nbsp;руб.
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">График работы:</td>
					<td class="bg_color4">
						<select name=grafik size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.graphic_arr item=v key=k}
								<option value="{$k}"{if $k == $page.resume.grafik} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Тип работы:</td>
					<td class="bg_color4">
						<select name=jtype size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.job_type_arr item=v key=k}
								<option value="{$k}"{if $k == $page.resume.jtype} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Образование:</td>
					<td class="bg_color4">
						<select name=educat size=1 style="width:200px">
							<option value="0">Любое</option>
							{foreach from=$page.education_arr item=v key=k}
								<option value="{$k}"{if $k == $page.resume.educat} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Учебное заведение:</td>
					<td class="bg_color4">
						<textarea name="vuz" rows=4 wrap=virtual style="width:100%">{$page.resume.vuz|escape:"html"}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Стаж:</td>
					<td class="bg_color4">
						<input name="stage" size=4 value="{$page.resume.stage|escape:"html"}"> лет
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Места предыдущей работы:</td>
					<td class="bg_color4">
						<textarea name="prevrab" rows=4 wrap=virtual style="width:100%">{$page.resume.prevrab}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Знание языков:</td>
					<td class="bg_color4">
						<textarea name=lang rows=4 wrap=virtual style="width:100%">{$page.resume.lang}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Знание компьютера:</td>
					<td class="bg_color4">
						<textarea name=comp rows=4 wrap=virtual style="width:100%">{$page.resume.comp}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Бизнес-образование:</td>
					<td class="bg_color4">
						<textarea name="baeduc" rows=4 wrap=virtual style="width:100%">{$page.resume.baeduc}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Дополнительные сведения:</td>
					<td class="bg_color4">
						<textarea name=dopsv rows=4 wrap=virtual style="width:100%">{$page.resume.dopsv}</textarea>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Важность:</td>
					<td class="bg_color4">
						<select name=imp_type size=1 style="width:100%">
							<option value="0">Нет</option>
							{foreach from=$page.imp_type_arr item=v key=k}
								<option value="{$k}"{if $k == $page.resume.imp_type} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Пол:</td>
					<td class="bg_color4">
						<select name=pol size=1 style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.sex_arr item=v key=k}
								<option value="{$k}"{if $k == $page.resume.pol} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Степень ограничения трудоспособности:</td>
					<td class="bg_color4">
						<select name=ability size=1 style="width:200px">
							{foreach from=$page.ability_arr item=a key=k}
								<option value="{$k}" {if $k == $page.resume.ability}selected{/if}>{$a}</option>
							{/foreach}
						</select><br/>
						<span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Возраст:</td>
					<td class="bg_color4">
						<input name=age value="{$page.resume.vozrast|escape:"html"}" style="width:200px">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">&nbsp;</td>
					<td class="bg_color4">
						<input name="getms" id="getms" type="checkbox" value="1"{if $page.resume.getms} checked="checked"{/if}>
						<label for="getms">Получать личные сообщения</label>
					</td>
				</tr>
				<tr>
					<th colspan="2">Контактная информация</th>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Адрес:</td>
					<td class="bg_color4">
						<input name=adres value="{$page.resume.addr|escape:"html"}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Телефон:</td>
					<td class="bg_color4">
						<input name=tel value="{$page.resume.phone|escape:"html"}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">http://</td>
					<td class="bg_color4">
						<input name=http value="{$page.resume.http|escape:"html"}" style="width:100%">
					</td>
				</tr>
				{*<tr>
					<td class="bg_color2" align="right" width="140" rowspan="2">E-mail:</td>
					<td class="bg_color4" width="100%" align="right">
						<a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить E-Mail"/></a>
					</td>
					<td class="bg_color4" nowrap="nowrap">
						<a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a>
					</td>
				</tr>*}
				<tr>
					<td class="bg_color2" align="right" width="140" rowspan="2">E-mail:</td>
					<td class="bg_color4"><div style="float:right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить E-Mail" vspace="3" hspace="4"/></a></div></td>
				</tr>
				<tr>
					<td class="bg_color4"><span id="email_list">
					{if is_array($page.resume.email)}
					{foreach from=$page.resume.email item=mail key=k}
						<span>
							<input name="email[]" value="{$mail|trim}" style="width:100%">{if $k>0}<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить E-Mail"/></a>{/if}</br>
						</span>
					{/foreach}
					{else}
						<span>
							<input name="email[]" value="{$mail|trim}" style="width:100%"></br>
						</span>
					{/if}
					</span>
					Бесплатный почтовый ящик <b>ваше_имя@{$ENV.site.domain}</b> можно получить <a href="http://{$ENV.site.domain}/mail/reg.php" target="_blank">здесь</a>.
					</td>
				</tr>

				<tr>
					<td class="bg_color2" align="right">Фото</td>
					<td class="bg_color4">
						{if !empty($page.resume.image.file)}<img src="{$page.resume.image.file}" alt="{$page.fio|escape:"html"}" width="{$page.resume.image.w}" height="{$page.resume.image.h}" align="left"><input type="checkbox" name="delphoto" value="checked" onchange="{literal}if (this.checked) {resume_form.photo.style.visibility='hidden'} else {resume_form.photo.style.visibility='visible'}{/literal}">&nbsp;&nbsp;Удалить<br/><br/>{/if}<div id=photo><input size=30 type=file id=photo name="photo" value=""></div><br>JPG файл размером не более 1,5Мб
						<input type=hidden name="preview_image" value="{$page.resume.image.filename}">
					</td>
				</tr>
				{if $page.action == 'resume_add'}
				<tr>
					<td class="bg_color2" align="right" width="140">Срок размещения:</td>
					<td class="bg_color4">
						<select name=srok size=1 style="width:200px">
							<option value="1" {if 1 == $page.resume.srok}selected="selected"{/if}>1 неделя</option>
							<option value="2" {if 2 == $page.resume.srok}selected="selected"{/if}>2 недели</option>
							<option value="3" {if 3 == $page.resume.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4" {if 4 == $page.resume.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{else}
				<tr>
					<td class="bg_color2" align="right" width="140">Размещать&nbsp;до:</td>
					<td class="bg_color4">{$page.resume.vdate}</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Продлить размещение на:</td>
					<td class="bg_color4">
						<select name=srok size=1>
							<option value="0">не продлять</option>
							<option value="1"{if 1 == $page.resume.srok}selected="selected"{/if}>1 неделю</option>
							<option value="2"{if 2 == $page.resume.srok}selected="selected"{/if}>2 недели</option>
							<option value="3"{if 3 == $page.resume.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4"{if 4 == $page.resume.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{/if}
			</table>
			<br/>
			<center>
			<input type="submit" name="_submit" value="{if $page.action == 'resume_add'}Добавить{else}Сохранить{/if}">&nbsp;&nbsp;&nbsp;
			<input type="button" name="_preview" value="Предварительный просмотр" onclick="resume_form.preview.value=1; if (CheckResForm(resume_form)) resume_form.submit();">&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Сброс">&nbsp;&nbsp;&nbsp;
			<input type=button value="Назад" onclick="window.history.go(-1)"></center>
			</form>
<br/>

{/if}

{/if}

{if $CURRENT_ENV.regid == 74}
{include file="design/200608_title/common/block_main_support.tpl"}
{/if}