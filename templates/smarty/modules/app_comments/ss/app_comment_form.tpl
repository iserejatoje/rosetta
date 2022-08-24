<div id="ask_form_added" style="display:none;text-align:center"><br><br><br>
	{if $CONFIG.premoderate}Ваш комментарий будет размещен на сайте, если он соответствует<br>
	<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
	<br><br>{/if}<a href="javascript:ask_form_show_form();">Добавить еще комментарий</a>
	<br><br><br>
</div>

<table id="ask_form" align="center" width="470" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<form name="news_askform" id="news_askform" method="post" style="margin:0px">
			<input type="hidden" name="UserID" id="userid" value="{$USER->ID}">
			<input type="hidden" name="action" value="comments_edit">
			<input type="hidden" name="UniqueID" id="UniqueID" value="{$res.UniqueID}">
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td class="title2_askform"><a name="addcomment"></a>Добавить комментарий</td>
				</tr>
				{if $USER->IsAuth()}
				<tr>
					<td width="100px" align="right"><b>Автор:</b></td>
					<td width="350px" align="left" style="padding-left:2px;">
					<input type="hidden" name="Name" value="">
						<b>{$USER->Profile.general.showname|escape:'html'}</b>
					</td>
				</tr>
				{else}
				<tr>
					<td width="100px" align="right"><b>Имя:</b></td>
					<td width="350px" align="left" style="padding-left:2px;">
						<input type="text" id="name" name="Name" value="" style="width:350px;" maxlength="100"/>
					</td>
				</tr>
				<tr valign="top">
				    <td width="100px" align="right"><b>Код защиты от роботов:</b></td>
				    <td width="350px" align="left" style="padding-left:2px;"><img id="news_askform_capcha" height="50" width="150" border="0" align="middle" src="{$res.captcha_path}"/> >> <input type="text" value="" style="width: 100px;" name="captcha_code"/>
						<br/>Введите четырехзначное число, которое Вы видите на картинке</td>
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
						<textarea id="text" name="Text" style="width:350px;height:150px">{$res.text|escape:'html'}</textarea>
					</td>					
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<input id="ask_form_submit_button" type="button" onclick="news_askform_check('{$res.url}');" value="Отправить">&nbsp;&nbsp;
						<input type="reset" value="Очистить">&nbsp;&nbsp;
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
	<tr><td style="height:20px;"></td></tr>
	<tr><td class="small">Опубликованные сообщения являются частными мнениями лиц, их написавших.<br/>Редакция сайта за размещенные сообщения ответственности не несет.<br/><a href="http://rugion.ru/rules.html" target="rules" onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Правила модерирования сообщений</a></td></tr>
</table>
