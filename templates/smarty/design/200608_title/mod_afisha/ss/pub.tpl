{include file='design/200608_title/mod_afisha/sectiontitle.tpl'}

{if !empty($page.message)}<br><br><br><br><center>{$page.message}</center>{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
{foreach from=$page.data.events item=event}
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td width="96">{if sizeof($event.photo.src)}<a href="{$event.href}"><img src="{$event.photo.src}" {$event.photo.size} border="0"></a>{/if}</td>
		<td>
			<a href="{$event.href}"><b>{$event.name}</b></a><br/>
			<div class="lit2" style="margin-top: 5px">
				<table cellspacing="1" cellpadding="3" width="100%">
					{if is_array($event.seances)}
						{foreach from=$event.seances item=seance}
							<tr class="bg_color4">
								{if is_array($seance.link)}<td class="lit2" width="30%"><a href="{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a></td>{/if}
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
</table>

