<form style="margin:0px" method="POST">
<input type="hidden" id="im_form_to" value="{$res.to}" />
<table width="550" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td class="nyroModalTitle bg_color1">
			<div style="float:right">
				<img class="nyroModalClose" style="cursor:pointer;cursor:hand;padding-top:2px;" src="/_img/modules/passport/im/close.gif " />
			</div>
			<div align="left">Отправить резюме</div>
		</td>
	</tr>
{if sizeof($res.list.data)}
	<tr bgcolor="#E0F3F3" class="bg_color2">
		<td align="center" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td width="118" valign="top" align="left"><strong>Кому</strong></td>
					<td width="100%" align="left">
						<div>
							<div align="left" style="position:relative;float:left;padding-right:10px;">
								{if $res.UserInfo->Profile.general.AvatarUrl}
								<a class="pcomment" target="_blank" href="{$res.UserInfo->Profile.general.InfoUrl}">
									<img border="0" src="{$res.UserInfo->Profile.general.AvatarUrl}" width="{$res.UserInfo->Profile.general.AvatarWidth}" height="{$res.UserInfo->Profile.general.AvatarHeight}">
								</a>
								{/if}
							</div>
							<div align="left" style="position:relative;font-weight:bold" id="im_showname">{$res.UserInfo->Profile.general.ShowName}</div>
							{if $res.showvisited}
							<div align="left" style="position:relative;" class="pmtable_date">{$res.showvisited|user_online}</div>
							{/if}
							<div align="left" style="position:relative;padding-top:4px;">{if !empty($res.Type)}<b>{$res.DType}{if !empty($res.RefererTitle)}:{/if}</b>{/if} {if !empty($res.RefererTitle)}{if !empty($res.RefererUrl)}<a href="{$res.RefererUrl}">{/if}{$res.RefererTitle|with_href}{if !empty($res.RefererUrl)}</a>{/if}{/if}</div>
						</div>
						{if !empty($res.message)}
						<div align="left" class="dop" id="im_message_text" style="clear:both;overflow-y:auto">{$res.message.Text|nl2br|with_href}</div>
						{/if}
					</td>
				</tr>
				<tr>
					<td width="118" valign="top" align="left"><strong>Выберите резюме</strong><br></td>
					<td width="100%" align="left">
						<select id="im_select" style="width:100%">
						{if $res.list.type=='resume'}
							{foreach from=$res.list.data item=l}
								<option value="{$l.url}">{$l.pdate} - {$l.name} / {$l.dol} - {$l.fio}</option>
							{/foreach}
						{elseif $res.list.type=='vacancy'}
							{foreach from=$res.list.data item=l}
								<option value="{$l.url}">{$l.pdate} - {$l.name} / {$l.dol} - {$l.firm}</option>
							{/foreach}
						{/if}
						</select>
					</td>
				</tr>
				<tr>
					<td width="118" valign="top" align="left"><strong>Сообщение</strong><br></td>
					<td width="100%" align="left"><textarea 
						id="im_form_text" 
						style="width:100%; font-size:12px; height:120px"
						onkeypress="if (event.keyCode==10 || ((event.metaKey || event.ctrlKey) && event.keyCode==13)) $('#imSendButton').click()"></textarea></td>
				</tr>

				<tr>
					<td width="118" valign="top" align="left">&nbsp;</td>
					<td align="left"><input type="button" id="imSendButton" class="nyroModalSend" value="Отправить" />
						<input type="button" class="nyroModalClose" value="Закрыть" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
{else}
	<tr>
		<td valign="center" height="150px" bgcolor="#E0F3F3" class="bg_color2">
			<table width="100%" border="0" cellspacing="0" cellpadding="3">		
				<tr>
					<td align="center"><b>У Вас нет ни одного заполненного резюме!</b><br/><br/></td>
				</tr>
				<tr>
					<td align="center">
						<input type="button" class="nyroModalClose" value="Закрыть" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
{/if}
</table>
</form> 