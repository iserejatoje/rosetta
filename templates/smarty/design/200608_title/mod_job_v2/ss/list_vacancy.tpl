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

<form method="get" action="1.php" enctype="application/x-www-form-urlencoded">
{foreach from=$smarty.get key=k item=v}
	{if $k != 'scope'}
		{if ( is_array($v) )}
			{foreach from=$v item=l}
				<input type="hidden" name="{$k}[]" value="{$l}" />
			{/foreach}
		{else}
			<input type="hidden" name="{$k}" value="{$v}" />
		{/if}
	{/if}
{/foreach}
			
<table class="bg_color2" width="100%" cellpadding="5" style="margin-bottom: 20px;">
	<tr>
		<td class="tip" colspan="7">
		<b>Выводить вакансии:</b>
		</td>
	</tr>
	<tr>
		<td style="padding:3px 0 0 5px" valign="top">
			<input id="scope2" type="checkbox" name="scope[]" value="2" {if !is_array($res.scope) || in_array(2,$res.scope)}checked="checked"{/if} />
		</td>
		<td class="text11" width="30%" valign="top">
			<label for="scope2">прямой работодатель</label>
		</td>
		
		<td style="padding:3px 0 0 5px" valign="top">
			<input id="scope1" type="checkbox" name="scope[]" value="1" {if !is_array($res.scope) || in_array(1,$res.scope)}checked="checked"{/if} />
		</td>
		<td class="text11" width="30%" valign="top">
			<label for="scope1">рекрутинговое агентство</label>
		</td>
		
		<td style="padding:3px 0 0 5px" valign="top">
			<input id="scope4" type="checkbox" name="scope[]" value="4" {if !is_array($res.scope) || in_array(4,$res.scope)}checked="checked"{/if} />
		</td>
		<td class="text11" width="30%" valign="top">
			<label for="scope4">кадровый центр</label>
		</td>
		
		<td valign="bottom">
			<input type="submit" value="Выбрать" />
		</td>
	</tr>
</table>
</form>

{if $res.search_query}
<div style="text-align:right" class="text11"><a href="/{$ENV.section}/vacancy/search.php?{$res.search_query}">Изменить параметры поиска</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
{/if}
<div class="text11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Всего вакансий <b>{$res.vcount_all|number_format:"0":",":" "}</b>{if $res.vcount_all-$res.vcount > 0} (из них <b>{$res.vcount_all-$res.vcount|number_format:"0":",":" "}</b> в архиве){/if}.{if $res.bb <= $res.be} Показано: <b>{$res.bb|number_format:"0":",":" "} - {$res.be|number_format:"0":",":" "}</b>{/if}</div>

{if sizeof($res.vac)}

			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
				<tr>
					<th style="border-right:solid 2px #fff;">Дата</th>
					<th width="50%" style="border-right:solid 2px #fff;">Фирма</th>
					<th width="50%" style="border-right:solid 2px #fff;">Должности</th>
					<th>З/П</th>
				</tr>
							
				{excycle values=" , ,bg_color4,bg_color4"}
				{foreach from=$res.vac item=l name=listrows}
				
				{capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
				{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
				
				<tr valign="top" class="{excycle}">
					<td nowrap="nowrap" align="center" class="text11" style="border-right:solid 2px #fff;"><span style="color:red"><b>{$l.time}</b></span><br/>{$l.date}</td>
					<td style="border-right:solid 2px #fff;">{if $l.ftype>0 && $l.fid>0}<a class="list" href="/{$ENV.section}/vacancy/firm/{$l.fid}.php">{/if}{if $l.imp}<font color=red>{/if}{$l.firm}{if $l.imp}</font>{/if}{if $l.ftype>0}</a>{/if}{if $l.ftype==1}&nbsp;<img src="/_img/modules/job/icon_a.png" width="11" height="11" alt="Кадровое агентство" title="Кадровое агентство" />{elseif $l.ftype==2}&nbsp;<img src="/_img/modules/job/icon_r.png" width="11" height="11" alt="Прямой работодатель" title="Прямой работодатель" />{/if}</td>
					<td style="border-right:solid 2px #fff;">
						<a class="list" href="{$smarty.capture.link}vacancy/{$l.vid}.html{if $l.rid}?rid={$l.rid}{/if}"{$smarty.capture.target}><b>
						{if $l.imp}<font color=red>{/if}
							{if $l.dol != ""}
								{$l.dol}
							{else}
								{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}								
								{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid"}								
							{/if}
						{if $l.imp}</font>{/if}</b>
						</a><br/>
						<div align="right"><a href="javascript:void(0);" onclick="mod_job.show_details('vacancy',{$l.vid});" class="tip" style="color:#999999">краткий просмотр...</a></div>
					</td>
					<td align="right">{if $l.imp}<font color=red>{/if}{$l.pay|replace:"от ":"от&nbsp;"}{if $l.imp}</font>{/if}</td>
				</tr>
				<tr class="{excycle}" valign="top"><td colspan="4" align="center" style="padding:0px;"><div id="vacancy{$l.vid}loader" style="display:none"></div><div id="vacancy{$l.vid}content" style="display:none"></div></td></tr>
				
				{if $smarty.foreach.listrows.iteration == 7 OR ( $smarty.foreach.listrows.total < 7 AND $smarty.foreach.listrows.iteration == $smarty.foreach.listrows.total) }
				<tr>
					<td colspan="4" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{/if}

				{if $smarty.foreach.listrows.iteration == 14 }
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