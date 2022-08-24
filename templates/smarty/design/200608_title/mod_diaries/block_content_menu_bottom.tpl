<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="22">&nbsp;</td>
		<td><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.last.string}" id="gl">Главная</a>&nbsp;&nbsp;&nbsp;&nbsp;
		{if $USER->isAuth()}
		<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.journals_record.string}?id={$USER->ID}" id="gl">Мой дневник</a>&nbsp;&nbsp;&nbsp;&nbsp;
		{/if}
		<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.policy.string}" id="gl"><font color=red>Правила</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>