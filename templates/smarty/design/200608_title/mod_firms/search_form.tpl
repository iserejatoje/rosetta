{if $res.form.a_c}
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
<table border="0" cellpadding="0" cellspacing="3" width="100%">
<tr><td align="left" class="block_title_obl" style="padding-left: 15px;"><span>Поиск</span></td></tr> 
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="2">
<tr><td>
	<form name="frm_search" enctype="application/x-www-form-urlencoded" target="_blank" 
		method="get" action="http://www.{$ENV.site.domain}/{$ENV.section}/search.php" onsubmit="return _search_submit(this);">
		<input type="hidden" name="action" value="search" />
		<input type="hidden" name="a_c" value="{$res.form.a_c}" />
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="middle" align="center">
		<td>
			<input type="text" name="text" value="" style="width:55%;" />
			&nbsp;
			<input type="submit" value="Искать" />
		</td>
	</tr>
	</table>
	</form>
</td></tr>
</table>
{else}

<script type="text/javascript" language="javascript">
{literal}
<!--
function _search_submit(frm)
{
	if(frm.str.value == ""){
		alert('Введите запрос для поиска.');
		return false;
	}

	return true;
}
-->
{/literal}
</script>
<table border="0" cellpadding="0" cellspacing="3" width="100%">
<tr><td align="left" class="block_title_obl" style="padding-left: 15px;"><span>Поиск</span></td></tr> 
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="2">
<tr><td>
	<form name="frm_search" enctype="application/x-www-form-urlencoded" method="get" action="/{$CURRENT_ENV.section}/search.html" onsubmit="return _search_submit(this);">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="middle" align="center">
		<td>
			<input type="text" name="str" value="" style="width:55%;" />
			&nbsp;
			<input type="submit" value="Искать" />
		</td>
	</tr>
	</table>
	</form>
</td></tr>
</table>

{/if}