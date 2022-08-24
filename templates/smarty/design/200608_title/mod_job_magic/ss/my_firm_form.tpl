{include file="`$TEMPLATE.sectiontitle`" rtitle="`$res.title`"}

<script language="javascript" type="text/javascript">
{literal}
<!--
function TestParam(frm)
{
	var rt = document.getElementById('com');
	if(rt != null)
	{
		if(rt.checked == true){
			return true;
		}
	}
	var rt = document.getElementById('emp');
	if(rt != null)
	{
		if(rt.checked == true){
			if(frm.fname.value == "") {
				alert("НАЗВАНИЕ КОМПАНИИ не указано");
				frm.fname.focus();
				return false;
			}
		}
	}
	return true;
}

//-->
{/literal}
</script>

		<form method="post" enctype="multipart/form-data" name="chfinfo" onSubmit="return TestParam(this)">
		<input type="hidden" name="action" value="update_my_firm"/>
		<input type="hidden" name="fid" value="{$res.firm.fid}">
		{*if $res.edit_only*}
		<input type="hidden" name="url" value="{if $smarty.post.action!=''}{$smarty.post.url|escape:"quotes"}{else}{$smarty.get.url|escape:"quotes"}{/if}">
		{*/if*}

		{if !$res.edit_only}
		<table align="center" cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
			<tr>
				<td colspan="6" align="center">
					<br/><br/>
					<b>
						{if $res.user_type == 0}
							Для начала работы выберите статус.
						{elseif $res.user_type == 2}
							Для размещения резюме, вам необходимо поменять статус пользователя.
						{elseif $res.user_type == 1}
							Для размещения вакансии, вам необходимо поменять статус пользователя.
						{/if}
					</b>
					<br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td width="50%"></td>
				<td valign="top"><input id="emp" onclick="(this.checked) ? document.getElementById('form_F').style.display = '' : document.getElementById('form_F').style.display = 'none'; "
				 onchange="(this.checked) ? document.getElementById('form_F').style.display = '' : document.getElementById('form_F').style.display = 'none'; " type="radio" name="user_type" value="2" {if $res.user_type == 2 || ($res.user_type == 0 && $smarty.get.status == 2)}checked="checked"{/if}/></td>
				<td nowrap="nowrap">
					<label for="emp">Работодатель</label><br />
					- для размещения вакансий и резюме
				</td>
				<td valign="top"><input id="com" onclick="(this.checked) ? document.getElementById('form_F').style.display = 'none' : document.getElementById('form_F').style.display = ''; "
				 onchange="(this.checked) ? document.getElementById('form_F').style.display = 'none' : document.getElementById('form_F').style.display = ''; " type="radio" name="user_type" value="1" {if $res.user_type == 1 || ($res.user_type == 0 && $smarty.get.status == 1)}checked="checked"{/if}/></td>
				<td nowrap="nowrap">
					<label for="com">Соискатель</label><br />
					- только для размещения резюме
				</td>
				<td width="50%"></td>
			</tr>
		</table>
		{/if}
		{if isset($res.err) && is_array($res.err)}
		<br/><div align="center" style="color:red;"><b>
			{foreach from=$res.err item=l key=k}
				{$l}<br />
			{/foreach}
			</b></div><br/><br/>
		{/if}

		<table id="form_F" style="display:{if !$res.edit_only && !($res.user_type == 2 || ($res.user_type == 0 && $smarty.get.status == 2))}none{/if};" align="center" cellpadding="0" cellspacing="2" border="0" width="550px" class="table2">
			<tr>
				<th colspan="2">Информация о компании</th>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%"><font color="red">*</font> Название компании</td>
				<td class="bg_color4"><input type="text" name="fname" style="width:100%" value="{$res.firm.fname|escape:"html"}"/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Форма собственности</td>
				<td class="bg_color4">
					<select name="type">
						{foreach from=$res.etypes item=v key=k}
							<option value="{$k}" {if $res.firm.type == $v}selected="selected"{/if}>{$v}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Логотип (до 150*150 пикселей)</td>
				<td class="bg_color4">
				{if !empty($res.firm.img_big.file)}<img src="{$res.firm.img_big.file}" align="left"><br/>
				<div style="float:left"><input type="checkbox" name="isdel150" value="checked"/></div>
				<div style="float:left" class="text11">удалить</div><br/><br/>
				{/if}<input style="width:200px" type="file" name="photo150" value=""/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Логотип (до 100*60 пикселей)</td>
				<td class="bg_color4">
				{if !empty($res.firm.img_small.file)}<img src="{$res.firm.img_small.file}" align="left"><br/>
				<div style="float:left"><input type="checkbox" name="isdel100" value="checked"/></div>
				<div style="float:left" class="text11">удалить</div><br/><br/>
				{/if}<input style="width:200px" type="file" name="photo100" value=""/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Город</td>
				<td class="bg_color4">
					{php} $this->_tpl_vars['selected'] = false; {/php}
					<select name="city_id" size="1" style="width:200px" onchange="{literal}if (this.value==0) {chfinfo.city.disabled = false;} else {chfinfo.city.disabled = true; chfinfo.city.value='';}{/literal}">
						{foreach from=$res.city_list item=v key=k}
								<option value="{$k}" {if $res.firm.city_id == $k || ($res.firm.city_id == -1 && $CONFIG.default_city == $k)}{php} $this->_tpl_vars['selected'] = true; {/php}selected="selected"{/if}>{$v.name}</option>
						{/foreach}
						<option value="0" {if !$selected}selected="selected"{/if}>Другой...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Другой</td>
				<td class="bg_color4"><input type="text" name="city" id="city" style="width:200px" value="{if !$selected}{$res.firm.city|escape:"html"}{/if}" {if $selected} disabled="true"{/if} /></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Адрес</td>
				<td class="bg_color4"><input type="text" name="address" style="width:100%" value="{$res.firm.address|escape:"html"}"/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Телефон</td>
				<td class="bg_color4"><input type="text" name="phone" style="width:100%" value="{$res.firm.phone|escape:"html"}"/>
				                      <span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
				</td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Факс</td>
				<td class="bg_color4"><input type="text" name="fax" style="width:100%" value="{$res.firm.fax|escape:"html"}"/>
				                      <span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
				</td>
			</tr>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">E-Mail</td>
				<td class="bg_color4"><input type="text" name="email" size="40" value="{$res.firm.email|escape:"html"}"/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">http://</td>
				<td class="bg_color4"><input type="text" name="http" style="width:100%" value="{$res.firm.http|escape:"html"}"/></td>
			</tr>
            <tr>
				<td class="bg_color2" align="right" width="30%">Ссылка с анонса (http://)</td>
				<td class="bg_color4"><input type="text" name="link" style="width:100%" value="{$res.firm.link|escape:"html"}"/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Руководитель</td>
				<td class="bg_color4"><input type="text" name="fioruk" style="width:100%" value="{$res.firm.fioruk|escape:"html"}"/></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Доп.
				сведения</td>
				<td class="bg_color4"><textarea name="dopsv" style="width:100%" rows="5">{$res.firm.dopsv|nl2br}</textarea></td>
			</tr>
		</table>
		<br/>
		
		{if $res.firm.scope}
		<table id="form_F" style="display:{if !$res.edit_only && !$res.user_type}none{/if};" align="center" cellpadding="0" cellspacing="2" border="0" width="550px" class="table2">
			<tr>
				<th colspan="2">Настройки</th>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Принимать вопросы</td>
				<td class="bg_color4"><input type="checkbox" name="isotz" value="checked" {if $res.firm.isotz > 0}checked="checked"{/if}></td>
			</tr>
			<tr>
				<td class="bg_color2" align="right" width="30%">Ручное упорядочивание</td>
				<td class="bg_color4"><input type="checkbox" name="handsorder" value="checked" {if $res.firm.HandsOrder > 0}checked="checked"{/if}></td>
			</tr>
		</table>
		{/if}
		
		<br/>
		<center><input type="submit" value="Сохранить"></center>
		</form>
		<br/><br/>
