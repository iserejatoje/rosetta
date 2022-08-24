<table cellpadding="3" cellspacing="0" border="0" width="100%">
	<tr>
		<td bgcolor="#D1E6F0" class=title style="white-space: nowrap"><EM><IMG 
	            src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</EM>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
		<td valign="top" align="center" style="padding-right:2px;">
			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr valign="middle" align="center">
					<td>
						<form enctype="application/x-www-form-urlencoded" target="_blank" method="get" 
						action="http://74.ru/search/search.php" 
						onsubmit="if (this.text.value == "") {literal}{ alert('Введите запрос для поиска.'); return false; }{/literal} return true;">
						<input type="hidden" name="action" value="search" />
						<input type="hidden" name="a_c" value="{$res.a_c}" />
						<input type="text" name="text" value="" style="font-size:12px; width:60%;" />
						&nbsp;
						<input type="submit" value="Искать" style="font-size:12px; width:30%;" />
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
