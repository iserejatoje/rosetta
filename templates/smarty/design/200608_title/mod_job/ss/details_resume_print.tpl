{*изменено по требованию Россвязьнадзор*}
{$res.script}

<script language="javascript">
{literal}
<!--
window.print();
-->
{/literal}
</script>
{capture name="rname"}
	<b>Просмотр данных по резюме {$res.ResumeID}</b>
{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`" hide_search=true}
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
			</table>

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
				
			</table>
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

				{*if !empty($res.replyjs) && $res.AllowPM}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
				</tr>
				{elseif !$USER->IsAuth() && $res.uid>0}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4"><span style="font-size: 11px;">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span></td>
				</tr>
				{/if*}
			</table>

			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2" align="center">
				<tr>
					<th colspan="2">Пожелания к будущей работе</th>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Отрасль:</td>
					<td class="bg_color4">
						{$res.Branch}
					</td>
				</tr>

				<tr>
					<td class="bg_color2" align="right" width="130">Претендуемая должность:</td>
					<td class="bg_color4">
						{$res.Position}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="130">Профессиональные интересы:</td>
					<td class="bg_color4">
					{foreach from=$res.interestGroupTypes_arr item=group key=type}
						{if is_array($res.Interest[$type]) && sizeof($res.Interest[$type])}
							
								
								{foreach from=$res.Interest[$type] item=l}
									{$l.title}<br/>
								{/foreach}
												
						
						{/if}
					{/foreach}
					</td>
				</tr>
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
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы:</td>
					<td class="bg_color4">
						{$res.WorkType}
					</td>
				</tr>

			</table>

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
					<td class="bg_color4">
						{if !empty($res.PlaceList.work_place_arr)}
							
							{foreach from=$res.PlaceList.work_place_arr item=l key=k}
								{capture name="place"}
									{php}
										echo $this->_tpl_vars['res']['cityList'][$this->_tpl_vars['l']['citycode']]['Name'];
									{/php},
									{$l.name}
									{if $l.position || $l.y_start}
										<br/>{$l.position}
										{if $l.y_start || $l.y_end}({if $l.y_start}{$l.y_start}{/if}{if $l.y_end} - {$l.y_end}{elseif $l.y_start} - по настоящее время{/if}){/if}
									{/if}
								{/capture}
								
								{$smarty.capture.place|trim:" ,"}<br>
							{/foreach}
							
						{/if}
					
						{$res.CareerTemp|nl2br}
					</td>
				</tr>
				{/if}
			</table>

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
			</table>
			{/if}
			
			{*foreach from=$res.interestGroupTypes_arr item=group key=type}
				{if is_array($res.Interest[$type]) && sizeof($res.Interest[$type])}
					{capture name="Interest_`$type`"}
						<tr>
							<td class="bg_color2" align="right" width="130">%1$s:</td>
							<td class="bg_color4">
								
								{foreach from=$res.Interest[$type] item=l}
									{$l.title}<br/>
								{/foreach}								
							</td>
						</tr>
					{/capture}						
				{/if}
			{/foreach*}
			
			
			{*if $smarty.capture.Interest_1}
				{$smarty.capture.Interest_1|sprintf:"Профессиональные интересы"}
			{/if*}

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

				{if !empty($res.PlaceList.education_place_arr)}
				<tr>
					<td class="bg_color2" align="right" width="130"></td>
					<td class="bg_color4">
						{if !empty($res.PlaceList.education_place_arr)}
							
							{foreach from=$res.PlaceList.education_place_arr item=l key=k}
								{capture name="place"}
									{php}
										echo $this->_tpl_vars['res']['cityList'][$this->_tpl_vars['l']['citycode']]['Name'];
									{/php},
									{$l.name}
									{if $l.faculty}<br/>факультет {$l.faculty},{/if}
									{if $l.chair}<br/>кафедра {$l.chair},{/if}
									{if $l.y_start}<br/>({if $l.y_start}{$l.y_start}{/if}{if $l.y_end} - {$l.y_end}{elseif $l.y_start} - по настоящее время{/if}){/if}
								{/capture}
								
								{$smarty.capture.place|trim:" ,"}<br>
							{/foreach}
							
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
			</table>

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
					<td class="bg_color2" align="right" width="130">О себе:</td>
					<td class="bg_color4">
						{$res.About|nl2br}
					</td>
				</tr>
				{/if*}
				
				{if $smarty.capture.Interest_2}
					{$smarty.capture.Interest_2|sprintf:"Мои увлечения"}
				{/if}

				{if $res.Importance}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность:</td>
					<td class="bg_color4">
						{$res.Importance}
					</td>
				</tr>
				{/if}
			</table>
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
				<tr>
			</td>
					<td class="bg_color4">{if $res.email != ""}{$res.email}{/if}</td>
				</tr>
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
			</table>
		</td>
	</tr>
</table>
<div style="text-align:center"><a href='javascript:window.close()'>Закрыть</a></div><br/>