<form method="POST">
<input type="hidden" name="_action" value="_remember.html">
<table width="500" align="center" cellpadding="2" cellspacing="0">
{if !empty($ERROR.email)}<tr><td width="160">&nbsp;</td><td><span class="ferror">{$ERROR.email}</span></td></tr>{/if}
<tr><td width="160" align="right" class="fheader_text">Введите ваш E-Mail</td><td width="340"><input type="text" name="email" style="width:336px" value="{$code}"></td></tr> 
<tr><td class="fbreakline">&nbsp;</td><td class="fbreakline"><input type="submit" value="Выслать пароль"></td></tr>
</table>
</form>