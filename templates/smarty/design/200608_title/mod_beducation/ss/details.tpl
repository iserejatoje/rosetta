
<!-- begin content -->
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="3">
	<tr>		
		{if !empty($res.logotype)}<td width="1" align="left"><img src="{$res.logotype}"></td>{else}
		{/if}
		<td align="left"><font class="title">{$res.name}</font></td>
	</tr>
</table>
<br>
<table width="100%"  border="0" cellspacing="2" cellpadding="3">
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Компания</strong></td>
		<td bgcolor="#f5f9fa">{$res.company}<br></td>
	</tr>
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Дата</strong></td>
		<td bgcolor="#f5f9fa"><strong>
		{if $res.begin|date_format:"%m"==$res.end|date_format:"%m"}
		{if $res.begin|date_format:"%e"!=$res.end|date_format:"%e"}{$res.begin|date_format:"%e"|replace:" ":""}-{/if}{$res.end|date_format:"%e"|replace:" ":""} {$res.begin|month_to_string:2}
		{else}
		{$res.begin|date_format:"%e"} {$res.begin|month_to_string:2} {if $res.begin|date_format:"%y"!=$res.end|date_format:"%y"}{$res.begin|date_format:"%Y"} {/if} - {$res.end|date_format:"%e"|replace:" ":""} {$res.end|month_to_string:2} {if $res.begin|date_format:"%y"!=$res.end|date_format:"%y"}{$res.end|date_format:"%Y"} {/if}
		{/if}
		</strong><br></td>
	</tr>
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Программа</strong></td>
		<td bgcolor="#f5f9fa">{$res.programm}<br></td>
	</tr>
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Автор</strong></td>
		<td bgcolor="#f5f9fa">{$res.author}<br></td>
	</tr>
	{if $res.conditions!=""}
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Условия</strong></td>
		<td bgcolor="#f5f9fa">{$res.conditions|mailto_crypt}<br></td>
	</tr>
	{/if}
	{if $res.tel}
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Телефон</strong></td>
		<td bgcolor="#f5f9fa">{$res.tel}<br></td>
	</tr>
	{/if}
	{if $res.email!=""}
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Электронная почта</strong></td>
		<td bgcolor="#f5f9fa">{if !empty($res.email)}{$res.email|mailto_crypt}{/if}<br></td>
	</tr>
	{/if}
	{if $res.contact!=""}
	<tr>
		<td width="120" align="right" valign="top" class="block_title2"><strong>Контактное лицо</strong></td>
		<td bgcolor="#f5f9fa">{$res.contact}<br></td>
	</tr>
	{/if}
	{if $res.url!=""}
	<tr>
		<td align="right" valign="top" class="block_title2"><strong>Сайт компании</strong></td>
		<td bgcolor="#f5f9fa">{if !empty($res.url)}<a href="http://{$res.url|replace:"http://":""}" target="_blank">{$res.url}</a>{/if}<br></td>
	</tr>
	{/if}
</table>
<!-- end content -->
