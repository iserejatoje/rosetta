<form name="filter" method="get" action="/{$ENV.section}/{$res.type}/search.php">
{if $smarty.get.gid}<input type="hidden" name="gid" value="{$smarty.get.gid}">{/if}
<table width="100%" border="0" cellspacing="5" cellpadding="0" bgcolor="#e0f3f3" style="margin-top:5px; -moz-border-radius: 8px;">
	<tr>
		<td style="padding-left:3px; padding-right:3px">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr><td class="block_title2"><span>Поиск события</span></td></tr>
				<tr><td bgcolor="#005a52" colspan="3"><img height="3" width="1" alt="" src="/_img/x.gif"/></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="padding-left:3px; padding-right:3px">
			<table {*if $smarty.foreach.pub.total>=3*}width="100%" {*/if*}border="0" cellspacing="0" cellpadding="2">
				{foreach from=$res.places item=p key=k name=pub}
					{if $smarty.foreach.pub.iteration%3==1 || $smarty.foreach.pub.total<3}
						<tr>
					{/if}
					<td valign="top">
						{*<input type="checkbox" name="p[{$k}]" id="p[{$k}]" style="margin-left:0px" value="1"{if $smarty.get.p[$k] || !is_array($smarty.get.p)} checked{/if}>*}
						<input type="checkbox" name="p[{$k}]" id="p[{$k}]" style="margin-left:0px" value="1"{if $smarty.get.p[$k]} checked{/if}>
					</td>
					<td {if $smarty.foreach.pub.total>=3}width="33%" {/if}valign="top">
						{*<label for="p[{$k}]">&nbsp;{$p.title}</label><br>*}
						<a href="/{$ENV.section}/{$res.type}/{$p.name}">{$p.title}</a>
					</td>
					{if $smarty.foreach.pub.iteration%3==0 || $smarty.foreach.pub.total<3}
						</tr>
					{/if}
				{/foreach}
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="padding-left:3px; padding-right:3px">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;&nbsp;Дата:&nbsp;&nbsp;</td>
				<td>
					<select name="range" id="range" class="txt" style="width: 100px;">
						<option value="">все</option>
						<option value="today" {if $smarty.get.range=="today"}selected{/if}>сегодня</option>
						<option value="today_and_tomorrow" {if $smarty.get.range=="today_and_tomorrow"}selected{/if}>сегодня-завтра</option>
						<option value="tomorrow" {if $smarty.get.range=="tomorrow"}selected{/if}>завтра</option>
						<option value="weekend" {if $smarty.get.range=="weekend"}selected{/if}>на выходных</option>
						<option value="week" {if $smarty.get.range=="week"}selected{/if}>на этой неделе</option>
					</select>
				</td>
				<td style="padding-left: 50px;">&nbsp;&nbsp;Начало&nbsp;с&nbsp;&nbsp;</td>
				<td>
					<select name="time_start" id="time_start" class="txt" style="width: 55px;">
						<option value="">-</option>
						<option value="00:00" {if $smarty.get.time_start=="00:00"}selected{/if}>00:00</option>
						<option value="06:00" {if $smarty.get.time_start=="06:00"}selected{/if}>06:00</option>
						<option value="07:00" {if $smarty.get.time_start=="07:00"}selected{/if}>07:00</option>
						<option value="08:00" {if $smarty.get.time_start=="08:00"}selected{/if}>08:00</option>
						<option value="09:00" {if $smarty.get.time_start=="09:00"}selected{/if}>09:00</option>
						<option value="10:00" {if $smarty.get.time_start=="10:00"}selected{/if}>10:00</option>
						<option value="11:00" {if $smarty.get.time_start=="11:00"}selected{/if}>11:00</option>
						<option value="12:00" {if $smarty.get.time_start=="12:00"}selected{/if}>12:00</option>
						<option value="13:00" {if $smarty.get.time_start=="13:00"}selected{/if}>13:00</option>
						<option value="14:00" {if $smarty.get.time_start=="14:00"}selected{/if}>14:00</option>
						<option value="15:00" {if $smarty.get.time_start=="15:00"}selected{/if}>15:00</option>
						<option value="16:00" {if $smarty.get.time_start=="16:00"}selected{/if}>16:00</option>
						<option value="17:00" {if $smarty.get.time_start=="17:00"}selected{/if}>17:00</option>
						<option value="18:00" {if $smarty.get.time_start=="18:00"}selected{/if}>18:00</option>
						<option value="19:00" {if $smarty.get.time_start=="19:00"}selected{/if}>19:00</option>
						<option value="20:00" {if $smarty.get.time_start=="20:00"}selected{/if}>20:00</option>
						<option value="21:00" {if $smarty.get.time_start=="21:00"}selected{/if}>21:00</option>
						<option value="22:00" {if $smarty.get.time_start=="22:00"}selected{/if}>22:00</option>
						<option value="23:00" {if $smarty.get.time_start=="23:00"}selected{/if}>23:00</option>
					</select>
				</td>
				<td>&nbsp;&nbsp;до&nbsp;&nbsp;</td>
				<td>
					<select name="time_end" id="time_end" class="txt" style="width: 55px;">
						<option value="">-</option>
						<option value="00:00" {if $smarty.get.time_end=="00:00"}selected{/if}>00:00</option>
						<option value="06:00" {if $smarty.get.time_end=="06:00"}selected{/if}>06:00</option>
						<option value="07:00" {if $smarty.get.time_end=="07:00"}selected{/if}>07:00</option>
						<option value="08:00" {if $smarty.get.time_end=="08:00"}selected{/if}>08:00</option>
						<option value="09:00" {if $smarty.get.time_end=="09:00"}selected{/if}>09:00</option>
						<option value="10:00" {if $smarty.get.time_end=="10:00"}selected{/if}>10:00</option>
						<option value="11:00" {if $smarty.get.time_end=="11:00"}selected{/if}>11:00</option>
						<option value="12:00" {if $smarty.get.time_end=="12:00"}selected{/if}>12:00</option>
						<option value="13:00" {if $smarty.get.time_end=="13:00"}selected{/if}>13:00</option>
						<option value="14:00" {if $smarty.get.time_end=="14:00"}selected{/if}>14:00</option>
						<option value="15:00" {if $smarty.get.time_end=="15:00"}selected{/if}>15:00</option>
						<option value="16:00" {if $smarty.get.time_end=="16:00"}selected{/if}>16:00</option>
						<option value="17:00" {if $smarty.get.time_end=="17:00"}selected{/if}>17:00</option>
						<option value="18:00" {if $smarty.get.time_end=="18:00"}selected{/if}>18:00</option>
						<option value="19:00" {if $smarty.get.time_end=="19:00"}selected{/if}>19:00</option>
						<option value="20:00" {if $smarty.get.time_end=="20:00"}selected{/if}>20:00</option>
						<option value="21:00" {if $smarty.get.time_end=="21:00"}selected{/if}>21:00</option>
						<option value="22:00" {if $smarty.get.time_end=="22:00"}selected{/if}>22:00</option>
						<option value="23:00" {if $smarty.get.time_end=="23:00"}selected{/if}>23:00</option>
					</select>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="bottom">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-left: 10px; width: 60px;">Событие:&nbsp;&nbsp;</td>
				<td width="100%">
					<select name="eid" id="eid" class="txt" style="width: 98%;">
						<option value="0">все</option>
						{foreach from=$res.events item=event}
							<option value="{$event.id}"{if $smarty.get.eid && $event.id==$smarty.get.eid} selected{/if}>{$event.title}</option>
						{/foreach}
					</select>
				</td>
			<td width="100"><input type="submit" value="Найти" class="txt2" style="width:80px" /></td>
			</tr>
			</table>
		</td>
	</tr>
</table>

</form>
<br/>