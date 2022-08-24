<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<form id="cancel">
<input type="hidden" name="action" value="groups" />
{$SECTION_ID_FORM}
</form>
<form method="post">
{$SECTION_ID_FORM}
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="id" value="{$id}" />
<table width="100%" cellspacing="1">
<tr><td bgcolor="#F0F0F0"></td><td width="100%"><input type="checkbox" name="visible" value="1"{if $visible==1} checked{/if}> Показывать статью</td></tr>
<tr><td bgcolor="#F0F0F0">Название</td><td width="100%"><input type="text" name="name" value="{$name}" class="input_100"></td></tr>
<tr><td bgcolor="#F0F0F0">Название (короткое)</td><td width="100%"><input type="text" name="modname" value="{$modname}" class="input_100" style="width:50%"> ( буквы a-z, цифры 0-9 и знаки - _ )</td></tr>
</table>
<center><input type="submit" value="Сохранить" /> <input type="reset" value="Очистить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>