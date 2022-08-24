{if count($res.list.categories) > 0}
<br/><br/>
<table border="0"  cellpadding="1" cellspacing="0" width="100%">
<tr>
	<td width="20">&nbsp;</td>
	<td>
<div class="zag1" style="padding:4px">{$res.group.name}</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	{foreach from=$res.list.categories item=category}
		{foreach from=$category.events item=event}
		<tr>
			<td>
			<table width="100%"  border="0" cellspacing="1" cellpadding="1">
				<tr valign="top">
					<td width="96">{if sizeof($event.photo)}<a href="/{$CURRENT_ENV.section}/event/{$event.id}.php"><img src="{$event.photo.url}" width="{$event.photo.w}" height="{$event.photo.h}" border="0"></a>{/if}</td>
					<td ><a href="/{$CURRENT_ENV.section}/event/{$event.id}.php" class="zag7" >{$event.name}</a>
					<br/>
						{if $event.genre}
							<b>жанр:</b> {$event.genre}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{/if}
						{if $event.country}
							<b>страна:</b> {$event.country}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{/if}
						{if $event.length}
							<b>продолжительность:</b> {$event.length}
						{/if}

						<div style="margin-top: 5px">
							{if is_array($event.seances)}
								<table cellspacing="1" cellpadding="3" width="100%">
									<tr bgcolor="#F6F6F6">
										<th class="infa" width="30%" align="left">Где</th>
										<th class="infa" width="25%" align="left">Когда</th>
										<th class="infa" width="30%" align="left">Начало</th>
										<th class="infa" width="15%" align="center">Цена</th>
									</tr>
									{foreach from=$event.seances item=seance}
										<tr bgcolor="#F6F6F6">
											{if is_array($seance.link)}<td class="lit2" width="30%"><a href="/{$CURRENT_ENV.section}/{$category.name}/{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}</td>{/if}
											<td width="25%">{$seance.date}</td>
											<td width="30%">{if !empty($seance.begin)}{$seance.begin}{/if}</td>
											<td width="15%" align="center">{$seance.price}</td>
										</tr>
									{/foreach}
								</table>
							{/if}
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
				</tr>
				</table>
			</td>
		</tr>
		{/foreach}
	{/foreach}
</table>

</td>
<td width="20">&nbsp;</td>
</tr>
</table>
<br/><br/>

{/if}
