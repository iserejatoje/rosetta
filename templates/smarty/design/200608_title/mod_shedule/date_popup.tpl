<table width="550" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td class="nyroModalTitle bg_color1">
			<div style="float:right">
				<img class="nyroModalClose" style="cursor:pointer;cursor:hand;padding-top:2px;" src="/_img/modules/passport/im/close.gif " />
			</div>
			<div align="left">Выберите даты</div>
		</td>
	</tr>
	<tr bgcolor="#E0F3F3" class="bg_color2">
		<td>
			<div class="t14b" style="padding:6px">Туда:</div>
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
			{foreach from=$res.months item=month key=m name=list}
				<td class="txt_color1" width="25%" align="center" valign="top">
					<b>{$month.name}</b>
					<table border="0" cellpadding="2" cellspacing="0" class="date_popup">
						<tr class="font-weight:bold; color:#999;"><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th><th class="holiday">сб</th><th class="holiday">вс</th></tr>
						
						{foreach from=$month.days item=d name=month}
							{if ($smarty.foreach.month.iteration-1)%7==0}
								<tr>
							{/if}
							{if $d}
								<td align="right"{if ($smarty.foreach.month.iteration)%7==0 || ($smarty.foreach.month.iteration)%7==6} class="holyday"{/if}>{$d}</td>
							{else}
								<td></td>
							{/if}
							{if ($smarty.foreach.month.iteration)%7==0}
								<tr>
							{/if}
						{/foreach}
						
					</table>
				</td>
			{/foreach}
			</tr>
			
			</table>
			<br/>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td align="left">
					<a style="cursor:pointer" onclick="mod_shedule.date_popup.load({$res.prev.month.value},{$res.prev.year})">&larr; {$res.prev.month.name}</a>
				</td>
				<td align="right">
					<a style="cursor:pointer" onclick="mod_shedule.date_popup.load({$res.next.month.value},{$res.next.year})">{$res.next.month.name} &rarr;</a>
				</td>
			</tr>
			</table>
			<br/>
			<div class="t14b" style="padding:6px"><input type="checkbox" name="back" id="date_popup_back" /> Обратно:</div>

		</td>
	</tr>
</table>