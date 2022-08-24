<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="announce_blog" />
<div class="title" style="padding: 5px;">Мои дневники</div>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="blogfavorites" id="blogfavorites" value="1"{if $page.form.blogfavorites} checked="checked"{/if} /> <label for="blogfavorites">Показывать избранные дневники</label></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>