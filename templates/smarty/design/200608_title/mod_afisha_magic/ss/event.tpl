{include file='design/200608_title/mod_afisha_magic/sectiontitle.tpl'}
{if !empty($res.errors)}
<div align="center" style="color:red; font-weight:bold; margin-top:30px; margin-bottom:100px;">
	{foreach from=$res.errors item=l key=k}
		{$l}<br />
	{/foreach}
</div>
{else}

<table width="100%" border="0" cellspacing="0" cellpadding="1">
	{if $res.data.group_name}
	<tr>
		<td colspan="2" class="place_title"><span>{$res.data.group_name}</span></td>
		{if $res.data.group_desc}
		<tr>
			<td colspan="2">
				{$res.data.group_desc}<br/>
			</td>
		</tr>
		{/if}
	</tr>
	{/if}
	<tr>
		<td colspan="2" class="place_title"><span>{$res.data.title}</span></td>
	</tr>
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td>{if sizeof($res.data.photo.src)}<img src="/{$res.data.photo.src}" {$res.data.photo.size} align="left" alt="" style="margin-right:20px; margin-bottom:10px; margin-top:10px" />{/if}
			{$res.data.text}<br/><br/>
			{if $res.data.genre}<b>Жанр</b>: {$res.data.genre}<br/><br/>{/if}
			{if $res.data.country}<b>Страна</b>: {$res.data.country}<br/><br/>{/if}
			{if $res.data.year}<b>Год выпуска</b>: {$res.data.year}<br/><br/> {/if}
			{if $res.data.length}<b>Продолжительность</b>: {$res.data.length}<br/><br/>{/if}
			{if $res.data.producer}<b>Режиссёр</b>: {$res.data.producer}<br/><br/> {/if}
			{if $res.data.role}<b>В ролях</b>: {$res.data.role}<br/><br/> {/if}
		</td>
		<td width="20">&nbsp;</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td>
			<table cellspacing="1" cellpadding="5" width="100%">
		{if is_array($res.data.seances)}
			<tr class="bg_color4">
				<th width="30%" align="left" class="infa">Где</th>
				<th width="25%" align="left" class="infa">Когда</th>
				<th width="30%" align="left" class="infa">Начало</th>
				<th width="15%" align="center" class="infa">Цена</th>
			</tr>
			{foreach from=$res.data.seances item=seance}
				<tr class="bg_color4">
					<td width="30%"><a href="/{$ENV.section}/{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a> {if !empty($seance.link.phones)} <font class="otzyv">(тел. {$seance.link.phones})</font>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}{/if}</td>
					<td width="25%">{$seance.date}</td>
					<td width="30%">{if !empty($seance.begin)}{$seance.begin}{/if}</td>
					<td width="15%" align="center">{$seance.price}{if !empty($seance.booking_link)}<br/><a href="{$seance.booking_link}" style="color:red;" target="_blank">Заказать билеты</a>{/if}</td>
				</tr>
			{/foreach}
		{/if}
			</table><br/>
			<div style="padding-left: 5px;">Внимание! Время начала сеансов уточняйте по телефонам, указанным выше.</div>
		</td>
		<td width="20">&nbsp;</td>
	</tr>
</table>



{*if count($res.data.group_events.categories) > 0}
<br/><br/>
<table border="0"  cellpadding="1" cellspacing="0" width="100%">
<tr>
	<td width="20">&nbsp;</td>
	<td>
<div class="zag1" style="padding:4px">{$res.data.group_name}</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	{foreach from=$res.data.group_events.categories item=category}
		{foreach from=$category.events item=event}
		<tr>
			<td>
			<table width="100%"  border="0" cellspacing="1" cellpadding="1">
				<tr valign="top">
					<td width="96">{if sizeof($event.photo)}<a href="/{$ENV.section}/event/{$event.id}.php"><img src="/{$event.photo.src}" {$event.photo.size}" border="0"></a>{/if}</td>
					<td ><a href="/{$ENV.section}/event/{$event.id}.php" class="zag7" >{$event.name}</a>
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
											{if is_array($seance.link)}<td class="lit2" width="30%"><a href="/{$ENV.section}/{$category.name}/{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}</td>{/if}
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

{/if*}



{/if}