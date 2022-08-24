<br/>
<!-- begin content -->
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font class="t5">{$res.firm.name}{if !empty($res.firm.io)} {$res.firm.io}{/if}</font>
		</td>
	</tr>
</table>
<br/><br/><br/>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td align="left">
			{if !empty($res.firm.employment)}{$res.firm.employment}<br/>{/if}
			{if !empty($res.firm.resume)}{$res.firm.resume|screen_href|mailto_crypt}{/if}
		</td>
	</tr>
</table>
<!-- end content -->
