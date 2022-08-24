{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск резюме" hide_search=true}

<table cellpadding="0" cellspacing="0" border="0" width="550px" align="center">
	<tr>
		<td align="center">
			<form name="searchres" method="get" action="/{$ENV.section}/resume/search/1.php" enctype="application/x-www-form-urlencoded">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<td class="bg_color2" align="right">Город</td>
					<td class="bg_color4">
						<select name="city" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.city item=v key=k}
								{if ($ENV.site.domain=="mgorsk.ru" && $k==2376) || ($ENV.site.domain=="74.ru" && $k!=2376) || ($ENV.site.domain=="tolyatty.ru" && $k==1748) || ($ENV.site.domain=="63.ru" && $k!=1748) || ($ENV.site.domain=="sterlitamak1.ru" && $k==399) || ($ENV.site.domain=="ufa1.ru" && $k!=399) || !in_array($ENV.site.domain,array('mgorsk.ru','74.ru','tolyatty.ru','63.ru','sterlitamak1.ru','ufa1.ru'))}
								<option value="{$k}" {if isset($res._GET.city) && $res._GET.city == $k}selected="selected"{elseif !isset($res._GET.city) && $CONFIG.default_city == $k}selected="selected"{/if}>{$v.name}</option>
								{/if}
							{/foreach}
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
					<td class="bg_color2" align="right">Раздел</td>
					<td class="bg_color4">
						<select name="rid" size="1" style="width:100%">
							<option value="0">Любой</option>
							{foreach from=$res.section.razdel item=v}
								<option value="{$v.rid}" {if isset($res._GET.rid) && $res._GET.rid == $v.rid}selected="selected"{/if}>{$v.rname}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Период</td>
					<td class="bg_color4">
						<select class=in name=period size=1 style="width:200px" {if $res.arh}onchange="document.forms.searchres.month.disabled = (this.options[this.selectedIndex].value != -1);document.forms.searchres.years.disabled = (this.options[this.selectedIndex].value != -1);"{/if}>
							{foreach from=$res.period item=v key=k}
								<option value="{$k}" {if isset($res._GET.period) && $res._GET.period == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
						{if $res.arh}
							<select class=in name=month size=1>
								{foreach from=$res.month item=v key=k}
									<option value="{$k}" {if isset($res._GET.month) && $res._GET.month == $k}selected="selected"{/if}>{$v}</option>
								{/foreach}
							</select>
							<select class=in name=years size=1>
								{foreach from=$res.years item=v key=k}
									<option value="{$v}" {if isset($res._GET.years) && $res._GET.years == $k}selected="selected"{/if}>{$v} год</option>
								{/foreach}
							</select>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">График работы</td>
					<td class="bg_color4">
						<select name="grafik" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.graphic item=v key=k}
								<option value="{$k}" {if isset($res._GET.grafik) && $res._GET.grafik == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Тип работы</td>
					<td class="bg_color4">
						<select name="type" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.job_type item=v key=k}
								<option value="{$k}" {if isset($res._GET.type) && $res._GET.type == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Образование</td>
					<td class="bg_color4">
						<select name="educ" size="1" style="width:200px">
							<option value="0">Любое</option>
							{foreach from=$res.education item=v key=k}
								<option value="{$k}" {if isset($res._GET.educ) && $res._GET.educ == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Пол</td>
					<td class="bg_color4">
						<select name="pol" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.sex item=v key=k}
								<option value="{$k}" {if isset($res._GET.pol) && $res._GET.pol == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Возраст</td>
					<td class="bg_color4">
						<select name="age" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.age item=v key=k}
								<option value="{$k}" {if isset($res._GET.age) && $res._GET.age == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="bg_color2" align="right">Ключевое слово</td>
					<td class="bg_color4"><input type="text" name="keyword" style="width:100%" value="{if isset($res._GET.keyword)}{$res._GET.keyword|escape:"html"}{/if}"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Найти"/>
			</form>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}