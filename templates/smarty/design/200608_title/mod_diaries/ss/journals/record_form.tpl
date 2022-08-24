{ if $res.converting!=1}
<br />
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr><td>
	<table cellpadding=4 cellspacing=1 border=0 width=100%>
	<form name=frmaddrecord method=POST onsubmit="return valid_frmaddrecord(this)" enctype="multipart/form-data">
<script type="text/javascript" language="javascript">
var myform = document.frmaddrecord;
</script>
	<input type=hidden name=action value="{$res.action}">
	<input type=hidden name=id value={$res.id}>
	<input type=hidden name=rid value={$res.rid}>
	<input type=hidden name=p value={$res.p}>
	<tr><td class="block_title2"><a name=addrecord></a><span>{if $res.action == 'journals_addrecord'}Добавить{else}Редактировать{/if} запись</span></td></tr>
{if count($res.err)>0}
	<tr><td align=center bgcolor=#ffffff>{include  file="`$TEMPLATE.errors`" errors_list=$res.err}</td></tr>
{/if}
	<tr><td bgcolor=#ffffff style="padding:0;spacing:0">
		<table width=100% cellpadding=4 cellspacing=0 border=0>
		<tr bgcolor=#F5F9FA align=left valign=middle><td>
{if $USER->ID == 0}
		<a><b>Гость</b></a>
{else}
		<a href='{$CONFIG.files.get.users_list.string}?id={$ENV.user.id}'><b>{$USER->NickName}</a>
{/if}
		</td></tr>
		<tr align=left><td nowrap>Заголовок:
		<INPUT class=input type=text name="name" style="width:50%" maxlength=255 value='{$res.name|escape}'>
		<small>(не обязательно)</small>
		</td></tr>
{include  file="`$TEMPLATE.vbcode`"}
{include  file="`$TEMPLATE.smiles`"}
		<tr bgcolor=#EFEFEF align=center><td>
		<TEXTAREA class=input style="width:100%" name="text" rows="10">{$res.text|escape}</TEXTAREA>
		</td></tr>
		<tr bgcolor=#FFFFFF align=left><td>
<input type=checkbox name=optnocomment{if $res.optnocomment} checked{/if}> Запретить добавление комментариев<br>
<input type=checkbox name=optnosmile{if $res.optnosmile} checked{/if}> Не преобразовывать смайлы
		</td></tr>
		<tr bgcolor=#F5F9FA align=left><td>Доступ к записи:<br>
<select class=input name=access size=1 type=select-one style="width:350">
{foreach from=$res.arr_access item=l key=k}
	<option value={$k} {if $k==$res.access}selected{/if}>{$l}</option>
{/foreach}
</select>
{*<br>Дополнительный список:<br>
<INPUT class=input type=text name="addlist" style="width:350" maxlength=255 value='{$res.addlist}'>*}
		</td></tr>
{if $res.action == 'journals_addrecord'}
	<tr bgcolor=#FFFFFF align=left><td nowrap>Прикрепить:&nbsp;<br />
{php}
for($i=1;$i<=3;$i++){
echo "<input class=input type=file name=att$i style='width:200px'><br/>";
}
{/php}
<br><small>только .jpg, .gif размером не более {$res.attach_weight} Кб</small>
		</td></tr>
{else}
<tr bgcolor=#FFFFFF align=left><td>Прикрепить:&nbsp;<br />
{foreach from=$res.att item=l key=k}
Аттач {$k}:<br />
{if $l.file!=''}
	<img src="{$l.url}" border=0><input type=hidden name=oldatt{$k} value='{$l.name}'><br />
{/if}
{if $l.file!=''}<INPUT type=checkbox name=imgcheck{$k}{if $l.imgcheck} checked{/if}> Удалить текущий аттач{/if}<br/>
<input class=input type=file name=att{$k} style="width: 200px"><br/><br/>
{/foreach}
<br><small>только .jpg, .gif размером не более {$page.list.attach_weight} Кб</small>
</td></tr>
{/if}

		<tr><td>
		<INPUT class=button name=btnsave type=submit value="{if $res.action == 'journals_addrecord'}Добавить{else}Сохранить{/if}" style="width:100">
    &nbsp;&nbsp;
    <INPUT class=button type=button onclick="btnback();" value="Назад" style="width:100">
		</td></tr>
		</table>
	</td></tr>
	</form>
	</table>
</td></tr>
</table>
<SCRIPT language="JavaScript">
{literal}
function btnback(){
location.href='{/literal}{$CONFIG.files.get.journals_record.string}?id={$smarty.get.id}&p={$smarty.get.p}{literal}';
}
function valid_frmaddrecord(frm){
  if( frm.name.value.length > 255) {
    alert("Заголовок не может превышать 255 символов!");
    frm.name.focus();
    return false;
  }
  if( frm.text.value.length == 0) {
    alert("Но Вы же ничего не написали!");
    frm.text.focus();
    return false;
  }
	frm.btnsave.disabled=true;
  return true;
}
{/literal}
</SCRIPT>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
</table>
{else}
<br/><br/><br/><br/><center><b>Раздел на модернизации</b></center>
{/if}