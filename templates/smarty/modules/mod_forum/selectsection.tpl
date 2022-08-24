<form method="POST">
<input type="hidden" name="_action" value="{$file}">
<input type="hidden" name="action" value="{$action}">
<input type="hidden" name="sectionid" value="{$sectionid}">
{foreach from=$ids item=l}
<input type="hidden" name="ids[]" value="{$l}">
{/foreach}
<table width="100%">
	<tr>
		<td align="center">
			Выберите раздел:<br>
			<select name="tosection">
			{foreach from=$sections item=l}
				<option value="{$l.id}" {if $sectionid==$l.id} selected="selected"{/if}>{$l.data|indent:$l.offset:"   "}</option>
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