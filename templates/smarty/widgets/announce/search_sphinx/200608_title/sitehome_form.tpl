<span style="color:#03424A;"><b>Поиск по справочнику:</b></span>
<form enctype="application/x-www-form-urlencoded" target="_blank" method="get" 
				action="{$res.path}/search/search.php" 
				onsubmit="if (this.text.value == '') {literal}{ alert('Введите запрос для поиска.'); return false; }{/literal} return true;">
				<input type="hidden" name="action" value="search" />
				<input type="hidden" name="a_c" value="{$res.a_c}" />
				<input type="hidden" name="a_t" value="{$res.type_search}" />
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr valign="middle" align="left">
			<td>
				<input type="text" name="text" value="" style="font-size:12px; width:100%;" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<input type="submit" value="Искать" style="font-size:12px; width:40%;" />
			</td>
		</tr>
	</table>
</form>

<div style="text-align:right">
<small><a target="_blank" href="/firms/my/add/" class="redtext">Добавить компанию</a></small>
</div>
