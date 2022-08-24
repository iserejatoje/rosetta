{if $CURRENT_ENV.site.domain == 'domchel.ru' && $CURRENT_ENV.section=="renovation"}
	<div align="center" style="padding: 5px 0px">{banner_v2 id="2584"}</div>
{/if}
<div class="js-comment">
<div class="add-comment">
<a href="javascript:;" onclick="commentForm.moveForm(0);" class="title dashed-border">Скрыть форму</a>
{*<a class="title dashed-border"  id="hide_link" href="javascript:;" onclick="commentForm.moveForm(0);$('#hide_link').hide();$('#show_link').show();">Скрыть форму</a>
<a class="title dashed-border" id="show_link" href="javascript:;" onclick="commentForm.moveForm(0);$('#show_link').hide();$('#hide_link').show();" style="display: none;">Добавить комментарий</a>
*}
</div>

<div class="js-comments-form-holder-0">
	<div class="js-comments-form-holder">

		<div style="display:none;text-align:center" class="js-comments-status-holder">
			{if $res.premoderate}<br/>Ваш комментарий будет размещен на сайте, если он соответствует<br/>
				<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
			{else}
				Комментарий добавлен.
			{/if}
			<br/>
			<br/>
			<a href="javascript:;" onclick="commentForm.disableForm()">Закрыть</a>
			<br/><br/>
		</div>

		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="js-comments-field-holder">
			<tr>
				<td>
					<form method="post" style="margin:0px" class="js-comments-field-data" onsubmit="return commentForm.checkForm()">
					<input type="hidden" name="UserID" value="{$USER->ID}" class="js-comments-field-userid">
					<input type="hidden" name="ParentID" value="{$res.ParentID}" class="js-comments-field-parentid">
					<input type="hidden" name="action" value="comments_edit">
					<input type="hidden" name="UniqueID" id="UniqueID" value="{$res.UniqueID}">
					<table width="100%" border="0" cellspacing="5" cellpadding="0">
						{if $USER->IsAuth()}
						<tr>
							<td width="100px" align="right"><b>Автор:</b></td>
							<td align="left" style="padding:0px 10px 0px 2px;" nowrap="nowrap">
								<input size="40" style="display:none;" type="text" name="Name" value="" maxlength="100" class="js-comments-field-name">
								<span class="js-comments-field-name-text">{$USER->Profile.general.showname|escape:'html'}</span>
							</td>
							<td>
								<input id="guest{$res.UniqueID}" name="asGuest" class="js-comments-field-guest" type="checkbox" onclick="commentForm.Guest()" />
							</td>
							<td nowrap="nowrap" width="100%"><label for="guest{$res.UniqueID}">Ответить анонимно</label></td>
						</tr>
						{else}
						<tr>
							<td align="right"><b>Автор:</b></td>
							<td width="100%" align="left" style="padding-left:2px;">
								<input type="text" name="Name" value="" size="40" maxlength="100" class="js-comments-field-name"/>
							</td>
						</tr>
						{/if}
						<tr valign="top">
							<td align="right">
								<b>Cообщение:</b>
							</td>
							<td colspan="3"></td>
						</tr>
						<tr valign="top">
							<td colspan="4" width="100%" align="left">
								<textarea class="js-comments-field-text" name="Text" style="width:100%;" rows="6">{$res.text|escape:'html'}</textarea>
							</td>					
						</tr>
						{if !$USER->IsAuth()}
						<tr>
						    <td colspan="4" width="350px" align="left" style="padding-left:2px;"><input type="text" value="" style="width: 100px;" name="captcha_code" class="js-comments-field-captcha"/> << <img height="50" width="150" border="0" align="middle" class="js-comments-captcha-holder" src="{$res.captcha_path}"/>
								<br/>Введите четырехзначное число, которое Вы видите на картинке</td>
						</tr>
						{/if}
						<tr>
							<td colspan="4"><small>
								Опубликованные сообщения являются частными мнениями лиц, их написавших.<br/>
								Редакция сайта за размещенные сообщения ответственности не несет.<br/>
								<a href="http://rugion.ru/rules.html" target="rules" onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Правила модерирования сообщений</a>
							</small></td>
						</tr>
						<tr>
							<td colspan="4" align="left">
								<input class="js-comments-field-submit" type="submit" value="Отправить">&nbsp;&nbsp;
								<input type="reset" value="Очистить">&nbsp;&nbsp;
							</td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div></div>
<br/>
<br/>
{if $CURRENT_ENV.site.domain == 'domchel.ru' && in_array($CURRENT_ENV.section, array('lider', 'articles', 'expert', 'newscomp', 'design', 'news', 'newsline', 'renovation'))}
	<div align="center" style="padding: 5px 0px">{banner_v2 id="2354"}</div>
{/if}