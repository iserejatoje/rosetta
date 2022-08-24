<form method="GET">
<table width="500" align="center" cellpadding="2" cellspacing="0">
{if !empty($ERROR.code)}<tr><td width="130">&nbsp;</td><td><span class="ferror">{$ERROR.code}</span></td></tr>{/if}
<tr><td width="130" align="right" class="fheader_text">Код активации</td><td width="370"><input type="text" name="code" style="width:366px" value="{$code}"></td></tr> 
<tr><td class="fbreakline">&nbsp;</td><td class="fbreakline"><input type="submit" value="Активировать"></td></tr>
</table>
</form>