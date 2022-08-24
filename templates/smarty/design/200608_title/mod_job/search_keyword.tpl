{*if $CURRENT_ENV.regid == '74'}
<div align="center" style="padding:5px 5px 8px 5px">
<noindex><a href="http://www.u-b-s.ru/busines/sale/resultat/" target="_blank" style="color:red">Тренинг &laquo;Технологии достижения успеха <nobr>в продажах</nobr> <nobr>на рынке В2В</nobr> <nobr>в условиях</nobr> <nobr>конкурентной среды&raquo;</nobr><br /><nobr>тел. 245-07-07,</nobr> <nobr>245-03-03</nobr></a></noindex>
</div>
{/if*}
{if !$page.form}
<form method="get" action="/{$ENV.section}/search_keyword.php" name="search_keyword" enctype="application/x-www-form-urlencoded">
<table class="bg_color2" width="100%" cellpadding="5" style="margin-bottom: 20px;">
	<tr>
		<td>
		<b>Поиск</b>
		</td>
	<td>
		<select name="what" style="width: 100px;">
			<option value="vacancy">Работы</option>
			<option value="resume">Персонала</option>
		</select>
	</td>
	<td width="100%">
		<input type="text" name="keyword" onclick="this.value=''" style="width: 100%;" value="Укажите ключевые слова"/>
	</td>
	<td>
		<input type="submit" value="Искать"/>
	</td>
	</tr>
</table>
</form>
{/if}