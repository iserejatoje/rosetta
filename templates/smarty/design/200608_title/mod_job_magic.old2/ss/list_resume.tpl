{capture name="rname"}
	{if !$res.search}
		{if $res.rid>0}РЕЗЮМЕ - {$res.raname}
		{else}Последние резюме{/if}
	{else}
		{$res.raname}
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
	<div class="text11" style="text-align:right"><a href="/{$ENV.section}/resume/search.php?{$res.search_query}">Изменить параметры поиска</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
{/if}
<div class="text11" style="float:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего резюме <b>{$res.vcount_all|number_format:"0":",":" "}</b>{if !$res.arh && $res.vcount_all-$res.vcount > 0} (из них <b>{$res.vcount_all-$res.vcount|number_format:"0":",":" "}</b> в архиве){/if}.{if $res.bb <= $res.be} Показано: <b>{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</b>{/if}</div>
{if $res.arh}<div class="text11" style="float:right">Архив&#160;включен&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>{/if}
<br/>

{if sizeof($res.res)}
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
		<tr>
			<th style="border-right: solid 2px #fff;">Дата</th>
			<th width="50%" style="border-right: solid 2px #fff;">ФИО</th>
			<th width="50%" style="border-right: solid 2px #fff;">Должность</th>
			<th>З/П</th>
		</tr>
		{excycle values=" ,bg_color4"}
		{foreach from=$res.res item=l name=listrows}
			{capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
			{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
			<tbody class="{excycle}">
			<tr valign="top">
			      <td nowrap="nowrap" align="center" class="text11" style="border-right: solid 2px #fff;"><span style="color:red"><b>{$l.time}</b></span><br/>{$l.date}</td>
			      <td style="border-right: solid 2px #fff;">{$l.fio}</td>
			      <td style="border-right: solid 2px #fff;">
					<a class="list" href="{$smarty.capture.link}resume/{$l.resid}.html{if $l.archive == 1}?archive{if $l.rid}&rid={$l.rid}{/if}{elseif $l.rid}?rid={$l.rid}{/if}"{$smarty.capture.target}>{if $l.imp}<font color="red">{$l.dol|truncate:45:"...":false}</font>{else}{$l.dol|truncate:45:"...":false}{/if}</a><br/>
					<div align="right"><a href="javascript:void(0);" onclick="mod_job.show_details('resume',{$l.resid});" class="tip" style="color:#999999">краткий просмотр...</a></div>
				  </td>
			      <td align="right">{$l.pay|replace:"от ":"от&nbsp;"}</td>
			</tr>
			<tr valign="top"><td colspan="4" align="center" style="padding:0px;"><div id="resume{$l.resid}loader" style="display:none"></div><div id="resume{$l.resid}content" style="display:none"></div></td></tr>
			</tbody>

			{if $smarty.foreach.listrows.iteration == 7 && !empty($TEMPLATE.midbanner)}
			<tr>
				<td colspan="4" align="center">
				{include file="`$TEMPLATE.midbanner`"}
				</td>
			</tr>
			{/if}
			{if ($CURRENT_ENV.regid == 16) && (($smarty.foreach.listrows.iteration == 9) OR ( $smarty.foreach.listrows.total < 9 AND $smarty.foreach.listrows.iteration == $smarty.foreach.listrows.total))}
			<tr>
				<td colspan="4" align="center">{banner_v2 id="1584"}</td>
			</tr>
			{/if}

			{if $smarty.foreach.listrows.iteration == 14 && !empty($TEMPLATE.nizbanner) }
			<tr>
				<td colspan="4" align="center">
				{include file="`$TEMPLATE.nizbanner`"}
				</td>
			</tr>
			{/if}

			{if $smarty.foreach.listrows.iteration == 21 && !empty($TEMPLATE.lastbanner)}
			<tr>
				<td colspan="4" align="center">
				{include file="`$TEMPLATE.lastbanner`"}
				</td>
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

{* sms-блок *}
{if in_array($CURRENT_ENV.regid, array(74, 63, 59, 72, 16, 61, 2, 34))}
<div align="center" style="border: 1px dashed #999999; padding: 10px; background-color: #EDF6F8;">
<small>Ваше резюме может находиться на первой странице в конкретной рубрике и быть выделено красным цветом. В этом случае оно станет намного более заметным для работодателей:
<br /><br />
<img height="79" border="0" width="490" src="http://rugion.ru/img/misc/top_row.jpg" alt=""/>
<br /><br /><a href="/job/rules.html#sms">Как это сделать?</a>
</small>
</div>
{/if}

<center>
<br/><br/>

{if $res.last && !$res.arh && $res.vcount_all > 0}
{* Остальные резюме находятся в архиве и доступны для просмотра на коммерческой основе. *}
{if sizeof($res.res)==0}
<br/><br/><a href="/{$ENV.section}/">Перейти к списку рубрик</a>
{/if}
<br/>{/if}
{if !$res.arh && $res.arh_desc}{if !$res.search_query}<br/>{$res.curator}{/if}{/if}</center><br/><br/><br/>
