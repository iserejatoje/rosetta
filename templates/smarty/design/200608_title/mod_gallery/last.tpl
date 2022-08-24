<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="block_left">
<tr align="right"><th><span><a href="/gallery/" style="color:white">Фотогалерея</a></span></th></tr>
</table>
		<table  width="224" valign="top" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center" style="padding-top: 5px;">
				<a href="/{$BLOCK.section}/view/photo/{$BLOCK.photo.id}.html" title="Последнее фото">
				{if !empty($BLOCK.photo.path_small)} 
					<img src="{$BLOCK.photo.path_small}" {$BLOCK.photo.image_size} alt="Фото" border="0"  style="border:#005A52 solid 1px" /> 
				{else} <img	src="/_img/design/200608_title/none.jpg" alt="Нет фото"  border="0"  style="border:#005A52 solid 1px"/> {/if}
				</a>
				</td>
			</tr>
			<tr>
				<td align="center"><font class="t5gb"><strong>{$BLOCK.photo.name}</strong></font><br>
				<font class="t7">Автор: {$BLOCK.photo.login}<br/>
				Добавлено: {"d.m.Y H:i"|date:$BLOCK.photo.date_create}</font></td>
			</tr>

		</table>