{if $res.system_message}
				<br/><br/>{$res.system_message}<br/><br/>
{else}

{if $res.data}

<br/><br/>
	<table cellpadding=0 align=center cellspacing=0 border=0>
		<tr>
			<td>
				<font class=\"rem\"><b>катастрофа:</b></font>&#160;
			</td>
			{if $res.prev}
			<td><a href="/{$SITE_SECTION}{$res.prev}.php"><img src="/_img/design/200710_auto/prev.gif" alt="предыдущая" border=0></a></td>
			<td>&#160;<a href="/{$SITE_SECTION}/{$res.prev}.php">предыдущая</a>&#160;|</td>{/if}
			{if $res.next}
			<td>&#160;<a href="/{$SITE_SECTION}/{$res.next}.php">следующая</a>&#160;</td>
			<td><a href="/{$SITE_SECTION}/{$res.next}.php"><img src="/_img/design/200710_auto/next.gif" alt="следующая" border=0></a></td><td>&#160;|</td>
			{/if}
			<td>&#160;<a href="/{$SITE_SECTION}/">все</a>&#160;</td><td><a href="/{$SITE_SECTION}/"><img src="/_img/design/200710_auto/all.gif" alt="все катастрофы" border=0></a></td>
		</tr>
	</table><br/>
	
			{$res.data.Date|date_format:"%e %B %Y"} г.<br><font class=zag1><b>{$res.data.Name}</b></font><br><br>
			
			<img id="GalleryPhotoBig" style="border: #BAD5EA solid 2px" src="{$res.photo[$res.photo_selected].Big.url}" alt="{$res.data.Name}"><br><br>
			{if $res.data.Text}<b>Информация:</b><br>{$res.data.Text}<br><br>{/if}
	<table cellpadding=0 cellspacing=0 border=0>
		<tr>{if $res.data.IsUser}
			<td><img src="/_img/design/200710_auto/puser.gif" title="добавлены пользователем" alt="добавлены пользователем"></td>
			{/if}
			<td>
				&#160;<b>Другие фотографии с места катастрофы:</b>
			</td>
		</tr>
	</table>
	
	{if sizeof($res.photo)}
	
	<table cellpadding="8" cellspacing="2" border="0">
		<tr>
			<td>
				{foreach from=$res.photo item=img key=_k name=imglist }
				<div style="float:left; margin:10px;">
					<a href="/{$SITE_SECTION}/{$res.data.ID}.php?photo={$_k}" onClick="return mod_accident.ChangePhoto('{$img.Big.url}', '{$img.Big.w}', '{$img.Big.h}');"><img style="border: #BAD5EA solid 2px" src="{$img.Small.url}" width="{$img.Small.w}" height="{$img.Small.h}" alt="открыть"></a>
				</div>
				{/foreach}
			</td>
		</tr>
	</table>
	
	{/if}
	
			<br><table cellpadding="0" align="center" cellspacing="0" border="0">
		<tr>
			<td>
				<font class=\"rem\"><b>катастрофа:</b></font>&#160;
			</td>
			{if $res.prev}
			<td><a href="/{$SITE_SECTION}/{$res.prev}.php"><img src="/_img/design/200710_auto/prev.gif" alt="предыдущая" border=0></a></td>
			<td>&#160;<a href="/{$SITE_SECTION}/{$res.prev}.php">предыдущая</a>&#160;|</td>{/if}
			{if $res.next}
			<td>&#160;<a href="/{$SITE_SECTION}/{$res.next}.php">следующая</a>&#160;</td>
			<td><a href="/{$SITE_SECTION}/{$res.next}.php"><img src="/_img/design/200710_auto/next.gif" alt="следующая" border=0></a></td><td>&#160;|</td>
			{/if}
			<td>&#160;<a href="/{$SITE_SECTION}/">все</a>&#160;</td><td><a href="/{$SITE_SECTION}/"><img src="/_img/design/200710_auto/all.gif" alt="все катастрофы" border=0></a></td>
		</tr>
	</table><br>
{else}
	<br /><br />
	<center>
	Информация о данной катастрофе не найдена.<br /><br />
	<a href="/{$SITE_SECTION}/">Вернуться назад</a>
	</center>
{/if}
{/if}