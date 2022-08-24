<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
<tr>
	<th><span>Активные участники</span></th>
</tr> 
</table>

<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">
	{excycle values=" ,bg_color4"}
	{foreach from=$res.list item=l}
	<tr valign=middle class="{excycle}">
		<td align="left" width="100%">
			<a href="/passport/info.php?id={$l.UserID}" target="_blank">{$l.details.FirstName} {$l.details.LastName}</a>
		</td>
		<td align="right">{$l.MessageCount|number_format:"0":".":" "}</td>
		
	</tr>
	{/foreach}
	<tr>
		<td height="10"></td>
	</tr>
</table>