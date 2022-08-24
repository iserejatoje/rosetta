<div class="block_title">
	<span>{$res.title}</span>
</div>

<div style="padding: 3px;">
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr valign="middle" align="center">
			<td>
				<form enctype="application/x-www-form-urlencoded" target="_blank" method="get" 
				action="{$res.path}/search/search.php" 
				onsubmit="if (this.text.value == '') {literal}{ alert('Введите запрос для поиска.'); return false; }{/literal} return true;">
				<input type="hidden" name="action" value="search" />
				<input type="hidden" name="a_c" value="{$res.a_c}" />
				<input type="hidden" name="a_t" value="{$res.type_search}" />
				<input type="text" name="text" value="" style="font-size:12px; width:60%;" />
				&nbsp;
				<input type="submit" value="Искать" style="font-size:12px; width:30%;" />
				</form>
			</td>
		</tr>
	</table>
</div>
