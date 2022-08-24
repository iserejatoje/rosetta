{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск резюме" hide_search=true}

<script language="javascript">
	var branches_linear = {literal}{{/literal}{foreach from=$page.Branch_arr.razdel item=v name=branch}"{$v.rid}": '{$v.rname}'{if !$smarty.foreach.branch.last},{/if}{/foreach}{literal}}{/literal};
	var branches = {$page.speciality_list};
</script>
 
<table cellpadding="0" cellspacing="0" border="0" width="550px" align="center">
	<tr>
		<td align="left">
			<form name="searchres" method="get" action="/{$ENV.section}/resume/search/1.php" enctype="application/x-www-form-urlencoded">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<td class="bg_color2" align="right">Город</td>
					<td class="bg_color4">
						<input type="hidden" id="addr_country" value="{$page.country}" />
						<select name="city" id="addr_city" onchange="Address.ChangeCity('addr_country', 'addr_city')" style="width:100%;">
							<option value="0"> - Любой - </option>
			{foreach from=$page.city_arr item=l key=k}
							<option value="{$l.Code}"{if $l.Code===$page.city} selected="selected"{/if}>{$l.Name}</option>
			{/foreach}
                        <option value="-1"> - Другой - </option>
						</select>

						{if $ENV.site.domain=="74.ru"}
						<a href="http://mgorsk.ru/job/resume/search.php" class="text11" target="_blank">Магнитогорск</a>
						{elseif $ENV.site.domain=="mgorsk.ru"}
						<a href="http://74.ru/job/resume/search.php" class="text11" target="_blank">Челябинская область</a>
						{/if}
						{if $ENV.site.domain=="63.ru"}
						<a href="http://tolyatty.ru/job/resume/search.php" class="text11" target="_blank">Тольятти</a>
						{elseif $ENV.site.domain=="tolyatty.ru"}
						<a href="http://63.ru/job/resume/search.php" class="text11" target="_blank">Самарская область</a>
						{/if}
						{if $ENV.site.domain=="72.ru"}
						<noindex><a href="http://86.ru/job/resume/search.php" rel="nofollow" class="text11" target="_blank">ХМАО</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/resume/search.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
						{elseif $ENV.site.domain=="86.ru"}
						<noindex><a href="http://72.ru/job/resume/search.php"  rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/resume/search.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
                        			{elseif $ENV.site.domain=="89.ru"}
						<noindex><a href="http://72.ru/job/resume/search.php" rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://86.ru/job/resume/search.php" rel="nofollow" class="text11" target="_blank">ХМАО</a><noindex>
						{/if}
						{if $ENV.site.domain=="ufa1.ru"}
						<a href="http://sterlitamak1.ru/job/resume/search.php" class="text11" target="_blank">Стерлитамак</a>
						{elseif $ENV.site.domain=="sterlitamak1.ru"}
						<a href="http://ufa1.ru/job/resume/search.php" class="text11" target="_blank">Республика Башкортостан</a>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" valign="top">Отрасль / Должности</td>
					<td class="bg_color4">
						{include file="`$CONFIG.templates.ssections.position_list`" number="0" multi="true"}						
					
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Период</td>
					<td class="bg_color4">
						<select class=in name=period size=1 style="width:200px" {if $page.arh}onchange="document.forms.searchres.month.disabled = (this.options[this.selectedIndex].value != -1);document.forms.searchres.years.disabled = (this.options[this.selectedIndex].value != -1);"{/if}>
							{foreach from=$page.period item=v key=k}
								<option value="{$k}" {if isset($page._GET.period) && $page._GET.period == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
						{if $page.arh}
							<select class=in name=month size=1>
								{foreach from=$page.month item=v key=k}
									<option value="{$k}" {if isset($page._GET.month) && $page._GET.month == $k}selected="selected"{/if}>{$v}</option>
								{/foreach}
							</select>
							<select class=in name=years size=1>
								{foreach from=$page.years item=v key=k}
									<option value="{$v}" {if isset($page._GET.years) && $page._GET.years == $k}selected="selected"{/if}>{$v} год</option>
								{/foreach}
							</select>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">График работы</td>
					<td class="bg_color4">
						<select name="grafik" size="1" style="width:200px">
							{*<option value="0">Любой</option>*}
							{foreach from=$page.graphic item=v key=k}
								<option value="{$k}" {if isset($page._GET.grafik) && $page._GET.grafik == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Тип работы</td>
					<td class="bg_color4">
						<select name="type" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.job_type item=v key=k}
								<option value="{$k}" {if isset($page._GET.type) && $page._GET.type == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Образование</td>
					<td class="bg_color4">
						<select name="educ" size="1" style="width:200px">
							<option value="0">Любое</option>
							{foreach from=$page.education item=v key=k}
								<option value="{$k}" {if isset($page._GET.educ) && $page._GET.educ == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Пол</td>
					<td class="bg_color4">
						<select name="pol" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.sex item=v key=k}
								<option value="{$k}" {if isset($page._GET.pol) && $page._GET.pol == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Возраст</td>
					<td class="bg_color4">
						<select name="age" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$page.age item=v key=k}
								<option value="{$k}" {if isset($page._GET.age) && $page._GET.age == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Ключевое слово</td>
					<td class="bg_color4"><input type="text" name="keyword" style="width:100%" value="{if isset($page._GET.keyword)}{$page._GET.keyword|escape:"html"}{/if}"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Найти"/>
			</form>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}