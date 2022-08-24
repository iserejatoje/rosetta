<script language="JavaScript">
{literal}
<!--    
function TestParam(frm)
{ 
  if(frm.fname.value == "") {
    alert("НАЗВАНИЕ КОМПАНИИ не указано");
    frm.fname.focus();
    return false;
  }

  return true;
}

//-->
{/literal}
</script>

<form method="post" enctype="multipart/form-data" name="chfinfo" onSubmit="return TestParam(this)">
<input type="hidden" name="cmd" value="updfinfo"/>
<input type="hidden" name="lid" value="{$res.initcount}"/>
<input type="hidden" name="fid" value="">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="500">
	<tr>
		<td>
		<table cellpadding="4" cellspacing="1" border="0" width="100%">
			<tr>
				<td class="t1" align="center" bgcolor="#DEE7E7" colspan="2">Информация о компании</td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%"><font color="red">*</font> Название компании</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="fname" size="40" value="{$res.fname}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%"><font color="red">*</font> Форма собственности</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><select class="t7" name="type">{$res.fs}</select></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Логотип (до 150*150 пикселей)</td>
				<td class="t7" align="left" bgcolor="#F6FBFB">
				{if !empty($res.file_name150)}<img src="{$res.file_name150}">&nbsp;&nbsp;<input type="checkbox" name="isdel150" value="checked" class="in"/><font class="s1">удалить</font><br/>
				{/if}<input size="40" type="file" name="photo150" value=""/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Логотип (до 100*60 пикселей)</td>
				<td class="t7" align="left" bgcolor="#F6FBFB">
				{if !empty($res.file_name100)}<img src="{$res.file_name100}">&nbsp;&nbsp;<input	type="checkbox" name="isdel100" value="checked" class="in"/>
				<font class="s1">удалить</font><br/>
				{/if}<input size="40" type="file" name="photo100" value=""/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Город</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><select class="in" name="city" size="1">{$res.acity}<option value="0" {if $res.city!=""}selected{/if}>Другой...</option></select>
				</td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Другой</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="gorod" size="40" value="{$res.gorod}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Адрес</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="address" size="40" value="{$res.address}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Телефон</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="phone" size="40" value="{$res.phone}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Факс</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="fax" size="40" value="{$res.fax}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">e-mail</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="email" size="40" value="{$res.email}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">http://</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="http" size="40" value="{$res.http}" class="t7"/></td>
			</tr>
            <tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Ссылка с анонса (http://)</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="link" size="40" value="{$res.link}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Руководитель</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="text" name="fioruk" size="40" value="{$res.fioruk}" class="t7"/></td>
			</tr>
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Доп.
				сведения</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><textarea name="dopsv" cols="65" rows="5" class="t7">{$res.dopsv}</textarea></td>
			</tr>

			{if $res.ftype>0}
			<tr>
				<td class="t1" align="right" bgcolor="#DEE7E7" width="30%">Принимать вопросы</td>
				<td class="t7" align="left" bgcolor="#F6FBFB"><input type="checkbox" name="isotz" class="in" value="checked" {if $res.isotz>0}checked="checked"{/if}></td>
			</tr>
			{/if}

			<tr>
				<td class="t1" align="right" bgcolor="#e9efef" width="30%">Пароль</td>
				<td class="t7" align="left" bgcolor="#ffffff"><input type="password" class="s7" size="16" name="pwd" value="{$passw}"/></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<center><input type="submit" value="{$data.bname}" class="in"></center>
</form>
<br/>
<br/>
