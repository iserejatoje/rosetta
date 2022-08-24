{capture name="rname"}
	{if $res.search}
		{$res.raname}
	{else}
		{if $res.hot}Горящие вакансии{elseif $res.rid>0}ВАКАНСИИ - {$res.raname}{else}Последние вакансии{/if}
	{/if}
{/capture}

{capture name=pageslink}
{if count($res.pages.btn) > 0}
	Страницы:&#160;
	{if !empty($res.pages.back)}<a href="{$res.pages.back}" title="Предыдущая страница">&lt;&lt;&lt;</a>{/if}{
	foreach from=$res.pages.btn item=l}
		{if !$l.active
			}<a href="{$l.link}">[{$l.text}]</a>&nbsp;{
		else
			}[{$l.text}]&nbsp;{
		/if}{
	/foreach}{
	if !empty($res.pages.next)}<a href="{$res.pages.next}" title="Следующая страница">&gt;&gt;&gt;</a>{/if}
{/if}
{/capture}

{if $res.search}
	{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`" hide_search=true}
{else}
	{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
{/if}<br/>
{if $res.search_query}
<div style="text-align:right" class="dop2"><a href="/{$ENV.section}/vacancy/search.php?{$res.search_query}">Изменить параметры поиска</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
{/if}
<div class="dop2" style="text-align:right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего вакансий <font class="zag2">{$res.vcount_all|number_format:"0":",":" "}</font>{if $res.vcount_all-$res.vcount > 0} (из них <font class="zag2">{$res.vcount_all-$res.vcount|number_format:"0":",":" "}</font> в архиве){/if}{if $res.bb <= $res.be}<br/>Показано: <font class="zag2">{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</font>{/if}</div>
<br/><br/>

{if sizeof($res.vac)}
<center>
<table cellpadding=0 cellspacing=0 border=0 bgcolor="#FFFFFF" width=100%>
	<tr><td><table cellpadding=4 cellspacing=1 border=0 width=100%>
		<tr bgcolor="#D7F0FC">
			<th class="dopp" align="center">Время/Дата</th>
			<th class="dopp" align="center">Фирма</th>
			<th class="dopp" align="center">Должность</th>
			<th class="dopp" align="center">З/П</th>
		</tr>

		{excycle values="#F3F8F8,#FFFFFF"}
		{foreach from=$res.vac item=l name=listrows}
			<tr bgcolor="{excycle}">
			      <td class="dopp" valign="top" align="left"><font class="s3"><font color=red><b>&nbsp;{$l.time}</b></font></font><br>&nbsp;{$l.date}</td>
			      <td class="dopp" valign="top">{$l.firm}</td>
			      <td class="dopp" valign="top"><a href="/{$ENV.section}/vacancy/{$l.vid}.html{if $l.rid}?rid={$l.rid}{/if}" class="s3">{if $l.imp}<font color=red>{$l.dol}</font>{else}{$l.dol}{/if}</a></td>
			      <td class="dopp" valign="top" align="right">{$l.pay}</td>
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
</table>

{if $smarty.capture.pageslink!="" }
	<br/>
	<div style="text-align:right" class="text11">{$smarty.capture.pageslink}</div>
	{/if}
	<br/><br/>
{/if}

{if $res.last && $res.vcount_all > 0}

<center><br/>Остальные вакансии находятся в архиве и не доступны для просмотра.
	{if sizeof($res.vac)==0}
		<br/><br/><a href="/{$ENV.section}/">Перейти к списку рубрик</a>
	{/if}<br/>
</center>

{/if}
<br/><br/><br/>
