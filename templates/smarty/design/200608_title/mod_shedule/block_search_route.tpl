{if !$smarty.get.print}

{php}
	$this->_tpl_vars['cur_date'] = date('d.m.Y');
	$this->_tpl_vars['tmr_date'] = date('d.m.Y',time()+86400);				
{/php}

<form method="get" action="/{$ENV.section}/search.php">

<table border="0" width="100%" cellspacing="0" cellpadding="4" class="bg_color2" style="margin-bottom:5px; -moz-border-radius:5px;">
<tr>
	<td>
		<div class="title2" style="float:left;padding-left:3px">Поиск маршрута</div>
		<div class="t11b" style="float:right"><label for="back" title="Найти также обратные рейсы">Обратно</label> <input type="checkbox" name="back" value="1" id="back" onclick="mod_shedule.toggleBack(this); if ( this.checked ) $('#dateExample').html('{$cur_date} / {$tmr_date}'); else $('#dateExample').html('{$cur_date}');"{if $smarty.get.back} checked{/if} />	</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td class="t11b" style="padding:4px">Станция отправления</td>
				<td class="t11b" style="padding:4px">Станция прибытия</td>
				<td class="t11b" style="padding:4px">Дата</td>
				<td class="t11b"></td>
			</tr>
			<tr>
				<td style="padding-left:4px;padding-right:4px;">
					<input type="text" id="station_from" name="station_from" style="width:100%" maxlength="100" value="{$smarty.get.station_from}" />
					<script>
						<!--
						{literal}
							$(document).ready(function() {
								$('#station_from').suggest("/{/literal}{$ENV.section}{literal}/", {
										maxCacheSize: -1,
										minchars: 3,
										action: 'station_suggest'
									}
								);							
							});
						{/literal}
						//-->
					</script>
				</td>
				<td style="padding-left:4px;padding-right:4px;">
					<input type="text" id="station_to" name="station_to" style="width:100%" maxlength="100" value="{$smarty.get.station_to}" />
					<script>
						<!--
						{literal}
							$(document).ready(function() {
								$('#station_to').suggest("/{/literal}{$ENV.section}{literal}/", {
										maxCacheSize: -1,
										minchars: 3,
										action: 'station_suggest'
									}
								);							
							});
						{/literal}
						//-->
					</script>
				</td>
				<td width="187" style="padding-left:4px;padding-right:4px;">
					<input type="text" id="date" name="date" style="width:205px" value="{$smarty.get.date}" />
					<script>
						<!--
						{literal}
							$(document).ready(function() {
								$('#date').attachDatepicker({
									rangeSelect: false,
									yearRange: "2000:2010",
									firstDay: 1,
									changeMonth: false,
									changeYear: false,
									changeFirstDay: false,
									mandatory: true
									});
							});
						{/literal}
						//-->
					</script>
				</td>
				<td width="50" style="padding-left:4px;padding-right:4px;">
					<input type="submit" value="Поиск" />
				</td>
			</tr>
			<tr>
				<td class="tip" style="color:#999999;padding-left:4px;padding-bottom:4px;">Например, <a href="javascript:void(0);" onclick="$('#station_from').val('МОСКВА')" id="stationfromExample">МОСКВА</a></td>
				<td class="tip" style="color:#999999;padding-left:4px;padding-bottom:4px;">Например, <a href="javascript:void(0);" onclick="$('#station_to').val('САНКТ-ПЕТЕРБУРГ')" id="stationtoExample">САНКТ-ПЕТЕРБУРГ</a></td>
				<td class="tip" style="color:#999999;padding-left:4px;padding-bottom:4px;">Например, <a href="javascript:void(0);" onclick="$('#date').val(this.innerHTML)" id="dateExample">{if $smarty.get.back}{$cur_date} / {$tmr_date}{else}{$cur_date}{/if}</a></td>
				<td></td>
			</tr>
		</table>
	</td>
</tr>
</table>

</form>

{/if}