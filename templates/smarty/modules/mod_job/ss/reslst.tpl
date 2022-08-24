{*изменено по требованию Россвязьнадзор*}
{capture name="rname"}
	{if $smarty.get.cmd!="searchres"}
		{if $res.rid>0}РЕЗЮМЕ - {$res.raname}
		{elseif $res.arh}Архив резюме{else}Последние резюме{/if} 
	{else}
		{$res.raname}
	{/if}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
{if is_array($res.res) && sizeof($res.res)}
<br/>
<table cellpadding=0 cellspacing=0 border=0 width="100%">
      	<tr>
			<td class="t7" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего <b>{$res.vcount|number_format:"0":",":" "}</b> резюме в этом разделе. Показано: <b>{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</b>
		</td>
		{if $res.arh}<td class="t7">Архив&#160;включен&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>{/if}
	</tr>
</table>

<table cellpadding=0 cellspacing=0 border=0 align="center" width=100%>
	<tr><td><table cellpadding=4 cellspacing=1 border=0 width=100%>
		<tr bgcolor="#e9efef">
			<td class="t1" align="center">Время/Дата</td>
			<td class="t1" align="center">Имя{*ФИО*}</td>
			<td class="t1" align="center">Должность</td>
			<td class="t1" align="center">З/П</td>
			<td class="t1" align="center">Город</td>
		</tr>
		{php}
			$i=0;
		{/php}
		{excycle values="#F3F8F8,#FFFFFF"}
		{foreach from=$res.res item=l name=listrows}
				{capture name="site"}/{$CURRENT_ENV.section}/{/capture}
				{capture name="target"}{/capture}
			<tr bgcolor="{excycle}">
			      <td class="t7" valign="top" align="left"><font class="s3"><font color=red><b>&nbsp;{$l.time}</b></font></font><br>&nbsp;{$l.date}</td>
			      <td class="t7" valign="top">{$l.fio}</td>
			      <td class="t7" valign="top"><a href="{$smarty.capture.site}?cmd=showres&rid={$l.rid}&id={$l.resid}{if $l.archive == 1}&archive=1{/if}" class="s3" {$smarty.capture.target}>{if $l.imp}<font color=red>{$l.dol}</font>{else}{$l.dol}{/if}</a></td>
			      <td class="t7" valign="top" align="right">{$l.pay}</td>
			      <td class="t7" valign="top" align="center">{$l.city}</td>
			</tr>

			{if $smarty.foreach.listrows.iteration == 7  }
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
</table><br/>

<table cellpadding=0 cellspacing=0 border=0 width=98%>
	<tr>
		<td class="t7" align="right">
			{$res.pcontrol}
		</td>
	</tr>
</table>
<br/><br/>
{else}<center>
<br/><br/>Запрошенная вами страница не найдена или не существует.
<br/><br/>
<a href="/{$CURRENT_ENV.section}/?cmd=reslst&rid={$res.rid|intval}&p=1">Перейти к началу раздела</a></center>
{/if}
{if !$res.arh && $res.arh_desc}<br/>{$res.curator}{/if}