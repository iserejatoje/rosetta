{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск резюме"}

<form name="searchres" method="get">
<input type="hidden" name="cmd" value="searchres"/>
<table cellpadding="0" cellspacing="0" border="0" width="80%" align="center">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" >
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Город</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="city" size="1">{$data.acity}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Раздел</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="rid" size="1">{$data.arazdel}</select></td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7'>Период</td>
					<td class='t7' align='left' bgcolor='#F3F8F8'>
						<select class=in name=period size=1 {if $arh}onchange="document.forms.searchres.month.disabled = (this.options[this.selectedIndex].value != -1);document.forms.searchres.years.disabled = (this.options[this.selectedIndex].value != -1);"{/if}>{$data.aperiod}</select>
						{if $arh}
							<select class=in name=month size=1>{$data.month}</select>
							<select class=in name=years size=1>{$data.years}</select>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">График работы</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="grafik" size="1">{$data.agrafik}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Тип работы</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="type" size="1">{$data.atype}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Образование</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="educ" size="1">{$data.aeduc}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Пол</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="pol" size="1">{$data.apol}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Возраст</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><select class="in" name="age" size="1">{$data.aage}</select></td>
				</tr>
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Ключевое слово</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><input type="text" class="s1" name="keyword" value=""></td>
				</tr>
{if $arh}
				<tr>
					<td class="t1" align="right" bgcolor="#DEE7E7">Поиск в архиве</td>
					<td class="t7" align="left" bgcolor="#F3F8F8"><input type="checkbox" name="inarh" value="1"/></td>
				</tr>
{/if}
			</table>
		</td>
	</tr>
</table><br/>
<center><input type="submit" value="Найти" class="in"/></center>
</form><br/>
{include file="`$TEMPLATE.midbanner`"}