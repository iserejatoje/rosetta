<form method="POST">
<input type="hidden" name="_action" value="_block.html">
<input type="hidden" name="message_id" value="{$message_id}">
<table width="500" cellspacing="0" align="center">
{if !empty($ip) || !empty($ip_fw)}
<tr>
    <td width="16">&nbsp;</td>
    <td><b>IP:</b> <a href="https://www.nic.ru/whois/?ip={$ip}" target="_blank" title="посмотреть информацию на nic.ru">{$ip}</a>
    {if !empty($ip_fw)} <b>Forwarded IP:</b> {$ip_fw|regex_replace:"/\b((?:[0-9]+\.)+[0-9]+)\b/":"<a href=\"https://www.nic.ru/whois/?ip=\\1\" target=\"blank\">\\1</a>"}{/if}</td>
</tr>
<tr>
    <td width="16"><input type="checkbox" name="check_ip" value="1"{if $check_ip==true} checked="checked"{/if}></td>
    <td>Заблокировать этот IP</td>
</tr>
{if $check_ip==true}
<tr>
	<td>&nbsp;</td>
    <td class="fsmall">{if $b_ip.eternal==1}Неограниченная блокировка{else}Заблокировано до {$b_ip.still|date_format:"%d.%m.%Y"}{/if}<br>
    	<b>Комментарий:</b> {$b_ip.comment}</td>
</tr>
{/if} 
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
{/if}
{if !empty($cookie)}
<tr>
    <td width="16">&nbsp;</td>
    <td><b>Cookie:</b> {$cookie}</td>
</tr>
<tr>
    <td width="16"><input type="checkbox" name="check_cookie" value="1"{if $check_cookie==true} checked="checked"{/if}></td>
    <td>Заблокировать эту Cookie</td>
</tr>
{if $check_cookie==true}
<tr>
	<td>&nbsp;</td>
    <td class="fsmall">{if $b_cookie.eternal==1}Неограниченная блокировка{else}Заблокировано до {$b_cookie.still|date_format:"%d.%m.%Y"}{/if}<br>
    	<b>Комментарий:</b> {$b_cookie.comment}</td>
</tr>
{/if}
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
{/if}
<tr>
	<td>&nbsp;</td>
	<td>Комментарий</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><textarea name="comment" style="width:99%;height:50px;"></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>На <input type="text" name="len" style="width:50px;"> дней<br>
	<span style="fsmall">чтобы заблокировать на неогранниченый срок, оставте поле пустым</span></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" value="применить"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><a href="blocklist.html?mode=ip">Список заблокированных IP</a><br>
		<a href="blocklist.html?mode=cookie">Список заблокированных Cookie</a></td>
</tr>
</table>
</form>
