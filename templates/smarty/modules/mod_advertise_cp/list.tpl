<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			Здравствуйте: {$page.user.email}
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
        {if isset($BLOCKS.mod_advertise_control_panel_blocks) && is_array($BLOCKS.mod_advertise_control_panel_blocks)}
                {foreach from=$BLOCKS.mod_advertise_control_panel_blocks item=block}
        <tr>
                <td>
                        {$block}
                </td>
        </tr>
        <tr>
                <td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
        </tr>
                {/foreach}
        {/if}
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr>
		<td colspan="5" align="left" bgcolor="#E9EFEF" style="padding:3px;padding-left:8px;"><font class="t1">Настройки</font></td>
	</tr>
	<tr>
		<td align="left" colspan="5">
			Последний вход: {"d.m.Y H:i:s"|date:$page.user.date_login}<br /><br />
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap"><img src="/img/design/bullet.gif" width=7 height=7 border=0 alt="" />&nbsp;</td>
		<td nowrap="nowrap"><a href="/{$ENV.section}/options.html">Изменить персональные данные</a>&nbsp;&nbsp;</td>
		<td nowrap="nowrap"><img src="/img/design/bullet.gif" width=7 height=7 border=0 alt="" />&nbsp;</td>
		<td nowrap="nowrap"><a href="/{$ENV.section}/logout.html">Выход</a>&nbsp;&nbsp;</td>
		<td width="100%"></td>
	</tr>
</table>

