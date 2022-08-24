{if in_array($CURRENT_ENV.section,array('job','car','realty'))}
<br/><br/>
<table cellpadding="3" cellspacing="0" border="0" width="100%" class="text11">
<tr valign="top">
	<td align="right" width="40%" class="text11">Смотрите также:</td>
	<td>
{if $CURRENT_ENV.regid == 74}
	{if $CURRENT_ENV.section != 'job'}<a href="http://74.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://autochel.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://domchel.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 63}
	{if $CURRENT_ENV.section != 'job'}<a href="http://63.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://doroga63.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://dom63.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 16}
	{if $CURRENT_ENV.section != 'job'}<a href="http://116.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://116auto.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://116metrov.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 34}
	{if $CURRENT_ENV.section != 'job'}<a href="http://v1.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://34auto.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://34metra.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 61}
	{if $CURRENT_ENV.section != 'job'}<a href="http://161.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://161auto.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://161metr.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 2}
	{if $CURRENT_ENV.section != 'job'}<a href="http://ufa1.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://102km.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://102metra.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
	{if $CURRENT_ENV.section == 'job'}<a href="http://sterlitamak1.ru/job/" class="text11" style="color:red" target="_blank">работа в Стерлитамаке</a><br/>{/if}
	{if $CURRENT_ENV.section == 'car'}<a href="http://sterlitamak1.ru/car/" class="text11" style="color:red" target="_blank">автомобили в Стерлитамаке</a><br/>{/if}
	{if in_array($CURRENT_ENV.section, array('realty'))}<a href="http://sterlitamak1.ru/realty/" class="text11" style="color:red" target="_blank">недвижимость в Стерлитамаке</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 72}
	{if $CURRENT_ENV.section != 'job'}<a href="http://72.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://72avto.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://72doma.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{elseif $CURRENT_ENV.regid == 59}
	{if $CURRENT_ENV.section != 'job'}<a href="http://59.ru/job/" class="text11" style="color:red" target="_blank">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="http://avto59.ru/car/" class="text11" style="color:red" target="_blank">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="http://kvartira59.ru/realty/" class="text11" style="color:red" target="_blank">объявления по недвижимости</a><br/>{/if}
{else}
	{if $CURRENT_ENV.section != 'job'}<a href="/job/" class="text11" style="color:red">вакансии и резюме</a><br/>{/if}
	{if $CURRENT_ENV.section != 'car'}<a href="/car/" class="text11" style="color:red">автообъявления</a><br/>{/if}
	{if !in_array($CURRENT_ENV.section,array('realty'))}<a href="/realty/" class="text11" style="color:red">объявления по недвижимости</a><br/>{/if}
{/if}
	</td>
</tr>
</table>
<br/><br/>
{/if}


{if $CURRENT_ENV.section == 'job' && in_array($CURRENT_ENV.regid, array(2,16,29,34,61,64,76,78,93,174,193))}

<table width="100%" cellspacing="0" cellpadding="0" class="block_right">
<tr><th><span>Новости партнеров</span></th>
</tr>
</table>
<table width="100%" cellspacing="5" cellpadding="0">
<tr align="left">
	<td>
<!-- bof RedTram N4P -->
<div id="rtn4p_lnskrsf"><a href="http://ru.redtram.com" target="_blank">Загрузка...</a></div>
<!-- eof RedTram N4P -->

<!-- pered </body> -->
<script language="javascript" type="text/javascript" src="http://js.ru.redtram.com/n4p/u/f/ufa-trud.ru_lnskrsf.js"></script>
	</td>
</tr>
</table>

{/if}