<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="im_new" />
<input type="hidden" name="to" value="{$page.to}" />
<div class="title" style="padding: 5px;">Новое сообщение</div>
{if isset($page.UserInfo)}
<table width="100%" cellspacing="0" cellpadding="0">
	<tr class="pmtable_header">
		<td class="pmtable_nickname" width="120">&nbsp;{$page.UserInfo->Profile.general.ShowName}</td>
		<td><img width="1" height="25" src="/_img/x.gif" /></td>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><span class="pmtable_date">{if isset($page.message)}{$page.message.Created|simply_date}{/if}</span></td>
					<td nowrap="nowrap" align="right">
						{if isset($page.message)}<table cellspacing="6" cellpadding="0">
							<tr>
								<td><img width="10" height="10" align="bottom" src="/_i/passport/img/icon1.gif" /></td>
								<td><b><a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}&chain={$page.UserInfo->ID}">история</a></b></td>
								<td><img width="10" height="10" align="bottom" src="/_i/passport/img/icon1.gif" /></td>
								<td><b><a class="pmtable_command" title="удалить сообщение" href="/{$ENV.section}/{$CONFIG.files.get.im_delete.string}?id={$page.message.MessageID}">удалить</a></b></td>
							</tr>
						</table>{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="120" valign="top">
			{if !empty($page.UserInfo->Profile.general.Avatar)}
			<a class="pcomment" target="_blank" href="{$page.UserInfo->Profile.general.InfoUrl}">
				<img border="0" src="{$page.UserInfo->Profile.general.AvatarUrl}" width="{$page.UserInfo->Profile.general.AvatarWidth}" height="{$page.UserInfo->Profile.general.AvatarHeight}">
			</a>
			{/if}
			{if $page.showvisited}
			<div class="pmtable_date">{$page.showvisited|user_online}</div>
			{/if}
			<div style="padding-top:4px;padding-bottom:4px;"><a class="pcomment" target="_blank" href="{$page.UserInfo->Profile.general.InfoUrl}">профиль</a></div>
		</td>
		<td><img width="1" height="25" src="/_img/x.gif"/></td>
		<td valign="top">{if isset($page.message)}<div style="padding-bottom:6px;">Тема: {$page.message.Title|with_href}</div>{$page.message.Text|with_href}{/if}</td>
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
{else}
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('nicknameto') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('nicknameto')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Кому</td>
		<td class="bg_color4">
		{if $page.to==0}
			<input type="text" name="nicknameto" value="{$page.nicknameto|escape:'html'}" style="width:100%" />
		{else}
			<b>{$page.nicknameto|escape:'html'}</b>
		{/if}
		</td>
	</tr>
{/if}
{if $UERROR->GetErrorByIndex('title') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('title')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Тема</td>
		<td class="bg_color4">
			<input type="text" name="title" value="{$page.title|escape:'html'}" style="width:100%" />
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('text') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('text')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Сообщение.</td>
		<td class="bg_color4"><textarea name="text" style="width:100%; height:100px;">{$page.text|escape:'html'}</textarea></td>
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Отправить сообщение" /></td>
	</tr>
</table>
</form>