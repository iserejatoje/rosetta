<form method="POST">
<input type="hidden" name="action" value="block">
<input type="hidden" name="message_id" value="{$page.message_id}">
<table width="500" cellspacing="0" align="center">
{if !empty($page.data.ips)}
<tr>
	<td class="ftable_header">Блок</td>
	<td class="ftable_header">IP Адрес</td>
</tr>
{foreach from=$page.data.ips item=l}
<tr>
    <td align="center">
		<input type="hidden" name="ips[]" value="{$l.ip}">
		<input type="checkbox" name="block_ips[]" value="{$l.ip}"{if $l.blocked==true} checked="checked"{/if}>
	</td>
    <td><a href="https://www.nic.ru/whois/?ip={$l.ip}" target="_blank" title="посмотреть информацию на nic.ru">{$l.ip}</a></td>
</tr>
{if $l.blocked}
<tr>
	<td>&nbsp;</td>
	<td class="fsmall">{if $l.eternal==1}Неограниченная блокировка{else}Заблокировано до {$l.still|date_format:"%d.%m.%Y"}{/if}<br>
    	<b>Комментарий:</b> {$l.comment}</td>
</tr>
{/if}
{/foreach}
{/if}
{if !empty($page.data.cookies)}
<tr>
	<td class="ftable_header">Блок</td>
	<td class="ftable_header">Cookie</td>
</tr>
{foreach from=$page.data.cookies item=l}
<tr>
    <td align="center">
		<input type="hidden" name="cookies[]" value="{$l.cookie}">
		<input type="checkbox" name="block_cookies[]" value="{$l.cookie}"{if $l.blocked==true} checked="checked"{/if}>
	</td>
    <td>{$l.cookie}</td>
</tr>
{if $l.blocked}
<tr>
	<td>&nbsp;</td>
	<td class="fsmall">{if $l.eternal==1}Неограниченная блокировка{else}Заблокировано до {$l.still|date_format:"%d.%m.%Y"}{/if}<br>
    	<b>Комментарий:</b> {$l.comment}</td>
</tr>
{/if}
{/foreach}
{/if}
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><textarea name="comment" style="width:99%;height:50px;"></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>На <input type="text" name="still" style="width:50px;"> дней<br>
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
	<td><a href="block_ip_list.php">Список заблокированных IP</a><br>
		<a href="block_cookie_list.php">Список заблокированных Cookie</a></td>
</tr>
</table>
</form>
