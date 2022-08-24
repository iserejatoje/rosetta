{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме (`$res.count`)"}

{if $res.moderate_count>0}
<br/>
<div align="center" style="color:red">
<b>Вам отказано в размещении {$res.moderate_count} резюме</b>
</div>
<br/>
{/if}

<div align="right">
Сегодня размещено резюме: <b>{$res.today_count}</b><br/>
{if $res.premoderate_count}Ожидают проверки модератором: <b>{$res.premoderate_count}</b><br/>{/if}
{if $res.protect_count}<b>Внимание!</b> Можно размещать (продлять) не более <b>{$res.protect_count}</b> объявлений в сутки.<br/>{/if}
{if $CONFIG.protect_time}Продлять объявления разрешается не чаще, чем 1 раз в <b>{$CONFIG.protect_time}</b> часов.<br/>{/if}
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
	<br/><br/><div align="center" style="padding-bottom:5px;"><b>
		{foreach from=$res.err item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{/if}

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
		<td align="center">
			<form method="post" >
			<input type="hidden" name="action" value="resume_edit_list">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<th colspan="{if sizeof($res.data) > 1}9{else}8{/if}">Выберите резюме для редактирования</th>
				</tr>
				<tr bgcolor="#e9efef">
					<th>#</th>
					<th>Дата<br/>разм.</th>
					<th>Дата<br/>истеч.</th>
					<th>Ф.И.О. / Раздел</th>
					<th>Должность</th>
					<th>Выбор<br/><input type="checkbox" onclick="mod_job.selAll('arr_res',this);" /></th>
				</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.data item=l name=lst}
				<tr class="{excycle}" valign="top"{if $l.moderate != 0 || $USER->ID == 1} style="background-color:#FFAEAA"{/if}>
					<td align="center" class="text11"><a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php"{if $l.hide} style="color:#999999"{/if}>{$l.resid}</a>
						{if $l.hide}
							<br/><span style="color:#999999">скрыта</span>
						{elseif $l.moderate != 0}
							<br/><span>скрыта</span>
						{elseif $l.is_new == 2 && $l.moderate == 0}
							<br/><span style="color:red; font-weight: bold">ожидает<br/>проверки</span>
						{/if}</td>
					{*<td align="center" class="text11"><a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php"{if $l.hide || $l.is_new == 2} style="color:#999999"{/if}>{$l.resid}</a>{if $l.hide && $l.is_new != 2}<br/><span style="color:#999999">скрыто</span>{elseif $l.is_new == 2}<br/><span style="color:red; font-weight: bold">ожидает<br/>проверки</span>{/if}</td>*}
					<td align="center" class="text11"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}><span {if !$l.hide && $l.is_new != 2}style="color:red"{/if}><b>{$l.ptime}</b></span><br/>{$l.pdate}</td>
					<td align="center" class="text11"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}><span {if !$l.hide && $l.is_new != 2}style="color:red"{/if}><b>{$l.vtime}</b></span><br/>{$l.vdate}</td>
					<td{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}>{$l.fio}<br/>{$l.name}</td>
					<td><a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php"{if ($l.hide || $l.is_new == 2) && $l.moderate == 0} style="color:#999999"{/if}>{$l.dol}</a></td>
					<td align="center"><input type="checkbox" name="arr_res[]" value="{$l.resid}"/></td>
				</tr>
				{/foreach}
				<tr>
					<td colspan="{if sizeof($res.data) > 1}9{else}8{/if}" align="right" class="text11">{$smarty.capture.pageslink}</td>
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
