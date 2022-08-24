<script type="text/javascript" language="javascript">
{literal}
<!--
function _search_submit(frm)
{
	if(frm.text.value == ""){
		alert('Введите запрос для поиска.');
		return false;
	}

	return true;
}
-->
{/literal}
</script>
<table border=0 cellpadding="0" cellspacing="3" width=100%>
<tr><td align="left" class="block_title_obl" style="padding-left: 15px;"><span>Поиск на сайте</span></td></tr> 
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="2">
<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
<tr><td>
	<form name="frm_search" enctype="application/x-www-form-urlencoded" target="_blank" method="get" action="http://{$CURRENT_ENV.site.domain}/search/search.php" onsubmit="return _search_submit(this);">
	<input type="hidden" name="action" value="search" />
	<input type="hidden" name="a_c" value="{$CURRENT_ENV.site.search_code}" />
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="middle" align="center">
		<td>
			<input type="text" name="text" value="" style="width:55%;" />
			&nbsp;
			<input type="submit" value="Искать" style="width:30%;" />
		</td>
	</tr>
	
	</table>
	</form>
</td></tr>
</table>