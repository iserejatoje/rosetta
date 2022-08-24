<div class="gallery-popup">

	<table class="path">
		<tr>
			<td>
				<a href="{$TITLE->Path[1].link}">{$TITLE->Path[1].name}</a>
			</td>
		</tr>
	</table>

	<div class="t-line">
		<div class="content">
			Добавление альбома
		</div>
	</div>

	<div class="list">
		<div>
			<form method="post" class="form_cell">
			<input type="hidden" name="gallery" value="{$page.gallery}" />
			<input type="hidden" name="action" value="{$page.form.action}" />
			<table cellspacing="2" cellpadding="3" border="0" align="center" width="550">
				{if isset($UERROR->ERRORS.title)}
				<tr>
					<td align="right">&nbsp;</td>
					<td align="left" class="error"><span>{$UERROR->ERRORS.title}</span></td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="150">Название <font color="red">*</font></td>
					<td class="bg_color4"><input type="text" name="title" style="width:400px" value="{$page.form.title|escape:'html'}" /></td>
				</td>
				{if isset($UERROR->ERRORS.descr)}
				<tr>
					<td align="right">&nbsp;</td>
					<td align="left" class="error"><span>{$UERROR->ERRORS.descr}</span></td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="150">Описание</td>
					<td class="bg_color4"><textarea name="descr" style="width:400px;height:100px;">{$page.form.descr|escape:'html'}</textarea></td>
				</td>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="{if $page.form.action == 'addalbum'}Создать{else}Сохранить{/if}" style="width:100px">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Отмена" onclick="document.location.href='/{$ENV.section}/popup/gallery/{$page.gallery}.php'" style="width:100px"></td>
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