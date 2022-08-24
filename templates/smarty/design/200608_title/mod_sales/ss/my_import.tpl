<script language="javascript" type="text/javascript">
{literal}
<!--
	function checkForm()
	{		
		if ( $('#StatusSelect:first').val()=='0')
		{
			alert('Вы не указали статус!');
			$('#StatusSelect:first').focus();
			return false;
		}		
		
		if ( $('#price:first').val()=='')
		{
			alert('Вы не указали файл!');
			$('#price:first').focus();
			return false;
		}
		
		return true;
	}
-->	
{/literal}
</script>
<div class="title2_news">Импорт объявлений из файла</div>
<br/>

{if isset($UERROR->ERRORS.import)}
<center><div style="color:red">{$UERROR->ERRORS.import}</div></center><br/>
{/if}

{if !empty($page.errors)}
<center>
	<div style="color:red">
		{foreach from=$page.errors item=err}
			{$err}<br/>
		{/foreach}
	</div>
</center><br/>
{/if}

<form method="POST" enctype="multipart/form-data" onsubmit="return checkForm();">
	<input type="hidden" name="action" value="import" />
	<table cellspacing="2" cellpadding="0" border="0" class="table2" align="center">
	
		<tr class="bg_color2">
			<td class="menu" align="right">Статус имущества<span style="color:red"> *</span></td>
			<td>
				<select id="StatusSelect" name="Status" style="width:400px;">
					<option value="0" selected="selected">-- укажите статус --</option>
				{foreach from=$page.form.statuslist.list item=l}
					<option value="{$l.StatusID}" {if $l.StatusID==$page.form.StatusID}selected="selected"{/if}>{$l.ShortName}</option>
				{/foreach}
				</select>
			</td>
		</tr>

		<tr class="bg_color2">
			<td class="menu" align="right">Загружаемый файл<span style="color:red"> *</span></td>
			<td>
				<input type="file" name="price" id="price" /><br/><br/>
				Формат: xls. Максимальный размер: 4 Мб.
			</td>
		</tr>

		<tr class="bg_color2">
			<td></td>
			<td align="left">
				<input type="submit" value="Сохранить" />
			</td>
		</tr>

	</table>
</form>