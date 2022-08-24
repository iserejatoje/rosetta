{if count($res.list)}
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 1px;">
	<tr>
		<td class="block_title">
			<span>{$res.title}</span>
		</td>
	</tr>
</table>
<table width="100%" cellspacing="6" cellpadding="0" border="0">
{foreach from=$res.list item=l}
	<tr>
		<td align="right">
			<a href="{$res.title_url}offer/{$l.path}" target="_blank">{$l.data.name}</a>
		</td>
		<td align="right" nowrap="nowrap">
			<span class="t11_grey">({$l.count[0]|number_format:0:'.':' '})</span>
		</td>
	</tr>
{/foreach}
	<tr>
		<td align="right">
			<a href="{$res.title_url}add.html" class="a10" style="color:red" target="_blank">Добавить объявление</a>
		</td>
		<td></td>
	</tr>
</table>
{/if}
