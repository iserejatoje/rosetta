{$page.header}<br>
<form method="POST">
<input type="hidden" name="action" value="move_theme">
{foreach from=$page.ids item=l}
<input type="hidden" name="ids[]" value="{$l}">
{/foreach}
<table width="100%">
	<tr>
		<td align="center">
			Выберите раздел:<br>
			<select name="section_to">
			{foreach from=$page.sections item=l}
				{if $l.data.visible == 1}
				<option value="{$l.id}" {if $sectionid==$l.id} selected="selected"{/if}>{$l.data.title|indent:$l.offset:"   "}</option>
				{/if}
			{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">
			<input type="submit" value="Подтвердить">
		</td>
	</tr>
</table>
</form>