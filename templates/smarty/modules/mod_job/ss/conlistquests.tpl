{include file="`$TEMPLATE.sectiontitle`" rtitle="Консультация юриста по трудовому праву"}
{if isset($res.name)}
<table cellspacing="10" cellpadding="0" class="text11">
	<tr><td colspan="2">
		{$res.resume}<br><br>
		<b>На ваши вопросы отвечает:</b>
	</td></tr>
	<tr valign="top">
	<td>{if $res.photo.file}<img src="{$res.photo.file}" width="{$res.photo.w}" height="{$res.photo.h}" vspace="5" hspace="5">{/if}</td>
	<td>
		<b>{$res.name} {$res.io}</b>,<br/> 
		{$res.employ}. <br/><br/>
	{if !$res.readonly}<a href="#question">Задать вопрос</a><br/><br/>{/if}
	</td>
	</tr>
</table>

{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="/{$CURRENT_ENV.section}/{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="/{$CURRENT_ENV.section}/{$l.link}" class="s1">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="/{$CURRENT_ENV.section}/{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}


	{if $res.qcnt>0}
	<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<tr><td bgcolor="#ffffff" class="t7">Всего вопросов: <b>{$res.qcnt}</b>.</td></tr>
	{if $smarty.capture.pageslink!="" }
	<tr><td class="s1" align="center">
		{$smarty.capture.pageslink}
	</td></tr>
	<tr><td height="5px"></td></tr>
	{/if}
	</table>
	{/if}

	{foreach from=$res.quests item=l}
	<table cellpadding="7" cellspacing="0" width="100%" class="text11"> 
	<tr align="left"> 
		<td>&nbsp;<a name="{$l.id}">{$l.c}.</a>&nbsp;<b>{if $l.email!=""}<a href="mailto:{$l.email}">{$l.name}</a>{else}{$l.name}{/if}</b>&nbsp; 
		<font class="copy">( {$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"} )</font></td>
	</tr>   	
	<tr bgcolor="#f6f6f6" align="left">
		<td>
		<b>Вопрос</b>: <br/>
		{$l.otziv}<br/>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="/_img/x.gif" widht="1" height="7"></td>
		</tr>
		<tr>
			<td bgcolor="#005A52"><img src="/_img/x.gif" widht="1" height="1"></td>
		</tr>
		<tr>
			<td><img src="/_img/x.gif" widht="1" height="7"></td>
		</tr>
		</table>
		<b>Ответ</b>: <br/>
		{$l.answer}</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" widht="1" height="10"></td>
	</tr>
	</table>
	{/foreach}

	{if $res.qcnt>0}
	<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<tr><td bgcolor="#ffffff" class="t7">Всего вопросов: <b>{$res.qcnt}</b>.</td></tr>
	{if $smarty.capture.pageslink!="" }
	<tr><td class="s1" align="center">
		{$smarty.capture.pageslink}
	</td></tr>
	<tr><td height="5px"></td></tr>
	{/if}
	</table>
	{/if}
	{if !$res.readonly}
			<script language="Javascript">
			{literal}
				    <!--
			    function check(form){
			      if (isEmpty(form.name.value)){
			        alert('Укажите ваше имя или nickname!');
			        form.name.focus();
			        return false;
			      }
			      if (isEmpty(form.email.value)){
			        alert('Укажите ваш e-mail!');
			        form.email.focus();
			        return false;
			      }
			      if (!isEmpty(form.email.value) && !isEmail(form.email.value)){
			                alert('вы неправильно указали E-mail!');
			                form.email.focus();
			                return false;
			      }
			      if (isEmpty(form.otziv.value)){
			        alert('Вы не оставили сообщение!');
			        form.otziv.focus();
			        return false;
			      }
				if(isEmpty(form.antirobot.value)) {
				    alert('Поле ЗАЩИТА ОТ РОБОТОВ должно быть заполнено.');
				    form.antirobot.focus();
				    return false;
				}

			      return true;
			    }


			    function isEmail(email){
				        var arr1 = email.split('@');
				        if (arr1.length < 2) 
			                return false;
				        if (arr1[0].length < 1) 
				                return false;
				        var arr2 = arr1[1].split('.');
				        if (arr2.length < 2) 
			                return false;
				        if (arr2[0].length < 1) 
			                return false;
				        if (arr2[1].length < 1) 
			                return false;
			        return true;
			    }

			    function isEmpty (txt){
				      var ch;
				      if (txt == '') return true;
				      for (var i=0; i<txt.length; i++){
					        ch = txt.charAt(i);
					        if (ch!=' ' && ch!='\\n' && ch!='\\t' && ch!='\\r') return false;
				      }
			      return true;
			    }
			//    -->
			{/literal}
			</script>
		<!-- начало - форма для отзыва -->
		<br/><center>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" class="menu-klass"><a name="question"></a>
				<form method="post" onSubmit="javascript: return check(this)">
				<input type="hidden" name="id" value="{$res.id}">
				<input type="hidden" name="cmd" value="conaddquest">
				<table cellSpacing="0" cellPadding="4" width="100%" align="center" border="0">
				<tr>
					<td class="text16" vAlign="top" colSpan="2" align="center">
						<a name="add"></a>
						<font class="t1">Задать вопрос</font><br>
					</td>
				</tr>
				<tr>
					<td class="menu-klass" width="150" align="right">
						<b>Автор:</b></td>
					<td class="menu-klass" align="left">
						<input class="t_in" maxLength="100" size="42" name="name"></td>
				</tr>
				<tr>
					<td class="menu-klass" width="150" align="right">
						<b>E-mail:</b></td>
					<td class="menu-klass" align="left">
						<input class="t_in" maxLength="100" size="42" name="email"></td>
				</tr>
				<tr>
					<td class="menu-klass" vAlign="top" width="150" align="right">
						<b>Вопрос:</b></td>
					<td class="menu-klass" align="left">
						<textarea class="t_in" name="otziv" rows="8" cols="40"></textarea></td>
				</tr>
				<tr>
					<td class="menu-klass" vAlign="top" width="150" align="right">
						<b>Защита от роботов:</b></td>
					<td class="menu-klass" align="left">
						<img src="/_ar/pic.gif?{$res.ar.sar_id}" align="absmiddle" width="150" height="50" alt="код" border="0"> &gt;&gt; <input type="text" name="antirobot" size="20" class="text_edit" style="width:80px;">{$res.ar.sar_code}
						</td>
				</tr>
				<tr>
					<td class="menu-klass" vAlign="top" width="100"></td>
					<td align="left" class="menu-klass">
						<input type="submit" value="Отправить" class="SubmitBut">&nbsp;&nbsp;&nbsp; <input type="reset" value="Очистить" class="SubmitBut"></td>
				</tr>
				</table></form>
			</td>
		</tr>
		</table>
		</center>
		<!-- конец - форма для отзыва -->
	{/if}
{else}
	<center><br>Нет такого эксперта</center>
{/if}