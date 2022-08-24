<div class="title2_news">Моя организация</div>
<br/>

{if isset($UERROR->ERRORS.saved)}
<div style="align:center; color:red">{$UERROR->ERRORS.saved}</div>
{/if}

<form method="POST">
<input type="hidden" name="action" value="firm" />
<input type="hidden" name="url" value="{$page.form.url}" />
<table cellspacing="2" cellpadding="0" border="0" class="table2" align="center">
<tr class="bg_color2">
	<td class="menu" align="right">Наименование организации<span style="color:red">*</span></th>
	<td><input type="text" name="Name" style="width:400px;" value="{$page.form.firm.Name|escape:'html'}" /></td>
</tr>
{if isset($UERROR->ERRORS.name)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td style="color:red"><span>{$UERROR->ERRORS.name}</span></td>
</tr>
{/if}
<tr class="bg_color2">
	<td class="menu" align="right" valign="top">Контакты<span style="color:red">*</span></th>
	<td><textarea name="Contacts" style="width:400px;height:200px;" />{$page.form.firm.Contacts|escape:'html'}</textarea></td>
</tr>
{if isset($UERROR->ERRORS.contacts)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td style="color:red"><span>{$UERROR->ERRORS.contacts}</span></td>
</tr>
{/if}

<tr class="bg_color2">
	<td colspan="2" align="center">
		<input type="submit" value="Сохранить" />
	</td>
</tr>
</table>
</form>