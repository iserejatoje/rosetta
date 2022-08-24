<style>{literal}
.smallbtn{border:1px black solid;height:18px;}
.smallbtn2{border:1px black solid;width:18px;height:18px;}
{/literal}</style>
<script type='text/javascript' src='/_scripts/modules/forum/editor.js'></script>
<div align="left">
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="_action" value="{if $action=='addtheme'}_addtheme.html{elseif $action=='addmessage'}_addmessage.html{elseif $action=='editmessage'}_updatemessage.html{/if}" />
<input type="hidden" name="parent_id" value="{$parent_id}" />
<input type="hidden" name="p" value="{$page}" />

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if !$USER->IsAuth()}
	<tr>
		<td width="170" class="fanswertitle">Пользователь:</td>
		<td>{if !empty($ERROR.username)}
			<div class="ferror">{$ERROR.username}</div>
			{/if}
			<input type="text" name="username" style="width:99%" value="{$username}">
			</td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
{/if}
{if $action=='addtheme' || ($action=='editmessage' && $is_theme)}
	<tr>
		<td width="170" class="fanswertitle">Название темы:</td>
		<td>{if !empty($ERROR.title)}
			<div class="ferror">{$ERROR.title}</div>
			{/if}
			<input type="text" name="themename" style="width:99%" value="{$themename}">
			</td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
{/if}
	<tr>
        <td width="170" valign="top" class="fanswertitle"><a name="#answer"></a>Сообщение:<br><br>
			<table width="100%" cellpadding="0" cellspacing="0">
				{foreach from=$smiles item=sr}
				<tr>
				{foreach from=$sr key=k item=v}
					<td width="33%"><img class="ftoolbutton" onClick="insertsmile('{$k}')" src="{$ImgPath}smiles/{$v}" border="0"></td>
				{/foreach}
				</tr>
				{/foreach}
			</table><a href="javascript:opensmiles();" class="fmtable_command">все смайлы</a>
		</td>
        <td valign="top">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-zh.gif" width="26" height="26" onclick="inserttag('B')" class="ftoolbutton" alt="жирный" title="жирный"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-k.gif" width="26" height="26" onclick="inserttag('I')" class="ftoolbutton" alt="курсив" title="курсив"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-ch.gif" width="26" height="26" onclick="inserttag('U')" class="ftoolbutton" alt="подчеркнутый" title="подчеркнутый"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-small.gif" width="26" height="26" onclick="inserttag('SMALL')" class="ftoolbutton" alt="маленький" title="маленький"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-left.gif" width="26" height="26" onclick="inserttag('LEFT')" class="ftoolbutton" alt="прижат к левому краю" title="прижат к левому краю"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-center.gif" width="26" height="26" onclick="inserttag('CENTER')" class="ftoolbutton" alt="по центру" title="по центру"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-right.gif" width="26" height="26" onclick="inserttag('RIGHT')" class="ftoolbutton" alt="прижат к правому краю" title="прижат к правому краю"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-just.gif" width="26" height="26" onclick="inserttag('JUSTIFY')" class="ftoolbutton" alt="выравнен по обоим краям" title="выравнен по обоим краям"></td>
					<td width="5">&nbsp;</td>
					{*<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-spis.gif" width="26" height="26" onclick="inserttag('LIST')" class="ftoolbutton" alt="список" title="список"></td>
					<td width="5">&nbsp;</td>*}
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-soap.gif" width="26" height="26" onclick="inserttag('EMAIL')" class="ftoolbutton" alt="email" title="email"></td>
					<td width="5">&nbsp;</td>
					<td background="/_img/modules/forum/buttons/but-back.gif"><img src="/_img/modules/forum/buttons/but-ssyl.gif" width="26" height="26" onclick="inserttag('URL')" class="ftoolbutton" alt="ссылка" title="ссылка"></td>
				</tr>
			</table>
			<br>
			{if !empty($ERROR.editor)}
			<div class="ferror">{$ERROR.editor}</div>
			{/if}
			<textarea name="message" id="editor" style="width:99%;height:160px" onkeydown="changerows();">{$text}</textarea>
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
{/literal}</script>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if $USER->IsAuth()}
				<tr>
					<td valign="top">
{if $action!='editmessage' && $action!='edittheme'}
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
								<td><font class=dop2>Тип файла: jpg, gif, png.</font> </td>
							</tr>
						</table>
{/if}
					</td>
					<td width="30">&nbsp;</td>
					<td valign="top">
						<table border="0" cellspacing="2" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width="25"><input type="checkbox" id="is_subscribe" name="is_subscribe" value="1"></td>
								<td class="fchecktext"><label for="is_subscribe">Подписаться на тему</label></td>
							</tr>
							<tr>
								<td><input type="checkbox" id="not_is_smile" name="not_is_smile" value="1"></td>
								<td class="fchecktext"><label for="not_is_smile">Не заменять смайлы</label></td>
							</tr>
							<tr>
								<td><input type="checkbox" id="not_is_bb" name="not_is_bb" value="1"></td>
								<td class="fchecktext"><label for="not_is_bb">Не заменять BB теги</label></td>
							</tr>
						</table>
					</td>
				</tr>
{else}
				<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				<tr>					
					<td>
					{if !empty($ERROR.antirobot)}
					<div class="ferror">{$ERROR.antirobot}</div>
					{/if}
					<img src="/_ar/pic.gif?{$ar_session_id}" align="absmiddle" width="150" height="50" alt="код" border="0">
						{$ar_session_code}<input type="text" name="antirobot" size="20"><br />Введите четырехзначное число, которое Вы видите на картинке
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
				{if $action=='addtheme' && !empty($icons)}
				<tr>
					<td valign="top">
					{foreach from=$icons item=l key=id}
						<input type="radio" name="icon" id="icon{$id}" value="{$id}"><label for="icon{$id}">&nbsp;<img src="{$ImgPath}icons/{$l.file}" alt="{$l.alt}" title="{$l.alt}"></label>
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
				
				<tr> 
					<td valign="top" class="fbreakline"><input type="submit" id="submit" value="Разместить сообщение" class="button" style="width: 150px;"></td>
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
{if !empty($ERROR)}<script>window.scrollBy(0, 1000000);</script>{/if}