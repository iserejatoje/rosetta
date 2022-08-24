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
{/if}
<br/>
{if $res.search_query}
<div style="text-align:right" class="text11"><a href="/{$ENV.section}/vacancy/search.php?{$res.search_query}">Изменить параметры поиска</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
{/if}
<div class="text11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего вакансий <b>{$res.vcount_all|number_format:"0":",":" "}</b>{if $res.vcount_all-$res.vcount > 0} (из них <b>{$res.vcount_all-$res.vcount|number_format:"0":",":" "}</b> в архиве){/if}.{if $res.bb <= $res.be} Показано: <b>{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</b>{/if}</div>

{if sizeof($res.vac)}

			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
				<tr>
					<th style="border-right:solid 2px #fff;">Дата</th>
					<th width="50%" style="border-right:solid 2px #fff;">Фирма</th>
					<th width="50%" style="border-right:solid 2px #fff;">Должность</th>
					<th>З/П</th>
				</tr>
							
				{excycle values=" ,bg_color4"}
				{foreach from=$res.vac item=l name=listrows}
				
				{capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
				{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
				
				<tbody class="{excycle}">
				<tr valign="top">
					<td nowrap="nowrap" align="center" class="text11" style="border-right:solid 2px #fff;"><span style="color:red"><b>{$l.time}</b></span><br/>{$l.date}</td>
					<td style="border-right:solid 2px #fff;">{if $l.ftype>0 && $l.fid>0}<a class="list" href="/{$ENV.section}/vacancy/firm/{$l.fid}.php">{/if}{if $l.imp}<font color=red>{/if}{$l.firm}{if $l.imp}</font>{/if}{if $l.ftype>0}</a>{/if}{if $l.ftype==1}&nbsp;<img src="/_img/modules/job/icon_a.png" width="11" height="11" alt="Кадровое агентство" title="Кадровое агентство" />{elseif $l.ftype==2}&nbsp;<img src="/_img/modules/job/icon_r.png" width="11" height="11" alt="Прямой работодатель" title="Прямой работодатель" />{/if}</td>
					<td style="border-right:solid 2px #fff;">
						<a class="list" href="{$smarty.capture.link}vacancy/{$l.vid}.html{if $l.rid}?rid={$l.rid}{/if}"{$smarty.capture.target}>{if $l.imp}<font color=red>{$l.dol}</font>{else}{$l.dol}{/if}</a><br/>
						<div align="right"><a href="javascript:void(0);" onclick="mod_job.show_details('vacancy',{$l.vid});" class="tip" style="color:#999999">краткий просмотр...</a></div>
					</td>
					<td align="right">{if $l.imp}<font color=red>{/if}{$l.pay|replace:"от ":"от&nbsp;"}{if $l.imp}</font>{/if}</td>
				</tr>
				<tr valign="top"><td colspan="4" align="center" style="padding:0px;"><div id="vacancy{$l.vid}loader" style="display:none"></div><div id="vacancy{$l.vid}content" style="display:none"></div></td></tr>
				</tbody>
				
				{if $smarty.foreach.listrows.iteration == 7 OR ( $smarty.foreach.listrows.total < 7 AND $smarty.foreach.listrows.iteration == $smarty.foreach.listrows.total)  && !empty($TEMPLATE.midbanner)}
				<tr>
					<td colspan="4" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{/if}

				{if $smarty.foreach.listrows.iteration == 14 && !empty($TEMPLATE.nizbanner)}
				<tr>
					<td colspan="4" align="center">{include file="`$TEMPLATE.nizbanner`"}</td>
				</tr>
				{/if}

				{if $smarty.foreach.listrows.iteration == 21 && !empty($TEMPLATE.lastbanner)}
				<tr>
					<td colspan="4" align="center">{include file="`$TEMPLATE.lastbanner`"}</td>
				</tr>
				{/if}

				{if $smarty.foreach.listrows.iteration == 28 && !empty($TEMPLATE.lastbanner2)}
				<tr>
					<td colspan="4" align="center">{include file="`$TEMPLATE.lastbanner2`"}</td>
				</tr>
				{/if}

				{/foreach}
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
{include file="`$CONFIG.templates.ssections.incorrect_form`" incorrect_marks="`$res.incorrect_marks`"}
