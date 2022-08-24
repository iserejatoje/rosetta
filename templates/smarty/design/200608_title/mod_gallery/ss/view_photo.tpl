{if $page.errors.global}
<br/><br/><div align="center">
<font color="red"><b>{$page.errors.global}</b>
</font><br/><br/><a href="/{$ENV.section}/">На главную</a> | <a href="javascript:void(0)" onclick="window.history.go(-1)">Назад</a></div>
{else}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="center"><font class="t5gb"> Автор: <a
			href="/{$ENV.section}/list/albums/u{$page.data.uid}.html"><font
			color="#005A52" title="Смотреть альбомы {$page.data.user}">{$page.data.user}</font></a> </font></td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="center" valign="middle" width="100%">
		<table width="50%" cellpadding="0" cellspacing="15" border="0">
			<tr valign="middle">
				<td align="right" class="t7">{if $page.prev_image} <a
					href="/{$ENV.section}/view/photo/{$page.prev_image}.html"
					title="Предыдущее фото"><font color="#005A52"><b>&lt;&lt;</b></font></a>
				{/if}</td>
				<td align="center" class="t7">{if !empty($page.data.path_original)} <a
					href="{$page.data.path_original}" title="Cмотреть большую фотографию" target="_blank"> {/if} {if
				!empty($page.data.path_big)} <img src="{$page.data.path_big}"
					{$page.data.image_size} alt="Фото" border="0"/> {else} <img
					src="/_img/design/200608_title/none.jpg" alt="Нет фото"  border="0"/> {/if} {if
				!empty($page.data.path_original)} </a> {/if}</td>
				<td align="left" class="t7">{if $page.next_image} <a
					href="/{$ENV.section}/view/photo/{$page.next_image}.html"
					title="Следующее фото"><b>&gt;&gt;</b></a>
				{/if}</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="center" valign="top" width="50%">
		<table align="center" cellpadding="3" cellspacing="0" border="0">
			<tr>
				<td align="right" valign="top" width="50%"><b>Название:</b></td>
				<td align="left" width="50%"><font color="#005A52"><b>{$page.data.name}</b></font></td>
			</tr>
			{if $page.data.descr}
			<tr>
				<td align="right" valign="top"><b>Описание:</b></td>
				<td align="left">{$page.data.descr}</td>
			</tr>
			{/if}
			<tr>
				<td align="right" valign="top"><b>Дата добавления:</b></td>
				<td align="left">{"d-m-Y H:i"|date:$page.data.date_create}</td>
			</tr>
			<tr>
				<td align="right" valign="top"><b>Просмотров
				(сегодня/всего):</b></td>
				<td align="left">{$page.data.review_today} /
				{$page.data.review}</td>
			</tr>
			<tr valign="top">
				<form name="frm" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="poll" />
				<td colspan="2" align="center"><b>Средний балл: </b>{$page.data.rate}
				<b>Голосов: </b>{$page.data.votes} &nbsp;<select name="poll"
					size="1" type="select-one" style="width: 50px">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5" selected>5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select> &nbsp;<input type="submit" value="Голосовать" style="width: 100px;">
				</form>
				</td>
			</tr>
			{if $page.user.id == $page.data.uid}
			<tr>
				<td colspan="2" align="center"><a href="/{$ENV.section}/photo/edit/{$page.data.id}.html"><b>изменить</b></a>&#160;|&#160;<a href="/{$ENV.section}/photo/del/{$page.data.id}.html"><b>удалить</b></a></td>
			</tr>
			{/if}
			<tr>
				<td colspan="2"><img src="/_img/x.gif" width="1" height="10"
					border="0" alt="" /></td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
		{$page.comments}
		
		<div align="center" class="fheader_spath"><font color="red">{$page.errors.comments}</font></div><br/>
		<!-- начало - форма для отзыва -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">

				<table align="center" width="470" cellpadding="0" cellspacing="0"
					border="0">
					{if $page.error.comment}
					<tr>
						<td align="center" class="fheader_spath" style="color: red;"><b>$page.error.comment</b></td>
					</tr>
					{/if}
					<tr>
						<td>
						<table width="100%" border="0" cellspacing="5" cellpadding="0">
							<form name="news_askform" id="news_askform" method="post"
								onsubmit="return news_askform_check(this)"><input
								type="hidden" name="action" value="addotz" /> <input
								type="hidden" name="id" value="{$page.data.id}" />
							<tr>
								<td width="100px" align="right"><b>Автор:</b></td>
								<td width="350px" align="left"><input type="text"
									name="name" style="width: 350px" value="{if $page.user.id}{$page.user.login}{/if}" class="txt" /></td>
							</tr>
							<tr>
								<td width="100px" align="right"><b>E-mail:</b></td>
								<td width="350px" align="left"><input type="text"
									name="email" style="width: 350px" value="{if $page.user.email}{$page.user.email}{/if}" class="txt"></td>
							</tr>
							<tr valign="top">
								<td width="100px" align="right"><b>Cообщение:</b><br />
								<br />
								</td>
								<td width="350px" align="left"><textarea id="otziv"
									name="otziv" style="width: 350px; height: 150px" class="txt"></textarea></td>
							</tr>
							<tr>
								<td></td>
								<td align="left"><input type="submit" value="Отправить" class="txt">&nbsp;&nbsp;
								<input type="reset" value="Очистить" class="txt">&nbsp;&nbsp;</td>
							</tr>
							</form>
						</table>
						</td>
					</tr>

					<tr>
						<td height="20px"></td>
					</tr>
					<tr align="left">
						<td class="t7">Опубликованные сообщения являются частными мнениями лиц, их написавших.<br/>Редакция сайта за размещенные сообщения ответственности не несет.<br/><a href="http://rugion.ru/rules.html" target="rules" onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Правила модерирования сообщений</a></td>
					</tr>

					<tr>
						<td height="20px"></td>
					</tr>
				</table>

				</td>
			</tr>
		</table>

		<script type="text/javascript" language="javascript">
{literal}
<!--

	var news_askform_send = false;
	function news_askform_check(form)
	{
		if(news_askform_send)
			return false;
			


		if (isEmpty(form.name.value))
		{
			alert("Укажите ваше имя или nickname!");
			form.name.focus();
			return false;
		}
		
		if (!isEmpty(form.email.value) && !isEmail(form.email.value))
		{
			alert("Вы неправильно ввели E-mail!");
			form.email.focus();
			return false;
		}
		


		if (isEmpty(form.otziv.value))
		{
			alert("Вы не написали сообщение!");
			form.otziv.focus();
			return false;
		}
		
		if (form.otziv.value.length>1000)
		{
			alert("Ваше сообщение слишком большое. Максимальная длина - 1000 знаков.");
			form.otziv.focus();
			return false;
		}
		
		news_askform_send = true;
		return true;
	}
	
	function isEmail(email)
	{
		var arr1 = email.split("@");
		if (arr1.length != 2) return false;
		else if (arr1[0].length < 1) return false;
		var arr2 = arr1[1].split(".");
		if (arr2.length < 2) return false;
		else if (arr2[0].length < 1) return false;
		return true;
	}
	function isEmpty (txt)
	{
		var ch;
		if (txt == "") return true;
		for (var i=0; i<txt.length; i++){
			ch = txt.charAt(i);
			if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
		}
		return true;
	}

//    -->
{/literal}
</script> <!-- конец - форма для отзыва --></td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
{/if}