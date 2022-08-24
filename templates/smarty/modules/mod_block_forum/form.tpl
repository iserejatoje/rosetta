<div id="ask_form_added" style="display:none;text-align:center"><br><br><br>
	Ваше сообщение будет размещено на сайте, если оно соответствует<br>
	<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
	<br><br><br><a href="javascript:ask_form_show_form();">Добавить еще отзыв</a>
	<br><a href="{$res.forum_url}theme.html?act=last&id={$res.forum_theme}">Перейти к обсуждению</a><br><br><br><br><br><br>
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
					<td class="title2_askform"><a name=addcomment></a>Выскажи свое мнение!</td>
				</tr>
				
				<tr>
					<td width="100px" align="right"><b>Автор:</b></td>
					<td width="350px" align="left" style="padding-left:2px;">
						<div id="ask_form_error_login" style="display:none;color:red;"></div>
						<input type="text" id="login" name="login" style="width:350px" value="{$res.login|escape:'html'}">
					</td>
				</tr>
				<tr valign="top">
					<td width="100px" align="right">
						<b>Cообщение:</b><br /><br />
						<img src="/_img/design/common/resize_s.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(2, 2, 'news_otziv_', 'text', null, 350, 350, 100, 1000);" alt="Уменьшить" title="Уменьшить размер поля для ввода сообщения" /><br />
						<img src="/_img/design/common/resize_b.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(1, 2, 'news_otziv_', 'text', null, 350, 350, 100, 1000);" alt="Увеличить" title="Увеличить размер поля для ввода сообщения" /><br />
					</td>
					<td width="350px" align="left" style="padding-left:2px;">
						<div id="ask_form_error_text" style="display:none;color:red;"></div>
						<textarea id="text" name="text" style="width:350px;height:150px">{$res.text|escape:'html'}</textarea>
					</td>
				</tr>
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