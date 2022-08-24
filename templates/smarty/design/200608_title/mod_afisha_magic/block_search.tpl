<form name="filter" method="get" action="/{$ENV.section}/search.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: url(/img/design/green_search_bg.gif) repeat-x;">
<tr>
	<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
<tr>
	<td class="block_title_obl" align="left" style="padding-left: 10px;" colspan="2">
	<span>Поиск события</span>
	</td>
</tr>
	<tr bgcolor="#ffffff">
		<td height="2" colspan="2">
			<img height="6" width="1" src="/_img/x.gif"/>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px"><b>Дата</b></td>
		<td width="120" style="padding-right:10px">
			<select name="range" id="range" class="txt" style="width:100%">
				<option value="">все</option>
				<option value="today" {if $smarty.get.range=="today"}selected{/if}>сегодня</option>
				<option value="today_and_tomorrow" {if $smarty.get.range=="today_and_tomorrow"}selected{/if}>сегодня-завтра</option>
				<option value="tomorrow" {if $smarty.get.range=="tomorrow"}selected{/if}>завтра</option>
				<option value="weekend" {if $smarty.get.range=="weekend"}selected{/if}>на выходных</option>
				<option value="week" {if $smarty.get.range=="week"}selected{/if}>на этой неделе</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px"><b>Событие</b></td>
		<td width="120" style="padding-right:10px">
			<select name="eid" id="eid" class="txt" style="width:100%">
				<option value="0">все</option>
				{foreach from=$res.events item=event}
				<option value="{$event.id}"{if $smarty.get.eid && $event.id==$smarty.get.eid} selected{/if}>{$event.title}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" valign="bottom" colspan="2">
			<input type="submit" value="Найти" class="txt2" style="width:80px; margin:5px" />
		</td>
	</tr>
	<tr bgcolor="#ffffff">
		<td height="2" colspan="2">
			<img height="2" width="1" src="/_img/x.gif"/>
		</td>
	</tr>
</table>
</form>
