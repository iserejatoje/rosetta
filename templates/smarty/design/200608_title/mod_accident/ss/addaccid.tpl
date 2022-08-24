<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="padding-left:10px;padding-right:10px;"><center>	
		
		{if $page.system_message}
			<br/><br/><font class="t7">{$page.system_message}</font><br/><br/>
		{else}
		
		{if !$page.success}<br/><br/><font class="t5gb">Добавить фотографии с места ДТП</font>
		{if $page.message}
			<br/><br/><font color="red">{$page.message}</font><br/><br/>		
		{/if}	
		<form {*action="/{$SITE_SECTION}/addaccid/"*} name="add_form_accid" method="post" enctype="multipart/form-data">
			<input name="action" value="insaccid" type="hidden">
				<table border="0" cellspacing="5">
					<tr>
						<td align="right" class="t1"><font color="red">*</font>&nbsp;Место ДТП:</td>
						<td align="left">
							<input style="width: 320px;" name="where" class="txt" maxlength="255" value="{$page.where}" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" valign="top" class="t1">Описание:</td>
						<td align="left"><textarea name="desc" rows="10" cols="38" wrap="virtual" class="txt">{$page.desc}</textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" class="t7">
							Вы можете разместить до 5 фотографий.<br/>
							Тип файла: jpg, gif, png. <br/>
							Максимальный размер файла 500Kb.
						</td>
					</tr>
					<tr>
						<td align="right" class="t1"><font color="red">*</font>Фото 1:</td>
						<td align="left"><input name="photo[]" class="txt" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<td align="right" class="t1">Фото 2:</td>
						<td align="left"><input name="photo[]" class="txt" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<td align="right" class="t1">Фото 3:</td>
						<td align="left"><input name="photo[]" class="txt" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<td align="right" class="t1">Фото 4:</td>
						<td align="left"><input name="photo[]" class="txt" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<td align="right" class="t1">Фото 5:</td>
						<td align="left"><input name="photo[]" class="txt" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<th colspan="2"><br/><input value="Опубликовать" type="submit" class="txt"></th>
					</tr>
					<tr>
						<td colspan="2"><br/>
							<font class="t1">Примечание:</font> 
							<font color="red">*</font>
							<font class="t7"> - поля, обязательные для заполнения.</font>
						</td>
					</tr>
				</table>
		</form>
		<br/>
		<a title="все катастрофы" href="/{$SITE_SECTION}/">все</a>
		{else}
		
		<br/><br/><font color="red">{$page.message}</font><br/><br/>
		
		{/if}
		{/if}
		</center></td>
	</tr>
</table>
<br/><br/>