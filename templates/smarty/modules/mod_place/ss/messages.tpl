{if $page.message == 'place_update'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Данные успешно сохранены!<br/>
		Изменения появятся на сайте после проверки.<br/><br/>
		<a href="/{$ENV.section}/my/list/">К списку компаний</a>
	</td>
</tr>
</table>

{elseif $page.message == 'place_created'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Компания успешно добавлена и будет размещена на сайте после проверки.<br/><br/> 
		<a href="/{$ENV.section}/my/list/">К списку компаний</a>
	</td>
</tr>
</table>

{elseif $page.message == 'place_not_found'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Запрошенная Вами компания не найдена.<br/><br/> 
		<a href="/{$ENV.section}/my/list/">К списку компаний</a>
	</td>
</tr>
</table>

{elseif $page.message == 'attention_sent'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Данные успешно отправлены.<br/><br/> 
		<a href='javascript:window.close()' class="copy">Закрыть</a>
	</td>
</tr>
</table>

{/if}
