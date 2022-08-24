<table style="background-color: rgb(212, 231, 235);" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td bgcolor="#88c3c9" width="5"><img src="/_img/x.gif" width="5" height="1"></td>
<td>
	<table border="0" cellpadding="3" cellspacing="0" width="100%">
	<tr>

		<td style="margin-bottom: 2px;"><a href="/service/go/?url={"`$res.url`"|escape:"url"}" target="_blank" class="a12b">Продажа:</a></td>
	</tr>
		<tr>
		<td class="t11"><a href="/service/go/?url={"`$res.url`list_status/4/1.php"|escape:"url"}" target="_blank" class="t12">Залоговое имущество</a> (<b><nobr>{$res.status_count[4]}</nobr></b>)</td>
	</tr>
		<tr>

		<td class="t11"><a href="/service/go/?url={"`$res.url`list_status/5/1.php"|escape:"url"}" target="_blank" class="t12">Арестованное имущество</a> (<b><nobr>{$res.status_count[5]}</nobr></b>)</td>
	</tr>
	</table>
</td>
</tr>
</tbody></table>
