{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск вакансии" hide_search=true}
<table cellpadding="0" cellspacing="0" border="0" width="550px" align="center">
    <tr>
		<td align="center">
			<form name="searchvac" action="/{$ENV.section}/vacancy/search/1.php" method="get">
			<table cellpadding="4" cellspacing="1" border="0" width="100%">
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Город</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="city" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.city item=v key=k}
								<option value="{$k}" {if isset($res._GET.city) && $res._GET.city == $k}selected="selected"{elseif !isset($res._GET.city) && $CONFIG.default_city == $k}selected="selected"{/if}>{$v.name}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Раздел</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="rid" size="1" style="width:100%">
							{*<option value="0">Любой</option>*}
							{foreach from=$res.section.razdel item=v}
								{if $v.rid==1 || $v.rid==11 || $v.rid==21 || $v.rid==22}	
								<option value="{$v.rid}" {if isset($res._GET.rid) && $res._GET.rid == $v.rid}selected="selected"{/if}>{$v.rname}</option>
								{/if}
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Период</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="period" size="1" style="width:200px">{$data.aperiod}
							{foreach from=$res.period item=v key=k}
								<option value="{$k}" {if isset($res._GET.period) && $res._GET.period == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Зарплата от</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left"><input value="{if isset($res._GET.pay)}{$res._GET.pay|escape:"html"}{/if}" type="text" name="pay" size="10" maxlength="10"> руб.</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Форма оплаты</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="payform" size="1" style="width:200px">
							<option value="0">Любая</option>
							{foreach from=$res.payform item=v key=k}
								<option value="{$k}" {if isset($res._GET.payform) && $res._GET.payform == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">График работы</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="grafik" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.graphic item=v key=k}
								<option value="{$k}" {if isset($res._GET.grafik) && $res._GET.grafik == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Тип работы</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="type" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.job_type item=v key=k}
								<option value="{$k}" {if isset($res._GET.type) && $res._GET.type == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Образование</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="educ" size="1" style="width:200px">
							<option value="0">Любое</option>
							{foreach from=$res.education item=v key=k}
								<option value="{$k}" {if isset($res._GET.educ) && $res._GET.educ == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Пол</td>
					<td class="dopp" bgcolor="#f3f8f8" align="left">
						<select name="pol" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.sex item=v key=k}
								<option value="{$k}" {if isset($res._GET.pol) && $res._GET.pol == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Компания</td>
					<td class="dopp" bgcolor="#f3f8f8"><input value="{if isset($res._GET.firm)}{$res._GET.firm|escape:"html"}{/if}" type="text" name="firm" style="width:100%" maxlength="100"></td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Должность</td>
					<td class="dopp" bgcolor="#f3f8f8"><input value="{if isset($res._GET.dol)}{$res._GET.dol|escape:"html"}{/if}" type="text" name="dol" style="width:100%" maxlength="100"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Найти"/>
			</form>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}