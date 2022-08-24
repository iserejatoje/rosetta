{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование вакансий (`$res.count`)"}

{if $res.moderate_count>0}
<br/>
<div align="center" style="color:red">
<b>Вам отказано в размещении {$res.moderate_count} ваканси{if $res.moderate_count%10==1}и{else}й{/if}</b>
</div>
<br/>
{/if}
<div align="right">
Сегодня размещено вакансий: <b>{$res.today_count}</b><br/>
{if $res.premoderate_count}Ожидают проверки модератором: <b>{$res.premoderate_count}</b><br/>{/if}
{if $res.protect_count}<b>Внимание!</b> Можно размещать (продлевать) не более <b>{$res.protect_count}</b> объявлений в сутки.<br/>{/if}
{if $CONFIG.protect_time}Продлевать объявления разрешается не чаще, чем 1 раз в <b>{$CONFIG.protect_time}</b> часов.<br/>{/if}
</div>

{capture name=pageslink}
	{if sizeof($res.pageslink.btn)}
	<br/>{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
	<br/>{/if}
{/capture}

{if isset($res.err) && is_array($res.err)}
	<br/><div align="center" style="padding-bottom:5px;"><b>
		{foreach from=$res.err item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{/if}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
		<td align="center">
			<form name="rmvacancy" method="post">
			<input type="hidden" name="action" value="vacancy_edit_list">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<th colspan="{if sizeof($res.data) > 1}9{else}8{/if}">Выберите вакансию для редактирования</th>
				</tr>
				<tr>
					<th width="5%">#</th>
					<th width="10%">Дата<br/>разм.</th>
					<th width="10%">Дата<br/>истеч.</th>
					<th width="15%">Фирма</th>
					<th width="45%">Должность</th>

					{if $res.is_commerce && $res.HandsOrder && sizeof($res.data) > 1 }<th width="80">Порядок</th>{/if}

					<th>Выбор<br/><input type="checkbox" onclick="mod_job.selAll('arr_vac',this);" /></th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$res.data item=l name=lst}
				<tr class="{excycle}" valign="top" {if $l.moderate != 0 || $USER->ID == 1}style="background-color:#FFAEAA"{/if}>
					<td class="text11" align="center"><a href="/{$ENV.section}/my/vacancy/edit/{$l.vid}.php"{if $l.hide} style="color:#999999"{/if}>{$l.vid}</a>{if $l.hide}<br/><span style="color:#999999">скрыта</span>{elseif $l.moderate != 0}<br/><span>скрыта</span>{elseif $l.is_new == 2 && $l.moderate == 0}<br/><span style="color:red; font-weight: bold">ожидает<br/>проверки</span>{/if}</td>
					<td align="center" class="text11"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}><span {if !$l.hide && $l.is_new != 2}style="color:red"{/if}><b>{$l.ptime}</b></span><br/>{$l.pdate}</td>
					<td align="center" class="text11"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}><span {if !$l.hide && $l.is_new != 2}style="color:red"{/if}><b>{$l.vtime}</b></span><br/>{$l.vdate}</td>
					<td{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}>{$l.firm}</td>
					<td><a href="/{$ENV.section}/my/vacancy/edit/{$l.vid}.php"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}><b>
						{if $l.dolgnost != ''}
							{$l.dolgnost}
						{else}
							{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}
							{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid"}
						{/if}
					</b></a></td>

				{if $res.is_commerce && $res.HandsOrder && sizeof($res.data) > 1 }
					<td class="t7" nowrap="nowrap">
						{if !$smarty.foreach.lst.first}<a href="/{$ENV.section}/my/vacancy/move/up/{$l.vid}-{$res.page}.php" title="Переместить вверх" alt="Переместить вверх"><img {if $smarty.foreach.lst.last}hspace="8"{/if} src="/_img/design/200608_title/bullet_arrow_up.gif" border="0"></a>{/if}
						{if !$smarty.foreach.lst.last}<a href="/{$ENV.section}/my/vacancy/move/down/{$l.vid}-{$res.page}.php" title="Переместить вниз" alt="Переместить вниз"><img {if $smarty.foreach.lst.first}hspace="8"{/if} src="/_img/design/200608_title/bullet_arrow_down.gif" border="0"></a>{/if}
						<input name="ord[{$l.vid}]" type="text" value="{$l.order}" size="2"/>
					</td>
				{/if}

					<td align="center"><input type="checkbox" name="arr_vac[]" value="{$l.vid}" {*if $l.moderate<0}disabled="disabled"{/if*}/></td>
				</tr>
			{/foreach}
			<tr>
				<td colspan="{if sizeof($res.data) > 1}8{else}7{/if}" align="right" class="text11">{$smarty.capture.pageslink}</td>
			</tr>
			</table>
			<div align="right">Действие:
				<select name="user_action">
					<option value="prolong">Продлить на неделю</option>
					<option value="hide">Не отображать на сайте</option>
					<option value="show">Показать на сайте</option>
					<option value="delete">Удалить</option>
				</select>	
			</div>
			<input type="submit" value="Применить" class="in">&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Сброс" class="in">
			</form>
		</td>
	</tr>

</table><br/>