<script type="text/javascript">{literal}

function checkForm(obj)
{
	if ( obj.code.value.length < 3 )
	{
		alert('Введите хотябы 3 символа');
		return false;
	}
	return true;
}

{/literal}</script>

<form action="/{$ENV.section}/vsearch.php" method="get" onsubmit="return checkForm(this);">
<table class="block_right" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th align="left" colspan="2"><span>Поиск поездов</span></th>
	</tr>
	<tr>
		<td width="100%">
			<input type="text" id="code" name="code" value="{if $smarty.get.code}{$smarty.get.code}{else}номер или станция{/if}" style="color:#999999; width:100%;" onclick="if (this.value=='номер или станция') this.value=''; this.style.color='#000';" />
		</td><td>
			<input type="submit" value="Поиск">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="tip" style="color:#999; font-weight:normal;" align="right">Номер поезда или название станции отправления или прибытия. Полностью или частично.</span>
		</td>
	</tr>
</table>
<br/>
</form>