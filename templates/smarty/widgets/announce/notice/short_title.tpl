{if sizeof($res) && sizeof($res.list)}
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #d4e7eb;">
<tr>
<td width="5" bgcolor="#88c3c9"><img src="/_img/x.gif" width="5" height="1" /></td>
<td>
	<table cellspacing="0" cellpadding="3" border="0" width="100%">
	<tr>
		<td style="margin-bottom:2px;"><a href="/service/go/?url={$res.title_url}" target="_blank" class="a12b">{$res.title}:</a></td>
	</tr>
	{foreach from=$res.list item=l}
	<tr>
		<td class="t11"><a href="/service/go/?url={$res.title_url}{$l.sale}/{$l.link}/" target="_blank" class="t12">{$l.name|truncate:30}</a> (<b><nobr>{$l.cnt|number_format:0:' ':' '}</nobr></b>)</td>
	</tr>
	{/foreach}
{*	<tr>
		<td class="t11" style="padding-top: 3px;"><a href="/service/go/?url={$res.title_url}add.html" target="_blank" class="t11">Добавить объявление</a></td>
	</tr>*}
	</table>
</td>
</tr>
</table>
{/if}