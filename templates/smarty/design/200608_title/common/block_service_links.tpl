<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/baraholka/" target="_blank" class="a12"><font color=red>Барахолка</font></a> <span style="font-family: Tahoma; font-size: 85%; margin-left: 3px; color: red; font-weight: bold;">NEW</span></div>
{if $CURRENT_ENV.regid == 74}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://chelyabinsk.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Челябинска</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 63}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://63.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Самары</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://63.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Самара в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 59}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://59.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Перми</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://59.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Пермь в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 72}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://72.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Тюмени</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://72.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Тюмень в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 16}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://116.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Казани</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://116.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Казань в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 2}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://ufa1.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Уфы</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://ufa1.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Уфа в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 34}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://v1.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Волгограда</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://v1.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Волгоград в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{elseif $CURRENT_ENV.regid == 61}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://161.ru/guide/"|escape:"url"}" target="_blank" class="a12"><b>Гостям Ростова</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/service/go/?url={"http://161.ru/photos/"|escape:"url"}" target="_blank" class="a12"><b>Ростов в фотографиях</b></a></div>
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{else}
	<div style="margin: 5px 3px 2px 4px;" class="desc"><a href="/schedule/" target="_blank" class="a12"><b>Расписание поездов</b></a></div>
{/if}