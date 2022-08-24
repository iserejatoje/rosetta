{include file='design/200608_title/mod_afisha_magic/sectiontitle.tpl'}
{if !empty($res.errors)}
<div align="center" style="color:red; font-weight:bold; margin-top:30px; margin-bottom:100px;">
	{foreach from=$res.errors item=l key=k}
		{$l}<br />
	{/foreach}
</div>
{else}

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if is_array($res.data)}
	{foreach from=$res.data.categories item=category}
		{if sizeof($category.events)}
		<tr>
			<td width="20"> </td>
			<td class="place_title"><span>{$category.title}</span></td>
			<td width="20"> </td>
		</tr>
		<tr>
			<td width="20">&nbsp;</td>
			<td>{$category.search_form}</td>
			<td>&nbsp;</td>
		</tr>
		{/if}
		{foreach from=$category.events item=event}
		<tr>
			<td width="20">&nbsp;</td>
			<td>
			<table width="100%"  border="0" cellspacing="1" cellpadding="1">
				<tr valign="top">
					<td width="96">{if sizeof($event.photo)}<a href="/{$ENV.section}/event/{$event.id}.php"><img src="/{$event.photo.src}" {$event.photo.size}" border="0"></a>{/if}</td>
					<td ><a href="/{$ENV.section}/event/{$event.id}.php" class="zag7" ><b>{$event.name}</b></a>
					<br/>
						{if $event.genre}
							жанр: {$event.genre}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{/if}
						{if $event.country}
							страна: {$event.country}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{/if}
						{if $event.length}
							продолжительность: {$event.length}
						{/if}

						<div style="margin-top: 5px">
							{if is_array($event.seances)}
								<table cellspacing="1" cellpadding="3" width="100%">
									<tr class="bg_color4">
										<th width="30%" align="left" class="infa">Где</th>
										<th width="25%" align="left" class="infa">Когда</th>
										<th width="30%" align="left" class="infa">Начало</th>
										<th width="15%" align="center" class="infa">Цена</th>
									</tr>
									{foreach from=$event.seances item=seance}
										<tr  class="bg_color4">
											{if is_array($seance.link)}<td width="30%"><a href="/{$ENV.section}/{$category.name}/{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}</td>{/if}
											<td width="25%">{$seance.date}</td>
											<td width="30%">{if !empty($seance.begin)}{$seance.begin}{/if}</td>
											<td width="15%" align="center">{$seance.price}{if !empty($seance.booking_link)}<br/><a href="{$seance.booking_link}" style="color:red;" target="_blank">Заказать билеты</a>{/if}</td>
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
			<td>&nbsp;</td>
		</tr>
		{/foreach}
	{/foreach}
{/if}
</table>

{/if}