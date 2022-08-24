<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td valign="top"><br/>
          
		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
              
              <td align="left" class="print">
				<div style="float: left; position: relative;">
				<a href="{$res.links.advanced}" 
				onclick="{literal}
				if ($(this).html() == 'Краткий прогноз') { 
					$('#wprint').attr('href', '{/literal}{$res.links.simple_print}{literal}');
					
					$('.w-list-adv').removeClass('adv');
					$('.w-list-adv-d').hide(); 
					$('a', '.w-list-adv').attr('title', 'Подробнее...');
					$(this).html('Подробный прогноз'); 
					$(this).attr('href', '{/literal}{$res.links.advanced}{literal}'); 
				} else { 
					$('#wprint').attr('href', '{/literal}{$res.links.advanced_print}{literal}');
					
					$('.w-list-adv').addClass('adv');
					$('a', '.w-list-adv').attr('title', 'Кратко');
					$('.w-list-adv-d').show(); 
					$(this).html('Краткий прогноз'); 
					$(this).attr('href', '{/literal}{$res.links.simple}{literal}'); 
				}{/literal} return false;" class="action dashed">{if $res.page != 'simple'}Краткий прогноз{else}Подробный прогноз{/if}</a>
				</div>
				<div style="float: right; position: relative;">
					<a href="{$res.links.comments}" class="comments_action">обсудить текущую погоду</a>
				</div>
			</td>
            </tr>
          </table>
		  <br/>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="list">
				<tr class="head">
					<td style="width: 160px;">День недели</td>

					<td class="vline"></td>

					<td width="100">Облачность</td>

					<td class="vline"></td>

					<td>Температура</td>
					
					<td class="vline"></td>
					
					<td>Описание погоды</td>
				</tr>

				{foreach from=$res.current item=w}
				{foreach from=$w item=w1 name=weather1}
	            <tr class="adv">
	              <td align="left" class="date">
				  {if 1 == $smarty.foreach.weather1.iteration}
				  <div>
					<span class="day{if in_array(date('w', $w1.DateTS), array(0,6))}we{/if}">{$w1.DayOfWeek}</span><br/>
					{$w1.DayMonth}
				</div>
				  {/if}

					<span class="hour">{$w1.HourText}</span>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td width="120">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="26">{if isset($w1.PrecipImg)}<img width="20" height="20" class="png" src="{$res.icon_url}small/{$w1.HourType}/{$w1.PrecipImg}.png" alt="{$w1.PrecipText|escape:"quotes"}" title="{$w1.PrecipText|escape:"quotes"}" />{/if}</td>
							<td width="100%"><span class="desc">{$w1.PrecipText}</span></td>
						</tr>
					</table>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td align="center">
					<span class="temp1">{if $w1.T > 0}+{/if}{$w1.T}</span>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td>
				  <span class="desc">				 
					{if $w1.WindWard}Ветер {$w1.WindWard[0]}, {if $w1.WindSpeed > 0}{$w1.WindSpeed} м/с,{/if}{/if}
					{if $w1.Humidity > 0}влажность {$w1.Humidity}%, {/if}
					вероятность осадков {if $w1.PrecipChance > 0}{$w1.PrecipChance}{else}0{/if}%
					</span></td>
	            </tr>

				{/foreach}
				
				<tr class="line">
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
				</tr>
				{/foreach}
				
				{foreach from=$res.list item=w key=k}
				<tr {if $res.page == 'simple'}class="w-list-adv"{else}class="w-list-adv adv"{/if}>
	              <td class="date">
					<a href="javascript:;" title="{if $res.page != 'simple'}Кратко{else}Подробнее...{/if}" onclick="{literal}if(this.title == 'Кратко') this.title = 'Подробнее...'; else this.title = 'Кратко'; $(this).parents().parents('tr:eq(0)').toggleClass('adv'); $('.d{/literal}{$k}{literal}').map(function () { 
                                $(this).toggleClass('adv');
								$(this).toggle();
                              });{/literal}"><span class="day{if in_array(date('w', $w.DateTS), array(0,6))}we{/if}">{$w.DayOfWeek}</span></a><br/>
	                {$w.DayMonth}
				</td>
	              
				  <td class="vline"></td>
	              
				  <td align="center">{if isset($w.PrecipImg)}<img width="38" height="38" class="png" src="{$res.icon_url}middle/day/{$w.PrecipImg}.png" alt="{$w.PrecipText|escape:"quotes"}" title="{$w.PrecipText|escape:"quotes"}" />{/if}</td>
	              
				  <td class="vline"></td>
	              
				  <td align="center">
					<span class="temp1">{if $w.TDay > 0}+{/if}{$w.TDay}</span>
					<span class="temp2">{if $w.TNight > 0}+{/if}{$w.TNight}</span>
				 </td>
	              
				  <td class="vline"></td>
	              
				  <td><span class="desc">{$w.PrecipText}</span></td>
	            </tr>
				
				{foreach from=$res.adv[$k] item=w1}
	            <tr {if $res.page == 'simple'}class="w-list-adv w-list-adv-d d{$k}" style="display: none"{else}class="w-list-adv w-list-adv-d adv d{$k}"{/if}>
	              <td align="right" class="date">
					<span class="hour">{$w1.HourText}</span>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td width="120">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="26">{if isset($w1.PrecipImg)}<img width="20" height="20" class="png" src="{$res.icon_url}small/{$w1.HourType}/{$w1.PrecipImg}.png" alt="{$w1.PrecipText|escape:"quotes"}" title="{$w1.PrecipText|escape:"quotes"}" />{/if}</td>
							<td width="100%"><span class="desc">{$w1.PrecipText}</span></td>
						</tr>
					</table>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td align="center">
					<span class="temp1">{if $w1.T > 0}+{/if}{$w1.T}</span>
				  </td>
	              
				  <td class="vline"></td>
	              
				  <td>
				  <span class="desc">
					{if $w1.WindWard}Ветер {$w1.WindWard[0]}, {if $w1.WindSpeed > 0}{$w1.WindSpeed} м/с,{/if}{/if}
					{if $w1.Humidity > 0}влажность {$w1.Humidity}%, {/if}
					вероятность осадков {if $w1.PrecipChance > 0}{$w1.PrecipChance}{else}0{/if}%</span></td>
	            </tr>

				{/foreach}

				<tr class="line">
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
					<td class="vline"></td>
					<td><img width="100%" height="2" src="/_img/modules/weather/lin2.gif"/></td>
				</tr>
				
				{/foreach}
			</table>
		</td>
	</tr>
</table>

{if $res.page != 'print'}<br/>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="desc" width="98%"><noindex>Прогноз погоды по данным спутников сайта <a class="desc" href="http://weather.com/" rel="nofollow" target="_blank">weather.com</a>.<br />
			Информация о погоде обновляется один раз в час.</noindex></td>
		<td align="right" style="padding-right: 5px;"><img width="12" height="11" border="0" src="/_img/design/200608_title/print.gif"/></td>
		<td><nobr><a id="wprint" href="{if $res.page == 'simple'}{$res.links.simple_print}{else}{$res.links.advanced_print}{/if}" target="wprint"
		onclick="window.open('about:blank', 'wprint','width=700,height=500,resizable=1,menubar=0,scrollbars=1').focus();"
		><span class="desc">Версия&nbsp;для&nbsp;печати</span></a></nobr></td>
	</tr>
</table>
{/if}

{if trim($res.timer.Text) != ''}<br/><br/><br/>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="a11_lgrey">
			<font class="t12slogan"><strong>Сегодня по народному календарю</strong></font><br/>
			{$res.timer.Text}
		</td>
	</tr>
</table>{/if}<br/><br/>


{include file="design/200608_title/common/block_weather_under_footer.tpl"}

{if $res.page == 'print'}
	<br/>
	<div style="text-align:center" class="print desc">
		<a href="javascript:;" onclick="window.close()">Закрыть</a> | 
		<a href="javascript:;" onclick="window.print();">Печать</a>
	</div>
	<br/><br/>
	{literal}
	<script>
		$(function(){ window.print() });
	</script>
	{/literal}
{/if}

