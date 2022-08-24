{if $res.canedit === true}
<style>{literal}
.smallbtn{border:1px black solid;height:18px;}
.smallbtn2{border:1px black solid;width:18px;height:18px;}
{/literal}</style>
<script type='text/javascript' src='/_scripts/modules/forum/editor_v2.js'></script>
<script type='text/javascript' src='/_scripts/themes/frameworks/jquery/texteditor/texteditor.js'></script>
<div class="ForumEditor" align="left">
<form method="POST" enctype="multipart/form-data"{if $res.action} action="{$res.action}"{/if}{if $USER->IsAuth() && ($res.type=='create_theme' || $res.type=='edit_theme')} onsubmit="{literal}if (checkMsgForm(this) == false) { return false; } else { $('input[type=\'submit\']', this).attr('disabled', true); return true; }"{/literal}{else} onsubmit="$('input[type=\'submit\']', this).attr('disabled', true); return true;"{/if}>
<input type="hidden" name="action" value="{$res.type}" />
<input type="hidden" name="parent" value="{$res.parent}" />
<input type="hidden" name="p" value="{$res.page}" />

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if !$USER->IsAuth()}
	<tr>
		<td width="170" class="fanswertitle">Пользователь:</td>
		<td>{if $UERROR->GetErrorByIndex('username') != ''}
			<div class="ferror">{$UERROR->GetErrorByIndex('username')}</div>
			{/if}
			<input type="text" name="username" style="width:99%" value="{$username}">
			</td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
{/if}
{if $res.type=='create_theme' || ($res.type=='edit_theme' && $res.data.is_theme)}
	<tr>
		<td width="170" class="fanswertitle">Название темы:</td>
		<td>{if $UERROR->GetErrorByIndex('title') != ''}
			<div class="ferror">{$UERROR->GetErrorByIndex('title')}</div>
			{/if}
			<input type="text" name="title" style="width:99%" value="{$res.theme.name|escape:'quotes'}">
			</td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
{/if}
	<tr>
        <td width="170" valign="top" class="fanswertitle"><a name="answer"></a>Сообщение:<br><br>
			<table width="100%" cellpadding="0" cellspacing="0">
				{foreach from=$res.smiles item=sr}
				<tr>
				{foreach from=$sr key=k item=v}
					<td width="33%"><img class="ftoolbutton" onClick="insertsmile('{$k}')" src="{$CONFIG.image_url}smiles/{$v}" border="0"></td>
				{/foreach}
				</tr>
				{/foreach}
			</table><a href="javascript:opensmiles();" class="fmtable_command">все смайлы</a>
		</td>
        <td valign="top">
			{*
				ПОСЛЕ ЗАПУСКА ВСЕХ СОЦИАЛОК
				ЭТИ СТИЛИ ДОЛЖНЫ УЙТИ В СТИЛЬНИКИ ФОРУМОВ СОЦИАЛКИ И
				В design/200608_title/mod_forum/styles.css
			*}
			<style>{literal}
				.ForumEditor .BBbuttons INPUT{
					float: left;
					margin: 0px 5px 5px 0px;
					width: 26px;
					height: 26px;
					background: transparent url('/_img/modules/forum/buttons/buttons.gif') no-repeat;
					cursor: pointer;
					border: 0px;
					background-color: transparent;
				}
				.ForumEditor .BBbuttons INPUT.bold {					
					background-position: 0 0;
				}
				.ForumEditor .BBbuttons INPUT.italic {
					background-position: -26px 0;
				}
				.ForumEditor .BBbuttons INPUT.underline {
					background-position: -52px 0;
				}
				.ForumEditor .BBbuttons INPUT.small {
					background-position: -78px 0;
				}
				.ForumEditor .BBbuttons INPUT.align_left {
					background-position: -182px 0;
				}
				.ForumEditor .BBbuttons INPUT.align_center {
					background-position: -234px 0;
				}
				.ForumEditor .BBbuttons INPUT.align_right {
					background-position: -208px 0;
				}
				.ForumEditor .BBbuttons INPUT.align_justify {
					background-position: -156px 0;
				}
				.ForumEditor .BBbuttons INPUT.email {
					background-position: -104px 0;
				}
				.ForumEditor .BBbuttons INPUT.list {
					background-position: -130px 0;
				}
				.ForumEditor .BBbuttons INPUT.url {
					background-position: -260px 0;
				}
				.ForumEditor .BBbuttons INPUT.media {
					background-position: -286px 0;
				}
				.ForumEditor .BBbuttons INPUT.image {
					background-position: -338px 0;
				}
				{/literal}</style>
		
			<div class="BBbuttons">				
				<input class="bold" type="button" onclick="return inserttag('B');" title="жирный"/>
				<input class="italic" type="button" onclick="return inserttag('I');" title="курсив"/>				
				<input class="underline" type="button" onclick="return inserttag('U');" title="подчеркнутый"/>				
				<input class="small" type="button" onclick="return inserttag('SMALL');" title="маленький"/>								
				<input class="align_left" type="button" onclick="return inserttag('LEFT');" title="прижат к левому краю"/>
				<input class="align_center" type="button" onclick="return inserttag('CENTER');" title="по центру"/>
				<input class="align_right" type="button" onclick="return inserttag('RIGHT');" title="прижат к правому краю"/>
				<input class="align_justify" type="button" onclick="return inserttag('JUSTIFY');" title="выравнен по обоим краям"/>
				<input class="email" type="button" onclick="return inserttag('EMAIL');" title="email"/>
				<input class="url" type="button" onclick="return inserttag('URL');" title="ссылка"/>
				<input class="media" type="button" onclick="return inserttag('MEDIA');" title="видеоролик"/>
				{*<input class="image" type="button" onclick="return inserttag('IMG');" title="картинка"/>*}
			</div><div style="clear:both"></div>
			
			{*<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-zh.gif" width="26" height="26" onclick="inserttag('B')" class="ftoolbutton" alt="жирный" title="жирный"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-k.gif" width="26" height="26" onclick="inserttag('I')" class="ftoolbutton" alt="курсив" title="курсив"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-ch.gif" width="26" height="26" onclick="inserttag('U')" class="ftoolbutton" alt="подчеркнутый" title="подчеркнутый"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-small.gif" width="26" height="26" onclick="inserttag('SMALL')" class="ftoolbutton" alt="маленький" title="маленький"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-left.gif" width="26" height="26" onclick="inserttag('LEFT')" class="ftoolbutton" alt="прижат к левому краю" title="прижат к левому краю"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-center.gif" width="26" height="26" onclick="inserttag('CENTER')" class="ftoolbutton" alt="по центру" title="по центру"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-right.gif" width="26" height="26" onclick="inserttag('RIGHT')" class="ftoolbutton" alt="прижат к правому краю" title="прижат к правому краю"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-just.gif" width="26" height="26" onclick="inserttag('JUSTIFY')" class="ftoolbutton" alt="выравнен по обоим краям" title="выравнен по обоим краям"></td>
					<td width="5">&nbsp;</td>*}
					{*<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-spis.gif" width="26" height="26" onclick="inserttag('LIST')" class="ftoolbutton" alt="список" title="список"></td>
					<td width="5">&nbsp;</td>*}{*
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-soap.gif" width="26" height="26" onclick="inserttag('EMAIL')" class="ftoolbutton" alt="email" title="email"></td>
					<td width="5">&nbsp;</td>
					<td background="{$CONFIG.image_url}/buttons/but-back.gif"><img src="{$CONFIG.image_url}/buttons/but-ssyl.gif" width="26" height="26" onclick="inserttag('URL')" class="ftoolbutton" alt="ссылка" title="ссылка"></td>
				</tr>
			</table>
			<br>*}
			{if $UERROR->GetErrorByIndex('editor') != ''}
			<div class="ferror">{$UERROR->GetErrorByIndex('editor')}</div>
			{/if}
			<textarea name="message" id="editor" style="width:99%;height:160px" onkeydown="changerows();">{$res.data.text|escape:'tags'}</textarea>
			<script>changerowsstart();</script>
<script>{literal}
var id=1;
function addfilefield()
{
	if(id<3)
	{
		id++;
		document.getElementById('img['+id+']').style.display='';
	}
}

{/literal}
</script>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if $USER->IsAuth()}
				<tr>
					<td valign="top"><br />
						<div class="fbreakline"><strong>Иллюстрация</strong></div>
{assign var=hasimgs value=false}
{foreach from=$res.data.files item=img key=k}
						<div style="width:250px; float: left;overflow:hidden">
{if $img !== null}
{assign var=hasimgs value=true}
							<div style="width:220px;height:170px;">
								{if !empty($img.file)}<a href="{$img.file}" target="_blank">{/if}{if !empty($img.thumb)}<img src="{$img.thumb}" border="0" width="{$img.t_width}" height="{$img.t_height}" alt="{$img.origin}">{/if}{if !empty($img.file)}</a><br><span class="fimagecomment">{$img.origin|truncate:30}<br>размеры: {$img.s_width}x{$img.s_height} {$img.s_size|number_format:"2":".":" "} кб</span>{/if}
								<br /><input type="checkbox" id="img_del_{$k}" name="img_del[{$img.id}]" value="1"><label for="img_del_{$k}"> удалить</label>
							</div>
							<div style="width:220px;"><input type="file" name="img_old[{$img.id}]" style="font-size:12px;"></div>
{else}
							<div style="width:220px;{if $hasimgs==true}height:170px;{/if}">
							</div>
							<div style="width:220px;"><input type="file" name="img[]" style="font-size:12px;"></div>
{/if}
						</div>
{/foreach}
						<div class="clean:both"></div>
					</td>
{*					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
{if $res.type!='edit_message' && $res.type!='edit_theme'}
						<table width="100%"  border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="fbreakline"><strong>Иллюстрация</strong></td>
							</tr>
							<tr>
								<td><span id="images">
									<input type="file" name="img[1]" id="img[1]">
									<span id="img[2]" style="display:none"><br><input type="file" name="img[2]"></span>
									<span id="img[3]" style="display:none"><br><input type="file" name="img[3]"></span>
									<input type="button" value="+" onclick="addfilefield();"></span></td>
							</tr>
							<tr>
								<td><font class="dop2">Тип файла: jpg, gif, png, с разрешением не более {$CONFIG.image_size.max_width}x{$CONFIG.image_size.max_height} пикселов и размером не более {math equation="size/1024" size=$CONFIG.image_filesize}Кб.</font> </td>
							</tr>
						</table>
{/if}
					</td>
*}
					<td width="30">&nbsp;</td>
					<td valign="top"><br /><br />
						<div><input type="checkbox" id="not_is_smile" name="not_is_smile" value="1" {if $res.not_is_smile} checked{/if}>
						<span class="fchecktext"><label for="not_is_smile">Не заменять смайлы</label></span></div>
						<div><input type="checkbox" id="not_is_bb" name="not_is_bb" value="1" {if $res.not_is_bb} checked{/if}>
						<span class="fchecktext"><label for="not_is_bb">Не заменять BB теги</label></span></div>						
					</td>
				</tr>
{/if}
{if !$USER->IsAuth() || $res.afstatus == 'captcha'}
				<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				{if $UERROR->GetErrorByIndex('captcha') != ''}
					<tr>						
						<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('captcha')}</span></td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
					</tr>
				{/if}
				<tr>
					<td>
					{if $UERROR->GetErrorByIndex('antirobot') != ''}
					<div class="ferror">{$UERROR->GetErrorByIndex('antirobot')}</div>
					{/if}
					<img src="{$res.captcha_path}" width="150" height="50" border="0" />
						<input type="text" name="captcha_code" value="" style="width:150" /><br />Введите четырехзначное число, которое Вы видите на картинке
					</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
{/if}
				<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>

{if $USER->IsAuth() && ($res.type=='create_theme' || $res.type=='edit_theme' )}
				<tr>
					<td style="padding-bottom:10px"><input type="checkbox" id="theme_type" name="theme_type" value="1"{if $res.theme.type > 0} checked{/if} onclick="togglePoll(this);">
						<span class="fchecktext"><label for="theme_type">Добавить голосование</label>
					</td>
				</tr>
				<tr{if !$res.theme.type} style="display:none"{/if} id="poll">
					<td>
						<table width="100%"  border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td class="fbreakline" colspan="3"><strong>Голосование</strong></td>
							</tr>
							<tr>
								<td colspan="3">
									<table border="0" cellspacing="2" cellpadding="0" width="100%">
									{if $res.type=='edit_theme'}									
									<tr><td colspan="2"><br/><b>Внимание!</b> При сохранении темы результаты голосования будут обнулены, если Вы не закрываете голосование.</br><br/></td></tr>
									{/if}
									<tr>
									<td>Вопрос:&nbsp;</td>
									<td width="100%"><input type="text" id="question" name="question" style="width:100%" value="{$res.theme.question}" /></td>
									</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td id="answers" valign="top">
									<b>Варианты ответов:</b>
									{if $res.type=='edit_theme' && sizeof($res.theme.answers)}
										{foreach from=$res.theme.answers item=answer name=answers}
											<div><nobr><input class="answer" name="answer[{$answers.id}]" style="margin-top:2px;width:300px" value="{$answer.answer}">{if $smarty.foreach.answers.iteration > 1}<input class="answer_button" id="answer_button{$smarty.foreach.answers.iteration}" type="button" value="-" style="width:30px">{/if}</nobr></div>
										{/foreach}
									{else}
									<div><input class="answer" name="answer[1]" style="margin-top:2px;width:300px"></div>
									<div><nobr><input class="answer" name="answer[2]" style="margin-top:2px;width:300px"><input class="answer_button" id="answer_button2" type="button" value="+" style="width:30px"></nobr></div>
									{/if}
								</td>
								<td width="30">&nbsp;</td>
								<td valign="top">
									<table border="0" cellspacing="2" cellpadding="0">
									<tr>
										<td>
											Минимальное количество ответов
										</td>
										<td>
											<select name="minvote" id="minvote" style="width:40px;" value="{if $res.type=='edit_theme'}{$res.theme.minvote}{else}1{/if}">
												{if $res.type=='edit_theme' && sizeof($res.theme.answers)}
													{foreach from=$res.theme.answers item=l name=minvote}
														{if $smarty.foreach.minvote.iteration < $smarty.foreach.minvote.total}
														<option value="{$smarty.foreach.minvote.iteration}"{if $smarty.foreach.minvote.iteration==$res.theme.minvote} selected{/if}>{$smarty.foreach.minvote.iteration}</option>
														{/if}
													{/foreach}
												{else}
												<option value="1">1</option>
												{/if}
											</select>
										</td>
									</tr>
									<tr>
										<td>
											Максимальное количество ответов
										</td>
										<td>
											<select name="maxvote" id="maxvote" style="width:40px;" value="{if $res.type=='edit_theme'}{$res.theme.maxvote}{else}1{/if}">
												{if $res.type=='edit_theme' && sizeof($res.theme.answers)}
													{foreach from=$res.theme.answers item=l name=maxvote}
														<option value="{$smarty.foreach.maxvote.iteration}"{if $smarty.foreach.maxvote.iteration==$res.theme.maxvote} selected{/if}>{$smarty.foreach.maxvote.iteration}</option>
													{/foreach}
												{else}
												<option value="1">1</option>
												<option value="2">2</option>
												{/if}
											</select>
										</td>
									</tr>
									<tr>
										<td>
											Продолжительность голосования (дней)
										</td>
										<td>
											<input type="text" name="poll_length" style="width:40px;"{if $res.type=='edit_theme'} value="{$res.theme.poll_length}"{/if}>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<span class="tip">Оставьте это поле пустым, если голосование должно быть бессрочным.</span>
										</td>									
									</tr>
									{if $res.type=='edit_theme' && sizeof($res.theme.answers)}
									<tr>
										<td colspan="2" class="fchecktext">
											<input type="checkbox" id="poll_closed" name="poll_closed" value="1"{if $res.theme.type==2} checked{/if} /> <label for="poll_closed">Голосование закрыто</label>
										</td>
									</tr>
									{/if}
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
{/if}

				{if $res.type=='create_theme' && !empty($icons)}
				<tr>
					<td valign="top">
					{foreach from=$res.icons item=l key=id}
						<input type="radio" name="icon" id="icon{$id}" value="{$id}"><label for="icon{$id}">&nbsp;<img src="{$CONFIG.image_url}icons/{$l.file}" alt="{$l.alt}" title="{$l.alt}"></label>
					{/foreach}
						<input type="radio" name="icon" id="iconno" value="0" checked="checked"><label for="iconno">&nbsp;нет иконки</label>
					</td>
					<td valign="top">&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				{/if}

				{if $USER->IsAuth()}
				{if $res.deny_favorites !== true}
				<tr>
					<td style="padding-bottom:10px"><input type="checkbox" id="is_selected" name="is_selected" value="1"{if $res.is_selected} checked{/if}>
						<span class="fchecktext"><label for="is_selected">Добавить тему в избранное</label><br />Вы сможете быстро найти тему через меню &laquo;<a href="{$CONFIG.files.get.selected.string}">избранные темы</a>&raquo; или на странице &laquo;<a href="/passport/mypage.php">моя страница</a>&raquo;.</span>
					</td>
				</tr>
				{/if}
				<tr>
					<td style="padding-bottom:10px"><input type="checkbox" id="show_type" name="show_type" value="1"{if $res.show_type} checked{/if}>
						<span class="fchecktext"><label for="show_type">Показывать только зарегистрированным пользователям</label>
					</td>
				</tr>
				{/if}
				<tr>
					<td valign="top" class="fbreakline">
						<input type="submit" id="submit" value="Разместить сообщение" class="button" style="width: 180px;">
					</td>
					<td class="fbreakline">&nbsp;</td>
					<td valign="top" class="fbreakline">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
			</table>
		</td>
    </tr>
</table>
</form>
</div>
{if $UERROR->IsError()}<script>window.scrollBy(0, 1000000);</script>{/if}
{elseif $res.canedit === -8} {*пользователь забанен*}
<div align="center" class="fmtable_nickname" style="padding:30px;padding-bottom:50px;">
Вы не можете размещать сообщения на форуме в связи с активными наказаниями.
</div>
{elseif $res.canedit === -11} {*слишком часто пишет*}
<div align="center" class="fmtable_nickname" style="padding:30px;padding-bottom:50px;">
Вы отправляете сообщения слишком часто. Подождите некоторое время и попробуйте снова.
</div>
{*else}
<div align="center" class="fmtable_nickname" style="padding:30px;padding-bottom:50px;">
Оставлять сообщения на форуме могут только зарегистрированные пользователи.<br> <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Войти в форум</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.
</div>*}
{/if}

<script>
{if $res.type=='create_theme'}
{literal}


$(document).ready(function(){
	$('.answer_button').click( addAnswer );
});

{/literal}
{elseif $res.type=='edit_theme'}
{literal}

$(document).ready(function(){
	$('.answer_button').click( 
				function()
				{
					$(this.parentNode).remove(); 
					obj = $('#minvote').get(0);
					obj.options.length--;
					obj = $('#maxvote').get(0);
					obj.options.length--;
				}
		);
	obj = $('#answer_button{/literal}{if sizeof($res.theme.answers)}{$smarty.foreach.answers.total}{else}2{/if}{literal}').get(0);
	obj.value='+';
	$(obj).unbind();
	$(obj).click( addAnswer );
});

{/literal}
{/if}
</script>
