<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" bgcolor="#E9EFEF" style="padding:3px;padding-left:8px;">
			<font class="t1">{$BLOCK.title}</font>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align=left>Всего объявлений: {$BLOCK.res.count|number_format:0:".":" "}</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="100%">
		{if is_array($BLOCK.res.list) && sizeof($BLOCK.res.list)}
			<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" bgcolor=#FFFFFF>
				<tr align=center valign=middle bgcolor="#E9EFEF">
					<th width=80 class="t1">Рубрика:</th>
					<th width=180 class="t1">Тип недвижимости:</th>
					<th class="t1">Адрес:</th>
					<th width=70>&nbsp;</th>
				</tr>
				{foreach from=$BLOCK.res.list item=row key=key}
				<tr bgcolor="{if $key % 2}#FFFFFF{else}#F3F8F8{/if}" align=left>
					<td align="center">{if $row.rub}{$row.rub}{else}-{/if}</td>
					<td align="center">{if $row.object}{$row.object}{else}-{/if}</td>
					<td align="center">{if $row.address}{$row.address}{else}-{/if}</td>
					<td align=center><a href="/{$BLOCK.section}/edit.html?id={$row.id}">изменить</a></td>
				</tr>
				{/foreach}
			</table>
		{/if}
		</td>		
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td nowrap="nowrap"><img src="/img/design/bullet.gif" width=7 height=7 border=0 alt="" />&nbsp;</td>
		<td nowrap="nowrap"><a href="/{$BLOCK.section}/add.html">Добавить объявлениие</a>&nbsp;&nbsp;</td>
		{if is_array($BLOCK.res.list) && sizeof($BLOCK.res.list)}
		<td nowrap="nowrap"><img src="/img/design/bullet.gif" width=7 height=7 border=0 alt="" />&nbsp;</td>
		<td nowrap="nowrap"><a href="/{$BLOCK.res.section}/{$ENV.section}.html">Полный список</a>&nbsp;&nbsp;</td>
		{/if}
		<td nowrap="nowrap"><img src="/img/design/bullet.gif" width=7 height=7 border=0 alt="" />&nbsp;</td>
		<td nowrap="nowrap"><a href="/{$BLOCK.res.section}/{$ENV.section}/favorites.php" class="ssyl">Избранное {$BLOCK.res.count_favorites|number_format:0:".":" "}</a>&nbsp;&nbsp;</td>
		<td width="100%"></td>
	</tr>
</table>
<br /><br />