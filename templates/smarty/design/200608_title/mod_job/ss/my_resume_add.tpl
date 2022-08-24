{*изменено по требованию Россвязьнадзор*}

<script type="text/javascript" language="javascript" src="/_scripts/modules/job/checkres3.js"></script>

{if $page.action == 'resume_add'}
	{if $page.Preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новое резюме - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Новое резюме"}
	{/if}
{else}
	{if $page.Preview}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме `$page.Resume.ResumeID` - Предварительный просмотр"}
	{else}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме `$page.Resume.ResumeID`"}
	{/if}
	<div class="title" style="padding:0px 5px 0px 5px;"><a href="/{$ENV.section}/resume/{$page.Resume.ResumeID}.html" class="text11" target="_blank">Ссылка на резюме</a></div>
{/if}

{if $page.Resume.moderate < 0 && $page.action!='resume_add'}
<div style="padding:10px">
	<p style="color:red"><b>Отказано в размещении резюме</b></p>
	<p style="color:red">{$CONFIG.moderator_marks_resume[$page.Resume.moderate].message}</p>
	<p style="color:red">Отредактируйте резюме.</p>
</div>
{/if}


{if $page.Resume === false}
<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td align="center" style="color:red">
			<b>Резюме не найдено.</b>
		</td>
	</tr>
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/resume.php">К списку резюме</a> ]</td>
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

{if $page.Preview}
<form name="resume_form" method="post">
<input type=hidden name="PreviewData" value="{$page.PreviewData}">
<input type=hidden name="back" value="0">
<input type=hidden name="action" value="{$page.action}">
<input type=hidden name="PreviewImage" value="{$page.Resume.Image.filename}">
{if $page.DeletePhoto}
<input type="hidden" name="DeletePhoto" value="{$page.DeletePhoto}">
{/if}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($page.Resume.Image.file) && !$page.DeletePhoto}
		<td>
			<img src="{$page.Resume.Image.file}" 
				width="{$page.Resume.Image.w}" 
				height="{$page.Resume.Image.h}" 
				alt="{$page.Resume.FirstName}" hspace="2" vspace="2" align="left"/>
		</td>
		{/if}
		<td width="100%">
		
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Личные сведения</th>
				</tr>
				{if $page.Resume.MidName || $page.Resume.FirstName || $page.Resume.LastName}
				<tr>
					<td class="bg_color2" align="right" width="130">Имя{*Ф.И.О.*}:</td>
					<td class="bg_color4">{$page.Resume.MidName} {$page.Resume.FirstName} {$page.Resume.LastName}</td>
				</tr>
				{/if}
				{if $page.Sex_arr[$page.Resume.Sex]}
				<tr>
					<td class="bg_color2" align="right" width="130">Пол:</td>
					<td class="bg_color4">{$page.Sex_arr[$page.Resume.Sex]}</td>
				</tr>
				{/if}

				{if $page.Resume.Age}
				<tr>
					<td class="bg_color2" align="right">Возраст:</td>
					<td class="bg_color4">{$page.Resume.Age}</td>
				</tr>
				{/if}
			</table><br/>

			{if $page.Resume.CityText}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="3">Место жительства</th>
				</tr>
				<tr>
					<td align="right" class="bg_color2" width="130">Город:</td>
					<td class="bg_color4" colspan="2">
						{$page.Resume.CityText}
					</td>
				</tr>
				{if $page.Resume.DistrictText}
				<tr>
					<td align="right" class="bg_color2">Район:</td>
					<td class="bg_color4">
						{$page.Resume.DistrictText}
					</td>
				</tr>
				{/if}
				{if $page.Resume.StreetText}
				<tr>
					<td align="right" class="bg_color2">Улица:</td>
					<td class="bg_color4">
						{$page.Resume.StreetText}
					</td>
				</tr>
				{if $page.Resume.LocationHouse}
				<tr>
					<td align="right" class="bg_color2">Дом:</td>
					<td class="bg_color4" nowrap="nowrap">
						{$page.Resume.LocationHouse}
					</td>
				</tr>
				{/if}
				{/if}
				
			</table><br/>
			{/if}

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Контакты</th>
				</tr>

				{if $page.Resume.AddressTemp}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес:</td>
					<td class="bg_color4">
						{$page.Resume.AddressTemp}
					</td>
				</tr>
				{/if}

				{if $page.Resume.Phone}
				<tr>
					<td class="bg_color2" align="right" width="130">Телефон:</td>
					<td class="bg_color4">
						{$page.Resume.Phone}
					</td>
				</tr>
				{/if}
				{if $page.Resume.Email}
				<tr>
					<td class="bg_color2" align="right" width="130">E-mail:</td>
					<td class="bg_color4">
						{', '|implode:$page.Resume.Email}
					</td>
				</tr>
				{/if}
			</table><br/>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Пожелания к будущей работе</th>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Отрасль:</td>
					<td class="bg_color4">
						{$page.Resume.Branch}
					</td>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Претендуемая должность:</td>
					<td class="bg_color4">
						{$page.Resume.Position}
					</td>
				</tr>
				
				{foreach from=$page.interestGroupTypes_arr item=group key=type}
					{if is_array($page.Resume.Interest[$type]) && sizeof($page.Resume.Interest[$type])}
						{capture name="Interest_`$type`"}
							<tr>
								<td class="bg_color2" align="right" width="130">%1$s:</td>
								<td class="bg_color4">
									<div>
									{foreach from=$page.Resume.Interest[$type] item=l}
										<div>{$l.title}</div>
									{/foreach}
									</div>
								</td>
							</tr>
						{/capture}						
					{/if}
				{/foreach}
				
				{if $smarty.capture.Interest_1}
					{$smarty.capture.Interest_1|sprintf:"Профессиональные интересы"}
				{/if}
				
				<tr>
					<td class="bg_color2" align="right" width="130">Зарплата:</td>
					<td class="bg_color4">
						{$page.Resume.WageText}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="130">График работы:</td>
					<td class="bg_color4">
						{$page.Schedule_arr[$page.Resume.Schedule]}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы:</td>
					<td class="bg_color4">
						{$page.WorkType_arr[$page.Resume.WorkType]}
					</td>
				</tr>

			</table><br/>
			
			{if $page.Resume.ProfessionalSkills || $page.Resume.PersonalCharacteristics}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Профессиональные навыки</th>
				</tr>
				{if $page.Resume.ProfessionalSkills}
				<tr>
					<td class="bg_color2" align="right" width="130">Описание:</td>
					<td class="bg_color4">
						{$page.Resume.ProfessionalSkills|nl2br}
					</td>
				</tr>
				{/if}
				{if $page.Resume.PersonalCharacteristics}
				<tr>
					<td class="bg_color2" align="right" width="130">Личная характеристика:</td>
					<td class="bg_color4">
						{$page.Resume.PersonalCharacteristics|nl2br}
					</td>
				</tr>
				{/if}
			</table><br/>
			{/if}

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Опыт работы</th>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Стаж:</td>
					<td class="bg_color4">
						{$page.Resume.Stage}
					</td>
				</tr>

				{if $page.Resume.CareerTemp || !empty($page.Resume.PlaceList.work_place_arr)}
				<tr>
					<td class="bg_color2" align="right" width="130">Места предыдущей работы:</td>
					<td class="bg_color4 text11">
						{if !empty($page.Resume.PlaceList.work_place_arr)}
							<div>
							{foreach from=$page.Resume.PlaceList.work_place_arr item=l key=k name=pl}
								{capture name="place"}
									<div><strong>{php}echo $this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']][$this->_tpl_vars['l']['citycode']]['Name'];{/php}, {$l.name}</strong></div>
									{if $l.position || $l.y_start}
										<div class="txt_color1" style="font-size:13px"><strong>{$l.position}
										{if $l.y_start || $l.y_end}({if $l.y_start}{$page.Resume.months_arr[$l.m_start]} {$l.y_start}{/if}{if $l.y_end} - {$page.Resume.months_arr[$l.m_end]} {$l.y_end}{elseif $l.y_start} - по настоящее время{/if}){/if}</strong></div>
									{/if}
									<br/><div>{$l.comment|nl2br}</div>
								{/capture}
								
								<div>{$smarty.capture.place|trim:" ,"}</div>{if !$smarty.foreach.pl.last}<br/>{/if}
							{/foreach}
							</div>
						{/if}
					
						{$page.Resume.CareerTemp}
					</td>
				</tr>
				{/if}
			</table><br/>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Образование</th>
				</tr>

				{if $page.Education_arr[$page.Resume.Education]}
				<tr>
					<td class="bg_color2" align="right" width="130">Основное:</td>
					<td class="bg_color4">
						{$page.Education_arr[$page.Resume.Education]}
					</td>
				</tr>
				{/if}

				{if !empty($page.Resume.PlaceList.education_place_arr)}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4 text11">
						{if !empty($page.Resume.PlaceList.education_place_arr)}
							<div>
							{foreach from=$page.Resume.PlaceList.education_place_arr item=l key=k name=pl}
								{capture name="place"}
									<div><strong>{php}echo $this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']][$this->_tpl_vars['l']['citycode']]['Name'];{/php}, {$l.name}</strong></div>
									{if $l.chair || $l.faculty || $l.course || $l.status}
									<div class="txt_color1" style="font-size:13px">
										<strong>
											{php}
												$info = array();
												if ($this->_tpl_vars['l']['faculty'])
													$info[] = 'факультет '.$this->_tpl_vars['l']['faculty'];
												
												if ($this->_tpl_vars['l']['chair'])
													$info[] = 'кафедра '.$this->_tpl_vars['l']['chair'];
												
												if ($this->_tpl_vars['page']['course_form_arr'][$this->_tpl_vars['l']['course']])
													$info[] = 'Форма обучения '.$this->_tpl_vars['page']['course_form_arr'][$this->_tpl_vars['l']['course']];
												
												if ($this->_tpl_vars['page']['status_arr'][$this->_tpl_vars['l']['status']])
													$info[] = $this->_tpl_vars['page']['status_arr'][$this->_tpl_vars['l']['status']];
													
												echo implode(', ', $info);
											{/php}
										</strong>
									</div>
									{/if}
									<div>{if $l.y_start}({if $l.y_start}{$l.y_start}{/if}{if $l.y_end} - {$l.y_end}{elseif $l.y_start} - по настоящее время{/if}){/if}</div>
								{/capture}
								
								<div>{$smarty.capture.place|trim:" ,"}</div>{if !$smarty.foreach.pl.last}<br/>{/if}
							{/foreach}
							</div>
						{/if}
					</td>
				</tr>
				{/if}
				
				{if $page.Resume.FurtherEducation}
				<tr>
					<td class="bg_color2" align="right" width="130">Дополнительное образование:</td>
					<td class="bg_color4">
						{$page.Resume.FurtherEducation|nl2br}
					</td>
				</tr>
				{/if}
			</table><br/>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Дополнительные сведения</th>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Наличие автомобиля</td>
					<td class="bg_color4">
						{if $page.Resume.Auto}Да{else}Нет{/if}
					</td>
				</tr>
				{if $page.Travel_arr[$page.Resume.Travel]}
				<tr>
					<td class="bg_color2" align="right" width="130">Готовность к командировкам:</td>
					<td class="bg_color4">
						{$page.Travel_arr[$page.Resume.Travel]}
					</td>
				</tr>
				{/if}
				{if $page.Marriad_arr[$page.Resume.Marriad]}
				<tr>
					<td class="bg_color2" align="right" width="130">Семейное положение:</td>
					<td class="bg_color4">
						{$page.Marriad_arr[$page.Resume.Marriad]}
					</td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="130">Наличие детей:</td>
					<td class="bg_color4">
						{$page.Children_arr[$page.Resume.Children]}
					</td>
				</tr>
				{if $page.Ability_arr[$page.Resume.Ability]}
				<tr>
					<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности:</td>
					<td class="bg_color4">
						{$page.Ability_arr[$page.Resume.Ability]}
					</td>
				</tr>
				{/if}
				
				{if $smarty.capture.Interest_2}
					{$smarty.capture.Interest_2|sprintf:"Мои увлечения"}
				{/if}

				{if $page.Importance_arr[$page.Resume.Importance]}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность:</td>
					<td class="bg_color4">
						{$page.Importance_arr[$page.Resume.Importance]}
					</td>
				</tr>
				{/if}
				
				<tr>
					<td align='center' colspan='2'>
						<input type="submit" name="_submit" onclick="this.disabled=true; resume_form.submit(); return true;" value="{if $page.action == 'resume_add'}Разместить{else}Изменить{/if}" width="150">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="_back" value="Назад" onclick="resume_form.back.value=1; return true;"/>
					</td>
				</tr>
			</table>
		
		{*
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				{if $page.Resume.FirstName}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Ф.И.О.</td>
					<td class="bg_color4">{$page.Resume.MidName} {$page.Resume.FirstName} {$page.Resume.LastName}</td>
				</tr>
				{/if}
				{if $page.city_arr[$page.Resume.LocationCountry][$page.Resume.LocationCity].Name}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Город</td>
					<td class="bg_color4">{$page.city_arr[$page.Resume.LocationCountry][$page.Resume.LocationCity].Name}</td>
				</tr>
				{/if}
				{if $page.Resume.Position}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Должность</td>
					<td class="bg_color4">{$page.Resume.Position}</td>
				</tr>
				{/if}
				{if $page.Resume.WageText}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Зарплата</td>
					<td class="bg_color4">{$page.Resume.WageText}</td>
				</tr>
				{/if}
				{if $page.Resume.Schedule}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">График работы</td>
					<td class="bg_color4">{$page.Schedule_arr[$page.Resume.Schedule]}</td>
				</tr>
				{/if}
				{if $page.Resume.WorkType}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Тип работы</td>
					<td class="bg_color4">{$page.WorkType_arr[$page.Resume.WorkType]}</td>
				</tr>
				{/if}
				{if $page.Resume.Education}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Образование</td>
					<td class="bg_color4">{$page.Education_arr[$page.Resume.Education]}</td>
				</tr>
				{/if}
				{if $page.Resume.Stage}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Стаж</td>
					<td class="bg_color4">{$page.Resume.Stage}</td>
				</tr>
				{/if}
				{if $page.Resume.CareerTemp}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Предыдущие места работы</td>
					<td class="bg_color4">{$page.Resume.CareerTemp|nl2br}</td>
				</tr>
				{/if}
				{if $page.Resume.ProfessionalSkills}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Профессиональные навыки</td>
					<td class="bg_color4">{$page.Resume.ProfessionalSkills|nl2br}</td>
				</tr>
				{/if}
				{if $page.Resume.FurtherEducation}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Дополнительное образование</td>
					<td class="bg_color4">{$page.Resume.FurtherEducation|nl2br}</td>
				</tr>
				{/if}
				{if $page.Resume.About}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Мои увлечения</td>
					<td class="bg_color4">{$page.Resume.About|nl2br}</td>
				</tr>
				{/if}
				{if $page.Resume.Importance}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Важность</td>
					<td class="bg_color4">{$page.Importance_arr[$page.Resume.Importance]}</td>
				</tr>
				{/if}
				{if $page.Resume.Sex}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Пол</td>
					<td class="bg_color4">{$page.Sex_arr[$page.Resume.Sex]}</td>
				</tr>
				{/if}
				{if $page.Resume.Ability}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Степень ограничения трудоспособности</td>
					<td class="bg_color4">{$page.Ability_arr[$page.Resume.Ability]}</td>
				</tr>
				{/if}
				{if $page.Resume.Age}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Возраст</td>
					<td class="bg_color4">{$page.Resume.Age}</td>
				</tr>
				{/if}
				{if $page.Resume.HTTP}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">http://</td>
					<td class="bg_color4">{if $page.Resume.HTTP!=""}{$page.Resume.HTTP|url:false}{/if}</td>
				</tr>
				{/if}
				{if $page.Resume.Email}
				<tr>
					{php}
					if ($this->_tpl_vars['page']['Resume']['Email'] != '') {
						$this->_tpl_vars['page']['Resume']['email_text'] = implode(', ',$this->_tpl_vars['page']['Resume']['Email']);
					}
					{/php}
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">E-mail</td>
					<td class="bg_color4">
						{$page.Resume.email_text}
					</td>
				</tr>
				{/if}
				{if $page.Resume.Phone}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Телефон</td>
					<td class="bg_color4">{$page.Resume.Phone}</td>
				</tr>
				{/if}
				{if $page.Resume.AddressTemp}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="130">Адрес</td>
					<td class="bg_color4">{$page.Resume.AddressTemp}</td>
				</tr>
				{/if}

				<tr>
					<td align='center' colspan='2'>
						<input type="submit" name="_submit" onclick="this.disabled=true; resume_form.submit(); return true;" value="{if $page.action == 'resume_add'}Разместить{else}Изменить{/if}" width="150">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="_back" value="Назад" onclick="resume_form.back.value=1; return true;"/>
					</td>
				</tr>
			</table>
		*}
		</td>
	</tr>
</table>
</form>
<br/>

{else}

<script language="JavaScript">
{literal}
<!--
function addEmailField() {

	var list = document.getElementById('email_list');

	fold = document.createElement('span');
	fold.innerHTML = ''+
	'<input name="Email[]" value="" style="width:95%" />'+
	'<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/_img/design/200608_title/bullet_delete.gif" hspace="4" border="0" alt="Удалить E-Mail"/></a><br/>';
	list.appendChild(fold);
}

var InterestGroup = {};

function addInterestField(type) {

	var list = $('#interest_list_'+type);
	var fold = $('<span></span>');
	
	list.append(fold);
	
	var fieldID = $('<input type="hidden" />').attr({
		name: 'Interest['+type+'][id][]',
		value: ''
	});
	
	var fieldText = $('<input type="text" />').attr({
		name: 'Interest['+type+'][text][]',
		value: ''
	}).css({
		width: '95%'
	});
	
	fold.append(fieldID);
	fold.append(fieldText);
	fold.append(
		'<a onclick="removeInterestField(this, '+type+')" href="javascript:void(0)" title="Удалить интерес"><img src="/_img/design/200608_title/bullet_delete.gif" hspace="4" border="0" alt="Удалить интерес"/></a><br/>'
	);
	
	setInterestSuggest(fieldText, fieldID, type);
}

function removeInterestField(node, type) {

	$(node).parents(':first').remove();
	if ( $('#interest_list_'+type+' > span').size() == 0 )
		addInterestField(type);
}

function setInterestSuggest(fieldText, fieldID, type) {

	fieldText.autocomplete("/service/source/db.interest_v2", {
		extraParams: {
			action: 'interests',
			group: InterestGroup[type]
		},
		dataType: 'json',
		parse: function(json) {
			var parsed = [];
			if ( !json.list || !json.list.length )
				return parsed;

			for (var i in json.list) {
				parsed[parsed.length] = {
					data: json.list[i].title,
					value: json.list[i].id,
					result: json.list[i].title
				};
			}
			return parsed;
		},

		formatItem: function(text, i, max, value) {
			return text;
		},
		max: 20
	}).result(function(event, title, value) {

		fieldID.val(value);

		fieldText.unautocomplete();
		fieldText.bind("keyup", function(event) {
			var curTitle = this.value;
			if ( title == curTitle)
				return ;

			fieldID.val('');
			var fold = $($(this).get(0).parentNode);
			var fieldText = $('<input type="text">').attr({
				name: $(this).attr('name'),
				value: curTitle
			}).css({
				width: $(this).css('width')
			});
			
			fieldText.insertAfter(this);
			
			fieldText = setInterestSuggest(fieldText, fieldID, type);
			fieldText.flushCache();
			fieldText.focus();
			fieldText.click();

			if ( $.browser.opera )
				fieldText.keypress();
			else
				fieldText.keydown();
			fieldText.click();
			$(this).remove();
		});
	});
	
	return fieldText;
}

//-->
{/literal}
</script>

Форму резюме желательно заполнять целиком, ничего не пропуская. <br/>
Поля, помеченные звездочкой  <span style="color: red">*</span>, нужно заполнить обязательно. 
<br/><br/>

{if isset($UERROR->ERRORS.global)}
	<br/><div align="center" style="color:red;"><b>
		{$UERROR->ERRORS.global}
	</b></div><br/><br/>
{/if}

		<form name="resume_form" method="post" enctype="multipart/form-data" onSubmit='return CheckResForm(this)'>
		<input type="hidden" name="action" value="{$page.action}">
		<input type="hidden" name="ValidDate" value="{$page.Resume.ValidDate}">
		<input type="hidden" name="preview" value="0">
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="2">Личные сведения</th>
				</tr>
				
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Фамилия</td>
					<td class="bg_color4">
						<input name="MidName" value="{$page.Resume.MidName}" style="width:100%">
					</td>
				</tr>
				{if isset($UERROR->ERRORS.firstname)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.firstname}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Имя <span style="color: red">*</span></td>
					<td class="bg_color4">
						<input name="FirstName" value="{$page.Resume.FirstName}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Отчество</td>
					<td class="bg_color4">
						<input name="LastName" value="{$page.Resume.LastName}" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Пол</td>
					<td class="bg_color4">
						<table class="table0">
							<tr>
								<td>
									<input type="radio" name="Sex" id="Sex1" value="1" {if 1 == $page.Resume.Sex} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Sex1"> Мужской</label>
								</td>
								<td>
									<input type="radio" name="Sex" id="Sex2" value="2" {if 2 == $page.Resume.Sex} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Sex2"> Женский</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				{if isset($UERROR->ERRORS.birthday)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.birthday}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right">День рождения</td>
					<td class="bg_color4">
						День
						<select name="birthday_day">
							<option value="0">----</option>
							{foreach from=$page.days_arr item=l}
							<option value="{$l}"{if $page.Resume.birthday_day==$l} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
						Месяц
						<select name="birthday_month">
							<option value="0">----</option>
							{foreach from=$page.months_arr item=l key=k}
							<option value="{$k}"{if $page.Resume.birthday_month==$k} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
						Год
						<select name="birthday_year">
							<option value="0">----</option>
							{foreach from=$page.years_arr item=l}
							<option value="{$l}"{if $page.Resume.birthday_year==$l} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
					</td>
				</tr>
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="3">Место жительства</th>
				</tr>
				{if isset($UERROR->ERRORS.city)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.city}</span></td>
					</tr>
				{/if}
				<tr>
					<td align="right" class="bg_color2" width="140">Город <span style="color: red">*</span></td>
					<td class="bg_color4" colspan="2">
						<input type="hidden" id="addr_country" value="{$page.Resume.LocationCountry}" />
						<select name="city" id="addr_city" onchange="Address.ChangeCity('addr_country', 'addr_city', 'addr_district', 'addr_street', 'addr_house')" style="width:100%;">
							<option value="0"> - Выберите город - </option>
			{foreach from=$page.city_arr[$page.Resume.LocationCountry] item=l key=k}
							<option value="{$l.Code}"{if $l.Code===$page.Resume.LocationCity} selected="selected"{/if}>{$l.Name}</option>
			{/foreach}
							<option value="-1"> - Другой - </option>
						</select>
						{if $ENV.site.domain=="ufa1.ru"}
						<a href="http://sterlitamak1.ru/job/my/resume/add.php" class="text11" target="_blank">Стерлитамак</a>
						{/if}
					</td>
				</tr>
				<tr id="addr_district_cont" style="{if empty($page.district_arr)}display: none;{/if}width:100%">
					<td align="right" class="bg_color2">Районы</td>
					<td class="bg_color4">
						<select name="district" id="addr_district" style="width:244px;">
							<option value="0"> - Выберите район - </option>
			{foreach from=$page.district_arr item=l key=k}
							<option value="{$l.Code}" {if $l.Code===$page.Resume.LocationDistrict} selected="selected"{/if}>{$l.Name}</option>
			{/foreach}
						</select>
					</td>
				</tr>
				<tr id="addr_street_cont" {if  $page.street_count <= 0} style="display: none;"{/if}>
					<td align="right" class="bg_color2">Улица</td>
					<td class="bg_color4">
						<select name="street" id="addr_street" onchange="Address.ChangeStreet('addr_city', 'addr_street', 'addr_house')" style="width:100%;{if $page.street_count >= 200} display: none;{/if}">
							<option value="0"> - Выберите улицу - </option>
							{if $page.street_count >= 50}
							<option value="" disabled="disabled">-------------</option>
							<option value="-2">Поиск по списку</option>
							<option value="" disabled="disabled">-------------</option>
							{/if}
			{foreach from=$page.street_arr item=l key=k}
							<option value="{$l.Code}"{if $l.Code===$page.Resume.LocationStreet} selected="selected"{assign var="StreetName" value=$l.Name}{/if}>{$l.Name}</option>
			{/foreach}
						</select>
						{if $page.street_count >= 200}
							<script><!--
								Address.StreetRestSuggest('{$page.Resume.LocationCity}', $('#addr_street'){if $StreetName}, '{$StreetName}'{/if});
							--></script>
						{/if}
					</td>
				</tr>
				{if $page.street_count && isset($UERROR->ERRORS.house)}
				<tr>
					<td>&nbsp;</td>
					<td class="error"><span>{$UERROR->ERRORS.house}</span></td>
				</tr>
				{/if}
				<tr id="addr_house_cont" {if  $page.street_count <= 0 || !$page.Resume.LocationStreet} style="display: none;"{/if}>
					<td align="right" class="bg_color2">Дом</td>
					<td class="bg_color4" nowrap="nowrap">
						<select name="house" id="addr_house" style="width:100%;display: none;">
							<option value="0"> - Выберите дом - </option>
			{foreach from=$page.house_arr item=l key=k}
							<option value="{$l.Code}"{if $l.Code===$page.Resume.LocationHouse} selected="selected"{/if}>{$l.Name}</option>
			{/foreach}
						</select>
						<div id="addr_house_simple">
							<input type="text" name="House" value="{$page.Resume.House}" maxlength="8" style="width:208px;"/> - 
							<input type="text" name="HouseIndex" value="{$page.Resume.HouseIndex}" style="width:23px" maxlength="2" />
							<br/><small>Пример: 37, 29-Б</small>
						</div>
					</td>
				</tr>
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="2">Контакты</th>
				</tr>
				
				{if isset($UERROR->ERRORS.address)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.address}</span></td>
					</tr>
				{/if}
				{if $page.Resume.AddressTemp}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Адрес</td>
					<td class="bg_color4">
						<input name="AddressTemp" value="{$page.Resume.AddressTemp}" style="width:100%">
					</td>
				</tr>
				{/if}
				
				{if isset($UERROR->ERRORS.phone)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.phone}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Телефон <span style="color: red">*</span></td>
					<td class="bg_color4">
						<input name="Phone" value="{$page.Resume.Phone}" style="width:100%">
						<small><span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></small>
					</td>
				</tr>
				{if isset($UERROR->ERRORS.email)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.email}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140" rowspan="2">E-mail <span style="color: red">*</span></td>
					<td class="bg_color4"><span id="email_list">
					{if is_array($page.Resume.Email)}
					{foreach from=$page.Resume.Email item=mail key=k}
						<span>
							<input name="Email[]" value="{$mail|trim}" style="width:{if $k>0}95{else}100{/if}%">{if $k>0} <a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить E-Mail"/></a>{/if}<br/>
						</span>
					{/foreach}
					{else}
						<span>
							<input name="Email[]" value="{$page.Resume.Email|trim}" style="width:100%"><br />
						</span>
					{/if}
					</span>
					</td>
				</tr>
				<tr>
					<td class="bg_color4">
						<div style="float:right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить E-Mail" vspace="3" hspace="4"/></a></div>
						<small><span style="color:#808080">Бесплатный почтовый ящик <b>ваше_имя@{$ENV.site.domain}</b> можно получить <a href="http://{$ENV.site.domain}/mail/reg.php" target="_blank">здесь</a>.</span></small>
					</td>
				</tr>
				
				{*<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">http://</td>
					<td class="bg_color4">
						<input name="HTTP" value="{$page.Resume.HTTP}" style="width:100%">
					</td>
				</tr>*}
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="2">Пожелания к будущей работе</th>
				</tr>
				
				{if isset($UERROR->ERRORS.branch)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.branch}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Отрасль</td>
					<td class="bg_color4">
						<select name="BranchID" size="1" style="width:100%">
							{foreach from=$page.Branch_arr.razdel item=v}
								<option value="{$v.rid}" {if $v.rid == $page.Resume.BranchID} selected="selected"{/if}>{$v.rname}</option>
							{/foreach}
						</select><br/>
						<small><span style="color:#808080">Выберите одну отрасль, которая наиболее соответствует заявленной вами должности.</span></small>
					</td>
				</tr>
				
				{if isset($UERROR->ERRORS.position)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.position}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Претендуемая должность <span style="color: red">*</span></td>
					<td class="bg_color4">
						<input name="Position" id="position_suggest" value="{$page.Resume.Position}" style="width:100%">
						<script>
				<!--
				{literal}

					$(document).ready(function() {

				$('#position_suggest').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_place_position'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Text,
						value: '',
						result: json[i].Text
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		});

		});
					{/literal}

				 //--></script>
					</td>
				</tr>
				
				{foreach from=$page.interestGroupTypes_arr item=group key=type}
					<script>
					<!--
						InterestGroup[{$type}] = {$group};
					//-->
					</script>
					{capture name="Interest_`$type`"}
						<tr>
							<td class="bg_color2" valign="top" style="padding-top:7px" align="right" rowspan="2" width="140">%1$s</td>
							<td class="bg_color4">

							<span id="interest_list_{$type}">
							{if is_array($page.Resume.Interest[$type]) && sizeof($page.Resume.Interest[$type])}
							{foreach from=$page.Resume.Interest[$type] item=interest key=k}
								{if trim($interest.title) != ''}
								<span>
									<input id="i_id_{$type}_{$k}" type="hidden" name="Interest[{$type}][id][]" value="{$interest.id}" />
									<input id="i_txt_{$type}_{$k}" name="Interest[{$type}][text][]" value="{$interest.title}" style="width:95%3$s"/> <a onclick="removeInterestField(this, {$type})" href="javascript:void(0)" title="Удалить интерес"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить интерес"/></a><br/>
									
									<script>
										<!--
										$(document).ready(function() {literal}{{/literal}
											setInterestSuggest($('#i_txt_{$type}_{$k}'), $('#i_id_{$type}_{$k}'), {$type});
										{literal}}{/literal});
										//-->
									</script>
								</span>
								{/if}
							{/foreach}
							{else}
								<span>
									<input id="i_id_{$type}" type="hidden" name="Interest[{$type}][id][]" value="" />
									<input id="i_txt_{$type}" name="Interest[{$type}][text][]" value="" style="width:95%3$s"/> <a onclick="removeInterestField(this, {$type})" href="javascript:void(0)" title="Удалить интерес"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить интерес"/></a><br/>
								</span>
								
								<script>
									<!--
									$(document).ready(function() {literal}{{/literal}
										setInterestSuggest($('#i_txt_{$type}'), $('#i_id_{$type}'), {$type});
									{literal}}{/literal});
									//-->
								</script>
							{/if}
							</span>
							</td>
						</tr>
						<tr>
							<td class="bg_color4">
								<div style="float:right"><a href="javascript:void(0)" onclick="addInterestField({$type})" title="Добавить интерес"><small>Добавить&#160;интерес</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="addInterestField({$type})" title="Добавить интерес"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить интерес" vspace="3" hspace="4"/></a></div>
								<br clear="both"/>%2$s
							</td>
						</tr>	
						
					{/capture}
					
				{/foreach}

				{$smarty.capture.Interest_1|sprintf:"Профессиональные интересы":"<small><span style=\"color:#808080\">Область ваших профессиональных интересов - первое, на что обратит внимание работодатель. <br/><span style=\"color:#FF0000\">Например, бухгалтерская отчетность по МСФО или вирусный маркетинг или программирование на Python и т.д </span>.<br/>Добавляйте каждый интерес в отдельное поле, используя подсказку.</span></small>":"%"}
				
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Зарплата <span style="color: red">*</span></td>
					<td class="bg_color4">
						<input name="WageText" size=10 maxlength="35" value="{$page.Resume.WageText}">&nbsp;&nbsp;руб.
						<br/>
						<small><span style="color:#808080">Укажите минимальную заработную плату.</span></small>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">График работы</td>
					<td class="bg_color4">
						<select name="Schedule" size=1 style="width:200px">
							{foreach from=$page.Schedule_arr item=v key=k}
								<option value="{$k}"{if $k == $page.Resume.Schedule} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Тип работы</td>
					<td class="bg_color4">
						<select name="WorkType" style="width:200px">
							{foreach from=$page.WorkType_arr item=v key=k}
								<option value="{$k}"{if $k == $page.Resume.WorkType} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
			
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="2">Профессиональные навыки</th>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Описание</td>
					<td class="bg_color4" width="410">
						<textarea name=ProfessionalSkills rows="5" style="width:100%">{$page.Resume.ProfessionalSkills}</textarea>
						<br/><small><span style="color:#808080">Опишите здесь свои знания и навыки, которые пригодятся именно на этой должности. <span style="color:#FF0000">Например, знание иностранного языка, специальных компьютерных программ и т. д.</span></span></small>
					</td>
				</tr>

				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Личная характеристика</td>
					<td class="bg_color4" width="410">
						<textarea name="PersonalCharacteristics" rows="5" style="width:100%">{$page.Resume.PersonalCharacteristics}</textarea>
						<br/><small><span style="color:#FF0000">Например, целеустремленность, умение работать в команде, исполнительность.</span></small>
					</td>
				</tr>
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<thead>
					<tr>
						<th colspan="2">Опыт работы</th>
					</tr>
					
					{if isset($UERROR->ERRORS.stage)}
						<tr>
							<td class="bg_color2">&nbsp;</td>
							<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.stage}</span></td>
						</tr>
					{/if}
					<tr>
						<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Стаж <span style="color: red">*</span></td>
						<td class="bg_color4">
							<input name="Stage" size="4" value="{$page.Resume.Stage}"> лет
						</td>
					</tr>
					{if isset($UERROR->ERRORS.place_general)}
						<tr>
							<td class="bg_color2">&nbsp;</td>
							<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.place_general}</span></td>
						</tr>
					{/if}
				</thead>
				
				{foreach from=$page.Resume.PlaceList.work_place_arr item=l key=k}
				{php}
					$this->_tpl_vars['res'] = array(
						'with_suggest'	=> true,
						'city_arr'		=> (isset($this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']]) ? $this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']] : array()),
						'years_arr'		=> &$this->_tpl_vars['page']['work_years_arr'],
						'months_arr'	=> &$this->_tpl_vars['page']['work_months_arr'],
						'placeinfo'		=> &$this->_tpl_vars['l'],
						'position'		=> $this->_tpl_vars['k'],
					);

				{/php}

				{include file=$TEMPLATE.ssections.place[1] res = $res}
				
				{/foreach}
				<tfoot id="append_general">
					<tr>
						<td class="bg_color4" colspan="2">
							<div style="float:right"><a href="javascript:void(0)" onclick="mod_job.getPlaceForm(1, $('#append_general'))" title="Добавить место работы"><small>Добавить место работы</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="mod_job.getPlaceForm(1, $('#append_general'))" title="Добавить место работы"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить место работы" vspace="3" hspace="4"/></a></div><br clear="both"/>
						</td>
					</tr>
					
					{if $page.Resume.CareerTemp}
					<tr>
						<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Места предыдущей работы</td>
						<td class="bg_color4">
							<textarea name="CareerTemp" rows="5" style="width:100%">{$page.Resume.CareerTemp}</textarea>
						</td>
					</tr>
					{/if}
				</tfoot>
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<thead>
					<tr>
						<th colspan="2">Образование</th>
					</tr>
					
					{if isset($UERROR->ERRORS.education)}
						<tr>
							<td class="bg_color2">&nbsp;</td>
							<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.education}</span></td>
						</tr>
					{/if}
					<tr>
						<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Основное <span style="color: red">*</span></td>
						<td class="bg_color4">
							<select name="Education" style="width:200px">
								<option value="0">Не указано</option>
								{foreach from=$page.Education_arr item=v key=k}
									<option value="{$k}"{if $k == $page.Resume.Education} selected="selected"{/if}>{$v}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					{if isset($UERROR->ERRORS.place_education)}
						<tr>
							<td class="bg_color2">&nbsp;</td>
							<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.place_education}</span></td>
						</tr>
					{/if}
				</thead>
				
				{foreach from=$page.Resume.PlaceList.education_place_arr item=l key=k}
				{php}
					$this->_tpl_vars['res'] = array(
						'with_suggest'	=> true,
						'city_arr'		=> (isset($this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']]) ? $this->_tpl_vars['page']['city_arr'][$this->_tpl_vars['l']['countrycode']] : array()),
						'placeinfo'		=> &$this->_tpl_vars['l'],
						'years_arr'		=> &$this->_tpl_vars['page']['work_years_arr'],
						'grad_years_arr'	=> &$this->_tpl_vars['page']['grad_years_arr'],
						'status_arr'		=> &$this->_tpl_vars['page']['status_arr'],
						'course_form_arr'	=> &$this->_tpl_vars['page']['course_form_arr'],
						'position'		=> $this->_tpl_vars['k'],
					);

				{/php}

				{include file=$TEMPLATE.ssections.place[2] res = $res}
				
				{/foreach}
				
				<tfoot id="append_education">
					<tr>
						<td class="bg_color4" colspan="2">
							<div style="float:right"><a href="javascript:void(0)" onclick="mod_job.getPlaceForm(2, $('#append_education'))" title="Добавить учебное заведение"><small>Добавить учебное заведение</small></a></div><div style="float:right;"><a href="javascript:void(0)" onclick="mod_job.getPlaceForm(2, $('#append_education'))" title="Добавить учебное заведение"><img src="/_img/design/200608_title/bullet_add.gif" border="0" alt="Добавить учебное заведение" vspace="3" hspace="4"/></a></div><br clear="both"/>
						</td>
					</tr>
					<tr>
						<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Дополнительное образование</td>
						<td class="bg_color4">
							<textarea name="FurtherEducation" rows="5" style="width:100%">{$page.Resume.FurtherEducation}</textarea><br/>
							<small><span style="color:#808080">Это поле заполняется только в том случае, если вы окончили дополнительные курсы, прослушали семинары, которые повысили вашу квалификацию.</span></small>
						</td>
					</tr>
				</tfoot>
			</table><br/>
			
			<table cellpadding="0" cellspacing="2" border="0" width="550px" class="table2" align="center">
				<tr>
					<th colspan="2">Дополнительные сведения</th>
				</tr>

				<tr>
					<td class="bg_color2" width="140"> </td>
					<td class="bg_color4">
						<input name="Auto" id="Auto" type="checkbox" value="1"{if $page.Resume.Auto} checked="checked"{/if}> <label for="Auto">Наличие автомобиля</label>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Готовность к командировкам</td>
					<td class="bg_color4">
						<table class="table0">
							<tr>
								<td>
									<input type="radio" name="Travel" id="Travel1" value="1" {if 1 == $page.Resume.Travel} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Travel1">{$page.Travel_arr[1]}</label>
								</td>
								<td>
									<input type="radio" name="Travel" id="Travel2" value="2" {if 2 == $page.Resume.Travel} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Travel2">{$page.Travel_arr[2]}</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Наличие детей</td>
					<td class="bg_color4">
						<table class="table0">
							<tr>
								<td>
									<input type="radio" name="Children" id="Children1" value="1" {if 1 == $page.Resume.Children} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Children1">{$page.Children_arr[1]}</label>
								</td>
								<td>
									<input type="radio" name="Children" id="Children0" value="0" {if 0 == $page.Resume.Children} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Children0">{$page.Children_arr[0]}</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Семейное положение</td>
					<td class="bg_color4">
						<select name="Marriad" style="width:200px">
							<option value="0">Не указано</option>
							{foreach from=$page.Marriad_arr item=a key=k}
								<option value="{$k}" {if $k == $page.Resume.Marriad}selected{/if}>{$a}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Степень ограничения трудоспособности</td>
					<td class="bg_color4">
						<table class="table0">
							<tr>
								<td>
									<input type="radio" name="Ability" id="Ability0" value="0" {if 0 == $page.Resume.Ability} checked="checked"{/if}/>
								</td>
								<td width="100%">
									<label for="Ability0">{$page.Ability_arr[0]}</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="Ability" id="Ability1" value="1" {if 1 == $page.Resume.Ability} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Ability1">{$page.Ability_arr[1]}</label>
								</td>
							</tr>
							<tr>
								<td	colspan="2">
									<label for="Ability1"><small><span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями</span></small></label>
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="Ability" id="Ability2" value="2" {if 2 == $page.Resume.Ability} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Ability2">{$page.Ability_arr[2]}</label>
								</td>
							</tr>
							<tr>
								<td	colspan="2">
									<label for="Ability2"><small><span style="color:#808080">II степень - физический труд с ограничениями, умственный - без ограничений</span></small></label>
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="Ability" id="Ability3" value="3" {if 3 == $page.Resume.Ability} checked="checked"{/if}/>
								</td>
								<td>
									<label for="Ability3">{$page.Ability_arr[3]}</label>
								</td>
							</tr>
							<tr>
								<td	colspan="2">
									<label for="Ability3"><small><span style="color:#808080">III степень - невозможно заниматься тяжелым умственным или физическим трудом;</span></small></label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				{$smarty.capture.Interest_2|sprintf:"Мои увлечения":"<small><span style=\"color:#808080\">Опишите, чем вы занимаетесь в свободное от работы время.<br/><span style=\"color:#FF0000\">Например, горные лыжи, велосипедные прогулки или танцы</span>.</span></small>":"%"}
				{*
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Мои увлечения</td>
					<td class="bg_color4" width="410">
						<textarea name=About rows="5" style="width:100%">{$page.Resume.About}</textarea>
						<br/><small><span style="color:#808080">Опишите, чем вы занимаетесь в свободное от работы время. <span style="color:#FF0000">Например, горные лыжи, велосипедные прогулки или танцы.</span></span></small>
					</td>
				</tr>
				*}
				
				{if isset($UERROR->ERRORS.image)}
					<tr>
						<td class="bg_color2">&nbsp;</td>
						<td class="bg_color4 error" colspan="2"><span>{$UERROR->ERRORS.image}</span></td>
					</tr>
				{/if}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right">Фотография</td>
					<td class="bg_color4">
						{if !empty($page.Resume.Image.file)}
							<img src="{$page.Resume.Image.file}" width="{$page.Resume.Image.w}" height="{$page.Resume.Image.h}" align="left">
							<input type="checkbox" name="DeletePhoto" id="DeletePhoto" value="1" {if $page.DeletePhoto}checked="checked"{/if}>&nbsp;&nbsp;<label for="DeletePhoto">Удалить</label><br/><br/>
						{/if}
						<input size="30" type="file" id="Image" name="Image">
						<small><br />
						<span style="color:#808080">Добавьте свое фото! Для многих работодателей это важно. На фото должно быть отчетливо видно ваше лицо, не используйте групповые снимки.
						<br/>JPG файл размером не более 1,5Мб</span></small>
						<input type="hidden" name="PreviewImage" value="{$page.Resume.Image.filename}">
					</td>
				</tr>
				
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Важность</td>
					<td class="bg_color4">
						<select name="Importance" style="width:100%">
							<option value="0">Нет</option>
							{foreach from=$page.Importance_arr item=v key=k}
								<option value="{$k}"{if $k == $page.Resume.Importance} selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">&nbsp;</td>
					<td class="bg_color4">
						<input name="AllowPM" id="AllowPM" type="checkbox" value="1"{if $page.Resume.AllowPM} checked="checked"{/if}>
						<label for="AllowPM">Получать личные сообщения</label>
					</td>
				</tr>
				
				{if $page.action == 'resume_add'}
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Срок размещения</td>
					<td class="bg_color4">
						<select name=srok size=1 style="width:200px">
							<option value="1" {if 1 == $page.Resume.srok}selected="selected"{/if}>1 неделя</option>
							<option value="2" {if 2 == $page.Resume.srok}selected="selected"{/if}>2 недели</option>
							<option value="3" {if 3 == $page.Resume.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4" {if 4 == $page.Resume.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{else}
				<input type="hidden" name="ValidDate" value="{$page.Resume.ValidDate}"/>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Размещать&nbsp;до</td>
					<td class="bg_color4">{$page.Resume.ValidDate}</td>
				</tr>
				<tr>
					<td class="bg_color2" valign="top" style="padding-top:7px" align="right" width="140">Продлить размещение на</td>
					<td class="bg_color4">
						<select name=srok size=1>
							<option value="0">не продлять</option>
							<option value="1"{if 1 == $page.Resume.srok}selected="selected"{/if}>1 неделю</option>
							<option value="2"{if 2 == $page.Resume.srok}selected="selected"{/if}>2 недели</option>
							<option value="3"{if 3 == $page.Resume.srok}selected="selected"{/if}>1 месяц</option>
							<option value="4"{if 4 == $page.Resume.srok}selected="selected"{/if}>2 месяца</option>
						</select>
					</td>
				</tr>
				{/if}
			</table>
			<br/>
			<center>
			
			<input type="submit" name="_submit" value="{if $page.action == 'resume_add'}Добавить{else}Сохранить{/if}">&nbsp;&nbsp;&nbsp;
			<input type="button" name="_preview" value="Предварительный просмотр" onclick="resume_form.preview.value=1; if (CheckResForm(resume_form)) resume_form.submit();">&nbsp;&nbsp;&nbsp;
			{*<input type="reset" value="Сброс">&nbsp;&nbsp;&nbsp;*}
			<input type=button value="Назад" onclick="window.history.go(-1)"></center>
			</form>
<br/>

{/if}

{/if}