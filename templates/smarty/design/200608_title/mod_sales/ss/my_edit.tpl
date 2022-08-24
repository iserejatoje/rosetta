<script language="javascript" type="text/javascript">
{literal}
<!--
	function checkForm()
	{
		if ( $('#RubricSelect:first').val()=='0')
		{
			alert('Вы не указали рубрику!');
			$('#RubricSelect:first').focus();
			return false;
		}
		
		if ( $('#StatusSelect:first').val()=='0')
		{
			alert('Вы не указали статус!');
			$('#StatusSelect:first').focus();
			return false;
		}		
		
		if ( $('#ObjectName:first').val()=='')
		{
			alert('Вы не указали наименование!');
			$('#ObjectName:first').focus();
			return false;
		}
		
		if ( $('#ObjectDescription:first').val()=='')
		{
			alert('Вы не указали характеристики!');
			$('#ObjectDescription:first').focus();
			return false;
		}

		if ( $('#Price:first').val()!='')
		{
			var re = /^(\s+)?\d+(\,\d\d)?(\s+)?$/;
			if (!re.test($('#Price:first').val())){
				alert('Вы не верно заполнили поле "Цена". Формат данных должен быть таким: #####,##');
				$('#Price:first').focus();
				return false;
			}
		}
		
		return true;
	}
-->	
{/literal}
</script>

{if $page.form.action=='add'}
<div class="title2_news">Добавить объявление</div>
{else}
<div class="title2_news">Редактировать объявление</div>
{/if}
<br/>

<form method="POST" onsubmit="return checkForm();">
<input type="hidden" name="action" value="{$page.form.action}" />
<table cellspacing="2" cellpadding="0" border="0" class="table2" align="center">
{if $page.form.action=='add'}
<tr class="bg_color2">
	<td class="menu" align="right">Компания<span style="color:red">*</span></td>
	<td>
		<select  name="FirmID" style="width:400px;">		
		{foreach from=$page.form.firms item=l}
			<option value="{$l.FirmID}" {if $l.FirmID==$page.form.FirmID}selected="selected"{/if}>{$l.Name}</option>
		{/foreach}
		</select>
	</td>
</tr>
{/if}
<tr class="bg_color2">
	<td class="menu" align="right">Рубрика<span style="color:red">*</span></td>
	<td>
		<select id="RubricSelect" name="Rubric" style="width:400px;">
		{if $page.form.action=='add'}
			<option value="0">-- укажите рубрику --</option>
		{/if}
		{foreach from=$page.form.rubrics.list item=l}
			<option value="{$l.RubricID}" {if $l.RubricID==$page.form.RubricID}selected="selected"{/if}>{$l.Name}</option>
		{/foreach}
		</select>
	</td>
</tr>

{if isset($UERROR->ERRORS.status)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td class="error"><span>{$UERROR->ERRORS.status}</span></td>
</tr>
{/if}
<tr class="bg_color2">
	<td class="menu" align="right">Статус имущества<span style="color:red">*</span></td>
	<td>
		<select id="StatusSelect" name="Status" style="width:400px;">
		{if $page.form.action=='add'}
			<option value="0">-- укажите статус --</option>
		{/if}
		{foreach from=$page.form.statuslist.list item=l}
			<option value="{$l.StatusID}" {if $l.StatusID==$page.form.StatusID}selected="selected"{/if}>{$l.ShortName}</option>
		{/foreach}
		</select>
	</td>
</tr>

{if isset($UERROR->ERRORS.rubric)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td class="error"><span>{$UERROR->ERRORS.rubric}</span></td>
</tr>
{/if}
<tr class="bg_color2">
	<td class="menu" align="right">Наименование объекта<span style="color:red">*</span></td>
	<td><input type="text" id="ObjectName" name="Name" style="width:400px;" value="{$page.form.Name|escape:'html'}" /></td>
</tr>

<tr class="bg_color2">
	<td class="menu" align="right">Цена, руб.</td>
	<td><input type="text" id="Price" name="Price" style="width:400px;" value="{$page.form.Price|escape:'html'}" /></td>
</tr>

{if isset($UERROR->ERRORS.name)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td class="error"><span>{$UERROR->ERRORS.name}</span></td>
</tr>
{/if}
<tr class="bg_color2">
	<td class="menu" valign="top" align="right">Характеристики объекта<span style="color:red">*</span></td>
	<td><textarea id="ObjectDescription" name="Description" style="width:400px;height:200px;">{$page.form.Description|escape:"html"}</textarea></td>
</tr>

<tr class="bg_color2">
<td/>
{if $page.form.action=='add'}
	<td><input type="checkbox" name="add_gallery" value="1" /> Добавить фотогалерею</td>
{else}
	<td style="padding:5px"><a href="/{$ENV.section}/my/gallery/{$page.form.ObjectID}.php">Редактировать фотогалерею</a></td>
{/if}
</tr>

{if isset($UERROR->ERRORS.desc)}
<tr class="bg_color2">
	<td>&nbsp;</td>
	<td class="error"><span>{$UERROR->ERRORS.desc}</span></td>
</tr>
{/if}

<tr class="bg_color2">
	<td colspan="2" align="center">
		<input type="submit" value="Сохранить" />
	</td>
</tr>
</table>
</form>