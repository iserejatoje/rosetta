{*изменено по требованию Россвязьнадзор*}

	{capture name="rname"}
		Просмотр данных по резюме {$res.ResumeID}
	{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

{if is_array($res) && !sizeof($res) }
	<div align="center">
		<span style="color:red;"><b>Запрошенное вами резюме не найдено</b></span><br/><br/>
		<a href="/{$ENV.section}/resume/1.php">Перейти к списку резюме</a>
	</div>
{else}

<div class="text11" style="padding-bottom:3px; float:left">
	Обновлено {$res.UpdateDate}, просмотров: {$res.Views}
</div>
<div align="right" class="text11" style="padding-bottom:3px">
{if $res.canaddfavorite}<span id="ln{$res.ResumeID}"><a href="/{$ENV.section}/favorites/add/resume/{$res.ResumeID}.php" onclick="mod_job.toFavorites({$res.ResumeID}, 'resume'); return false;">Добавить резюме в избранное</a>&nbsp;|&nbsp;</span>{/if}
<a href="/{$ENV.section}/resume/{$res.ResumeID}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
</div>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.Image.file)}<td><img src="{$res.Image.file}" width="{$res.Image.w}" height="{$res.Image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Личные сведения</th>
				</tr>
				{if $res.Name}
				<tr>
					<td class="bg_color2" align="right" width="130">Имя{*Ф.И.О.*}:</td>
					<td class="bg_color4">{$res.Name}</td>
				</tr>
				{/if}
				{if $res.Sex}
				<tr>
					<td class="bg_color2" align="right" width="130">Пол:</td>
					<td class="bg_color4">{$res.Sex}</td>
				</tr>
				{/if}

				{if $res.Birthday}
				<tr>
					<td class="bg_color2" align="right">Возраст:</td>
					<td class="bg_color4">{$res.Birthday}</td>
				</tr>
				{/if}
			</table><br/>

			{if $res.CityText}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="3">Место жительства</th>
				</tr>
				<tr>
					<td align="right" class="bg_color2" width="130">Город:</td>
					<td class="bg_color4" colspan="2">
						{$res.CityText}
					</td>
				</tr>
				{if $res.DistrictText}
				<tr>
					<td align="right" class="bg_color2">Район:</td>
					<td class="bg_color4">
						{$res.DistrictText}
					</td>
				</tr>
				{/if}
				{if $res.StreetText}
				<tr>
					<td align="right" class="bg_color2">Улица:</td>
					<td class="bg_color4">
						{$res.StreetText}
					</td>
				</tr>
				{if $res.LocationHouse}
				<tr>
					<td align="right" class="bg_color2">Дом:</td>
					<td class="bg_color4" nowrap="nowrap">
						{$res.LocationHouse}
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

				{if $res.AddressTemp}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес:</td>
					<td class="bg_color4">
						{$res.AddressTemp}
					</td>
				</tr>
				{/if}

				{if $res.Phone}
				<tr>
					<td class="bg_color2" align="right" width="130">Телефон:</td>
					<td class="bg_color4">
						{$res.Phone}
					</td>
				</tr>
				{/if}
				{if $res.Email}
				<tr>
					<td class="bg_color2" align="right" width="130">E-mail:</td>
					<td class="bg_color4">
						{$res.Email|mailto_crypt}
					</td>
				</tr>
				{/if}

				{if !empty($res.replyjs) && $res.AllowPM}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
				</tr>
				{elseif !$USER->IsAuth() && $res.uid>0}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><span style="font-size: 11px;">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span></td>
				</tr>
				{/if}
			</table><br/>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Пожелания к будущей работе</th>
				</tr>

				<tr>
					<td class="bg_color2" align='right' width="130">{if $res.Position != ""}Должность{else}Отрасли/Должности{/if}</td>
					<td class="bg_color4">{if $res.Position != ""}{$res.Position}{else}{include file="`$CONFIG.templates.ssections.branches`"}{/if}</td>
				</tr>
				
				{*foreach from=$res.interestGroupTypes_arr item=group key=type}
					{if is_array($res.Interest[$type]) && sizeof($res.Interest[$type])}
						{capture name="Interest_`$type`"}
							<tr>
								<td class="bg_color2" align="right" width="130">%1$s:</td>
								<td class="bg_color4">
									<div>
									{foreach from=$res.Interest[$type] item=l}
										<div>{$l.title}</div>
									{/foreach}
									</div>
								</td>
							</tr>
						{/capture}						
					{/if}
				{/foreach*}
				
				{if $smarty.capture.Interest_1}
					{* {$smarty.capture.Interest_1|sprintf:"Профессиональные интересы"} *}
					{"Профессиональные интересы"|string_format:$smarty.capture.Interest_1}
				{/if}
				
				<tr>
					<td class="bg_color2" align="right" width="130">Зарплата:</td>
					<td class="bg_color4">
						{$res.WageText}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="130">График работы:</td>
					<td class="bg_color4">
						{$res.Schedule}
					</td>
				</tr>
				{if is_array($res.WorkType) && count($res.WorkType)}
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы:</td>
					<td class="bg_color4">
						{foreach from=$res.WorkType item=v key=k}
								{$res.WorkType_arr[$k]}<br/>
							{/foreach}
					</td>
				</tr>
				{/if}

			</table><br/>
			
			{if $res.ProfessionalSkills || $res.PersonalCharacteristics}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Профессиональные навыки</th>
				</tr>
				{if $res.ProfessionalSkills}
				<tr>
					<td class="bg_color2" align="right" width="130">Описание:</td>
					<td class="bg_color4">
						{$res.ProfessionalSkills|nl2br}
					</td>
				</tr>
				{/if}
				{if $res.PersonalCharacteristics}
				<tr>
					<td class="bg_color2" align="right" width="130">Личная характеристика:</td>
					<td class="bg_color4">
						{$res.PersonalCharacteristics|nl2br}
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
						{$res.Stage}
					</td>
				</tr>

				{if $res.CareerTemp || !empty($res.PlaceList.work_place_arr)}
				<tr>
					<td class="bg_color2" align="right" width="130">Места предыдущей работы:</td>
					<td class="bg_color4 text11">
						{if !empty($res.PlaceList.work_place_arr)}
							<div>
							{foreach from=$res.PlaceList.work_place_arr item=l key=k name=pl}
								{capture name="place"}
									<div><strong>{php} if (is_scalar($this->_tpl_vars['l']['CityCode'])) if (is_array($this->_tpl_vars['res']['cityList'][$this->_tpl_vars['l']['CityCode']])) echo $this->_tpl_vars['res']['cityList'][$this->_tpl_vars['l']['CityCode']]['Name'];{/php}, {$l.Name}</strong></div>
									{if $l.Position || $l.YearStart}
										<div class="txt_color1" style="font-size:13px"><strong>{$l.Position}
										{if $l.YearStart || $l.YearEnd}({if $l.YearStart}{$res.months_arr[$l.MonthStart]} {$l.YearStart}{/if}{if $l.YearEnd} - {$res.months_arr[$l.MonthEnd]} {$l.YearEnd}{elseif $l.YearStart} - по настоящее время{/if}){/if}</strong></div>
									{/if}
									<br/><div>{$l.Comment|nl2br}</div>
								{/capture}
								
								<div>{$smarty.capture.place|trim:" ,"}</div>{if !$smarty.foreach.pl.last}<br/>{/if}
							{/foreach}
							</div>
						{/if}

						{$res.CareerTemp}
					</td>
				</tr>
				{/if}
			</table><br/>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Образование</th>
				</tr>

				{if $res.Education}
				<tr>
					<td class="bg_color2" align="right" width="130">Основное:</td>
					<td class="bg_color4">
						{$res.Education}
					</td>
				</tr>
				{/if}

				{if !empty($res.PlaceList.education_place_arr.High) || !empty($res.PlaceList.education_place_arr.SecondSpecial) || !empty($res.PlaceList.education_place_arr.Second)}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4 text11">
						{if !empty($res.PlaceList.education_place_arr.High) || !empty($res.PlaceList.education_place_arr.SecondSpecial) || !empty($res.PlaceList.education_place_arr.Second)}
							<div>
							{foreach from=$res.PlaceList.education_place_arr item=PlaceType}
								{if is_array($PlaceType)}
									{foreach from=$PlaceType item=l key=k name=pl}
										{capture name="place"}
											<div><strong>{php}echo $this->_tpl_vars['res']['cityList'][$this->_tpl_vars['l']['CityCode']]['Name'];{/php}, {$l.Name}</strong></div>
											{if $l.Chair || $l.Faculty || $l.Course || $l.Status}
											<div class="txt_color1" style="font-size:13px">
												<strong>
													{php}
														$info = array();
														if ($this->_tpl_vars['l']['Class'])
															$info[] = 'класс '.$this->_tpl_vars['l']['Class'];

														if ($this->_tpl_vars['l']['Faculty']['Name']) {
															$info[] = 'факультет '.$this->_tpl_vars['l']['Faculty']['Name'];

															if ($this->_tpl_vars['l']['Chair']['Name'])
																$info[] = 'кафедра '.$this->_tpl_vars['l']['Chair']['Name'];
														} else if ($this->_tpl_vars['l']['Chair']['Name'])
															$info[] = 'специализация '.$this->_tpl_vars['l']['Chair']['Name'];

														if ($this->_tpl_vars['l']['Course'])
															$info[] = 'Форма обучения '.$this->_tpl_vars['l']['Course'];

														if ($this->_tpl_vars['l']['Status'])
															$info[] = $this->_tpl_vars['l']['Status'];

														echo implode(', ', $info);
													{/php}
												</strong>
											</div>
											{/if}
											<div>{if $l.YearStart}({if $l.YearStart}{$l.YearStart}{/if}{if $l.YearEnd} - {$l.YearEnd}{elseif $l.YearStart} - по настоящее время{/if}){/if}</div>
										{/capture}

										<div>{$smarty.capture.place|trim:" ,"}</div>{if !$smarty.foreach.pl.last}<br/>{/if}
									{/foreach}
								{/if}
							{/foreach}
							</div>
						{/if}
					</td>
				</tr>
				{/if}
				
				{if $res.FurtherEducation}
				<tr>
					<td class="bg_color2" align="right" width="130">Дополнительное образование:</td>
					<td class="bg_color4">
						{$res.FurtherEducation|nl2br}
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
						{if $res.Auto}Да{else}Нет{/if}
					</td>
				</tr>
				{if $res.Travel}
				<tr>
					<td class="bg_color2" align="right" width="130">Готовность к командировкам:</td>
					<td class="bg_color4">
						{$res.Travel}
					</td>
				</tr>
				{/if}
				{if $res.Marriad}
				<tr>
					<td class="bg_color2" align="right" width="130">Семейное положение:</td>
					<td class="bg_color4">
						{$res.Marriad}
					</td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="130">Наличие детей:</td>
					<td class="bg_color4">
						{$res.Children}
					</td>
				</tr>
				{if $res.Ability}
				<tr>
					<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности:</td>
					<td class="bg_color4">
						{$res.Ability}
					</td>
				</tr>
				{/if}

				{*if $res.About}
				<tr>
					<td class="bg_color2" align="right" width="130">Мои увлечения:</td>
					<td class="bg_color4">
						{$res.About|nl2br}
					</td>
				</tr>
				{/if*}
				
				{if $smarty.capture.Interest_2}
					{* {$smarty.capture.Interest_2|sprintf:"Мои увлечения"} *}
					{"Мои увлечения"|string_format:$smarty.capture.Interest_2}
				{/if}

				{if $res.Importance}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность:</td>
					<td class="bg_color4">
						{$res.Importance}
					</td>
				</tr>
				{/if}
				{*if $res.show_incorrect == 1}
				<tr>
					<td colspan="2" align="left">Это объявление некорректно? <a href="#" onclick="mod_job_incorrect_obj.show({$res.ResumeID}, 'resume'); return false;">Сообщите нам об этом</a>.
					</td>
				</tr>
				{/if*}
			</table>
			{if $res.show_incorrect == 1}
				Это объявление некорректно? <a href="#" onclick="mod_job_incorrect_obj.show({$res.ResumeID}, 'resume'); return false;">Сообщите нам об этом</a>.
				
				{/if}
				
			{literal} 
			<div style="float:right"><noindex>
			<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
			<script type="text/javascript">
			new Ya.share({
				'element': 'ya_share1',
				'elementStyle': {
					'type': 'button',
					'linkIcon': true,
					'border': false,
					'quickServices': ['yaru', 'vkontakte', 'facebook', 'twitter', 'moimir']
				},
				'popupStyle': {
					'copyPasteField': true
				}
			 });
			</script>
			<span id="ya_share1"></span>
			</noindex></div>
			{/literal}
		</td>
	</tr>
</table>

{/if}

<div id="incorrect_container_{$res.ResumeID}" class="incorrect_container" align="center" style="display: none;">&nbsp;</div>
{include file="`$CONFIG.templates.ssections.incorrect_form`" incorrect_marks="`$res.incorrect_marks`"}

<br/>
{include file="`$TEMPLATE.midbanner`"}<br/><br/>