<div align="center">Добавить новую тему</div>
<form method="POST">
<input type="hidden" name="_action" value="_addtheme.html">
<input type="hidden" name="sec_id" value="{$section.id}">
<table width="100%">
<tr><td>Пользователь</td><td><input type="text" name="login"></td></tr>
<tr><td>Название темы</td><td><input type="text" name="name"></td></tr>
<tr><td colspan="2"><textarea name="message" style="width:70%;height:200px;"></textarea></td></tr>
<tr><td colspan="2"><input type="submit" value="Добавить" /></td></tr>
</table>
</form>