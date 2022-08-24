<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="_action" value="_settings.html">
<table width="500" align="center" cellpadding="2" cellspacing="0">
<tr><td width="160" align="right" class="fheader_text">ФИО</td><td width="340"><input type="text" name="fio" value="{$fio}" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
{if !empty($ERROR.url)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.url}</span></td></tr>{/if}
<tr><td align="right" class="fheader_text">Сайт</td><td><input type="text" name="url" value="{$url}" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
<tr><td align="right" class="fheader_text">ICQ</td><td><input type="text" name="icq" value="{$icq}" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
<tr><td align="right" class="fheader_text">Место проживания</td><td><input type="text" value="{$address}" name="address" style="width:336px"></td></tr>
<tr><td>&nbsp;</td><td class="fcomment">Подпись вставляется после каждого Вашего сообщения.</td></tr>
<tr><td align="right" class="fheader_text">Подпись</td><td><input type="text" value="{$signature}" name="signature" style="width:336px"></td></tr>
{if !empty($avatar)}
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
<tr><td>&nbsp;</td><td><img src="{$avatar}"></td></tr>
<tr><td>&nbsp;</td><td><input type="checkbox" name="delavatar" value="1"> Удалить аватар</td></tr>
{/if}
{if !empty($ERROR.avatar)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.avatar}</span></td></tr>{/if}
<tr><td>&nbsp;</td><td class="fcomment">Размер аватара не должен превышать {$avatar_size.max_width} на {$avatar_size.max_height} пикселей и быть не более {$avatar_size.max_size} Кб.<br>Поддерживаемые форматы: gif, png, jpg, bmp.</td></tr>
<tr><td align="right" class="fheader_text">Аватар</td><td><input type="file" name="avatar" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
{if !empty($ERROR.email)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.email}</span></td></tr>{/if}
<tr><td width="160" align="right" class="fheader_text">E-Mail<br>для рассылки</td><td><input type="text" name="email" value="{$email}" style="width:336px"><br>
<span class="fcomment">не отображается на сайте</span></td></tr>
{if !empty($ERROR.emailshow)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.emailshow}</span></td></tr>{/if}
<tr><td width="160" align="right" class="fheader_text">E-Mail<br>для пользователей</td><td><input type="text" name="emailshow" value="{$emailshow}" style="width:336px"><br>
<span class="fcomment">отображается на сайте</span></td></tr></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
<tr><td>&nbsp;</td><td class="fcomment">Если вы не хотите менять пароль, не заполняйте следующие 2 поля</td></tr>
{if !empty($ERROR.pass)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.pass}</span></td></tr>{/if}
<tr><td align="right" class="fheader_text">Новый пароль</td><td><input type="password" name="pass1" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="5"></td><td><img src="/_img/x.gif" height="5"></td></tr>
<tr><td align="right" class="fheader_text">Повтор пароля</td><td><input type="password" name="pass2" style="width:336px"></td></tr>
<tr><td><img src="/_img/x.gif" height="10"></td><td><img src="/_img/x.gif" height="5"></td></tr>
{if !empty($ERROR.oldpass)}<tr><td>&nbsp;</td><td><span class="ferror">{$ERROR.oldpass}</span></td></tr>{/if}
<tr><td align="right" class="fheader_text">Текущий пароль</td><td><input type="password" name="oldpass" style="width:336px"></td></tr>
<tr><td class="fbreakline">&nbsp;</td><td class="fbreakline"><input type="submit" value="Изменить профиль"></td></tr>
</table>
</form>