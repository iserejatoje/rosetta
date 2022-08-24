
{if $res.photo}
{assign var=_nocomment value=$res.data.nocomment}

			<table width="100%" cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td colspan="2" align="left">{$res.nav}</td>
				</tr>
				<tr>
					<td colspan="2"><img src="/_img/x.gif" width="0" height="5" border="0"></td>
				</tr>
				<tr valign="top" align="center">
					<td width="100%">
						<table align=center width="100%" cellpadding="4" cellspacing="1" border="0">
							<tr align=left valign=top class="block_title2">
								<td width="20%"><b>Название:</b></td>
								<td width="80%" bgcolor="#F5F9FA">{if $res.data.name}{$res.data.name}{else}-{/if}</td>
							</tr>
							<tr align=left valign=top class="block_title2">
								<td><b>Дата создания:</b></td>
								<td bgcolor="#F5F9FA">{$res.data.date|date_format:'%e-%m-%Y'}&nbsp;</td>
							</tr>
							<tr align=left valign=top class="block_title2">
								<td><b>Дополнительная информация:</b></td>
								<td bgcolor="#F5F9FA">{if $res.data.text}{$res.data.text}{else}-{/if}</td>
							</tr>
							<tr align=left valign=top class="block_title2">
								<td><b>Просмотров:</b></td>
								<td bgcolor="#F5F9FA">{$res.data.shows|intval}&nbsp;</td>
							</tr>
						</table>
					</td>
					<td>
						<table align=center cellpadding="5" cellspacing="1" border="0" bgcolor="#999999">
							<tr align=center valign=top bgcolor="#ffffff">
								<td>
								{if $res.photo.prop=="imgzoom"}
									<a href="{$CONFIG.files.get.imgzoom.string}?img={$res.original.url}" onmouseover="window.status='Кликни для увеличения';return true;" onmouseout="window.status=defaultStatus" onclick="javascript:ImgZoom('{$CONFIG.files.get.imgzoom.string}?state=photo&img={$res.original.url}','gallery{$res.data.id}',{$res.original.w+25},{$res.original.h+40});return false;" target="_blank">
										<img src="{$res.photo.url}" width={$res.photo.w} height={$res.photo.h} border="0" alt="Кликни для увеличения">
									</a>
								{else}
									<img src="{$res.photo.url}" border="0" width="{$res.photo.w}" height="{$res.photo.h}">
								{/if}
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
{else}
<br/><br/><br/>
<center>Изображение не найдено.</center><br/><br/>
{assign var=_nocomment value=true}
{/if}