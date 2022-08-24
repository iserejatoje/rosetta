<div id="ask_form_added" style="display:none;text-align:center"><br><br><br>
	Ваше сообщение будет размещено на сайте, если оно соответствует<br>
	<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
	<br><br><br><a href="javascript:ask_form_show_form();">Добавить еще отзыв</a>
{if !preg_match('@^http://rugion.ru/@', $res.forum_url)}
	<br><a href="{$res.forum_url}theme.php?act=last&id={$res.forum_theme}">Перейти к обсуждению</a><br><br><br><br><br><br>
{/if}

</div>
<table id="ask_form" align="center" width="470" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<form name="news_askform" id="news_askform" method="post" style="margin:0px">
			<input type="hidden" id="theme" value="{$res.forum_theme}" />
			<input type="hidden" id="scid" value="{$res.section_id}" />
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td class="title2_askform"><a name=addcomment></a>
Выскажи свое мнение!
					</td>
				</tr>
				
				{if $USER->IsAuth()}
				<tr>
					<td width="100px" align="right"><b>Автор:</b></td>
					<td width="350px" align="left" style="padding-left:2px;">
						<div id="ask_form_error_login" style="display:none;color:red;"></div>
						<input type="hidden" name="login" id="login" value="{$USER->Profile.general.showname}">
						<b>{$USER->Profile.general.showname|escape:'html'}</b>
					</td>
				</tr>
				{else}
				<tr>
					<td width="100px" align="right">&nbsp;</td>
					<td width="350px" align="left" style="padding-left:2px;">
						Если вы не хотите, чтобы под вашим именем писал кто-то другой, то <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">зарегистрируйтесь</a>.<br>
						Если вы уже зарегистрированы, то просто <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>.
					</td>
				</tr>
				<tr>
					<td width="100px" align="right"><b>Автор:</b></td>
					<td width="350px" align="left" style="padding-left:2px;">
						<div id="ask_form_error_login" style="display:none;color:red;"></div>
						<input type="text" id="login" name="login" style="width:350px" value="{$res.login|escape:'html'}">
					</td>
				</tr>
				{/if}				
				<tr valign="top">
					<td width="100px" align="right">
						<b>Cообщение:</b><br /><br />
						<img src="/_img/modules/block_forum/resize_s.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(2, 2, 'news_otziv_', 'text', null, 350, 350, 100, 1000);" alt="Уменьшить" title="Уменьшить размер поля для ввода сообщения" /><br />
						<img src="/_img/modules/block_forum/resize_b.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(1, 2, 'news_otziv_', 'text', null, 350, 350, 100, 1000);" alt="Увеличить" title="Увеличить размер поля для ввода сообщения" /><br />
					</td>
					<td width="350px" align="left" style="padding-left:2px;">
						<div id="ask_form_error_text" style="display:none;color:red;"></div>
						<textarea id="text" name="text" style="width:350px;height:150px">{$res.text|escape:'html'}</textarea>
					</td>					
				</tr>
				{if $USER->IsAuth() && !preg_match('@^http://rugion.ru/@', $res.forum_url)}
				<tr>
					<td></td>
					<td>
						<input type="checkbox" id="is_selected" name="is_selected" value="1">
                              	                <label for="is_selected">Добавить в избранное</label><br /><font style="font-size: 11px; font-color: #666666;">Вы сможете быстро найти тему через меню &laquo;<a href="{$res.forum_url}selected.php">избранные темы</a>&raquo; или на странице &laquo;<a href="/passport/mypage.php">моя страница</a>&raquo;.</font>
					</td>
				</tr>
				{/if}
				<tr>
					<td></td>
					<td align="left">
						<input id="ask_form_submit_button" type="button" value="Отправить" onclick="news_askform_check();">&nbsp;&nbsp;
						<input type="reset" value="Очистить">&nbsp;&nbsp;
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
	<tr><td height="20px"></td></tr>
	<tr><td class="smalltext">Опубликованные сообщения являются частными мнениями лиц, их написавших.<br/>Редакция сайта за размещенные сообщения ответственности не несет.<br/><a href="http://rugion.ru/rules.html" target="rules" onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Правила размещения сообщений</a></td></tr>
	<tr><td height="20px"></td></tr>
</table>
