<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_auto" />
<div class="title">Мои автомобили</div>

<table border="0" cellpadding="3" cellspacing="2" width="550" class="table">
<tr>
	<th class="bg_color2"></th>
	<th class="bg_color2">Марка</th>
	<th class="bg_color2">Модель</th>
	<th class="bg_color2">Год выпуска</th>
	<th class="bg_color2">Объем двигателя</th>
	<th class="bg_color2">Тип руля</th>
	{if !empty($page.opinion_link)}
	<th class="bg_color2">Отзывы</th>
	{/if}
	<th class="bg_color2">Количество пассажирских мест</th>
	<th class="bg_color2"><input type="checkbox" onclick="{literal}if (this.checked) { $('.car_ids').attr('checked','checked') } else { $('.car_ids').removeAttr('checked') }{/literal}" /></th>
</tr>

{excycle values=" ,bg_color4"}
{foreach from=$page.cars item=car}
<tr class="{excycle}">
	<td width="100">{if !empty($car.small_photo.url)}<a href="/{$ENV.section}/mypage/auto/{$car.CarID}.php"><img src="{$car.small_photo.url}" border="0" width="{$car.small_photo.w}" height="{$car.small_photo.h}" /></a>{/if}</td>
	<td align="center">{$car.MarkaName}</td>
	<td align="center"><a href="/{$ENV.section}/mypage/auto/{$car.CarID}.php">{$car.ModelName}</a></td>
	<td>{if $car.Year}{$car.Year}{/if}</td>	
	<td>{if $car.Volume}{$car.Volume}{/if}</td>
	<td>{if $car.WheelType==0}Левый{else}Правый{/if}</td>
	{if !empty($page.opinion_link)}
	<td align="center" nowrap="nowrap">
		{if $car.opinion_count>0}
			<a href="{$page.opinion_link}model/{$car.ModelID}.php" target="_blank">{$car.opinion_count}</a>
		{/if}
	</td>
	{/if}
	<td>{$car.Capacity}</td>
	<td align="center"><input type="checkbox" name="car_ids[]" class="car_ids" value="{$car.CarID}" /></td>
</tr>
{/foreach}
<tr>
	<td colspan="9" align="right" bgcolor="#ffffff">
		<a href="/{$ENV.section}/mypage/auto/add.php">Добавить еще один автомобиль</a>&nbsp;&nbsp;<input type="submit" value="Удалить" />
	</td>
</tr>
</table>
</form>

<br/><br/>

<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_auto_anketa" />
<div class="title">Моя анкета</div>

<table border="0" cellpadding="3" cellspacing="2" width="100%" class="table">
{foreach from=$CONFIG.auto_anketa item=q key=k}
<tr>
	<td class="bg_color2" align="right">{$q.question}</td>
	<td class="bg_color4">
		{foreach from=$q.answers item=a key=ak}
			<input type="{if $q.multiple}checkbox{else}radio{/if}" name="Anketa[{$k}]{if $q.multiple}[{$ak}]{/if}" id="Anketa_{$k}_{$ak}" value="{if $q.multiple}1{else}{$ak}{/if}" {if ($q.multiple && $page.Anketa[$k][$ak]) || (!$q.multiple && $page.Anketa[$k]==$ak)}checked="checked"{/if} /> <label for="Anketa_{$k}_{$ak}">{$a}</label><br/>
		{/foreach}
		{if $q.user_answer}
			<br/>
			другое: <input type="text" name="Anketa[{$k}]{if $q.multiple}[other]{/if}" style="width:400px" value="{$page.Anketa[$k].other}" />
		{/if}
	</td>
{/foreach}
</table>

<br/>
<div align="center"><input type="submit" value="Сохранить" /></div>
<br/>

</form>