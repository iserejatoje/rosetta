{capture name="link"}{if $ENV.regid == 74 && $res.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
{capture name="target"}{if $ENV.regid == 74 && in_array($res.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
{if $res.in_state == 1}

	<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	{if $res.city}
		<tr>
			<td align='right' width="130"><b>Город:</b></td>
			<td width="100%">{$res.city}</td>
		</tr>
	{/if}
	<tr>
		<td align='right' width="130"></td>
		<td>Срок размещения вакансии истек</td>
	</tr>
	</table>
{elseif is_array($res) && !sizeof($res) }
	<div align="center">
		<span style="color:red;"><b>Запрошенная вами вакансия не найдена</b></span><br/><br/>
	</div>
{else}

	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
	{if $res.city}
	<tr>
		<td align='right' width="130"><b>Город:</b></td>
		<td width="100%">{$res.city}</td>
	</tr>
	{/if}
	{if $res.region}
	<tr>
		<td align='right' width="130"><b>Место&nbsp;работы&nbsp;(район):</b></td>
		<td width="100%">{$res.regions[$res.region].name}</td>
	</tr>
	{/if}
	{if $res.grafik}
	<tr>
		<td align='right' width="130"><b>График&nbsp;работы:</b></td>
		<td width="100%">{$res.grafik}</td>
	</tr>
	{/if}
	{if $res.jtype}
	<tr>
		<td align='right' width="130"><b>Тип&nbsp;работы:</b></td>
		<td width="100%">
			{foreach from=$res.jtype item=v key=k}
				{$res.WorkType_arr[$k]}<br/>
			{/foreach}
		</td>
	</tr>
	{/if}
	{if $res.uslov}
	<tr>
		<td align='right' width="130"><b>Условия:</b></td>
		<td width="100%">{$res.uslov|nl2br}</td>
	</tr>
	{/if}
	{if $res.treb}
	<tr>
		<td align='right' width="130"><b>Требования:</b></td>
		<td width="100%">{$res.treb|nl2br}</td>
	</tr>
	{/if}
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" width="100%"><tr>
				<td width="75%" align="left">
					{if $res.show_incorrect == 1}Это объявление некорректно? <a class="tip" href="#" onclick="mod_job_incorrect_obj.show({$res.vid}, 'vacancy'); return false;">Сообщите нам об этом</a>.{/if}
				</td>
				<td width="25%" align="right">		
					<a href="{$smarty.capture.link}vacancy/{$res.vid}.html{if $res.rid}?rid={$res.rid}{/if}" class="tip"{$smarty.capture.target}>подробнее...</a>
				</td>	
			</tr></table>
		</td>			
	</tr>
	</table>
{/if}
<div id="incorrect_container_{$res.vid}" class="incorrect_container" align="center" style="display: none;">&nbsp;</div>