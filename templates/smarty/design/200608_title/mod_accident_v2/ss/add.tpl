<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="padding-left:10px;padding-right:10px;"><center>	
		
		{if isset($smarty.get.success)}
			<br/><br/>Ваша информация и фотографии будут добавлены на сайт<br/>
				в течение нескольких часов,<br/>
				если они не противоречат общепринятым<br/>
				этическим нормам и соответствуют теме раздела.
				<br/><br/>[ <a href="/{$CURRENT_ENV.section}/add.php">Вернуться к странице добавления фотографий</a> ]<br/><br/>
				[ <a href="/{$CURRENT_ENV.section}/">Перейти к списку ДТП</a> ]
		<br/>
		<br/>
		{else}
		
		<br/><br/><font class="zag6">Добавить фотографии с места ДТП</font>
		<form name="add_accident" method="post" enctype="multipart/form-data">
			<input name="action" value="add_accident" type="hidden">
				<table border="0" cellspacing="5">
					{if isset($UERROR->ERRORS.where)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.where}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right"><span style="color:red">*</span>&nbsp;Место ДТП:</td>
						<td align="left">
							<input style="width: 320px;" name="where" class="text_edit" maxlength="255" value="{$page.where}" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><font class="txt_red"></font>&nbsp;Описание:</td>
						<td align="left"><textarea name="desc" rows="10" cols="38" wrap="virtual">{$page.desc}</textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="small" align="left">
							Вы можете разместить до 5 фотографий.<br/>
							Тип файла: jpg, gif, png. <br/>
							Максимальный размер файла {$page.max_file_size} Kb.
						</td>
					</tr>
					{if isset($UERROR->ERRORS.photo1)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.photo1}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right"><span style="color:red">*</span> Фото 1:</td>
						<td align="left"><input name="photo[]" class="TextEdit" size="37" value="" type="file"></td>
					</tr>
					{if isset($UERROR->ERRORS.photo2)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.photo2}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right">Фото 2:</td>
						<td align="left"><input name="photo[]" class="TextEdit" size="37" value="" type="file"></td>
					</tr>
					{if isset($UERROR->ERRORS.photo3)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.photo3}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right">Фото 3:</td>
						<td align="left"><input name="photo[]" class="TextEdit" size="37" value="" type="file"></td>
					</tr>
					{if isset($UERROR->ERRORS.photo4)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.photo4}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right">Фото 4:</td>
						<td align="left"><input name="photo[]" class="TextEdit" size="37" value="" type="file"></td>
					</tr>
					{if isset($UERROR->ERRORS.photo5)}
					<tr>
						<td colspan="2" align="center"><font color="red">{$UERROR->ERRORS.photo5}</font></td>
					</tr>
					{/if}
					<tr>
						<td align="right">Фото 5:</td>
						<td align="left"><input name="photo[]" class="TextEdit" size="37" value="" type="file"></td>
					</tr>
					<tr>
						<th colspan="2"><br/><input value="Опубликовать" type="submit"></th>
					</tr>
					<tr>
						<td colspan="2"><br/>
							<font class="small">Примечание:</font> 
							<span style="color:red">*</span>
							<font class="small"> - поля, обязательные для заполнения.</font>
						</td>
					</tr>
				</table>
		</form>
		<br/>
		<a title="все катастрофы" href="/{$SITE_SECTION}/">все</a>&nbsp;<a href="/{$SITE_SECTION}/"><img src="/_img/design/200710_auto/all.gif" alt="все катастрофы" border="0" style="vertical-align:text-top;"></a>
		
		{/if}
		</center></td>
	</tr>
</table>
