{include file="`$TEMPLATE.sectiontitle`" rtitle="Поиск резюме" hide_search=true}

<table cellpadding="0" cellspacing="0" border="0" width="550px" align="center">
	<tr>
		<td align="center">
			<form name="searchres" method="get" action="/{$ENV.section}/resume/search/1.php">
			<table cellpadding="4" cellspacing="1" border="0" width="100%">
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Город</td>
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#E3F6FF" align="right">График работы</td>
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#F3F8F8" align="left">
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
					<td class="dopp" bgcolor="#F3F8F8" align="left">
						<select name="pol" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.sex item=v key=k}
								<option value="{$k}" {if isset($res._GET.pol) && $res._GET.pol == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Возраст</td>
					<td class="dopp" bgcolor="#F3F8F8" align="left">
						<select name="age" size="1" style="width:200px">
							<option value="0">Любой</option>
							{foreach from=$res.age item=v key=k}
								<option value="{$k}" {if isset($res._GET.age) && $res._GET.age == $k}selected="selected"{/if}>{$v}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right">Ключевое слово</td>
					<td class="dopp"><input type="text" name="keyword" style="width:100%" value="{if isset($res._GET.keyword)}{$res._GET.keyword|escape:"html"}{/if}"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Найти"/>
			</form>
		</td>
	</tr>
</table><br/>
{*include file="`$TEMPLATE.midbanner`"*}