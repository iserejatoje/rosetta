{capture name=pageslink}
{if !empty($page.pages.btn)}
<div class="ppageslink">Страницы:
	{if $page.pages.back!="" }<a href="{$page.pages.back}" class="ppageslink">&lt;&lt;</a>{/if}
	{foreach from=$page.pages.btn item=l}
		{if !$l.active}
	&nbsp;<a href="{$l.link}" class="ppageslink">{$l.text}</a>
		{else}
	&nbsp;<span class="ppageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $page.pages.next!="" }&nbsp;<a href="{$page.pages.next}" class="ppageslink">&gt;&gt;</a>{/if}
</div>
{/if}
{/capture}

<div class="title" style="padding: 5px;">Мои сообщения</div>

<div style="margin-top:20px; font-size:10px;">
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}">{if $page.folder==1}<font color="red">{/if}Входящие{if $page.folder==1}</font>{/if}</a> ({if $page.count.incoming_new>0}<b>{$page.count.incoming_new|number_format:0:'':' '}</b>/{/if}{$page.count.incoming|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?folder=2">{if $page.folder==2}<font color="red">{/if}Исходящие{if $page.folder==2}</font>{/if}</a> ({$page.count.outcoming|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_black_list.string}">Черный список</a> ({$page.count.blacklist|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
		{if $page.folder==3}<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?chain={$page.uchain->ID}"><font color="red">Цепочка с {$page.uchain->Profile.general.ShowName}</font></a> ({$page.count.chain|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;{/if}
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_contacts.string}">Контакты</a> ({$page.count.contacts|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
</div><br/>

<div align="right" style="padding-top:16px">
	<select class="messages_act_list" onChange="{literal}$('#messages_act').val($(this).val());var val = $(this).val(); $('.messages_act_list').each(function() { $(this).val(val); }){/literal}">
		<option value="">-- действие --</option>
		<option value="make_read">отметить как прочитанные</option>
		<option value="make_unread">отметить как новые</option>
		<option value="delete">удалить</option>
	</select>
	<input type="button" onclick="$('#messages_act').get(0).form.submit()" value="Ок" />
</div>

{$smarty.capture.pageslink}

<form action="" style="margin:0px" method="post">
	{if isset($page.redirect_url)}<input type="hidden" name="rurl" value="{$page.redirect_url}" />{/if}
	<input type="hidden" name="action" value="im_messages" />
	<input type="hidden" name="folder" value="{$page.folder}" />
	<input type="hidden" name="p" value="{$page.page}" />
	<input type="hidden" id="messages_act" name="act" value="" />

	<table align="center" border="0" cellpadding="3" cellspacing="2" width="100%">
		{foreach from=$page.list item=l}
		<tr>
			<td>
				<a name="im_message{$l.MessageID}"></a>
				<table width="100%" cellspacing="0" cellpadding="0">
					<tr class="pmtable_header bg_color2">
						<td width="130">&nbsp;
							<img alt="" width="10" height="10" src="/_i/passport/img/icon1.gif" style="vertical-align:bottom;" />
							<b><a class="pmtable_command" href="javascript:void(0)" onClick="{$l.replyjs}return false;">ответить</a></b>
						</td>
						<td style="height:25px;">&nbsp;</td>
						<td>
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td nowrap="nowrap" align="right">
										<table cellspacing="0" cellpadding="6">
											<tr>
												<td>
													<div class="blacklist_{$l.UserInfo->ID}" style="display:{if !$l.IsInBlackList}block{else}none{/if};">
														<img alt="" width="10" height="10" style="vertical-align:bottom" src="/_i/passport/img/icon1.gif" />&nbsp;
														<b>
															<a class="pcomment" href="javascript:void(0)"
															   onClick="mod_passport_im_loader.black_list({$l.UserInfo->ID}, 'add');return false;">в черный список</a>
														</b>
													</div>
													<div class="blacklist_add_{$l.UserInfo->ID}" style="display:{if $l.IsInBlackList}block{else}none{/if};">
														<span style="color:red" class="tip">в черном списке</span>
													</div>
												</td>

												{if $USER->ID == 1}
												<td>
													<div id="contactslist_add_{$l.UserInfo->ID}" style="display:{if !$l.IsInContactsList}block{else}none{/if};">
														<img alt="" width="10" height="10" style="vertical-align:bottom" src="/_i/passport/img/icon1.gif" />&nbsp;
														<b>
															<a class="pcomment" href="javascript:void(0)" onClick="mod_passport_im_loader.contacts_list({$l.UserInfo->ID}, 'add');return false;">добавить в контакты</a></b>
													</div>
													<div id="contactslist_del_{$l.UserInfo->ID}" style="display:{if $l.IsInContactsList}block{else}none{/if};">
														<img alt="" width="10" height="10" style="vertical-align:bottom" src="/_i/passport/img/icon1.gif" />&nbsp;
														<b><a class="pcomment" href="javascript:void(0)" onClick="mod_passport_im_loader.contacts_list({$l.UserInfo->ID}, 'del');return false;">удалить из контактов</a></b>
													</div>
												</td>
												{/if}

												{if $page.folder != 3 && ($l.UserID!=$l.UserFrom && $page.folder!=2) || ($l.UserID!=$l.UserTo && $page.folder==2)}
												<td>
													<img alt="" width="10" height="10" style="vertical-align:bottom" src="/_i/passport/img/icon1.gif" />&nbsp;
													<b><a class="pcomment" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?chain={$l.UserInfo->ID}">история</a></b>
												</td>
												{/if}

												<td>
													<img alt="" width="10" height="10" style="vertical-align:bottom" src="/_i/passport/img/icon1.gif" />&nbsp;
													<b>	<a class="pcomment" title="удалить сообщение" href="/{$ENV.section}/{$CONFIG.files.get.im_delete.string}?id={$l.MessageID}&folder={$page.folder}&p={$page.page}{if isset($page.redirect_url)}&rurl={$page.redirect_url|escape:"url"}{/if}">удалить</a></b>
												</td>
												<td class="bg_color3">
													<input type="checkbox" name="ids[]" value="{$l.MessageID}" class="checkboxes"
														   onchange="$('#check_all').attr('checked',$('.checkboxes').length == $('.checkboxes:checked').length?true:false);" />
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="120" valign="top">

							<div class="bg_color3" style="padding:1px;height:160px;margin:2px;width:130px;">
								<div class="bg_color4" align="center" style="height:160px;width:130px;">
									<div style="background:{
										if $l.UserInfo->Profile.general.Avatar!='' && $l.UserInfo->Profile.general.AvatarUrl
											}url('{$l.UserInfo->Profile.general.AvatarUrl}')
										{else
											}url('/_img/modules/passport/user_unknown.gif'){
										/if} no-repeat center;width:100px; padding-top:2px;">
										<a href="{$l.UserInfo->Profile.general.InfoUrl}"><img alt="" border="0" src="/_img/x.gif" width="100" height="100"/></a>
									</div>
									<div style="padding:4px" class="text11">
										<a href="{$l.UserInfo->Profile.general.InfoUrl}"><b>{$l.UserInfo->Profile.general.ShowName|truncate:20}</b></a>
									</div>

									{if $l.showvisited}
									<div class="tip" style="margin-bottom: 5px;">{$l.showvisited|user_online:"%f %H:%M":"%d %F":$l.UserInfo->Profile.general.Gender}</div>
									{/if}
								</div>
							</div>

						</td>
						<td>&nbsp;</td>
						<td valign="top">
							<div style="padding-top:6px; padding-bottom:6px;">
								<span class="pmtable_date"{if $l.IsNew!=0} style="color:red;font-weight:bold"{/if}>{$l.Created|simply_date}</span>
							</div>

							<div style="padding-bottom:4px;" class="dop">
								{if !empty($l.Type)}
								<b>{$l.DType}{if !empty($l.RefererTitle)}:{/if}</b>{/if}
									{if !empty($l.RefererTitle)}{if !empty($l.RefererUrl)}
								<a href="{$l.RefererUrl}">{$l.RefererTitle}</a>
									{else if !empty($l.RefererTitle)}
										{$l.RefererTitle}
									{/if}
								{/if}
							</div>

							<div>{$l.Text|with_href|nl2br}</div>

							{if $l.File}
							<div class="tip">
								<br />Прикрепленный файл: <a href="{$l.File.Url}" target="_blank">{$l.File.NameOriginal}</a>
							</div>
							{/if}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		{/foreach}
	</table>
</form>

{$smarty.capture.pageslink}

<div align="right" style="padding-top:16px">
	<select class="messages_act_list" onChange="{literal}$('#messages_act').val($(this).val());var val = $(this).val(); $('.messages_act_list').each(function() { $(this).val(val); }){/literal}">
		<option value="">-- действие --</option>
		<option value="make_read">отметить как прочитанные</option>
		<option value="make_unread">отметить как новые</option>
		<option value="delete">удалить</option>
	</select>
	<input type="button" onclick="$('#messages_act').get(0).form.submit()" value="Ок" />
</div>

<br/><br/>