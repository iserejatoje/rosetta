{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск вакансии"}
<form name="searchvac" method="get">
<input type="hidden" name="cmd" value="searchvac"/>
<table cellpadding="0" cellspacing="0" border="0" width="80%" align="center">
    <tr>
		<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%">
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Город</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="city" size="1">{$data.acity}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Раздел</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="rid" size="1">{$data.arazdel}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Период</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="period" size="1">{$data.aperiod}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Зарплата от</td>
					<td class="t7 s4" align="left" bgcolor="#f3f8f8"><input type="text" name="pay" class="t7" size="10" maxlength="10"> руб.</td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Форма оплаты</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="payform" size="1">{$data.apayform}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">График работы</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="grafik" size="1">{$data.agrafik}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Тип работы</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="type" size="1">{$data.atype}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Образование</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="educ" size="1">{$data.aeduc}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Пол</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><select class="in" name="pol" size="1">{$data.apol}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Компания</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><input type="text" class="t7" name="firm" size="40" maxlength="100"></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Должность</td>
					<td class="t7" align="left" bgcolor="#f3f8f8"><input class="t7" type="text" name="dol" size="40" maxlength="100"></td>
				</tr>
			</table>
		</td>
	</tr>
</table><br/>
<center><input type="submit" value="Найти" class="in"/></center>
</form><br/>
{include file="`$TEMPLATE.midbanner`"}