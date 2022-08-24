<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Адресная книга</span></td>
		</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="submenu"><a href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}"><span>Добавить адрес</span></a></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

{if count($page.error.err)>0}	
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
</table>
{/if}

{$page.list}


