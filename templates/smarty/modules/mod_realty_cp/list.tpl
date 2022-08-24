<table width="100%" cellpadding="0" cellspacing="0" class="table2">
	<tr>
		<td>
			Здравствуйте: {$USER->Profile.general.ShowName}
		</td>
		<td align="right">
			Последний вход: {$USER->Visited|date_format:"%d.%m.%Y %T"}<br /><br />
			{if is_array($page.stats)}
				Сегодня размещено или продлено <b>{$page.stats[1]}</b> из <b>{$page.stats[0].limit}</b> объявлений
			{/if}
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
	{if isset($BLOCKS.mod_advertise_control_panel_blocks) && is_array($BLOCKS.mod_advertise_control_panel_blocks)}
		{foreach from=$BLOCKS.mod_advertise_control_panel_blocks item=block}
	<tr>
		<td colspan="2">
			{$block}
		</td>
	</tr>
		{/foreach}
	{/if}
</table>
<table width="100%" cellspacing="0" border="0" class="table2">
	<tr>
		<td colspan="5" class="bg_color2"><b>Настройки<b></td>
	</tr>
	<tr>
		<td nowrap="nowrap"><a href="/{$ENV.section}/options.html">Изменить персональные данные</a>&nbsp;&nbsp;</td>
		<td nowrap="nowrap"></td>
		<td nowrap="nowrap"></td>
		<td width="100%"></td>
	</tr>
</table>
<br/>

