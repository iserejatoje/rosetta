<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<style>
{literal}
.inp {
	width:100%;
}
{/literal}
</style>
<form id="cancel">
{$SECTION_ID_FORM}
</form>
<form method="post">
<input type="hidden" name="action" value="{$action}">
<table border="0" width="100%">
	<tr>
		<td width="100" bgcolor="#F0F0F0">Фамилия</td>
		<td><input type="text" name="LastName" value="{$list.LastName}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Имя</td>
		<td><input type="text" name="FirstName" value="{$list.FirstName}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Отчество</td>
		<td><input type="text" name="MidName" value="{$list.MidName}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">E-mail</td>
		<td><input type="text" name="Email" value="{$list.Email}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">ICQ</td>
		<td><input type="text" name="ICQ" value="{$list.ICQ}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Регион</td>
		<td><select name="Region" style="width:100px;">
		{foreach from=$region_list item=l}
			<option value="{$l}"{if $list.Region == $l} selected{/if}>{$l}</option>
		{/foreach}
		</select></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Должность</td>
		<td><input type="text" name="Position" value="{$list.Position}" class="inp"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Группы</td>
		<td><select multiple size="5" name="groups[]" class="inp">
		{foreach from=$groups item=l}
		<option value="{$l.GroupID}">{$l.Name}</option>		
		{/foreach}
		</select></td>
	</tr>
</table>
<center><input type="submit" value="Сохранить" /> <input type="reset" value="Очистить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>