<script type="text/javascript" language="javascript">
{literal}
<!--
function _search_submit(frm)
{
	if(!frm.query || frm.query.value == ""){
		alert('Введите запрос для поиска.');
		return false;
	}

	return true;
}
-->
{/literal}
</script>

<table border=0 cellpadding="0" cellspacing="3" width=100%>
	<tr>
		<td align="left" class="block_title_obl" style="padding-left: 15px;"><span>Поиск на сайте</span></td>
	</tr> 
</table>

<table width="100%" border="0" cellspacing="3" cellpadding="2">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td>
	</tr>
	<tr>
		<td>
			<form name="frm_search" enctype="application/x-www-form-urlencoded" 
			target="_blank" method="get" action="http://www.{$ENV.site.domain}/{$ENV.section}/search.php" 
			onsubmit="return _search_submit(this);">
			<input type="hidden" name="a_c" value="{$res.form.a_c}" />
			<input type="hidden" name="where" value="{$res.form.where}" />
			<input type="hidden" name="sortby" value="{$res.form.sortby}" />
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr valign="middle" align="center">
					<td>
						<input type="text" name="query" value="" style="width:55%;" />&nbsp;<input type="submit" value="Искать" />
					</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
</table>