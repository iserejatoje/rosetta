{capture name="rname"}
	{if $smarty.get.cmd=="searchvac"}
		{$res.raname}
	{else}
		{if $res.hot}Горящие вакансии{elseif $res.rid>0}ВАКАНСИИ - {$res.raname}{else}Последние вакансии{/if} 
	{/if}
{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}

{if is_array($res.vac) && sizeof($res.vac)}
<br/>
<table cellpadding=0 cellspacing=0 border=0>
      	<tr>
		<td class="t7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего <b>{$res.vcount|number_format:"0":",":" "}</b> вакансий в этом разделе. Показано: <b>{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</b></td>
	</tr>
</table>
<center>
<table cellpadding=0 cellspacing=0 border=0 bgcolor="#FFFFFF" width=100%>
	<tr><td><table cellpadding=4 cellspacing=1 border=0 width=100%>
		<tr bgcolor="#e9efef">
			<td class="t1" align="center">Время/Дата</td>
			<td class="t1" align="center">Фирма</td>
			<td class="t1" align="center">Должность</td>
			<td class="t1" align="center">З/П</td>
		</tr>
		{php}
			$i=0;
		{/php}
		{excycle values="#F3F8F8,#FFFFFF"}
		{foreach from=$res.vac item=l name=listrows}
				{capture name="site"}/{$CURRENT_ENV.section}/{/capture}
				{capture name="target"}{/capture}
			<tr bgcolor="{excycle}">
			      <td class="t7" valign="top" align="left"><font class="s3"><font color=red><b>&nbsp;{$l.time}</b></font></font><br>&nbsp;{$l.date}</td>
			      <td class="t7" valign="top">{$l.firm}</td>
			      <td class="t7" valign="top"><a href="{$smarty.capture.site}?cmd=showvac&rid={$l.rid}{$res.params}&id={$l.vid}" class="s3" {$smarty.capture.target}>{if $l.imp}<font color=red>{$l.dol}</font>{else}{$l.dol}{/if}</a></td>
			      <td class="t7" valign="top" align="right">{$l.pay}</td>
			</tr>
			{if $smarty.foreach.listrows.iteration == 7 OR ( $smarty.foreach.listrows.total < 7 AND $smarty.foreach.listrows.iteration == $smarty.foreach.listrows.total) }
			<tr>
				<td colspan="4" align="center">
				{include file="`$TEMPLATE.midbanner`"}
				</td>
			</tr>
			{/if}

			{if $smarty.foreach.listrows.iteration == 14 }
			<tr>
				<td colspan="4" align="center">
				{include file="`$TEMPLATE.nizbanner`"}
				</td>
			</tr>
			{/if}

		{/foreach}
		</table>
	</td></tr>
</table><br>

<table cellpadding=0 cellspacing=0 border=0 width=98%>
	<tr>
		<td class="t7" align="right">
			{$res.pcontrol}
		</td>
	</tr>
</table><br/><br/>
{else}<center>
<br/><br/>Запрошенная вами страница не найдена или не существует.
<br/><br/>
<a href="/{$CURRENT_ENV.section}/?cmd=vaclst&rid={$res.rid|intval}&hot={$res.hot|intval}&p=1">Перейти к началу раздела</a></center>
{/if}