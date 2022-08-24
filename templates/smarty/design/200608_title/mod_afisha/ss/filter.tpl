<form name="filterpub" metod="get">
<input type="hidden" name="cmd" value="list">
<input type="hidden" name="type" value="{$smarty.get.type}">

<table width="100%" border="0" cellspacing="5" cellpadding="0" bgcolor="#e0f3f3">
	<tr>
		<td style="padding-left:3px; padding-right:3px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td class="block_title2"><span>Поиск события</span></td></tr>
			<tr><td colspan="3" bgcolor="#005a52"><img src="/_img/x.gif" width="1" height="3" alt="" /></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="padding-left:3px; padding-right:3px">
			<table {if $smarty.foreach.pub.total>=3}width="100%" {/if}border="0" cellspacing="0" cellpadding="0">
				{foreach from=$page.data.pub item=p key=k name=pub}
					{if $smarty.foreach.pub.iteration%3==1 || $smarty.foreach.pub.total<3}
						<tr>
					{/if}
					<td valign="top">
						<input type="checkbox" name="id_pub[{$k}]" id="id_pub[{$k}]" style="margin-left:0px" value="1"{if $p.selected || (!$smarty.get.id_pub)} checked{/if}>
					</td>
					<td {if $smarty.foreach.pub.total>=3}width="33%" {/if}valign="top">
						<label for="id_pub[{$k}]">&nbsp;{$p.name}</label><br>
					</td>
					{if $smarty.foreach.pub.iteration%3==0 || $smarty.foreach.pub.total<3}
						</tr>
					{/if}
				{/foreach}
			</table>
		</td>
	</tr>
	<tr>
		<td class="zag3" valign="top" style="padding-left:3px; padding-right:3px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;&nbsp;Дата:&nbsp;&nbsp;</td>
				<td>
					<select name="range" id="range" class="txt" style="width: 110px;">
						<option value="">все</option>
						<option value="today" {if $smarty.get.range=="today"}selected{/if}>сегодня</option>
						<option value="today_and_tomorrow" {if $smarty.get.range=="today_and_tomorrow"}selected{/if}>сегодня-завтра</option>
						<option value="tomorrow" {if $smarty.get.range=="tomorrow"}selected{/if}>завтра</option>
						<option value="week" {if $smarty.get.range=="week"}selected{/if}>на этой неделе</option>
					</select>
				</td>
				<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
				<td style="padding-left: 50px">Событие:&nbsp;&nbsp;</td>
				<td width="100%">
					<select name="id" id="id" class="txt" style="width: 100%;">
						<option value="0">все</option>
						{*foreach from=$page.data.categories item=category}
							{foreach from=$category.events item=event}
								<option value="{$event.id}"{if $event.selected} selected{/if}>{$event.name}</option>
							{/foreach}
						{/foreach*}
						{foreach from=$page.data.event_list item=event}
							<option value="{$event.id}"{if $event.selected} selected{/if}>{$event.name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" valign="bottom">
			<input type="submit" value="Найти" class="txt2" style="width:80px" />
		</td>
	</tr>
</table>

</form>
<br/>