{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск вакансии" hide_search=true}
<script language="javascript">
	var branches_linear = {literal}{{/literal}{foreach from=$page.Branch_arr.razdel item=v name=branch}"{$v.rid}": '{$v.rname}'{if !$smarty.foreach.branch.last},{/if}{/foreach}{literal}}{/literal};
	var branches = {$page.speciality_list};
</script>

<table cellpadding="0" cellspacing="0" border="0" width="550px" align="center">
    <tr>
		<td align="center">
			<form name="searchvac" action="/{$ENV.section}/vacancy/search/1.php" method="get" enctype="application/x-www-form-urlencoded">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<td class="bg_color2" align="right">Город</td>
					<td class="bg_color4">
						<select id="city_id" name="city" size="1" style="width:200px" onchange="mod_job.change_city(this, 'region', null, 'Любой');">
							<option value="0">Любой</option>
							{foreach from=$page.city item=v key=k}
								{if ($ENV.site.domain=="mgorsk.ru" && $k==2376) 
									|| ($ENV.site.domain=="74.ru" && $k!=2376) 
									|| ($ENV.site.domain=="tolyatty.ru" && $k==1748) 
									|| ($ENV.site.domain=="63.ru" && $k!=1748) 
									|| ($ENV.site.domain=="sterlitamak1.ru" && $k==399) 
									|| ($ENV.site.domain=="ufa1.ru" && $k!=399) 
									|| !in_array($ENV.site.domain,array('mgorsk.ru','74.ru','tolyatty.ru','63.ru','sterlitamak1.ru','ufa1.ru'))}
								<option value="{$k}" {if isset($page._GET.city) && $page._GET.city == $k}selected="selected"{elseif !isset($page._GET.city) && $CONFIG.default_city == $k}selected="selected"{/if}>{$v.name}</option>
								{/if}
							{/foreach}
						</select>
						{if $ENV.site.domain=="74.ru"}
						<a href="http://mgorsk.ru/job/vacancy/search.php" class="text11" target="_blank">Магнитогорск</a>
						{elseif $ENV.site.domain=="mgorsk.ru"}
						<a href="http://74.ru/job/vacancy/search.php" class="text11" target="_blank">Челябинская область</a>
						{/if}
						{if $ENV.site.domain=="63.ru"}
						<a href="http://tolyatty.ru/job/vacancy/search.php" class="text11" target="_blank">Тольятти</a>
						{elseif $ENV.site.domain=="tolyatty.ru"}
						<a href="http://63.ru/job/vacancy/search.php" class="text11" target="_blank">Самарская область</a>
						{/if}
						{if $ENV.site.domain=="72.ru"}
						<noindex><a href="http://86.ru/job/vacancy/search.php" rel="nofollow" class="text11" target="_blank">ХМАО</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/vacancy/search.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
						{elseif $ENV.site.domain=="86.ru"}
						<noindex><a href="http://72.ru/job/vacancy/search.php"  rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://89.ru/job/vacancy/search.php" rel="nofollow" class="text11" target="_blank">ЯНАО</a><noindex>
                        			{elseif $ENV.site.domain=="89.ru"}
						<noindex><a href="http://72.ru/job/vacancy/search.php" rel="nofollow" class="text11" target="_blank">Тюмень</a>&nbsp;&nbsp;
						<a href="http://86.ru/job/vacancy/search.php" rel="nofollow" class="text11" target="_blank">ХМАО</a><noindex>
						{/if}
						{if $ENV.site.domain=="ufa1.ru"}
						<a href="http://sterlitamak1.ru/job/vacancy/search.php" class="text11" target="_blank">Стерлитамак</a>
						{elseif $ENV.site.domain=="sterlitamak1.ru"}
						<a href="http://ufa1.ru/job/vacancy/search.php" class="text11" target="_blank">Республика Башкортостан</a>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="140">Место работы (район)</td>
					<td class="bg_color4">
						<select id="region" name="region" size="1" style="width:200px"{if $selected} disabled="true"{/if}>
							<option value="0">Любой</option>
							{foreach from=$page.regions item=v key=k}
								{if $v.name}<option value="{$k}" {if isset($page._GET.region) && $page._GET.region == $k} {php} $this->_tpl_vars['selected'] = true; {/php}selected="selected"{/if}>{$v.name}</option>{/if}
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Отрасль / Должности</td>
					<td class="bg_color4">
						{include file="`$CONFIG.templates.ssections.position_list`" number="0" search="1"}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Период</td>
					<td class="bg_color4">
						<select name="period" size="1" style="width:200px">{$data.aperiod}
							{foreach from=$page.period item=v key=k}
								<option value="{$k}" {if isset($page._GET.period) && $page._GET.period == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Зарплата от</td>
					<td class="bg_color4"><input value="{if isset($page._GET.pay)}{$page._GET.pay|escape:"html"}{/if}" type="text" name="pay" size="10" maxlength="10"> руб.</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Форма оплаты</td>
					<td class="bg_color4">
						<select name="payform" size="1" style="width:200px">
							<option value="0">Любая</option>
							{foreach from=$page.payform item=v key=k}
								<option value="{$k}" {if isset($page._GET.payform) && $page._GET.payform == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
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
					<td class="bg_color2" align="right">Компания</td>
					<td class="bg_color4"><input value="{if isset($page._GET.firm)}{$page._GET.firm|escape:"html"}{/if}" type="text" name="firm" style="width:100%" maxlength="100"></td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Должность</td>
					<td class="bg_color4"><input value="{if isset($page._GET.tposition)}{$page._GET.tposition|escape:"html"}{/if}" type="text" name="tposition" style="width:100%" maxlength="100"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Найти"/>
			</form>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}