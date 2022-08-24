<br /><br /><br />
<table cellpadding="0" cellspacing="2" border="0" width="98%" align="center" class="table2">
	<tr>
		<th>Дата</th>
		<th width="50%">Должность</th>
		<th>З/П</th>
		<th>Условия</th>
	</tr>
	{excycle values=" ,bg_color4"}
	{foreach from=$res.list item=l name=vacancy_list}
	<tr class="{excycle}" valign="top">
		<td class="text11">{$l.date|date_format:"%e.%m.%Y"}</td>
		<td><a href="/{$ENV.section}/vacancy/{$l.vid}.html?fid={$res.firm.fid}" {if $l.imp}style="color:red;"{/if}>
		<b>
		{if $l.dol != ""}
			{$l.dol|escape}
		{else}
			{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}
			{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid"}			
		{/if}</b>
		</a></td>
		<td align="right">{$l.paysum}</td>
		<td>{$l.uslov|escape|truncate:40:"...":false}</td>
	</tr>
	{/foreach}
</table>

{if $res.firm.isotz && $res.firm.ftype>0}
	<div style="text-align:center" class="text11"><a href="/{$ENV.section}/question/{$res.firm.fid}.php" style="color:red">Задать вопрос</a></div>
{/if}
<br/><br/><br/>