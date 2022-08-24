<div class="gallery-popup">

	<table class="path">
		<tr>
			<td>
				<a href="{$TITLE->Path[1].link}" class="top">{$TITLE->Path[1].name}</a><br/>
				<a href="{$TITLE->Path[2].link}">{$TITLE->Path[2].name}</a>
			</td>
		</tr>
	</table>

	<div class="t-line">
		<div class="content">
			Добавление фотографии
		</div>
	</div>

	<div class="list">
		<div>
			<form method="post" class="form_cell" enctype="multipart/form-data">
			<input type="hidden" name="album" value="{$page.album}" />
			<input type="hidden" name="action" value="{$page.action}" />
			<table cellspacing="2" cellpadding="3" border="0" align="center" width="550">
				{if isset($UERROR->ERRORS.photo)}
				<tr>
					<td align="right">&nbsp;</td>
					<td align="left" class="error"><span>{$UERROR->ERRORS.photo}</span></td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="150">Фотография <font color="red">*</font></td>
					<td class="bg_color4">
					{if $page.action == 'editphoto'}
					<a href="{$page.form.photo.url}" target="_blank" title="Нажмите чтобы увеличить"><img src="{$page.form.thumb.url}" width="{$page.form.thumb.w}" height="{$page.form.thumb.h}" border="0"></a><br><br>
					{else}
					<input type="file" name="photo" style="width:400px" />
					{/if}
						<span class="tip">Размер фотографии не должен превышать {$page.max_source_photo_size.size}Мб, разрешение фотографии должно быть не больше {$page.max_source_photo_size.width}x{$page.max_source_photo_size.height} пикселов. Вы можете загрузить файлы JPEG, GIF, PNG.</span></td></td>
				</tr>
				{if $page.action == 'editphoto'}
				<tr>
					<td class="bg_color2" align="right">Переместить в </td>
					<td class="bg_color4">
						<select name="AlbumID" style="width:400px">
						{if sizeof($page.form.albums) > 0}
							<option value="-1">-- выберите альбом --</option>
						{foreach from=$page.form.albums item=l}
							<option value="{$l.id}">{$l.name}</option>
						{/foreach}
						{/if}
						</select>
					</td>
				</tr>	
				{/if}
				<tr>
					<td class="bg_color2">&nbsp;</td>
					<td class="bg_color4"><input type="checkbox" name="totitle" value="1" id="totitle"{if $page.form.totitle} checked="checked"{/if} /><label for="totitle"> сделать анонсирующей фотографией</label></td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="150">Название</td>
					<td class="bg_color4"><input type="text" name="title" style="width:400px" value="{$page.form.title|escape:'html'}" /></td>
				</tr>
				<tr>
					<td class="bg_color2" align="right" width="150">Описание</td>
					<td class="bg_color4"><textarea name="descr" style="width:400px;height:100px;">{$page.form.descr|strip_tags}</textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="{if $page.action == 'editphoto'}Сохранить{else}Создать{/if}">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Отмена" onclick="document.location.href='/{$ENV.section}/popup/album/{$page.album}.php'" style="width:100px"></td>
				</tr>
				<tr>
					<td colspan="2" align="center">Символом <font color="red">*</font> отмечены поля, обязательные для заполнения.</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	
	<div class="b-line-padding"> </div>
	
	<div class="b-line">
		<div class="content">
		</div>
	</div>
	
</div>