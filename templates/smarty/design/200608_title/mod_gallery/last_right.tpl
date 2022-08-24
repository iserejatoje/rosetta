<table width="100%"  border="0" cellspacing="3" cellpadding="0" class="block_right">
<tr align="left"><th><span><a href="http://{$ENV.site.domain}/gallery/" {if $CURRENT_ENV.site.domain != $ENV.site.domain }target="_blank" {/if}style="color:white">Фотогалерея</a></span></th></tr>
</table>
		<table  width="224" valign="top" border="0" cellspacing="3" cellpadding="0">
			<tr>
				<td align="center" style="padding-top: 5px;">
				<a href="http://{$ENV.site.domain}/{$BLOCK.section}/view/photo/{$BLOCK.photo.id}.html" {if $CURRENT_ENV.site.domain != $ENV.site.domain }target="_blank" {/if}title="Последнее фото">
				{if !empty($BLOCK.photo.path_small)} 
					<img src="{$BLOCK.photo.path_small}" {$BLOCK.photo.image_size} alt="Фото" border="0"  style="border:#005A52 solid 1px" /> 
				{else} <img	src="/img/none.jpg" alt="Нет фото"  border="0"  style="border:#005A52 solid 1px"/> {/if}
				</a>
				</td>
			</tr>
			<tr>
				<td align="center"><font class="t5gb"><strong>{$BLOCK.photo.name}</strong></font><br>
				<font class="t7">Автор: {$BLOCK.photo.login}<br/>
				Добавлено: {"d.m.Y H:i"|date:$BLOCK.photo.date_create}</font></td>
			</tr>
			<tr><td class="otzyv" align="right"><a href="http://{$ENV.site.domain}/gallery/photo/add.html" {if $CURRENT_ENV.site.domain != $ENV.site.domain }target="_blank" {/if}><font color="red">Добавить фото</font></a></td></tr>
		</table>