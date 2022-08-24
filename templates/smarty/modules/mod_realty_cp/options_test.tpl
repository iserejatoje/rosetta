<table width="100%" cellspacing="0" class="table2">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td>
<a href="/{$ENV.section}/">Вернуться в личный кабинет</a>
</td></tr></table>

                <br/><br/>
		<form name="frm" method="post">
		<input type="hidden" name="action" value="options" />
		<table align="center" cellspacing="1" class="table2">
		<tr>
			<th colspan="2">Персональные данные</td>
		</tr>
		<tr>
			<td class="bg_color2" align="right">ФИО:</td>
			<td width="200" class="bg_color4"><input type="text" name="name" style="width:200px" value="{if $ENV._POST.action == 'options'}{$ENV._POST.name|htmlspecialchars}{else}{$page.user.name|htmlspecialchars}{/if}"></td>
		</tr>
		<tr>
			<td class="bg_color2" align="right">Организация:</td>
			<td width="200" class="bg_color4"><input type="text" name="firm" style="width:200px" value="{if $ENV._POST.action == 'options'}{$ENV._POST.firm|htmlspecialchars}{else}{$page.user.firm|htmlspecialchars}{/if}"></td>
		</tr>
		<tr>
			<td class="bg_color2" align="right">Информация об организации:</td>
			<td width="200" class="bg_color4"><textarea name="about" style="width:200px;height:80px;">{if $ENV._POST.action == 'options'}{$ENV._POST.about|strip_tags}{else}{$page.user.about|strip_tags}{/if}</textarea></td>
		</tr>
		<tr>
			<td class="bg_color2" align="right">E-mail:</td>
			<td width="200" class="bg_color4"><input type="text" name="email" style="width:200px" value="{if $ENV._POST.action == 'options'}{$ENV._POST.email|htmlspecialchars}{else}{$page.user.email|htmlspecialchars}{/if}"></td>
		</tr>
		<tr>
			<td class="bg_color2" align="right">Контакты:</td>
			<td width="200"  class="bg_color4"><textarea name="contacts" style="width:200px;height:80px;">{if $ENV._POST.action == 'options'}{$ENV._POST.contacts|strip_tags}{else}{$page.user.contacts|strip_tags}{/if}</textarea></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input class="button" type="submit" value="Сохранить" style="width:100px;">&nbsp;&nbsp;
			<input class="button" type="reset" value="Очистить" style="width:100px;">
			</td>
		</tr>
		</form>
		</table>
