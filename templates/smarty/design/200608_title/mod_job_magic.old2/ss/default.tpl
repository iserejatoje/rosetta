{include file="`$TEMPLATE.sectiontitle`" rtitle="Работа: Вакансии и резюме по рубрикам"}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<th>Вакансии ({$page.allvac|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/1.php" style="color:red;" {if $ENV.site.domain=="74.ru"}onclick="OnCounterClick(131);"{/if}>новые</a></th>
					<th>Резюме ({$page.allres|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/resume/1.php" style="color:red;">новые</a></th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$page.razdel item=l name=razdel}
					{*capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
					{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture*}
				<tr class="{excycle}">
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/{$l.rid}/1.php">{if in_array($l.rid,array(22,23,36,37))}<font color="red">{/if}{$l.rname}{if in_array($l.rid,array(22,23,36,37))}</font>{/if}</a></div><div class="text11" style="float:right">{$l.vcount|number_format:"0":",":" "}</div></td>
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/resume/{$l.rid}/1.php">{if in_array($l.rid,array(22,23,36,37))}<font color="red">{/if}{$l.rname}{if in_array($l.rid,array(22,23,36,37))}</font>{/if}</a></div><div class="text11" style="float:right">{$l.rcount|number_format:"0":",":" "}</div></td>
				</tr>
				{if $smarty.foreach.razdel.iteration == 7 && ($CURRENT_ENV.regid != 16) && $TEMPLATE.midbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{elseif ($smarty.foreach.razdel.iteration == 5) && ($CURRENT_ENV.regid == 16) && $TEMPLATE.midbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{elseif $smarty.foreach.razdel.iteration == 14 && $TEMPLATE.nizbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.nizbanner`"}</td>
				</tr>
				{elseif $smarty.foreach.razdel.iteration == 21 && $TEMPLATE.lastbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.lastbanner`"}</td>
				</tr>
				{/if}
			{/foreach}
			</table>
<br/><br/><br/>
{if $CURRENT_ENV.regid == 74}
<p class="text11" align="left">
Работа в Челябинске на сайте 74.ru - это самая большая база вакансий и резюме в Уральском регионе. Удобная навигация с рубрикатором дает возможность осуществлять быстрый и качественный поиск нужных предложений как для соискателей, так и для работодателей. <br/>
Работа в Челябинске на сайте 74.ru - это более двух тысяч новых вакансий и резюме ежедневно. Лучшие компании и организации Челябинска размещают свои объявления  в разделе &laquo;Работа&raquo; на 74.ru.</p><br/><br/>
{/if}