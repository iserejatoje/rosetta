<form style="margin:0px" method="POST" enctype="multipart/form-data" id="im_form" action="/passport/im/ajax_new.php" style="width:550px">
<input type="hidden" id="im_form_to" name="to" value="{$res.to}" />
<input type="hidden" id="im_form_itype" name="itype" value="" />
<input type="hidden" id="im_form_ititle" name="ititle" value="" />
<input type="hidden" id="im_form_iurl" name="iurl" value="" />
<input type="hidden" name="action" value="im_ajax_new" />
<table width="550" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td class="nyroModalTitle bg_color1">
			<div style="float:right">
				<img class="nyroModalClose" style="cursor:pointer;cursor:hand;padding-top:2px;" src="/_img/modules/passport/im/close.gif " />
			</div>
			<div align="left">Написать сообщение</div>
		</td>
	</tr>
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
							<div align="left" style="position:relative;font-weight:bold">{$res.UserInfo->Profile.general.ShowName}</div>
							{if $res.showvisited}
							<div align="left" style="position:relative;" class="pmtable_date">{$res.showvisited|user_online:"%f %H:%M":"%d %F":$res.UserInfo->Profile.general.gender}</div>
							{/if}
							{*<div style="position:relative;" class="dop">{if empty($res.message)}{$res.UserInfo->Profile.general.About}{else}&nbsp;{/if}</div>*}
							<div align="left" style="position:relative;padding-top:4px;">{if !empty($res.Type)}<b>{$res.DType}{if !empty($res.RefererTitle)}:{/if}</b>{/if} {if !empty($res.RefererTitle)}{if !empty($res.RefererUrl)}<a href="{$res.RefererUrl}">{/if}{$res.RefererTitle|with_href}{if !empty($res.RefererUrl)}</a>{/if}{/if}</div>
						</div>
						{if !empty($res.message)}
						<div align="left" class="dop" id="im_message_text" style="clear:both;overflow-y:auto">{$res.message.Text|nl2br|with_href}</div>
						{/if}
					</td>
				</tr>
				<tr>
					<td width="118">&nbsp;</td>
					<td>
						{*
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div style="position:absolute;display:none;" id="im_form_smiles">
										<div style="position:relative;width:400px;height:180px;background-color:white;overflow:auto;padding-top:10px;border-left:2px solid #F0F0F0;border-top:2px solid #F0F0F0;border-bottom:2px solid #D0D0D0;border-right:2px solid #D0D0D0">
											{foreach from=$res.smiles.smiles item=l key=k}
												<div style="float:left;" class="pimsmile">
													<img src="{$res.smiles.path}{$l}" alt="{$k}" title="{$k}" onclick="mod_passport_im_loader.insertsmile('{$k}');">
												</div>
											{/foreach}
											<div style="clear:both"></div>
										</div>
									</div>
									<img src="/_img/modules/passport/im/btn/b-smile.gif" width="16" height="16" onclick="mod_passport_im_loader.showsmiles(true)" class="pimbtn" alt="смайлы" title="смайлы"></td>
								<td width="5">&nbsp;</td>
								
								<td><img src="/_img/modules/passport/im/btn/b-bold.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('B')" class="pimbtn" alt="жирный" title="жирный"></td>
								<td width="5">&nbsp;</td>

								<td><img src="/_img/modules/passport/im/btn/b-italic.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('I')" class="pimbtn" alt="курсив" title="курсив"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-underlina.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('U')" class="pimbtn" alt="подчеркнутый" title="подчеркнутый"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-small.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('SMALL')" class="pimbtn" alt="маленький" title="маленький"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-left.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('LEFT')" class="pimbtn" alt="прижат к левому краю" title="прижат к левому краю"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-center.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('CENTER')" class="pimbtn" alt="по центру" title="по центру"></td>

								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-right.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('RIGHT')" class="pimbtn" alt="прижат к правому краю" title="прижат к правому краю"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-just.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('JUSTIFY')" class="pimbtn" alt="выравнен по обоим краям" title="выравнен по обоим краям"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-mail.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('EMAIL')" class="pimbtn" alt="email" title="email"></td>
								<td width="5">&nbsp;</td>
								<td><img src="/_img/modules/passport/im/btn/b-link.gif" width="16" height="16" onclick="mod_passport_im_loader.inserttag('URL')" class="pimbtn" alt="ссылка" title="ссылка"></td>
							</tr>
						</table>
						*}
						<div style="position:absolute;display:none;" id="im_form_smiles">
							<div style="position:relative;width:400px;height:180px;background-color:white;overflow:auto;padding-top:10px;border-left:2px solid #F0F0F0;border-top:2px solid #F0F0F0;border-bottom:2px solid #D0D0D0;border-right:2px solid #D0D0D0">
								{foreach from=$res.smiles.smiles item=l key=k}
									<div style="float:left;" class="pimsmile">
										<img src="{$res.smiles.path}{$l}" alt="{$k}" title="{$k}" onclick="mod_passport_im_loader.insertsmile('{$k}');">
									</div>
								{/foreach}
								<div style="clear:both"></div>
							</div>
						</div>
						<div class="BBbuttons">
							<div class="smile" onclick="mod_passport_im_loader.showsmiles(true);" title="смайлы"></div>
							<div class="bold" onclick="mod_passport_im_loader.inserttag('B');" title="жирный"></div>
							<div class="italic" onclick="mod_passport_im_loader.inserttag('I');" title="курсив"></div>
							<div class="underline" onclick="mod_passport_im_loader.inserttag('U');" title="подчеркнутый"></div>
							<div class="small" onclick="mod_passport_im_loader.inserttag('SMALL');" title="маленький"></div>
							<div class="align_left" onclick="mod_passport_im_loader.inserttag('LEFT');" title="прижат к левому краю"></div>
							<div class="align_center" onclick="mod_passport_im_loader.inserttag('CENTER');" title="по центру"></div>
							<div class="align_right" onclick="mod_passport_im_loader.inserttag('RIGHT');" title="прижат к правому краю"></div>
							<div class="align_justify" onclick="mod_passport_im_loader.inserttag('JUSTIFY');" title="выравнен по обоим краям"></div>
							<div class="email" onclick="mod_passport_im_loader.inserttag('EMAIL');" title="email"></div>
							<div class="url" onclick="mod_passport_im_loader.inserttag('URL');" title="ссылка"></div>
							<div class="media" onclick="mod_passport_im_loader.inserttag('MEDIA');" title="видеоролик"></div>
						</div><div style="clear:both"></div>						
					</td>
				</tr>
				<tr>
					<td width="118" valign="top" align="left"><strong>Сообщение</strong><br></td>
					<td width="100%" align="left"><textarea 
						id="im_form_text" 
						name="text"
						style="width:100%; font-size:12px; height:120px"
						onkeypress="if (event.keyCode==10 || ((event.metaKey || event.ctrlKey) && event.keyCode==13)) $('#im_form').submit()"></textarea>
<div class="tip" style="color:red">
Внимание! Не станьте жертвой мошенников, которые снимают деньги с сотовых телефонов.<br/>
Сайт не несет ответственность за содержание сообщений!
</div>
						</td>
				</tr>
				<tr>
					<td width="118">&nbsp;</td>
					<td>
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top">
									<input type="file" name="file" />
								</td>
								<td valign="top" width="100%" class="tip" style="padding-left:10px;">Вы можете прикрепить документы (Word, Excel), картинки, архивы и другие файлы размером не более 1,5 Мб.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="118" valign="top" align="left">&nbsp;</td>
					<td align="left"><input type="submit" id="imSendButton" class="nyroModalSend" value="Отправить" />
						<input type="button" class="nyroModalClose" value="Закрыть" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>