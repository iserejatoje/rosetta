<style>
{literal}
.inp {
	width:100%;
}
.red {
	color:#FF0000;
}
{/literal}
</style>
<form method="post">
<input type="hidden" name="action" value="add_to_passport">
<table width="100%" border="1">
{foreach from=$list item=l}
	<tr valign="top">
		<td width="100">
			<input type="radio" name="user[{$l.UserID}][action]" value="1" id="o{$l.UserID}" checked><label for="o{$l.UserID}"> Сохранить</label><br>
			<input type="radio" name="user[{$l.UserID}][action]" value="2" id="d{$l.UserID}"><label for="d{$l.UserID}"> Удалить</label>
		</td>
		<td>
<div>{if $l.InPassport == 0}<span style="color:green;">Пользователя <b>нет</b> в Паспорте{else}<span style="color:red;">Пользователь <b>есть</b> в Паспорте{/if}</span></div>
<table border="0" width="100%">
{if $errors[$l.UserID]}
	<tr>
		<td colspan="4" align="center"><b style="color:red;">
		{foreach from=$errors[$l.UserID] item=z}
		{$z}<br>
		{/foreach}
		</b></td>
	</tr>
{/if}
	<tr>
		<td width="100" bgcolor="#F0F0F0">ФИО</td>
		<td><input type="text" name="user[{$l.UserID}][LastName]" value="{$l.LastName}" class="inp"></td>
		<td><input type="text" name="user[{$l.UserID}][FirstName]" value="{$l.FirstName}" class="inp"></td>
		<td><input type="text" name="user[{$l.UserID}][MidName]" value="{$l.MidName}" class="inp"></td>
	</tr>
</table>
<table border="0" width="100%">
	<tr>
		<td width="100" bgcolor="#F0F0F0">E-mail</td>
		<td><input type="text" name="user[{$l.UserID}][Email]" value="{$l.Email}" class="inp" disabled></td>
		<td width="100" bgcolor="#F0F0F0">ICQ</td>
		<td><input type="text" name="user[{$l.UserID}][ICQ]" value="{$l.ICQ}" class="inp"></td>
	</tr>
</table>
<table border="0" width="100%">
	<tr>
		<td width="100" bgcolor="#F0F0F0">Регион</td>
		<td width="100"><select name="user[{$l.UserID}][Region]">
		{foreach from=$region_list item=k key=key}
			<option value="{$key}"{if $l.Region == $key} selected{/if}>{$k}</option>
		{/foreach}
		</select></td>
		<td width="100" bgcolor="#F0F0F0">Должность</td>
		<td><input type="text" name="user[{$l.UserID}][Position]" value="{$l.Position}" class="inp"></td>
	</tr>
</table>
<table border="0" width="100%">
	<tr>
		<td width="100" bgcolor="#F0F0F0">Группы</td>
		<td>
			<table border="0">
				<tr valign="top">
					<td>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="354" id="k1{$l.UserID}" checked><label for="k1{$l.UserID}"> Компания</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="360" id="k3{$l.UserID}"><label for="k3{$l.UserID}"> Компания: Дирекция</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="358" id="k4{$l.UserID}"><label for="k4{$l.UserID}"> Компания: Менеджеры</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="359" id="k5{$l.UserID}"><label for="k5{$l.UserID}"> Компания: Персонал</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="355" id="k2{$l.UserID}"><label for="k2{$l.UserID}"> Компания: Администраторы</label>
					</td>
					<td>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="356" id="k6{$l.UserID}"><label for="k6{$l.UserID}"> Компания: Дизайнеры</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="34" id="k7{$l.UserID}"><label for="k7{$l.UserID}"> Компания: Модераторы</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="104" id="k8{$l.UserID}"><label for="k8{$l.UserID}"> Компания: Программисты</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="103" id="k9{$l.UserID}"><label for="k9{$l.UserID}"> Компания: Тестировщики</label>
					</td>
					<td>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="368" id="k10{$l.UserID}"><label for="k10{$l.UserID}"> Компания: RUгион</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="362" id="k11{$l.UserID}"{if $l.Region == 102} checked{/if}><label for="k11{$l.UserID}"> Компания: Регион 02</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="363" id="k12{$l.UserID}"{if $l.Region == 16} checked{/if}><label for="k12{$l.UserID}"> Компания: Регион 16</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="364" id="k13{$l.UserID}"{if $l.Region == 34} checked{/if}><label for="k13{$l.UserID}"> Компания: Регион 34</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="365" id="k14{$l.UserID}"{if $l.Region == 59} checked{/if}><label for="k14{$l.UserID}"> Компания: Регион 59</label>
					</td>
					<td>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="369" id="k15{$l.UserID}"{if $l.Region == 61} checked{/if}><label for="k15{$l.UserID}"> Компания: Регион 61</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="363" id="k16{$l.UserID}"{if $l.Region == 63} checked{/if}><label for="k16{$l.UserID}"> Компания: Регион 63</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="367" id="k17{$l.UserID}"{if $l.Region == 72} checked{/if}><label for="k17{$l.UserID}"> Компания: Регион 72</label><br>
						<input type="checkbox" name="user[{$l.UserID}][group][]" value="361" id="k18{$l.UserID}"{if $l.Region == 74} checked{/if}><label for="k18{$l.UserID}"> Компания: Регион 74</label>
					</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
		</td>
	</tr>
{/foreach}
</table>
<br><br>
<center><input type="submit" value="Применить" /></center>
</form>