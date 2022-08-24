<table width="100%" cellspacing="2" cellpadding="0" border="0">
<tr>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" class="t12">
			<tr><td align="left" style="padding: 1px 10px;" class="t13_grey2">Резюме</td></tr>
			<tr><td height="1" bgcolor="#666666" align="left"><img width="1" height="1" border="0" src="/_img/x.gif" /></td></tr>
		</table>
	</td>
	</tr>
	<tr>
		<td valign="top">
		<table width="100%" cellspacing="6" cellpadding="0" border="0">
		{foreach from=$res item=l}
		<tr valign="top">
			<td width="1" class="t11">{$l.date}  </td>
			<td><a class="t11" href="/{$ENV.section}/resume/{$l.resid}.html" {if $l.imp}style="color:red"{/if}>{$l.dolgnost}</a> - <font class="t11"><b>{$l.paysum}</b> руб.</font></td>
		</tr>
		{/foreach}
		</table>						
		</td>
	</tr>
</table>
