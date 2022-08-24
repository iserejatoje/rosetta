{include file='design/200608_title/mod_afisha_magic/sectiontitle.tpl'}
{if !empty($res.errors)}
<div align="center" style="color:red; font-weight:bold; margin-top:30px; margin-bottom:100px;">
	{foreach from=$res.errors item=l key=k}
		{$l}<br />
	{/foreach}
</div>
{else}

{if is_array($res.data.place_info) && ($res.data.place_info.phones || $res.data.place_info.address)}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table cellspacing="1" cellpadding="3" width="100%">
				<tr>
					<td colspan="2" class="place_title"><span>{$res.data.place_info.name}</span></td>
				</tr>
				{if $res.data.place_info.desc}
				<tr>
					<td colspan="2">{$res.data.place_info.desc}<br/><br/></td>
				</tr>
				{/if}
				{if $res.data.place_info.phones}
				<tr bgcolor="#edf6f8">
					<td style="padding-left:20px;">Телефон:</td>
					<td width="100%">{$res.data.place_info.phones}</td>
				</tr>
				{/if}
				{if $res.data.place_info.address}
				<tr bgcolor="#edf6f8">
					<td align="right">Адрес:</td>
					<td>{$res.data.place_info.address}</td>
				</tr>
				{/if}
				{*if $res.data.place_info.phones}
				<tr>
					<td></td>
					<td>Внимание! Время начала сеансов уточняйте по телефонам</td>
				</tr>
				{/if*}
			</table>
		</td>
	</tr>
</table>
<br/>
{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
{if is_array($res.data)}
	{foreach from=$res.data.categories item=category}
		{if sizeof($category.events)}
			{foreach from=$category.events item=event}
				<tr valign="top">
					<td width="20">&nbsp;</td>
					<td width="96">{if sizeof($event.photo.src)}<a href="/{$ENV.section}/event/{$event.id}.php"><img src="/{$event.photo.src}" {$event.photo.size} border="0"></a>{/if}</td>
					<td>
						<a href="/{$ENV.section}/event/{$event.id}.php" class="zag7"><b>{$event.name}</b></a><br/>
						<div class="lit2" style="margin-top: 5px">
							<table cellspacing="1" cellpadding="3" width="100%">
								{if is_array($event.seances)}
									{foreach from=$event.seances item=seance}
										<tr class="bg_color4">
											<td class="lit2" width="25%">{$seance.date}</td>
											<td class="lit2" width="30%">{if !empty($seance.begin)}начало: {$seance.begin}{/if}{if $seance.auditorium} Зал: {$seance.auditorium}{/if}</td>
											<td class="lit2" width="15%" align="center">{$seance.price}</td>
										</tr>
									{/foreach}
								{/if}
							</table>
						</div> 
					</td>
					<td width="20">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
				</tr>
			{/foreach}
		{/if}
	{/foreach}
	{if $res.data.place_info.phones}
		<tr>
			<td width="20">&nbsp;</td>
			<td></td>
			<td>Внимание! Время начала сеансов уточняйте по телефонам, указанным выше.</td>
			<td width="20">&nbsp;</td>
		</tr>
	{/if}
{/if}
</table>
<br/>
<br/>
{/if}